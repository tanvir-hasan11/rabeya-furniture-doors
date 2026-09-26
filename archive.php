<?php
/**
 * Blog / notice archive.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="container site-main blog-archive">
	<header class="page-head">
		<h1>
			<?php
			if ( is_category() || is_tag() || is_tax() ) {
				single_term_title();
			} else {
				esc_html_e( 'News & Notices', 'rabeya' );
			}
			?>
		</h1>
		<p class="page-sub"><?php esc_html_e( 'Offers, delivery updates and new arrivals from Rabeya Furniture and Doors.', 'rabeya' ); ?></p>
	</header>

	<?php if ( have_posts() ) : ?>
		<div class="post-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="post-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
					<?php endif; ?>
					<div class="post-body">
						<time class="post-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-excerpt"><?php the_excerpt(); ?></div>
						<a class="post-more" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read more', 'rabeya' ); ?> &rarr;</a>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="empty-note"><?php esc_html_e( 'No notices published yet.', 'rabeya' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
