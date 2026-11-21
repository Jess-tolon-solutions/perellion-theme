<?php
/**
 * Redirect map for URLs that change with the rebuild.
 *
 * The three post types keep production's URL shape (/meet-the-team/<slug>/,
 * /case-studies/<slug>/, /join-the-team/<slug>/), so single posts need no
 * redirect. What changes:
 *
 *  - the old category archives (/category/meet-the-team/ etc.) become the
 *    post type archives at the same top-level path;
 *  - /aerospace-defense/ goes to the home page, as Reese Allen asked on the
 *    Monday thread "Aerospace and Defense page" (20 Nov 2026).
 *
 * Add a line to $map for any further legacy URL. Paths are matched without
 * their query string and trailing slash.
 */
add_action( 'template_redirect', 'perellion_legacy_redirects', 1 );
function perellion_legacy_redirects(): void {
	$map = array(
		'/category/meet-the-team'  => '/meet-the-team/',
		'/category/case-studies'   => '/case-studies/',
		'/category/join-the-team'  => '/join-the-team/',
		'/aerospace-defense'       => '/',
	);
	$path = rtrim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
	if ( $path === '' || ! isset( $map[ $path ] ) ) {
		return;
	}
	wp_safe_redirect( home_url( $map[ $path ] ), 301 );
	exit;
}
