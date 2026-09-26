<?php
/**
 * Customer testimonials.
 *
 * @package Rabeya
 */

$items = apply_filters( 'rabeya_testimonials', array(
	array(
		'name'  => 'Mohammad Shawon',
		'city'  => 'চট্টগ্রাম',
		'stars' => 5,
		'text'  => 'ভিলা প্রজেক্টের মেইন ডোর। জ্যামিতিক কাজটা একদম পরিষ্কার। চট্টগ্রামে এই মানের খোদাই সহজে মেলে না।',
	),
	array(
		'name'  => 'Farhana Akter',
		'city'  => 'হালিশহর',
		'stars' => 5,
		'text'  => 'খাটের হেডবোর্ডের খোদাই ছবির চেয়ে বাস্তবে আরও ভালো। মিলের লোকজন বাসায় এসে মাপ নিয়ে গেছে, তাই ফিটিং নিয়ে ঝামেলা হয়নি।',
	),
	array(
		'name'  => 'Kamrul Hasan',
		'city'  => 'পাহাড়তলী',
		'stars' => 4,
		'text'  => 'ডাইনিং সেটের চেয়ারগুলো শক্ত, টেবিলের গ্রেইন সুন্দর। এক সপ্তাহ দেরি হয়েছিল, তবে কাজের মান নিয়ে অভিযোগ নেই।',
	),
	array(
		'name'  => 'Nusrat Jahan',
		'city'  => 'নাসিরাবাদ',
		'stars' => 5,
		'text'  => 'মেইন গেটের খোদাই দেখে অর্ডার দিয়েছিলাম। বাসায় বসানোর পর প্রতিবেশীরাও জিজ্ঞেস করছে কোথা থেকে করিয়েছি। পলিশ একদম মসৃণ।',
	),
) );

if ( empty( $items ) ) {
	return;
}
?>
<section class="section testimonials">
	<div class="container">
		<header class="section-head">
			<h2><?php esc_html_e( 'কাস্টমার যা বলেছেন', 'rabeya' ); ?></h2>
			<p><?php esc_html_e( 'চট্টগ্রামের ঘরে ঘরে রাবেয়ার কাজ।', 'rabeya' ); ?></p>
		</header>

		<div class="testimonial-grid">
			<?php foreach ( $items as $item ) : ?>
				<figure class="testimonial-card">
					<div class="testimonial-stars" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'rabeya' ), (int) $item['stars'] ) ); ?>">
						<?php
						for ( $i = 1; $i <= 5; $i++ ) {
							echo '<span class="' . ( $i <= (int) $item['stars'] ? 'on' : 'off' ) . '" aria-hidden="true">&#9733;</span>';
						}
						?>
					</div>
					<blockquote><?php echo esc_html( $item['text'] ); ?></blockquote>
					<figcaption>
						<span class="t-avatar"><?php echo esc_html( mb_substr( $item['name'], 0, 1 ) ); ?></span>
						<span class="t-meta">
							<strong><?php echo esc_html( $item['name'] ); ?></strong>
							<small><?php echo esc_html( $item['city'] ); ?></small>
						</span>
					</figcaption>
				</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
