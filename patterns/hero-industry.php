<?php
/**
 * Title: Industry hero
 * Slug: perellion/hero-industry
 * Categories: perellion-hero
 * Description: Full-width industry hero with accent headline, section navigation, scroll cue and circular media.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"perellion-hero perellion-reveal","style":{"spacing":{"padding":{"top":"var:preset|spacing|96","bottom":"var:preset|spacing|120","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1280px"}} -->
<section class="wp-block-group alignfull perellion-hero perellion-reveal" style="padding-top:var(--wp--preset--spacing--96);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--120);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"textAlign":"center","className":"perellion-hero__title","fontSize":"display","fontFamily":"poppins"} -->
<h1 class="wp-block-heading has-text-align-center perellion-hero__title has-poppins-font-family has-display-font-size">Trusted Engineering for Secure <span class="perellion-gradient-text">Defense</span> Programs</h1>
<!-- /wp:heading -->

<!-- wp:group {"className":"perellion-sectionnav","style":{"spacing":{"margin":{"top":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|48"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}} -->
<div class="wp-block-group perellion-sectionnav" style="margin-top:var(--wp--preset--spacing--60)">
<!-- wp:paragraph {"className":"perellion-overline"} -->
<p class="perellion-overline"><a href="#challenges">Challenges</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"perellion-overline"} -->
<p class="perellion-overline"><a href="#help">Help</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"perellion-overline"} -->
<p class="perellion-overline"><a href="#secure">Secure</a></p>
<!-- /wp:paragraph -->
<!-- wp:paragraph {"className":"perellion-overline"} -->
<p class="perellion-overline"><a href="#risk">Risk</a></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:html -->
<div class="perellion-scrollcue" aria-hidden="true">
  <svg width="28" height="16" viewBox="0 0 28 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M2 2L14 14L26 2" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
</div>
<!-- /wp:html -->

<!-- wp:group {"className":"perellion-hero__media","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-hero__media">
<!-- wp:image {"align":"center","className":"perellion-hero__disc perellion-parallax","sizeSlug":"perellion-hero"} -->
<figure class="wp-block-image aligncenter perellion-hero__disc perellion-parallax"><img src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/placeholder-hero.svg" alt="Defense engineering at Perellion"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
