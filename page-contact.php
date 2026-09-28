<?php
/**
 * Template Name: Contact
 *
 * "যোগাযোগ" page with map + form.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="site-main contact-page">
	<header class="contact-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'যোগাযোগ', 'rabeya' ); ?></p>
			<h1><?php esc_html_e( 'শোরুমে আসুন অথবা ফোন দিন', 'rabeya' ); ?></h1>
			<p class="contact-lead"><?php esc_html_e( 'প্রতিদিন সকাল ৯টা - রাত ৯টা খোলা। মাপ নিতে বা দাম জানতে সরাসরি চলে আসুন।', 'rabeya' ); ?></p>
		</div>
	</header>

	<section class="section contact-cards">
		<div class="container contact-card-grid">
			<div class="contact-card">
				<span class="contact-icon" aria-hidden="true">&#128205;</span>
				<h3><?php esc_html_e( 'ঠিকানা', 'rabeya' ); ?></h3>
				<p><?php echo esc_html( rabeya_info( 'address' ) ); ?></p>
			</div>
			<div class="contact-card">
				<span class="contact-icon" aria-hidden="true">&#128222;</span>
				<h3><?php esc_html_e( 'ফোন', 'rabeya' ); ?></h3>
				<p><a href="tel:<?php echo esc_attr( rabeya_info( 'phone_raw' ) ); ?>"><?php echo esc_html( rabeya_info( 'phone' ) ); ?></a></p>
			</div>
			<div class="contact-card">
				<span class="contact-icon" aria-hidden="true">&#9993;</span>
				<h3><?php esc_html_e( 'ইমেইল', 'rabeya' ); ?></h3>
				<p><a href="mailto:<?php echo esc_attr( rabeya_info( 'email' ) ); ?>"><?php echo esc_html( rabeya_info( 'email' ) ); ?></a></p>
			</div>
			<div class="contact-card">
				<span class="contact-icon" aria-hidden="true">&#128337;</span>
				<h3><?php esc_html_e( 'খোলা', 'rabeya' ); ?></h3>
				<p><?php echo esc_html( rabeya_info( 'hours' ) ); ?></p>
			</div>
		</div>
	</section>

	<section class="section contact-main">
		<div class="container contact-main-grid">
			<div class="contact-form-wrap">
				<h2><?php esc_html_e( 'মেসেজ পাঠান', 'rabeya' ); ?></h2>

			<?php if ( isset( $_GET['sent'] ) ) : ?>
				<?php if ( '1' === $_GET['sent'] ) : ?>
					<div class="form-notice"><?php esc_html_e( 'ধন্যবাদ! আমরা শীঘ্রই যোগাযোগ করব।', 'rabeya' ); ?></div>
				<?php elseif ( 'mail_fail' === $_GET['sent'] ) : ?>
					<div class="form-notice form-error"><?php esc_html_e( 'মেসেজ সংরক্ষিত হয়েছে কিন্তু ইমেইল পাঠানো যায়নি।', 'rabeya' ); ?></div>
				<?php elseif ( 'spam' === $_GET['sent'] ) : ?>
					<div class="form-notice form-error"><?php esc_html_e( 'অনুগ্রহ করে কিছুক্ষণ পর আবার চেষ্টা করুন।', 'rabeya' ); ?></div>
				<?php elseif ( 'invalid' === $_GET['sent'] ) : ?>
					<div class="form-notice form-error"><?php esc_html_e( 'সব প্রয়োজনীয় তথ্য সঠিকভাবে পূরণ করুন।', 'rabeya' ); ?></div>
				<?php else : ?>
					<div class="form-notice form-error"><?php esc_html_e( 'কিছু একটা সমস্যা হয়েছে। আবার চেষ্টা করুন।', 'rabeya' ); ?></div>
				<?php endif; ?>
			<?php endif; ?>

				<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="rabeya_contact">
					<?php wp_nonce_field( 'rabeya_contact', 'rabeya_contact_nonce' ); ?>
					<div style="position:absolute;left:-9999px;" aria-hidden="true"><input type="text" name="rabeya_website" tabindex="-1" autocomplete="off"></div>

					<p>
						<label for="ct-name"><?php esc_html_e( 'আপনার নাম', 'rabeya' ); ?> *</label>
						<input id="ct-name" type="text" name="ct_name" required>
					</p>
					<p>
						<label for="ct-phone"><?php esc_html_e( 'মোবাইল', 'rabeya' ); ?> *</label>
						<input id="ct-phone" type="tel" name="ct_phone" required>
					</p>
					<p>
						<label for="ct-email"><?php esc_html_e( 'ইমেইল', 'rabeya' ); ?></label>
						<input id="ct-email" type="email" name="ct_email">
					</p>
					<p>
						<label for="ct-message"><?php esc_html_e( 'আপনার মেসেজ', 'rabeya' ); ?> *</label>
						<textarea id="ct-message" name="ct_message" rows="5" required></textarea>
					</p>
					<p class="co-submit"><button type="submit" class="btn btn-primary"><?php esc_html_e( 'পাঠান', 'rabeya' ); ?></button></p>
				</form>
			</div>

			<div class="contact-map-wrap">
				<h2><?php esc_html_e( 'মানচিত্রে দেখুন', 'rabeya' ); ?></h2>
				<div class="contact-map">
					<iframe
						title="<?php esc_attr_e( 'Rabeya Furniture and Doors location', 'rabeya' ); ?>"
						src="https://www.google.com/maps?q=Halishahar,+Chittagong,+Bangladesh&output=embed"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						allowfullscreen></iframe>
				</div>
				<?php $wa = rabeya_whatsapp_url(); ?>
				<?php if ( $wa ) : ?>
					<a class="btn btn-primary wa-btn" href="<?php echo esc_url( $wa ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'হোয়াটসঅ্যাপে কথা বলুন', 'rabeya' ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
