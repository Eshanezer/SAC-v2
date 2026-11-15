<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'f6vsvy_db0' );

/** Database username */
define( 'DB_USER', 'f6vsvy_0' );

/** Database password */
define( 'DB_PASSWORD', 'f4#Q)1HZk2i-' );

/** Database hostname */
define( 'DB_HOST', 'mt7g.your-database.de' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'G,J_Y`ze(}8qNie@ab_#uPn*815lSTo`6YY5kZ<ok5-b.1_xFt7})5qF(%g0L&Pt' );
define( 'SECURE_AUTH_KEY',   'R{4S}eQ*etu<x:jFp{qhY/|jr`CVA<D>-*/L1 xSKaYn2tCB9+5.6q[eB13m`:xb' );
define( 'LOGGED_IN_KEY',     'km7W:v9&I[kOnG9X|XiHR.,U.bLG{hxEly35kMX=bM>:AZ9YuMELJCwJ_QQv,7{)' );
define( 'NONCE_KEY',         'oZWob.RG+d2]+jnb(/T/VK^}|(r&2b`PG1jQWF$SMT(}g6;cj{^{keG#n>^5)36O' );
define( 'AUTH_SALT',         'iD[@fd{iyX{*4+Fg4>(bdJwvF?tMQ~PnF`)UgEaQ*`oU`$+Oj*%7eSKHc1q@PN;X' );
define( 'SECURE_AUTH_SALT',  '+:$|dGsem3go~+(3j>B % j/>T<oT%q1A)bBc*8&#=/=li9,?F8m2T}@UpeM c:r' );
define( 'LOGGED_IN_SALT',    'xdt8pm0~Ha$$@x|y<Il/]/^SN2_jc_}oO/xR?5gl12tnqxF]~9bx!)o~<a)_bd@4' );
define( 'NONCE_SALT',        'K1!M>DqU5H{4asrr/%BfRcEHrC9:iQTR?zP7HQMNK5f,*^w}qAvFzd+UeKx[yM!K' );
define( 'WP_CACHE_KEY_SALT', 'hS;{E5Xk.et_MYWtyso43]6%C;bE-%N6|fbKd:z7T]u;8,qk>Xz(};l5{1exjE?W' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );


define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'spiritassemblychurch.com' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
