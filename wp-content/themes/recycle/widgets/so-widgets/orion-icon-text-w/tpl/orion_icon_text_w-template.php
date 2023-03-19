<?php  //prepare variables
	$column_class = 'col-lg-'.(12 / $instance['per_row']);
	if ($instance['per_row'] == 3) {
		$column_class .= ' col-md-4';
	}
	$wrap_classes = '';
	$align_icons_center_mobile = $instance['align_icons_center_mobile'];
	$alignment_class = $instance['alignment'];
	$style = $instance['style'];
	if (isset($align_icons_center_mobile) && $align_icons_center_mobile =='true') {
		$wrap_classes .= ' align-icons-center-mobile';
	}	
	$icon_style = $instance['icon_style'];
	$counter = 0;
	

	foreach ($instance['icon_repeater'] as $feature) {
		$counter++;
	}
	if ($counter == 1 || $instance['per_row'] == 1) {
		$column_class .= ' col-sm-12';
	} else {
		$column_class .= ' col-sm-6';
	} 

	switch ($instance['text_style']) {
	    case "text-light":
	    	$text_color = 'text-light';
	    	break;
		case "text-dark":
			$text_color = 'text-dark';
			break;
		default:	
			$text_color = '';
			break;
	}
	 
	$bottom_margin = $instance['bottom_margin'];
	
?>

<div class="row icon-box-items-wrap grid<?php echo esc_attr($wrap_classes);?> <?php echo esc_attr($style);?>">
 
	<?php foreach ($instance['icon_repeater'] as $icon_text) :?>

		<?php 
		$the_icon = $icon_text['the_icon'];

		$description = $icon_text['description'];
			
		$icon_link = $icon_text['icon_link'];
		if (preg_match('#^post#', $icon_link) === 1) {
			preg_match_all('!\d+!', $icon_link, $post_id);
			$post_url = get_permalink($post_id[0][0]);
			$icon_link = $post_url;
		}
		$icon_color = $icon_text['icon_color'];
		$icon_bg_color = $icon_text['icon_bg_color'];
		$icon_styles = array();
		$icon_styles[] = 'color: '. $icon_color;
		 
		if ($icon_style != 'simple') {

			$icon_styles[] = 'background-color: '. $icon_bg_color;
		};
		?>

		<?php 

		$icon_title = '';
		$target = '';

		if( $icon_text['icon_title']!= '') {
			if($icon_link != '') {
				if ($icon_text['link_new_tab'] == true) {
					$target = 'target="_blank"';
				}

				$icon_title = '<a ' . $target . 'href="' . esc_url($icon_link) . '" title="' . esc_html($icon_text['icon_title']) . '><h5 class="item-title">' . $icon_text['icon_title'].'</h5></a>';		
			} else {
				$icon_title = '<h5 class="item-title">' . $icon_text['icon_title'] . '</h5>';
			}
		}
		
		$icon_title_kses = array(
		    'a' => array(
		        'href' => array(),
		        'title' => array(),
		        'h5' => array(),
		        'target' => array(),
		    ),
		    'h5' => array(
		    	'class' => array(),
		    	),
		);		

		$position_html_class = 'relative';
		if($style == 'short') {
			$position_html_class = 'absolute';
		}
		$position_html_class .= ' '. $alignment_class;
		?>

		<?php $wrap_class = $column_class; 
		if (isset($alignment_class) && $alignment_class != '') {
			$wrap_class .= ' '. $alignment_class;
		}?>
		
		<?php 
		/* image */
		$custom_image_file = $icon_text['custom_image_file'];
		$final_img = '';
		if (isset($custom_image_file) && $custom_image_file != '' && is_int($custom_image_file)) {
			$final_img = '<span class="image">' . wp_get_attachment_image($custom_image_file, 'thumbnail') . '</span>';
			$the_icon = '';
			$text_color .=' icon-image-wrap';
		}
		?>

		<div class="icon-box-wrap clearfix <?php echo esc_attr($wrap_class);?> <?php echo esc_attr($text_color);?>" style="margin-bottom:<?php echo esc_attr($bottom_margin);?>px;">		

			<?php if ($style != 'icon-top' ) {
				echo wp_kses($icon_title, $icon_title_kses); 
			};?>
			<?php if ($icon_link == '') :?>
				<div class="icon-wrap <?php echo esc_attr($position_html_class);?> <?php echo esc_attr($icon_style);?>">
					<?php echo siteorigin_widget_get_icon( $the_icon, $icon_styles); ?>
					<?php echo wp_kses_post($final_img); ?>
				</div>
			<?php else : ?>
				<a href="<?php echo esc_url($icon_link);?>" <?php echo wp_kses_post($target);?> class="icon-wrap <?php echo esc_attr($position_html_class);?> <?php echo esc_attr($icon_style);?>">
					<?php echo siteorigin_widget_get_icon( $the_icon, $icon_styles); ?>
					<?php echo wp_kses_post($final_img); ?>
				</a>
			<?php endif;?>

			<?php if ($style == 'icon-top' ) {
				echo wp_kses($icon_title, $icon_title_kses); 
			};?>			

			<span class="description"><?php echo wp_kses_post($description);?></span>

		</div>
	<?php endforeach;?>

</div>