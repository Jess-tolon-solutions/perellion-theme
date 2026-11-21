<?php
/**
 * Title: Insights page
 * Slug: perellion/page-insights
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Insights, built from Figma 298:85446 (04 / Insights / Desktop). One grid across Meet the team, Join the team and Case studies, with the three tags as links to each archive.
 *
 * The frame shows a static row of three tags and six cards, three across.
 * Production has no news posts, so this page is the "news archive" line of
 * the SOW: a filtered view over the three existing content types. The tags
 * link to the three archives, which keeps every existing archive URL alive.
 * The pill on each card is written by CSS from the post type, so the one
 * loop serves all three types.
 */
?>
<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-hero perellion-hero--page perellion-hero--archive","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|32","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"900px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-hero perellion-hero--page perellion-hero--archive" style="padding-top:var(--wp--preset--spacing--60);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:heading {"level":1,"textAlign":"center","className":"perellion-hero__title","fontSize":"display"} -->
<h1 class="wp-block-heading has-text-align-center perellion-hero__title has-display-font-size">Insights</h1>
<!-- /wp:heading -->
<!-- wp:group {"className":"perellion-tagrow","layout":{"type":"flex","justifyContent":"center","flexWrap":"wrap"}} -->
<div class="wp-block-group perellion-tagrow">
<!-- wp:paragraph --><p><a class="perellion-tag" href="/meet-the-team/">Meet the team</a></p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p><a class="perellion-tag" href="/join-the-team/">Join the team</a></p><!-- /wp:paragraph -->
<!-- wp:paragraph --><p><a class="perellion-tag" href="/case-studies/">Case studies</a></p><!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->

<!-- wp:group {"tagName":"section","align":"full","className":"perellion-reveal perellion-archive__grid","style":{"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|80","left":"var:preset|spacing|24","right":"var:preset|spacing|24"}}},"layout":{"type":"constrained","contentSize":"1100px"}} -->
<section class="wp-block-group alignfull perellion-reveal perellion-archive__grid" style="padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--24);padding-bottom:var(--wp--preset--spacing--80);padding-left:var(--wp--preset--spacing--24)">
<!-- wp:query {"queryId":31,"query":{"perPage":12,"pages":0,"offset":0,"postType":"team_member","order":"desc","orderBy":"date","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query">
<!-- wp:post-template {"className":"perellion-insightgrid","layout":{"type":"grid","columnCount":3}} -->
<!-- wp:group {"className":"perellion-card perellion-card--team","layout":{"type":"default"}} -->
<div class="wp-block-group perellion-card perellion-card--team">
<!-- wp:post-featured-image {"isLink":true,"className":"perellion-card__media"} /-->
<!-- wp:paragraph {"className":"perellion-card__pill perellion-card__pill--auto"} -->
<p class="perellion-card__pill perellion-card__pill--auto"></p>
<!-- /wp:paragraph -->
<!-- wp:post-title {"level":2,"isLink":true,"fontSize":"card"} /-->
<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":12,"className":"perellion-card__role"} /-->
<!-- wp:read-more {"content":"Read more","className":"perellion-card__link"} /-->
</div>
<!-- /wp:group -->
<!-- /wp:post-template -->
<!-- wp:query-pagination {"paginationArrow":"none","layout":{"type":"flex","justifyContent":"center"}} -->
<!-- wp:query-pagination-previous {"label":"Previous"} /-->
<!-- wp:query-pagination-numbers /-->
<!-- wp:query-pagination-next {"label":"More"} /-->
<!-- /wp:query-pagination -->
</div>
<!-- /wp:query -->
</section>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"perellion/cta-contact"} /-->
