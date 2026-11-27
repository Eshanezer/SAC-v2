<?php
/**
 * The base configuration for WordPress
 *
 * Configured to dynamically load environment settings from .env files
 * (.env for local development, .env.production for production server).
 *
 * @package WordPress
 */

// ---------------------------------------------------------------------
// 1. Lightweight, zero-dependency .env loader
// ---------------------------------------------------------------------
if ( ! function_exists( 'sac_load_env' ) ) {
	/**
	 * Parse and load key-value pairs from an environment file.
	 */
	function sac_load_env( string $path ): void {
		if ( ! file_exists( $path ) || ! is_readable( $path ) ) {
			return;
		}

		$lines = file( $path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );
		if ( false === $lines ) {
			return;
		}

		foreach ( $lines as $line ) {
			$line = trim( $line );

			// Skip empty lines and comment lines
			if ( '' === $line || str_starts_with( $line, '#' ) ) {
				continue;
			}

			// Strip optional 'export ' prefix
			if ( str_starts_with( $line, 'export ' ) ) {
				$line = trim( substr( $line, 7 ) );
			}

			$parts = explode( '=', $line, 2 );
			if ( 2 !== count( $parts ) ) {
				continue;
			}

			$key   = trim( $parts[0] );
			$value = trim( $parts[1] );

			if ( '' === $key ) {
				continue;
			}

			// Handle quoted and unquoted values
			if ( ( str_starts_with( $value, '"' ) && str_ends_with( $value, '"' ) )
				|| ( str_starts_with( $value, "'" ) && str_ends_with( $value, "'" ) ) ) {
				$value = substr( $value, 1, -1 );
			} else {
				$hash_pos = strpos( $value, ' #' );
				if ( false !== $hash_pos ) {
					$value = trim( substr( $value, 0, $hash_pos ) );
				}
			}

			$_ENV[ $key ]    = $value;
			$_SERVER[ $key ] = $value;
			putenv( "{$key}={$value}" );
		}
	}
}

if ( ! function_exists( 'env' ) ) {
	/**
	 * Retrieve environment variable with type-casting and default fallback.
	 */
	function env( string $key, mixed $default = null ): mixed {
		$value = $_ENV[ $key ] ?? $_SERVER[ $key ] ?? getenv( $key );

		if ( false === $value || null === $value ) {
			return $default;
		}

		return match ( strtolower( (string) $value ) ) {
			'true', '(true)'   => true,
			'false', '(false)' => false,
			'null', '(null)'   => null,
			'empty', '(empty)' => '',
			default            => $value,
		};
	}
}

// ---------------------------------------------------------------------
// 2. Discover and load appropriate .env file
// ---------------------------------------------------------------------
$wp_env_type = getenv( 'WP_ENV' ) ?: getenv( 'WP_ENVIRONMENT_TYPE' );

if ( $wp_env_type && file_exists( __DIR__ . '/.env.' . $wp_env_type ) ) {
	// Specific environment file (e.g. .env.production)
	sac_load_env( __DIR__ . '/.env.' . $wp_env_type );
} elseif ( file_exists( __DIR__ . '/.env' ) ) {
	// Default .env (local)
	sac_load_env( __DIR__ . '/.env' );
	if ( file_exists( __DIR__ . '/.env.local' ) ) {
		sac_load_env( __DIR__ . '/.env.local' );
	}
} elseif ( file_exists( __DIR__ . '/.env.production' ) ) {
	// Production server fallback
	sac_load_env( __DIR__ . '/.env.production' );
	$wp_env_type = 'production';
}

// ---------------------------------------------------------------------
// 3. Database Settings
// ---------------------------------------------------------------------
$environment = env( 'WP_ENVIRONMENT_TYPE', $wp_env_type ?: 'local' );
$is_local = in_array( $environment, array( 'local', 'development' ), true );
$db_name = env( 'DB_NAME', $is_local ? 'local' : null );
$db_user = env( 'DB_USER', $is_local ? 'root' : null );
$db_password = env( 'DB_PASSWORD', $is_local ? 'root' : null );

if ( ! $is_local && ( ! $db_name || ! $db_user || ! $db_password || 'root' === strtolower( (string) $db_user ) ) ) {
	http_response_code( 503 );
	exit( 'Database configuration is incomplete.' );
}

define( 'DB_NAME',     $db_name );
define( 'DB_USER',     $db_user );
define( 'DB_PASSWORD', $db_password );
define( 'DB_HOST',     env( 'DB_HOST', 'localhost' ) );
define( 'DB_CHARSET',  env( 'DB_CHARSET', 'utf8' ) );
define( 'DB_COLLATE',  env( 'DB_COLLATE', '' ) );

// ---------------------------------------------------------------------
// 4. Authentication Unique Keys and Salts
// ---------------------------------------------------------------------

// WordPress generates per-installation salts when the keys are omitted.
foreach ( array( 'AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT', 'WP_CACHE_KEY_SALT' ) as $key ) {
	$value = env( $key );
	if ( is_string( $value ) && '' !== trim( $value ) ) {
		define( $key, $value );
	}
}

// ---------------------------------------------------------------------
// 5. Database Table Prefix
// ---------------------------------------------------------------------
$table_prefix = env( 'DB_TABLE_PREFIX', 'wp_' );

// ---------------------------------------------------------------------
// 6. Debugging & Environment Settings
// ---------------------------------------------------------------------
define( 'WP_ENVIRONMENT_TYPE', $environment );

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', (bool) env( 'WP_DEBUG', false ) );
}
if ( ! defined( 'WP_DEBUG_LOG' ) ) {
	define( 'WP_DEBUG_LOG', (bool) env( 'WP_DEBUG_LOG', false ) );
}
if ( ! defined( 'WP_DEBUG_DISPLAY' ) ) {
	define( 'WP_DEBUG_DISPLAY', (bool) env( 'WP_DEBUG_DISPLAY', false ) );
}
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', (bool) env( 'DISALLOW_FILE_EDIT', true ) );
}
if ( ! defined( 'FORCE_SSL_ADMIN' ) && env( 'FORCE_SSL_ADMIN' ) !== null ) {
	define( 'FORCE_SSL_ADMIN', (bool) env( 'FORCE_SSL_ADMIN' ) );
}

// ---------------------------------------------------------------------
// 7. Optional SMTP Mail Provider Configuration
// ---------------------------------------------------------------------
if ( env( 'SMTP_HOST' ) ) {
	define( 'SMTP_HOST',   (string) env( 'SMTP_HOST' ) );
	define( 'SMTP_PORT',   (int) env( 'SMTP_PORT', 465 ) );
	define( 'SMTP_USER',   (string) env( 'SMTP_USER', 'info@spiritassemblychurch.com' ) );
	define( 'SMTP_PASS',   (string) env( 'SMTP_PASS', '' ) );
	define( 'SMTP_SECURE', (string) env( 'SMTP_SECURE', 'ssl' ) );
	define( 'SMTP_AUTH',   (bool) env( 'SMTP_AUTH', true ) );
}

// ---------------------------------------------------------------------
// 8. Multisite Configuration
// ---------------------------------------------------------------------
define( 'WP_ALLOW_MULTISITE',   (bool) env( 'WP_ALLOW_MULTISITE', true ) );
define( 'MULTISITE',            (bool) env( 'MULTISITE', true ) );
define( 'SUBDOMAIN_INSTALL',    (bool) env( 'SUBDOMAIN_INSTALL', true ) );
$base = env( 'PATH_CURRENT_SITE', '/' );
define( 'DOMAIN_CURRENT_SITE',  (string) env( 'DOMAIN_CURRENT_SITE', 'spiritassemblychurch.com' ) );
define( 'PATH_CURRENT_SITE',    (string) env( 'PATH_CURRENT_SITE', '/' ) );
define( 'SITE_ID_CURRENT_SITE', (int) env( 'SITE_ID_CURRENT_SITE', 1 ) );
define( 'BLOG_ID_CURRENT_SITE', (int) env( 'BLOG_ID_CURRENT_SITE', 1 ) );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
