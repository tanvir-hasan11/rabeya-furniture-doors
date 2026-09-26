<?php
/**
 * Offer countdown strip.
 *
 * Managed from Appearance -> Customize -> Rabeya Premium.
 *
 * @package Rabeya
 */

if ( ! get_theme_mod( 'rabeya_offer_enabled', true ) ) {
	return;
}

$title = get_theme_mod( 'rabeya_offer_title', '' );
$text  = get_theme_mod( 'rabeya_offer_text', '' );
$date  = get_theme_mod( 'rabeya_offer_date', '' );
$url   = get_theme_mod( 'rabeya_offer_url', '' );

if ( '' === $title && '' === $text ) {
	return;
}
?>
<section class="offer-strip" data-deadline="<?php echo esc_attr( $date ); ?>">
	<div class="container offer-strip-inner">
		<div class="offer-strip-copy">
			<?php if ( $title ) : ?>
				<h3><?php echo esc_html( $title ); ?></h3>
			<?php endif; ?>
			<?php if ( $text ) : ?>
				<p><?php echo esc_html( $text ); ?></p>
			<?php endif; ?>
		</div>

		<div class="offer-strip-side">
			<?php if ( $date ) : ?>
				<div class="offer-timer" aria-hidden="true">
					<span class="unit"><span class="num" data-unit="days">00</span><span class="lbl"><?php esc_html_e( 'Days', 'rabeya' ); ?></span></span>
					<span class="unit"><span class="num" data-unit="hours">00</span><span class="lbl"><?php esc_html_e( 'Hours', 'rabeya' ); ?></span></span>
					<span class="unit"><span class="num" data-unit="minutes">00</span><span class="lbl"><?php esc_html_e( 'Min', 'rabeya' ); ?></span></span>
					<span class="unit"><span class="num" data-unit="seconds">00</span><span class="lbl"><?php esc_html_e( 'Sec', 'rabeya' ); ?></span></span>
				</div>
			<?php endif; ?>

			<?php if ( $url ) : ?>
				<a class="btn btn-primary offer-strip-btn" href="<?php echo esc_url( $url ); ?>"><?php esc_html_e( 'Grab the offer', 'rabeya' ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
