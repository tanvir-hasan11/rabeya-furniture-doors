<?php
/**
 * Theme customizer: Rabeya Slider section.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default slides used before the admin configures any.
 *
 * @return array
 */
function rabeya_default_slides() {
	return array(
		array(
			'eyebrow'     => __( 'New arrival', 'rabeya' ),
			'title'       => __( 'Solid teak doors, crafted to your size', 'rabeya' ),
			'text'        => __( 'Seasoned wood, hand finished, delivered across Bangladesh.', 'rabeya' ),
			'button_text' => __( 'Explore doors', 'rabeya' ),
			'button_url'  => home_url( '/' ),
			'image'       => '',
		),
		array(
			'eyebrow'     => __( 'Living room', 'rabeya' ),
			'title'       => __( 'Complete sofa and table sets', 'rabeya' ),
			'text'        => __( 'Save up to 20% on full living room packages this month.', 'rabeya' ),
			'button_text' => __( 'Shop furniture', 'rabeya' ),
			'button_url'  => home_url( '/' ),
			'image'       => '',
		),
	);
}

/**
 * Resolve slides from customizer settings, falling back to defaults.
 *
 * @return array
 */
function rabeya_get_slides() {
	$slides = array();

	for ( $i = 1; $i <= 4; $i++ ) {
		$title = get_theme_mod( "rabeya_slide_{$i}_title", '' );

		if ( '' === $title ) {
			continue;
		}

		$slides[] = array(
			'eyebrow'     => get_theme_mod( "rabeya_slide_{$i}_eyebrow", '' ),
			'title'       => $title,
			'text'        => get_theme_mod( "rabeya_slide_{$i}_text", '' ),
			'button_text' => get_theme_mod( "rabeya_slide_{$i}_button_text", '' ),
			'button_url'  => get_theme_mod( "rabeya_slide_{$i}_button_url", '' ),
			'image'       => get_theme_mod( "rabeya_slide_{$i}_image", '' ),
		);
	}

	/**
	 * Filter the resolved slider slides.
	 *
	 * @param array $slides Slide data.
	 */
	$slides = apply_filters( 'rabeya_slides', $slides );

	return $slides ? $slides : rabeya_default_slides();
}

/**
 * Register customizer settings.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 */
function rabeya_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'rabeya_slider', array(
		'title'    => __( 'Rabeya Slider', 'rabeya' ),
		'priority' => 30,
	) );

	for ( $i = 1; $i <= 4; $i++ ) {
		$fields = array(
			"rabeya_slide_{$i}_eyebrow"     => __( 'Eyebrow text', 'rabeya' ),
			"rabeya_slide_{$i}_title"       => __( 'Title', 'rabeya' ),
			"rabeya_slide_{$i}_text"        => __( 'Description', 'rabeya' ),
			"rabeya_slide_{$i}_button_text" => __( 'Button text', 'rabeya' ),
			"rabeya_slide_{$i}_button_url"  => __( 'Button URL', 'rabeya' ),
		);

		foreach ( $fields as $setting => $label ) {
			$wp_customize->add_setting( $setting, array(
				'default'           => '',
				'sanitize_callback' => 'rabeya_slide_{$i}_button_url' === $setting ? 'esc_url_raw' : 'sanitize_text_field',
				'transport'         => 'refresh',
			) );
			$wp_customize->add_control( $setting, array(
				'label'   => sprintf( __( 'Slide %1$d - %2$s', 'rabeya' ), $i, $label ),
				'section' => 'rabeya_slider',
				'type'    => 'text',
			) );
		}

		$wp_customize->add_setting( "rabeya_slide_{$i}_image", array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control(
			$wp_customize,
			"rabeya_slide_{$i}_image",
			array(
				'label'   => sprintf( __( 'Slide %d - background image', 'rabeya' ), $i ),
				'section' => 'rabeya_slider',
			)
		) );
	}
}
add_action( 'customize_register', 'rabeya_customize_register' );
