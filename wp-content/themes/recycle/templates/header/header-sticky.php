<?php 
// get sticky header bg color 
$navigation_type = orion_get_theme_option_css('sticky_navigation_style', 'nav-style-1', 'navigation_style');
$header_style = orion_get_theme_option_css('sticky_navigation_links_color_style', 'nav-dark', 'navigation_links_color_style');

if($header_style == 'nav-dark') {
	$color_3 = orion_get_theme_option_css('color_3', '#1F2A44' );
	$header_bg_color = orion_get_theme_option_css(array('sticky_header_background','background-color'),$color_3, 'nav_menu_bg_color_nav_dark');
} else {
	$header_bg_color = orion_get_theme_option_css(array('sticky_header_background','background-color'),"#fff", 'nav_menu_bg_color_nav_light');
}

if(orion_isColorLight($header_bg_color)){
	$text_color_class = 'text-dark'; 
} else {
	$text_color_class = 'text-light'; 
}
?>

<?php if ($header_style == 'nav-light') {
$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_light','regular'),'rgba(0,0,0,.8)');	
} else {
	$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_dark','regular'),'rgba(0,0,0,.8)');
}
?>

<header class="stickymenu hidesticky <?php echo esc_attr($header_style);?> <?php echo esc_attr($navigation_type);?>">
	<div class="nav-container">
		<div class="container">
			 <div class="relativewrap row">
			 	<div class="site-branding absolute left <?php echo esc_attr($text_color_class); ?>">
			 		<?php orion_get_sticky_logo(); ?>
			 	</div>
			 	<div class="col-md-12 site-navigation">
			 	<?php orion_get_navigation(array('text-left','clearfix'), array('float-right'));?>		 			
			 	</div>	 	
			</div>
		</div>
	</div>
</header>
