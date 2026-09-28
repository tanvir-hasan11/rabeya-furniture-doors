<?php
/**
 * Premium features for Rabeya Furniture & Doors.
 *
 * Wishlist, quick view, WhatsApp ordering, product badges, back-to-top,
 * scroll animations and a sticky mobile add-to-cart bar.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WhatsApp number used for order buttons (digits only).
 *
 * @return string
 */
function rabeya_whatsapp_number() {
	$number = rabeya_info( 'whatsapp' );
	if ( '' === $number ) {
		$number = get_theme_mod( 'rabeya_whatsapp', '8801000000000' );
	}
	return preg_replace( '/[^0-9]/', '', (string) $number );
}

/**
 * Build a WhatsApp order URL, optionally for a product.
 *
 * @param WC_Product|null $product Product object.
 * @return string
 */
function rabeya_whatsapp_url( $product = null ) {
	$number = rabeya_whatsapp_number();

	if ( '' === $number ) {
		return '';
	}

	$text = __( 'Hello Rabeya Furniture and Doors, I would like to order:', 'rabeya' );

	if ( $product instanceof WC_Product ) {
		$text .= ' ' . $product->get_name();
		$text .= ' - ' . wp_strip_all_tags( wc_price( wc_get_price_to_display( $product ) ) );
		$text .= ' ' . get_permalink( $product->get_id() );
	}

	return 'https://wa.me/' . $number . '?text=' . rawurlencode( $text );
}

/**
 * Enqueue premium assets.
 */
function rabeya_premium_assets() {
	wp_enqueue_style( 'rabeya-premium', get_template_directory_uri() . '/assets/css/premium.css', array( 'rabeya-main' ), RABEYA_VERSION );
	wp_enqueue_script( 'rabeya-premium', get_template_directory_uri() . '/assets/js/premium.js', array(), RABEYA_VERSION, true );

	wp_localize_script( 'rabeya-premium', 'rabeyaPremium', array(
		'ajaxUrl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'rabeya_premium_ajax' ),
		'labels'  => array(
			'added'    => __( 'Added to wishlist', 'rabeya' ),
			'removed'  => __( 'Removed from wishlist', 'rabeya' ),
			'empty'    => __( 'Your wishlist is empty.', 'rabeya' ),
			'loading'  => __( 'Loading...', 'rabeya' ),
			'error'    => __( 'Something went wrong. Please try again.', 'rabeya' ),
			'wishlist' => __( 'My Wishlist', 'rabeya' ),
			'close'    => __( 'Close', 'rabeya' ),
		),
	) );
}
add_action( 'wp_enqueue_scripts', 'rabeya_premium_assets', 20 );

/* -------------------------------------------------------------------------
 * Product badges
 * ---------------------------------------------------------------------- */

/**
 * Render New / Sale / Hot badges on a product card.
 */
function rabeya_product_badges() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$badges = array();

	if ( $product->is_on_sale() ) {
		$badges[] = array( 'sale', __( 'Sale', 'rabeya' ) );
	}

	$created = $product->get_date_created();

	if ( $created && ( time() - $created->getTimestamp() ) < 30 * DAY_IN_SECONDS ) {
		$badges[] = array( 'new', __( 'New', 'rabeya' ) );
	}

	if ( $product->is_featured() ) {
		$badges[] = array( 'hot', __( 'Hot', 'rabeya' ) );
	}

	if ( ! $badges ) {
		return;
	}

	echo '<div class="product-badges-float">';

	foreach ( $badges as $badge ) {
		printf( '<span class="pbadge pbadge-%1$s">%2$s</span>', esc_attr( $badge[0] ), esc_html( $badge[1] ) );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'rabeya_product_badges', 9 );

/* -------------------------------------------------------------------------
 * Wishlist + quick view buttons on the product loop
 * ---------------------------------------------------------------------- */

/**
 * Wishlist heart + quick view button overlay.
 */
function rabeya_loop_action_buttons() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$id = $product->get_id();

	echo '<div class="loop-actions">';

	printf(
		'<button type="button" class="wishlist-toggle" data-product-id="%1$s" aria-pressed="false" aria-label="%2$s"><span class="icon-heart" aria-hidden="true">&#9825;</span></button>',
		esc_attr( $id ),
		esc_attr__( 'Add to wishlist', 'rabeya' )
	);

	if ( function_exists( 'wc_get_product' ) ) {
		printf(
			'<button type="button" class="quick-view-btn" data-product-id="%1$s">%2$s</button>',
			esc_attr( $id ),
			esc_html__( 'Quick view', 'rabeya' )
		);
	}

	echo '</div>';
}
add_action( 'woocommerce_before_shop_loop_item_title', 'rabeya_loop_action_buttons', 11 );

/**
 * Wishlist button on the single product page.
 */
function rabeya_single_wishlist_button() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	printf(
		'<button type="button" class="wishlist-toggle wishlist-toggle-text" data-product-id="%1$s" aria-pressed="false"><span class="icon-heart" aria-hidden="true">&#9825;</span> %2$s</button>',
		esc_attr( $product->get_id() ),
		esc_html__( 'Add to wishlist', 'rabeya' )
	);
}
add_action( 'woocommerce_after_add_to_cart_button', 'rabeya_single_wishlist_button', 15 );

/* -------------------------------------------------------------------------
 * AJAX: quick view
 * ---------------------------------------------------------------------- */

/**
 * Return the quick view HTML for a product.
 */
function rabeya_ajax_quick_view() {
	check_ajax_referer( 'rabeya_premium_ajax', 'nonce' );

	$id = isset( $_GET['product_id'] ) ? absint( $_GET['product_id'] ) : 0;

	if ( ! $id || ! function_exists( 'wc_get_product' ) ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'rabeya' ) ) );
	}

	$product = wc_get_product( $id );

	if ( ! $product || ! $product->is_visible() ) {
		wp_send_json_error( array( 'message' => __( 'Product not found.', 'rabeya' ) ) );
	}

	// Make the WooCommerce templates behave like a single product page.
	global $post, $product;
	$post    = get_post( $id );
	$product = wc_get_product( $id );
	setup_postdata( $post );

	ob_start();
	?>
	<div class="qv-grid">
		<div class="qv-media">
			<?php echo wp_kses_post( $product->get_image( 'large' ) ); ?>
		</div>
		<div class="qv-info">
			<h2 class="qv-title"><?php echo esc_html( $product->get_name() ); ?></h2>

			<?php if ( $product->get_average_rating() ) : ?>
				<div class="qv-rating"><?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating(), $product->get_review_count() ) ); ?></div>
			<?php endif; ?>

			<p class="qv-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>

			<?php if ( $product->get_short_description() ) : ?>
				<div class="qv-desc"><?php echo wp_kses_post( wpautop( $product->get_short_description() ) ); ?></div>
			<?php endif; ?>

			<div class="qv-cart"><?php woocommerce_template_single_add_to_cart(); ?></div>

			<div class="qv-links">
				<a class="qv-details" href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php esc_html_e( 'View full details', 'rabeya' ); ?> &rarr;</a>
			</div>
		</div>
	</div>
	<?php
	$html = ob_get_clean();

	wp_reset_postdata();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_rabeya_quick_view', 'rabeya_ajax_quick_view' );
add_action( 'wp_ajax_nopriv_rabeya_quick_view', 'rabeya_ajax_quick_view' );

/* -------------------------------------------------------------------------
 * AJAX: wishlist items
 * ---------------------------------------------------------------------- */

/**
 * Return rendered mini cards for the given product ids.
 */
function rabeya_ajax_wishlist_items() {
	check_ajax_referer( 'rabeya_premium_ajax', 'nonce' );
	$raw = isset( $_GET['ids'] ) ? sanitize_text_field( wp_unslash( $_GET['ids'] ) ) : '';
	$ids = array_filter( array_map( 'absint', explode( ',', $raw ) ) );

	if ( ! $ids || ! function_exists( 'wc_get_product' ) ) {
		wp_send_json_success( array( 'html' => '' ) );
	}

	ob_start();

	foreach ( $ids as $id ) {
		$product = wc_get_product( $id );

		if ( ! $product ) {
			continue;
		}
		?>
		<div class="wish-item">
			<a class="wish-item-thumb" href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo wp_kses_post( $product->get_image( 'thumbnail' ) ); ?></a>
			<div class="wish-item-body">
				<a class="wish-item-title" href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
				<span class="wish-item-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			</div>
			<button type="button" class="wishlist-toggle wish-item-remove" data-product-id="<?php echo esc_attr( $id ); ?>" aria-label="<?php esc_attr_e( 'Remove', 'rabeya' ); ?>">&times;</button>
		</div>
		<?php
	}

	$html = ob_get_clean();

	wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_rabeya_wishlist_items', 'rabeya_ajax_wishlist_items' );
add_action( 'wp_ajax_nopriv_rabeya_wishlist_items', 'rabeya_ajax_wishlist_items' );

/* -------------------------------------------------------------------------
 * Sticky mobile add-to-cart bar
 * ---------------------------------------------------------------------- */

/**
 * Output the sticky bar on single product pages.
 */
function rabeya_sticky_add_to_cart() {
	if ( ! function_exists( 'is_product' ) || ! is_product() ) {
		return;
	}

	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}
	?>
	<div class="sticky-cart" aria-hidden="true">
		<div class="sticky-cart-inner">
			<span class="sticky-cart-thumb"><?php echo wp_kses_post( $product->get_image( 'thumbnail' ) ); ?></span>
			<span class="sticky-cart-text">
				<strong><?php echo esc_html( wp_trim_words( $product->get_name(), 5 ) ); ?></strong>
				<span class="sticky-cart-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
			</span>
			<a class="btn btn-primary sticky-cart-btn" href="#tab-title-description"><?php esc_html_e( 'Add to cart', 'rabeya' ); ?></a>
		</div>
	</div>
	<?php
}
add_action( 'wp_footer', 'rabeya_sticky_add_to_cart', 15 );

/* -------------------------------------------------------------------------
 * Floating buttons + wishlist drawer + quick view shell
 * ---------------------------------------------------------------------- */

/**
 * Markup injected before the closing body tag.
 */
function rabeya_premium_footer_markup() {
	$whatsapp = rabeya_whatsapp_url();
	?>
	<div class="scroll-progress" aria-hidden="true"><span></span></div>

	<div class="float-stack">
		<button type="button" class="float-btn float-wishlist" aria-label="<?php esc_attr_e( 'Open wishlist', 'rabeya' ); ?>">
			<span aria-hidden="true">&#9825;</span>
			<span class="wishlist-count">0</span>
		</button>

		<?php if ( $whatsapp ) : ?>
			<a class="float-btn float-whatsapp" href="<?php echo esc_url( $whatsapp ); ?>" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Order on WhatsApp', 'rabeya' ); ?>">
				<span aria-hidden="true">&#9993;</span>
			</a>
		<?php endif; ?>

		<button type="button" class="float-btn float-top" aria-label="<?php esc_attr_e( 'Back to top', 'rabeya' ); ?>">
			<span aria-hidden="true">&uarr;</span>
		</button>
	</div>

	<div class="wish-drawer" aria-hidden="true">
		<div class="wish-drawer-head">
			<h3><?php esc_html_e( 'My Wishlist', 'rabeya' ); ?></h3>
			<button type="button" class="wish-drawer-close" aria-label="<?php esc_attr_e( 'Close', 'rabeya' ); ?>">&times;</button>
		</div>
		<div class="wish-drawer-body" id="wishDrawerBody"></div>
	</div>

	<div class="quick-view" aria-hidden="true">
		<div class="qv-backdrop"></div>
		<div class="qv-panel" role="dialog" aria-modal="true">
			<button type="button" class="qv-close" aria-label="<?php esc_attr_e( 'Close', 'rabeya' ); ?>">&times;</button>
			<div class="qv-content"></div>
		</div>
	</div>

	<div class="premium-toast" aria-live="polite"></div>
	<?php
}
add_action( 'wp_footer', 'rabeya_premium_footer_markup', 20 );

/* -------------------------------------------------------------------------
 * Customizer: WhatsApp + offer strip
 * ---------------------------------------------------------------------- */

/**
 * Premium customizer options.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function rabeya_premium_customize( $wp_customize ) {
	$wp_customize->add_section( 'rabeya_premium', array(
		'title'    => __( 'Rabeya Premium', 'rabeya' ),
		'priority' => 34,
	) );

	$wp_customize->add_setting( 'rabeya_whatsapp', array(
		'default'           => '8801000000000',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rabeya_whatsapp', array(
		'label'       => __( 'WhatsApp number', 'rabeya' ),
		'description' => __( 'Country code soho, digits only. Example: 8801712345678', 'rabeya' ),
		'section'     => 'rabeya_premium',
		'type'        => 'text',
	) );

	$wp_customize->add_setting( 'rabeya_offer_enabled', array(
		'default'           => true,
		'sanitize_callback' => 'rabeya_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'rabeya_offer_enabled', array(
		'label'   => __( 'Show the offer countdown strip', 'rabeya' ),
		'section' => 'rabeya_premium',
		'type'    => 'checkbox',
	) );

	$wp_customize->add_setting( 'rabeya_offer_title', array(
		'default'           => __( 'Eid Special Offer', 'rabeya' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rabeya_offer_title', array(
		'label'   => __( 'Offer title', 'rabeya' ),
		'section' => 'rabeya_premium',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'rabeya_offer_text', array(
		'default'           => __( 'Up to 25% off on all custom doors and dining sets.', 'rabeya' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rabeya_offer_text', array(
		'label'   => __( 'Offer description', 'rabeya' ),
		'section' => 'rabeya_premium',
		'type'    => 'text',
	) );

	$wp_customize->add_setting( 'rabeya_offer_date', array(
		'default'           => gmdate( 'Y-m-d', strtotime( '+30 days' ) ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wp_customize->add_control( 'rabeya_offer_date', array(
		'label'       => __( 'Offer end date', 'rabeya' ),
		'description' => __( 'Format: YYYY-MM-DD', 'rabeya' ),
		'section'     => 'rabeya_premium',
		'type'        => 'date',
	) );

	$wp_customize->add_setting( 'rabeya_offer_url', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( 'rabeya_offer_url', array(
		'label'   => __( 'Offer button link', 'rabeya' ),
		'section' => 'rabeya_premium',
		'type'    => 'url',
	) );
}
add_action( 'customize_register', 'rabeya_premium_customize' );
