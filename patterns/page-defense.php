<?php
/**
 * Title: Defense industry page
 * Slug: perellion/page-defense
 * Categories: perellion-content
 * Block Types: core/post-content
 * Post Types: page
 * Description: Complete Defense industry page. Insert into an empty page, then replace copy and imagery.
 */

$perellion_sections = array(
	'hero-industry.php',
	'section-overview.php',
	'section-challenges.php',
	'section-media-text.php',
	'section-capability-cards.php',
	'section-proof-stats.php',
	'faq.php',
	'cta-contact.php',
);

foreach ( $perellion_sections as $perellion_section ) {
	$perellion_path = __DIR__ . '/' . $perellion_section;
	if ( file_exists( $perellion_path ) ) {
		include $perellion_path;
	}
}
