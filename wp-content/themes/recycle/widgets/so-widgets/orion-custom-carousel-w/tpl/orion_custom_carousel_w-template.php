<?php  //prepare variables 
	$column_class = '';
	$per_row = 1;
	$text_style = $instance['option_section']['text_style'];

	$btn_type = $instance['option_section']['btn_type'];
	$btn_style = $instance['option_section']['btn_style'];
	$btn_size = $instance['option_section']['btn_size'];
	$button_color = $instance['option_section']['button_color'];

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
<ul class="carousel-navigation nav nav-tabs tabs-style-2 text-center <?php echo esc_attr($text_style);?>">
<?php foreach ($instance['slide_repeater'] as $slide) : ?>
	<?php 
	$navigation_label = $slide['navigation_label'];
	$slide_id = preg_replace("/[^a-zA-Z0-9]+/", "", $navigation_label) . $counter;
	$counter ++;
	?>
	<li <?php if ($counter == 1):?> class="active" <?php endif;?> ><a class="owl-nav-link font-2" data-navid="<?php echo esc_attr($slide_id);?>" href="#<?php echo esc_attr($slide_id);?>"><?php echo esc_html($navigation_label);?></a></li>
	
<?php endforeach;?>
</ul>
<div class="custom-carousel-wrap">
	<div class=" owl-carousel owl-theme" data-col="<?php echo esc_attr($per_row);?>" data-autoplay="<?php echo esc_attr($autoplay);?>" data-dots="<?php echo esc_attr($dots);?>" data-owlloop="false" data-hashlisten="true" data-slideby="1">

		<?php $counter = 0; ?>
		<?php foreach ($instance['slide_repeater'] as $slide) : ?>
			<?php 
			$slide_title = $slide['slide_title'];
			$navigation_label = $slide['navigation_label'];
			$subtitle = $slide['subtitle'];
			$description = $slide['description'];

			/* button */
			$btn_text = $slide['btn_text'];	

			$button_classes = '';
			if ($button_color) {
				$button_classes .= $button_color;
			}
			if ($btn_style) {
				$button_classes .= ' ' . $btn_style;
			}
			if ( $btn_type != '' ) {
				$button_classes .= ' ' . $btn_type;
			}
			if ( $btn_size != '' ) {
				$button_classes .= ' ' . $btn_size;
			}

			$slide_id = preg_replace("/[^a-zA-Z0-9]+/", "", $navigation_label) . $counter;
			$counter ++;

			$slide_url = $slide['url'];
			// get link;
			if (preg_match('#^post#', $slide_url) === 1) {
				preg_match_all('!\d+!', $slide_url, $post_id);
				$post_slide_url = get_permalink($post_id[0][0]);
				$slide_url = $post_slide_url;
			}

			$slide_image = '';
			if ($slide['image']) {
				$get_image = wp_get_attachment_image_src($slide['image'], 'orion_carousel');
				$slide_image = $get_image[0];
			} ;?>

			<div class="carousel-item table clearfix owl-item <?php echo esc_attr($column_class);?> <?php echo esc_attr($text_style);?>" data-hash="<?php echo esc_attr($slide_id);?>">

				<div class="image">
					<?php if($slide_url != '' ) : ?>
					<div class="absolute" style="background-image: url(<?php echo esc_url($slide_image);?>)"></div>		

					<?php endif;?>	

					<img src="<?php echo esc_url($slide_image);?>" alt="<?php echo esc_html($slide_title);?>" />

					<?php if($slide_url != '' ) : ?>
					
					<?php endif;?>						
				</div>
				<div class="content">
	
					<?php if($slide_url != '' ) : ?>
					<a href="<?php echo esc_url($slide_url);?>">
					<?php endif;?>

					<h3><?php echo esc_html($slide_title);?></h3>

					<?php if($slide_url != '' ) : ?>
					</a>
					<?php endif;?>	

					<div class="subtitle lead"><?php echo esc_html($subtitle);?></div>
					<div class="description"><?php echo esc_html($description);?></div>

					<?php if($slide_url != '' && $btn_text != '' ) : ?>
					<a href="<?php echo esc_url($slide_url);?>" class="<?php echo esc_attr($button_classes);?>"> 
						<?php echo esc_html($btn_text);?> 
					</a>	
					<?php endif;?>	
		
				</div>
			</div>
		<?php endforeach;?>
	</div>
</div>