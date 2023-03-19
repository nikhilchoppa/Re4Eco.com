<?php 
/*********************************** O.o **********************************/
/*                           TEMPLATE FUNCTIONS                           */
/**************************************************************************/
/**
 * @return template
 */

if(!function_exists('orion_get_top_bar')) {
	function orion_get_top_bar() {	
	global $orion_options;
	if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
	if (isset($orion_options['top_bar_onoff']) && $orion_options['top_bar_onoff']==1) {
		return( get_template_part( 'templates/header/topbar', 'leftright' ));}
	}
}
/* favicon support */
function orion_site_icon_sizes($sizes) {
	$sizes = array(16, 32, 64, 72, 120);
    return $sizes;
}
add_filter('site_icon_image_sizes', 'orion_site_icon_sizes');

function orion_site_icon_meta_tags($tags) {
    $tags[] = sprintf('<link rel="icon" href="%s" sizes="16x16" />', esc_url(get_site_icon_url(null, 16)));
    $tags[] = sprintf('<link rel="icon" href="%s" sizes="32x32" />', esc_url(get_site_icon_url(null, 32)));
    $tags[] = sprintf('<link rel="icon" href="%s" sizes="64x64" />', esc_url(get_site_icon_url(null, 64)));
    $tags[] = sprintf('<link rel="icon" href="%s" sizes="72x72" />', esc_url(get_site_icon_url(null, 72)));
    $tags[] = sprintf('<link rel="icon" href="%s" sizes="120x120" />', esc_url(get_site_icon_url(null, 120)));

    return $tags;
}
add_filter('site_icon_meta_tags', 'orion_site_icon_meta_tags');

/* Global defaults */
if(!function_exists('orion_get_orion_defaults')) {
	function orion_get_orion_defaults() {
	$orion_defauls = array ( 'last_tab' => '', 'main_theme_color' => '#22AA86', 'secondary_theme_color' => '#9CC026', 'color_3' => '#44514E', 'site_background_color' => '#F2F4F4', 'page_404' => '', 'back_to_top' => '0', 'one_page' => '0', 'comments_posts' => '1', 'comments_pages' => '1', 'swipebox_bars_mobile' => '0', 'minimize_css' => '1', 'logo_upload_dark' => array ( 'url' => '', 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), 'logo_upload_light' => array ( 'url' => '', 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), 'logo_upload_sticky' => array ( 'url' => '', 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), 'text_logo' => '', 'logo_max_dimensions' => array ( 'width' => '', 'height' => '', ), 'content_font' => array ( 'font-family' => 'Source Sans Pro', 'font-options' => '', 'google' => '1', 'subsets' => '', ), 'title_font' => array ( 'font-family' => 'Montserrat', 'font-options' => '', 'google' => '1', 'subsets' => '', ), 'button_nav_font' => array ( 'font-family' => 'Montserrat', 'font-options' => '', 'google' => '1', 'subsets' => '', ), 'paragraph_colors_dark' => '#000000', 'paragraph_colors_dark_opacity' => '0.6', 'heading_colors_dark' => '#000000', 'heading_colors_dark_opacity' => '0.8', 'link_colors_dark' => array ( 'regular' => '#000', 'hover' => '', 'active' => '', ), 'link_colors_dark_opacity' => '0.7', 'pagetitle_colors_dark' => '#000000', 'pagetitle_colors_dark_opacity' => '0.85', 'meta_colors_dark' => array ( 'regular' => '#000', 'hover' => '#000', ), 'meta_colors_dark_opacity' => '0.7', 'paragraph_colors_light' => '#ffffff', 'paragraph_colors_light_opacity' => '0.8', 'heading_colors_light' => '#ffffff', 'heading_colors_light_opacity' => '0.95', 'link_colors_light' => array ( 'regular' => '#ffffff', 'hover' => '#ffffff', 'active' => '#ffffff', ), 'link_colors_light_opacity' => '0.9', 'pagetitle_colors_light' => '#ffffff', 'pagetitle_colors_light_opacity' => '0.95', 'meta_colors_light' => array ( 'regular' => '#ffffff', 'hover' => '#ffffff', ), 'meta_colors_light_opacity' => '0.7', 'body-font' => array ( 'font-family' => 'Source Sans Pro', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '14px', 'line-height' => '24px', 'word-spacing' => '', 'letter-spacing' => '', ), 'lead-font' => array ( 'font-family' => 'Source Sans Pro', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '21px', 'line-height' => '30px', 'word-spacing' => '', 'letter-spacing' => '', ), 'blockquote-font' => array ( 'font-family' => 'Source Sans Pro', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '400', 'font-style' => 'italic', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '21px', 'line-height' => '30px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h1-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '45px', 'line-height' => '48px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h1_font_color' => '#000000', 'h1_opacity' => '0.6', 'h2-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '32px', 'line-height' => '36px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h2_font_color' => '#000000', 'h2_opacity' => '0.8', 'h3-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '24px', 'line-height' => '30px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h3_font_color' => '#000000', 'h3_opacity' => '0.8', 'h4-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '20px', 'line-height' => '24px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h4_font_color' => '#000000', 'h4_opacity' => '0.8', 'h5-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '18px', 'line-height' => '24px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h5_font_color' => '#000000', 'h5_opacity' => '0.8', 'h6-font' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-backup' => '', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-align' => '', 'text-transform' => '', 'font-size' => '16px', 'line-height' => '24px', 'word-spacing' => '', 'letter-spacing' => '', ), 'h6_font_color' => '#000000', 'h6_opacity' => '0.8', 'boxed_fullwidth' => '1', 'boxed_site_background_color' => '#BEC8C6', 'pattern_type' => '1', 'boxed_site_background' => array ( 'background-repeat' => '', 'background-size' => '', 'background-attachment' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'boxed_site_width' => '1350', 'boxed_site_padding' => '90', 'boxed_top_margin' => array ( 'margin-top' => '36px', 'margin-bottom' => '36px', ), 'passepartout' => '0', 'passepartout_size' => array ( 'width' => '30', 'height' => '30', ), 'passepartout_color' => '#BEC8C6', 'page-sidebar-left-defauts' => '', 'page-sidebar-right-defauts' => '', 'page_topbottom_spacing' => array ( 'padding-top' => '60px', 'padding-bottom' => '60px', ), 'orion_header_type' => 'classic', 'header_transparency' => '0', 'classic_header_background' => array ( 'background-color' => '', 'background-repeat' => '', 'background-size' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'header_hight_classic' => '132', 'classicheader_mobile_logo_color' => 'mobile-text-dark', 'header_width_classic' => '0', 'logo_position_hight_classic' => '50', 'classicheader_widgets_switch' => '', 'classic_headerwidgets_background_color' => '', 'classicheader_widgets_colorstyle' => 'text-dark', 'classicheader_widgets_colorstyle_mobile' => '', 'classic_header_widgets_spacing' => array ( 'padding-top' => '24px', 'padding-bottom' => '12px', ), 'header_background' => array ( 'background-color' => '#ffffff', 'background-repeat' => '', 'background-size' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'header_hight_with_widgets' => '96', 'navbar_hight_with_widgets' => '96', 'header_width_with_widgets' => '0', 'widgetsfluid_header_mobile_logo_color' => 'mobile-text-dark', 'logo_position_hight_with_widgets' => '50', 'widgetsfluid_widgets_switch' => '1', 'header_widgets_width' => 'col-md-8', 'widgetsfluid_header_widgets_spacing' => array ( 'padding-top' => '24px', 'padding-bottom' => '12px', ), 'header_widgets_colorstyle' => 'text-dark', 'header_widgets_colorstyle_mobile' => '', 'top_bar_onoff' => '0', 'topbar_background' => '', 'topbar_text_color' => 'text-light', 'topbar_divider_left' => '1', 'topbar_divider_right' => '1', 'topbar_border_color' => array ( 'color' => '#000', 'alpha' => '0.1', 'rgba' => 'rgba(0,0,0,0.1)', ), 'is_top_bar_fluid' => '0', 'is_top_bar_always_open' => '0', 'navigation_links_color_style' => 'nav-light', 'navigation_style' => 'nav-style-3', 'orion_megamenu' => '1', 'mega_menu_background' => array ( 'background-color' => '#ffffff', 'background-repeat' => '', 'background-size' => '', 'background-attachment' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'mega_menu_borders' => 'mega-light-borders', 'first-lvl-menu' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-transform' => 'uppercase', 'font-size' => '14px', 'letter-spacing' => '', ), 'second-lvl-menu' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-weight' => '', 'font-style' => '', 'subsets' => '', 'text-transform' => 'uppercase', 'font-size' => '12px', 'letter-spacing' => '1px', ), 'mobile_menu_background' => '', 'mobile_menu_link_colors' => array ( 'regular' => '', 'active' => '', ), 'search_icon' => '0', 'site_search_bg_color' => '#1a7f65', 'is_header_sticky' => '0', 'sticky_header_background' => array ( 'background-color' => '#ffffff', 'background-repeat' => '', 'background-size' => '', 'background-attachment' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'sticky_navigation_links_color_style' => '', 'sticky_navigation_style' => '', 'display_header_button' => '1', 'button_link_url' => '#', 'button_text' => 'Button', 'header_button_color' => 'btn-c2', 'header_button_rounding' => '', 'last_tab_size' => 's36', 'nav_menu_bg_color_nav_light' => '', 'first_lvl_menu_colors_nav_light' => array ( 'regular' => 'rgba(0,0,0,.8)', 'hover' => '', 'active' => '', ), 'first_lvl_menu_bg_nav_light' => array ( 'regular' => '', 'hover' => '', 'active' => 'rgba(34, 170, 134, 0.15)', ), 'submenu_colors_nav_light' => array ( 'regular' => '#ffffff', 'hover' => '', 'active' => '', ), 'submenu_background_nav_light' => array ( 'color' => '#000', 'alpha' => '0.9', 'rgba' => 'rgba(0,0,0,0.9)', ), 'submenu_border_nav_light' => array ( 'color' => '#000', 'alpha' => '0.2', 'rgba' => 'rgba(0,0,0,0.2)', ), 'nav_menu_bg_color_nav_dark' => '', 'first_lvl_menu_colors_nav_dark' => array ( 'regular' => 'rgba(255, 255, 255, 0.8)', 'hover' => 'rgba(255, 255, 255, 1)', 'active' => 'rgba(255, 255, 255, 1)', ), 'first_lvl_menu_bg_nav_dark' => array ( 'regular' => '', 'hover' => 'rgba(0, 0, 0, 0.05)', 'active' => 'rgba(0, 0, 0, 0.15)', ), 'submenu_colors_nav_dark' => array ( 'regular' => 'rgba(0,0,0,.8)', 'hover' => '', 'active' => '', ), 'submenu_background_nav_dark' => array ( 'color' => '#fff', 'alpha' => '0.95', 'rgba' => 'rgba(255,255,255,0.95)', ), 'submenu_border_nav_dark' => array ( 'color' => '#000', 'alpha' => '0.1', 'rgba' => 'rgba(0,0,0,0.1)', ), 'post_heading_type' => 'classic', 'title_single_post_onoff' => '0', 'default_overlay' => '', 'post-heading-background-classic' => array ( 'background-color' => '', 'background-repeat' => 'no-repeat', 'background-size' => 'cover', 'background-attachment' => '', 'background-position' => 'center center', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'post-heading-padding-classic' => array ( 'padding-top' => '30px', 'padding-bottom' => '30px', ), 'post-heading-title-classic' => array ( 'font-family' => 'Montserrat', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'text-transform' => 'none', 'font-size' => '21px', 'line-height' => '24px', 'word-spacing' => '', 'letter-spacing' => '0', ), 'pagetitle_font_color_classic' => '#ffffff', 'pagetitle_opacity_classic' => '0.9', 'crumbs-onoff-classic' => '1', 'crumbs-font-classic' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'font-size' => '12px', 'letter-spacing' => '1px', 'color' => '#fff', ), 'post-heading-background-centered' => array ( 'background-color' => '', 'background-repeat' => 'no-repeat', 'background-size' => 'cover', 'background-attachment' => '', 'background-position' => 'center center', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'post-heading-padding-centered' => array ( 'padding-top' => '72px', 'padding-bottom' => '60px', ), 'post-heading-title-centered' => array ( 'font-family' => 'Montserrat', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'text-transform' => 'capitalize', 'font-size' => '42px', 'line-height' => '48px', 'word-spacing' => '', 'letter-spacing' => '', ), 'pagetitle_font_color_centered' => '#ffffff', 'pagetitle_opacity_centered' => '0.9', 'crumbs-onoff-centered' => '1', 'crumbs-font-centered' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'font-size' => '12px', 'letter-spacing' => '1px', 'color' => '#fff', ), 'post-heading-background-left' => array ( 'background-color' => '', 'background-repeat' => 'no-repeat', 'background-size' => 'cover', 'background-attachment' => '', 'background-position' => 'center center', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'post-heading-padding-left' => array ( 'padding-top' => '72px', 'padding-bottom' => '72px', ), 'post-heading-title-left' => array ( 'font-family' => 'Montserrat', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'text-transform' => 'none', 'font-size' => '42px', 'line-height' => '48px', 'word-spacing' => '', 'letter-spacing' => '', ), 'pagetitle_font_color_leftaligned' => '#ffffff', 'pagetitle_opacity_leftaligned' => '0.9', 'crumbs-onoff-left' => '1', 'crumbs-font-left' => array ( 'font-family' => '', 'font-options' => '', 'google' => '1', 'font-weight' => '400', 'font-style' => '', 'subsets' => '', 'font-size' => '12px', 'letter-spacing' => '1px', 'color' => '#fff', ), 'blog_layout' => 'classic', 'archive_blog_sidebar_left_defaults' => '', 'archive_blog_sidebar_right_defaults' => 'sidebar-default', 'blog_content_bg' => '#ffffff', 'postmeta_settings' => array ( 1 => '1', 2 => '1', 3 => '1', 4 => '', ), 'post-sidebar-left-defauts' => '', 'post-sidebar-right-defauts' => 'sidebar-default', 'share-icons' => array ( 'facebook' => '1', 'twitter' => '1', 'google' => '1', ), 'portfolio_sidebar_left_defaults' => '', 'portfolio_sidebar_right_defaults' => 'sidebar-default', 'portfolio_number_columns' => 'col-md-4', 'uncoveringfooter_switch' => '', 'mainfooter-sidebars' => '4', 'footer_text_colors' => 'auto', 'footer_background' => array ( 'background-color' => '', 'background-repeat' => '', 'background-size' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'footer_spacing' => array ( 'padding-top' => '60px', 'padding-bottom' => '48px', ), 'prefooter_switch' => '0', 'prefooter-sidebars' => '2', 'prefooter_text_colors' => '', 'prefooter_background' => array ( 'background-color' => '', 'background-repeat' => '', 'background-size' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'prefooter_spacing' => array ( 'padding-top' => '60px', 'padding-bottom' => '60px', ), 'copyrightarea_switch' => '1', 'copyrightfooter-sidebars' => '2', 'copyright_text_colors' => 'auto', 'copyright_background' => array ( 'background-color' => '', 'background-repeat' => '', 'background-size' => '', 'background-position' => '', 'background-image' => '', 'media' => array ( 'id' => '', 'height' => '', 'width' => '', 'thumbnail' => '', ), ), 'copyright_footer_spacing' => array ( 'padding-top' => '17px', 'padding-bottom' => '17px', ), 'add-sidebars' => array ( 0 => 'Orion custom sidebar', ), 'orion_custom_css_editor' => '', );

	return $orion_defauls;
	}
}

/**
 * @return header template
 */
if(!function_exists('orion_get_header')) {
	function orion_get_header() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}

		if (isset($orion_options["orion_header_type"])) {
			return( get_template_part( 'templates/header/header', $orion_options["orion_header_type"] ));
		} else	{
			return( get_template_part( 'templates/header/header', 'classic' ));
		}

	}
}

if(!function_exists('orion_get_stickyHeader')) {
	function orion_get_stickyHeader() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		if (isset($orion_options["is_header_sticky"]) && $orion_options["is_header_sticky"] == '1') {
			return( get_template_part( 'templates/header/header', 'sticky' ));
		}
	}
} 

/**
 * @return breadcrumbs
 */
if(!function_exists('orion_get_breadcrumbs')) {
	function orion_get_breadcrumbs($heading_type) {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		$orion_breadcrumbs_option = 'crumbs-onoff-'.$heading_type;
		if (isset($orion_options[$orion_breadcrumbs_option]) && $orion_options[$orion_breadcrumbs_option] == '1') {
			return( get_template_part( 'templates/heading/content', 'breadcrumbs' ) );
		} 
	}
}

if(!function_exists('orion_hextorgba')) {
	function orion_hextorgba($hex, $alpha = false) {
	   $hex = str_replace('#', '', $hex);
	   if ( strlen($hex) == 6 ) {
	      $rgb['r'] = hexdec(substr($hex, 0, 2));
	      $rgb['g'] = hexdec(substr($hex, 2, 2));
	      $rgb['b'] = hexdec(substr($hex, 4, 2));
	   }
	   else if ( strlen($hex) == 3 ) {
	      $rgb['r'] = hexdec(str_repeat(substr($hex, 0, 1), 2));
	      $rgb['g'] = hexdec(str_repeat(substr($hex, 1, 1), 2));
	      $rgb['b'] = hexdec(str_repeat(substr($hex, 2, 1), 2));
	   }
	   else {
	      $rgb['r'] = '0';
	      $rgb['g'] = '0';
	      $rgb['b'] = '0';
	   }
	   if ( $alpha ) {
	      $rgb['a'] = $alpha;
	   } else {
	   	 $rgb['a'] = '1';
	   }
	   return 'rgba(' . $rgb['r'] .','. $rgb['g'] .','. $rgb['b'].','. $rgb['a']. ')';
	}
}

/**
 * darken / lighten
 **/
if(!function_exists('orion_adjustBrightness')) {
	function orion_adjustBrightness($hex, $steps) {
	    // Steps should be between -255 and 255. Negative = darker, positive = lighter
	    $steps = max(-255, min(255, $steps));

	    // Normalize into a six character long hex string
	    $hex = str_replace('#', '', $hex);
	    if (strlen($hex) == 3) {
	        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
	    }

	    // Split into three parts: R, G and B
	    $color_parts = str_split($hex, 2);
	    $return = '#';

	    foreach ($color_parts as $color) {
	        $color   = hexdec($color); // Convert to decimal
	        $color   = max(0,min(255,$color + $steps)); // Adjust color
	        $return .= str_pad(dechex($color), 2, '0', STR_PAD_LEFT); // Make two char hex code
	    }

	    return $return;
	}
}

if (!function_exists('orion_isColorLight')) {
	function orion_isColorLight($hex) {
	   $hex       = str_replace('#', '', $hex);
	   $r         = (hexdec(substr($hex, 0, 2)) / 255);
	   $g         = (hexdec(substr($hex, 2, 2)) / 255);
	   $b         = (hexdec(substr($hex, 4, 2)) / 255);
	   $lightness = round((((max($r, $g, $b) + min($r, $g, $b)) / 2) * 100));
	   return ($lightness >= 50 ? true : false);
	}
}	
/**
 * 
 * add search to the menu
 * @return search icon markup in main menu.
 *
 * used in templates/header/header-*
 */

if (!function_exists('orion_nav_wrap')) {
	function orion_nav_wrap() {
		$last_tab_html = '';
		$search_icon = false;
		$woocart = false;
		$cta_button = false;
		$search_HTML_class = '';
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		
		if (isset($orion_options['last_tab_size'])) {
			$last_tab_size = $orion_options['last_tab_size'];
		} else {
			$last_tab_size = 's48';
		}

		switch ($last_tab_size) {
		    case "s48":
		    	$last_tab_class = 'style-medium';
		    	break;
			case "s36":
				$last_tab_class = 'style-small';
				break;
			case "s60":
				$last_tab_class = 'style-large';
				break;				
			default:
				$last_tab_class = 'style-medium';
				break;
		}

		if (isset($orion_options['search_icon']) && $orion_options['search_icon'] != '0') {
			$search_icon = $orion_options['search_icon'];
		    $search_link = '<li class="menu-item search simple search-toggle">';
		    $search_link .= '<div class="to-x">';
		    $search_link .= '<div class="search-box">';
			$search_link .= '<div class="circle top"></div>';
			$search_link .= '<div class="circle bottom"></div>';
			$search_link .= '<div class="handle"></div>';
			$search_link .= '</div>';
		    $search_link .= '</div>';
		    $search_link .= '</li>';
		    $search_icon = true;			
		} else {
			$search_link = "";
		}

		if( class_exists( 'WooCommerce' ) && isset($orion_options['woo_cart']) && $orion_options['woo_cart']!='0') {
			ob_start();
			woocommerce_mini_cart();
			$woo_cart = '<li class="woocart">';
			$woo_cart .= ob_get_contents();
			$woo_cart .= '</li>';
			ob_end_clean();	
			$woocart = true;
		} else {
			$woo_cart = '';
		}

		$menu_btn = orion_get_menu_button();
		if(strlen($menu_btn) > 10) {
			$cta_button = true;
		} 
		$mobile_menu_toggle = '<div class="search-form hidden-md hidden-lg">';
	    $mobile_menu_toggle .= get_search_form($echo = false);
	    $mobile_menu_toggle .= '</div>';

		$last_tab_html = "<li class='last-tab " . $last_tab_class . "'>";
		$last_tab_html .= $mobile_menu_toggle;
		$last_tab_html .= '<div class="last-tab-wrap"> <ul>';
		$last_tab_html .= $woo_cart . $search_link . $menu_btn; 
		$last_tab_html .= '</ul></div>';
		$last_tab_html .= '</li>';

	    if ($search_icon == false && $cta_button == false && $woocart == false) {
	    	$last_tab_html = '';
	    }

		$wrap  = '<ul id="%1$s" class="%2$s">';
	    $wrap .= '%3$s';
	    $wrap .= $last_tab_html;
	    $wrap .= '</ul>';

		return $wrap;
	}
}
 
/**
 * @return passpartout
 */
if(!function_exists('orion_get_passepartout')) {
	function orion_get_passepartout() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		$recycle_passepartout_data = "";
		if (!isset($orion_options['passepartout'])) {
			return;
		}
		$is_fullwidth = $orion_options['boxed_fullwidth']; 
		if($is_fullwidth != 1) {
			return;	
		}
		if ($orion_options['passepartout'] != '1') {
			return;
		//passpartue data exists
		} else {			
			/* passpart height */
			if ( $orion_options['passepartout_size']['height'] != '' ) {
				$passpartuet_height = $orion_options['passepartout_size']['height'];
			} else {
				$passpartuet_height = '24';
			}

			/* passpart width */
			if ( $orion_options['passepartout_size']['width'] != '' ) {
				$passpartuet_width = $orion_options['passepartout_size']['width'];
			} else {
				$passpartuet_width = '24';
			}

			/* passpart color */
			if ( $orion_options['passepartout_color'] != '' ) {
				$passepartout_color = $orion_options['passepartout_color'];
			} else {
				$passepartout_color = 'f8f8f8';
			}
			$recycle_passepartout_data .= ' data-passepartoutheight='.$passpartuet_height;
			$recycle_passepartout_data .= ' data-passepartoutwidth='.$passpartuet_width;
			$recycle_passepartout_data .= ' data-passepartoutcolor='.$passepartout_color;
		}

		echo esc_attr($recycle_passepartout_data);
	}
}

if(!function_exists('orion_get_sticky_logo')) {
	function orion_get_sticky_logo() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		/* get logo alt text */
		if(isset($orion_options['text_logo']) && $orion_options['text_logo'] != ''){
			$logo_text = $orion_options['text_logo'];
		} else {
			$logo_text = get_bloginfo('name');
		}
		
		/* display sticky logo if there is one, else display normal logo */
		if(isset($orion_options['logo_upload_sticky']) && $orion_options['logo_upload_sticky'] != '' && $orion_options['logo_upload_sticky']['url'] != '') : ?>
		<?php $logo_sticky = $orion_options['logo_upload_sticky']['url'];
		?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo wp_kses_post( $logo_text );?>" class="logo logo-sticky">
				<img src="<?php echo esc_url($logo_sticky); ?>" alt="<?php echo wp_kses_post( $logo_text );?>" />
			</a>
		<?php else : ?>
			<?php orion_get_logo();?>
		<?php endif;
	}
}

if(!function_exists('orion_get_logo')) {
	function orion_get_logo() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}

		$logo_light = false;
		$logo_dark = false;
		$logos = 0;

		if(isset($orion_options['text_logo']) && $orion_options['text_logo'] != ''){
			$logo_text = $orion_options['text_logo'];
		} else {
			$logo_text = get_bloginfo('name');
		}
		if( isset($orion_options['logo_upload_light']['url']) && $orion_options['logo_upload_light']['url'] != "" ) {
			$logo_light = $orion_options['logo_upload_light']['url'];
			$logo = $logo_light;
			$logos ++;
		} 
		if( isset($orion_options['logo_upload_dark']['url']) && $orion_options['logo_upload_dark']['url'] != "" ) {
			$logo_dark = $orion_options['logo_upload_dark']['url'];
			$logo = $logo_dark;
			$logos ++;
		}	

		if ($logos == 0) : ?>
			<a class="site-title logo text-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="h4"><?php echo wp_kses_post( $logo_text );?></span></a>

		<?php elseif ($logos == 1) : ?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo wp_kses_post( $logo_text );?>" class="logo logo-default">
				<img src="<?php echo esc_url($logo); ?>" alt="<?php echo wp_kses_post( $logo_text );?>" />
			</a>

		<?php else : ?>

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo wp_kses_post( $logo_text );?>" class="logo logo-light">
				<img src="<?php echo esc_url($logo_light); ?>" alt="<?php echo wp_kses_post( $logo_text );?>" />
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo wp_kses_post( $logo_text );?>" class="logo logo-dark">
				<img src="<?php echo esc_url($logo_dark); ?>" alt="<?php echo wp_kses_post( $logo_text );?>" />
			</a>

		<?php endif; 		
	}
}

if(!function_exists('orion_get_navigation')) {
	// used for separator default colors
	function orion_get_navigation( $container_classes = array(), $menu_classes = array()) {
			
		// are there any special classes?
		$html_container_classes = 'main-nav-wrap';
		if (is_array ( $container_classes )) {
			$html_container_classes .= ' ' . implode(" ", $container_classes );
		}

		$html_menu_classes = 'nav-menu';
		if (is_array ( $menu_classes )) {
			$html_menu_classes .= ' ' . implode(" ", $menu_classes );
		}		

		// is megamenu on in theme options?
		if (has_nav_menu( 'primary' ) && orion_get_option('orion_megamenu', false) == true){
	 		wp_nav_menu( 
	 			array( 
		 			'theme_location' => 'primary', 
		 			'menu_class' => $html_menu_classes, 
		 			'container_class' => $html_container_classes, 
		 			'items_wrap' => orion_nav_wrap(),
		 			'walker'  => new OrionNavWalker() //use our custom walker
	 			) 
	 		);
		} else {
 			wp_nav_menu( 
 				array( 
		 			'theme_location' => 'primary', 
		 			'menu_class' => $html_menu_classes, 
		 			'container_class' => $html_container_classes, 
		 			'items_wrap' => orion_nav_wrap(),
		 		) 
 			); 
		}
	}
}

if(!function_exists('orion_site_content_bg')) {
	// used for separator default colors
	function orion_site_content_bg() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		if(isset($orion_options['site_background_color']) && $orion_options['site_background_color'] != ''){
			$content_bg_color = $orion_options['site_background_color'];
		} else {
			$content_bg_color = '#fff';
		}
		$data_att = ' data-site-content-bg =' . $content_bg_color;
		echo esc_attr($data_att);
	}
}

if(!function_exists('orion_is_boxed')) {
	function orion_is_boxed($start_end) {
		
		$orion_options = get_option('recycle', orion_get_orion_defaults());

		$is_fullwidth = $orion_options['boxed_fullwidth']; 

		if($is_fullwidth === '0') {
			if ($start_end == 'start') : ?>
				<div class="boxed-container primary-content">
			<?php else : ?>
				</div> <!-- boxed -->
			<?php endif;
		}
	}
}


if(!function_exists('orion_heading_classes')) {
	/**
	 * adds page heading HTML classes
	 * @return string (HTML classes)
	 */
	function orion_heading_classes() {
		
		$heading_classes = ' ';
		$orion_options = get_option('recycle', orion_get_orion_defaults());

		if ( is_single() || is_page() || (is_home() && is_front_page() == false)) {
			if (is_home() && is_front_page() == false) {
				$page_for_posts = get_option( 'page_for_posts' );
				$orion_wp_meta = get_post_meta( $page_for_posts );
			} else  {
				$orion_wp_meta = get_post_meta( get_the_ID() );
			}
			if (isset($orion_wp_meta['_recycle_heading_text_color']) && $orion_wp_meta['_recycle_heading_text_color'][0] != 'text-default') {
				$heading_classes .= $orion_wp_meta['_recycle_heading_text_color'][0];
			}
			if (isset($orion_wp_meta['_recycle_orion_overlay']) && $orion_wp_meta['_recycle_orion_overlay'][0] != 'default') {
				if ($orion_wp_meta['_recycle_orion_overlay'][0] != 'none') {
					$heading_classes .= ' ' . $orion_wp_meta['_recycle_orion_overlay'][0];
				}
				
			} else if (isset($orion_options['default_overlay']) && $orion_options['default_overlay'] != '' && $orion_options['default_overlay'] != 'none') {
				$heading_classes .= ' ' . $orion_options['default_overlay'];
			}
			if (isset($orion_wp_meta['_recycle_orion_parallax']) && $orion_wp_meta['_recycle_orion_parallax'][0] != 'default') {
				$heading_classes .= ' ' . $orion_wp_meta['_recycle_orion_parallax'][0];
				if($orion_wp_meta['_recycle_orion_parallax'][0] != 'fixed') {
					$heading_classes .= ' orion-parallax';
				}
			}
			if (isset($orion_wp_meta['_recycle_heading_bg_img_repeat']) && $orion_wp_meta['_recycle_heading_bg_img_repeat'][0] != 'default') {
				$heading_classes .= ' ' .$orion_wp_meta['_recycle_heading_bg_img_repeat'][0];
			}
			if (isset($orion_wp_meta['_recycle_heading_bg_img_sizing']) && $orion_wp_meta['_recycle_heading_bg_img_sizing'][0] != 'default') {
				$heading_classes .= ' ' .$orion_wp_meta['_recycle_heading_bg_img_sizing'][0];
			}
			if (isset($orion_wp_meta['_recycle_heading_bg_img_align']) && $orion_wp_meta['_recycle_heading_bg_img_align'][0] != 'default') {
				$heading_classes .= ' ' .$orion_wp_meta['_recycle_heading_bg_img_align'][0];
			}
		} else if (isset($orion_options['default_overlay']) && $orion_options['default_overlay'] != '' && $orion_options['default_overlay'] != 'none') {
			$heading_classes .= ' ' . $orion_options['default_overlay'];	
		}

		return $heading_classes;
	}
}

if(!function_exists('orion_heading_style')) {
	/**
	 * adds page heading HTML classes
	 * @return string (HTML classes)
	 */
	function orion_heading_style() {
		$heading_style = ' ';

		if ( is_single() || is_page() || (is_home() && is_front_page() == false)) {
			if (is_home() && is_front_page() == false) {
				$page_for_posts = get_option( 'page_for_posts' );
				$orion_wp_meta = get_post_meta( $page_for_posts );
			} else {
				$orion_wp_meta = get_post_meta( get_the_ID() );
			}
		} elseif (is_404()) {
			$orion_options = get_option('recycle', orion_get_orion_defaults());
	
			if (isset($orion_options['page_404']) && $orion_options['page_404'] != '') {
				$orion_wp_meta = get_post_meta( $orion_options['page_404'] );
			} else {
				$heading_style = '';
			}
		}

		$heading_style = 'style="';
		if (isset($orion_wp_meta['_recycle_heading_bg_image'])) {
			$heading_style .= 'background-image: url(' . $orion_wp_meta['_recycle_heading_bg_image'][0] . ');';
		}
		if (isset($orion_wp_meta['_recycle_top_padding'][0]) && $orion_wp_meta['_recycle_top_padding'][0] != '') {
			$heading_style .= ' padding-top:' . intval(preg_replace('/[^0-9]+/', '', $orion_wp_meta['_recycle_top_padding'][0]), 10) . 'px;';
		}
		if (isset($orion_wp_meta['_recycle_bottom_padding'][0]) && $orion_wp_meta['_recycle_bottom_padding'][0] != '') {
			$heading_style .= ' padding-bottom:' . intval(preg_replace('/[^0-9]+/', '', $orion_wp_meta['_recycle_bottom_padding'][0]), 10) . 'px;';
		}	
		$heading_style .= '"';

		return $heading_style;
	}
}

if(!function_exists('orion_get_class_cb')) {
	/**
	 * Echo any class (if needed) from a checkbox options or a switch
	 * @param  string $the_orion_option  redux option name
	 * @param  string $def_class_name 	 class to return if checked
	 * @param  string $alt_class_name  	 class to return if NOT checked
	 * @param  string $default  		 in case there is no option value saved echo def_class_name unless specified 'off'
	 * @return echo HTML class
	 */
	function orion_get_class_cb( $the_orion_option, $def_class_name, $alt_class_name="", $default="on" ) {
		$orion_options = get_option('recycle', orion_get_orion_defaults());

		$html_class = "";

		if (isset($orion_options[$the_orion_option])) {
			if ($orion_options[$the_orion_option] == 1 || $orion_options[$the_orion_option] == 'on') {
				if ($def_class_name == "noclass") {
					$html_class = '';
				} else {
					$html_class .= $def_class_name;
				}					
			} else {
				if ($alt_class_name == "noclass") {
					$html_class = '';
				} else {
					$html_class .= $alt_class_name;
				}	
			}
		} else {
			// no option is found			
			$arg_num = func_num_args();
			switch ($arg_num) {
				case 4:
					if ($default != "noclass") {
						$html_class .= $default;
					}
					break;
			    case 2:
			    case 3:
						$html_class .= $def_class_name;
					break;
			}

		}
		// echo appropriate HTML class
		echo esc_attr($html_class);
	}
}

//function orion_option
if(!function_exists('orion_get_option')) {
	/**
	 * get HTML classes from theme options
	 * @param  string $the_orion_option 
	 * @param  bolean $echo 
	 * @param  string $default
	 * @return string
	 */
	function orion_get_option($the_orion_option, $echo = true, $default = false) {

		$html_class = "";
		//	if the option is NOT saved in the database
		$orion_options = get_option('recycle', orion_get_orion_defaults());

		if ( !isset($orion_options[$the_orion_option]) || $orion_options[$the_orion_option] == "" ) {
			if ($default) {
				if ($echo) {
					echo esc_attr($default);		
				} else {
					return $default;
				}
			}		
		} else { 
			$html_class .= $orion_options[$the_orion_option];
		}

		if ($echo) {
			echo esc_attr($html_class);		
		} else {
			return $html_class;
		}
	}
}

if(!function_exists('orion_get_real_option')) {
	/**
	 * Same as orion_get_option, but requires redux options and ignores defaults.
	 * @param  string $the_orion_option 
	 * @param  bolean $echo 
	 * @param  string $default
	 * @return string
	 */
	function orion_get_real_option($the_orion_option, $echo = true, $default = false) {

		$html_class = "";
		//	if the option is NOT saved in the database
		$orion_options = get_option('recycle');

		if ( !isset($orion_options[$the_orion_option]) || $orion_options[$the_orion_option] == "" ) {
			if ($default) {
				if ($echo) {
					echo esc_attr($default);		
				} else {
					return $default;
				}
			}		
		} else { 
			$html_class .= $orion_options[$the_orion_option];
		}

		if ($echo) {
			echo esc_attr($html_class);		
		} else {
			return $html_class;
		}
	}
}


//function orion_option
if(!function_exists('orion_get_theme_option_css')) {
	/**
	 * get options values from deep in theme option array, if is not set, return the backup option, else return default.
	 * Accepts arrays too. ie:
	 * 
	 * orion_get_theme_option_css(array('link_color','regular'), 'red', 'main_theme_color');
	 * or
	 * orion_get_theme_option_css(array('link_color','regular'), 'red', '')
	 *
	 * 1. checks for orion_options[link_color][regular], 
	 * 2. if there is no value, checks main_theme_color, 
	 * 3. if still none, echoes red
	 * 
	 * returns string 
	 */
	function orion_get_theme_option_css($theme_option_1, $default = false, $theme_option_2 = false) {

		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		$css = "";

		/* check first theme option */
		$status = true;
		$new_orion_options = $orion_options;
		if (is_string($theme_option_1)) {
            if (isset($orion_options[$theme_option_1]) && $orion_options[$theme_option_1] != '') {
            	$new_orion_options = $orion_options[$theme_option_1]; 
            }
		} else {	
			foreach ( $theme_option_1 as $option ) {   
		        if($status) {
		            if (isset($new_orion_options[$option]) && $new_orion_options[$option] != '') {
		                $new_orion_options = $new_orion_options[$option]; 
		            } else {
		                $status = false;
		            }
		        }
	   		}
		}	   		
   		if (is_string($new_orion_options)) {
   			return($new_orion_options);
   		/* check second theme option */
   		} else {
   			$status = true;
   			$new_orion_options = $orion_options;
   			if ($theme_option_2 == false) {
   				//just move on
   			} else if (is_string($theme_option_2)) {
	            if (isset($orion_options[$theme_option_2]) && $orion_options[$theme_option_2] != '') {
	            	$new_orion_options = $orion_options[$theme_option_2]; 
	            }
			} else {		
				foreach ( $theme_option_2 as $option ) {   
			        if($status) {
			            if (isset($new_orion_options[$option]) && $new_orion_options[$option] != '') {
			                $new_orion_options = $new_orion_options[$option];
			            } else {
			                $status = false;
			            }
			        }
		   		}
		   	}	 		
	  		if (is_string($new_orion_options)) {
	   			return($new_orion_options);
	   		/* if everything fails, return default */
			} else {
				return($default);
			}
		}	
	} 
}
if(!function_exists('orion_post_meta_array')) {
	function orion_post_meta_array() {
		$orion_options = get_option('recycle', orion_get_orion_defaults());	
		if (isset($orion_options['postmeta_settings'])) {
			$meta = $orion_options['postmeta_settings'];
		} else {
			$meta = array( 1 => '1', 2 => '1', 3 => '1', 4 => '');
		}
		return $meta;
	}
}


//function orion_option
if(!function_exists('orion_option_css')) {
	/**
	 * echoes options values from deep in theme option array, if is not set, return the backup option, else return default.
	 * Accepts arrays too. ie:
	 * 
	 * orion_option_css(array('link_color','regular'),'main_theme_color', 'red');
	 *
	 * 1. checks for orion_options[link_color][regular], 
	 * 2. if there is no value, checks main_theme_color, 
	 * 3. if still none, echoes red
	 * 
	 * echo string
	 */
	

	function orion_option_css($theme_option_1, $default = false, $theme_option_2 = false) {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		$css = "";

		/* check first theme option */
		$status = true;
		$new_orion_options = $orion_options;
		if (is_string($theme_option_1)) {
            if (isset($orion_options[$theme_option_1]) && $orion_options[$theme_option_1] != '') {
            	$new_orion_options = $orion_options[$theme_option_1]; 
            } else {
            	$status = false;
            }
		} else {
			foreach ( $theme_option_1 as $option ) {   
		        if($status) {
		            if (isset($new_orion_options[$option]) && $new_orion_options[$option] != '') {
		                $new_orion_options = $new_orion_options[$option]; 
		            } else {
		                $status = false;
		            }
		        }
	   		}
		}	   		
   		if (is_string($new_orion_options) && is_string($new_orion_options)!='') {
   			echo esc_attr($new_orion_options);
   		/* check second theme option */
   		} else {

   			$status = true;
   			$new_orion_options = $orion_options;
   			if ($theme_option_2 == false) {
   				//just move on
   			} else if (is_string($theme_option_2)) {
	            if (isset($orion_options[$theme_option_2]) && $orion_options[$theme_option_2] != '') {
	            	$new_orion_options = $orion_options[$theme_option_2]; 
	            }
			} else {		
				foreach ( $theme_option_2 as $option ) {   
			        if($status) {
			            if (isset($new_orion_options[$option]) && $new_orion_options[$option] != '') {
			                $new_orion_options = $new_orion_options[$option];
			            } else {
			                $status = false;
			            }
			        }
		   		}
		   	}	 		
	  		if (is_string($new_orion_options) && is_string($new_orion_options)!=NULL) {
	   			echo esc_attr($new_orion_options);
	   		/* if everything fails, return default */
			} else {
				echo esc_attr($default);
			}
		}	
	} 
}
// dump Redux theme options
/**
 * Function used for debugging and development purpuses only
 * @param  [type]  $option   [description]
 * @param  boolean $dontexit [description]
 * @return [type]            [description]
 */
function orion_dump_option($option, $dontexit = false){
	global $orion_options; 
	if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
	$the_option = $orion_options[$option];

	var_dump($the_option);
	if ($dontexit) {
		Exit;
	}
}

/* Page heading */
if(!function_exists('orion_get_orion_page_heading')) {
	function orion_get_orion_page_heading() {
		// get meta
		if (is_404() ) {
			$orion_options = get_option('recycle', orion_get_orion_defaults());
			if (isset($orion_options['page_404']) && $orion_options['page_404'] != '') {
				$orion_wp_meta = get_post_meta( $orion_options['page_404'] );
			}	
		} else {
			$orion_wp_meta = get_post_meta( get_the_ID() );
		}
		// display heading
		if (isset($orion_wp_meta['_recycle_hide_heading']) && ($orion_wp_meta['_recycle_hide_heading'][0] == 'on')) {
			return;
		} else {			
			if ( ( is_single() || is_page() || is_404() ) && isset($orion_wp_meta['_recycle_heading_type']) ) {
				get_template_part( 'templates/heading/content-heading', $orion_wp_meta['_recycle_heading_type'][0] );
			} else {
				get_template_part( 'templates/heading/content-heading', orion_get_option('post_heading_type', false) );
			}
		}
	}
}

/* .site-main paddings */
if(!function_exists('get_orion_page_padding')) { 
	function get_orion_page_padding( $id=false ) {
		if ($id == false ) {
			$orion_wp_meta = get_post_meta( get_the_ID() );
		} else {
			$orion_wp_meta = get_post_meta( $id );
		}
		$html_classes = '';
 		if (isset($orion_wp_meta['_recycle_remove_padding_top']) && ($orion_wp_meta['_recycle_remove_padding_top'][0] == 'on')) {
			$html_classes .= ' notoppadding';
		}
		if (isset($orion_wp_meta['_recycle_remove_padding_bottom']) && ($orion_wp_meta['_recycle_remove_padding_bottom'][0] == 'on')) {
			$html_classes .= ' nobottompadding';
		}				
		return $html_classes;
	}
}

/*sidebars*/
function orion_get_orion_sidebars() {
	$num_of_sidebars = '0';
	$right_sidebar = "no_sidebar";
	$left_sidebar = 'no_sidebar';
	$ot_sidebars = array(
		'primary_class' => 'col-md-12', 
		'left_sidebar_class' => '', 
		'right_sidebar_class' =>'',
		'ot_left_sidebar_id' => '',
		'ot_right_sidebar_id' => ''		
	);
	$post_type = get_post_type();

	if ($post_type == 'orion_portfolio') {
		if (is_single()) {
			$orion_wp_meta = get_post_meta( get_the_ID() );
			if (isset($orion_wp_meta['_recycle_portfolio_sidebar_select_left']) && ($orion_wp_meta['_recycle_portfolio_sidebar_select_left'][0] != 'no_sidebar')) {
				$ot_sidebars['ot_left_sidebar_id'] = $orion_wp_meta['_recycle_portfolio_sidebar_select_left'][0];
			  	$num_of_sidebars++;   
			}		
			if (isset($orion_wp_meta['_recycle_portfolio_sidebar_select_right']) && ($orion_wp_meta['_recycle_portfolio_sidebar_select_right'][0] != 'no_sidebar')) {
				$ot_sidebars['ot_right_sidebar_id'] = $orion_wp_meta['_recycle_portfolio_sidebar_select_right'][0];
			  	$num_of_sidebars++;   
			}
		} else {
		global $orion_options;
			if(empty($orion_options)) {
				$orion_options = orion_get_orion_defaults();
			}
			if (isset($orion_options['portfolio_sidebar_left_defaults']) && ($orion_options['portfolio_sidebar_left_defaults'] != "")) {
	           $ot_sidebars['ot_left_sidebar_id'] = $orion_options['portfolio_sidebar_left_defaults'];
	           $num_of_sidebars++; 
	        } 
	     	if (isset($orion_options['portfolio_sidebar_right_defaults']) && ($orion_options['portfolio_sidebar_right_defaults'] != "")) {
	           $ot_sidebars['ot_right_sidebar_id'] = $orion_options['portfolio_sidebar_right_defaults'];
	           $num_of_sidebars++; 
	        }			
		}
	} 
	else if ($post_type == 'product') {
		if (is_single()) {
			$orion_wp_meta = get_post_meta( get_the_ID() );
			if (isset($orion_wp_meta['_recycle_woo_sidebar_select_left']) && ($orion_wp_meta['_recycle_woo_sidebar_select_left'][0] != 'no_sidebar')) {
				$ot_sidebars['ot_left_sidebar_id'] = $orion_wp_meta['_recycle_woo_sidebar_select_left'][0];
			  	$num_of_sidebars++;   
			}		
			if (isset($orion_wp_meta['_recycle_woo_sidebar_select_right']) && ($orion_wp_meta['_recycle_woo_sidebar_select_right'][0] != 'no_sidebar')) {
				$ot_sidebars['ot_right_sidebar_id'] = $orion_wp_meta['_recycle_woo_sidebar_select_right'][0];
			  	$num_of_sidebars++;   
			}
		} else {
		global $orion_options;
			if(empty($orion_options)) {
				$orion_options = orion_get_orion_defaults();
			}
			if (isset($orion_options['woo_sidebar_left']) && ($orion_options['woo_sidebar_left'] != "")) {
	           $ot_sidebars['ot_left_sidebar_id'] = $orion_options['woo_sidebar_left'];
	           $num_of_sidebars++; 
	        } 
	     	if (isset($orion_options['woo_sidebar_right']) && ($orion_options['woo_sidebar_right'] != "")) {
	           $ot_sidebars['ot_right_sidebar_id'] = $orion_options['woo_sidebar_right'];
	           $num_of_sidebars++; 
	        }			
		}
	}
	else 
	if (is_single()) {
		$orion_wp_meta = get_post_meta( get_the_ID() );
		if (isset($orion_wp_meta['_recycle_post_sidebar_select_left']) && ($orion_wp_meta['_recycle_post_sidebar_select_left'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_left_sidebar_id'] = $orion_wp_meta['_recycle_post_sidebar_select_left'][0];
		  	$num_of_sidebars++;   
		}		
		if (isset($orion_wp_meta['_recycle_post_sidebar_select_right']) && ($orion_wp_meta['_recycle_post_sidebar_select_right'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_right_sidebar_id'] = $orion_wp_meta['_recycle_post_sidebar_select_right'][0];
		  	$num_of_sidebars++;   
		}
	} else if(is_page()){		

		$orion_wp_meta = get_post_meta( get_the_ID() );
		if (isset($orion_wp_meta['_recycle_page_sidebar_select_left']) && ($orion_wp_meta['_recycle_page_sidebar_select_left'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_left_sidebar_id'] = $orion_wp_meta['_recycle_page_sidebar_select_left'][0];
		  	$num_of_sidebars++;   
		}		
		if (isset($orion_wp_meta['_recycle_page_sidebar_select_right']) && ($orion_wp_meta['_recycle_page_sidebar_select_right'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_right_sidebar_id'] = $orion_wp_meta['_recycle_page_sidebar_select_right'][0];
		  	$num_of_sidebars++;   
		}
			
	} else if (is_archive() || is_search()) {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		if (isset($orion_options['archive_blog_sidebar_left_defaults']) && ($orion_options['archive_blog_sidebar_left_defaults'] != "")) {
           $ot_sidebars['ot_left_sidebar_id'] = $orion_options['archive_blog_sidebar_left_defaults'];
           $num_of_sidebars++; 
        } 
     	if (isset($orion_options['archive_blog_sidebar_right_defaults']) && ($orion_options['archive_blog_sidebar_right_defaults'] != "")) {
           $ot_sidebars['ot_right_sidebar_id'] = $orion_options['archive_blog_sidebar_right_defaults'];
           $num_of_sidebars++; 
        }
	} else if (is_home() || is_front_page() == false) {     
		$orion_wp_meta = get_post_meta( get_option( 'page_for_posts' ) );

		if (isset($orion_wp_meta['_recycle_page_sidebar_select_left']) && ($orion_wp_meta['_recycle_page_sidebar_select_left'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_left_sidebar_id'] = $orion_wp_meta['_recycle_page_sidebar_select_left'][0];
		  	$num_of_sidebars++;   
		}		
		if (isset($orion_wp_meta['_recycle_page_sidebar_select_right']) && ($orion_wp_meta['_recycle_page_sidebar_select_right'][0] != 'no_sidebar')) {
			$ot_sidebars['ot_right_sidebar_id'] = $orion_wp_meta['_recycle_page_sidebar_select_right'][0];
		  	$num_of_sidebars++;   
		}
	} else {
		$num_of_sidebars = '0';
	}
	
	switch ($num_of_sidebars) {
		case '0' :
			$ot_sidebars['primary_class'] = " col-md-12";
			break;

		case '1' :
			$ot_sidebars['primary_class']=" col-md-9";
			if($ot_sidebars['ot_left_sidebar_id'] != '' ){
			  	$ot_sidebars['left_sidebar_class'] = ' col-md-3 col-md-pull-9';
			  	$ot_sidebars['primary_class'] .= ' col-md-push-3';
			}
			if($ot_sidebars['ot_right_sidebar_id'] != '' ){
				$ot_sidebars['right_sidebar_class'] = " col-md-3";	
			}
			break;

		case '2' :
		    $ot_sidebars['primary_class'] = " col-md-6 col-md-push-3";
		    $ot_sidebars['left_sidebar_class'] = " col-md-3 col-md-pull-6";
		    $ot_sidebars['right_sidebar_class'] = " col-md-3";
			break;

		default:
			
			$ot_sidebars['primary_class'] = " col-md-12";			
			break;
	}
	return $ot_sidebars;	
}

function orion_display_prefooter() {
	$should_display = false;
	if (orion_get_real_option('prefooter_switch', false) == 1) {
		$should_display = true;
	}

	if(is_page()){		
		$orion_wp_meta = get_post_meta( get_the_ID() );
		if ( isset($orion_wp_meta['_recycle_hide_prefooter']) && ($orion_wp_meta['_recycle_hide_prefooter'] == true) ) 	{
			$should_display = false;
		}
	}
	if(is_single()){		
		$orion_wp_meta = get_post_meta( get_the_ID() );
		if ( isset($orion_wp_meta['_recycle_hide_prefooter']) && ($orion_wp_meta['_recycle_hide_prefooter'] == true) ) {
			$should_display = false;
		}
	}	
	return $should_display;
}

/* excerpt length */
function orion_excerpt_length($limit) {
	$excerpt = get_the_excerpt();
	$excerpt = preg_replace('/(<script[^>]*>.+?<\/script>|<style[^>]*>.+?<\/style>)/s', '', $excerpt);
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags($excerpt);
	$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
    $excerpt = wp_trim_words(get_the_excerpt(), $limit);
    return $excerpt;

}

/* Comments */
if(!function_exists('orion_comments')) {
	function orion_comments($comment, $args, $depth) {

	    if ( 'div' === $args['style'] ) {
	        $tag       = 'div';
	        $add_below = 'comment';
	    } else {
	        $tag       = 'li';
	        $add_below = 'div-comment';
	    }
	    ?>
	    <<?php echo esc_attr($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	    <?php if ( 'div' != $args['style'] ) : ?>
	        <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	    <?php endif; ?>
	    <div class="comment-author vcard">
	        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	        <?php echo wp_kses_post( sprintf( __( '<cite class="fn"><h6 class="comment-author-name">%s</h6></cite>', 'recycle' ), get_comment_author_link() )); ?>
	    </div>
	    <?php if ( $comment->comment_approved == '0' ) : ?>
	         <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'recycle' ); ?></em>
	          <br />
	    <?php endif; ?>
	    <div class="comment-content">
	    	<?php comment_text(); ?>
	    </div>
	    <div class="comment-meta commentmetadata meta-data"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
	        <?php
	        /* translators: 1: date, 2: time */
	        echo wp_kses_post(sprintf( __('%1$s at %2$s', 'recycle'), get_comment_date(),  get_comment_time() )); ?></a><?php edit_comment_link( esc_html__( '(Edit)', 'recycle' ), '  ', '' );
	        ?>
	    </div>

	    <div class="reply">
	        <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => wp_kses_post(__( '<span class="font-3">Reply <i class="fa fa-reply primary-color"></i></span>', 'recycle' ) ) ) )); ?>
	    </div>
	    <?php if ( 'div' != $args['style'] ) : ?>
	    </div>
	    <?php endif; ?>
	    <?php
	}
}

/* Page title */
if(!function_exists('orion_page_title')) {
    function orion_page_title() {
        if(is_home() && is_front_page()) {
        	echo bloginfo ( 'description' );
        } else if( is_home() && !is_front_page()) {
	    	 echo get_the_title(get_option('page_for_posts'));;
        } else if( is_day() ) {
            echo esc_html__('Daily Archives', 'recycle') . ': ' . get_the_date();
        } else if( is_month() ) {
            echo esc_html__('Monthly Archives', 'recycle') . ': ' . get_the_time('F');
        } else if( is_year() ) {
            echo esc_html__('Yearly Archives', 'recycle') . ': ' . get_the_time('Y');
        } else if( is_search() ) {
            echo esc_html__('Search results', 'recycle');
        } else if( is_tag() ) {
            echo single_tag_title('', false);
        } else if( is_category() ) {
            echo single_cat_title('', false);
        } else if( is_tax() ) {
        	$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
        	echo esc_html($term->name);
        } else if( function_exists('is_shop') && is_shop() ) {
            echo get_the_title(get_option( 'woocommerce_shop_page_id' ));
        } else if( is_404() ) {
            echo esc_html__('Page not found', 'recycle');
        } else if( is_author() ) {
            echo esc_html__('Articles posted by', 'recycle') . ' ' . get_the_author();
		} else if(is_post_type_archive('team-member')) {
			$post_type_name = get_option( 'orion_base_name', 'Team' );
			echo esc_html($post_type_name);
	    } else if(is_post_type_archive('orion_portfolio')) {
			$post_type_name = get_option( 'orion_portfolio_base_name', 'Projects' );
			echo esc_html($post_type_name);
	    } else {
            echo get_the_title();
        }
    }
}

if(!function_exists('orion_custom_styles')) {
	/**
	 * Generate custom styles
	 * @return custom css
	 */
	function orion_custom_styles() {
	    if ( file_exists( get_template_directory() . '/framework/css/custom-styles.php' ) ) {
	        require_once get_template_directory() . '/framework/css/custom-styles.php';
	    }
	}
}

if(!function_exists('orion_addhttp')) {
	function orion_addhttp($url) {
	    if (!preg_match("~^(?:f|ht)tps?://~i", $url) && !preg_match('/#/', $url) ) {
	        $url = "http://" . $url;
	    }
	    return $url;
	}
}

if(!function_exists('orion_removehttp')){
	function orion_removehttp($url) {
		$disallowed = array('http://', 'https://');
		foreach($disallowed as $d) {
			if(strpos($url, $d) === 0) {
			 	return str_replace($d, '', $url);
			}
   		}
   		return $url;
	}
}


if(!function_exists('orion_get_gallery_attachments')) {
	function orion_get_gallery_attachments(){
		global $post;
		
		$post_content = $post->post_content;
		preg_match('/\[gallery.*ids=.(.*).\]/', $post_content, $ids);

		if (!empty($ids)) {
			$images_id = explode(",", $ids[1]);
			return $images_id;
		}
	}
}

/**
 * returns blog type
 * @return blog type
 */
if(!function_exists('orion_get_blog_type')) {
	function orion_get_blog_type($blog_type = false) {
		if ($blog_type == false) {
			global $orion_options;
			if(empty($orion_options)) {
				$orion_options = orion_get_orion_defaults();
			}
			if (array_key_exists('blog_layout', $orion_options)) {
				return $orion_options['blog_layout'];
			} else {
				return 'classic';
			}
		} else {
			return $blog_type;
		}
	}
}

if(!function_exists('orion_paging_nav')) {
	/**
	 * create blog pagination
	 * @return pagination
	 */
	function orion_paging_nav() {
	  // Don't print empty markup if there's only one page.
	  if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
	    return;
	  }

	  $paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	  $pagenum_link = html_entity_decode( get_pagenum_link() );
	  $query_args   = array();
	  $url_parts    = explode( '?', $pagenum_link );

	  if ( isset( $url_parts[1] ) ) {
	    wp_parse_str( $url_parts[1], $query_args );
	  }

	  $pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	  $pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	  $format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	  $format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	  // Set up paginated links.
	  $links = paginate_links( array(
	    'base'     => $pagenum_link,
	    'format'   => $format,
	    'total'    => $GLOBALS['wp_query']->max_num_pages,
	    'current'  => $paged,
	    'mid_size' => 3,
	    'add_args' => array_map( 'urlencode', $query_args ),
	    'prev_text' => esc_html__( '&larr;', 'recycle' ),
	    'next_text' => esc_html__( '&rarr;', 'recycle' ),
	    'type'      => 'list',
	  ) );

	  if ( $links ) :
	  ?>
	  <nav class="navigation paging-navigation clearfix">
	    <h3 class="screen-reader-text"><?php _e( 'Posts navigation', 'recycle' ); ?></h3>
	      <?php echo wp_kses_post($links);?> 
	  </nav><!-- .navigation -->
	  <?php
	  endif;
	}
}


if(!function_exists('orion_header_mobile_nav')) {
	function orion_header_mobile_nav() {
		;?>
		<div class="hidden-lg hidden-md text-center burger-container">
			<div class="to-x">
				<div class="hamburger-box">
					<div class="bun top"></div>
					<div class="meat"></div>
					<div class="bun bottom"></div>
				</div>
				<?php 
				$woo_cart = orion_get_option('woo_cart', false);
				
				if(class_exists( 'WooCommerce' ) && isset($woo_cart) && $woo_cart!='0') : ?>
					<div class="woocart">
						<?php woocommerce_mini_cart();?>
					</div>			
				<?php endif;?>
			</div>
		</div>	
		<?php
	}
}

/*********************************** O.o ***********************************/
/*                           FILTER FUNCTIONS                         	   */
/***************************************************************************/

/* back to top button */
if(!function_exists('orion_back_to_top')) {
	function orion_back_to_top() {
		if (orion_get_theme_option_css('back_to_top', '0') == true)  :?>
	    	<a class="back-to-top primary-color-bg hideit" href="#"></a>
		<?php endif; 
	}
}	
add_action( 'wp_footer', 'orion_back_to_top' );


/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string modified "read more" excerpt string.
 */
if(!function_exists('orion_excerpt_more')) {
	function orion_excerpt_more( $more ) {
	    return '';
	}
}		
add_filter( 'excerpt_more', 'orion_excerpt_more' );

/** 
* Vertical menu toggle
* @return "vertical-menu" if vertical menu is turned on in theme options.
*/
if(!function_exists('orion_has_vertical_menu')) {
	function orion_has_vertical_menu() {
		global $orion_options;
		if(empty($orion_options)) {
			$orion_options = orion_get_orion_defaults();
		}
		$orion_headertype = 'classic';
		if (isset($orion_options["orion_header_type"])) {
			$orion_headertype = $orion_options["orion_header_type"];	
		}
		if ($orion_headertype == 'vertical') {	
			return('vertical-menu');
		}
	}
}
if(!function_exists('orion_body_boxed_class')) {
	function orion_body_boxed_class() {
		$orion_options = get_option('recycle', orion_get_orion_defaults());

		if ($orion_options['boxed_fullwidth'] === '0') {	
			return('boxed');
		}
	}
}
if(!function_exists('orion_one_page')) {
	function orion_one_page() {
		$orion_options = get_option('recycle', array());
		 if (array_key_exists( 'one_page', $orion_options )) {
			if ($orion_options['one_page'] === '1') {	
				return('one-page');
			}
		 }
	}
}
if(!function_exists('orion_swipebox_bars_mobile')) {
	function orion_swipebox_bars_mobile() {
		$orion_options = get_option('recycle', array());
		if (array_key_exists( 'swipebox_bars_mobile', $orion_options )) {
			if ($orion_options['swipebox_bars_mobile'] === '1') {	
				return('swipebox-mobile');
			}
		}
	}
}

/**
* add custom HTML classes to the <body> element.
* @param  $classes 
* @return <body> HTML classes 
*/
if(!function_exists('orion_body_classes')) {
	function orion_body_classes( $classes ) {	
		array_push( $classes, orion_has_vertical_menu());
		array_push( $classes, orion_body_boxed_class());
		array_push( $classes, orion_one_page());
		array_push( $classes, orion_swipebox_bars_mobile());		
		// push additional HTML classes here, if needed...
	return $classes;}
}
add_filter( 'body_class', 'orion_body_classes' );

/* tag cloud */
if(!function_exists('orion_tag_cloud_args')) {
	function orion_tag_cloud_args( $args ) {
		$args['largest'] = 15;
		$args['smallest'] = 11;
		$args['unit'] = 'px';
		return $args;
	}
}
add_filter( 'widget_tag_cloud_args', 'orion_tag_cloud_args' );
add_filter( 'woocommerce_product_tag_cloud_widget_args', 'orion_tag_cloud_args' ); //woocommerce
/**
 * fallback for wp_nav_menu. Instead of not showing anyhing if there is no primary menu, fallback to wp_page_menu and adjust the markup.
 * @param  page_markup (default pagemenu markup)
 * @return markup adjusted for styling
 */
if(!function_exists('orion_page_menu')) {
	function orion_page_menu ($page_markup) {
	    $toreplace = 'nav-menu';
	    $new_markup = str_replace($toreplace, 'main-nav-wrap', $page_markup);
	    $new_markup = preg_replace('<ul>', 'ul class="nav-menu float-right no-primary-menu"', $new_markup, 1);
	    $new_markup = preg_replace('<page_item>', 'page_item menu-item', $new_markup);
	    $new_markup = preg_replace('<children>', 'sub-menu', $new_markup);
	    $new_markup = preg_replace('<menu-item_has_sub-menu>', 'menu-item-has-children', $new_markup);
	return $new_markup; }
}
add_filter('wp_page_menu', 'orion_page_menu');


/* used in tabs widget for getting the content out of page builder  */
if(!function_exists('orion_process_pagebuilder_content')){
	function orion_process_pagebuilder_content( $content ) {
		if( function_exists( 'siteorigin_panels_render' ) ) {
			$content_builder_id = substr( md5( json_encode( $content ) ), 0, 8 );
			echo siteorigin_panels_render( 'w'.$content_builder_id, true, $content );
		}
		else {
			echo esc_html__( 'This widget requires Page Builder.', 'recycle' );
		}
	}
}


/* menu button */
function orion_get_menu_button() {
	$button_text = $button_link = '';
	$display_button = false;

	$orion_options = get_option('recycle', orion_get_orion_defaults());

	if (isset($orion_options['last_tab_size'])) {
		$last_tab_size = $orion_options['last_tab_size'];
	} else {
		$last_tab_size = 's48';
	}
	switch ($last_tab_size) {
	    case "s48":
	    	$btn_class = 'btn-md';
	    	break;
		case "s36":
			$btn_class = 'btn-sm';
			break;
		case "s60":
			$btn_class = 'btn-lg';
			break;				
		default:	
			$btn_class = 'btn-md';
			break;
	}
	if (isset($orion_options['header_button_rounding']) && $orion_options['header_button_rounding'] != '') {
		$btn_class .= ' ' . $orion_options['header_button_rounding'];
	}
	if (isset($orion_options['display_header_button'])) {
		$display_button = $orion_options['display_header_button'];
	}
	if (isset($orion_options['button_text'])) {
		$button_text = $orion_options['button_text'];
	}
	if (isset($orion_options['button_link_url'])) {
		$button_link = $orion_options['button_link_url'];
	}

	$menu_btn_color = orion_get_option('header_button_color', false);

	if(is_page()) {
		$orion_wp_meta = get_post_meta( get_the_ID() );
		if (isset($orion_wp_meta['_recycle_button_text']) && $orion_wp_meta['_recycle_button_text']['0'] != '') {
			$button_text = $orion_wp_meta['_recycle_button_text']['0'];
		}
		if (isset($orion_wp_meta['_recycle_button_link']) && $orion_wp_meta['_recycle_button_link']['0'] != '') {
			$button_link = $orion_wp_meta['_recycle_button_link']['0'];
		}
		if(isset($orion_wp_meta['_recycle_button_link']) && isset($orion_wp_meta['_recycle_button_text']) && $orion_wp_meta['_recycle_button_link']['0']!= '' && $orion_wp_meta['_recycle_button_text']['0']!= '') {
			$display_button = true;
		}
	}

	if ($display_button == false) {
		return;
	} else {
		$menu_btn = "<li class='nav-button'><div class='mainnav-button-wrap'> <a href = '" . $button_link . "' class='btn ". $menu_btn_color ." btn-flat " . $btn_class . "'>" . $button_text. "</a></div></li>";

		return $menu_btn;
	}
}


/* Minify CSS */
function orion_minify_css($input) {
    if(trim($input) === "") return $input;
    return preg_replace(
        array(
            // Remove comment(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
            // Remove unused white-space(s)
            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
            // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
            '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
            // Replace `:0 0 0 0` with `:0`
            '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
            // Replace `background-position:0` with `background-position:0 0`
            '#(background-position):0(?=[;\}])#si',
            // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
            '#(?<=[\s:,\-])0+\.(\d+)#s',
            // Minify string value
            '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
            '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
            // Minify HEX color code
            '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
            // Replace `(border|outline):none` with `(border|outline):0`
            '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
            // Remove empty selector(s)
            '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
        ),
        array(
            '$1',
            '$1$2$3$4$5$6$7',
            '$1',
            ':0',
            '$1:0 0',
            '.$1',
            '$1$3',
            '$1$2$4$5',
            '$1$2$3',
            '$1:0',
            '$1$2'
        ),
    $input);
}




/* checking if it is a WooCommerce page */
/**
* Must be placed separate from WooCommerce scripts, because it needs to return result even when WooCommerce is not installed.
* @access public
* @return bool
*/
function orion_is_woo() {
	if(  !function_exists ( "is_woocommerce" )) {
		return false;
	} else if (  function_exists ( "is_woocommerce" ) && is_woocommerce()){
        return true;
    } else {
	    $woocommerce_keys = array ( 
			"woocommerce_shop_page_id",
			"woocommerce_terms_page_id",
			"woocommerce_cart_page_id",
			"woocommerce_checkout_page_id",
			"woocommerce_pay_page_id",
			"woocommerce_thanks_page_id",
			"woocommerce_myaccount_page_id",
			"woocommerce_edit_address_page_id",
			"woocommerce_view_order_page_id",
			"woocommerce_change_password_page_id",
			"woocommerce_logout_page_id",
			"woocommerce_lost_password_page_id"
		);
	    foreach ( $woocommerce_keys as $wc_page_id ) {
	        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
	                return true ;
	        }
	    }
	    return false;
    }
}