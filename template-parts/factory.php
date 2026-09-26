<?php
/**
 * Workshop / factory section.
 *
 * @package Rabeya
 */
?>
<section class="factory">
	<div class="container factory-inner">
		<div class="factory-art" aria-hidden="true">
			<span class="factory-badge"><?php esc_html_e( 'নিজস্ব স\'মিল', 'rabeya' ); ?></span>
			<span class="factory-year">1998</span>
		</div>

		<div class="factory-copy">
			<p class="eyebrow"><?php esc_html_e( 'কারখানা', 'rabeya' ); ?></p>
			<h2><?php esc_html_e( 'হালিশহরে আমাদের স\'মিল', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'রাবেয়া ফার্নিচার এন্ড ডোর - চট্টগ্রামের নিজস্ব স\'মিলে সেগুন ও শক্ত কাঠের দরজা-ফার্নিচার তৈরি হয়। হাতে খোদাই, নিজস্ব ফিনিশিং, কথামতো ডেলিভারি।', 'rabeya' ); ?></p>

			<ul class="factory-list">
				<li><?php esc_html_e( 'কাঠ আমরা নিজেরা কাটি - বাইরের বোর্ড নয়।', 'rabeya' ); ?></li>
				<li><?php esc_html_e( 'ফিনিশিং ও ডেলিভারি তারিখ - যেটা বলি সেটাই।', 'rabeya' ); ?></li>
				<li><?php esc_html_e( 'চট্টগ্রাম শহরে ডেলিভারি ও বসানো - আলাদা বিল নয়।', 'rabeya' ); ?></li>
			</ul>

			<p class="factory-address"><strong><?php esc_html_e( 'শোরুম:', 'rabeya' ); ?></strong> <?php echo esc_html( rabeya_info( 'address' ) ); ?></p>

			<a class="btn btn-ghost" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( 'আরও জানুন', 'rabeya' ); ?></a>
		</div>
	</div>
</section>
