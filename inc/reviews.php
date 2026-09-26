<?php
/**
 * Product review styling and layout helpers.
 *
 * @package Rabeya
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Summary bar above the reviews list: average + per-star breakdown.
 */
function rabeya_review_summary() {
	global $product;

	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$count = $product->get_review_count();

	if ( ! $count ) {
		return;
	}

	$average = (float) $product->get_average_rating();
	?>
	<div class="review-summary">
		<div class="review-summary-score">
			<strong><?php echo esc_html( number_format_i18n( $average, 1 ) ); ?></strong>
			<?php echo wc_get_rating_html( $average ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<span class="review-summary-count">
				<?php
				/* translators: %s: number of reviews. */
				printf( esc_html( _n( '%s review', '%s reviews', $count, 'rabeya' ) ), esc_html( number_format_i18n( $count ) ) );
				?>
			</span>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_review_before_comment_meta', 'rabeya_review_card_open', 5 );

/**
 * Wrap each review in a card.
 */
function rabeya_review_card_open() {
	echo '<div class="review-card">';
}

/**
 * Close the review card.
 */
function rabeya_review_card_close() {
	echo '</div>';
}
add_action( 'woocommerce_review_after_comment_text', 'rabeya_review_card_close', 99 );

/**
 * Add a "Verified purchase" badge next to verified reviews.
 *
 * @param string $author Author markup.
 * @return string
 */
function rabeya_verified_badge( $author ) {
	global $comment;

	if ( 'yes' !== get_comment_meta( $comment->comment_ID, 'verified', true ) ) {
		return $author;
	}

	return $author . '<span class="verified-badge">' . esc_html__( 'Verified purchase', 'rabeya' ) . '</span>';
}
add_filter( 'woocommerce_review_gravatar_size', '__return_zero' );
add_filter( 'get_comment_author_link', 'rabeya_verified_badge' );

/**
 * Change the "Add a review" heading wording.
 *
 * @param array $args Comment form args.
 * @return array
 */
function rabeya_review_form_args( $args ) {
	$args['title_reply'] = __( 'Write a review', 'rabeya' );
	$args['label_submit'] = __( 'Submit review', 'rabeya' );

	return $args;
}
add_filter( 'woocommerce_product_review_comment_form_args', 'rabeya_review_form_args' );
