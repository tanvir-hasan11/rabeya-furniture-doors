<?php
/**
 * Contact form handler.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle the contact form submission.
 */
function rabeya_handle_contact() {
	$redirect = home_url( '/contact/' );
	if ( ! isset( $_POST['rabeya_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rabeya_contact_nonce'] ) ), 'rabeya_contact' ) ) {
		rabeya_submission_reject( $redirect, '0' );
	}
	if ( rabeya_submission_honeypot_filled() || rabeya_submission_is_rate_limited( 'contact' ) ) {
		rabeya_submission_reject( $redirect, '0' );
	}

	$name    = isset( $_POST['ct_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ct_name'] ) ) : '';
	$phone   = isset( $_POST['ct_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['ct_phone'] ) ) : '';
	$email   = isset( $_POST['ct_email'] ) ? sanitize_email( wp_unslash( $_POST['ct_email'] ) ) : '';
	$message = isset( $_POST['ct_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ct_message'] ) ) : '';

	if ( '' === $name || '' === $phone || '' === $message || ( $email && ! is_email( $email ) ) ) {
		rabeya_submission_reject( $redirect, '0' );
	}

	$body = sprintf( "New contact message\n\nName: %s\nPhone: %s\nEmail: %s\n\nMessage:\n%s", $name, $phone, $email, $message );
	$to      = sanitize_email( rabeya_info( 'email' ) );
	$subject = 'Contact - ' . $name;
	$headers = $email ? array( 'Reply-To: ' . $email ) : array();
	$mailed  = $to && wp_mail( $to, $subject, $body, $headers );

	$post_id = wp_insert_post( array(
		'post_type'    => 'rabeya_inquiry',
		'post_status'  => 'private',
		'post_title'   => 'Contact - ' . $name,
		'post_content' => $body,
	), true );
	if ( is_wp_error( $post_id ) ) {
		rabeya_submission_reject( $redirect, '0' );
	}
	update_post_meta( $post_id, '_rabeya_inquiry_type', 'contact' );
	update_post_meta( $post_id, '_rabeya_mail_sent', $mailed ? '1' : '0' );

	// A failed mail is still retained privately for admin follow-up.
	wp_safe_redirect( add_query_arg( 'contact_sent', $mailed ? '1' : '0', $redirect ) );
	exit;
}
add_action( 'admin_post_rabeya_contact', 'rabeya_handle_contact' );
add_action( 'admin_post_nopriv_rabeya_contact', 'rabeya_handle_contact' );
