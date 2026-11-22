<?php
/**
 * Plugin Name: Site Security Hardening & De-identification
 * Description: Hardens site security and strips WordPress identifying footprints from headers, markup, and API endpoints.
 * Version: 1.0.0
 * Author: Security Hardening
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ------------------------------------------------------------------------
 * 1. REMOVE WORDPRESS HEAD METADATA & FINGERPRINTS
 * ------------------------------------------------------------------------
 */

// 1.1 Remove WordPress generator tag and generator string
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );

// 1.2 Remove RSD (Really Simple Discovery) link
remove_action( 'wp_head', 'rsd_link' );

// 1.3 Remove Windows Live Writer manifest link
remove_action( 'wp_head', 'wlwmanifest_link' );

// 1.4 Remove REST API discovery links in head and HTTP headers
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// 1.5 Remove WordPress Shortlink from head and HTTP headers
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );

// 1.6 Remove adjacent posts rel links
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

/**
 * ------------------------------------------------------------------------
 * 2. DISABLE WORDPRESS EMOJIS & PREFETCHES
 * ------------------------------------------------------------------------
 */
add_action( 'init', static function (): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter( 'tiny_mce_plugins', static function ( $plugins ) {
		return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
	} );

	// Remove s.w.org dns-prefetch link
	add_filter( 'wp_resource_hints', static function ( array $urls, string $relation_type ): array {
		if ( 'dns-prefetch' === $relation_type ) {
			$urls = array_filter(
				$urls,
				static fn( $url ) => ! str_contains( (string) $url, 's.w.org' )
			);
		}
		return array_values( $urls );
	}, 10, 2 );
} );

/**
 * ------------------------------------------------------------------------
 * 3. STRIP WORDPRESS VERSION STRINGS FROM ASSETS
 * ------------------------------------------------------------------------
 */
function sac_remove_version_strings( string $src ): string {
	global $wp_version;
	if ( ! empty( $wp_version ) && str_contains( $src, 'ver=' . $wp_version ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
add_filter( 'style_loader_src', 'sac_remove_version_strings', 9999 );
add_filter( 'script_loader_src', 'sac_remove_version_strings', 9999 );

/**
 * ------------------------------------------------------------------------
 * 4. DISABLE XML-RPC & PINGBACKS
 * ------------------------------------------------------------------------
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_empty_array' );
add_filter( 'wp_headers', static function ( array $headers ): array {
	unset( $headers['X-Pingback'] );
	return $headers;
} );

/**
 * ------------------------------------------------------------------------
 * 5. USER ENUMERATION PROTECTION
 * ------------------------------------------------------------------------
 */

// 5.1 Block author archive scans via query parameter (?author=N)
add_action( 'template_redirect', static function (): void {
	if ( ! is_admin() && ( is_author() || isset( $_GET['author'] ) ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );

// 5.2 Restrict REST API user enumeration (/wp-json/wp/v2/users) to users with 'list_users' cap
add_filter( 'rest_endpoints', static function ( array $endpoints ): array {
	if ( ! current_user_can( 'list_users' ) ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
	}
	return $endpoints;
} );

/**
 * ------------------------------------------------------------------------
 * 6. SECURITY: OBFUSCATE LOGIN FAILURE MESSAGES
 * ------------------------------------------------------------------------
 * Stops attackers from discovering whether a specific username exists.
 */
add_filter( 'login_errors', static function (): string {
	return __( 'Invalid login credentials.', 'sac' );
} );

/**
 * ------------------------------------------------------------------------
 * 7. CLEAN UP IDENTIFYING BODY CLASSES & SCRIPTS
 * ------------------------------------------------------------------------
 */
// 7.1 Deregister wp-embed
add_action( 'wp_footer', static function (): void {
	wp_deregister_script( 'wp-embed' );
} );

// 7.2 Remove giveaway WordPress body classes on frontend
add_filter( 'body_class', static function ( array $classes ): array {
	$remove = array(
		'page-template-default',
		'wp-custom-logo',
		'wp-embed-responsive',
	);
	return array_values( array_diff( $classes, $remove ) );
} );

// 7.3 Hide WordPress version from admin footer
add_filter( 'update_footer', '__return_empty_string', 9999 );
add_filter( 'admin_footer_text', '__return_empty_string', 9999 );
