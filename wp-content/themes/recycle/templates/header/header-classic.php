<?php 
/* defaults*/
$hide_header_widgets = false;
$header_overlay = '';
// variables
$nav_style_class = orion_get_theme_option_css('navigation_style', 'nav-style-1');
$header_style = orion_get_theme_option_css('navigation_links_color_style', 'nav-dark');
$widgets_color = orion_get_option('classicheader_widgets_colorstyle', false);

if($header_style == 'nav-dark') {
	$color_3 = orion_get_theme_option_css('color_3', '#1F2A44' );
	$header_bg_color = orion_get_theme_option_css(array('classic_header_background','background-color'), $color_3, 'nav_menu_bg_color_nav_dark');	
} else {
	$header_bg_color = orion_get_theme_option_css(array('classic_header_background','background-color'), '#fff', 'nav_menu_bg_color_nav_light');
}
 
if(orion_isColorLight($header_bg_color)){
	$text_color_class = 'text-dark'; 
} else {
	$text_color_class = 'text-light'; 
}

$search_class = '';
if ( orion_get_theme_option_css('search_icon') ) {
	$search_class = 'has_search';
}

$mobile_logo_color = ' ' . orion_get_theme_option_css('classicheader_mobile_logo_color', 'mobile-text-dark');
/* 
- transparent header 
- hide widget area
- mobile header color
*/
if (is_page()|| is_single() ) {
	$orion_wp_meta = get_post_meta( get_the_ID() );
	if (isset($orion_wp_meta['_recycle_transparent_header']) && ($orion_wp_meta['_recycle_transparent_header'][0] == 'on')) {
		$nav_style_class .= ' header-transparent';
	}

	if (isset($orion_wp_meta['_recycle_transparent_header_text_color']) && ($orion_wp_meta['_recycle_transparent_header_text_color'][0] != '')){
		$text_color_class = $orion_wp_meta['_recycle_transparent_header_text_color'][0];
		$widgets_color = $orion_wp_meta['_recycle_transparent_header_text_color'][0];
		
		if ($orion_wp_meta['_recycle_transparent_header_text_color'][0] == 'text-light') {
			$header_style = 'nav-dark';

		} else {
			$header_style = 'nav-light';
		}
	}
	if (isset($orion_wp_meta['_recycle_hide_header_widget']) && $orion_wp_meta['_recycle_hide_header_widget'] == true) {
		$hide_header_widgets = true;	
	}
	if (isset($orion_wp_meta['_recycle_header_overlay']) && $orion_wp_meta['_recycle_header_overlay'][0] != '') {
		$header_overlay = ' ' . $orion_wp_meta['_recycle_header_overlay'][0];	
	}
	if (isset($orion_wp_meta['_recycle_mobile_logo_color']) && $orion_wp_meta['_recycle_mobile_logo_color'][0] != '') {

		$mobile_logo_color = ' ' . $orion_wp_meta['_recycle_mobile_logo_color'][0];	
	}	
}

if ( orion_get_option('header_width_classic', false, '0') == 1) {
	$container_class = 'container-fluid';
} else {
	$container_class = 'container';
}

if ($header_style == 'nav-light') {
$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_light','regular'),'rgba(0,0,0,.8)');	
} else {
	$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_dark','regular'),'rgba(0,0,0,.8)');
}


$mobile_widgets_color = '';
if (orion_get_option('classicheader_widgets_colorstyle_mobile', false) && orion_get_option('classicheader_widgets_colorstyle_mobile', false) != '' ) {
	$mobile_widgets_color .= ' ' . orion_get_option('classicheader_widgets_colorstyle_mobile', false);
}
?>

<header class="header-classic site-header mainheader <?php echo esc_attr($header_style);?> <?php echo esc_attr($nav_style_class);?><?php echo esc_attr($header_overlay);?>">
	<div class="site-branding hidden-lg hidden-md <?php echo esc_attr($text_color_class); ?><?php echo esc_attr($mobile_logo_color);?>">
		<?php orion_get_logo(); ?>
	</div>
	<?php orion_header_mobile_nav();?>
	<div class="nav-container">
		<div class="<?php echo esc_attr($container_class);?>">
			 <div class="relativewrap row header-set-height">
			 	<div class="site-branding absolute left visible-md visible-lg <?php echo esc_attr($text_color_class); ?>">
			 		<?php orion_get_logo(); ?>
			 	</div>
			 	<div class="site-navigation stickynav <?php echo esc_attr($search_class);?>">
			 		<?php orion_get_navigation(array('text-left', 'clearfix'), array('float-right'));?>				 		
			 	</div>	 	
			</div>
		</div>
	</div>
	<?php if(is_active_sidebar( 'sidebar-header' ) && orion_get_option('classicheader_widgets_switch', false, '0' == 1) && $hide_header_widgets != true) : ?>
		<div class="widget-section <?php echo esc_attr($widgets_color);?>">
			<div class="<?php echo esc_attr($container_class);?>">
				
				<div class="header-widgets row<?php echo esc_attr($mobile_widgets_color);?>">
					<?php dynamic_sidebar( 'sidebar-header' ); ?>	
				</div>
				
			</div>	
		</div>
	<?php endif;?>
</header>
