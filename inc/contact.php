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
	if ( ! isset( $_POST['rabeya_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rabeya_contact_nonce'] ) ), 'rabeya_contact' ) ) {
		wp_safe_redirect( home_url( '/contact/?contact_sent=0' ) );
		exit;
	}

	$name    = isset( $_POST['ct_name'] ) ? sanitize_text_field( wp_unslash( $_POST['ct_name'] ) ) : '';
	$phone   = isset( $_POST['ct_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['ct_phone'] ) ) : '';
	$email   = isset( $_POST['ct_email'] ) ? sanitize_email( wp_unslash( $_POST['ct_email'] ) ) : '';
	$message = isset( $_POST['ct_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['ct_message'] ) ) : '';

	if ( '' === $name || '' === $phone || '' === $message ) {
		wp_safe_redirect( home_url( '/contact/?contact_sent=0' ) );
		exit;
	}

	$body = sprintf(
		"New contact message\n\nName: %s\nPhone: %s\nEmail: %s\n\nMessage:\n%s",
		$name,
		$phone,
		$email,
		$message
	);

	$to      = rabeya_info( 'email' );
	$subject = 'Contact - ' . $name;
	$headers = $email ? array( 'Reply-To: ' . $email ) : array();

	wp_mail( $to, $subject, $body, $headers );

	wp_insert_post( array(
		'post_type'    => 'post',
		'post_status'  => 'draft',
		'post_title'   => 'Contact - ' . $name,
		'post_content' => $body,
	) );

	wp_safe_redirect( home_url( '/contact/?contact_sent=1' ) );
	exit;
}
add_action( 'admin_post_rabeya_contact', 'rabeya_handle_contact' );
add_action( 'admin_post_nopriv_rabeya_contact', 'rabeya_handle_contact' );
