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
}

// ---------------------------------------------------------------------
// 3. Database Settings
// ---------------------------------------------------------------------
define( 'DB_NAME',     env( 'DB_NAME', 'local' ) );
define( 'DB_USER',     env( 'DB_USER', 'root' ) );
define( 'DB_PASSWORD', env( 'DB_PASSWORD', 'root' ) );
define( 'DB_HOST',     env( 'DB_HOST', 'localhost' ) );
define( 'DB_CHARSET',  env( 'DB_CHARSET', 'utf8' ) );
define( 'DB_COLLATE',  env( 'DB_COLLATE', '' ) );

// ---------------------------------------------------------------------
// 4. Authentication Unique Keys and Salts
// ---------------------------------------------------------------------
define( 'AUTH_KEY',          env( 'AUTH_KEY', 'G,J_Y`ze(}8qNie@ab_#uPn*815lSTo`6YY5kZ<ok5-b.1_xFt7})5qF(%g0L&Pt' ) );
define( 'SECURE_AUTH_KEY',   env( 'SECURE_AUTH_KEY', 'R{4S}eQ*etu<x:jFp{qhY/|jr`CVA<D>-*/L1 xSKaYn2tCB9+5.6q[eB13m`:xb' ) );
define( 'LOGGED_IN_KEY',     env( 'LOGGED_IN_KEY', 'km7W:v9&I[kOnG9X|XiHR.,U.bLG{hxEly35kMX=bM>:AZ9YuMELJCwJ_QQv,7{)' ) );
define( 'NONCE_KEY',         env( 'NONCE_KEY', 'oZWob.RG+d2]+jnb(/T/VK^}|(r&2b`PG1jQWF$SMT(}g6;cj{^{keG#n>^5)36O' ) );
define( 'AUTH_SALT',         env( 'AUTH_SALT', 'iD[@fd{iyX{*4+Fg4>(bdJwvF?tMQ~PnF`)UgEaQ*`oU`$+Oj*%7eSKHc1q@PN;X' ) );
define( 'SECURE_AUTH_SALT',  env( 'SECURE_AUTH_SALT', '+:$|dGsem3go~+(3j>B % j/>T<oT%q1A)bBc*8&#=/=li9,?F8m2T}@UpeM c:r' ) );
define( 'LOGGED_IN_SALT',    env( 'LOGGED_IN_SALT', 'xdt8pm0~Ha$$@x|y<Il/]/^SN2_jc_}oO/xR?5gl12tnqxF]~9bx!)o~<a)_bd@4' ) );
define( 'NONCE_SALT',        env( 'NONCE_SALT', 'K1!M>DqU5H{4asrr/%BfRcEHrC9:iQTR?zP7HQMNK5f,*^w}qAvFzd+UeKx[yM!K' ) );
define( 'WP_CACHE_KEY_SALT', env( 'WP_CACHE_KEY_SALT', 'hS;{E5Xk.et_MYWtyso43]6%C;bE-%N6|fbKd:z7T]u;8,qk>Xz(};l5{1exjE?W' ) );

// ---------------------------------------------------------------------
// 5. Database Table Prefix
// ---------------------------------------------------------------------
$table_prefix = env( 'DB_TABLE_PREFIX', 'wp_' );

// ---------------------------------------------------------------------
// 6. Debugging & Environment Settings
// ---------------------------------------------------------------------
define( 'WP_ENVIRONMENT_TYPE', env( 'WP_ENVIRONMENT_TYPE', 'local' ) );

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
