<?php
/**
 * Title: What we do page
 * Slug: perellion/page-what-we-do
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Complete What we do page, built from Figma 298:85283 and the 1443w / 834w / 390w exports.
 *
 * Four capability blocks, each an alternating copy/media panel followed by
 * a four-up row of sub-capabilities. Sections alternate tinted and white
 * backgrounds, and the media alternates side and shape, exactly as the
 * desktop export draws them.
 *
 * All four production anchor ids are preserved so the live nav keeps
 * working: machine-automation, aerospace-defense, manufacturing-logistics,
 * engineering-services. Production also carries #manufacturing-renderings,
 * which does not appear in the design; it is kept as an empty target on
 * the manufacturing block rather than silently dropped.
 */

/**
 * Media, 21 Nov: photos and the 16 capability icons come from the Figma
 * handoff file (frame image fills and the "04A Capability media" masters),
 * sideloaded into the media library. Fallbacks keep the page rendering if
 * an attachment is missing. The Machines & Automation photo is the nearest
 * master (the robot cell, 865): the frame's own fill was not exported by the
 * file. Engineering Services uses the same shot as the hub's Siemens block.
 */
$t = get_stylesheet_directory_uri();
$wwd_img = function ( $id, $fallback ) use ( $t ) {
	$u = $id ? wp_get_attachment_image_url( $id, 'large' ) : '';
	return $u ? $u : $fallback;
};
$wwd_photo = array(
	'machines'    => $wwd_img( 865, $t . '/assets/img/placeholder-feature.svg' ),
	'aerospace'   => $wwd_img( 908, $t . '/assets/img/placeholder-feature.svg' ),
	'logistics'   => $wwd_img( 905, $t . '/assets/img/placeholder-feature.svg' ),
	'engineering' => $t . '/assets/img/hub/partner-siemens.jpg',
	'contact'     => $wwd_img( 868, $wwd_img( 515, $t . '/assets/img/placeholder-feature.svg' ) ),
);
$wwd_icon = array(
	'Custom Machine Tools' => 888, 'Robotic Systems' => 887, 'Composite Automation' => 889, 'Additive Manufacturing' => 890,
	'Wing and Fuselage Assembly' => 892, 'Final Assembly Lines' => 891, 'Composite Fabrication' => 893, 'Drilling and Fastening' => 894,
	'Assembly Lines' => 896, 'Layout &amp; Material Flow' => 895, 'Material Handling' => 897, 'Assembly Tooling' => 898,
	'Design for Manufacturing' => 899, 'Factory Layout Planning' => 900, 'Automation Feasibility' => 901, 'Process Development' => 902,
);
$wwd_icon_tag = function ( $title ) use ( $wwd_icon ) {
	$id = isset( $wwd_icon[ $title ] ) ? $wwd_icon[ $title ] : 0;
	$u  = $id ? wp_get_attachment_image_url( $id, 'full' ) : '';
	if ( ! $u ) { return '<span class="perellion-subcap__icon is-awaiting-asset" aria-hidden="true"></span>'; }
	return '<span class="perellion-subcap__icon" aria-hidden="true"><img src="' . esc_url( $u ) . '" width="96" height="96" alt="" loading="lazy"></span>';
};
?>

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-hero perellion-hero--page","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-hero perellion-hero--page" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"textAlign":"center","className":"perellion-hero__title","fontSize":"display"} -->
<h1 class="wp-block-heading has-text-align-center perellion-hero__title has-display-font-size">We love solving <span class="perellion-accent">hard problems</span></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","className":"perellion-hero__body"} -->
<p class="has-text-align-center perellion-hero__body">That&rsquo;s why we have experts with a variety of capabilities. From planning to implementation, we focus on simple and precise solutions.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<nav class="perellion-jumpnav" aria-label="Capabilities">
  <a href="#machine-automation">Machines &amp; Automation</a>
  <a href="#aerospace-defense">Aerospace &amp; Defense</a>
  <a href="#manufacturing-logistics">Manufacturing &amp; Logistics</a>
  <a href="#engineering-services">Engineering Services</a>
</nav>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"machine-automation","className":"perellion-reveal perellion-split perellion-band--tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="machine-automation" class="wp-block-group alignfull perellion-reveal perellion-split perellion-band--tint" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Machines &amp; Automation</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We build innovative machines that save space and manual labor. Every aspect of our automation services ensures clients receive a product that minimizes risk and accelerates production for a manufacturing process that results in prime scalability and uptime.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="/advanced-manufacturing/">Advanced manufacturing</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--a perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( $wwd_photo['machines'] ); ?>" alt="Machines &amp; Automation"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>(Perellion was) selected for their creative engineering and expertise in complex automation, and ease of collaboration.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Program Manager at a Fortune 100</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-subcaps perellion-band--tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-subcaps perellion-band--tint" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:html -->
<div class="perellion-subcaps__row">
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Custom Machine Tools' ); ?>
    <h3 class="perellion-subcap__title">Custom Machine Tools</h3>
    <p class="perellion-subcap__desc">Clean sheet design to customer&rsquo;s specifications</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Robotic Systems' ); ?>
    <h3 class="perellion-subcap__title">Robotic Systems</h3>
    <p class="perellion-subcap__desc">Fully integrated systems with custom engineered end-effectors</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Composite Automation' ); ?>
    <h3 class="perellion-subcap__title">Composite Automation</h3>
    <p class="perellion-subcap__desc">Elegant solutions for improved composite part throughput &amp; cost</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Additive Manufacturing' ); ?>
    <h3 class="perellion-subcap__title">Additive Manufacturing</h3>
    <p class="perellion-subcap__desc">Enabling the next generation of manufacturing capabilities</p>
  </div>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"aerospace-defense","className":"perellion-reveal perellion-split perellion-split--mirror","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="aerospace-defense" class="wp-block-group alignfull perellion-reveal perellion-split perellion-split--mirror" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Aerospace &amp; Defense</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>With top-of-the-line precision and some of the best engineers in the industry, we lead innovation in aerospace and defense machinery.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="/aerospace/">Aerospace deep-dive</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--b perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--b perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( $wwd_photo['aerospace'] ); ?>" alt="Aerospace &amp; Defense"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>This team has some of the best resumes around for automated aircraft assembly.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">CTO at a well-known company</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-subcaps","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-subcaps" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:html -->
<div class="perellion-subcaps__row">
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Wing and Fuselage Assembly' ); ?>
    <h3 class="perellion-subcap__title">Wing and Fuselage Assembly</h3>
    <p class="perellion-subcap__desc">Assembly tooling and material handling</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Final Assembly Lines' ); ?>
    <h3 class="perellion-subcap__title">Final Assembly Lines</h3>
    <p class="perellion-subcap__desc">Positioning systems, ergonomic access solutions, and integrated metrology</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Composite Fabrication' ); ?>
    <h3 class="perellion-subcap__title">Composite Fabrication</h3>
    <p class="perellion-subcap__desc">Automated layup and trimming operations</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Drilling and Fastening' ); ?>
    <h3 class="perellion-subcap__title">Drilling and Fastening</h3>
    <p class="perellion-subcap__desc">Robotic systems and custom machine tools</p>
  </div>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"manufacturing-logistics","className":"perellion-reveal perellion-split perellion-band--tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="manufacturing-logistics" class="wp-block-group alignfull perellion-reveal perellion-split perellion-band--tint" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Manufacturing &amp; Logistics</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>We believe in exploring all possibilities before deciding on the safest, smartest, and most cost-effective solution. Our pragmatic team tests for all parts of material management, planning, and execution.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--c perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--c perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( $wwd_photo['logistics'] ); ?>" alt="Manufacturing &amp; Logistics"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>Overall, everyone is quite happy. (This is a) major upgrade in that process.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Senior Engineer at electric aviation company</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-subcaps perellion-band--tint","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-subcaps perellion-band--tint" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:html -->
<div class="perellion-subcaps__row">
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Assembly Lines' ); ?>
    <h3 class="perellion-subcap__title">Assembly Lines</h3>
    <p class="perellion-subcap__desc">Integrating subsystems together into a finished product</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Layout &amp; Material Flow' ); ?>
    <h3 class="perellion-subcap__title">Layout &amp; Material Flow</h3>
    <p class="perellion-subcap__desc">Planning out your factory to meet rate efficiently</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Material Handling' ); ?>
    <h3 class="perellion-subcap__title">Material Handling</h3>
    <p class="perellion-subcap__desc">AGVs, positioners, and overhead lifting equipment</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Assembly Tooling' ); ?>
    <h3 class="perellion-subcap__title">Assembly Tooling</h3>
    <p class="perellion-subcap__desc">Fixtures, jigs, and assembly aids</p>
  </div>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<?php
/**
 * Production carries a #manufacturing-renderings anchor on this page
 * that the design does not draw. Direct links to it exist in the wild,
 * so the target is preserved rather than dropped.
 */
?>
<!-- wp:html -->
<span id="manufacturing-renderings" class="perellion-anchor-stub"></span>
<!-- /wp:html -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"engineering-services","className":"perellion-reveal perellion-split perellion-split--mirror","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="engineering-services" class="wp-block-group alignfull perellion-reveal perellion-split perellion-split--mirror" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Engineering Services</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>Each project has its own unique challenges and solutions. That&rsquo;s why every project is assigned an engineer who leads design, manufacturing, procurement, and programming, and maintains consistent communication.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( $wwd_photo['engineering'] ); ?>" alt="Engineering Services"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>This is by far the most well put together Alpha I have ever seen.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Lead engineer at a Fortune 100</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-subcaps","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-subcaps" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:html -->
<div class="perellion-subcaps__row">
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Design for Manufacturing' ); ?>
    <h3 class="perellion-subcap__title">Design for Manufacturing</h3>
    <p class="perellion-subcap__desc">Taking prototype designs to production readiness</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Factory Layout Planning' ); ?>
    <h3 class="perellion-subcap__title">Factory Layout Planning</h3>
    <p class="perellion-subcap__desc">Making the most efficient use of the space available</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Automation Feasibility' ); ?>
    <h3 class="perellion-subcap__title">Automation Feasibility</h3>
    <p class="perellion-subcap__desc">Identifying where automation can add the most value</p>
  </div>
  <div class="perellion-subcap">
    <?php echo $wwd_icon_tag( 'Process Development' ); ?>
    <h3 class="perellion-subcap__title">Process Development</h3>
    <p class="perellion-subcap__desc">Helping customers develop and refine process parameters</p>
  </div>
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<?php echo perellion_cta_markup( array( 'eyebrow' => false, 'email' => 'info@perellion.com', 'address_line' => true, 'card' => 'beside', 'portrait' => array( 904, 868 ), 'quote' => 'Some of the cleanest and clearest reports I\'ve seen.', 'source' => 'Blue Origin Stress Analyst' ) ); ?>
