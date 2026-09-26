<?php
/**
 * WooCommerce wrapper template.
 *
 * @package Rabeya
 */

get_header();
?>
<main class="container site-main woocommerce-page">
	<?php woocommerce_content(); ?>
</main>
<?php
get_footer();
