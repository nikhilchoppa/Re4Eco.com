<?php  
//prepare variables
$layout = $instance['display_layout'];
$column_class = 'col-md-'.(12 / $instance['per_row']);
if ($instance['per_row'] == '1') {
	$column_class .= ' col-sm-12';
} else {
	$column_class .= ' col-sm-6';
}
$nav_color = 'white';
$text_size = $instance['option_section']['text_size'];
switch ($instance['option_section']['text_color']) {
    case "text-light":
    	$text_color = 'text-light';
    	$separator_style = ' style-text-light';
    	break;
	case "text-dark":
		$text_color = 'text-dark';
		$separator_style = ' style-text-dark';
		break;
	default:	
		$text_color = '';
		$separator_style = '';
		break;
}
$testimonial_bg_color = 'transparent';
$hex = $instance['option_section']['bg_color'];
$alpha = ($instance['option_section']['bg_opacy']/100);
if ($hex) {
	$testimonial_bg_color = orion_hextorgba($hex, $alpha);
}

$testimonials_style = "style='";
$testimonials_style .= 'background-color:'. $testimonial_bg_color . ';';

if($instance['option_section']['border-radius'] == true){
	$testimonials_style .= ' border-radius: 4px; ';
}	

$per_row = $instance['per_row'];


$testimonial_style = $testimonials_style;

// add padding if no background color or border
if($testimonial_bg_color == 'transparent') {
	$testimonial_style .= " padding-bottom:0;";
	$testimonial_style .= " padding-top:0;";
} else {
	$testimonial_style .= " padding: 15px; margin-right: 0px; margin-left: 0; padding-top: 24px; padding-bottom: 24px;";
}

$testimonial_style .= "'";
$testimonials_style = '';	

// carousel options
$navigation_carousel = $instance['option_section']['option_carousel']['navigation_carousel'];
$display_mobile_nav = $instance['option_section']['option_carousel']['display_mobile_nav'];	

if($instance['option_section']['option_carousel']['autoplay']) {
	$autoplay = $instance['option_section']['option_carousel']['autoplay'];
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

/* row class */
$row_class = $layout;
if ($navigation_carousel == 'arrows_top') {
	$row_class .= ' top-nav';
}
if ($text_color != '') {
	$row_class .= ' ' . $text_color;
} ?>


<div class="orion-testimonial row <?php echo esc_attr($row_class);?><?php echo esc_attr($display_mobile_nav_class);?>">

<?php //title
if(!empty($instance['title'])) : ?>
	<div class="col-md-12 widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>

	<div class="wrapper clearfix<?php echo esc_attr($wrapper_class);?>" <?php echo wp_kses_post($testimonials_style);?>>
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
		
		<?php foreach ($instance['widget_repeater'] as $item) :?>
			<div class="article item <?php echo esc_attr($column_class);?>">
				<div class="wrapper row" <?php echo wp_kses_post($testimonial_style);?>>
				<?php if($item['image'] != '') {
					$get_image = wp_get_attachment_image_src($item['image'], 'thumbnail');
					$bg_image = $get_image[0];
				} else {
					$bg_image = get_template_directory_uri(). '/img/orion-client-avatar.png';
				}?>

				<?php if(!empty($item["description"])) : ?>
					<div class="description col-md-12 <?php echo esc_attr($text_size);?>">
						<?php echo wp_kses_post($item["description"]);?>
					</div>
				<?php endif;?>			
				<?php if(!empty($item["name"])) : ?>
					<div class="author col-md-12">
					<?php if ($instance['option_section']['hide_image'] != true) : ?>
						<div class="image-wrap">
							<img src="<?php echo esc_url($bg_image);?>" <?php if (isset($item["item_title"]) && $item["item_title"] != '') :?> alt="<?php echo esc_html($item["item_title"]);?>" <?php endif; ?> class="circle" >
						</div>
					<?php endif;?>
						<div class="name">
							<small class="font-3">
							<?php echo wp_kses_post($item["name"]);?>
							</small>
							<?php if (isset ($item["item_title"]) && $item["item_title"] != '') :?>
								<span class="company">
									<?php echo esc_html($item["item_title"]);?>
								</span>
							<?php endif; ?>
						</div>			
					</div>			
				<?php endif;?>
				</div>
			</div>
		<?php endforeach;?>
		<?php if ($layout == 'carousel') : ?>
		</div> <!-- owl-carousel -->
			<?php if ($navigation_carousel == 'arrows_aside') : ?>
				<div class="nav-controll arrows-aside">
					<div class="owl-nav aside <?php echo esc_attr($text_color);?>">
						<a class="btn btn-sm btn-empty owlprev icon" ><i class="fa fa-angle-left"></i></a>
						<a class="btn btn-sm btn-empty owlnext icon" ><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			<?php endif; ?>			
			<?php if($navigation_carousel == 'arrows_bottom' ) : ?>
				<?php $owl_nav_style = "top: 24px; padding-right: 0;";?>
			<div class="nav-controll bottom" >					
				<div class="owl-nav style-1 bottom text-right col-md-12 <?php echo esc_attr($text_color);?>" <?php if($per_row == 1 ) :?> style="<?php echo esc_attr($owl_nav_style);?>" <?php endif;?> >
					<a class="btn btn-sm btn-flat owlprev icon" ><i class="eleganticons-arrow_left"></i></a>
					<a class="btn btn-sm btn-flat owlnext icon" ><i class="eleganticons-arrow_right"></i></a>
				</div>
			</div>					
			<?php endif;?>
		<!-- </div>  -->
		<?php endif;?>
	</div>	<!-- wrapper -->
</div>	<!-- testimonials -->