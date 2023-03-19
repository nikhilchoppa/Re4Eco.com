<?php  //prepare variables
$nav_menu = $instance['menu_option'];
$text_color_class = $instance['style_section']['text_color_class'];
$hex = $instance['style_section']['bg_color'];
$alpha = ($instance['style_section']['bg_opacy']/100);
if ($hex) {
	$bg_color = orion_hextorgba($hex, $alpha);
} else {
	$bg_color = orion_get_option('main_theme_color', false, '#22AA86' );
}
?>

<?php //title
if(!empty($instance['title'])) : ?>
	<div class="widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>
<div class="widget_nav_menu <?php echo esc_attr($text_color_class);?> menu-padding" style="background:<?php echo esc_attr($bg_color);?>">
<?php
		$nav_menu_args = array(
			'fallback_cb' => '',
			'menu'        => $nav_menu
		);
		wp_nav_menu( apply_filters( 'widget_nav_menu_args', $nav_menu_args, $nav_menu, $args, $instance ) );
?>		
</div>