<?php
/**
 * Get in touch section, shared by every page but drawn differently per
 * frame: the industry pages carry the CONTACT eyebrow, defense@perellion.com
 * and the white card over the portrait's right edge; the core pages (home,
 * What we do, Industries hub, Insights) drop the eyebrow, use
 * info@perellion.com, put the address on its own line in action blue and
 * draw the testimonial as a bare card to the left of the portrait. Each
 * frame also carries its own testimonial and portrait.
 *
 * Patterns call perellion_cta_markup() with the frame's values; the
 * perellion/cta-contact pattern keeps the industry defaults.
 */
function perellion_cta_markup( array $a = array() ): string {
	$d = array(
		'eyebrow'  => true,
		'email'    => 'defense@perellion.com',
		'quote'    => 'This team has some of the best resumes around for automated aircraft assembly.',
		'source'   => 'CTO at a well-known company',
		'portrait' => array( 868, 515 ),
		'alt'      => 'Perellion engineer in the shop',
		'card'     => 'over',      // 'over' = white card on the photo's right edge; 'beside' = bare card left of it
		'address_line' => false,   // true = Address on its own line in action blue (core pages)
	);
	$a = array_merge( $d, $a );
	$t = get_stylesheet_directory_uri();
	$src = '';
	foreach ( (array) $a['portrait'] as $id ) {
		$src = wp_get_attachment_image_url( $id, 'large' );
		if ( $src ) { break; }
	}
	if ( ! $src ) { $src = $t . '/assets/img/placeholder-feature.svg'; }
	$eyebrow = $a['eyebrow'] ? "<!-- wp:paragraph {\"className\":\"perellion-overline perellion-eyebrow\"} -->\n<p class=\"perellion-overline perellion-eyebrow\">Contact</p>\n<!-- /wp:paragraph -->\n" : '';
	$email = esc_html( $a['email'] );
	$address = $a['address_line']
		? '<br>\n    <b>Address</b> <a href="https://maps.google.com/?q=6700+Hardeson+Rd+%23104+Everett+WA+98203" rel="noopener">6700 Hardeson Rd #104<br>Everett, WA 98203</a>'
		: '\n    <b>Address</b> 6700 Hardeson Rd #104 Everett, WA 98203';
	$address = str_replace( '\n', "\n", $address );
	$alt    = esc_attr( $a['alt'] );
	$panel  = 'perellion-panel--portrait';   /* every Get in touch frame: 345 x 471 portrait */
	$card   = perellion_quote( $a['quote'], $a['source'], 'beside' === $a['card'] ? 'left' : 'right' );
	return <<<HTML
<!-- wp:group {"tagName":"section","align":"full","anchor":"contact","className":"perellion-reveal perellion-split perellion-cta","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="contact" class="wp-block-group alignfull perellion-reveal perellion-split perellion-cta" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
{$eyebrow}<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Get in touch</h2>
<!-- /wp:heading -->
<!-- wp:html -->
<div class="perellion-contact">
  <p class="perellion-contact__intro">Have a problem that needs solving? Or just want more information? Let&rsquo;s discuss it.</p>
  <p class="perellion-contact__lines">
    <b>Phone</b> <a href="tel:+14253683368">+1 (425) 368-3368</a><br>
    <b>Email</b> <a href="mailto:{$email}">{$email}</a>{$address}
  </p>
</div>
<!-- /wp:html -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|40"},"blockGap":{"left":"var:preset|spacing|16"}}},"layout":{"type":"flex","justifyContent":"left"}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--40)">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"},"spacing":{"padding":{"top":"var:preset|spacing|16","bottom":"var:preset|spacing|16","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}}} -->
<div class="wp-block-button"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px;padding-top:var(--wp--preset--spacing--16);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--16);padding-left:var(--wp--preset--spacing--40)" href="/contact/">Send message</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel {$panel} perellion-panel--b perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel {$panel} perellion-panel--b perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="{$src}" alt="{$alt}"/></figure>
<!-- /wp:image -->
{$card}
</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
HTML;
}
