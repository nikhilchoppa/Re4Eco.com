<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

<div class="clearfix tabs-wrap tabs-top active-c1 woo-tabs widget_orion_tabs_w">
		<ul class="nav nav-tabs col-sm-12" role="tablist">
			<?php foreach ( $tabs as $key => $tab ) : ?>
<?php
	
	$active_class = "";
	if ($key == 'description') {
		$active_class = "active";
	}
?>
				<li role="presentation" class="<?php echo esc_attr($active_class);?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>" area-controls="tab-<?php echo esc_attr( $key ); ?>" role="tab" data-toggle="tab">

					<?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
						
					</a>
				</li>
			<?php endforeach; ?>
		</ul>


		<div class="tab-content clearboth">		
		<?php foreach ( $tabs as $key => $tab ) : ?>

			<?php
				$active_class = "";
				if ($key == 'description') {
					$active_class = "active";
				}
			?>


			<div class="tab-pane clearboth <?php echo esc_attr($active_class);?>" role="tabpanel" id="tab-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>	

<?php endif; ?>
