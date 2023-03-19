<?php
function orion_create_custom_css(){ 
	global $orion_options;  

/* ---COLORS--- */
$color_1 = orion_get_theme_option_css('main_theme_color', '#22AA86' );
$color_2 = orion_get_theme_option_css('secondary_theme_color', '#9CC026' );
$color_3 = orion_get_theme_option_css('color_3', '#44514E' );

/* defaults*/
/* MEGA WIDGET */
	// generate defaults on theme activation
	$basic_megawidget_color_array = array('regular'=>'', 'hover'=>'rgba(0,0,0,.8)', 'active'=>'#ffffff');
	$basic_megawidget_bg_array = array('regular'=>'transparent', 'hover'=>'#f2f2f2', 'active'=>'');
	$basic_megawidget_icon_color = array('regular'=>'', 'hover'=>'', 'active'=>'#fff');
	$basic_featured_megawidget_title_colors = array('regular'=>'', 'hover'=>'', 'active'=>'');
	$basic_featured_megawidget_icon_color = array('regular'=>'', 'hover'=>'', 'active'=>'#fff');

	// get values from theme options
	$megawidget_title_colors = orion_get_theme_option_css('megawidget-title-colors', $basic_megawidget_color_array);
	$megawidget_title_background = orion_get_theme_option_css('megawidget-background-colors', $basic_megawidget_bg_array);
	$megawidget_active_title_background = orion_get_theme_option_css(array('megawidget-background-colors','active'), $color_1);

	$megawidget_icon_color = orion_get_theme_option_css('megawidget-icon-colors', $basic_megawidget_icon_color);
	$featured_megawidget_title_colors = orion_get_theme_option_css('featured-megawidget-title-colors', $basic_featured_megawidget_title_colors);
	$featured_megawidget_title_background = orion_get_theme_option_css(array('featured-megawidget-background-colors','active'), $color_2);
	$featured_megawidget_icon_color = orion_get_theme_option_css('featured-megawidget-icon-colors',$basic_featured_megawidget_icon_color);

/* MAIN NAVIGATION */
	$navigation_links_color_style = orion_get_theme_option_css('navigation_links_color_style','nav-dark');

	$first_lvl_menu_color_nav_light = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_light','regular'),'rgba(0,0,0,.8)');
	$first_lvl_menu_color_hover_nav_light = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_light','hover'), $color_1);
	$first_lvl_menu_color_active_nav_light = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_light','active'), $color_1);
	$submenu_colors_regular_nav_light= orion_get_theme_option_css(array('submenu_colors_nav_light','regular'),'rgba(0,0,0,.8)');
	$submenu_colors_hover_nav_light = orion_get_theme_option_css(array('submenu_colors_nav_light','hover'),$color_1);
	$submenu_colors_active_nav_light = orion_get_theme_option_css(array('submenu_colors_nav_light','active'),$color_1);

	$first_lvl_menu_color_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_dark','regular'),'#fff');
	$first_lvl_menu_color_hover_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_dark','hover'), $color_1);
	$first_lvl_menu_color_active_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_colors_nav_dark','active'), $color_1);
	$submenu_colors_regular_nav_dark= orion_get_theme_option_css(array('submenu_colors_nav_dark','regular'),'rgba(0,0,0,.8)');
	$submenu_colors_hover_nav_dark = orion_get_theme_option_css(array('submenu_colors_nav_dark','hover'),$color_1);
	$submenu_colors_active_nav_dark = orion_get_theme_option_css(array('submenu_colors_nav_dark','active'),$color_1);

	// backgrounds 
	$nav_menu_bg_color_nav_light = orion_get_theme_option_css('nav_menu_bg_color_nav_light',"transparent");
	$first_lvl_menu_bg_nav_light = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_light','regular'),'transparent');
	$first_lvl_menu_bg_hover_nav_light = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_light','hover'),'rgba(0,0,0,0.05)');
	$first_lvl_menu_bg_active_nav_light = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_light','active'),$color_1);

	//transparent color picker returns false values if empty
	if (!isset($orion_options['submenu_background_nav_light']['color']) || $orion_options['submenu_background_nav_light']['color'] == '') {
		$submenu_background_nav_light = "rgba(0,0,0,0.9)";
	} else {
		$submenu_background_nav_light = orion_get_theme_option_css(array('submenu_background_nav_light', 'rgba'), 'rgba(0,0,0,0.9)' );
	}

	$nav_menu_bg_color_nav_dark = orion_get_theme_option_css('nav_menu_bg_color_nav_dark',$color_3);
	$first_lvl_menu_bg_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_dark','regular'),'transparent');
	$first_lvl_menu_bg_hover_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_dark','hover'),'rgba(0,0,0,0.30)');
	$first_lvl_menu_bg_active_nav_dark = orion_get_theme_option_css(array('first_lvl_menu_bg_nav_dark','active'),$color_1);
		//transparent color picker returns false values if empty
	if (!isset($orion_options['submenu_background_nav_dark']['color']) || $orion_options['submenu_background_nav_dark']['color'] == '') {
		$submenu_background_nav_dark = "rgba(255,255,255,0.95)";
	} else {
		$submenu_background_nav_dark = orion_get_theme_option_css(array('submenu_background_nav_dark', 'rgba'), 'rgba(255,255,255,0.95)' );
	}
	$submenu_border_nav_dark = orion_get_theme_option_css(array('submenu_border_nav_dark', 'rgba'),'rgba(0, 0, 0, 0.1)');
	$submenu_border_nav_light = orion_get_theme_option_css(array('submenu_border_nav_light','rgba'),'rgba(0, 0, 0, 0.2)');

	$megamenu_nav_color = orion_get_theme_option_css(array('mega_menu_background','background-color'), 'false');

	/* li padding for classic menu: */
	$header_hight_classic = orion_get_theme_option_css('header_hight_classic', '96');
	$li_height = 36;

	if(orion_get_theme_option_css('navigation_style', 'nav-style-2') == 'nav-style-1') {
		$li_height = 48;
	}

	if(orion_get_theme_option_css('navigation_style', 'nav-style-2') == 'nav-style-3') {
		$li_height = 48;
		$first_lvl_menu_bg_active_nav_dark = 'transparent';
		$first_lvl_menu_bg_hover_nav_dark = 'transparent';
		$first_lvl_menu_bg_nav_dark = 'transparent';
		$first_lvl_menu_bg_nav_light = 'transparent';
		$first_lvl_menu_bg_hover_nav_light = 'transparent';
		$first_lvl_menu_bg_active_nav_light = 'transparent';
	}

	$li_padding_top_classic = round(($header_hight_classic - $li_height - 1) / 2);
	if ($li_padding_top_classic < 0) {
		$li_padding_top_classic = 0;
	}

	/* logo position: */
	$logo_position_hight_classic = orion_get_theme_option_css('logo_position_hight_classic', '50');
	$logo_position_hight_with_widgets = orion_get_theme_option_css('logo_position_hight_with_widgets', '50');

	/* Top bar */
	$topbar_background = orion_get_theme_option_css('topbar_background', $color_1 );


	/* Page spacing */
	$page_topbottom_spacing_top = orion_get_theme_option_css(array('page_topbottom_spacing', 'padding-top'), '60px' );
	$page_topbottom_spacing_bottom = orion_get_theme_option_css(array('page_topbottom_spacing', 'padding-bottom'), '60px' );	
	$page_topbottom_spacing_top_check = rtrim($page_topbottom_spacing_top, 'px');
	$page_topbottom_spacing_bottom_check = rtrim($page_topbottom_spacing_bottom, 'px');

	if ((int)$page_topbottom_spacing_top_check > 60) {
		$mobile_page_topbottom_spacing_top = '60px';
	} else {
		$mobile_page_topbottom_spacing_top = $page_topbottom_spacing_top;
	}
	if ((int)$page_topbottom_spacing_bottom_check > 60) {
		$mobile_page_topbottom_spacing_bottom = '60px';
	} else {
		$mobile_page_topbottom_spacing_bottom = $page_topbottom_spacing_bottom;
	}
?>

@media (max-width: 991px) {
	body .site-main {
	    padding-top: <?php echo esc_attr($mobile_page_topbottom_spacing_top);?>;
    	padding-bottom: <?php echo esc_attr($mobile_page_topbottom_spacing_bottom);?>;
	}
}
<?php
/*********************************** O.o ***********************************/
/*                          submenu separators  	    				   */ 
/***************************************************************************/
?>
@media (min-width: 992px) {
	header.nav-dark .nav-menu ul.sub-menu li.menu-item:not(:last-child):not(.orion-megamenu-subitem):after {
		background-color: <?php echo esc_attr($submenu_border_nav_dark);?>;
	}
	header.nav-light .nav-menu ul.sub-menu li.menu-item:not(:last-child):not(.orion-megamenu-subitem):after {
		background-color: <?php echo esc_attr($submenu_border_nav_light);?>;
	}

	header .nav-menu .orion-megamenu.mega-light-borders ul.sub-menu .sub-menu li.menu-item:not(:last-child):after {
		background-color: <?php echo esc_attr($submenu_border_nav_light);?>;
	}
	header .nav-menu .orion-megamenu.mega-dark-borders ul.sub-menu .sub-menu li.menu-item:not(:last-child):after {
		background-color: <?php echo esc_attr($submenu_border_nav_dark);?>;
	}	
}

/*********************************** O.o ***********************************/
/*                          Woo borders  	    				           */ 
/***************************************************************************/

@media (min-width: 992px) { 
	header.nav-light .last-tab-wrap .woocart ul.product_list_widget > li.mini_cart_item {
		border-color: <?php echo esc_attr($submenu_border_nav_light);?>;
	}
	header.nav-dark .last-tab-wrap .woocart ul.product_list_widget > li.mini_cart_item {
		border-color: <?php echo esc_attr($submenu_border_nav_dark);?>;
	}	
}



<?php
/*********************************** O.o ***********************************/
/*                            Overlays - mobile		                       */ 
/***************************************************************************/
?>
@media(max-width: 991px) {
	.isotope-el .overlay-hover-primary .overlay {
	    background: <?php echo esc_attr($color_1);?>;
	    opacity: 0.8;			
	}
	.isotope-el .overlay-hover-secondary .overlay{
	    background: <?php echo esc_attr($color_2);?>;
	    opacity: 0.8;	
	}
	.isotope-el .overlay-hover-tertiary .overlay{
	    background: <?php echo esc_attr($color_3);?>;
	    opacity: 0.8;	
	}
}
<?php
/*********************************** O.o ***********************************/
/*                             	  Mega Menu		                           */ 
/***************************************************************************/
?>

header.nav-style-2 .nav-menu > .orion-megamenu > .mega-indicator-wrap:after,
header.nav-style-3 .nav-menu > .orion-megamenu > .mega-indicator-wrap:after {
	border-bottom-color: <?php echo esc_attr($megamenu_nav_color);?>;
}

<?php
/*********************************** O.o ***********************************/
/*                             	  Top Bar 		                           */ 
/***************************************************************************/
?>
.top-bar, .top-bar .widget_shopping_cart .orion-cart-wrapper {
	background-color: <?php echo esc_attr($topbar_background);?>;
}

.top-bar-toggle {
	border-top-color: <?php echo esc_attr($topbar_background);?>;
}
<?php 
/*********************************** O.o ***********************************/
/*                                	Logo                                   */ 
/***************************************************************************/
?>
@media (min-width: 992px) {
	.mainheader a.logo > img {
		max-height: <?php orion_option_css(array('logo_max_dimensions','height'), '72');?>px;
		max-width: <?php orion_option_css(array('logo_max_dimensions','width'), '300');?>px;
	} 
	.header-classic .site-branding, .header-classic .site-branding .text-logo,  header.stickymenu .site-branding {
		width: <?php orion_option_css(array('logo_max_dimensions','width'), '300');?>px;
	}
}
<?php
/*********************************** O.o ***********************************/
/*                             MAIN NAVIGATION                             */ 
/***************************************************************************/
?>	

@media (min-width: 992px) {	
	header.nav-dark:not(.stickymenu) .nav-container {
		background-color:<?php echo esc_attr($nav_menu_bg_color_nav_dark);?>;
	}
	header.nav-light:not(.stickymenu) .nav-container {
		background-color:<?php echo esc_attr($nav_menu_bg_color_nav_light);?>;
	}
}

<?php /*    DESKTOP    */?>	
@media (min-width: 992px) {	

	<?php // Dark navigation style ?>			
	.nav-dark .nav-menu > li > a, .nav-dark .nav-menu > ul > li > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_nav_dark);?>;
	}
	.site-branding.text-light .site-title span {
		color:  <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
	}

	.nav-dark .nav-menu > li:hover > a, .nav-dark .nav-menu > ul > li:hover > a, .nav-dark .nav-menu > li:focus > a, .nav-dark .nav-menu > ul > li:focus > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_hover_nav_dark);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_hover_nav_dark);?>;
	}	
	.nav-dark .nav-menu > li.current-menu-item > a, .nav-dark .nav-menu > li.current-menu-ancestor > a, .nav-dark .nav-menu > li.one-page-current-item > a,
	.nav-dark .nav-menu > li.one-page-current-anchester > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_active_nav_dark);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_active_nav_dark);?>;
	}
	.nav-dark .last-tab-wrap .woo-cart-icon {
		color:  <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
	}

	<?php // submenues ?>
	.nav-dark ul.sub-menu:not(.mega-light) li.menu-item > a, .orion-megamenu ul.sub-menu.nav-dark li.menu-item > a, .nav-dark ul.sub-menu:not(.nav-light) li.menu-item > span, .nav-dark .nav-menu ul.sub-menu:not(.mega-light) li > a > span.coll_btn i, .nav-dark .search-submit, .nav-dark .search-form input, header.nav-dark .nav-menu .togglecontainer .widget_nav_menu li a, li.orion-megamenu > ul.sub-menu.nav-dark > li:hover > a, header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper, header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn),
	header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn) span{
		color: <?php echo esc_attr($submenu_colors_regular_nav_dark);?>;
	}
	.nav-dark ul.sub-menu .menu-item:hover > a, .nav-dark ul.sub-menu li.menu-item:hover > a:not(.btn):hover, .nav-dark .nav-menu ul.sub-menu li:hover > a > span.coll_btn i, .nav-dark ul.sub-menu li:focus > a, .nav-dark .nav-menu ul.sub-menu li:focus > a > span.coll_btn i, header.nav-dark .nav-menu .togglecontainer .widget_nav_menu li a:hover, .widget_nav_menu.text-dark .current-menu-ancestor > a,
	 li.orion-megamenu > ul.sub-menu.nav-dark > li > a:hover, header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn):hover, header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn):hover span {
		color: <?php echo esc_attr($submenu_colors_hover_nav_dark);?>;
	}
	
	.nav-dark ul.sub-menu li.menu-item:not(.orion-megamenu-subitem).current-menu-item > a,
	.nav-dark ul.sub-menu li.menu-item:not(.orion-megamenu-subitem).current-menu-ancestor > a, , .nav-dark ul.sub-menu li.menu-item.one-page-current-item > a, .nav-dark ul.sub-menu li.menu-item.one-page-current-anchester > a {
		color: <?php echo esc_attr($submenu_colors_active_nav_dark);?>;
	}

	.nav-dark .nav-menu li:not(.orion-megamenu-subitem) > ul.sub-menu, .nav-dark .nav-menu .togglecontainer, header.nav-dark .main-nav-wrap .nav-menu .orion-cart-wrapper {
		background-color: <?php echo esc_attr($submenu_background_nav_dark);?>;
	}		
	header.nav-dark .site-navigation .search.open .searchwrap {
		background-color: <?php echo esc_attr($submenu_background_nav_dark);?>;
	}		

	<?php // search (dark) ?>		
	.nav-dark .to-x .search-box .circle.top {
		border-top-color: <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
		border-left-color: <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
	}
	.nav-dark .to-x .search-box .circle.bottom {
		border-right-color: <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
		border-bottom-color: <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
	}
	.nav-dark .to-x .search-box .handle {
		background-color: <?php echo esc_attr($first_lvl_menu_color_nav_dark);?>;
	}

	<?php // Light navigation style ?>
	.nav-light .nav-menu > li > a, .nav-light .nav-menu > ul > li > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_nav_light);?>;
	}
	.nav-light .nav-menu > li:hover > a, .nav-light .nav-menu > ul > li:hover > a, .nav-light .nav-menu > li:focus > a, .nav-light .nav-menu > ul > li:focus > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_hover_nav_light);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_hover_nav_light);?>;
	}	
	.nav-light .nav-menu > li.current-menu-item > a, .nav-light .nav-menu > li.current-menu-ancestor > a, .nav-light .nav-menu > li.one-page-current-item > a,
	.nav-light .nav-menu > li.one-page-current-anchester > a {
		color:  <?php echo esc_attr($first_lvl_menu_color_active_nav_light);?>;
		background: <?php echo esc_attr($first_lvl_menu_bg_active_nav_light);?>;
	}	
	.nav-light .last-tab-wrap .woo-cart-icon {
		color:  <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
	}
	<?php // submenues ?>
	.nav-light ul.sub-menu li.menu-item > a, .nav-light ul.sub-menu li.menu-item > span, .nav-light .nav-menu ul.sub-menu li > a > span.coll_btn i,
	.orion-megamenu ul.sub-menu.nav-light li.menu-item > a,
	header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper,
	header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn),
	header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn) span
	{
		color: <?php echo esc_attr($submenu_colors_regular_nav_light);?>;
	}
	.nav-light ul.sub-menu li.menu-item:not(.orion-megamenu-subitem):hover > a:not(.btn),  ul.sub-menu.nav-light .megamenu-sidebar .widget_nav_menu li > a:not(.btn):hover,  ul.sub-menu.nav-light li.orion-megamenu-subitem > a:hover, .nav-light .nav-menu ul.sub-menu li:hover > a > span.coll_btn i, .nav-light ul.sub-menu li:focus > a, .nav-light .nav-menu ul.sub-menu li:focus > a > span.coll_btn i, header.nav-light .nav-menu .togglecontainer .widget_nav_menu li a:hover, ul.sub-menu > .current-menu-item > a, .nav-light ul.sub-menu .current-menu-item > a, ul.sub-menu > .current-menu-ancestor > a, .nav-light ul.sub-menu .current-menu-ancestor > a,
	header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn):hover,
	header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper a:not(.btn):hover span
	 {
		color: <?php echo esc_attr($submenu_colors_hover_nav_light);?>;
	}
	
	.nav-light ul.sub-menu li.menu-item:not(.orion-megamenu-subitem).current-menu-item > a:not(.btn),
	.nav-light ul.sub-menu li.menu-item:not(.orion-megamenu-subitem).current-menu-ancestor > a:not(.btn),
	.nav-light ul.sub-menu li.menu-item.one-page-current-anchester > a, .nav-light ul.sub-menu li.menu-item.one-page-current-item > a {
	color: <?php echo esc_attr($submenu_colors_active_nav_light);?>;
	}

	.nav-light .nav-menu li:not(.orion-megamenu-subitem) > ul.sub-menu, .nav-light .nav-menu .togglecontainer {
		background-color: <?php echo esc_attr($submenu_background_nav_light);?>; 
	}

	header.nav-light .site-navigation .search.open .searchwrap, header.nav-light .nav-menu .togglecontainer .widget_nav_menu li a, header.nav-light .main-nav-wrap .nav-menu .orion-cart-wrapper {
		background-color: <?php echo esc_attr($submenu_background_nav_light);?>;
	}			

	<?php // before elements?>	
	.header-classic.nav-light .nav-menu > li > .sub-menu:before, .header-classic.nav-light .nav-menu > li.mega-menu-item.mega-active:before,
	.header-with-widgets.nav-light .nav-menu > li > .sub-menu:before {
		border-bottom-color: <?php echo esc_attr($submenu_background_nav_light);?>;

	}
	.header-classic.nav-dark .nav-menu > li > .sub-menu:before, .header-classic.nav-dark .nav-menu > li.mega-menu-item.mega-active:before,
	.header-with-widgets.nav-dark .nav-menu > li > .sub-menu:before {
		border-bottom-color: <?php echo esc_attr($submenu_background_nav_dark);?>;
	}		

	<?php // search (light) ?>		
	.nav-light .to-x .search-box .circle.top {
		border-top-color: <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
		border-left-color: <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
	}
	.nav-light .to-x .search-box .circle.bottom {
		border-right-color: <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
		border-bottom-color: <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
	}
	.nav-light .to-x .search-box .handle {
		background-color: <?php echo esc_attr($first_lvl_menu_color_nav_light);?>;
	}
}	
<?php 
$mobile_light_color = orion_get_theme_option_css('mobile_menu_background',$nav_menu_bg_color_nav_light);
	if ($mobile_light_color == 'transparent') {
		$mobile_light_color = '#f2f2f2';
	}
?>
@media (max-width: 991px) {	
	.site-header .nav-container.open, .site-header .mobile-cart.open {
		background-color: <?php orion_option_css('mobile_menu_background','#f2f2f2');?>;
	}
	header.site-header.nav-dark .nav-container.open, .site-header.nav-dark .mobile-cart.open  {
		background-color: <?php orion_option_css('mobile_menu_background',$nav_menu_bg_color_nav_dark);?>;
	}
	header.site-header.nav-light .nav-container.open, .site-header.nav-light .mobile-cart.open {
		background-color: <?php echo esc_attr($mobile_light_color);?>;
	}

	header.nav-light .nav-menu li:not(.current-menu-item):not(:hover) > a, header.nav-light .nav-menu li.menu-item > span, .nav-light .coll_btn i, .nav-light .site-navigation .widget .description, .nav-light .coll_btn i, .nav-light .site-navigation .widget h4, .nav-light .site-navigation .widget p, 
		.nav-light .site-navigation .widget-title, 
		.nav-light .mobile-cart a:not(.btn), .nav-light .mobile-cart, .nav-light .mobile-cart a > .item-title,
		.nav-light .menu-item .search-form .searchfield, .nav-light .site-navigation input.search-submit,
		.nav-light .woo-cart-icon  {

		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), 'rgba(0,0,0,.8)', 'first-lvl-menu-colors');?>;
	}

	.nav-dark .nav-menu li > a, header.nav-dark .nav-menu ul.sub-menu li:not(:hover) > a ,header.nav-dark .nav-menu ul.sub-menu li > span , .nav-dark .coll_btn i, .nav-dark .site-navigation .widget .description, .nav-dark .coll_btn i, .nav-dark .site-navigation .widget .item-title, .nav-dark .site-navigation .widget p, .nav-dark .site-navigation .widget-title,
	.nav-dark .menu-item.search .searchfield, .nav-dark .site-navigation input.search-submit, .nav-dark .mobile-cart a:not(.btn), .nav-dark .mobile-cart, .nav-dark .mobile-cart a > .item-title, .nav-dark .woo-cart-icon  {

		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), $first_lvl_menu_color_nav_dark );?>;
	}

	<?php // placeholder color ?>
	.nav-light .nav-menu .search-form input.searchfield::-webkit-input-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), 'rgba(0,0,0,.8)', 'first-lvl-menu-colors');?>;
		opacity: 0.8;
	}
	.nav-light .nav-menu .search-form input.searchfield::-moz-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), 'rgba(0,0,0,.8)', 'first-lvl-menu-colors');?>;
		opacity: 0.8;
	}
	.nav-light .nav-menu .search-form input.searchfield:-ms-input-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), 'rgba(0,0,0,.8)', 'first-lvl-menu-colors');?>;
		opacity: 0.8;
	}
	.nav-light .nav-menu .search-form input.searchfield::placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), 'rgba(0,0,0,.8)', 'first-lvl-menu-colors');?>;
		opacity: 0.8;
	}
		
	.nav-dark .nav-menu .search-form input.searchfield::-webkit-input-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), $first_lvl_menu_color_nav_dark );?>;
		opacity: 0.8;
	}
	.nav-dark .nav-menu .search-form input.searchfield::-moz-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), $first_lvl_menu_color_nav_dark );?>;
		opacity: 0.8;
	}
	.nav-dark .nav-menu .search-form input.searchfield:-ms-input-placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), $first_lvl_menu_color_nav_dark );?>;
		opacity: 0.8;
	}
	.nav-dark .nav-menu .search-form input.searchfield::placeholder {
		color: <?php orion_option_css(array('mobile_menu_link_colors','regular'), $first_lvl_menu_color_nav_dark );?>;
		opacity: 0.8;
	}

	.nav-menu li:hover > a, header .nav-menu ul.sub-menu li:hover > a, .site-header .coll_btn:hover i, .nav-menu li.current-menu-item > a, .nav-menu li.current-menu-ancestor > a {
		color: <?php orion_option_css(array('mobile_menu_link_colors','active'), $color_1) ;?>!important;
	}

	.coll_btn i {
		line-height: <?php echo esc_attr(orion_get_theme_option_css(array('first-lvl-menu', 'line-height'), '48px'));?>;
	}
	.sub-menu > li > a, .sub-menu > li > span {
		line-height: <?php echo esc_attr(orion_get_theme_option_css(array('first-lvl-menu', 'line-height'), '48px'));?>;
	}
}	


<?php if ($navigation_links_color_style == 'nav-light') {
	$first_lvl_menu_bg = $nav_menu_bg_color_nav_light;
	$first_lvl_menu_bg_active = $first_lvl_menu_bg_active_nav_light;
} else {
	$first_lvl_menu_bg = $nav_menu_bg_color_nav_dark;
	$first_lvl_menu_bg_active = $first_lvl_menu_bg_active_nav_dark;
}
if ($first_lvl_menu_bg == 'transparent' && $first_lvl_menu_bg_active == 'transparent' ) : ?>
	@media (min-width: 992px) {
		header.header-classic .nav-menu > li:last-child > a {
		    padding-right: 0;
		}
	}
<?php endif; ?>

<?php 
/*********************************** O.o ***********************************/
/*                     MAIN NAVIGATION header-with-widgets                 */ 
/***************************************************************************/
?>	
<?php $nav_hww_size = orion_get_theme_option_css('navbar_hight_with_widgets', '96');?>
@media (min-width: 992px) {	
	.header-with-widgets.nav-style-1 .nav-menu > li > a, .header-with-widgets.nav-style-3 .nav-menu > li > a {
		padding-top: <?php echo esc_attr(($nav_hww_size - 48 )/ 2);?>px;
		padding-bottom: <?php echo esc_attr(($nav_hww_size - 48 ) / 2);?>px;
	}

	.header-with-widgets.nav-style-1 .nav-menu > .last-tab > .last-tab-wrap,
	.header-with-widgets.nav-style-3 .nav-menu > .last-tab > .last-tab-wrap
	{
		padding-top: <?php echo esc_attr(($nav_hww_size - 48 )/ 2);?>px;
	}

	.header-with-widgets.nav-style-2 .nav-menu > li:not(.last-tab) {
		padding-top: <?php echo esc_attr(($nav_hww_size - 36 )/ 2);?>px;
		padding-bottom: <?php echo esc_attr(($nav_hww_size - 36 ) / 2);?>px;
	}
	.header-with-widgets.nav-style-2 .container-fluid .site-navigation {
		padding-left: <?php echo esc_attr(($nav_hww_size - 36 )/ 2);?>px;
		padding-right: <?php echo esc_attr(($nav_hww_size - 36 )/ 2);?>px;
	}	

	.header-with-widgets.nav-style-2 .nav-menu > li.last-tab {
		padding-top: <?php echo esc_attr(($nav_hww_size - 36 )/ 2);?>px;
	}
	.header-with-widgets.nav-style-2:not(.stickymenu) .nav-menu > .orion-megamenu > .mega-indicator-wrap:after, .header-with-widgets.nav-style-3:not(.stickymenu) .nav-menu > .orion-megamenu > .mega-indicator-wrap:after {
		top: <?php echo esc_attr(($nav_hww_size - 36 )/ 2);?>px;
	}	

}
header.header-with-widgets.nav-style-2.nav-light .nav-menu > li > .sub-menu:before {
	border-bottom-color: <?php echo esc_attr($submenu_background_nav_light);?>; 
}
.nav-style-2.nav-light .nav-menu > li > .sub-menu:before, .nav-style-3.nav-light .nav-menu > li > .sub-menu:before {
	border-bottom-color: <?php echo esc_attr($submenu_background_nav_light);?>; 
}

/* sticky */
header.header-with-widgets.nav-style-2.nav-dark .nav-menu > li > .sub-menu:before, header.header-with-widgets.nav-style-3.nav-dark .nav-menu > li > .sub-menu:before   {
	border-bottom-color: <?php echo esc_attr($submenu_background_nav_dark);?>;
}		
.nav-style-2.nav-dark .nav-menu > li > .sub-menu:before, .nav-style-3.nav-dark .nav-menu > li > .sub-menu:before {
	border-bottom-color: <?php echo esc_attr($submenu_background_nav_dark);?>;
}

<?php $header_hight_with_widgets = orion_get_theme_option_css('header_hight_with_widgets', '92');?>
@media (min-width: 992px) {	
	.header-with-widgets > .mainheader > div > .container,  .header-with-widgets .site-branding{
		min-height: <?php echo esc_attr($header_hight_with_widgets);?>px;
	}
}
<?php 	
/*********************************** O.o ***********************************/
/*                          END MAIN NAVIGATION                            */ 
/***************************************************************************/
?>	

<?php
	// search icon padding
if ( $orion_options['search_icon'] == '1' ) : ?>
@media (max-width: 991px) {
	.nav-menu > li:nth-last-child(2) > a {
		border-bottom: none;
	}
}
<?php endif; ?>

<?php // icon ?>

.top-bar .so-widget-orion_mega_widget_topbar > .widget-title span[class*="icon"] {
	color: <?php orion_option_css(array('megawidget-icon-colors','regular'), $color_1);?>;
}
.top-bar .so-widget-orion_mega_widget_topbar > .widget-title:not(.active):hover span[class*="icon"] {
	color: <?php orion_option_css(array('megawidget-icon-colors','hover'), $color_1);?>;
}	
.top-bar .so-widget-orion_mega_widget_topbar > .widget-title.active span[class*="icon"] {
	color: <?php echo esc_attr($megawidget_icon_color['active']);?>;
}

<?php // Featured icon ?>

.top-bar .so-widget-orion_mega_widget_topbar > .widget-title.featured span[class*="icon"] {
	color: <?php orion_option_css(array('featured-megawidget-icon-colors','regular'), $color_2);?>;
}
.top-bar .so-widget-orion_mega_widget_topbar > .widget-title.featured:not(.active):hover span[class*="icon"] {
	color: <?php orion_option_css(array('featured-megawidget-icon-colors','hover'), $color_2);?>;
}	
.top-bar .so-widget-orion_mega_widget_topbar > .widget-title.featured.active span[class*="icon"] {
	color: <?php orion_option_css(array('featured-megawidget-icon-colors','active'), '#fff');?>;
}

<?php // Typography ?>	

<?php  /* next and previous post */?>
.prev-post a:hover, .next-post a:hover {
	background-color: <?php echo esc_attr(orion_hextorgba($color_1, '0.85'));?>;
}
.prev-post.bg-img a:not(:hover), .next-post.bg-img a:not(:hover) {
	background-color: rgba(255,255,255,1);
}

@media (min-width: 992px) {	
	.header-classic.site-header .site-branding {
		min-height: <?php echo esc_attr($header_hight_classic);?>px;
	}

	.header-with-widgets.site-header .site-branding {
		min-height: <?php echo esc_attr($header_hight_with_widgets);?>px;
	}
	.header-with-widgets .relative-wrap {
		height: <?php echo esc_attr($header_hight_with_widgets);?>px;
	}

	.header-with-widgets.site-header .header-widgets > * {
		max-height: <?php echo esc_attr($header_hight_with_widgets);?>px;
	}

	.header-with-widgets.site-header .header-widgets img {
		max-height: <?php echo esc_attr($header_hight_with_widgets);?>px;
		width: auto;
	}

	.header-classic.nav-style-1:not(.stickymenu) .nav-menu > li > a,
	.header-classic.nav-style-2:not(.stickymenu) .nav-menu > li:not(.last-tab),
	.header-classic.nav-style-3:not(.stickymenu) .nav-menu > li > a
	 {
		padding-top: <?php echo esc_attr($li_padding_top_classic);?>px;
		padding-bottom: <?php echo esc_attr($li_padding_top_classic);?>px;
	}
	.header-classic.nav-style-2:not(.stickymenu) .nav-menu > .orion-megamenu > .mega-indicator-wrap:after
	{
		top: <?php echo esc_attr($li_padding_top_classic);?>px;
	}

	.header-classic.nav-style-3:not(.stickymenu) .nav-menu > li > .last-tab-wrap,
	.header-classic.nav-style-1:not(.stickymenu) .nav-menu > li > .last-tab-wrap,		
	.header-classic.nav-style-2:not(.stickymenu) .nav-menu > .last-tab {
		padding-top: <?php echo esc_attr($li_padding_top_classic);?>px;
	}


	.nav-style-2:not(.type-fluid-nav):not(.stickymenu) .nav-menu > li > .sub-menu, .nav-style-2:not(.type-fluid-nav):not(.stickymenu) .nav-menu > li > .togglecontainer {
		top: <?php echo esc_attr($header_hight_classic);?>px;
	}

	.header-classic a.logo > img, .header-classic a.site-title {
		top: <?php echo esc_attr($logo_position_hight_classic);?>%;
	}

	.header-with-widgets a.logo > img{
		top: <?php echo esc_attr($logo_position_hight_with_widgets);?>%;
	}	
	.header-with-widgets a.site-title > span, .header-classic a.site-title > span{
		top: <?php echo esc_attr($logo_position_hight_with_widgets);?>%;
	    transform: translateY(-50%);
	    position: absolute;
	}    
}

.primary-hover:hover, .primary-hover:hover > a {
	color: <?php echo esc_attr($color_1);?>;
}

<?php //boxed 
if($orion_options['boxed_fullwidth'] == 0 ) : ?>
@media (min-width: 1200px) {	
	body.boxed .boxed-container {
		max-width: <?php echo esc_attr($orion_options['boxed_site_width']);?>px;
		margin-top: <?php echo esc_attr($orion_options['boxed_top_margin']['margin-top']);?>;
		margin-bottom: <?php echo esc_attr($orion_options['boxed_top_margin']['margin-bottom']);?>;
	}
	body.boxed .site .site-content, body.boxed .site .prefooter, body.boxed .main-footer, body.boxed .copyright-footer {
		padding-left: <?php echo esc_attr($orion_options['boxed_site_padding'] -15);?>px; 
		padding-right: <?php echo esc_attr($orion_options['boxed_site_padding'] -15);?>px; 
	}
	body.boxed .header-with-widgets .mainheader > div > .container, body.boxed .top-bar .container, body.boxed .header-classic .nav-container .container,
	.boxed-container .header-classic .widget-section .container,
	body.boxed .stickymenu .nav-container .container {
		padding-left: <?php echo esc_attr($orion_options['boxed_site_padding']);?>px; 
		padding-right: <?php echo esc_attr($orion_options['boxed_site_padding']);?>px; 
	}
	body.boxed .header-with-widgets .container .main-nav-wrap, .page-heading {
		padding-left: <?php echo esc_attr($orion_options['boxed_site_padding'] -15);?>px; 
		padding-right: <?php echo esc_attr($orion_options['boxed_site_padding'] -15);?>px; 
	}
	body.boxed .stickymenu .container {
		width: <?php echo esc_attr($orion_options['boxed_site_width']);?>px;
		padding: 0;
	}
}
<?php endif;?>

<?php // set siteorigin behaviour for boxed / fullwidth layout
$so_option = get_option('siteorigin_panels_settings');
if($orion_options['boxed_fullwidth'] == 0 ) {
	$so_option['full-width-container'] = '.boxed-container';
	update_option('siteorigin_panels_settings', $so_option);
} else {
	$so_option['full-width-container'] = 'body';
	update_option('siteorigin_panels_settings', $so_option);
}?>

<?php /* overlays */ ?>
/*********************************** O.o ***********************************/
/* 		                         Overlays                              	   */ 
/***************************************************************************/
.overlay-c1-wrapper {
    background: <?php echo esc_attr($color_1);?>;
    opacity: 0.9;
} 
.overlay-c2-wrapper {
    background: <?php echo esc_attr($color_2);?>;
    opacity: 0.9;
} 
.overlay-c3-wrapper {
    background: <?php echo esc_attr($color_3);?>;
    opacity: 0.9;
}
.overlay-c1-c2-wrapper {
    background: linear-gradient(-45deg, <?php echo esc_attr($color_1);?>, <?php echo esc_attr($color_2);?>);
    opacity: 0.85;
} 
.overlay-c2-c1-wrapper {
    background: linear-gradient(-45deg, <?php echo esc_attr($color_2);?>, <?php echo esc_attr($color_1);?>);
    opacity: 0.85;
} 
@media (min-width: 992px) {	
	.overlay-c1-t-wrapper{
		background: linear-gradient(90deg,<?php echo esc_attr($color_1);?> 0%,rgba(255,255,255,0) 100%);
	    opacity: 0.95;
	} 
	.overlay-c2-t-wrapper{
		background: linear-gradient(90deg,<?php echo esc_attr($color_2);?> 0%,rgba(255,255,255,0) 100%);
	    opacity: 0.95;
	} 
	.overlay-c3-t-wrapper{
		background: linear-gradient(90deg,<?php echo esc_attr($color_3);?> 0%,rgba(255,255,255,0) 100%);
	    opacity: 0.95;
	}
}
@media (max-width: 991px) {	
	.overlay-c1-t-wrapper{
		background: <?php echo esc_attr($color_1);?>;
	    opacity: 0.85;
	} 
	.overlay-c2-t-wrapper{
		background: <?php echo esc_attr($color_2);?>;
	    opacity: 0.85;
	} 
	.overlay-c3-t-wrapper{
		background: <?php echo esc_attr($color_3);?>;
	    opacity: 0.85;
	}
}

/*********************************** O.o ***********************************/
/* 		                         WooCommerce                           	   */ 
/***************************************************************************/
.woocommerce-info {
    border-top-color: <?php echo esc_attr($color_1);?>;
}
.woocommerce-info a:not(:hover), .woocommerce-message a:not(:hover), .woocommerce-error a:not(:hover), .woocommerce-notice a:not(:hover) {
    color: <?php echo esc_attr(orion_adjustBrightness($color_1, -15 ));?>;
}
.woocommerce-info a:hover, .woocommerce-message a:hover, .woocommerce-error a:hover, .woocommerce-notice a:hover  {
    color: <?php echo esc_attr($color_1);?>;
}


<?php }

// require buttons
require_once get_template_directory().'/framework/css/button-styles.php';
require_once get_template_directory().'/framework/css/typography.php';
// compiler
add_filter('redux/options/recycle/compiler', 'compiler_action', 10, 3);
 
function compiler_action($options, $css, $changed_values) {
   	ob_start();
    orion_create_custom_css();
    orion_create_custom_buttons_css();
    orion_create_typography_css();
	$css = ob_get_clean();
	$minifiedCss = orion_minify_css($css);
	/* update theme options CSS */
	if (orion_get_theme_option_css('minimize_css', false ) == true) {
    	update_option( 'orion_theme_option_css', $minifiedCss);
    } else {
    	update_option( 'orion_theme_option_css', $css);
    }
    /* write CSS options to a file */		
    global $wp_filesystem;
 
    $filename = get_template_directory() . '/framework/css/orion-redux.css';
 
    if( empty( $wp_filesystem ) ) {
        require_once( ABSPATH .'/wp-admin/includes/file.php' );
        WP_Filesystem();
    }
 
    if( $wp_filesystem ) {
        $wp_filesystem->put_contents(
            $filename,
            $css,
            FS_CHMOD_FILE // predefined mode settings for WP files
        );
    }        
}

