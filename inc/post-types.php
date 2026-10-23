<?php
/**
 * Content types for Perellion.
 *
 * The 2023 site published case studies, team bios and job postings as blog
 * posts filed under categories. That is why they were hard to manage. Each
 * becomes a proper content type here, with its own archive and single
 * template, so the team can add one without touching layout.
 *
 * Migration note: existing posts keep their URLs. /case-studies/{slug},
 * /meet-the-team/{slug} and /join-the-team/{slug} are preserved as the
 * rewrite slugs below, so no redirects are needed for these three types.
 *
 * @package Perellion
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the three content types.
 */
function perellion_register_post_types(): void {

	$types = array(

		'case_study' => array(
			'singular' => __( 'Case Study', 'perellion' ),
			'plural'   => __( 'Case Studies', 'perellion' ),
			'slug'     => 'case-studies',
			'icon'     => 'dashicons-portfolio',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
		),

		'team_member' => array(
			'singular' => __( 'Team Member', 'perellion' ),
			'plural'   => __( 'Meet the Team', 'perellion' ),
			'slug'     => 'meet-the-team',
			'icon'     => 'dashicons-groups',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
		),

		'job_posting' => array(
			'singular' => __( 'Job Posting', 'perellion' ),
			'plural'   => __( 'Join the Team', 'perellion' ),
			'slug'     => 'join-the-team',
			'icon'     => 'dashicons-clipboard',
			'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
		),
	);

	foreach ( $types as $key => $type ) {

		register_post_type(
			$key,
			array(
				'labels'       => array(
					'name'               => $type['plural'],
					'singular_name'      => $type['singular'],
					'add_new_item'       => sprintf( /* translators: %s: content type name */ __( 'Add New %s', 'perellion' ), $type['singular'] ),
					'edit_item'          => sprintf( /* translators: %s: content type name */ __( 'Edit %s', 'perellion' ), $type['singular'] ),
					'search_items'       => sprintf( /* translators: %s: content type name */ __( 'Search %s', 'perellion' ), $type['plural'] ),
					'not_found'          => sprintf( /* translators: %s: content type name */ __( 'No %s yet', 'perellion' ), strtolower( $type['plural'] ) ),
				),
				'public'       => true,
				'has_archive'  => $type['slug'],
				'rewrite'      => array(
					'slug'       => $type['slug'],
					'with_front' => false,
				),
				'menu_icon'    => $type['icon'],
				'supports'     => $type['supports'],
				'show_in_rest' => true,
				'template_lock' => false,
			)
		);
	}
}
add_action( 'init', 'perellion_register_post_types' );

/**
 * Industry taxonomy.
 *
 * Lets a case study be tagged to one or more industries so the six industry
 * pages can pull their own relevant proof automatically, rather than each
 * page carrying a hand-maintained list.
 */
function perellion_register_taxonomies(): void {

	register_taxonomy(
		'industry',
		array( 'case_study' ),
		array(
			'labels'            => array(
				'name'          => __( 'Industries', 'perellion' ),
				'singular_name' => __( 'Industry', 'perellion' ),
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array(
				'slug'       => 'industries',
				'with_front' => false,
			),
		)
	);
}
add_action( 'init', 'perellion_register_taxonomies' );

/**
 * Seed the six industry terms on theme activation so the taxonomy is usable
 * immediately and the slugs match the industry page URLs.
 */
function perellion_seed_industry_terms(): void {

	$industries = array(
		'Defense'                 => 'defense',
		'Aerospace'               => 'aerospace',
		'Advanced Manufacturing'  => 'advanced-manufacturing',
		'Space'                   => 'space',
		'Medical Technology'      => 'medical-technology',
		'Energy'                  => 'energy',
	);

	foreach ( $industries as $name => $slug ) {
		if ( ! term_exists( $slug, 'industry' ) ) {
			wp_insert_term( $name, 'industry', array( 'slug' => $slug ) );
		}
	}
}
add_action( 'after_switch_theme', 'perellion_seed_industry_terms' );

/**
 * Flush rewrite rules once on activation so the new URLs resolve without
 * anyone having to re-save permalinks.
 */
function perellion_flush_rewrites(): void {
	perellion_register_post_types();
	perellion_register_taxonomies();
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'perellion_flush_rewrites', 20 );
