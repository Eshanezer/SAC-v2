<?php
/**
 * Secure native contact form handling.
 *
 * @package SAC
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Process the public contact form and redirect with a status code.
 */
function sac_handle_contact_form(): void {
	$redirect = wp_get_referer() ?: sac_page_url( 'contact' );

	if ( ! isset( $_POST['sac_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sac_contact_nonce'] ) ), 'sac_contact_form' ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'security', $redirect ) );
		exit;
	}

	if ( ! empty( $_POST['website'] ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'success', $redirect ) );
		exit;
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['contact_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['contact_email'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['contact_phone'] ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );

	if ( '' === $name || ! is_email( $email ) || '' === $message ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'invalid', $redirect ) );
		exit;
	}

	$rate_key = 'sac_contact_' . md5( sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) ) );

	if ( get_transient( $rate_key ) ) {
		wp_safe_redirect( add_query_arg( 'contact-status', 'rate', $redirect ) );
		exit;
	}

	$page       = get_page_by_path( 'contact' );
	$recipient  = (string) sac_field( 'sac_contact_email', (string) get_option( 'admin_email' ), $page instanceof WP_Post ? $page->ID : 0 );
	$mail_title = sprintf( '[%s] %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $subject ?: __( 'Website enquiry', 'sac' ) );
	$mail_body  = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\n{$message}";
	$headers    = array( 'Reply-To: ' . $name . ' <' . $email . '>' );
	$sent       = wp_mail( sanitize_email( $recipient ), $mail_title, $mail_body, $headers );

	if ( $sent ) {
		set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
	}

	wp_safe_redirect( add_query_arg( 'contact-status', $sent ? 'success' : 'failed', $redirect ) . '#contact-form' );
	exit;
}
add_action( 'admin_post_nopriv_sac_contact', 'sac_handle_contact_form' );
add_action( 'admin_post_sac_contact', 'sac_handle_contact_form' );
