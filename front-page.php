<?php
/**
 * Front page template.
 *
 * @package Rabeya
 */

get_header();

// Banner slider (managed from Appearance -> Customize -> Rabeya Slider).
get_template_part( 'template-parts/slider' );
?>

<section class="trust">
	<div class="container trust-grid">
		<div class="trust-item"><strong><?php esc_html_e( '25+ Years', 'rabeya' ); ?></strong><span><?php esc_html_e( 'Of craftsmanship', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( 'Free Delivery', 'rabeya' ); ?></strong><span><?php esc_html_e( 'Inside Dhaka', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( 'Custom Size', 'rabeya' ); ?></strong><span><?php esc_html_e( 'Doors and furniture', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( '5 Year Warranty', 'rabeya' ); ?></strong><span><?php esc_html_e( 'On all wooden items', 'rabeya' ); ?></span></div>
	</div>
</section>

<section id="categories" class="section categories">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'Shop by category', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'From solid wood doors to complete living room sets.', 'rabeya' ); ?></p>
		</header>

		<?php $categories = rabeya_front_categories(); ?>
		<?php if ( $categories ) : ?>
			<div class="category-grid">
				<?php foreach ( $categories as $term ) : ?>
					<?php
					$thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
					$image    = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'medium_large' ) : '';
					?>
					<a class="category-card" href="<?php echo esc_url( get_term_link( $term ) ); ?>">
						<span class="category-media" style="<?php echo $image ? 'background-image:url(' . esc_url( $image ) . ')' : ''; ?>"></span>
						<span class="category-body">
							<strong><?php echo esc_html( $term->name ); ?></strong>
							<small><?php echo esc_html( sprintf( _n( '%s product', '%s products', $term->count, 'rabeya' ), number_format_i18n( $term->count ) ) ); ?></small>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="empty-note"><?php esc_html_e( 'Add product categories in WooCommerce to see them here.', 'rabeya' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( function_exists( 'wc_get_products' ) ) : ?>
<section class="section featured">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'Featured pieces', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'Best selling furniture and doors this season.', 'rabeya' ); ?></p>
		</header>
		<?php echo do_shortcode( '[products limit="8" columns="4" visibility="featured" orderby="popularity"]' ); ?>
	</div>
</section>
<?php endif; ?>

<section class="section cta">
	<div class="container cta-inner">
		<div>
			<h2><?php esc_html_e( 'Need a custom door size?', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'Send us your measurements and we will craft it to fit perfectly.', 'rabeya' ); ?></p>
		</div>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Request a quote', 'rabeya' ); ?></a>
	</div>
</section>

<?php
get_footer();
