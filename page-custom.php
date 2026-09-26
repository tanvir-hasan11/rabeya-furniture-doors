<?php
/**
 * Template Name: Custom Order
 *
 * Custom measurement request page.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="container site-main custom-order">
	<header class="page-head">
		<h1><?php esc_html_e( 'কাস্টম অর্ডার', 'rabeya' ); ?></h1>
		<p class="page-sub"><?php esc_html_e( 'শোরুমের ডিজাইন রাখুন, শুধু চওড়া-উচ্চতা বদলান - অথবা নিজের স্কেচ পাঠান।', 'rabeya' ); ?></p>
	</header>

	<div class="custom-order-grid">
		<div class="custom-order-form">
			<h2><?php esc_html_e( 'মাপ পাঠান', 'rabeya' ); ?></h2>

			<?php
			$sent = isset( $_GET['custom_sent'] ) ? sanitize_text_field( wp_unslash( $_GET['custom_sent'] ) ) : '';
			if ( '1' === $sent ) : ?>
				<div class="form-notice"><?php esc_html_e( 'ধন্যবাদ! আমরা ২৪ ঘণ্টার মধ্যে যোগাযোগ করব।', 'rabeya' ); ?></div>
			<?php endif; ?>

			<form class="custom-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="rabeya_custom_order">
				<?php wp_nonce_field( 'rabeya_custom_order', 'rabeya_custom_nonce' ); ?>

				<p>
					<label for="co-name"><?php esc_html_e( 'আপনার নাম', 'rabeya' ); ?> *</label>
					<input id="co-name" type="text" name="co_name" required>
				</p>

				<p>
					<label for="co-phone"><?php esc_html_e( 'মোবাইল নম্বর', 'rabeya' ); ?> *</label>
					<input id="co-phone" type="tel" name="co_phone" required>
				</p>

				<p>
					<label for="co-type"><?php esc_html_e( 'কী বানাতে চান?', 'rabeya' ); ?></label>
					<select id="co-type" name="co_type">
						<option><?php esc_html_e( 'দরজা', 'rabeya' ); ?></option>
						<option><?php esc_html_e( 'আলমারি / ওয়ারড্রোব', 'rabeya' ); ?></option>
						<option><?php esc_html_e( 'খাট', 'rabeya' ); ?></option>
						<option><?php esc_html_e( 'ডাইনিং', 'rabeya' ); ?></option>
						<option><?php esc_html_e( 'কিচেন ক্যাবিনেট', 'rabeya' ); ?></option>
						<option><?php esc_html_e( 'অন্যান্য', 'rabeya' ); ?></option>
					</select>
				</p>

				<p class="co-row">
					<span>
						<label for="co-width"><?php esc_html_e( 'চওড়া (ইঞ্চি)', 'rabeya' ); ?></label>
						<input id="co-width" type="text" name="co_width">
					</span>
					<span>
						<label for="co-height"><?php esc_html_e( 'উচ্চতা (ইঞ্চি)', 'rabeya' ); ?></label>
						<input id="co-height" type="text" name="co_height">
					</span>
				</p>

				<p>
					<label for="co-notes"><?php esc_html_e( 'বিস্তারিত / স্কেচ লিংক', 'rabeya' ); ?></label>
					<textarea id="co-notes" name="co_notes" rows="4"></textarea>
				</p>

				<p class="co-submit">
					<button type="submit" class="btn btn-primary"><?php esc_html_e( 'রিকোয়েস্ট পাঠান', 'rabeya' ); ?></button>
				</p>
			</form>
		</div>

		<aside class="custom-order-info">
			<h2><?php esc_html_e( 'আমাদের শোরুম', 'rabeya' ); ?></h2>
			<ul class="custom-contact">
				<li><strong><?php esc_html_e( 'ঠিকানা:', 'rabeya' ); ?></strong> <?php echo esc_html( rabeya_info( 'address' ) ); ?></li>
				<li><strong><?php esc_html_e( 'ফোন:', 'rabeya' ); ?></strong> <a href="tel:<?php echo esc_attr( rabeya_info( 'phone_raw' ) ); ?>"><?php echo esc_html( rabeya_info( 'phone' ) ); ?></a></li>
				<li><strong><?php esc_html_e( 'ইমেইল:', 'rabeya' ); ?></strong> <a href="mailto:<?php echo esc_attr( rabeya_info( 'email' ) ); ?>"><?php echo esc_html( rabeya_info( 'email' ) ); ?></a></li>
				<li><strong><?php esc_html_e( 'খোলা:', 'rabeya' ); ?></strong> <?php echo esc_html( rabeya_info( 'hours' ) ); ?></li>
			</ul>

			<?php $wa = rabeya_whatsapp_url(); ?>
			<?php if ( $wa ) : ?>
				<a class="btn btn-primary wa-btn" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'হোয়াটসঅ্যাপে কথা বলুন', 'rabeya' ); ?></a>
			<?php endif; ?>
		</aside>
	</div>
</main>
<?php
get_footer();
