<?php
/**
 * Custom order form handler.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rabeya_handle_custom_order() {
	$redirect = home_url( '/custom/' );
	if ( ! isset( $_POST['rabeya_custom_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rabeya_custom_nonce'] ) ), 'rabeya_custom_order' ) ) {
		rabeya_submission_reject( $redirect, 'nonce' );
	}
	if ( rabeya_submission_honeypot_filled() || rabeya_submission_is_rate_limited( 'custom_order' ) ) {
		rabeya_submission_reject( $redirect, 'spam' );
	}

	$name   = isset( $_POST['co_name'] ) ? sanitize_text_field( wp_unslash( $_POST['co_name'] ) ) : '';
	$phone  = isset( $_POST['co_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['co_phone'] ) ) : '';
	$type   = isset( $_POST['co_type'] ) ? sanitize_text_field( wp_unslash( $_POST['co_type'] ) ) : '';
	$width  = isset( $_POST['co_width'] ) ? sanitize_text_field( wp_unslash( $_POST['co_width'] ) ) : '';
	$height = isset( $_POST['co_height'] ) ? sanitize_text_field( wp_unslash( $_POST['co_height'] ) ) : '';
	$notes  = isset( $_POST['co_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['co_notes'] ) ) : '';

	if ( '' === $name || '' === $phone ) {
		rabeya_submission_reject( $redirect, 'invalid' );
	}

	$body = sprintf( "New custom order request\n\nName: %s\nPhone: %s\nProduct: %s\nWidth: %s\nHeight: %s\nNotes: %s", $name, $phone, $type, $width, $height, $notes );
	$to     = sanitize_email( rabeya_info( 'email' ) );
	$mailed = $to && wp_mail( $to, 'Custom order - ' . $name, $body );
	$post_id = wp_insert_post( array(
		'post_type'    => 'rabeya_inquiry',
		'post_status'  => 'private',
		'post_title'   => 'Custom order - ' . $name,
		'post_content' => $body,
	), true );
	if ( is_wp_error( $post_id ) ) {
		rabeya_submission_reject( $redirect, 'error' );
	}
	update_post_meta( $post_id, '_rabeya_inquiry_type', 'custom_order' );
	update_post_meta( $post_id, '_rabeya_mail_sent', $mailed ? '1' : '0' );

	wp_safe_redirect( add_query_arg( 'sent', $mailed ? '1' : 'mail_fail', $redirect ) );
	exit;
}
add_action( 'admin_post_rabeya_custom_order', 'rabeya_handle_custom_order' );
add_action( 'admin_post_nopriv_rabeya_custom_order', 'rabeya_handle_custom_order' );
