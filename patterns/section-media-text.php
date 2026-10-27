<?php
/**
 * Title: Section, media and text
 * Slug: perellion/section-media-text
 * Categories: perellion-content
 * Description: Alternating image and copy section on a tinted band.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"help","className":"perellion-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|96","bottom":"var:preset|spacing|96","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"backgroundColor":"canvas","layout":{"type":"constrained","contentSize":"1280px"}} -->
<section id="help" class="wp-block-group alignfull perellion-reveal has-canvas-background-color has-background" style="padding-top:var(--wp--preset--spacing--96);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--96);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|80"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center">
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:paragraph {"className":"perellion-overline perellion-eyebrow"} -->
<p class="perellion-overline perellion-eyebrow">Our approach</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"fontSize":"heading","fontFamily":"poppins"} -->
<h2 class="wp-block-heading has-poppins-font-family has-heading-font-size">How Perellion Helps</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"graphite","style":{"spacing":{"margin":{"top":"var:preset|spacing|24"}}}} -->
<p class="has-graphite-color has-text-color" style="margin-top:var(--wp--preset--spacing--24)">Placeholder copy. We join programs at any stage, from early feasibility through to full rate production tooling, and we work to the documentation standard the program requires.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center"} -->
<div class="wp-block-column is-vertically-aligned-center">
<!-- wp:image {"className":"perellion-media perellion-parallax","sizeSlug":"large"} -->
<figure class="wp-block-image perellion-media perellion-parallax"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/placeholder-section.svg" alt="Perellion engineering in progress"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</section>
<!-- /wp:group -->
