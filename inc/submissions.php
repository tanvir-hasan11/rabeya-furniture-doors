<?php
/**
 * Private storage for contact and custom-order enquiries.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function rabeya_register_inquiry_post_type() {
	register_post_type( 'rabeya_inquiry', array(
		'labels' => array(
			'name'          => __( 'Customer Enquiries', 'rabeya' ),
			'singular_name' => __( 'Customer Enquiry', 'rabeya' ),
		),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'supports'            => array( 'title', 'editor' ),
		'capability_type'     => 'post',
		'map_meta_cap'        => true,
		'has_archive'         => false,
		'rewrite'             => false,
		'query_var'           => false,
		'show_in_rest'        => false,
	) );
}
add_action( 'init', 'rabeya_register_inquiry_post_type' );

function rabeya_submission_is_rate_limited( $action ) {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
	$key = 'rabeya_' . md5( $action . '|' . $ip );
	if ( get_transient( $key ) ) {
		return true;
	}
	set_transient( $key, 1, MINUTE_IN_SECONDS );
	return false;
}

function rabeya_submission_reject( $url, $code = '0' ) {
	wp_safe_redirect( add_query_arg( 'sent', $code, $url ) );
	exit;
}

function rabeya_submission_honeypot_filled() {
	return ! empty( $_POST['rabeya_website'] );
}
