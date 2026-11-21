<?php
/**
 * Title: Industries hub page
 * Slug: perellion/page-industries
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Industries hub, built from the Industries / Desktop frame (industry-hub-desktop.png, 1463w export).
 *
 * Bands, read from the frame: Industries served gray with the six cards
 * straddling its bottom edge; FANUC white; Coriolis gray; Siemens white;
 * Get in touch white (shared cta-contact pattern).
 *
 * Photos: the Siemens photo is Sovo's own (Drive, Industry Hub Page folder,
 * 12 Nov, 2x). The FANUC and Coriolis photos and the six card photos are cut from the
 * frame export at 1x as stand-ins (assets/img/hub/). They are to be replaced
 * with the Figma exports once supplied; the markup stays the same.
 *
 * Copy is verbatim from the frame. One deviation: the FANUC quote in the
 * frame ends with a stray closing quotation mark, left out here and raised
 * with Sovo.
 */
$t = get_stylesheet_directory_uri();
/**
 * Photos: the Figma handoff file's "Photo sources" masters, sideloaded into
 * the media library on 21 Nov (ids below). The frame crops in
 * assets/img/hub/ remain as fallbacks if an attachment is missing.
 */
$img = function ( $id, $fallback ) use ( $t ) {
	$u = $id ? wp_get_attachment_image_url( $id, 'large' ) : '';
	return $u ? $u : $t . '/assets/img/hub/' . $fallback;
};
$media = array(
	'advanced-manufacturing' => 859,
	'medical-technology'     => 860,
	'aerospace'              => 861,
	'space'                  => 862,
	'energy'                 => 863,
	'defense'                => 864,
	'fanuc'                  => 857,
	'coriolis'               => 858,
);
$cards = array(
	array( 'advanced-manufacturing', 'Advanced Manufacturing' ),
	array( 'medical-technology', 'Medical Technology' ),
	array( 'aerospace', 'Aerospace' ),
	array( 'space', 'Space' ),
	array( 'energy', 'Energy' ),
	array( 'defense', 'Defense' ),
);
?>

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-hubhero","style":{"spacing":{"padding":{"top":"56px","bottom":"0","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1075px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-hubhero" style="padding-top:56px;padding-right:var(--wp--preset--spacing--24);padding-bottom:0;padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"textAlign":"center","className":"perellion-hubhero__title","fontSize":"display"} -->
<h1 class="wp-block-heading has-text-align-center perellion-hubhero__title has-display-font-size">Industries served</h1>
<!-- /wp:heading -->

<!-- wp:html -->
<ul class="perellion-industrygrid">
<?php foreach ( $cards as $c ) : ?>
  <li class="perellion-card perellion-card--industry">
    <a class="perellion-card__media" href="/<?php echo esc_attr( $c[0] ); ?>/"><img src="<?php echo esc_url( $img( $media[ $c[0] ], 'card-' . $c[0] . '.jpg' ) ); ?>" width="345" height="205" alt="" loading="lazy"></a>
    <h3 class="perellion-card__title"><a href="/<?php echo esc_attr( $c[0] ); ?>/"><?php echo esc_html( $c[1] ); ?></a></h3>
    <a class="perellion-card__link" href="/<?php echo esc_attr( $c[0] ); ?>/">Read more</a>
  </li>
<?php endforeach; ?>
</ul>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"fanuc","className":"perellion-reveal perellion-split perellion-partner","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="fanuc" class="wp-block-group alignfull perellion-reveal perellion-split perellion-partner" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax">
<!-- wp:html -->
<figure class="perellion-panel__media"><img src="<?php echo esc_url( $img( $media['fanuc'], 'partner-fanuc.jpg' ) ); ?>" alt="FANUC robot integrated by Perellion" width="467" height="467"></figure>
<figure class="perellion-quote perellion-quote--left">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>FANUC has extremely good customer service</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Reese Allen<br>Perellion VP &amp; Co-Founder</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">FANUC</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Perellion&rsquo;s partnership with Fanuc has produced custom robot integrations for our clients that would otherwise be unavailable in today&rsquo;s global supply chains. Our partnership allows us to create one of a kind robotic solutions for all environments, conditions, and operational requirements.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="#" data-awaiting-link="fanuc">Read more</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"coriolis","className":"perellion-reveal perellion-split perellion-split--mirror perellion-partner","backgroundColor":"canvas","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="coriolis" class="wp-block-group alignfull perellion-reveal perellion-split perellion-split--mirror perellion-partner has-canvas-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Coriolis</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Partnering with Coriolis, a global leader in Automated Fiber Placement (AFP), lets Perellion build on proven technology rather than adding decades of development. Paired with Perellion&rsquo;s large-scale automation and tooling expertise, it creates opportunities worldwide, bringing the full Coriolis portfolio to US defense and large-aerostructure manufacturers for the first time.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="#" data-awaiting-link="coriolis">Read more</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax">
<!-- wp:html -->
<figure class="perellion-panel__media"><img src="<?php echo esc_url( $img( $media['coriolis'], 'partner-coriolis.jpg' ) ); ?>" alt="Coriolis automated fiber placement head" width="467" height="571"></figure>
<figure class="perellion-quote perellion-quote--rect">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>We share a strong culture of exceptional customer service and cutting edge technology.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Cody Brown<br>Perellion Cofounder &amp; CEO</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"siemens","className":"perellion-reveal perellion-split perellion-partner","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="siemens" class="wp-block-group alignfull perellion-reveal perellion-split perellion-partner" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax">
<!-- wp:html -->
<figure class="perellion-panel__media"><img src="<?php echo esc_url( $t ); ?>/assets/img/hub/partner-siemens.jpg" alt="Siemens controls on a Perellion build" width="467" height="467"></figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Siemens</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Perellion partners with Siemens to provide our customers with reliable, high-performance automation solutions built on industry-leading controls technology. By standardizing on Siemens hardware and software in our custom equipment, we ensure every system is intuitive to operate, easy to maintain, and supported worldwide. This partnership allows us to deliver automation platforms that are scalable, robust, and designed with our customers&rsquo; long-term success in mind.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="#" data-awaiting-link="siemens">Read more</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<?php echo perellion_cta_markup( array( 'eyebrow' => false, 'email' => 'info@perellion.com', 'address_line' => true, 'card' => 'beside', 'portrait' => array( 868 ), 'quote' => 'We can\'t lose access to your team\'s skill sets.', 'source' => 'Aerospace Supply Chain Manager' ) ); ?>
