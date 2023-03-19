<?php
 	orion_set_isotope();
	//prepare variables

	$text_color = 'text-light'; // TODO

	$style_nav_class = 'col-sm-12';
	$style_content_class = 'col-sm-12';

	$nav_portfolio_class = 'nav-tabs';

	$uniqid = uniqid();

	$portfolio_cats = $instance['portfolio_cat'];
	$number_of_posts = $instance['number_of_posts'];
	$order_by = $instance['order_by'];
	$order = $instance['order'];
	$columns = $instance['columns'];
	$filter = $instance['filter'];

	$onclick = $instance['onclick'];
	// overlays
	$image_overlay = $instance['style_section']['image_overlay'];
	$image_overlay_hover = $instance['style_section']['image_overlay_hover'];
	$link_class = '';
	$link_class .= ' ' . $image_overlay . ' ' . $image_overlay_hover;

	// image style
	$image_style = $instance['style_section']['image_style'];
	$image_class = $instance['style_section']['image_style'];
	if ($image_style == 'orion_circle') {
		$image_size = 'orion_square';
		$image_class .= ' image-wrap rounded';
	} else {
		$image_size = $image_style;
	}
	$image_class .= ' ' . $image_overlay . ' ' . $image_overlay_hover;	
?>

<?php // query 
if($portfolio_cats != 0) {
    $orion_args = array(
    	'post_type' => 'orion_portfolio',
	    'tax_query' => array(
	        array(
	            'taxonomy' => 'portfolio_category',
	            'field'    => 'term_id',
	            'terms'    => $portfolio_cats,
	        ),
	    ),    
    	'posts_per_page'   => $number_of_posts,
    	'orderby'          => $order_by,
    	'order'            => $order,
    	'post_status'      => 'publish',
    );
} else {
	$terms = get_terms( array(
	    'taxonomy' => 'portfolio_category',
	    'orderby'    => 'count',
	    'hide_empty' => true,
	) );	 
	$portfolio_cats = array();
	foreach ($terms as $key => $portfolio_cat) {
		$id = $portfolio_cat->term_id;
		$portfolio_cats[] = $id;
	}

    $orion_args = array(
    	'post_type' => 'orion_portfolio',    
    	'posts_per_page'   => $number_of_posts,
    	'orderby'          => $order_by,
    	'order'            => $order,
    	'post_status'      => 'publish',
    );
}    
 	$portfolio_posts = new WP_Query( $orion_args );
?>

<div class="isotope-wrap">
	<?php //widget title
	if(!empty($instance['title'])) : ?>
		<div class="col-sm-12 entry-header">
			<h2 class="h5 widget-title">title</h2>
		</div>
	<?php endif; ?>	

    <?php // filter
    if (!is_string($portfolio_cats) && $filter == true) : ?>
    <?php 
    $btn_type = $instance['filter_style']['btn_type'];
    $button_color = $instance['filter_style']['button_color'];
    $btn_size = $instance['filter_style']['btn_size'];
    $btn_style = $instance['filter_style']['btn_style'];
    $filter_classes = $btn_type . ' ' . $button_color . ' ' . $btn_size . ' ' . $btn_style;
    ?>
    <div class="row">
        <div class="isotope-filter col-md-12 text-center">
        	<button class="btn <?php echo esc_attr($filter_classes);?> active" data-filter="*"><?php echo esc_html("All", 'recycle');?></button>
	        <?php foreach ($portfolio_cats as $portfolio_category_id) : ?>
	        	<?php 
	        	$term_data = get_term( $portfolio_category_id, 'portfolio_category');
	        	$cat_title = $term_data->name;
	        	$cat_slug = $term_data->slug;
	        	?>
	            <button class="btn <?php echo esc_attr($filter_classes);?>" data-filter=".filter-<?php echo esc_attr($cat_slug);?>"> <?php echo esc_html($cat_title);?></button>
	        <?php endforeach;?>
        </div>
    </div>
    <?php endif;?>
	
	<div class="isotope-items relative row">
		<?php  // portfolio content
		while( $portfolio_posts->have_posts() ) :
		    $portfolio_posts->the_post(); 

			if (has_post_thumbnail()) { // do not display items without featured image
				
			$item_category_data = get_the_terms( get_the_ID(), 'portfolio_category' );
			$item_cat_slug = '';
			$url = get_permalink();
			foreach ($item_category_data as $cat) {
				$item_cat_slug .= 'filter-' . $cat->slug . ' ';
			}?>
			<div class="<?php echo esc_attr($item_cat_slug);?>isotope-el <?php echo esc_attr($columns);?> ">
				<div class="relative wrapper image-w">
					<?php //the_post_thumbnail( 'orion_carousel' );?>

					<?php // add a link?
					if($onclick == 'link' && $url != '') : ?>
						<a class="<?php echo esc_attr($image_class);?>" href="<?php echo esc_url($url);?>">
					<?php elseif ($onclick == 'lightbox') : ?>
						
						<?php 
						$post_id = get_the_ID();
						$image = get_post_thumbnail_id( $post_id );
						$large_image = wp_get_attachment_image_src($image, 'large');?>
						<a class="<?php echo esc_attr($image_class);?>" href="<?php echo the_post_thumbnail_url( 'large' );?>">
					<?php else : ?>
						<div class="notlink <?php echo esc_attr($image_class);?>">
					<?php endif; ?>
						<?php //echo wp_kses_post($img);?>

					<?php the_post_thumbnail( $image_size );?>

						<div class="overlay"></div>
					<?php if($onclick == 'lightbox' || ($url != '' && $onclick == 'link')) : ?>
						</a>
					<?php else : ?>
						</div>
					<?php endif; ?>

					<div class="absolute">
						<div class="hover-desc table-wrap">
							<div class="cell-wrap">
								<h4 class="<?php echo esc_attr($text_color);?>"><?php the_title();?></h4>
							</div>
						</div>
					</div>	
				</div>				
			</div>  
			<?php } // has post thumbnail ?>  
		<?php 
		endwhile;
		wp_reset_postdata();
		?>
	</div>
</div>