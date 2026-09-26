<?php
/**
 * Site header.
 *
 * @package Rabeya
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'rabeya' ); ?></a>

<div class="topbar">
	<div class="container topbar-inner">
		<span class="topbar-item">
			<span class="topbar-strong"><?php echo esc_html( rabeya_info( 'city' ) ); ?></span> &middot; <?php esc_html_e( 'নিজস্ব স\'মিল', 'rabeya' ); ?>
		</span>
		<span class="topbar-links">
			<a class="topbar-item" href="tel:<?php echo esc_attr( rabeya_info( 'phone_raw' ) ); ?>"><?php echo esc_html( rabeya_info( 'phone' ) ); ?></a>
			<a class="topbar-item" href="<?php echo esc_url( rabeya_info( 'facebook' ) ); ?>" target="_blank" rel="noopener">Facebook</a>
		</span>
	</div>
</div>

<header id="masthead" class="site-header">
	<div class="container header-inner">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<span class="brand-mark">R</span>
					<span class="brand-text">
						<strong><?php bloginfo( 'name' ); ?></strong>
						<small><?php bloginfo( 'description' ); ?></small>
					</span>
				</a>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'rabeya' ); ?>">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_id'        => 'primary-menu',
				'container'      => false,
				'fallback_cb'    => false,
			) );
			?>
		</nav>

		<div class="header-actions">
			<button class="menu-toggle" aria-expanded="false" aria-controls="primary-menu">
				<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'rabeya' ); ?></span>
				<span class="bar"></span><span class="bar"></span><span class="bar"></span>
			</button>
			<?php rabeya_cart_link(); ?>
		</div>
	</div>
</header>

<div id="content" class="site-content">
