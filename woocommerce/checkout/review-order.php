<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="shop_table woocommerce-checkout-review-order-table">
	<span class="product-name cart-header"><?php esc_html_e( 'Product', 'woocommerce' ); ?></span>
	<span class="product-total cart-header"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
	<?php
	do_action( 'woocommerce_review_order_before_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
				<span class="product-name <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<span class="product-total">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
			<?php
		}
	}

	do_action( 'woocommerce_review_order_after_cart_contents' );
	?>

	<span class="cart-subtotal cart-header"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
	<span class="cart-subtotal cart-header"><?php wc_cart_totals_subtotal_html(); ?></span>


	<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
		<span class="cart-discount cart-header coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
		<span class="cart-discount cart-data coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
	<?php endforeach; ?>

	<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

		<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

		<?php wc_cart_totals_shipping_html(); ?>

		<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

	<?php endif; ?>

	<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
		<span class="fee cart-header"><?php echo esc_html( $fee->name ); ?></span>
		<span class="fee cart-data"><?php wc_cart_totals_fee_html( $fee ); ?></span>
	<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<span class="cart-header tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>"><?php echo esc_html( $tax->label ); ?></span>
					<span class="cart-data tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
				<?php endforeach; ?>
			<?php else : ?>
				<span class="cart-header tax-total"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
				<span class="cart-data tax-total"><?php wc_cart_totals_taxes_total_html(); ?></span>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<span class="cart-header order-total"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
		<span class="cart-header order-total order-total-sum"><?php wc_cart_totals_order_total_html(); ?></span>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>
