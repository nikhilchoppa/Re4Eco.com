<?php  //prepare variables
	$text_color = $instance['text_color'];
	$display_as = $instance['display_as'];
	$logo_height = $instance['logo_height'];
	$per_row = $instance['per_row'];

	$counter = 0;
	foreach ($instance['repeater'] as $logos) {
		$counter++;
	} 
	$logos_wrap_class = "";
	$logo_wrap_class = "";
	$logos_wrap_data = "";

	if($display_as == 'carousel') {
			$logos_wrap_class = $display_as;
			$logos_wrap_class .= ' owl-carousel owl-theme';
			$logos_wrap_data = 'data-col=' . $per_row;

			if($instance['option_carousel']['autoplay'] == '1') {
				$autoplay = 'true';
			} else {
				$autoplay = 'false';
			}
			$logos_wrap_data .= ' data-autoplay=' . $autoplay;

			if($instance['option_carousel']['autoplay_timeout']) {
				$autoplay_timeout = $instance['option_carousel']['autoplay_timeout'];
			} else {
				$autoplay_timeout = 5000;
			}
			
			$logos_wrap_data .= ' data-autoplaytimeout=' . $autoplay_timeout;

	} else { //grid
		if ($per_row == 1 ) {
			$logo_wrap_class .= ' col-xs-12';
		} else {
			$logo_wrap_class .= ' col-xs-6 col-md-'.(12 / $per_row);
		}
	}

	$border_color = 'border-color:'. $instance['border_color'] .';';
	
	$logo_img_size = $instance['logo_img_size'];
	$logo_img_hover_size = $instance['logo_img_hover_size'];
	$logo_data_attr = 'data-imgsize=' . $logo_img_size;
	$logo_data_attr .= ' data-imghoversize=' . $logo_img_hover_size;

	$navigation_carousel = $instance['option_carousel']['navigation_carousel'];
	$display_mobile_nav = $instance['option_carousel']['display_mobile_nav'];
?>
<?php 
$display_mobile_nav_class = '';
if ($display_as == 'carousel' && $display_mobile_nav != true) {
	$display_mobile_nav_class = ' hide-mobile-nav';
}
?>
<div class="row logo-w-wrap<?php echo esc_attr($display_mobile_nav_class);?>">
	<?php if(!empty($instance['title'])) : ?>
		<div class="col-md-12 entry-header">
			<h2 class="h5 widget-title <?php echo esc_attr($text_color);?>">
				<?php echo esc_html($instance['title']);?>
			</h2>
		</div>
	<?php endif;?>
	<?php if ($display_as == 'carousel' &&  $navigation_carousel == 'arrows_aside') : ?>
	<?php // relative wrapper for carousel: ?>
	<div class="relative clearfix">
	<?php endif;?>
	<div class="logos-wrap col-md-12 <?php echo esc_attr($logos_wrap_class);?>" <?php echo esc_attr($logos_wrap_data);?> >
		<?php if($display_as != 'carousel') :?>
		<div class="wrap-2 clearfix row">
		<?php endif;?>

		<?php foreach ($instance['repeater'] as $logos) :?>
			<?php //prepare variables
				$link = '';
				$logo = '';
				$logo = wp_get_attachment_image_src($logos['logo'], 'full');
				$logo_image = $logo[0];	
				$logs_alt = $logos['logo-title'];
			?>
			<div class="cell-wrap<?php echo esc_attr($logo_wrap_class);?>" style="padding-bottom: <?php echo esc_attr($logo_height);?>px;<?php echo esc_attr($border_color);?>">
				<?php if ($logos['link'] != '') :?>
					<a href="<?php echo esc_url($logos['link']);?>" class="logo" <?php echo esc_attr($logo_data_attr);?> title="<?php echo esc_html($logs_alt);?>" >
						<img src="<?php echo esc_url($logo_image);?>" alt="<?php echo esc_html($logs_alt);?>">
					</a>
				<?php else : ?>
					<span class="logo" <?php echo esc_attr($logo_data_attr);?>>
						<img src="<?php echo esc_url($logo_image);?>" alt="<?php echo esc_html($logs_alt);?>">
					</span>
				<?php endif;?>
			</div>			
		<?php endforeach;?>	
		<?php if($display_as != 'carousel') :?>
		</div>
		<?php endif;?>			
	</div>
	<?php if ($display_as == 'carousel' &&  $navigation_carousel == 'arrows_aside') : ?>
		<div class="nav-controll arrows-aside">
			<div class="owl-nav aside <?php echo esc_attr($text_color);?>">
				<a class="btn btn-sm btn-empty owlprev icon" ><i class="fa fa-angle-left"></i></a>
				<a class="btn btn-sm btn-empty owlnext icon" ><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>