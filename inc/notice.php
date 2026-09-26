<?php
/**
 * Notice bar + homepage notice strip.
 *
 * The notice bar text is managed from
 * Appearance -> Customize -> Rabeya Notice Bar.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register the notice bar customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function rabeya_notice_customize( $wp_customize ) {
	$wp_customize->add_section( 'rabeya_notice', array(
		'title'    => __( 'Rabeya Notice Bar', 'rabeya' ),
		'priority' => 32,
	) );

	$wp_customize->add_setting( 'rabeya_notice_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'rabeya_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'rabeya_notice_enabled', array(
		'label'   => __( 'Show the notice bar', 'rabeya' ),
		'section' => 'rabeya_notice',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'rabeya_notice_text', array(
		'default'           => __( 'Eid offer: 15% off on all custom doors until the end of this month.', 'rabeya' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rabeya_notice_text', array(
		'label'   => __( 'Notice text', 'rabeya' ),
		'section' => 'rabeya_notice',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'rabeya_notice_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'rabeya_notice_url', array(
		'label'       => __( 'Notice link (optional)', 'rabeya' ),
		'description' => __( 'Where the notice should link to.', 'rabeya' ),
		'section'     => 'rabeya_notice',
		'type'        => 'url',
	) );
}
add_action( 'customize_register', 'rabeya_notice_customize' );

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function rabeya_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Render the notice bar under the header.
 */
function rabeya_render_notice_bar() {
	if ( ! get_theme_mod( 'rabeya_notice_enabled', true ) ) {
		return;
	}

	$text = get_theme_mod( 'rabeya_notice_text', '' );

	if ( '' === $text ) {
		return;
	}

	$url = get_theme_mod( 'rabeya_notice_url', '' );

	echo '<div class="notice-bar"><div class="container notice-bar-inner">';
	echo '<span class="notice-bar-icon" aria-hidden="true">&#9733;</span>';

	if ( $url ) {
		printf( '<a href="%1$s">%2$s</a>', esc_url( $url ), esc_html( $text ) );
	} else {
		echo '<span>' . esc_html( $text ) . '</span>';
	}

	echo '</div></div>';
}
add_action( 'wp_body_open', 'rabeya_render_notice_bar', 5 );

/**
 * Latest notices for the homepage strip.
 *
 * @param int $limit How many posts.
 * @return WP_Post[]
 */
function rabeya_latest_notices( $limit = 3 ) {
	return get_posts( array(
		'post_type'           => 'post',
		'posts_per_page'      => $limit,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	) );
}
