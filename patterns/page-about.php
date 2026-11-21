<?php
/**
 * Title: About us page
 * Slug: perellion/page-about
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: About us page, built from the 02 / About us / Desktop frame (about-3up.png, 1440w).
 *
 * Rebuilt 20-21 Nov from the frame export rather than the text extraction,
 * which had missed a paragraph, the Our culture subline, the wide culture
 * photo and the layout of every section. Section order and the five live
 * anchor ids are unchanged: who-we-are, team, what-we-do, our-culture,
 * certifications.
 *
 * Bands, read from the frame margin: hero white, Who we are gray, Meet the
 * team gray, What we do white, Our culture gray (both halves), Certifications
 * white, Join the team gray.
 *
 * Photos are the production site's own, sideloaded into the dev library on
 * 20 Nov (ids 720-729): the frame uses the same imagery.
 *
 * Copy is verbatim from the frame with two deviations, marked where they
 * occur: "Perillion" corrected, and the ITAR certificate link held.
 */
$u = '/wp-content/uploads/2026/11/';
$t = get_stylesheet_directory_uri();
?>

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-hero perellion-hero--page perellion-hero--about","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-hero perellion-hero--page perellion-hero--about" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"className":"perellion-hero__title perellion-wordstack","fontSize":"display"} -->
<h1 class="wp-block-heading perellion-hero__title perellion-wordstack has-display-font-size">Designers<span class="perellion-dot">.</span><br>Inventors<span class="perellion-dot">.</span><br>Collaborators<span class="perellion-dot">.</span><br>Partners<span class="perellion-dot">.</span></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"perellion-hero__body"} -->
<p class="perellion-hero__body">At Perellion, our goal is to create technical solutions for our clients by designing machinery through precision, expertise, and innovation.</p>
<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"who-we-are","className":"perellion-reveal perellion-split","backgroundColor":"canvas","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="who-we-are" class="wp-block-group alignfull perellion-reveal perellion-split has-canvas-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--a perellion-parallax">
<!-- wp:image {"id":720,"sizeSlug":"full","className":"perellion-panel__media"} -->
<figure class="wp-block-image size-full perellion-panel__media"><img src="<?php echo $u; ?>cody-brown-ceo.png" alt="Cody Brown, Cofounder" class="wp-image-720"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote perellion-quote--left">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>Everything we do requires teamwork.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Cody Brown,<br>Cofounder</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Who we are</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"perellion-standfirst"} -->
<p class="perellion-standfirst">With 10&ndash;30 years of experience, our engineers bring groundbreaking ideas to machine design.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>One of our engineers has partnered with a European company to develop a new aerospace material. Some of us have worked on teams that reimagined a new process for automation systems in commercial plane manufacturing. We all have foundational skills in engineering and work as subject matter experts in our field.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Every engineer who joins our team is driven by problem solving&mdash;especially complex problems&mdash;and attention to detail. We&rsquo;re passionate about learning new approaches and rethinking technical systems, so much so that it shows through in our hobbies outside of work as well.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"team","className":"perellion-reveal perellion-teamband","backgroundColor":"white","style":{"spacing":{"padding":{"top":"8px","bottom":"42px","left":"0","right":"0"}}},"layout":{"type":"default"}} -->
<section id="team" class="wp-block-group alignfull perellion-reveal perellion-teamband has-white-background-color has-background" style="padding-top:8px;padding-right:0;padding-bottom:42px;padding-left:0">
<!-- wp:html -->
<p class="perellion-teamband__arrow" aria-hidden="true"><svg width="16" height="24" viewBox="0 0 16 24" fill="none"><path d="M8 1v21M2 16l6 6 6-6" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"/></svg></p>
<!-- /wp:html -->
<!-- wp:paragraph {"align":"center","className":"perellion-overline perellion-eyebrow"} -->
<p class="has-text-align-center perellion-overline perellion-eyebrow">Meet the team</p>
<!-- /wp:paragraph -->

<!-- wp:html -->
<div class="perellion-carousel" data-carousel>
  <div class="perellion-carousel__nav" aria-hidden="false">
    <button type="button" class="perellion-carousel__btn" data-carousel-next aria-label="Next"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="m6 3 5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
    <button type="button" class="perellion-carousel__btn" data-carousel-prev aria-label="Previous"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M10 3 5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></button>
  </div>
<!-- /wp:html -->

<!-- wp:query {"queryId":1,"query":{"perPage":"12","pages":0,"offset":0,"postType":"team_member","order":"asc","orderBy":"menu_order","inherit":false},"className":"perellion-carousel__viewport","layout":{"type":"default"}} -->
<div class="wp-block-query perellion-carousel__viewport">
<!-- wp:post-template {"className":"perellion-carousel__track","layout":{"type":"default"}} -->
<!-- wp:group {"className":"perellion-card perellion-card--team","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-card perellion-card--team">
<!-- wp:post-featured-image {"isLink":true,"className":"perellion-card__media"} /-->
<!-- wp:paragraph {"className":"perellion-card__pill"} -->
<p class="perellion-card__pill">Meet the team</p>
<!-- /wp:paragraph -->
<!-- wp:post-title {"level":3,"isLink":true,"fontSize":"card"} /-->
<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":12,"className":"perellion-card__role"} /-->
<!-- wp:read-more {"content":"Read more","className":"perellion-card__link"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->

<!-- wp:html -->
</div>
<!-- /wp:html -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"what-we-do","className":"perellion-reveal perellion-split perellion-split--mirror","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="what-we-do" class="wp-block-group alignfull perellion-reveal perellion-split perellion-split--mirror" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">What we do</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"perellion-standfirst"} -->
<p class="perellion-standfirst">It&rsquo;s simple. We strive for technical sophistication in everything we do so we can come up with the most durable solutions possible.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>We develop practical and innovative machines for custom automation. Some clients come to us with an idea of what they want, while others only bring a clean sheet design problem. Our team is ready to take on new project proposals with a collective attitude of &ldquo;the more outside-the-box, the better.&rdquo; While we leverage our existing knowledge in our work, we also aren&rsquo;t afraid to invent something new if needed.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>This practical approach and our ability to collaborate internally and externally allows us to solve any type of manufacturing problem quickly. For example, we went from original concept to fabrication in 9 weeks on one project. Because we value open communication and collaboration, we develop long-term partnerships with our clients. The more problems they have, the more we work to solve them.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--rect perellion-panel--b perellion-parallax">
<!-- wp:image {"id":721,"sizeSlug":"full","className":"perellion-panel__media"} -->
<figure class="wp-block-image size-full perellion-panel__media"><img src="<?php echo $u; ?>timing-belt-zoom-full-res-scaled-e1757615090825.jpg" alt="Timing belt machine detail" class="wp-image-721"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"our-culture","className":"perellion-reveal perellion-sectionhead perellion-culture","backgroundColor":"canvas","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"0","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"840px"}} -->
<section id="our-culture" class="wp-block-group alignfull perellion-reveal perellion-sectionhead perellion-culture has-canvas-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:0;padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":2,"textAlign":"center","fontSize":"heading"} -->
<h2 class="wp-block-heading has-text-align-center has-heading-font-size">Our culture</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">We strive for a culture built on transparency, curiosity, collaboration, and work/life balance.</p>
<!-- /wp:paragraph -->
<!-- wp:group {"className":"perellion-panel perellion-panel--wide perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-panel perellion-panel--wide perellion-parallax">
<!-- wp:image {"id":723,"sizeSlug":"full","className":"perellion-panel__media"} -->
<figure class="wp-block-image size-full perellion-panel__media"><img src="<?php echo $u; ?>positive-work-environment.jpg" alt="Perellion team at work" class="wp-image-723"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-split perellion-culture-split","backgroundColor":"canvas","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-split perellion-culture-split has-canvas-background-color has-background" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--round perellion-panel--c perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--round perellion-panel--c perellion-parallax">
<!-- wp:image {"id":728,"sizeSlug":"full","className":"perellion-panel__media"} -->
<figure class="wp-block-image size-full perellion-panel__media"><img src="<?php echo $u; ?>life-work-balance.png" alt="Engineer with his son" class="wp-image-728"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<?php
/**
 * PLACEHOLDER ATTRIBUTION. "Program Manager at a Fortune 100" is the
 * component's anonymised default on the frame. Marked so it cannot ship
 * unnoticed; open with Sovo alongside the other anonymous quotes.
 */
?>
<figure class="perellion-quote perellion-quote--near" data-awaiting-source="true">
  <img class="perellion-quote__mark" src="<?php echo esc_url( $t ); ?>/assets/img/quote-mark.svg" width="32" height="32" alt="" aria-hidden="true">
  <blockquote class="perellion-quote__body"><p>We would not be where we are today without Perellion.</p></blockquote>
  <hr class="perellion-quote__rule">
  <figcaption class="perellion-quote__source">Program Manager at a Fortune 100</figcaption>
</figure>
<!-- /wp:html -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:paragraph -->
<p>Our engineers know that the secrets to success are communication and willingness to learn. That&rsquo;s how we&rsquo;ve cultivated a highly collaborative environment where everyone has something to teach and everyone has something to learn.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Because we&rsquo;ve cultivated a culture that thrives on solving challenges, we&rsquo;ve created an open environment where new perspectives are valued and diversity is embraced.</p>
<!-- /wp:paragraph -->
<!-- wp:paragraph -->
<p>Therefore, we seek to hire engineers who demonstrate their passion and communication and problem-solving skills first. Everything else can be refined on the job.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"certifications","className":"perellion-reveal perellion-sectionhead perellion-certs","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<section id="certifications" class="wp-block-group alignfull perellion-reveal perellion-sectionhead perellion-certs" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":2,"textAlign":"center","fontSize":"heading"} -->
<h2 class="wp-block-heading has-text-align-center has-heading-font-size">Certifications</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">We demonstrate our dedication to high-quality service by keeping our industry certifications and registrations up to date.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"perellion-certs__grid","layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group perellion-certs__grid">

<!-- wp:group {"className":"perellion-certcard","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-certcard">
<!-- wp:html -->
<img class="perellion-certcard__badge" src="<?php echo esc_url( $t ); ?>/assets/img/badge-as9100d.png" width="96" height="85" alt="AS9100D certified">
<!-- /wp:html -->
<!-- wp:heading {"level":3,"textAlign":"center","fontSize":"card"} -->
<h3 class="wp-block-heading has-text-align-center has-card-font-size">Quality</h3>
<!-- /wp:heading -->
<?php
/**
 * LINK HELD. The frame links "AS9100D" but the target was not supplied and
 * the certificate PDF on the live site could not be confirmed from here.
 * Plain text until Perellion supplies the current certificate link.
 */
?>
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Our AS9100D and ISO 9001:2015 certifications demonstrate our unwavering commitment to quality. Clients come to us for our world-class engineering expertise, and because they know they can rely on us. The consistency and dependability of a certified quality management system is essential to our continued success as an industry-leading provider of custom automation and tooling solutions.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-certcard","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-certcard">
<!-- wp:html -->
<img class="perellion-certcard__badge" src="<?php echo esc_url( $t ); ?>/assets/img/badge-cmmc.png" width="96" height="75" alt="CMMC Level 2 compliant">
<!-- /wp:html -->
<!-- wp:heading {"level":3,"textAlign":"center","fontSize":"card"} -->
<h3 class="wp-block-heading has-text-align-center has-card-font-size">Cyber Security</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">We&rsquo;ve achieved 100% compliance with NIST SP 800-171, and when CMMC is rolled out, we will seek certification. Nearly every one of our projects involves extremely high-value intellectual property and often regulatory controlled data. Our customers trust us to make investments in our IT systems and maintain business processes to ensure their proprietary information stays confidential.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-certcard","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-certcard">
<!-- wp:html -->
<img class="perellion-certcard__badge" src="<?php echo esc_url( $t ); ?>/assets/img/badge-itar.png" width="96" height="96" alt="ITAR registered">
<!-- /wp:html -->
<!-- wp:heading {"level":3,"textAlign":"center","fontSize":"card"} -->
<h3 class="wp-block-heading has-text-align-center has-card-font-size">Defense Services</h3>
<!-- /wp:heading -->
<?php
/**
 * LINK HELD. The frame links "ITAR registered" to a registration PDF whose
 * filename states an expiry of 30 September 2026, which has passed. Plain
 * text until Perellion supplies the current certificate. Raised with Reese.
 * The frame also reads "At Perillion"; corrected below.
 */
?>
<!-- wp:paragraph {"align":"center"} -->
<p class="has-text-align-center">Perellion is ITAR registered with the DDTC and maintains a compliance program around our relevant business processes. Engineering data for items on the United States Munitions List including aircraft, rockets, and spacecraft must be protected from access by non-US persons under US law. At Perellion, we know upholding export regulations is crucial to the work we do.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","anchor":"join","className":"perellion-reveal perellion-split perellion-split--mirror perellion-join","backgroundColor":"white","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"default"}} -->
<section id="join" class="wp-block-group alignfull perellion-reveal perellion-split perellion-split--mirror perellion-join has-white-background-color has-background" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--60);padding-left:var(--wp--preset--spacing--24)">

<!-- wp:group {"className":"perellion-split__text","layout":{"type":"constrained","contentSize":"460px","justifyContent":"left"}} -->
<div class="wp-block-group perellion-split__text">
<!-- wp:heading {"level":2,"fontSize":"heading"} -->
<h2 class="wp-block-heading has-heading-font-size">Join the team</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"perellion-standfirst"} -->
<p class="perellion-standfirst">Are you ready to be part of an innovative, world-class team? Explore open positions now.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"backgroundColor":"charcoal","textColor":"white","style":{"border":{"radius":"999px"}},"fontSize":"small"} -->
<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link has-white-color has-charcoal-background-color has-text-color has-background wp-element-button" style="border-radius:999px" href="/join-the-team/">Explore open positions</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->

<!-- wp:group {"className":"perellion-split__media perellion-panel perellion-panel--portrait perellion-panel--a perellion-parallax","layout":{"type":"constrained"}} -->
<div class="wp-block-group perellion-split__media perellion-panel perellion-panel--portrait perellion-panel--a perellion-parallax">
<!-- wp:image {"id":729,"sizeSlug":"full","className":"perellion-panel__media"} -->
<figure class="wp-block-image size-full perellion-panel__media"><img src="<?php echo $u; ?>company-workplace.jpg" alt="Engineer with dog at the workshop" class="wp-image-729"/></figure>
<!-- /wp:image -->
<!-- wp:html -->
<figure class="perellion-quote perellion-quote--beside" data-awaiting-source="true">
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
