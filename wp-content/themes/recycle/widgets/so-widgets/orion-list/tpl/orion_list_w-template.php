<?php  //prepare variables
	$column_class = 'col-md-12';
	$list_text_color = $instance['style_section']['list_text_color'];
	$text_color = $instance['text_color'];
	$icon_size = $instance['style_section']['icon_size'];
	$list_bg_color = 'transparent';
	$list_wrap_class = $icon_size;
	$list_padding = $instance['style_section']['list_padding'];
	$hex = $instance['style_section']['list_bg_color'];
	$alpha = ($instance['style_section']['bg_opacy']/100);
	if ($hex) {
		$list_bg_color = orion_hextorgba($hex, $alpha);	
		$list_wrap_class .= ' padding-medium';
	}

	$icon_styles = array();	 
	if (isset($instance['style_section']['list_icon_color']) && $instance['style_section']['list_icon_color'] != '' ) {
		$icon_styles[] = 'color: '. $instance['style_section']['list_icon_color'];
	} else {
		$icon_styles[] = 'color: '. orion_get_theme_option_css('main_theme_color', '#1CBAC8' );
	}
	$list_styles = '';
	if ($instance['style_section']['list_text_color'] != '' ) {
		$list_styles .= 'color:'. $instance['style_section']['list_text_color'] . ';';
	}
	if ($list_padding != 12) {
		$list_styles .= 'padding-bottom:'. $list_padding . 'px;';
	}
	if ($list_styles != '') {
		$list_styles = 'style=\''.$list_styles.'\'';
	}
?>
<div class="row button-wrap">
	<?php
	if(!empty($instance['title'])) : ?>
		<div class="col-md-12 entry-header">
			<h2 class="h5 widget-title <?php echo esc_attr($text_color);?>"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>

	<div class="list-wrap <?php echo esc_attr($column_class);?>">
		<ul class="no-liststyle <?php echo esc_attr($list_wrap_class);?>" style="background:<?php echo esc_attr($list_bg_color);?>">
	<?php foreach ($instance['widget_repeater'] as $list_item) : ?>
		<?php // set variables:
		$list_name = $list_item['list_name'];		
		$list_icon = $list_item['list_icon'];

		?>	
		<li class="<?php echo esc_attr($text_color);?>" <?php echo wp_kses_post($list_styles);?>>
			<?php if (isset($list_icon) && $list_icon != "") :?>
				<span class="icon">
					<?php echo siteorigin_widget_get_icon( $list_icon, $icon_styles); ?>
				</span>
			<?php endif; ?>
				<?php echo wp_kses_post($list_name);?>
		</li>	

	<?php endforeach;?>
		</ul>
	</div>
</div>