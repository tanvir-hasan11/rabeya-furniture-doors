<?php
/**
 * Shop / product category archive customisation.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Replace the default WooCommerce archive header with a custom banner.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

/**
 * Category / shop banner above the product loop.
 */
function rabeya_shop_banner() {
	$title       = '';
	$description = '';
	$image       = '';

	if ( is_product_category() || is_product_tag() ) {
		$term = get_queried_object();
		if ( $term instanceof WP_Term ) {
			$title       = $term->name;
			$description = $term->description;
			$thumb_id    = get_term_meta( $term->term_id, 'thumbnail_id', true );
			$image       = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'large' ) : '';
		}
	} elseif ( is_shop() ) {
		$title       = woocommerce_page_title( false );
		$shop_id     = wc_get_page_id( 'shop' );
		$description = $shop_id ? get_post_field( 'post_excerpt', $shop_id ) : '';
	}

	if ( '' === $title ) {
		return;
	}
	?>
	<section class="shop-banner<?php echo $image ? ' has-image' : ''; ?>"<?php echo $image ? ' style="background-image:url(' . esc_url( $image ) . ')"' : ''; ?>>
		<div class="container shop-banner-inner">
			<nav class="shop-breadcrumb" aria-label="<?php esc_attr_e( 'Breadcrumb', 'rabeya' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'rabeya' ); ?></a>
				<span aria-hidden="true">/</span>
				<span><?php echo esc_html( $title ); ?></span>
			</nav>
			<h1 class="shop-title"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $description ) : ?>
				<div class="shop-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
			<?php endif; ?>
		</div>
	</section>
	<?php
}
add_action( 'woocommerce_before_main_content', 'rabeya_shop_banner', 5 );

/**
 * Subcategory chips on a product category page.
 */
function rabeya_subcategory_chips() {
	if ( ! is_product_category() ) {
		return;
	}

	$term = get_queried_object();

	if ( ! $term instanceof WP_Term ) {
		return;
	}

	$children = get_terms( array(
		'taxonomy'   => 'product_cat',
		'parent'     => $term->term_id,
		'hide_empty' => true,
	) );

	if ( is_wp_error( $children ) || empty( $children ) ) {
		return;
	}

	echo '<div class="container subcategory-chips">';

	foreach ( $children as $child ) {
		printf(
			'<a class="chip" href="%1$s">%2$s <span>%3$s</span></a>',
			esc_url( get_term_link( $child ) ),
			esc_html( $child->name ),
			esc_html( number_format_i18n( $child->count ) )
		);
	}

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'rabeya_subcategory_chips', 5 );

/**
 * Custom toolbar: result count on the left, ordering on the right.
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

function rabeya_shop_toolbar() {
	if ( ! woocommerce_product_loop() ) {
		return;
	}

	echo '<div class="shop-toolbar">';
	echo '<div class="shop-toolbar-count">';
	woocommerce_result_count();
	echo '</div>';
	echo '<div class="shop-toolbar-sort">';
	woocommerce_catalog_ordering();
	echo '</div>';
	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop', 'rabeya_shop_toolbar', 20 );

/**
 * Products per page - 12 on furniture catalogs.
 *
 * @return int
 */
function rabeya_products_per_page() {
	return 12;
}
add_filter( 'loop_shop_per_page', 'rabeya_products_per_page', 20 );

/**
 * 3 columns on the shop grid (matches the theme's product card width).
 *
 * @return int
 */
function rabeya_loop_columns() {
	return 3;
}
add_filter( 'loop_shop_columns', 'rabeya_loop_columns', 20 );
