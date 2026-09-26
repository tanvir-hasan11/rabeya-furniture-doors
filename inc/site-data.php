<?php
/**
 * Single source of truth for Rabeya Furniture & Doors business data.
 *
 * Every value can be overridden from Appearance -> Customize -> Rabeya Business Info.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default business info.
 *
 * @return array
 */
function rabeya_business_defaults() {
	return array(
		'phone'     => '01814-116643',
		'phone_raw' => '8801814116643',
		'whatsapp'  => '8801814116643',
		'email'     => 'rabeyadoorctg@gmail.com',
		'facebook'  => 'https://www.facebook.com/RabeyaFurnitureandDoor',
		'address'   => 'হালিশহর, তাসফিয়া কমিউনিটি সেন্টার গেট, ২৫ নং রামপুর, চট্টগ্রাম',
		'city'      => 'চট্টগ্রাম',
		'hours'     => 'প্রতিদিন সকাল ৯টা - রাত ৯টা',
	);
}

/**
 * Get one piece of business info.
 *
 * @param string $key     Field key.
 * @param string $default Fallback.
 * @return string
 */
function rabeya_info( $key, $default = '' ) {
	$defaults = rabeya_business_defaults();
	$fallback = isset( $defaults[ $key ] ) ? $defaults[ $key ] : $default;

	return get_theme_mod( 'rabeya_info_' . $key, $fallback );
}

/**
 * Business info customizer section.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function rabeya_business_customize( $wp_customize ) {
	$wp_customize->add_section( 'rabeya_business', array(
		'title'    => __( 'Rabeya Business Info', 'rabeya' ),
		'priority' => 28,
	) );

	$fields = array(
		'phone'     => __( 'Phone (display)', 'rabeya' ),
		'phone_raw' => __( 'Phone (digits, for tel: link)', 'rabeya' ),
		'whatsapp'  => __( 'WhatsApp number (digits only)', 'rabeya' ),
		'email'     => __( 'Email', 'rabeya' ),
		'facebook'  => __( 'Facebook page URL', 'rabeya' ),
		'address'   => __( 'Showroom address', 'rabeya' ),
		'hours'     => __( 'Opening hours', 'rabeya' ),
	);

	foreach ( $fields as $key => $label ) {
		$wp_customize->add_setting( 'rabeya_info_' . $key, array(
			'default'           => '',
			'sanitize_callback' => in_array( $key, array( 'facebook' ), true ) ? 'esc_url_raw' : 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'rabeya_info_' . $key, array(
			'label'   => $label,
			'section' => 'rabeya_business',
			'type'    => 'text',
		) );
	}
}
add_action( 'customize_register', 'rabeya_business_customize' );
