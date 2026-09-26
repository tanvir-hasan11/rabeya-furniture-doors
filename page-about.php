<?php
/**
 * Template Name: About
 *
 * "আমাদের কথা" page.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="site-main about-page">
	<section class="about-hero">
		<div class="container">
			<p class="eyebrow"><?php esc_html_e( 'আমাদের কথা', 'rabeya' ); ?></p>
			<h1><?php esc_html_e( 'হালিশহরের কারিগররা, চট্টগ্রামের ঘরে ঘরে', 'rabeya' ); ?></h1>
			<p class="about-lead"><?php esc_html_e( '১৯৯৮ সাল থেকে সেগুন ও শক্ত কাঠের দরজা-ফার্নিচার বানাচ্ছি। নিজস্ব স\'মিল, হাতে খোদাই, আর কথামতো ডেলিভারি - এটাই আমাদের পরিচয়।', 'rabeya' ); ?></p>
		</div>
	</section>

	<section class="section about-story">
		<div class="container about-story-inner">
			<div class="about-art" aria-hidden="true">
				<span class="about-badge"><?php esc_html_e( 'নিজস্ব স\'মিল', 'rabeya' ); ?></span>
				<span class="about-year">1998</span>
			</div>
			<div class="about-copy">
				<h2><?php esc_html_e( 'শুরুটা একটা ছোট টুল ঘর থেকে', 'rabeya' ); ?></h2>
				<p><?php esc_html_e( 'প্রথমে ছিল একটা ছোট ওয়ার্কশপ, কয়েকজন কারিগর, আর কয়েকটা হাতিয়ার। আজ চট্টগ্রামের হালিশহরে আমাদের নিজস্ব স\'মিলে প্রতিদিন সেগুন, মেহগনি ও গর্জন কাঠে দরজা-ফার্নিচার তৈরি হয়।', 'rabeya' ); ?></p>
				<p><?php esc_html_e( 'বাইরের বোর্ড নয় - কাঠ আমরা নিজেরা কাটি, নিজেরা শুকাই, নিজেরা ফিনিশিং করি। তাই মানের উপর আমাদের পুরো নিয়ন্ত্রণ থাকে, আর দামও থাকে হাতের নাগালে।', 'rabeya' ); ?></p>
			</div>
		</div>
	</section>

	<section class="section about-values">
		<div class="container">
			<header class="section-head">
				<h2><?php esc_html_e( 'যে বিষয়গুলোতে আমরা আপোষ করি না', 'rabeya' ); ?></h2>
			</header>
			<div class="value-grid">
				<div class="value-card">
					<span class="value-icon" aria-hidden="true">&#127796;</span>
					<h3><?php esc_html_e( 'নিজস্ব কাঠ', 'rabeya' ); ?></h3>
					<p><?php esc_html_e( 'সেগুন, মেহগনি ও গর্জন - নিজস্ব স\'মিলে কাটা ও শুকানো।', 'rabeya' ); ?></p>
				</div>
				<div class="value-card">
					<span class="value-icon" aria-hidden="true">&#128295;</span>
					<h3><?php esc_html_e( 'হাতে খোদাই', 'rabeya' ); ?></h3>
					<p><?php esc_html_e( 'প্রতিটা ডিজাইন কারিগরের হাতে - একটার সাথে আরেকটা হুবহু মিলবে না।', 'rabeya' ); ?></p>
				</div>
				<div class="value-card">
					<span class="value-icon" aria-hidden="true">&#9200;</span>
					<h3><?php esc_html_e( 'কথা = কাজ', 'rabeya' ); ?></h3>
					<p><?php esc_html_e( 'ডেলিভারি তারিখ যেটা বলি, সেটাই - বাড়তি অপেক্ষা নেই।', 'rabeya' ); ?></p>
				</div>
				<div class="value-card">
					<span class="value-icon" aria-hidden="true">&#128666;</span>
					<h3><?php esc_html_e( 'ফ্রি ফিটিং', 'rabeya' ); ?></h3>
					<p><?php esc_html_e( 'চট্টগ্রাম শহরে ডেলিভারি ও বসানো - আলাদা বিল নেই।', 'rabeya' ); ?></p>
				</div>
			</div>
		</div>
	</section>

	<section class="section about-numbers">
		<div class="container number-grid">
			<div class="number-item"><strong>২৫+</strong><span><?php esc_html_e( 'বছরের অভিজ্ঞতা', 'rabeya' ); ?></span></div>
			<div class="number-item"><strong>৫০০০+</strong><span><?php esc_html_e( 'সন্তুষ্ট পরিবার', 'rabeya' ); ?></span></div>
			<div class="number-item"><strong>১৫+</strong><span><?php esc_html_e( 'দক্ষ কারিগর', 'rabeya' ); ?></span></div>
			<div class="number-item"><strong>৫</strong><span><?php esc_html_e( 'বছরের ওয়ারেন্টি', 'rabeya' ); ?></span></div>
		</div>
	</section>

	<section class="section cta">
		<div class="container cta-inner">
			<div>
				<h2><?php esc_html_e( 'শোরুমে আসুন, কাঠ হাতে দেখুন', 'rabeya' ); ?></h2>
				<p><?php esc_html_e( 'হালিশহর, তাসফিয়া কমিউনিটি সেন্টার গেট, ২৫ নং রামপুর, চট্টগ্রাম।', 'rabeya' ); ?></p>
			</div>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'যোগাযোগ করুন', 'rabeya' ); ?></a>
		</div>
	</section>
</main>
<?php
get_footer();
