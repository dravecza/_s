<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php
		$regular_price = get_post_meta( get_the_ID(), '_regular_price', true);;
		$sale_price = get_post_meta( get_the_ID(), '_sale_price', true);
		$sale_percent = floor(100 - ($sale_price / $regular_price * 100));
		echo apply_filters( 'woocommerce_sale_flash',
		  '<span class="onsale' . ($sale_percent > 10 ? " bigsale" : "") . '"><span>' .
			($sale_percent > 10 ? "-" . $sale_percent . "%" : "%") .
			'</span></span>', $post, $product );
	?>

<?php endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
