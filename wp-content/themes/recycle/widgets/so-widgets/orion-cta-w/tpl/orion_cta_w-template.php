<?php  

//prepare variables

$cta_text = $instance['cta_text'];
$buttontext = $instance['button'];
$top_bottom_padding = $instance['style_section']['top_bottom_padding'];
$text_color = $instance['style_section']['text_color'];
$text_align = $instance['style_section']['text_align'];
$text_size = $instance['style_section']['text_size'];
$button_align = $instance['style_section']['button_align'];
$button_color = $instance['style_section']['button_color'];
$btn_style = $instance['style_section']['btn_style'];
$icon = $instance['icon_section']['icon'];
$icon_position = $instance['icon_section']['icon_position'];
$url = $instance['url'];
$btn_type = $instance['style_section']['btn_type'];
$btn_size = $instance['style_section']['btn_size'];
$new_tab = $instance['new_tab'];
$icon_color	 = $instance['icon_section']['icon_color'];

$button_classes = '';
$icon_style = array();

if ($icon_color!= '') {
	$icon_style[] .= 'color:' . $icon_color;
}

if ($url == '') {
	$url = '#';
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
// get link;
if (preg_match('#^post#', $url) === 1) {
	preg_match_all('!\d+!', $url, $post_id);
	$post_url = get_permalink($post_id[0][0]);
	$url = $post_url;
}?>

<?php 
if ($text_size == 'lead' || $text_size == '') {
	$text_size_start = '<span class="' . $text_size . ' ' . $text_color . '">';
	$text_size_end = '</span>';
} else {
	$text_size_start = '<' . $text_size . ' class="' . $text_color . '">';
	$text_size_end = '</' . $text_size . '>';
}
$cta_text = $text_size_start . $cta_text . $text_size_end;
?>

<div class="wrapper orion-cta <?php if($button_align == 'inline-block') :?> middle_align <?php else :?>clearfix <?php endif;?><?php if($text_align == 'text-center') :?> cta-centered<?php endif;?>" style="padding-top: <?php echo esc_attr($top_bottom_padding);?>px; padding-bottom: <?php echo esc_attr($top_bottom_padding);?>px; ">
	<div class="cta-text <?php echo esc_attr($text_align);?> <?php echo esc_attr($button_align);?>">
		<?php echo wp_kses_post($cta_text);?>
	</div>
	<div class="cta-btn <?php echo esc_attr($button_align);?> <?php echo esc_attr($text_align);?>">
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
	</div>
</div>