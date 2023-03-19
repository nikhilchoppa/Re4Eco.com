<?php 
/*
Template Name: Page
*/
get_header(); 
$orion_sidebars = orion_get_orion_sidebars();
$padding_classes = get_orion_page_padding();?>
<?php orion_get_orion_page_heading(); ?>

<?php 
add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );
?>
<?php 
if (is_shop() || is_product_category() || is_product_tag()) {
	$orion_options = get_option('recycle', orion_get_orion_defaults());	
	$num_of_sidebars = '0';
	$right_sidebar = "no_sidebar";
	$left_sidebar = 'no_sidebar';
	$orion_sidebars = array(
		'primary_class' => 'col-md-12', 
		'left_sidebar_class' => '', 
		'right_sidebar_class' =>'',
		'ot_left_sidebar_id' => '',
		'ot_right_sidebar_id' => ''		
	);
	if (isset($orion_options['woo_sidebar_left']) && ($orion_options['woo_sidebar_left'] != "")) {
       $orion_sidebars['ot_left_sidebar_id'] = $orion_options['woo_sidebar_left'];
       $num_of_sidebars++; 
    } 
 	if (isset($orion_options['woo_sidebar_right']) && ($orion_options['woo_sidebar_right'] != "")) {
       $orion_sidebars['ot_right_sidebar_id'] = $orion_options['woo_sidebar_right'];
       $num_of_sidebars++; 
    }
    switch ($num_of_sidebars) {
		case '0' :
			$orion_sidebars['primary_class'] = " col-md-12";
			break;
		case '1' :
			$orion_sidebars['primary_class']=" col-md-9";
			if($orion_sidebars['ot_left_sidebar_id'] != '' ){
			  	$orion_sidebars['left_sidebar_class'] = ' col-md-3 col-md-pull-9';
			  	$orion_sidebars['primary_class'] .= ' col-md-push-3';
			}
			if($orion_sidebars['ot_right_sidebar_id'] != '' ){
				$orion_sidebars['right_sidebar_class'] = " col-md-3";	
			}
			break;
		case '2' :
		    $orion_sidebars['primary_class'] = " col-md-6 col-md-push-3";
		    $orion_sidebars['left_sidebar_class'] = " col-md-3 col-md-pull-6";
		    $orion_sidebars['right_sidebar_class'] = " col-md-3";
			break;
		default:	
			$orion_sidebars['primary_class'] = " col-md-12";			
			break;
	}
}

;?>

<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row<?php echo esc_attr($padding_classes);?>">
				<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php woocommerce_content(); ?>
				</div><!-- #primary -->

			<?php if ( $orion_sidebars['ot_left_sidebar_id']): ?>
				<aside class="left-s sidebar <?php echo esc_attr($orion_sidebars['left_sidebar_class']);?>">
				    <section><?php dynamic_sidebar($orion_sidebars['ot_left_sidebar_id']); ?></section>
				</aside>   
			<?php endif; ?>

			<?php if ( $orion_sidebars['ot_right_sidebar_id']): ?>
			    <aside class="right-s sidebar <?php echo esc_attr($orion_sidebars['right_sidebar_class']);?>">
				    <section><?php dynamic_sidebar($orion_sidebars['ot_right_sidebar_id']); ?></section>
			    </aside>   
			<?php endif; ?>			
		</main><!-- #main -->
	</div> <!-- container-->
</div> <!-- #content-->

<?php get_footer(); 

