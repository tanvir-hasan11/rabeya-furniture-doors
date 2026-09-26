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
		<div class="trust-item"><strong><?php esc_html_e( 'নিজস্ব স\'মিল', 'rabeya' ); ?></strong><span><?php esc_html_e( 'কাঠ আমরা নিজেরা কাটি', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( 'কথা = কাজ', 'rabeya' ); ?></strong><span><?php esc_html_e( 'ডেলিভারি তারিখ যেটা বলি', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( 'ফ্রি ফিটিং', 'rabeya' ); ?></strong><span><?php esc_html_e( 'চট্টগ্রাম শহরে', 'rabeya' ); ?></span></div>
		<div class="trust-item"><strong><?php esc_html_e( 'হাতে খোদাই', 'rabeya' ); ?></strong><span><?php esc_html_e( 'নিজস্ব ফিনিশিং', 'rabeya' ); ?></span></div>
	</div>
</section>

<section id="categories" class="section categories">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'যা লাগবে, ক্যাটাগরি ধরে', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'দরজা থেকে কিচেন - সব নিজস্ব মিলে।', 'rabeya' ); ?></p>
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
							<small><?php echo esc_html( sprintf( _n( '%s টি পণ্য', '%s টি পণ্য', $term->count, 'rabeya' ), number_format_i18n( $term->count ) ) ); ?></small>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php else : ?>
			<p class="empty-note"><?php esc_html_e( 'WooCommerce-এ প্রোডাক্ট ক্যাটাগরি যোগ করুন।', 'rabeya' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( function_exists( 'wc_get_products' ) ) : ?>
<section class="section featured">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'শোরুমে যা এখন চলছে', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'বেস্ট সেলিং দরজা, আলমারি, খাট ও ডাইনিং।', 'rabeya' ); ?></p>
		</header>
		<?php echo do_shortcode( '[products limit="8" columns="4" visibility="featured" orderby="popularity"]' ); ?>
	</div>
</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/factory' ); ?>

<?php if ( function_exists( 'wc_get_products' ) ) : ?>
<section class="section bestsellers">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'এখন যেসব পণ্যে ছাড়', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'স্টক থাকতে থাকতে দরজা, টেবিল ও স্টোরেজে ছাড়।', 'rabeya' ); ?></p>
		</header>
		<?php echo do_shortcode( '[sale_products limit="4" columns="4"]' ); ?>
	</div>
</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/offer-strip' ); ?>

<section class="section custom-cta">
	<div class="container custom-cta-inner">
		<div>
			<h2><?php esc_html_e( 'মাপমতো দরজা, আলমারি, কিচেন', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'শোরুমের ডিজাইন রাখুন, শুধু চওড়া-উচ্চতা বদলান - অথবা নিজের স্কেচ পাঠান।', 'rabeya' ); ?></p>
		</div>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/custom/' ) ); ?>"><?php esc_html_e( 'কাস্টম রিকোয়েস্ট', 'rabeya' ); ?></a>
	</div>
</section>

<?php get_template_part( 'template-parts/testimonials' ); ?>

<?php $notices = rabeya_latest_notices( 3 ); ?>
<?php if ( $notices ) : ?>
<section class="home-notices">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'নোটিশ ও অফার', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'নতুন ডিজাইন আর অফারের খবর।', 'rabeya' ); ?></p>
		</header>
		<div class="notice-grid">
			<?php foreach ( $notices as $notice ) : ?>
				<article class="notice-card">
					<time class="post-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C, $notice ) ); ?>"><?php echo esc_html( get_the_date( '', $notice ) ); ?></time>
					<h3><a href="<?php echo esc_url( get_permalink( $notice ) ); ?>"><?php echo esc_html( get_the_title( $notice ) ); ?></a></h3>
					<p><?php echo esc_html( wp_trim_words( get_the_excerpt( $notice ), 18 ) ); ?></p>
					<a class="post-more" href="<?php echo esc_url( get_permalink( $notice ) ); ?>"><?php esc_html_e( 'Read more', 'rabeya' ); ?> &rarr;</a>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<section class="section cta">
	<div class="container cta-inner">
		<div>
			<h2><?php esc_html_e( 'নিজের মাপে বানাতে চান?', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'চওড়া-উচ্চতা পাঠান, আমরা ২৪ ঘণ্টায় দাম জানিয়ে দেব।', 'rabeya' ); ?></p>
		</div>
		<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'কথা বলুন', 'rabeya' ); ?></a>
	</div>
</section>

<?php
get_footer();
