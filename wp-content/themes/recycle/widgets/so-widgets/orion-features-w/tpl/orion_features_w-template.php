<?php  //prepare variables 
	$column_class = 'col-md-'.(12 / $instance['option_section']['per_row']);
	$text_style = $instance['option_section']['text_style'];
	$text_alignment = $instance['option_section']['text_alignment'];
	$btn_type = $instance['option_section']['option_button']['btn_type'];
	$btn_style = $instance['option_section']['option_button']['btn_style'];
	$btn_size = $instance['option_section']['option_button']['btn_size'];
	$has_borders = '';
	$border_color = '';
	if ($instance['option_section']['add_borders'] == 1 ) {
		$has_borders = ' has_borders';
		if($instance['option_section']['border_color'] != '') {
			$border_color = 'style=border-color:'. $instance['option_section']['border_color'] .';';
		}
	}
	$counter = 0;
	foreach ($instance['icon_repeater'] as $feature) {
		$counter++;
	}
	if ($counter == 1) {
		$column_class .= ' col-sm-12';
	} else {
		$column_class .= ' col-sm-6';
	}

	$always_open = $instance['option_section']['always_open'];
	if ($instance['option_section']['always_open']) {
		$dec_open_class = 'no-toggle';
	} else {
		$dec_open_class = '';
	}

	$feature_height = $instance['option_section']['feature_height'] . 'px';
	if ($feature_height == ''){
		$feature_height = '336px';
	}
?>

<div class="features-wrap<?php echo esc_attr($has_borders);?>">
	<div class="table-wrap">
	<?php if ($instance['option_section']['add_borders'] == 1 ) : ?>
	<div class="wrap-2 clearfix row">
	<?php endif;?>
		<?php foreach ($instance['icon_repeater'] as $feature) :?>
			<?php 

			$icon_title = $feature['icon_title'];
			$button_color = $feature['style']['button_color'];
			$title_hover_color = $feature['style']['title_hover_color'];
			/* button style */
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
			$url = $feature['url'];
			// get link;
			if (preg_match('#^post#', $url) === 1) {
				preg_match_all('!\d+!', $url, $post_id);
				$post_url = get_permalink($post_id[0][0]);
				$url = $post_url;
			}


			if($url != '') {
				$icon_title_html = '<a class="'. $title_hover_color .'" href="' . esc_url($url) . '" title="' . esc_html($icon_title) . '><h5 class="item-title ' . $title_hover_color . '">' . $feature['icon_title'].'</h5></a>';		
			} else {
				$icon_title_html = '<h5 class="item-title">' . $feature['icon_title'] . '</h5>';
			};	

			$the_icon = $feature['the_icon'];
			$description = $feature['description'];

			if ($feature['style']['icon_color'] != false) {
				$icon_color = $feature['style']['icon_color'];
			} else {
				if ($text_style == 'text-dark') {
					$icon_color = orion_get_theme_option_css('main_theme_color', '#1CBAC8' );
				} else {
					$icon_color = '#fff';		
				}
			}

			$icon_styles = array();
			$icon_styles[] = 'color: '. $icon_color;

			if ($instance['option_section']['icon_size'] == 'large') {
				$icon_styles[] = 'font-size: 84px';
				$icon_styles[] = 'line-height: 96px';
			}

			$icon_title_kses = array(
			    'a' => array(
			        'href' => array(),
			        'title' => array(),
			        'h5' => array(),
			        'class' => array(),
			        'title' => array(),
			    ),
			    'h5' => array(
			    	'class' => array(),
			    	),
			);	
			$read_more = $feature['read_more'];

			$bg_image = '';
			$has_bg_class = '';
			if ($feature['style']['bg_image'] != '' && $feature['style']['bg_image'] != '0') {
				$get_image = wp_get_attachment_image_src($feature['style']['bg_image'], 'orion_tablet');
				$bg_image = $get_image[0];
				$has_bg_class = ' has-bg';
			};
			$hex = $feature['style']['bg_color'];
			$alpha = ($feature['style']['bg_opacy']/100);
			if ($hex && $hex != 'transparent') {
				$overlay_bg_color = orion_hextorgba($hex, $alpha);	
				$has_bg_class = ' has-bg';
			} else  {
				$overlay_bg_color = 'transparent';
			}
			?>

			<?php 
			/* image instead of icon*/
			$custom_image_file = $feature['custom_image_file'];
			$final_img = '';
			if (isset($custom_image_file) && $custom_image_file != '' && is_int($custom_image_file)) {
				$icon_style_css = implode("; ",$icon_styles).';';

				$final_img = '<span class="image" style="'.$icon_style_css.'">' . wp_get_attachment_image($custom_image_file, 'thumbnail') . '</span>';
				$the_icon = '';
			}
			?>			
			<div class="feature-item clearfix<?php echo esc_attr($has_bg_class);?> <?php echo esc_attr($text_alignment);?> <?php echo esc_attr($column_class);?> <?php echo esc_attr($text_style);?>" <?php echo esc_attr($border_color);?>>
				<div class="overflow-hidden">
					<div class="feature-item-wrap table-wrap <?php echo esc_attr($dec_open_class);?>">		
						<div class="overlay-wrap" style="background-color: <?php echo esc_attr($overlay_bg_color);?>;">
						</div>
						<div class="image-overlay-wrap"<?php if($bg_image != '') :?> style="background-image: url('<?php echo esc_url($bg_image);?>');"<?php endif;?>>
						</div>
						<div class="table-cell" style="height:<?php echo esc_attr($feature_height);?>;">
							<div class="header">
								<?php echo siteorigin_widget_get_icon( $the_icon, $icon_styles); 
									echo wp_kses_post($final_img);
									echo wp_kses($icon_title_html, $icon_title_kses); 
								?>
							</div>
							<div class="footer">
								<p>
									<?php echo esc_html($description);?>
								</p>	
								<?php if($url != '' && $read_more != '' ) : ?>
								<a  href="<?php echo esc_url($url);?>" class="btn <?php echo esc_attr($button_classes);?>"> 
									<?php echo esc_html($read_more);?> </a>	
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>

			</div>
		<?php endforeach;?>
	<?php if ($instance['option_section']['add_borders'] == 1 ) : ?>
	</div>
	<?php endif;?>
	</div>

</div>