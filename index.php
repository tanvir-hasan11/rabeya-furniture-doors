<?php
/**
 * Main template fallback.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="container site-main">
	<?php if ( have_posts() ) : ?>
		<header class="page-head">
			<h1><?php echo esc_html( get_the_archive_title() ); ?></h1>
		</header>

		<div class="post-grid">
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<a class="post-thumb" href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium_large' ); ?></a>
					<?php endif; ?>
					<div class="post-body">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-excerpt"><?php the_excerpt(); ?></div>
					</div>
				</article>
			<?php endwhile; ?>
		</div>

		<?php the_posts_pagination( array( 'mid_size' => 1 ) ); ?>
	<?php else : ?>
		<p class="empty-note"><?php esc_html_e( 'Nothing found.', 'rabeya' ); ?></p>
	<?php endif; ?>
</main>
<?php
get_footer();
