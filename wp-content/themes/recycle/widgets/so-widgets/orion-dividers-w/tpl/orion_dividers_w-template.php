<?php  //prepare variables
	$divider_style = $instance['divider_style'];
	$divider_color = $instance['divider_color'];
	$divider_color_opacity = ($instance['divider_color_opacity'] / 100);
	$divider_color = orion_hextorgba($divider_color, $divider_color_opacity);
	
	$height = $instance['height'];
	$width = $instance['width'];
	$margin_top = $instance['margin_top'];
	$margin_bottom = $instance['margin_bottom'];

	$style_css = 'border-top-width:' . esc_attr($height) . 'px; border-top-color:' . esc_attr($divider_color) .
	'; border-style: ' . esc_attr($divider_style) . '; width: ' . esc_attr($width) . '%; ';

	if ( $margin_top != '') {
		$style_css .= ' margin-top:' . $margin_top . 'px;';
	} else {
		$style_css .= ' margin-top: 0;';
	}
	if ( $margin_bottom != '') {
		$style_css .= ' margin-bottom:' . $margin_bottom . 'px;';
	}	
?>
	<hr style="<?php echo esc_attr($style_css);?>">