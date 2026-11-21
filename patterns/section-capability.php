<?php
/**
 * Title: Section, capability with sub-capability row
 * Slug: perellion/section-capability
 * Categories: perellion-content
 * Description: One What We Do capability: an alternating copy/media panel followed by a four-up row of sub-capabilities.
 *
 * The four-up row is the one genuinely new component on the core pages --
 * nothing on the six industry pages matches it. Circular icon badge,
 * title, one line of description, four across on desktop, two on tablet,
 * one on phone, which is what the 834w and 390w frames draw.
 *
 * Not a standalone pattern in practice: page-what-we-do.php inlines four
 * of these with different content. Registered separately so the component
 * is visible in the inserter and can be reused on a future page.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"capability","className":"perellion-reveal perellion-split","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="capability" class="wp-block-group alignfull perellion-reveal perellion-split" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Capability heading</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>One paragraph describing the capability.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--a perellion-parallax">
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/placeholder-feature.svg" alt=""/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-subcaps","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-subcaps" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:group {"className":"perellion-subcaps__row","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-subcaps__row">

<!-- wp:html -->
<div class="perellion-subcap">
  <span class="perellion-subcap__icon is-awaiting-asset" aria-hidden="true"></span>
  <h3 class="perellion-subcap__title">Sub-capability</h3>
  <p class="perellion-subcap__desc">One line of description.</p>
</div>
<!-- /wp:html -->

</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
