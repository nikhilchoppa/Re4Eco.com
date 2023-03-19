<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
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
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<?php 
	$orion_product_class = orion_get_option('woo_product_columns', false, 'col-lg-4 col-sm-6');
?>

<li <?php post_class($orion_product_class); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 8 );	

	add_action( 'woocommerce_before_shop_loop_item', 'orion_woocommerce_template_loop_product_header_open', 9 );		
	// remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

	do_action( 'woocommerce_before_shop_loop_item' );

	/**
	 * woocommerce_before_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_show_product_loop_sale_flash - 10
	 * @hooked woocommerce_template_loop_product_thumbnail - 10
	 */
	remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);	
	do_action( 'woocommerce_before_shop_loop_item_title' );


	/**
	 * woocommerce_shop_loop_item_title hook.
	 */
	add_action( 'woocommerce_shop_loop_item_title', 'orion_close_product_link', 6 );
	
	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 7 );
	add_action( 'woocommerce_shop_loop_item_title', 'orion_close_product_header', 8 );
	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9 );
	/**
	 * @hooked woocommerce_template_loop_product_title - 10
	 */

	add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close',11 );

	do_action( 'woocommerce_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item_title hook.
	 *
	 * @hooked woocommerce_template_loop_rating - 5
	 * @hooked woocommerce_template_loop_price - 10
	 */
	// remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_price',10);

	add_action('woocommerce_after_shop_loop_item_title','orion_woo_product_content_close',12);
	do_action( 'woocommerce_after_shop_loop_item_title' );

	/**
	 * woocommerce_after_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_close - 5
	 * @hooked woocommerce_template_loop_add_to_cart - 10
	 */
	// remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );


	// do_action( 'woocommerce_after_shop_loop_item' );
	?>
</li> 
