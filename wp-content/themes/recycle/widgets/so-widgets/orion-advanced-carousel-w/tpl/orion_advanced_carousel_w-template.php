<?php  //prepare variables 
	$column_class = '';
	$per_row = 1;
	$nav_align = 'text-center';
	if (isset($instance['option_section']['nav_align'])){
		$nav_align = $instance['option_section']['nav_align'];
	};
	$space_below_nav = $instance['option_section']['space_below_nav'];
	if ($space_below_nav == "") {
		$space_below_nav = 0;
	}
	/* Carousel */
	if($instance['option_carousel']['autoplay'] == '1') {
		$autoplay = 'true';
	} else {
		$autoplay = 'false';
	}

	$counter = 0;
	foreach ($instance['slide_repeater'] as $slide_count) {
		$counter++;
	}

	$dots = 'false';	
	

?>

<?php $counter = 0; ?>
<div class="nav-wrap <?php echo esc_attr($nav_align);?>" style="margin-bottom:<?php echo esc_attr($space_below_nav);?>px;">
	<ul class="carousel-navigation nav nav-tabs tabs-style-2">
	<?php foreach ($instance['slide_repeater'] as $slide) : ?>
		<?php 
		$navigation_label = $slide['navigation_label'];
		$slide_id = preg_replace("/[^a-zA-Z0-9]+/", "", $navigation_label) . $counter;
		$counter ++;
		?>
		<li <?php if ($counter == 1):?> class="active" <?php endif;?> ><a class="owl-nav-link font-2" data-navid="<?php echo esc_attr($slide_id);?>" href="#<?php echo esc_attr($slide_id);?>"><?php echo esc_html($navigation_label);?></a></li>
		
	<?php endforeach;?>
	</ul>
</div>
<div class="advanced-carousel-wrap">
	<div class=" owl-carousel owl-theme owl-correct-height" data-col="<?php echo esc_attr($per_row);?>" data-autoplay="<?php echo esc_attr($autoplay);?>" data-dots="<?php echo esc_attr($dots);?>" data-owlloop="false" data-hashlisten="true" data-slideby="1" data-autoheight="true">

		<?php $counter = 0; ?>
		<?php foreach ($instance['slide_repeater'] as $slide) : ?>
			<?php 
			$navigation_label = $slide['navigation_label'];

			$slide_id = preg_replace("/[^a-zA-Z0-9]+/", "", $navigation_label) . $counter;
			$counter ++;?>

			<div class="carousel-item table clearfix owl-item <?php echo esc_attr($column_class);?>" data-hash="<?php echo esc_attr($slide_id);?>">
				<?php orion_process_pagebuilder_content($slide['layoutbuilder']);?>
			</div>
		<?php endforeach;?>
	</div>
</div>