<?php
/**
 * Site footer.
 *
 * @package Rabeya
 */
?>
</div><!-- #content -->

<footer id="colophon" class="site-footer">
	<div class="container footer-grid">
		<div class="footer-col">
			<h3><?php bloginfo( 'name' ); ?></h3>
			<p><?php esc_html_e( 'Handcrafted furniture and doors made with seasoned wood, built to last for generations.', 'rabeya' ); ?></p>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Shop', 'rabeya' ); ?></h3>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'fallback_cb'    => false,
				'depth'          => 1,
			) );
			?>
		</div>

		<div class="footer-col footer-widgets">
			<?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
				<?php dynamic_sidebar( 'footer-widgets' ); ?>
			<?php endif; ?>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'Contact', 'rabeya' ); ?></h3>
			<ul class="footer-contact">
				<li><?php esc_html_e( 'Showroom: Dhaka, Bangladesh', 'rabeya' ); ?></li>
				<li><a href="mailto:info@rabeyafurniture.com">info@rabeyafurniture.com</a></li>
				<li><a href="tel:+8801000000000">+880 1000-000000</a></li>
			</ul>
		</div>
	</div>

	<div class="container footer-bottom">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'rabeya' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
