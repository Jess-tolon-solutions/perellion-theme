<?php
/**
 * Dev-only deploy endpoint.
 *
 * Lets an already-authenticated administrator write theme files over the
 * REST API, so a change can go from the developer's workspace to the dev
 * site without a zip upload through wp-admin. Nothing here grants access
 * that an administrator does not already have (Appearance > Themes >
 * Upload does the same writes); it only removes the manual step.
 *
 * Guardrails, in the order they are checked:
 *   1. Loads only when the request host is the dev environment. On any
 *      other host, including production, the file registers nothing.
 *   2. Route requires a logged-in user with install_themes (administrator)
 *      and a valid REST nonce. Cookie auth without a nonce is refused by
 *      WordPress itself.
 *   3. Every path is normalized and must resolve inside this theme's
 *      directory. No "..", no absolute paths, no symlink escape.
 *   4. Only text and image/font/script asset extensions are accepted.
 *   5. Writes are atomic (temp file then rename) and each one is logged
 *      with user, time, path, size and SHA-256 to an admin-only option.
 *   6. A GET manifest route lists the theme's current files and hashes,
 *      so a deploy can be verified without a second upload.
 *
 * Remove this file and its require line before launch. It is listed in
 * the handover checklist.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERELLION_DEV_DEPLOY_HOST', 'perelliondev.wpengine.com' );

if ( empty( $_SERVER['HTTP_HOST'] ) || strtolower( $_SERVER['HTTP_HOST'] ) !== PERELLION_DEV_DEPLOY_HOST ) {
	return;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'perellion/v1', '/deploy', array(
		'methods'             => 'POST',
		'callback'            => 'perellion_dev_deploy',
		'permission_callback' => 'perellion_dev_deploy_can',
	) );
	register_rest_route( 'perellion/v1', '/deploy/manifest', array(
		'methods'             => 'GET',
		'callback'            => 'perellion_dev_deploy_manifest',
		'permission_callback' => 'perellion_dev_deploy_can',
	) );
	register_rest_route( 'perellion/v1', '/migrate', array(
		'methods'             => 'POST',
		'callback'            => 'perellion_dev_migrate',
		'permission_callback' => 'perellion_dev_deploy_can',
	) );
	register_rest_route( 'perellion/v1', '/deploy/log', array(
		'methods'             => 'GET',
		'callback'            => 'perellion_dev_deploy_log',
		'permission_callback' => 'perellion_dev_deploy_can',
	) );
} );

function perellion_dev_deploy_can() {
	return is_user_logged_in() && current_user_can( 'install_themes' );
}

function perellion_dev_deploy_allowed_ext() {
	return array( 'php', 'css', 'js', 'json', 'html', 'txt', 'md', 'svg', 'png', 'jpg', 'jpeg', 'webp', 'gif', 'woff', 'woff2', 'ttf', 'mp4', 'webm' );
}

/**
 * Resolve a relative path to an absolute path inside the theme, or return
 * null if it tries to leave.
 */
function perellion_dev_deploy_resolve( $rel ) {
	$rel = str_replace( '\\', '/', (string) $rel );
	if ( $rel === '' || $rel[0] === '/' || strpos( $rel, "\0" ) !== false ) {
		return null;
	}
	$parts = array();
	foreach ( explode( '/', $rel ) as $p ) {
		if ( $p === '' || $p === '.' ) {
			continue;
		}
		if ( $p === '..' ) {
			return null;
		}
		$parts[] = $p;
	}
	if ( ! $parts ) {
		return null;
	}
	$ext = strtolower( pathinfo( end( $parts ), PATHINFO_EXTENSION ) );
	if ( ! in_array( $ext, perellion_dev_deploy_allowed_ext(), true ) ) {
		return null;
	}
	$root = realpath( get_stylesheet_directory() );
	$abs  = $root . '/' . implode( '/', $parts );
	// The parent directory must exist or be creatable inside the root.
	$dir = dirname( $abs );
	if ( ! is_dir( $dir ) ) {
		wp_mkdir_p( $dir );
	}
	$real_dir = realpath( $dir );
	if ( ! $real_dir || strpos( $real_dir . '/', $root . '/' ) !== 0 ) {
		return null;
	}
	return $abs;
}

/**
 * The log lives in the options table, not in a file: uploads/ is web
 * readable on WP Engine, and the log should be visible to administrators
 * only. Capped at the last 400 lines.
 */
function perellion_dev_deploy_append_log( $line ) {
	$lines   = (array) get_option( 'perellion_dev_deploy_log', array() );
	$lines[] = $line;
	if ( count( $lines ) > 400 ) {
		$lines = array_slice( $lines, -400 );
	}
	update_option( 'perellion_dev_deploy_log', $lines, false );
	// Remove the file an earlier build wrote to uploads/, if present.
	$up  = wp_upload_dir();
	$old = trailingslashit( $up['basedir'] ) . 'perellion-deploy.log';
	if ( is_file( $old ) ) {
		@unlink( $old );
	}
}

/**
 * POST body (JSON):
 *   { "files": { "relative/path.ext": "<base64>", ... },
 *     "delete": [ "relative/path.ext", ... ],      optional
 *     "dry_run": true|false,                        optional
 *     "note": "free text for the log" }             optional
 */
function perellion_dev_deploy( WP_REST_Request $req ) {
	$body    = $req->get_json_params();
	$files   = isset( $body['files'] ) && is_array( $body['files'] ) ? $body['files'] : array();
	$delete  = isset( $body['delete'] ) && is_array( $body['delete'] ) ? $body['delete'] : array();
	$dry     = ! empty( $body['dry_run'] );
	$note    = isset( $body['note'] ) ? sanitize_text_field( $body['note'] ) : '';
	$user    = wp_get_current_user();
	$stamp   = gmdate( 'Y-m-d\TH:i:s\Z' );
	$written = array();
	$removed = array();
	$errors  = array();

	foreach ( $files as $rel => $b64 ) {
		$abs = perellion_dev_deploy_resolve( $rel );
		if ( ! $abs ) {
			$errors[] = array( 'path' => $rel, 'error' => 'path refused' );
			continue;
		}
		$data = base64_decode( (string) $b64, true );
		if ( $data === false ) {
			$errors[] = array( 'path' => $rel, 'error' => 'bad base64' );
			continue;
		}
		// "gz": true means every file value is base64 of a gzip stream.
		if ( ! empty( $body['gz'] ) ) {
			$data = @gzdecode( $data );
			if ( $data === false ) {
				$errors[] = array( 'path' => $rel, 'error' => 'bad gzip' );
				continue;
			}
		}
		$sha = hash( 'sha256', $data );
		if ( $dry ) {
			$written[] = array( 'path' => $rel, 'bytes' => strlen( $data ), 'sha256' => $sha, 'dry_run' => true );
			continue;
		}
		$tmp = $abs . '.deploy-tmp';
		if ( file_put_contents( $tmp, $data, LOCK_EX ) === false || ! rename( $tmp, $abs ) ) {
			@unlink( $tmp );
			$errors[] = array( 'path' => $rel, 'error' => 'write failed' );
			continue;
		}
		if ( function_exists( 'opcache_invalidate' ) && substr( $abs, -4 ) === '.php' ) {
			@opcache_invalidate( $abs, true );
		}
		$written[] = array( 'path' => $rel, 'bytes' => strlen( $data ), 'sha256' => $sha );
	}

	/*
	 * Patches: exact-string replacements inside an existing file, so a small
	 * change to a large file (style.css) does not need the whole file sent.
	 * Each find string must occur exactly once; otherwise the patch is
	 * refused and the file is left untouched. The response carries the
	 * resulting SHA-256 so the caller can compare it with its local copy.
	 *   "patches": { "relative/path.ext": [ { "find": "...", "replace": "..." } ] }
	 */
	$patches = isset( $body['patches'] ) && is_array( $body['patches'] ) ? $body['patches'] : array();
	foreach ( $patches as $rel => $ops ) {
		$abs = perellion_dev_deploy_resolve( $rel );
		if ( ! $abs || ! is_file( $abs ) ) {
			$errors[] = array( 'path' => $rel, 'error' => 'patch target refused or missing' );
			continue;
		}
		$data = file_get_contents( $abs );
		$bad  = false;
		foreach ( (array) $ops as $i => $op ) {
			$find = isset( $op['find'] ) ? (string) $op['find'] : '';
			$n    = $find === '' ? 0 : substr_count( $data, $find );
			if ( $n !== 1 ) {
				$errors[] = array( 'path' => $rel, 'error' => 'patch ' . $i . ' matched ' . $n . ' times' );
				$bad = true;
				break;
			}
			$data = str_replace( $find, (string) $op['replace'], $data );
		}
		if ( $bad ) {
			continue;
		}
		$sha = hash( 'sha256', $data );
		if ( $dry ) {
			$written[] = array( 'path' => $rel, 'bytes' => strlen( $data ), 'sha256' => $sha, 'dry_run' => true, 'patched' => true );
			continue;
		}
		$tmp = $abs . '.deploy-tmp';
		if ( file_put_contents( $tmp, $data, LOCK_EX ) === false || ! rename( $tmp, $abs ) ) {
			@unlink( $tmp );
			$errors[] = array( 'path' => $rel, 'error' => 'write failed' );
			continue;
		}
		if ( function_exists( 'opcache_invalidate' ) && substr( $abs, -4 ) === '.php' ) {
			@opcache_invalidate( $abs, true );
		}
		$written[] = array( 'path' => $rel, 'bytes' => strlen( $data ), 'sha256' => $sha, 'patched' => true );
	}

	/*
	 * Sideload: copy an image from the production site (only) into the dev
	 * media library, server side, so photos that already exist on
	 * perellion.com do not have to pass through a browser upload.
	 *   "sideload": [ { "url": "https://www.perellion.com/...", "title": "...", "alt": "..." } ]
	 */
	$sideload = isset( $body['sideload'] ) && is_array( $body['sideload'] ) ? $body['sideload'] : array();
	$imported = array();
	if ( $sideload && ! $dry ) {
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
		foreach ( $sideload as $item ) {
			$url = isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '';
			if ( ! preg_match( '#^https://(www\.)?perellion\.com/#', $url ) ) {
				$errors[] = array( 'path' => $url, 'error' => 'sideload only from perellion.com' );
				continue;
			}
			$title = isset( $item['title'] ) ? sanitize_text_field( $item['title'] ) : '';
			$id    = media_sideload_image( $url, 0, $title, 'id' );
			if ( is_wp_error( $id ) ) {
				$errors[] = array( 'path' => $url, 'error' => $id->get_error_message() );
				continue;
			}
			if ( ! empty( $item['alt'] ) ) {
				update_post_meta( $id, '_wp_attachment_image_alt', sanitize_text_field( $item['alt'] ) );
			}
			$imported[] = array( 'url' => $url, 'id' => $id, 'src' => wp_get_attachment_url( $id ) );
		}
	}

	/*
	 * Pull: fetch the theme from its GitHub repository at a given ref and
	 * write every file into the theme directory, so a deploy is "git push,
	 * then pull on dev" with no payload passing through a browser.
	 *   "pull": { "ref": "main" | "<commit sha>" }
	 * Only the project's own repository is accepted.
	 */
	$pulled = array();
	if ( ! empty( $body['pull']['ref'] ) && ! $dry ) {
		$ref = preg_replace( '/[^A-Za-z0-9._\/-]/', '', (string) $body['pull']['ref'] );
		$zip_url = 'https://codeload.github.com/Jess-tolon-solutions/perellion-theme/zip/' . $ref;
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$tmpzip  = wp_tempnam( 'perellion-pull.zip' );
		$res     = wp_remote_get( $zip_url, array( 'timeout' => 60, 'stream' => true, 'filename' => $tmpzip ) );
		if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) {
			$errors[] = array( 'path' => $zip_url, 'error' => is_wp_error( $res ) ? $res->get_error_message() : 'HTTP ' . wp_remote_retrieve_response_code( $res ) );
		} else {
			$za = new ZipArchive();
			if ( true !== $za->open( $tmpzip ) ) {
				$errors[] = array( 'path' => $zip_url, 'error' => 'zip open failed' );
			} else {
				$root = realpath( get_stylesheet_directory() );
				for ( $i = 0; $i < $za->numFiles; $i++ ) {
					$name = $za->getNameIndex( $i );
					if ( substr( $name, -1 ) === '/' ) { continue; }
					$parts = explode( '/', $name, 2 );          // strip "perellion-theme-<ref>/"
					if ( count( $parts ) < 2 ) { continue; }
					$rel = $parts[1];
					if ( strpos( $rel, '.git' ) === 0 || strpos( $rel, 'node_modules/' ) === 0 ) { continue; }
					$abs = perellion_dev_deploy_resolve( $rel );
					if ( ! $abs ) { continue; }
					$data = $za->getFromIndex( $i );
					if ( $data === false ) { continue; }
					$sha = hash( 'sha256', $data );
					if ( is_file( $abs ) && hash_file( 'sha256', $abs ) === $sha ) { continue; }
					$tmp = $abs . '.deploy-tmp';
					if ( file_put_contents( $tmp, $data, LOCK_EX ) === false || ! rename( $tmp, $abs ) ) {
						@unlink( $tmp );
						$errors[] = array( 'path' => $rel, 'error' => 'write failed' );
						continue;
					}
					if ( function_exists( 'opcache_invalidate' ) && substr( $abs, -4 ) === '.php' ) {
						@opcache_invalidate( $abs, true );
					}
					$pulled[] = array( 'path' => $rel, 'bytes' => strlen( $data ), 'sha256' => $sha );
				}
				$za->close();
			}
		}
		@unlink( $tmpzip );
		$written = array_merge( $written, $pulled );
	}

	foreach ( $delete as $rel ) {
		$abs = perellion_dev_deploy_resolve( $rel );
		if ( ! $abs || ! is_file( $abs ) ) {
			$errors[] = array( 'path' => $rel, 'error' => 'delete refused or missing' );
			continue;
		}
		if ( ! $dry ) {
			@unlink( $abs );
		}
		$removed[] = $rel;
	}

	if ( ! $dry ) {
		// Clear the caches WP Engine layers on top, so the next request sees the files.
		if ( function_exists( 'wp_cache_flush' ) ) {
			wp_cache_flush();
		}
		if ( class_exists( 'WpeCommon' ) ) {
			if ( method_exists( 'WpeCommon', 'purge_memcached' ) ) {
				WpeCommon::purge_memcached();
			}
			if ( method_exists( 'WpeCommon', 'purge_varnish_cache' ) ) {
				WpeCommon::purge_varnish_cache();
			}
		}
		$summary = array();
		foreach ( $written as $w ) {
			$summary[] = $w['path'] . ' ' . $w['bytes'] . 'B ' . substr( $w['sha256'], 0, 12 );
		}
		foreach ( $removed as $r ) {
			$summary[] = 'DELETE ' . $r;
		}
		if ( ! empty( $body['pull']['ref'] ) ) {
			$summary[] = 'PULL ' . $body['pull']['ref'] . ' (' . count( $pulled ) . ' files changed)';
		}
		foreach ( $imported as $im ) {
			$summary[] = 'SIDELOAD ' . basename( $im['url'] ) . ' -> ' . $im['id'];
		}
		perellion_dev_deploy_append_log( $stamp . ' ' . $user->user_login . ' ' . ( $note ? '[' . $note . '] ' : '' ) . implode( '; ', $summary ) );
	}

	return array(
		'ok'      => empty( $errors ),
		'dry_run' => $dry,
		'written' => $written,
		'deleted' => $removed,
		'imported' => isset( $imported ) ? $imported : array(),
		'errors'  => $errors,
		'version' => wp_get_theme()->get( 'Version' ),
	);
}

function perellion_dev_deploy_manifest() {
	$root  = realpath( get_stylesheet_directory() );
	$out   = array();
	$iter  = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS ) );
	foreach ( $iter as $file ) {
		$rel = substr( $file->getPathname(), strlen( $root ) + 1 );
		$out[ str_replace( '\\', '/', $rel ) ] = array( 'bytes' => $file->getSize(), 'sha256' => hash_file( 'sha256', $file->getPathname() ) );
	}
	ksort( $out );
	return array( 'version' => wp_get_theme()->get( 'Version' ), 'files' => $out );
}

function perellion_dev_deploy_log() {
	return array( 'log' => implode( "\n", (array) get_option( 'perellion_dev_deploy_log', array() ) ) );
}

/**
 * Content migration from production (dev only).
 *
 * Reads posts from the production site's public REST API and recreates
 * them on dev as the matching custom post type, with the featured image
 * sideloaded and the production id kept in meta so a re-run updates
 * rather than duplicates. Slugs are preserved, which with the CPT rewrite
 * slugs keeps every /meet-the-team/<name>/ style URL identical.
 *
 * POST { "category": 16, "post_type": "team_member", "dry_run": false, "limit": 100 }
 */
function perellion_dev_migrate( WP_REST_Request $req ) {
	$body      = $req->get_json_params();
	$category  = isset( $body['category'] ) ? (int) $body['category'] : 0;
	$post_type = isset( $body['post_type'] ) ? sanitize_key( $body['post_type'] ) : '';
	$dry       = ! empty( $body['dry_run'] );
	$limit     = isset( $body['limit'] ) ? max( 1, min( 100, (int) $body['limit'] ) ) : 100;
	if ( ! $category || ! post_type_exists( $post_type ) ) {
		return new WP_Error( 'bad_request', 'category and a registered post_type are required', array( 'status' => 400 ) );
	}
	$src = 'https://www.perellion.com/wp-json/wp/v2/posts?categories=' . $category . '&per_page=' . $limit . '&orderby=date&order=desc&_fields=id,slug,title,excerpt,content,featured_media,date_gmt,modified_gmt,link';
	$res = wp_remote_get( $src, array( 'timeout' => 30 ) );
	if ( is_wp_error( $res ) ) {
		return new WP_Error( 'fetch_failed', $res->get_error_message(), array( 'status' => 502 ) );
	}
	$posts = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( ! is_array( $posts ) ) {
		return new WP_Error( 'bad_source', 'production returned no post list', array( 'status' => 502 ) );
	}
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';
	$out = array();
	$order = 0;
	foreach ( $posts as $p ) {
		$order++; // production lists newest first (its category archive order), so menu_order 1 = newest
		$prod_id = (int) $p['id'];
		$slug    = sanitize_title( $p['slug'] );
		$title   = wp_strip_all_tags( $p['title']['rendered'] );
		$excerpt = trim( wp_strip_all_tags( $p['excerpt']['rendered'] ) );
		$html    = $p['content']['rendered'];
		// Team bios on production open with a bare role line ("President &
		// Co-founder") as their first paragraph, then the professional and
		// personal paragraphs. The frame shows the role beside the name and
		// on the card, so the role moves to the excerpt and the original
		// tenure string ("... with Perellion since 2022") is kept in meta
		// until Sovo decides where, if anywhere, it is shown.
		$tenure = '';
		if ( 'team_member' === $post_type ) {
			// Production's excerpt is the full role ("President & Co-founder",
			// "Mechanical Engineer with Perellion since August 2024"); the
			// frame's profile title uses the role and its FPO subline fits the
			// tenure, so the excerpt is split on "with Perellion since".
			if ( preg_match( '#^(.*?)\s+with Perellion since\s+(.+)$#i', $excerpt, $t ) ) {
				$excerpt = trim( $t[1] );
				$tenure  = 'With Perellion since ' . trim( $t[2] );
			}
			// The bare role line production opens each bio with is dropped
			// from the body; the title row carries it.
			if ( preg_match( '#^\s*<p>(.*?)</p>#s', $html, $m ) ) {
				$role = trim( wp_strip_all_tags( $m[1] ) );
				if ( $role !== '' && strlen( $role ) < 90 && strpos( $role, '. ' ) === false ) {
					$html = substr( $html, strlen( $m[0] ) );
				}
			}
		}
		// Paragraphs to paragraph blocks; anything else stays as a classic HTML block.
		$content = perellion_dev_html_to_blocks( $html );
		$existing = get_posts( array( 'post_type' => $post_type, 'meta_key' => '_perellion_prod_id', 'meta_value' => $prod_id, 'post_status' => 'any', 'numberposts' => 1, 'fields' => 'ids' ) );
		$row = array( 'prod_id' => $prod_id, 'slug' => $slug, 'title' => $title, 'action' => $existing ? 'update' : 'create' );
		if ( $dry ) {
			$out[] = $row;
			continue;
		}
		$args = array(
			'post_type'    => $post_type,
			'post_status'  => 'publish',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_excerpt' => $excerpt,
			'post_content' => $content,
			'post_date_gmt' => $p['date_gmt'],
			'post_date'    => get_date_from_gmt( $p['date_gmt'] ),
			'menu_order'   => $order,
		);
		if ( $existing ) {
			$args['ID'] = $existing[0];
			$id = wp_update_post( wp_slash( $args ), true );
		} else {
			$id = wp_insert_post( wp_slash( $args ), true );
		}
		if ( is_wp_error( $id ) ) {
			$row['error'] = $id->get_error_message();
			$out[] = $row;
			continue;
		}
		update_post_meta( $id, '_perellion_prod_id', $prod_id );
		update_post_meta( $id, '_perellion_prod_link', esc_url_raw( $p['link'] ) );
		if ( 'team_member' === $post_type ) {
			update_post_meta( $id, 'perellion_tenure', $tenure );
		}
		$row['id'] = $id;
		// Featured image: fetch the media record for its source URL, sideload once.
		if ( ! empty( $p['featured_media'] ) && ! has_post_thumbnail( $id ) ) {
			$m = wp_remote_get( 'https://www.perellion.com/wp-json/wp/v2/media/' . (int) $p['featured_media'] . '?_fields=source_url,alt_text,title', array( 'timeout' => 30 ) );
			$mj = is_wp_error( $m ) ? null : json_decode( wp_remote_retrieve_body( $m ), true );
			if ( ! empty( $mj['source_url'] ) ) {
				$att = media_sideload_image( $mj['source_url'], $id, $title, 'id' );
				if ( ! is_wp_error( $att ) ) {
					set_post_thumbnail( $id, $att );
					if ( ! empty( $mj['alt_text'] ) ) {
						update_post_meta( $att, '_wp_attachment_image_alt', sanitize_text_field( $mj['alt_text'] ) );
					}
					$row['thumb'] = $att;
				} else {
					$row['thumb_error'] = $att->get_error_message();
				}
			}
		}
		$out[] = $row;
	}
	if ( ! $dry ) {
		perellion_dev_deploy_append_log( gmdate( 'Y-m-d\TH:i:s\Z' ) . ' ' . wp_get_current_user()->user_login . ' [migrate ' . $post_type . ' cat ' . $category . '] ' . count( $out ) . ' posts' );
	}
	return array( 'ok' => true, 'dry_run' => $dry, 'count' => count( $out ), 'items' => $out );
}

/**
 * Turn a classic-editor HTML body into block markup: each top-level <p>,
 * <h2>-<h4>, <ul>/<ol> becomes its core block; anything else is wrapped
 * in a single core/html block so nothing is lost.
 */
function perellion_dev_html_to_blocks( $html ) {
	$html = trim( $html );
	if ( $html === '' ) {
		return '';
	}
	$dom = new DOMDocument();
	libxml_use_internal_errors( true );
	$dom->loadHTML( '<?xml encoding="utf-8" ?><div id="root">' . $html . '</div>' );
	libxml_clear_errors();
	$root = $dom->getElementById( 'root' );
	$blocks = array();
	foreach ( $root->childNodes as $node ) {
		if ( $node->nodeType === XML_TEXT_NODE ) {
			$t = trim( $node->textContent );
			if ( $t !== '' ) {
				$blocks[] = "<!-- wp:paragraph -->\n<p>" . esc_html( $t ) . "</p>\n<!-- /wp:paragraph -->";
			}
			continue;
		}
		if ( $node->nodeType !== XML_ELEMENT_NODE ) {
			continue;
		}
		$inner = '';
		foreach ( $node->childNodes as $c ) {
			$inner .= $dom->saveHTML( $c );
		}
		$inner = trim( $inner );
		$tag = strtolower( $node->nodeName );
		if ( $tag === 'p' ) {
			if ( $inner === '' || $inner === '&nbsp;' ) { continue; }
			$blocks[] = "<!-- wp:paragraph -->\n<p>" . $inner . "</p>\n<!-- /wp:paragraph -->";
		} elseif ( in_array( $tag, array( 'h2', 'h3', 'h4' ), true ) ) {
			$lvl = (int) substr( $tag, 1 );
			$blocks[] = '<!-- wp:heading {"level":' . $lvl . "} -->\n<" . $tag . ' class="wp-block-heading">' . $inner . '</' . $tag . ">\n<!-- /wp:heading -->";
		} elseif ( $tag === 'ul' || $tag === 'ol' ) {
			$items = '';
			foreach ( $node->getElementsByTagName( 'li' ) as $li ) {
				$li_inner = '';
				foreach ( $li->childNodes as $c ) { $li_inner .= $dom->saveHTML( $c ); }
				$items .= "<!-- wp:list-item -->\n<li>" . trim( $li_inner ) . "</li>\n<!-- /wp:list-item -->\n";
			}
			$attr = $tag === 'ol' ? ' {"ordered":true}' : '';
			$blocks[] = '<!-- wp:list' . $attr . " -->\n<" . $tag . ">\n" . $items . '</' . $tag . ">\n<!-- /wp:list -->";
		} else {
			$blocks[] = "<!-- wp:html -->\n" . $dom->saveHTML( $node ) . "\n<!-- /wp:html -->";
		}
	}
	return implode( "\n\n", $blocks );
}
