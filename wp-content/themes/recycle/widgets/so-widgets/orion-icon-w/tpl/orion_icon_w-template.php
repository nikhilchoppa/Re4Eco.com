<?php // variables
	$icon_link_style = '';
	$icon_repeater = $instance['icon_repeater'];
	$icons_classes = $instance['style_section']['icons_type'];
	$icons_classes .= ' ' . $instance['style_section']['icon_color'];
	$icons_classes .= ' ' . $instance['style_section']['icon_size'];
	$icons_classes .= ' ' . $instance['style_section']['icon_style'];

	$space_between_icons = intval($instance['style_section']['space_between_icons']) -2;
	if (is_int($space_between_icons)) {
		$icon_link_style = "style=margin-right:".$space_between_icons."px"; 
	}
?>
<div class="row icon-row">

	<?php //title
	if(!empty($instance['title'])) : ?>
		<div class="col-md-12 widget-header">
			<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>
	<div class="icon wrapper col-md-12">
		<?php foreach ($icon_repeater as $o_icon) :?>

			<?php $icon_classes = $icons_classes . ' ' .$o_icon['icon_color']; ?>
			<?php $url = $o_icon['url'];
				if (preg_match('#^post#', $url) === 1) {
					preg_match_all('!\d+!', $url, $post_id);
					$post_url = get_permalink($post_id[0][0]);
					$url = $post_url;
				} 
				if ($url == '') {
					$url = '#';
				}
			?>

			<?php $icon = $o_icon['icon'];
			$icon_style = array();
			$icon_color = $o_icon['icon_color'];
			if ($icon_color!= '') {
				$icon_style[] .= 'color:' . $icon_color;
			}?>

			<?php	
			$new_tab = $o_icon['new_tab'];
			if($new_tab == true) {
				$target = 'target=_blank';
			} else {
				$target = '';
			}
			$link_atts = $target; ?>
		
			<a href="<?php echo esc_url($url);?>" class="btn btn-icon <?php echo esc_attr($icon_classes)?>" <?php echo esc_attr($link_atts);?> <?php echo esc_attr($icon_link_style);?>>
				<?php echo siteorigin_widget_get_icon( $icon, $icon_style);?>
			</a>
		<?php endforeach;?>
	</div>
</div>