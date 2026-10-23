<?php
/**
 * Perellion theme functions.
 *
 * Structure of this theme:
 *   theme.json       Design tokens. Colour, type, spacing, shadows. Single source of truth.
 *   style.css        Figma token aliases, base styles, utility classes.
 *   /inc             Content types and fields.
 *   /patterns        Reusable section layouts the editor can insert.
 *   /parts           Header and footer template parts.
 *   /templates       Page and archive templates.
 *   /assets          Fonts, images, vectors.
 *
 * @package Perellion
 */

declare( strict_types = 1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PERELLION_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'PERELLION_DIR', get_stylesheet_directory() );
define( 'PERELLION_URI', get_stylesheet_directory_uri() );

/**
 * Load the parent and child stylesheets.
 */
function perellion_enqueue_styles(): void {
	wp_enqueue_style(
		'perellion',
		PERELLION_URI . '/style.css',
		array( 'ollie-style' ),
		PERELLION_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'perellion_enqueue_styles', 20 );

/**
 * Load the token aliases in the block editor too, so what the client sees
 * while editing matches what visitors see.
 */
function perellion_editor_styles(): void {
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'perellion_editor_styles' );

/**
 * Theme supports.
 */
function perellion_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// Image sizes used by the card grids and hero treatments.
	add_image_size( 'perellion-card', 720, 480, true );
	add_image_size( 'perellion-portrait', 640, 800, true );
	add_image_size( 'perellion-hero', 2400, 1200, true );
}
add_action( 'after_setup_theme', 'perellion_setup' );

/**
 * Register the pattern categories the section patterns are filed under.
 * Keeps the inserter organised for whoever is editing.
 */
function perellion_pattern_categories(): void {
	$categories = array(
		'perellion-hero'       => __( 'Perellion: heroes', 'perellion' ),
		'perellion-capability' => __( 'Perellion: capability', 'perellion' ),
		'perellion-proof'      => __( 'Perellion: proof and testimonials', 'perellion' ),
		'perellion-cta'        => __( 'Perellion: calls to action', 'perellion' ),
		'perellion-content'    => __( 'Perellion: content sections', 'perellion' ),
	);

	foreach ( $categories as $slug => $label ) {
		register_block_pattern_category( $slug, array( 'label' => $label ) );
	}
}
add_action( 'init', 'perellion_pattern_categories' );

/**
 * Content types.
 *
 * Replaces the previous site's use of blog categories for case studies,
 * team bios and job postings.
 */
require_once PERELLION_DIR . '/inc/post-types.php';

/**
 * Restrict the editor to the theme's own palette and sizes.
 * Stops the site drifting off-brand through ordinary content edits.
 */
function perellion_editor_restrictions(): void {
	remove_theme_support( 'core-block-patterns' );
}
add_action( 'after_setup_theme', 'perellion_editor_restrictions' );
