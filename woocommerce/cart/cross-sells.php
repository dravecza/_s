<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $cross_sells ) : ?>

	<div class="cross-sells swiper-container">

		<h2><?php _e( 'You may be interested in&hellip;', 'woocommerce' ) ?></h2>

		<?php
		echo '<ul class="products swiper-wrapper">';
		?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	// $post_object = get_post( $cross_sell->get_id() );
					//
					// setup_postdata( $GLOBALS['post'] =& $post_object );
					//
					// wc_get_template_part( 'content', 'swiper-product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>
		<div class="swiper-pagination"></div>
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
	<script type="text/javascript">
		var swiper = new Swiper('.swiper-container', {
			slidesPerView: 2,
			spaceBetween: 10,
			loop: true,
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			// Responsive breakpoints
			breakpoints: {
				// when window width is <= 320px
				640: {
					slidesPerView: 2,
					spaceBetween: 10
				},
				// when window width is <= 640px
				768: {
					slidesPerView: 3,
					spaceBetween: 30
				}
			}
		});
	</script>
<?php endif;

wp_reset_postdata();
