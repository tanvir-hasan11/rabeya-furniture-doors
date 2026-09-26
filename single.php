<?php
/**
 * Single blog post / notice.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="container site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry single-post' ); ?>>
			<header class="page-head">
				<time class="post-date" datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				<h1><?php the_title(); ?></h1>
				<?php if ( has_category() ) : ?>
					<div class="post-cats"><?php the_category( ' ' ); ?></div>
				<?php endif; ?>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-thumb"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>

			<div class="entry-content"><?php the_content(); ?></div>

			<footer class="entry-footer">
				<?php the_tags( '<div class="post-tags">', ' ', '</div>' ); ?>
			</footer>
		</article>

		<nav class="post-nav">
			<div class="post-nav-prev"><?php previous_post_link( '%link', '&larr; %title' ); ?></div>
			<div class="post-nav-next"><?php next_post_link( '%link', '%title &rarr;' ); ?></div>
		</nav>

		<?php
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
		?>
	<?php endwhile; ?>
</main>
<?php
get_footer();
