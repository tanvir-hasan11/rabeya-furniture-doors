<?php
/**
 * Custom order form handler.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handle the custom measurement request.
 */
function rabeya_handle_custom_order() {
	if ( ! isset( $_POST['rabeya_custom_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rabeya_custom_nonce'] ) ), 'rabeya_custom_order' ) ) {
		wp_safe_redirect( home_url( '/custom/?custom_sent=0' ) );
		exit;
	}

	$name   = isset( $_POST['co_name'] ) ? sanitize_text_field( wp_unslash( $_POST['co_name'] ) ) : '';
	$phone  = isset( $_POST['co_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['co_phone'] ) ) : '';
	$type   = isset( $_POST['co_type'] ) ? sanitize_text_field( wp_unslash( $_POST['co_type'] ) ) : '';
	$width  = isset( $_POST['co_width'] ) ? sanitize_text_field( wp_unslash( $_POST['co_width'] ) ) : '';
	$height = isset( $_POST['co_height'] ) ? sanitize_text_field( wp_unslash( $_POST['co_height'] ) ) : '';
	$notes  = isset( $_POST['co_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['co_notes'] ) ) : '';

	if ( '' === $name || '' === $phone ) {
		wp_safe_redirect( home_url( '/custom/?custom_sent=0' ) );
		exit;
	}

	$body = sprintf(
		"New custom order request\n\nName: %s\nPhone: %s\nProduct: %s\nWidth: %s\nHeight: %s\nNotes: %s",
		$name,
		$phone,
		$type,
		$width,
		$height,
		$notes
	);

	$to      = rabeya_info( 'email' );
	$subject = 'Custom order - ' . $name;

	wp_mail( $to, $subject, $body );

	// Store as a draft post so nothing is lost even if mail fails.
	wp_insert_post( array(
		'post_type'    => 'post',
		'post_status'  => 'draft',
		'post_title'   => 'Custom order - ' . $name,
		'post_content' => $body,
	) );

	wp_safe_redirect( home_url( '/custom/?custom_sent=1' ) );
	exit;
}
add_action( 'admin_post_rabeya_custom_order', 'rabeya_handle_custom_order' );
add_action( 'admin_post_nopriv_rabeya_custom_order', 'rabeya_handle_custom_order' );
