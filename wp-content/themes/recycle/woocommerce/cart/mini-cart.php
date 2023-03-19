<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>
<?php $is_cart_empty = '';
if ( WC()->cart->is_empty() ) {
$is_cart_empty = ' cart-is-empty';
};?>

<span class="woo-cart-icon <?php echo esc_attr($is_cart_empty);?>"><span class="sow-icon-eleganticons" data-sow-icon="&#xe015;"></span></span>

<div class="cart-contents">
    <?php if (WC()->cart->get_cart_contents_count() != '0'){
        echo '<span class="cart-quantity font-2 primary-color-bg">' . WC()->cart->get_cart_contents_count() .'</span>';
    }?>
</div>

<div class="orion-cart-wrapper minicart-hidden">

	<div class="font-3 text-uppercase item-title">
		<?php echo sprintf (_n( '%d item in cart', '%d items in cart', WC()->cart->get_cart_contents_count(), 'recycle' ), WC()->cart->get_cart_contents_count(), 'recycle' ); ?>
	</div>

	<ul class="cart_list product_list_widget clearfix <?php echo $args['list_class']; ?>">

		<?php if ( ! WC()->cart->is_empty() ) : ?>

			<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
					$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
						$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
						$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
						$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
						?>
						<li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
							<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
								'<a href="%s" class="remove-item remove_from_cart_button" title="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><span class="sow-icon-eleganticons" data-sow-icon="&#x4d;"></span></a>',
								esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
								__( 'Remove this item', 'woocommerce' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							), $cart_item_key );
							?>
							<?php if ( ! $_product->is_visible() ) : ?>
								<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . $product_name . '&nbsp;'; ?>
							<?php else : ?>
								<a class="item-link font-2" href="<?php echo esc_url( $product_permalink ); ?>">
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '<span class="item-title product-title">'.$product_name . '</span>'; ?>
								</a>
							<?php endif; ?>
							
							<?php //echo WC()->cart->get_item_data( $cart_item ); ?>
						
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( 'Qty: %s %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); ?>
						</li>
						<?php
					}
				}
			?>

		<?php else : ?>

			<li class="empty"><?php _e( 'No products in the cart.', 'recycle' ); ?></li>

		<?php endif; ?>

	</ul><!-- end product list -->

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<div class="cart-total text-uppercase clearfix item-title font-3"><?php _e( 'Total Price', 'recycle' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></div>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<div class="buttons row">
			<div class="col-lg-6 col-md-12 col-sm-6 col-xs-12">
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn btn-sm btn-white block"><?php _e( 'View Cart', 'recycle' ); ?></a>	
			</div>
			<div class="col-lg-6 col-md-12 col-sm-6 col-xs-12 text-right">
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn btn-sm btn-c1 block"><?php _e( 'Checkout', 'recycle' ); ?></a>
			</div>		
		</div>

	<?php endif; ?>

	<?php do_action( 'woocommerce_after_mini_cart' ); ?>
</div>