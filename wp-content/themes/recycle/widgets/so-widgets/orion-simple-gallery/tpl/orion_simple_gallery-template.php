<?php 
/* prepare variables */
$per_row = $instance['per_row'];
$column_class = 'col-md-'.(12 / $per_row);
$article_class = '';
$image_class = '';
$onclick = $instance['option_section']['onclick'];
$image_style = $instance['style_section']['image_style'];
if ($column_class != 'col-md-12') {
	$column_class .= ' col-sm-6';
}

$layout = $instance['display_layout'];

//text color:
$text_color = $instance['text_color'];
$text_hover_color = $instance['style_section']['text_hover_color'];

if ($image_style == 'orion_circle') {
	$image_size = 'orion_square';
	$image_class .= ' image-wrap rounded';
} else {
	$image_size = $image_style;
}
 
// carousel options
$display_mobile_nav = $instance['option_section']['option_carousel']['display_mobile_nav'];
$navigation_carousel = $instance['option_section']['option_carousel']['navigation_carousel'];
if($instance['option_section']['option_carousel']['autoplay'] == '1') {
	$autoplay = 'true';
} else {
	$autoplay = 'false';
}
$autoplay_timeout = $instance['option_section']['option_carousel']['autoplay_timeout'];
$autoplay_data = '';

$display_mobile_nav_class = '';
if ($layout == 'carousel' && $display_mobile_nav != true) {
	$display_mobile_nav_class = ' hide-mobile-nav';
}
$wrapper_class = '';
if ($layout == 'carousel') {
	$wrapper_class = ' type-' . $navigation_carousel;
}

$entry_content_class = '';
$image_overlay = $instance['style_section']['image_overlay'];
$image_overlay_hover = $instance['style_section']['image_overlay_hover'];
$scale_efect = $instance['style_section']['scale_efect'];

/* row class */
$row_class = $layout;
if ($navigation_carousel == 'arrows_top') {
	$row_class .= ' top-nav';
}

?>
<?php $image_class .= ' ' . $image_overlay . ' ' . $image_overlay_hover . ' ' . $scale_efect;;?>
<div class="row orion-simple-gallery <?php echo esc_attr($row_class);?><?php echo esc_attr($display_mobile_nav_class);?>">

<?php //title
if(!empty($instance['title'])) : ?>
	<div class="col-md-12 widget-header">
		<h3 class="widget-title <?php echo esc_attr($text_color);?>"><?php echo esc_html($instance['title']);?></h3>
	</div>
<?php endif; ?>

	<div class="wrapper<?php echo esc_attr($wrapper_class);?>">	
	<?php if ($layout == 'carousel') : ?>
		<?php 
		if ($autoplay == 'true' && isset($autoplay_timeout)) {
			$autoplay_data .= ' data-autoplaytimeout=' . $autoplay_timeout;
		}
		?>		
		<?php if ( $navigation_carousel == 'arrows_top') : ?>
			<?php // carousel top navigation ?>
			<div class="owl-nav style-1 top <?php echo esc_attr($text_color);?>">
				<a class="btn btn-sm btn-flat owlprev icon" ><i class="eleganticons-arrow_left"></i></a>
				<a class="btn btn-sm btn-flat owlnext icon" ><i class="eleganticons-arrow_right"></i></a>
			</div>
		<?php endif;?>


		<div class="owl-carousel owl-theme clearfix" data-col="<?php echo esc_html($instance['per_row']);?>" data-autoplay="<?php echo esc_attr($autoplay);?>"<?php echo esc_attr($autoplay_data);?> data-dots="<?php echo ($navigation_carousel == 'dots');?>">

			<?php $column_class = 'col-md-12';?>
	<?php endif; ?>
		<?php // render pages ?>
		<?php foreach ($instance['images_repeater'] as $single_image) : ?>
			<?php //variables
			$image = $single_image['image'];
			$hovertext = $single_image['hovertext'];
			?>
			<div class="<?php echo esc_attr($column_class);?>">
				<div class="image-w relative">

						<?php $img = wp_get_attachment_image($image, $image_size);?>
						
						<?php // add a link?
						if($onclick == 'lightbox') : ?>
							<?php $large_image = wp_get_attachment_image_src($image, 'large');?>
							<a class="<?php echo esc_attr($image_class);?>" href="<?php echo wp_kses_post($large_image[0]);?>">
						<?php else : ?>
							<div class="<?php echo esc_attr($image_class);?>">
						<?php endif; ?>
							<?php echo wp_kses_post($img);?>
							<div class="overlay"></div>
						<?php if($onclick == 'lightbox') : ?>
							</a>
						<?php else : ?>
							</div>
						<?php endif; ?>	
					
					<div class="absolute">
					<?php if ($hovertext) :?>
						<div class="hover-desc table-wrap">
							<div class="cell-wrap">
								<h4 class="<?php echo esc_attr($text_hover_color);?>"><?php echo wp_kses_post($hovertext);?></h4>
							</div>
						</div>
					<?php endif;?>	
					</div>					
				</div>
			</div>
		<?php endforeach; ?>
		
		<?php //end carousel div
		if ($layout == 'carousel' ) : ?>
			</div>
			<?php if ($navigation_carousel == 'arrows_aside') : ?>
				<div class="nav-controll arrows-aside">
					<div class="owl-nav aside <?php echo esc_attr($text_color);?>">
						<a class="btn btn-sm btn-empty owlprev icon" ><i class="fa fa-angle-left"></i></a>
						<a class="btn btn-sm btn-empty owlnext icon" ><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			<?php endif; ?>				
			<?php if($navigation_carousel == 'arrows_bottom' ) : ?>
				<div class="nav-controll bottom">			
					<div class="owl-nav style-1 bottom text-right col-md-12 <?php echo esc_attr($text_color);?>">
						<a class="btn btn-sm btn-flat owlprev icon" ><i class="eleganticons-arrow_left"></i></a>
						<a class="btn btn-sm btn-flat owlnext icon" ><i class="eleganticons-arrow_right"></i></a>
					</div>
				</div>
			<?php endif;?>				

		<?php endif; ?>

	</div>
</div>