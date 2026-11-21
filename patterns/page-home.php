<?php
/**
 * Title: Home page
 * Slug: perellion/page-home
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Home page, built from the 01 / Home / Desktop frame (home-3up.png, 1440w column).
 *
 * Sections, from the frame: hero (word stack + body, wide fixture photo with
 * the testimonial card over its right edge), Core Capabilities (gray band,
 * four icons linking into What we do), Get in touch (shared cta-contact).
 *
 * The fixture photo and the four icons are cut from the frame at 1x as
 * stand-ins (assets/img/home/) until the Figma exports are supplied.
 * Copy is verbatim from the frame.
 */
$t = get_stylesheet_directory_uri();
$caps = array(
	array( 'machines', 'Machines &amp;<br>Automation', '/what-we-do/#machine-automation' ),
	array( 'aerospace', 'Aerospace<br>&amp; Defense', '/what-we-do/#aerospace-defense' ),
	array( 'manufacturing', 'Manufacturing<br>&amp; Logistics', '/what-we-do/#manufacturing-logistics' ),
	array( 'engineering', 'Engineering<br>Services', '/what-we-do/#engineering-services' ),
);
?>

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-hero perellion-hero--page perellion-hero--home","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-hero perellion-hero--page perellion-hero--home" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"className":"perellion-hero__title perellion-wordstack","fontSize":"display"} -->
<h1 class="wp-block-heading perellion-hero__title perellion-wordstack has-display-font-size">Innovation<span class="perellion-dot">.</span><br>Speed<span class="perellion-dot">.</span><br>Precision<span class="perellion-dot">.</span></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"perellion-hero__body"} -->
<p class="perellion-hero__body">We&rsquo;re passionate engineers with years of experience who value the art of solving complex problems and the science behind efficiently executing those solutions.</p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"showcase","className":"perellion-reveal perellion-showcase","style":{"spacing":{"padding":{"top":"0","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"838px"}} -->
<section id="showcase" class="wp-block-group alignfull perellion-reveal perellion-showcase" style="padding-top:0;padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:group {"className":"perellion-panel perellion-panel--wide perellion-panel--c perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-panel perellion-panel--wide perellion-panel--c perellion-parallax">
<!-- wp:html -->
<figure class="perellion-panel__media"><img src="<?php echo esc_url( $t ); ?>/assets/img/home/hero-fixture.jpg" alt="Perellion assembly fixture on the shop floor" width="838" height="470"></figure>
<figure class="perellion-quote perellion-quote--showcase" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>[Perellion] has done a great job for me. Really enjoyed working with you and your crew.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Lead engineer at a space technology company</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
<!-- wp:html -->
<p class="perellion-teamband__arrow perellion-showcase__arrow" aria-hidden="true"><svg width="16" height="24" viewBox="0 0 16 24" fill="none"><path d="M8 1v21M2 16l6 6 6-6" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/></svg></p>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"capabilities","className":"perellion-reveal perellion-sectionhead perellion-capabilities","backgroundColor":"canvas","style":{"spacing":{"padding":{"top":"80px","bottom":"36px","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section id="capabilities" class="wp-block-group alignfull perellion-reveal perellion-sectionhead perellion-capabilities has-canvas-background-color has-background" style="padding-top:80px;padding-right:var(--wp--preset--spacing--24);padding-bottom:36px;padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":2,"textAlign":"center","fontSize":"heading"} -->
<h2 class="wp-block-heading has-text-align-center has-heading-font-size">Core Capabilities</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">We bring multiple disciplines and perspectives together, so any challenge has a solution.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<ul class="perellion-capgrid">
<?php foreach ( $caps as $c ) : ?>
  <li class="perellion-capcard">
    <a class="perellion-capcard__icon" href="<?php echo esc_url( $c[2] ); ?>"><img src="<?php echo esc_url( $t ); ?>/assets/img/home/icon-<?php echo esc_attr( $c[0] ); ?>.png" width="96" height="96" alt=""></a>
    <h3 class="perellion-capcard__title"><a href="<?php echo esc_url( $c[2] ); ?>"><?php echo $c[1]; ?></a></h3>
    <a class="perellion-capcard__link" href="<?php echo esc_url( $c[2] ); ?>">Read more</a>
  </li>
<?php endforeach; ?>
</ul>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"perellion/cta-contact"} /-->
