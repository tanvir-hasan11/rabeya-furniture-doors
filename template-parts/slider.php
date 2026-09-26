<?php
/**
 * Homepage banner slider.
 *
 * Slides are managed from Appearance -> Customize -> Rabeya Slider.
 *
 * @package Rabeya
 */

$slides = rabeya_get_slides();

if ( empty( $slides ) ) {
	return;
}
?>
<section class="hero-slider" aria-label="<?php esc_attr_e( 'Featured promotions', 'rabeya' ); ?>">
	<div class="slider-track">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<article class="slide<?php echo 0 === $index ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
				<?php if ( ! empty( $slide['image'] ) ) : ?>
					<span class="slide-media" style="background-image:url(<?php echo esc_url( $slide['image'] ); ?>)"></span>
				<?php endif; ?>
				<div class="container slide-inner">
					<div class="slide-copy">
						<?php if ( ! empty( $slide['eyebrow'] ) ) : ?>
							<p class="eyebrow"><?php echo esc_html( $slide['eyebrow'] ); ?></p>
						<?php endif; ?>
						<h2><?php echo esc_html( $slide['title'] ); ?></h2>
						<?php if ( ! empty( $slide['text'] ) ) : ?>
							<p class="slide-text"><?php echo esc_html( $slide['text'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $slide['button_text'] ) && ! empty( $slide['button_url'] ) ) : ?>
							<a class="btn btn-primary" href="<?php echo esc_url( $slide['button_url'] ); ?>"><?php echo esc_html( $slide['button_text'] ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<?php if ( count( $slides ) > 1 ) : ?>
		<div class="slider-dots" role="tablist">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<button class="slider-dot<?php echo 0 === $index ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>" role="tab" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'rabeya' ), $index + 1 ) ); ?>"></button>
			<?php endforeach; ?>
		</div>
		<button class="slider-arrow slider-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'rabeya' ); ?>">&#8249;</button>
		<button class="slider-arrow slider-next" aria-label="<?php esc_attr_e( 'Next slide', 'rabeya' ); ?>">&#8250;</button>
	<?php endif; ?>
</section>
