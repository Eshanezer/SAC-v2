<?php
/**
 * SAC theme bootstrap file.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAC_THEME_VERSION', '0.3.0' );
define( 'SAC_BOOTSTRAP_VERSION', '5.3.8' );

$sac_includes = array(
	'/inc/setup.php',
	'/inc/settings.php',
	'/inc/helpers.php',
	'/inc/navigation.php',
	'/inc/contact.php',
	'/inc/post-types.php',
	'/inc/acf.php',
);

foreach ( $sac_includes as $sac_include ) {
	require_once get_template_directory() . $sac_include;
}
