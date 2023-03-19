<?php
/**
 * The template used for displaying portfolio categories and archive pages
 *
 * @package recycle
 */
?>
<?php //variables 
$columns = orion_get_option('portfolio_number_columns', false, 'col-md-4');
$image_class = 'overlay-none overlay-hover-black';
$text_color = 'text-light';
$image_size = 'orion_carousel';
orion_set_isotope();
?>

<?php  // portfolio content
		
	$item_category_data = get_the_terms( get_the_ID(), 'portfolio_category' );

	$item_cat_slug = '';
	$url = get_permalink();
	if($item_category_data) {
		foreach ($item_category_data as $cat) {
			$item_cat_slug .= 'filter-' . $cat->slug . ' ';
		}
	}?>

	<div class="<?php echo esc_attr($item_cat_slug);?>isotope-el <?php echo esc_attr($columns);?> ">
		<div class="relative wrapper image-w">

			<a class="<?php echo esc_attr($image_class);?>" href="<?php echo esc_url($url);?>">
				<?php 
				if(has_post_thumbnail()) : ?>
					<?php the_post_thumbnail( $image_size );?>
				<?php else : ?>
					<span class="image-wrap no-image block">
						<span class="sow-icon-eleganticons" data-sow-icon="&#xe005;"></span>
					</span>					
				<?php endif;?>
				<div class="overlay"></div>
			</a>

			<div class="absolute">
				<div class="hover-desc table-wrap">
					<div class="cell-wrap">
						<h4 class="<?php echo esc_attr($text_color);?>"><?php the_title();?></h4>
					</div>
				</div>
			</div>	
		</div>				
	</div>  
<?php 
?>
