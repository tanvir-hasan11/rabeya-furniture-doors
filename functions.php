<?php
/**
 * Rabeya Furniture & Doors theme functions.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'RABEYA_VERSION', '1.0.0' );

require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/product-specs.php';
require get_template_directory() . '/inc/shop.php';
require get_template_directory() . '/inc/notice.php';
require get_template_directory() . '/inc/reviews.php';
require get_template_directory() . '/inc/premium.php';

function rabeya_setup() {
	load_theme_textdomain( 'rabeya', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );

	// WooCommerce support.
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'rabeya' ),
		'footer'  => __( 'Footer Menu', 'rabeya' ),
	) );
}
add_action( 'after_setup_theme', 'rabeya_setup' );

function rabeya_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'rabeya' ),
		'id'            => 'shop-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widgets', 'rabeya' ),
		'id'            => 'footer-widgets',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'rabeya_widgets_init' );

function rabeya_scripts() {
	wp_enqueue_style( 'rabeya-style', get_stylesheet_uri(), array(), RABEYA_VERSION );
	wp_enqueue_style( 'rabeya-main', get_template_directory_uri() . '/assets/css/main.css', array( 'rabeya-style' ), RABEYA_VERSION );
	wp_enqueue_style( 'rabeya-slider', get_template_directory_uri() . '/assets/css/slider.css', array( 'rabeya-main' ), RABEYA_VERSION );
	wp_enqueue_style( 'rabeya-blog', get_template_directory_uri() . '/assets/css/blog.css', array( 'rabeya-main' ), RABEYA_VERSION );

	if ( function_exists( 'is_product' ) && is_product() ) {
		wp_enqueue_style( 'rabeya-product', get_template_directory_uri() . '/assets/css/product.css', array( 'rabeya-main' ), RABEYA_VERSION );
		wp_enqueue_style( 'rabeya-reviews', get_template_directory_uri() . '/assets/css/reviews.css', array( 'rabeya-main' ), RABEYA_VERSION );
	}

	if ( function_exists( 'is_woocommerce' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		wp_enqueue_style( 'rabeya-shop', get_template_directory_uri() . '/assets/css/shop.css', array( 'rabeya-main' ), RABEYA_VERSION );
	}

	wp_enqueue_script( 'rabeya-main', get_template_directory_uri() . '/assets/js/main.js', array(), RABEYA_VERSION, true );

	if ( is_front_page() ) {
		wp_enqueue_script( 'rabeya-slider', get_template_directory_uri() . '/assets/js/slider.js', array(), RABEYA_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'rabeya_scripts' );

/**
 * Cart link with live item count for the header.
 */
function rabeya_cart_link() {
	if ( ! function_exists( 'WC' ) ) {
		return;
	}

	$count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;

	printf(
		'<a class="header-cart" href="%1$s"><span class="cart-icon" aria-hidden="true">&#128722;</span><span class="cart-count">%2$d</span><span class="screen-reader-text">%3$s</span></a>',
		esc_url( wc_get_cart_url() ),
		(int) $count,
		esc_html__( 'View cart', 'rabeya' )
	);
}

/**
 * Top product categories for the homepage grid.
 *
 * @return WP_Term[]
 */
function rabeya_front_categories() {
	$terms = get_terms( array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'number'     => 6,
		'orderby'    => 'count',
		'order'      => 'DESC',
	) );

	return is_wp_error( $terms ) ? array() : $terms;
}
