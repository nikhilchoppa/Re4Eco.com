<?php 
$is_single = is_single();
$orion_gallery = get_post_meta(get_the_ID(), '_recycle_mutiple_img_upload');
$gallery_img_size = get_post_meta(get_the_ID(), '_recycle_gallery_img_size', true);

if ($is_single && get_post_meta(get_the_ID(), '_recycle_gallery_display', true) != '') {
	$orion_gallery_display_type = get_post_meta(get_the_ID(), '_recycle_gallery_display', true);
} else {
	$orion_gallery_display_type = 'carousel';
}

if ($orion_gallery_display_type != 'carousel'){
	$header_margin_class = ' no-bottom-margin';
}

if (!empty($orion_gallery)){
	$gallery_images = array();
	foreach ($orion_gallery[0] as $key => $value) {
		$gallery_images[] = $key;
	}
} else {
	$gallery_images = orion_get_gallery_attachments();
}

if (!isset($blog_type)) {
	$blog_type = orion_get_blog_type();
}
if ((!isset($gallery_images) || empty($gallery_images)) && $orion_gallery_display_type !='hide') : ?> 
	<?php get_template_part( 'templates/posts/formats/format', 'standard' );?> 
<?php  else : ?> 

<?php // variables

$bg_transparent = false;

$content_wrap_css = '';  //bg color
$wrap_class = 'col-md-12';
$entry_title_h1_class = "";
$content_wrap_class = '';
$is_gallery_grid = '';
$header_row_class = 'row';
$grid_class = '';
$carousel_class = '';
$wrap_count = 1;

if ($orion_gallery_display_type != 'carousel' && $orion_gallery_display_type != 'hide') {
	$is_gallery_grid = ' gallery-grid-type';
	$grid_class .= ' grid-'.$orion_gallery_display_type;

	switch ($orion_gallery_display_type) {
		case 'col-sm-4':
			$wrap_count = 3;
			break;
		case 'col-sm-3':
			$wrap_count = 4;
			break;
		case 'col-sm-6':
			$wrap_count = 2;
			break;					
		default:
			$wrap_count = 1;
			break;
	}

}
if(is_single() && $bg_transparent != true){
	$header_row_class = '';
}

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent' || $blog_content_bg == '') {
	$bg_transparent = true;
	$content_wrap_css = "style='background-color: transparent;'";
	$content_wrap_class = ' bg-transparent';
	$wrap_class = '';
	$grid_class .= ' bg-transparent row';
	
} else if ($blog_content_bg != '') {
	$content_wrap_class = " has-bg col-md-12";
	$grid_class .= ' has-bg';
	$content_wrap_css = "style='background-color:".$blog_content_bg.";'";
	if (orion_isColorLight($blog_content_bg) == false) {
		$entry_title_h1_class = " text-light";
		$wrap_class .= " text-light";
	}
};?>

<?php if (!is_single()) {
	$carousel_class = 'col-xs-12';
}?>

	<?php if ($orion_gallery_display_type != 'hide') :?>
	<header class="entry-header relative<?php echo esc_attr($is_gallery_grid);?>">
	<div class="<?php echo esc_attr($header_row_class);?>">
		
		<?php if ($orion_gallery_display_type != 'carousel' && $orion_gallery_display_type != 'hide') :?>
			<div class="grid grid-header clearfix<?php echo esc_attr($grid_class);?>" <?php echo wp_kses_post($content_wrap_css);?>>
				<?php
				if($gallery_img_size == '') {
					$gallery_img_size = 'orion_carousel';
				};?>
				<?php $counter = 0;?>
			<?php foreach ($gallery_images as $key => $value) : ?>

				<?php if (is_numeric($value)) :?>

					<?php // count items
					if($counter == 0) :?>
						<div class="flex-wrap clearfix flex-<?php echo esc_attr($wrap_count);?>">
					<?php endif;?>
					<?php $counter++ ;?>
					<div class="image-w <?php echo esc_attr($orion_gallery_display_type);?>">
						<a href="<?php echo wp_get_attachment_url( $value, 'full' );?>" class="overlay-hover-black">
							<?php echo wp_get_attachment_image( $value, $gallery_img_size );?>
							<div class="overlay"></div>
						</a>
					</div>

					
					<?php if ($counter == $wrap_count) : ?>
						</div> <?php // flex wrap ?>
						<?php $counter = 0;?>
					<?php endif;				
				 endif;?>
			<?php endforeach; ?> 
			</div>
		<?php endif;?>
		<?php if ($orion_gallery_display_type == 'carousel') :?>

			<?php // get the right size:
			if (is_single()) {
				if($gallery_img_size == '') {
					$gallery_img_size = 'orion_container_width';
				};
			} else if (strpos($blog_type, 'masonry') == false) {
				$gallery_img_size = 'orion_container_width';
			} else {
				$gallery_img_size = 'orion_carousel';
			}?>

			<?php // get ratios 
			$ratios = array();
			foreach ($gallery_images as $key => $value) {
				$img_data = wp_get_attachment_image_src($value, $gallery_img_size);
				if (isset($img_data[1]) && isset($img_data[2]) && $img_data[1] != '0' && $img_data[2] != '0') {
					array_push($ratios, round( ($img_data[2] / $img_data[1] ) , 4));
				}
			}
			$min_ratio = min ( $ratios );
			$max_ratio = max ( $ratios );
			$average_ratio = round( array_sum($ratios) / count($ratios) , 4); 
			?>			
			<div class="<?php echo esc_attr($carousel_class);?>">
				<div class="owl-carousel owl-equal-height" data-col="1" data-minratio="<?php echo esc_attr($min_ratio);?>" data-maxratio="<?php echo esc_attr($max_ratio);?>" data-avarageratio="<?php echo esc_attr($average_ratio);?>">
				<?php foreach ($gallery_images as $key => $value) : ?>
					<?php if (is_numeric($value)) {
							echo wp_get_attachment_image( $value, $gallery_img_size );
						}?>
				<?php endforeach; ?> 
				</div>
				<div class="owl-nav-custom">
				    <a class="owlprev primary-color-bg"><i class="fa fa-angle-left"></i></a>
				    <a class="owlnext primary-color-bg"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
		<?php endif;?>	
	</div>	
	</header> 
	<?php endif;?>
	<div class="content-wrap clearfix<?php echo esc_attr($content_wrap_class);?>" <?php echo wp_kses_post($content_wrap_css);?>>

		<?php if(is_single()) :?>
			<?php // don't show on portfolio
			if('post' == get_post_type()) :?>
				<div class="<?php echo esc_attr($wrap_class);?>">
					<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
					<h1 class="entry-title<?php echo esc_attr($entry_title_h1_class);?>"><?php the_title(); ?></h1>
				</div>
			<?php endif;?>
		<?php else : ?>
			<div class="<?php echo esc_attr($wrap_class);?>">
				<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
				<?php 	
				if (strpos($blog_type, 'grid') !== false || strpos($blog_type, 'masonry') !== false) : ?>
					<h2 class="h3 entry-title">
				<?php else : ?>
					<h2 class="entry-title">
				<?php endif;?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_title(); ?>
					</a>
				</h2>
			</div>	
		<?php endif;?>
<?php  endif; ?> 