<?php
/**
 * Plugin Name: Default Mail Provider Configuration
 * Description: Configures info@spiritassemblychurch.com as the default outgoing and incoming email address and enables SMTP configuration.
 * Version: 1.0.0
 * Author: SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

const SAC_DEFAULT_EMAIL = 'info@spiritassemblychurch.com';

/**
 * Filter default From email address for all wp_mail calls.
 */
add_filter( 'wp_mail_from', static function ( string $email ): string {
	// If WordPress defaults to wordpress@ or if empty, use the church email.
	if ( empty( $email ) || str_starts_with( $email, 'wordpress@' ) ) {
		return SAC_DEFAULT_EMAIL;
	}
	return $email;
}, 999 );

/**
 * Filter default From display name for all wp_mail calls.
 */
add_filter( 'wp_mail_from_name', static function ( string $name ): string {
	if ( empty( $name ) || 'WordPress' === $name ) {
		$site_name = get_bloginfo( 'name' );
		return ! empty( $site_name ) ? $site_name : 'Spirit Assembly Church';
	}
	return $name;
}, 999 );

/**
 * Fallback admin_email option to SAC_DEFAULT_EMAIL if unset or empty.
 */
add_filter( 'option_admin_email', static function ( mixed $value ): string {
	$email = is_string( $value ) ? trim( $value ) : '';
	return ! empty( $email ) ? $email : SAC_DEFAULT_EMAIL;
} );

/**
 * Configure PHPMailer instance for info@spiritassemblychurch.com and optional SMTP.
 */
add_action( 'phpmailer_init', static function ( $phpmailer ): void {
	if ( empty( $phpmailer->From ) || str_starts_with( (string) $phpmailer->From, 'wordpress@' ) ) {
		$phpmailer->From = SAC_DEFAULT_EMAIL;
	}

	if ( empty( $phpmailer->FromName ) || 'WordPress' === $phpmailer->FromName ) {
		$phpmailer->FromName = get_bloginfo( 'name' ) ?: 'Spirit Assembly Church';
	}

	// Support SMTP configuration if constants are defined in wp-config.php
	if ( defined( 'SMTP_HOST' ) && constant( 'SMTP_HOST' ) ) {
		$phpmailer->isSMTP();
		$phpmailer->Host       = (string) constant( 'SMTP_HOST' );
		$phpmailer->Port       = defined( 'SMTP_PORT' ) ? (int) constant( 'SMTP_PORT' ) : 587;
		$phpmailer->SMTPSecure = defined( 'SMTP_SECURE' ) ? (string) constant( 'SMTP_SECURE' ) : 'tls';
		$phpmailer->SMTPAuth   = defined( 'SMTP_AUTH' ) ? (bool) constant( 'SMTP_AUTH' ) : true;
		$phpmailer->Username   = defined( 'SMTP_USER' ) ? (string) constant( 'SMTP_USER' ) : SAC_DEFAULT_EMAIL;
		if ( defined( 'SMTP_PASS' ) ) {
			$phpmailer->Password = (string) constant( 'SMTP_PASS' );
		}
	}
} );
