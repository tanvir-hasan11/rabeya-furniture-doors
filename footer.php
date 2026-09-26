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
			<p><?php esc_html_e( 'চট্টগ্রামের নিজস্ব স\'মিলে সেগুন দরজা ও ফার্নিচার। হাতে খোদাই, কথামতো ডেলিভারি।', 'rabeya' ); ?></p>
			<?php if ( rabeya_info( 'facebook' ) ) : ?>
				<a class="footer-social" href="<?php echo esc_url( rabeya_info( 'facebook' ) ); ?>" target="_blank" rel="noopener">Facebook</a>
			<?php endif; ?>
		</div>

		<div class="footer-col">
			<h3><?php esc_html_e( 'ক্যাটাগরি', 'rabeya' ); ?></h3>
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
			<h3><?php esc_html_e( 'শোরুম', 'rabeya' ); ?></h3>
			<ul class="footer-contact">
				<li><?php echo esc_html( rabeya_info( 'address' ) ); ?></li>
				<li><a href="tel:<?php echo esc_attr( rabeya_info( 'phone_raw' ) ); ?>"><?php echo esc_html( rabeya_info( 'phone' ) ); ?></a></li>
				<li><a href="mailto:<?php echo esc_attr( rabeya_info( 'email' ) ); ?>"><?php echo esc_html( rabeya_info( 'email' ) ); ?></a></li>
				<li><?php echo esc_html( rabeya_info( 'hours' ) ); ?></li>
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
