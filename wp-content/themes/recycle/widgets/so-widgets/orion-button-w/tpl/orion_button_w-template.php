<?php  

//prepare variables
$buttontext = $instance['button'];
$button_color = $instance['style_section']['button_color'];
$btn_style = $instance['style_section']['btn_style'];
$icon = $instance['icon_section']['icon'];
$icon_position = $instance['icon_section']['icon_position'];
$url = $instance['url'];
$btn_type = $instance['style_section']['btn_type'];
$btn_size = $instance['style_section']['btn_size'];
$btn_alignment = $instance['style_section']['btn_alignment'];
$new_tab = $instance['new_tab'];
$icon_color	 = $instance['icon_section']['icon_color'];

$button_classes = '';
$icon_style = array();

if ($icon_color!= '') {
	$icon_style[] .= 'color:' . $icon_color;
}

$link = false;
if ($instance['url'] != '') {
	$link = true;
}
if($new_tab == true) {
	$target = 'target=_blank';
} else {
	$target = '';
}

if ($button_color) {
	$button_classes .= $button_color;
}
if ($btn_style) {
	$button_classes .= ' ' . $btn_style;
}
if ( $icon != '' ) {
	$button_classes .= ' ' . $icon_position;
}
if ( $btn_type != '' ) {
	$button_classes .= ' ' . $btn_type;
}
if ( $btn_size != '' ) {
	$button_classes .= ' ' . $btn_size;
}
if ( $btn_alignment != 'center' && $btn_alignment != '' ) {
	$button_classes .= ' ' . $btn_alignment;
}
// get link;
if (preg_match('#^post#', $url) === 1) {
	preg_match_all('!\d+!', $url, $post_id);
	$post_url = get_permalink($post_id[0][0]);
	$url = $post_url;
}
?>
<?php if ($btn_alignment == 'center') : ?>
	<div class="wrapper block" style="text-align:center">
<?php endif;?>

	<?php if($link) : ?>
		<a class="<?php echo esc_attr($button_classes);?>" <?php echo esc_attr($target);?> href="<?php echo esc_url($url);?>">
			<?php //render button content
			if ($icon_position == 'icon-left' || $icon_position == 'inset-left' ) {
				echo siteorigin_widget_get_icon( $icon, $icon_style);
			};
			echo esc_html($buttontext); 

			if ($icon_position == 'icon-right' || $icon_position == 'inset-right' ) {
				echo siteorigin_widget_get_icon( $icon, $icon_style);
			};?>		
		</a>
	<?php else :?>
		<button class="<?php echo esc_attr($button_classes);?>" >
			<?php //render button content
			if ($icon_position == 'icon-left' || $icon_position == 'inset-left' ) {
				echo siteorigin_widget_get_icon( $icon, $icon_style);
			};
			echo esc_html($buttontext); 

			if ($icon_position == 'icon-right' || $icon_position == 'inset-right' ) {
				echo siteorigin_widget_get_icon( $icon, $icon_style);
			};?>
		</button>
	<?php endif;?>

<?php if ($btn_alignment == 'center') : ?>
</div>
<?php endif;?>