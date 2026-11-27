<?php
/**
 * The two body components every page is built from, written once.
 *
 * Figma: "Body Component" = Visual (720 x 700) + Content (720 x 700).
 * The Visual holds one "Perellion/Feature media" (circle, rect, portrait
 * or wide) and, optionally, one "Perellion/Testimonial Left | Right".
 * Positions and sizes live in style.css under "Testimonial card and
 * photo panel"; the markup here only names the shape and the side.
 *
 * Patterns call:
 *   perellion_quote( 'Quote text', 'Who said it', 'left' )
 *   perellion_panel( 'round', array( 857, 515 ), 'alt text', 'a', perellion_quote( ... ) )
 */

/**
 * Testimonial card.
 *
 * @param string $quote  The quote, plain text.
 * @param string $source Attribution; <br> allowed.
 * @param string $side   'right' (over the photo's right edge) or 'left' (beside its left edge).
 * @param bool   $bare   true = no white fill (About, Join the team).
 */
function perellion_quote( string $quote, string $source, string $side = 'right', bool $bare = false ): string {
	$t     = get_stylesheet_directory_uri();
	$class = 'perellion-quote';
	if ( 'left' === $side ) { $class .= ' perellion-quote--left'; }
	if ( $bare ) { $class .= ' perellion-quote--bare'; }
	$q = esc_html( $quote );
	$s = wp_kses( $source, array( 'br' => array() ) );
	return <<<HTML
<!-- wp:html -->
<figure class="{$class}" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="{$t}/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>{$q}</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">{$s}</figcaption>
</figure>
<!-- /wp:html -->
HTML;
}

/**
 * Photo panel (the Visual half).
 *
 * @param string       $shape  'round' | 'rect' | 'portrait' | 'wide'.
 * @param int|array    $media  Attachment id, or ids in order of preference.
 * @param string       $alt    Image alt text.
 * @param string       $art    Decoration set: 'a' | 'b' | 'c' | '' (per-section artwork is mapped in CSS by section id).
 * @param string       $inner  Extra markup inside the panel (a perellion_quote()).
 * @param string       $extra  Extra classes on the panel (e.g. 'perellion-split__media').
 * @param string       $size   Image size slug.
 */
function perellion_panel( string $shape, $media, string $alt, string $art = 'a', string $inner = '', string $extra = 'perellion-split__media', string $size = 'full' ): string {
	$src = '';
	foreach ( (array) $media as $id ) {
		if ( is_int( $id ) || ctype_digit( (string) $id ) ) {
			$src = wp_get_attachment_image_url( (int) $id, $size );
		} elseif ( is_string( $id ) && '' !== $id ) {
			$src = $id; // a theme asset path
		}
		if ( $src ) { break; }
	}
	if ( ! $src ) { $src = get_stylesheet_directory_uri() . '/assets/img/placeholder-feature.svg'; }
	$class = trim( "{$extra} perellion-panel perellion-panel--{$shape}" . ( $art ? " perellion-panel--{$art}" : '' ) . ' perellion-parallax' );
	$alt   = esc_attr( $alt );
	$src   = esc_url( $src );
	return <<<HTML
<!-- wp:group {"className":"{$class}","layout":{"type":"constrained"}} -->
<div class="wp-block-group {$class}">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"{$size}"} -->
<figure class="wp-block-image perellion-panel__media"><img src="{$src}" alt="{$alt}"/></figure>
<!-- /wp:image -->
{$inner}
</div>
<!-- /wp:group -->
HTML;
}

/**
 * About › Meet the team: a "See more" button under the cards, linking to the
 * full team list. Shown at tablet width only (style.css, 1.44.8), where the
 * cards sit in a 2 × 2 grid with no way to reach the rest of the team
 * (Round 1, Haley's About 1:1). Added at render time so the About page
 * content does not need editing.
 */
add_filter( 'render_block_core/group', function ( $content, $block ) {
	if ( ! is_string( $content ) || ! is_page( 'about' ) ) {
		return $content;
	}
	if ( false === strpos( $content, 'id="team"' ) || 0 !== strpos( ltrim( $content ), '<section' ) || false !== strpos( $content, 'perellion-teamband__more' ) ) {
		return $content;
	}
	$pos = strrpos( $content, '</section>' );
	if ( false === $pos ) {
		return $content;
	}
	$more = '<nav class="perellion-more perellion-teamband__more" aria-label="Meet the team"><a class="wp-block-query-pagination-next" href="/meet-the-team/">See more</a></nav>';
	return substr( $content, 0, $pos ) . $more . substr( $content, $pos );
}, 10, 2 );
