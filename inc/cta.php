<?php
/**
 * Get in touch section, shared by every page.
 *
 * ONE PLACE FOR THE CONTACT DETAILS: perellion_contact_details() below holds
 * the phone number, the email addresses and the mailing address. Every Get in
 * touch block on the site (pages, industry pages, team profiles, job posts,
 * case studies, the archives and the Contact page) is filled from it when the
 * page is rendered, including blocks already saved inside page content. To
 * change the address or phone number, change it here and nowhere else.
 *
 * Layout still differs per frame (eyebrow, testimonial, portrait); patterns
 * call perellion_cta_markup() with the frame's values.
 */
function perellion_contact_details(): array {
	return array(
		'phone_label'   => '+1 (425) 368-3368',
		'phone_href'    => 'tel:+14253683368',
		'email'         => 'info@perellion.com',
		/* Pages (by slug) that show a different address from the default. */
		'email_by_page' => array( 'defense' => 'defense@perellion.com' ),
		'address_1'     => '6700 Hardeson Rd #104',
		'address_2'     => 'Everett, WA 98203',
		'map_href'      => 'https://maps.google.com/?q=6700+Hardeson+Rd+%23104+Everett+WA+98203',
	);
}

/** Email for the page being viewed. */
function perellion_contact_email(): string {
	$d = perellion_contact_details();
	if ( did_action( 'wp' ) && is_page() ) {
		$post = get_queried_object();
		if ( $post instanceof WP_Post && isset( $d['email_by_page'][ $post->post_name ] ) ) {
			return $d['email_by_page'][ $post->post_name ];
		}
	}
	return $d['email'];
}

/**
 * The Phone / Email / Address lines. $one_line keeps the address on a single
 * line (the centered Contact page); otherwise it breaks after the street.
 */
function perellion_contact_lines( bool $one_line = false ): string {
	$d     = perellion_contact_details();
	$email = esc_html( perellion_contact_email() );
	$join  = $one_line ? ', ' : '<br>';
	return "\n    <b>Phone</b> <a href=\"" . esc_url( $d['phone_href'] ) . "\">" . esc_html( $d['phone_label'] ) . "</a><br>"
		. "\n    <b>Email</b> <a href=\"mailto:{$email}\">{$email}</a><br>"
		. "\n    <b>Address</b> <a href=\"" . esc_url( $d['map_href'] ) . "\" rel=\"noopener\">" . esc_html( $d['address_1'] ) . $join . esc_html( $d['address_2'] ) . "</a>\n  ";
}

/**
 * Fill every saved Get in touch block from perellion_contact_details() at
 * render time, so copies stored in page content can never drift.
 */
add_filter( 'render_block', function ( $content, $block ) {
	if ( ! is_string( $content ) || false === strpos( $content, 'perellion-contact__lines' ) ) {
		return $content;
	}
	if ( empty( $block['blockName'] ) || 'core/html' !== $block['blockName'] ) {
		return $content;
	}
	$one_line = false !== strpos( $content, 'perellion-contact--centered' );
	return preg_replace_callback(
		'#(<p class="perellion-contact__lines">).*?(</p>)#s',
		function ( $m ) use ( $one_line ) {
			return $m[1] . perellion_contact_lines( $one_line ) . $m[2];
		},
		$content
	);
}, 10, 2 );

function perellion_cta_markup( array $a = array() ): string {
	$d = array(
		'eyebrow'  => true,
		'quote'    => 'This team has some of the best resumes around for automated aircraft assembly.',
		'source'   => 'CTO at a well-known company',
		'portrait' => array( 868, 515 ),
		'alt'      => 'Perellion engineer in the shop',
		'card'     => 'over',      // 'over' = white card on the photo's right edge; 'beside' = bare card left of it; 'none' = no card
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
	$lines = perellion_contact_lines();
	$alt    = esc_attr( $a['alt'] );
	$panel  = 'perellion-panel--portrait';   /* every Get in touch frame: 345 x 471 portrait */
	/* 'none': the frame has no testimonial here (Industries hub, 12:91573: Quote Options empty). */
	$card   = 'none' === $a['card'] ? '' : perellion_quote( $a['quote'], $a['source'], 'beside' === $a['card'] ? 'left' : 'right' );
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
  <p class="perellion-contact__lines">{$lines}</p>
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
