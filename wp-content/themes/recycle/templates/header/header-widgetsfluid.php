<?php // header with widgets

/* defaults*/
$hide_header_widgets = false;
/* variables */
$nav_style_class = orion_get_theme_option_css('navigation_style', 'nav-style-1');

// header bg color class (text-color)
$header_bg_color = orion_get_theme_option_css(array('header_background','background-color'), '#fff');

if(orion_isColorLight($header_bg_color)){
	$text_color_class = 'text-dark'; 
} else {
	$text_color_class = 'text-light'; 
}

// widget area width
if (orion_get_option('header_widgets_width', false, 'col-md-8' ) == 'col-md-6') {
	$branding_b_class = 'col-md-6';
	$widget_b_class = 'col-md-6';
} else if (orion_get_option('header_widgets_width', false, 'col-md-8' ) == 'col-md-9') {
	$branding_b_class = 'col-md-3';
	$widget_b_class = 'col-md-9';
} else {
	$branding_b_class = 'col-md-4';
	$widget_b_class = 'col-md-8';
}
$header_overlay = '';
$header_style = orion_get_theme_option_css('navigation_links_color_style', 'nav-dark');
$mobile_logo_color = ' ' . orion_get_theme_option_css('widgetsfluid_header_mobile_logo_color', 'mobile-text-dark');
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

if ( orion_get_option('header_widgets_colorstyle_mobile', false) && orion_get_option('header_widgets_colorstyle_mobile', false) != '' ) {
	$text_color_class .= ' ' . orion_get_option('header_widgets_colorstyle_mobile', false);
}

/* get megamenu color style */
if ($header_style == 'nav-light') {
$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_light','regular'),'rgba(0,0,0,.8)');	
} else {
	$submenu_colors_regular = orion_get_theme_option_css(array('submenu_colors_nav_dark','regular'),'rgba(0,0,0,.8)');
}

if ( orion_get_option('header_width_with_widgets', false, '0') == 1) {
	$container_class = 'container-fluid';
} else {
	$container_class = 'container';
}
?>

<header class="header-with-widgets site-header type-fluid-nav <?php echo esc_attr($header_style);?> <?php echo esc_attr($nav_style_class);?><?php echo esc_attr($header_overlay);?>">
	<div class="mainheader section">
		<div>
			<div class="<?php echo esc_attr($container_class);?>">
				<div class="row">
					<div class="site-branding <?php echo esc_attr($branding_b_class);?> text-left <?php echo esc_attr($text_color_class);?><?php echo esc_attr($mobile_logo_color);?>">
						<?php orion_get_logo(); ?>
					</div>

					<div class="relative-wrap <?php echo esc_attr($widget_b_class);?>">		
						<?php if ($hide_header_widgets != true) :?>
							<div class="row header-widgets text-right <?php echo esc_attr($text_color_class);?>">
								<?php dynamic_sidebar( 'sidebar-widgetsfluid-header' ); ?>
							</div>
						<?php endif;?>
					</div>
					<?php orion_header_mobile_nav();?>					
				</div>
			</div>
 
			<div class="nav-container <?php orion_get_class_cb('is_header_sticky', 'stickynav', 'noclass');?>"> 
				<div class="<?php echo esc_attr($container_class);?>">					
					<div class="row">
						<?php // Navigation ?>
						<div class="col-md-12">
							<nav id="primary-navigation" class="site-navigation" role="navigation">

							<?php orion_get_navigation(array('text-left'), array('nav-menu', 'text-left', 'clearfix'));?>		

			                </nav>
						</div>					
					</div>
				</div>
			</div>
		</div>
	</div>
</header>


