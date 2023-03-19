<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     2.0.0
 */
?>
<?php 
$product_class= ' grid';
if (is_shop()) {
	if (get_option('woocommerce_shop_page_display', '')!= '') {
		$product_class .= ' '.get_option('woocommerce_shop_page_display', '');
	}
} else if (is_product_category()) {
	if (get_option('woocommerce_category_archive_display', '') != '') {
		$product_class .= ' '.get_option('woocommerce_category_archive_display', '');
	}
} ?>
<ul class="orion-products row<?php echo esc_html($product_class);?>">
