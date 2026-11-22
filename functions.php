<?php
/**
 * Perellion theme functions.
 *
 * Structure of this theme:
 *   theme.json       Design tokens. Colour, type, spacing, shadows. Single source of truth.
 *   style.css        Figma token aliases, base styles, utility classes.
 *   /inc             Content types and fields.
 *   /patterns        Reusable section layouts the editor can insert.
 *   /parts           Header and footer template parts.
 *   /templates       Page and archive templates.
 *   /assets          Fonts, images, vectors.
 *
 * @package Perellion
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERELLION_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'PERELLION_DIR', get_stylesheet_directory() );
define( 'PERELLION_URI', get_stylesheet_directory_uri() );

/**
 * Load the parent and child stylesheets.
 */
function perellion_enqueue_styles(): void {
	wp_enqueue_style(
		'perellion',
		PERELLION_URI . '/style.css',
		array(),
		PERELLION_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'perellion_enqueue_styles', 20 );

/**
 * Load the token aliases in the block editor too, so what the client sees
 * while editing matches what visitors see.
 */
function perellion_editor_styles(): void {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'perellion_editor_styles' );

/**
 * Theme supports.
 */
function perellion_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// Image sizes used by the card grids and hero treatments.
	add_image_size( 'perellion-card', 720, 480, true );
	add_image_size( 'perellion-portrait', 640, 800, true );
	add_image_size( 'perellion-hero', 2400, 1200, true );
}
add_action( 'after_setup_theme', 'perellion_setup' );

/**
 * Register the pattern categories the section patterns are filed under.
 * Keeps the inserter organised for whoever is editing.
 */
function perellion_pattern_categories(): void {
	$categories = array(
		'perellion-hero'       => __( 'Perellion: heroes', 'perellion' ),
		'perellion-capability' => __( 'Perellion: capability', 'perellion' ),
		'perellion-proof'      => __( 'Perellion: proof and testimonials', 'perellion' ),
		'perellion-cta'        => __( 'Perellion: calls to action', 'perellion' ),
		'perellion-content'    => __( 'Perellion: content sections', 'perellion' ),
	);

	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', 'perellion_pattern_categories' );

/**
 * Content types.
 *
 * Replaces the previous site's use of blog categories for case studies,
 * team bios and job postings.
 */
require_once PERELLION_DIR . '/inc/post-types.php';
require_once PERELLION_DIR . '/inc/redirects.php';
require_once PERELLION_DIR . '/inc/components.php';
require_once PERELLION_DIR . '/inc/cta.php';

/**
 * Dev-only deploy endpoint (REMOVE BEFORE LAUNCH).
 * The file returns early on any host other than perelliondev.wpengine.com,
 * so this line is inert on production. See inc/dev-deploy.php.
 */
require_once PERELLION_DIR . '/inc/dev-deploy.php';

/**
 * Restrict the editor to the theme's own palette and sizes.
 * Stops the site drifting off-brand through ordinary content edits.
 */
function perellion_editor_restrictions(): void {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'perellion_editor_restrictions' );

/**
 * Add a slug-based class to <body> so page-specific rules can be written
 * once, in the stylesheet, instead of being applied by hand per page.
 *
 * The six industry pages all reuse the same section ids (#overview, #help,
 * #risk and so on), so before this there was no way to say "the decoration
 * in Defense's risk section sits at the top, but Aerospace's sits right."
 * That is why those corrections kept arriving one page at a time: each one
 * could only be fixed where it was seen, never stated as a rule.
 *
 * Deliberately keyed on the slug, not on page-id. Ids differ between dev
 * and production -- Medical Technology is already live under a different
 * one -- so a page-id rule would silently stop matching on launch.
 */
function perellion_body_class( array $classes ): array {
	if ( is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && $post->post_name ) {
			$classes[] = 'perellion-page--' . sanitize_html_class( $post->post_name );
		}
	}
	return $classes;
}
add_filter( 'body_class', 'perellion_body_class' );

/**
 * Front-end motion script. Included-tier scroll behavior only.
 */
function perellion_enqueue_motion() {
	wp_enqueue_script(
		'perellion-motion',
		get_stylesheet_directory_uri() . '/assets/js/motion.js',
		array(),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'perellion_enqueue_motion' );

/**
 * Query loop adjustments for the content types.
 *
 *  - queryId 7  (team profile, "You might also like to meet"): leave the
 *    current person out and shuffle, so the strip changes per profile.
 *  - queryId 31 (Insights): one grid across all three content types, which
 *    the Query block cannot express on its own.
 */
add_filter( 'query_loop_block_query_vars', function ( $query, $block ) {
	$id = isset( $block->context['queryId'] ) ? (int) $block->context['queryId'] : 0;
	if ( 7 === $id ) {
		$current = get_queried_object_id();
		if ( $current ) {
			$query['post__not_in'] = array( $current );
		}
		$query['orderby'] = 'rand';
	}
	if ( 31 === $id ) {
		$query['post_type'] = array( 'team_member', 'case_study', 'job_posting' );
		$query['orderby']   = 'date';
		$query['order']     = 'DESC';
	}
	return $query;
}, 10, 2 );

/**
 * Team profile subline: the tenure string production kept as the post
 * excerpt ("... with Perellion since 2022"), stored by the migration in
 * post meta. Fills the empty paragraph the single-team_member template
 * reserves for it; the paragraph stays empty (and hidden) when there is none.
 */
add_filter( 'render_block_core/paragraph', 'perellion_profile_tenure', 10, 2 );
function perellion_profile_tenure( $content, $block ) {
	if ( empty( $block['attrs']['className'] ) || false === strpos( $block['attrs']['className'], 'perellion-profile__tenure' ) ) {
		return $content;
	}
	$tenure = get_post_meta( get_the_ID(), 'perellion_tenure', true );
	if ( ! $tenure ) {
		return $content;
	}
	return str_replace( '></p>', '>' . esc_html( $tenure ) . '</p>', $content );
}
