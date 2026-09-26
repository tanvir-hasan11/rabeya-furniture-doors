<?php
/**
 * Product page customisation for furniture and doors.
 *
 * - Specifications table (wood type, finish, size, door hand)
 * - Custom "Delivery & Warranty" tab
 * - Trust badges under the add-to-cart button
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Attributes shown in the specification table, in order.
 *
 * Keys are matched case-insensitively against product attribute labels.
 *
 * @return array
 */
function rabeya_spec_attributes() {
	return apply_filters( 'rabeya_spec_attributes', array(
		'wood type' => __( 'Wood Type', 'rabeya' ),
		'finish'    => __( 'Finish', 'rabeya' ),
		'size'      => __( 'Size', 'rabeya' ),
		'door hand' => __( 'Door Hand', 'rabeya' ),
	) );
}

/**
 * Build the specification rows for a product.
 *
 * @param WC_Product $product Product object.
 * @return array List of [ label, value ] pairs.
 */
function rabeya_product_specs( $product ) {
	$rows = array();

	foreach ( $product->get_attributes() as $attribute ) {
		if ( ! $attribute->get_visible() ) {
			continue;
		}

		$label = wc_attribute_label( $attribute->get_name() );
		$key   = strtolower( $label );

		if ( ! array_key_exists( $key, rabeya_spec_attributes() ) ) {
			continue;
		}

		if ( $attribute->is_taxonomy() ) {
			$values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'names' ) );
		} else {
			$values = $attribute->get_options();
		}

		if ( empty( $values ) ) {
			continue;
		}

		$rows[] = array(
			'label' => $label,
			'value' => implode( ', ', $values ),
		);
	}

	// Dimensions (WooCommerce core fields).
	$dimensions = array_filter( array(
		$product->get_length(),
		$product->get_width(),
		$product->get_height(),
	) );

	if ( $dimensions ) {
		$unit   = get_option( 'woocommerce_dimension_unit' );
		$rows[] = array(
			'label' => __( 'Dimensions', 'rabeya' ),
			'value' => sprintf( '%1$s %2$s', implode( ' x ', $dimensions ), $unit ),
		);
	}

	return apply_filters( 'rabeya_product_specs', $rows, $product );
}

/**
 * Render the specification table after the add-to-cart form.
 */
function rabeya_render_specs_table() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$rows = rabeya_product_specs( $product );

	if ( empty( $rows ) ) {
		return;
	}

	echo '<section class="product-specs">';
	echo '<h3 class="product-specs-title">' . esc_html__( 'Specifications', 'rabeya' ) . '</h3>';
	echo '<table class="specs-table"><tbody>';

	foreach ( $rows as $row ) {
		printf(
			'<tr><th scope="row">%1$s</th><td>%2$s</td></tr>',
			esc_html( $row['label'] ),
			esc_html( $row['value'] )
		);
	}

	echo '</tbody></table>';
	echo '</section>';
}
add_action( 'woocommerce_single_product_summary', 'rabeya_render_specs_table', 25 );

/**
 * Trust badges under the short description.
 */
function rabeya_render_trust_badges() {
	$badges = apply_filters( 'rabeya_product_badges', array(
		__( 'Free delivery inside Dhaka', 'rabeya' ),
		__( '5 year warranty on wood', 'rabeya' ),
		__( 'Custom size available', 'rabeya' ),
		__( 'Cash on delivery', 'rabeya' ),
	) );

	if ( empty( $badges ) ) {
		return;
	}

	echo '<ul class="product-badges">';

	foreach ( $badges as $badge ) {
		echo '<li>' . esc_html( $badge ) . '</li>';
	}

	echo '</ul>';
}
add_action( 'woocommerce_single_product_summary', 'rabeya_render_trust_badges', 35 );

/**
 * Add a "Delivery & Warranty" tab to the product data tabs.
 *
 * @param array $tabs Existing tabs.
 * @return array
 */
function rabeya_product_tabs( $tabs ) {
	$tabs['rabeya_delivery'] = array(
		'title'    => __( 'Delivery & Warranty', 'rabeya' ),
		'priority' => 25,
		'callback' => 'rabeya_delivery_tab_content',
	);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'rabeya_product_tabs' );

/**
 * Content of the Delivery & Warranty tab.
 */
function rabeya_delivery_tab_content() {
	?>
	<h3><?php esc_html_e( 'Delivery', 'rabeya' ); ?></h3>
	<ul>
		<li><?php esc_html_e( 'Free delivery inside Dhaka for orders over 20,000 BDT.', 'rabeya' ); ?></li>
		<li><?php esc_html_e( 'Outside Dhaka: delivery charge depends on weight and distance.', 'rabeya' ); ?></li>
		<li><?php esc_html_e( 'Doors and large furniture are delivered by our own team.', 'rabeya' ); ?></li>
		<li><?php esc_html_e( 'Typical delivery time: 3-7 working days for ready items.', 'rabeya' ); ?></li>
	</ul>

	<h3><?php esc_html_e( 'Warranty', 'rabeya' ); ?></h3>
	<ul>
		<li><?php esc_html_e( '5 year warranty against manufacturing defects on all wooden items.', 'rabeya' ); ?></li>
		<li><?php esc_html_e( 'Warranty does not cover damage from water, fire or misuse.', 'rabeya' ); ?></li>
		<li><?php esc_html_e( 'Custom orders are covered by a 2 year workmanship warranty.', 'rabeya' ); ?></li>
	</ul>

	<h3><?php esc_html_e( 'Custom orders', 'rabeya' ); ?></h3>
	<p><?php esc_html_e( 'Need a door or wardrobe in a custom size? Send your width and height in inches through the contact form and we will quote you within 24 hours.', 'rabeya' ); ?></p>
	<?php
}

/**
 * Show a small "Custom size available" notice before the add-to-cart button.
 */
function rabeya_custom_size_notice() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$has_custom = false;

	foreach ( $product->get_attributes() as $attribute ) {
		if ( 'size' === strtolower( wc_attribute_label( $attribute->get_name() ) ) ) {
			$has_custom = true;
			break;
		}
	}

	if ( ! $has_custom ) {
		return;
	}

	echo '<p class="custom-size-note">' . esc_html__( 'This item can be made in a custom size - mention your measurements in the order notes.', 'rabeya' ) . '</p>';
}
add_action( 'woocommerce_before_add_to_cart_button', 'rabeya_custom_size_notice' );
