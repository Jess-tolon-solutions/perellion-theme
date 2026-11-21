<?php
/**
 * Title: CTA, get in touch
 * Slug: perellion/cta-contact
 * Categories: perellion-cta
 * Description: Closing contact section. The frame gives this a visual panel like the other body components.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","anchor":"contact","className":"perellion-reveal perellion-split","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="contact" class="wp-block-group alignfull perellion-reveal perellion-split" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:paragraph {"className":"perellion-overline perellion-eyebrow"} -->
<p class="perellion-overline perellion-eyebrow">Contact</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Get in touch</h2>
<!-- /wp:heading -->
<!-- wp:html -->
<?php
/**
 * Feedback item 11: "Match the original contact text grouping rather than
 * the R1 narrow multi-column fields." The frame does not use fields at
 * all. It is one 460px text block at 16/36 with the label bold and inline
 * and the value in action blue on the same line, wrapping naturally. The
 * definition list that was here produced the narrow columns she objected
 * to, so it is replaced by the single block the frame actually draws.
 *
 * Email is defense@perellion.com, per the desktop frame. The mobile frame
 * says info@perellion.com and the build said e@perellion.com, which
 * matched neither; that conflict is item 13 and is with Sovo.
 */
?>
<div class="perellion-contact">
  <p class="perellion-contact__intro">Have a problem that needs solving? Or just want more information? Let&rsquo;s discuss it.</p>
  <p class="perellion-contact__lines">
    <b>Phone</b> <a href="tel:+14253683368">+1 (425) 368-3368</a><br>
    <b>Email</b> <a href="mailto:defense@perellion.com">defense@perellion.com</a>
    <b>Address</b> 6700 Hardeson Rd #104 Everett, WA 98203
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

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax">
<?php
// Portrait: the Figma "perellion-engineering-team-contact" master (media id
// 868, sideloaded 21 Nov), falling back to the R2 345x471 crop (515) and
// then the theme placeholder, so the pattern never renders empty.
$portrait = wp_get_attachment_image_url( 868, 'large' );
if ( ! $portrait ) { $portrait = wp_get_attachment_image_url( 515, 'full' ); }
if ( ! $portrait ) { $portrait = get_stylesheet_directory_uri() . '/assets/img/placeholder-feature.svg'; }
?>
<!-- wp:image {"className":"perellion-panel__media","sizeSlug":"full"} -->
<figure class="wp-block-image perellion-panel__media"><img src="<?php echo esc_url( $portrait ); ?>" alt="Perellion engineer in the shop"/></figure>
<!-- /wp:image -->

<!-- wp:html -->
<?php
/**
 * Feedback item 11: "restore the quote card overlapping the portrait".
 * Taken from the frame, not from the description. The card is 205.71 wide
 * by 314 tall, sits 85.67 below the top of the photo, and crosses the
 * photo's right edge so that 99.48 of it is over the image and 106.23
 * hangs past it. White at 90% with a 14px backdrop blur and a 1px white
 * hairline, 2px radius, 24 padding, 20 between items.
 */
?>
<figure class="perellion-quote">
  <img class="perellion-quote__mark" src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>This team has some of the best resumes around for automated aircraft assembly.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">CTO at a well-known company</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

</section>
<!-- /wp:group -->
