<?php
/**
 * Title: Contact page
 * Slug: perellion/page-contact
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Contact page, built from Figma 298:85612 (06 / Contact / Desktop / 1440w).
 *
 * The shortest page in the handoff at 1440x1294. A centered single column
 * over a map band. Note what is NOT here: there is no contact form
 * anywhere on the frame at any breakpoint. The page is a mailto, which
 * answers the "contact form routing" question that has been open on the
 * board since kickoff -- there is no form to route.
 *
 * Reese confirmed on 10 Nov that submissions go to info@perellion.com now
 * and after launch, so that is the address used throughout.
 */
?>

<!-- wp:group {"tagName":"section","align":"full","anchor":"get-in-touch","className":"perellion-reveal perellion-contactpage","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"720px"}} -->
<section id="get-in-touch" class="wp-block-group alignfull perellion-reveal perellion-contactpage" style="padding-top:var(--wp--preset--spacing--80);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:heading {"level":1,"textAlign":"center","className":"perellion-hero__title","fontSize":"display"} -->
<h1 class="wp-block-heading has-text-align-center perellion-hero__title has-display-font-size">Get in touch</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"align":"center","className":"perellion-hero__body"} -->
<p class="has-text-align-center perellion-hero__body">Have a problem that needs solving?<br>Or just want more information? Let&rsquo;s discuss it.</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<div class="perellion-contact perellion-contact--centered">
  <p class="perellion-contact__lines">
    <b>Phone</b> <a href="tel:+14253683368">+1 (425) 368-3368</a><br>
    <b>Email</b> <a href="mailto:info@perellion.com">info@perellion.com</a><br>
    <b>Address</b> <a href="https://maps.google.com/?q=6700+Hardeson+Rd+%23104+Everett+WA+98203" rel="noopener">6700 Hardeson Rd #104, Everett, WA 98203</a>
  </p>
</div>
<!-- /wp:html -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="mailto:info@perellion.com">Send message</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->

</section>
<!-- /wp:group -->

<?php
/**
 * MAP: ASSET DECISION OPEN.
 *
 * The frame draws a dark-styled map of the Puget Sound area with a yellow
 * "Perellion HQ" pin over the Everett / Mukilteo area and brand glow
 * behind it. Two ways to build it:
 *
 *   Static export  -- simplest. No API key, no third-party script, no
 *                     cookie-consent implication, and the styling is
 *                     exactly what Sovo drew. Not clickable.
 *   Live embed     -- interactive and zoomable, but adds a Google script,
 *                     needs a billing-enabled API key, and places a
 *                     third-party cookie on a defense contractor's site,
 *                     which is a conversation worth having deliberately.
 *
 * Recommending the static export. Held as an awaiting-asset band rather
 * than guessed at, because either answer needs something we do not have:
 * an image from Sovo, or a key and a privacy decision from Perellion.
 *
 * The address above links out to Google Maps in the meantime, so the
 * page is already functional for someone trying to find the building.
 */
?>
<?php
/**
 * Map: the frame's own map image (dark Puget Sound map with the yellow
 * "Perellion HQ" pin), taken from the Contact frame's image fill and
 * sideloaded into the media library on 21 Nov as id 880. Drawn at the
 * frame's 800 x 450 with the brand glow behind it; the address above
 * still links out to Google Maps.
 */
$map = wp_get_attachment_image_url( 880, 'full' );
?>
<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-mapband","style":{"spacing":{"padding":{"top":"24px","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"800px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-mapband" style="padding-top:24px;padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:html -->
<?php if ( $map ) : ?>
<div class="perellion-panel perellion-panel--map perellion-panel--c">
  <figure class="perellion-panel__media"><img src="<?php echo esc_url( $map ); ?>" alt="Map showing Perellion HQ in Everett, Washington" width="800" height="450"></figure>
</div>
<?php else : ?>
<div class="perellion-mapband__slot is-awaiting-asset">
  <span class="perellion-mapband__label">Perellion HQ</span>
  <span class="perellion-mapband__note">Map image to come</span>
</div>
<?php endif; ?>
<!-- /wp:html -->
</section>
<!-- /wp:group -->
