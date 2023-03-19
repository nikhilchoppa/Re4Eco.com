<?php 
	
	function orion_create_typography_css(){ 

	$recycle_options = get_option('recycle');
	
	$color_1 = orion_get_theme_option_css('main_theme_color', '#22AA86' );
	$color_2 = orion_get_theme_option_css('secondary_theme_color', '#9CC026' );
	$color_3 = orion_get_theme_option_css('color_3', '#44514E' );


	// active submenus
	$submenu_colors_nav_light_active = orion_get_theme_option_css(array('submenu_colors_nav_light','active'),'rgba(255,255,255,.6)');
	$submenu_colors_nav_dark_active = orion_get_theme_option_css(array('submenu_colors_nav_dark','active'),'rgba(0,0,0,.6)');

	/* paragraph dark */
	$paragraph_colors_dark_color = orion_get_theme_option_css('paragraph_colors_dark', '#000' );
	$paragraph_colors_dark = orion_hextorgba($paragraph_colors_dark_color, orion_get_theme_option_css('paragraph_colors_dark_opacity', '.6' ));
	/* headings dark */
	$heading_colors_dark = orion_get_theme_option_css('heading_colors_dark', '#000' );
	$heading_colors_dark = orion_hextorgba($heading_colors_dark, orion_get_theme_option_css('heading_colors_dark_opacity', '0.8' ));

	/* page title */
	$pagetitle_colors_dark = orion_get_theme_option_css('pagetitle_colors_dark', '#000' );
	$pagetitle_colors_dark = orion_hextorgba($pagetitle_colors_dark, orion_get_theme_option_css('pagetitle_colors_dark_opacity', '0.55' ));

	$pagetitle_colors_light = orion_get_theme_option_css('pagetitle_colors_light', '#fff' );
	$pagetitle_colors_light = orion_hextorgba($pagetitle_colors_light, orion_get_theme_option_css('pagetitle_colors_dark_opacity', '0.55' ));

	$pagetitle_font_color_classic = orion_get_theme_option_css('pagetitle_font_color_classic', '#000' );
	$pagetitle_font_color_classic = orion_hextorgba($pagetitle_font_color_classic, orion_get_theme_option_css('pagetitle_opacity_classic', '0.85' ));

	$pagetitle_font_color_leftaligned = orion_get_theme_option_css('pagetitle_font_color_leftaligned', '#000' );
	$pagetitle_font_color_leftaligned = orion_hextorgba($pagetitle_font_color_leftaligned, orion_get_theme_option_css('pagetitle_opacity_leftaligned', '0.9' ));

	$pagetitle_font_color_centered = orion_get_theme_option_css('pagetitle_font_color_centered', '#fff' );
	$pagetitle_font_color_centered = orion_hextorgba($pagetitle_font_color_centered, orion_get_theme_option_css('pagetitle_opacity_centered', '0.9' ));


	/* links dark */
	$link_colors_dark = $recycle_options['link_colors_dark'];
	$link_colors_dark_opacity = orion_get_theme_option_css('link_colors_dark_opacity', '.55' );

	/* paragraph light */
	$paragraph_colors_light_color = orion_get_theme_option_css('paragraph_colors_light', '#fff' );
	$paragraph_colors_light = orion_hextorgba($paragraph_colors_light_color, orion_get_theme_option_css('paragraph_colors_light_opacity', '.9' ));
	/* headings light */
	$heading_colors_light_color = orion_get_theme_option_css('heading_colors_light', '#fff' );
	$heading_colors_light = orion_hextorgba($heading_colors_light_color, orion_get_theme_option_css('heading_colors_light_opacity', '0.8' ));
	/* links light */
	$link_colors_light = $recycle_options['link_colors_light'];
	$link_colors_light_opacity = orion_get_theme_option_css('link_colors_light_opacity', '.7' );

	/* add opacity to regular links dark */
	if ($link_colors_dark['regular'] != null && $link_colors_dark_opacity != null) {
		$link_colors_dark_regular = orion_hextorgba($link_colors_dark['regular'],$link_colors_dark_opacity) ; 
	} else {
		$link_colors_dark_regular = 'rgba(0,0,0,.7)';
	}

	/* add opacity to regular links light */
	if ($link_colors_light['regular'] != null && $link_colors_light_opacity != null) {
		$link_colors_light_regular = orion_hextorgba($link_colors_light['regular'],$link_colors_light_opacity); 
	} else {
		$link_colors_light_regular = 'rgba(255,255,255, 0.7)';
	}

	/* hover and active link colors */
	$link_colors_dark_hover = orion_get_theme_option_css(array('link_colors_dark','hover'), '#000');
	$link_colors_dark_active = orion_get_theme_option_css(array('link_colors_dark','active'), '#000');	
	$link_colors_light_hover = orion_get_theme_option_css(array('link_colors_light','hover'), '', '#fff' );
	$link_colors_light_active = orion_get_theme_option_css(array('link_colors_light','active'), '', '#fff' );


	/* Meta & Caption Text Colors */

	$meta_colors_dark_regular = orion_get_theme_option_css(array('meta_colors_dark','regular'), '#000');
	$meta_colors_dark_hover = orion_get_theme_option_css(array('meta_colors_dark','hover'), '#000');
	$meta_colors_dark_opacity = orion_get_theme_option_css('meta_colors_dark_opacity', '0.7' );

	if ($meta_colors_dark_regular != null && $meta_colors_dark_opacity != null) {
		$meta_colors_dark_regular = orion_hextorgba($meta_colors_dark_regular,$meta_colors_dark_opacity) ; 
	}

	$meta_colors_light_regular = orion_get_theme_option_css(array('meta_colors_light','regular'), '#fff');
	$meta_colors_light_hover = orion_get_theme_option_css(array('meta_colors_light','hover'), '#fff');
	$meta_colors_light_opacity = orion_get_theme_option_css('meta_colors_light_opacity', '0.7' );

	if ($meta_colors_light_regular != null && $meta_colors_light_opacity != null) {
		$meta_colors_light_regular = orion_hextorgba($meta_colors_light_regular,$meta_colors_light_opacity) ; 
	} 	
?>

<?php // regular text: ?>

p , lead, small, html, body,
.text-dark p, .text-light .text-dark p, .text-dark lead, .text-dark small, .text-light .text-dark lead, .text-light .text-dark small, h1.text-dark > small, h1.text-dark.small, h2.text-dark > small, h2.text-dark.small, h3.text-dark > small, h3.text-dark.small, h4.text-dark > small, h4.text-dark.small, h5.text-dark > small, h5.text-dark.small, h6.text-dark > small, h6.text-dark.small, a.category {
	color: <?php echo esc_attr($paragraph_colors_dark);?>;
}

.text-light p , .text-light lead, .text-light small, .text-light,
.text-dark .text-light p, .text-dark .text-light lead, .text-dark .text-light small, .text-light blockquote footer, h1.text-light > small, h1.text-light.small, h2.text-light > small, h2.text-light.small, h3.text-light > small, h3.text-light.small, h4.text-light > small, h4.text-light.small, h5.text-light > small, h5.text-light.small, h6.text-light > small, h6.text-light.small  {
	color: <?php echo esc_attr($paragraph_colors_light);?>;
}

.text-light .owl-theme .owl-dots .owl-dot, .text-dark .text-light .owl-theme .owl-dots .owl-dot {
  background: <?php echo esc_attr(orion_hextorgba($paragraph_colors_light_color, '0.4'));?>;
  box-shadow: inset 0px 0px 0px 1px <?php echo esc_attr(orion_hextorgba($paragraph_colors_light_color, '0.05'));?>; 
}

.text-dark .owl-theme .owl-dots .owl-dot, .text-light .text-dark .owl-theme .owl-dots .owl-dot {
  background: <?php echo esc_attr(orion_hextorgba($paragraph_colors_dark_color, '0.4'));?>;
  box-shadow: inset 0px 0px 0px 1px <?php echo esc_attr(orion_hextorgba($paragraph_colors_dark_color, '0.05'));?>;   
} 

.arrows-aside i,  .arrows-aside .text-dark i {
	color: <?php echo esc_attr(orion_hextorgba($paragraph_colors_dark_color, '0.3'));?>!important;
}
.arrows-aside .text-dark a:hover i, .arrows-aside a:hover i  {
	color: <?php echo esc_attr(orion_hextorgba($paragraph_colors_dark_color, '0.7'));?>!important;
}

.arrows-aside .text-light i {
	color: <?php echo esc_attr(orion_hextorgba($paragraph_colors_light_color, '0.3'));?>!important;
}
.arrows-aside .text-light a:hover i {
	color: <?php echo esc_attr(orion_hextorgba($paragraph_colors_light_color, '0.7'));?>!important;
}
<?php /* post meta */ ?>
.entry-meta span:not(.time), .entry-meta a:not(:hover):not(:focus), .meta a:not(:hover):not(:focus), .text-dark .meta a:not(:hover):not(:focus), .text-light .text-dark .meta a:not(:hover):not(:focus) {
	color: <?php echo esc_attr($meta_colors_dark_regular);?>;
}
.entry-meta a:hover, .entry-meta a:focus, .text-dark .entry-meta a:hover, .text-dark .entry-meta a:focus {
	color: <?php echo esc_attr($meta_colors_dark_hover);?>;
}

.entry-meta.text-light span:not(.time), .entry-meta.text-light a:not(:hover):not(:focus), .recent-post-carousel.text-light .meta a:not(:hover):not(:focus), .text-light .meta a:not(:hover):not(:focus),
.text-light .entry-meta span:not(.time), .single .text-light .bottom-meta span.meta
 {
	color: <?php echo esc_attr($meta_colors_light_regular);?>;
}
.entry-meta.text-light a:hover, .entry-meta.text-light a:focus {
	color: <?php echo esc_attr($meta_colors_light_hover);?>;
}

<?php /* links dark */ ?>
a, .text-dark a:not(.btn):not(:hover), a > .item-title, .text-dark a > .item-title, .text-light .text-dark a > .item-title, .text-light .text-dark a:not(.btn):not(:hover), .header-widgets .widget_nav_menu .sub-menu li a, a.text-dark, .text-dark .widget .search-submit {
	color: <?php echo esc_attr($link_colors_dark_regular);?>;
}
a:hover, a:focus, .text-dark a:not(.btn):hover, .text-light .text-dark a:not(.btn):hover, a:hover > .item-title, .text-dark a:hover > .item-title, .text-light .text-dark a:hover > .item-title, a.text-dark:hover, a.text-dark:focus, .text-dark .widget .search-submit:hover{
	color: <?php echo esc_attr($link_colors_dark_hover);?>;
}
.text-dark a:not(.btn):focus, .text-light .text-dark a:not(.btn):not(.owl-nav-link):not([data-toggle]):focus {
	color: <?php echo esc_attr($link_colors_dark_active);?>;
}

.text-light .text-dark .item-title:after, .text-dark .item-title:after,
.text-light .text-dark .border, .text-dark .border 
{
	border-color: <?php echo esc_attr($heading_colors_dark);?>; 
}

.text-dark .text-light .item-title:after, .text-light .item-title:after,
.text-dark .text-light .border, .text-light .border
{
 border-color: <?php echo esc_attr($heading_colors_light);?>; 
}


.orion-megamenu ul.sub-menu.mega-dark li.current-menu-item > a, .text-dark .current-menu-item a:not(.btn):not(.text-light) {
	color: <?php echo esc_attr($submenu_colors_nav_dark_active);?>;
}

/* text light HEADING colors */
.text-light.h1, .text-light h1, .text-light h2, .text-light h3, .text-light h4, .text-light h5, .text-light h6, .text-light > h1, .text-light > h2, .text-light > h3, .text-light > h4, .text-light > h5, .text-light > h6 {
	color: <?php echo esc_attr($heading_colors_light);?>; 
}
/* text light HEADING colors */
h1.text-light, h2.text-light, h3.text-light, h4.text-light, h5.text-light, h6.text-light {
	color: <?php echo esc_attr($heading_colors_light);?>!important; 
}

.page-heading.heading-centered:not(.text-dark):not(.text-light) h1.page-title{
 	color: <?php echo esc_attr($pagetitle_font_color_centered);?>; 
}
.page-heading.heading-left:not(.text-dark):not(.text-light) h1.page-title{
 	color: <?php echo esc_attr($pagetitle_font_color_leftaligned);?>; 
}
.page-heading.heading-classic:not(.text-dark):not(.text-light) h1.page-title{
 	color: <?php echo esc_attr($pagetitle_font_color_classic);?>; 
}

.page-heading.text-light h1.page-title{
 	color: <?php echo esc_attr($pagetitle_colors_light);?>!important; 
}
.page-heading.text-light .breadcrumbs ol li a, .page-heading.text-light .breadcrumbs ol li:after, .page-heading.text-light .breadcrumbs ol li span {
	color: <?php echo esc_attr($pagetitle_colors_light);?>!important;
}

.page-heading.text-dark h1.page-title  {
	color: <?php echo esc_attr($pagetitle_colors_dark);?>!important; 
}
.page-heading.text-dark .breadcrumbs ol li a, .page-heading.text-dark .breadcrumbs ol li:after, .page-heading.text-dark .breadcrumbs ol li span {
	color: <?php echo esc_attr($pagetitle_colors_dark);?>!important;
}

.text-light h2.item-title, .text-light h3.item-title, .text-light h4.item-title, 
.text-dark .text-light h2.item-title, .text-dark .text-light h3.item-title, .text-dark .text-light h4.item-title,
.text-dark .text-light .item-title,
.text-light .nav-tabs > li:not(.active) > a:not(.text-dark):not(:hover),
.text-light .nav-stacked > li:not(.active) > a:not(.text-dark):not(:hover)
{
 	color: <?php echo esc_attr($heading_colors_light);?>; 
}

.h1.text-dark,
.text-light .text-dark .item-title, .text-dark .item-title,
.text-light .text-dark a.item-title, .text-dark a.item-title,
h1, h2, h3, h4, h5, h6, item-title, a.item-title, a:not(:hover) > h2.item-title.text-dark, a:not(:hover) > h3.item-title.text-dark, a:not(:hover) > h4.item-title.text-dark, 
.text-dark .nav-tabs > li:not(.active) > a:not(:hover),
.text-dark .nav-stacked > li:not(.active) > a:not(:hover),
.text-light .text-dark h2, .text-light .text-dark h3, .text-light .text-dark h4
{
  color: <?php echo esc_attr($heading_colors_dark);?>; 
}

<?php /* links light */ ?>
.text-light a:not(.btn):not(.text-dark), .text-dark .text-light a:not(.btn):not(.text-dark), .text-light a > .item-title, .text-dark .text-light a > .item-title, .text-light .widget .search-submit {
	color: <?php echo esc_attr($link_colors_light_regular);?>;
}
.text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):hover, .text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):hover, .text-light a:hover > .item-title, .text-dark .text-light a:hover > .item-title, .text-light .widget .search-submit:hover{
	color: <?php echo esc_attr($link_colors_light_hover);?>;
}

.text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):focus, .text-dark .text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):focus {
	color: <?php echo esc_attr($link_colors_light_active);?>;
}

.orion-megamenu ul.sub-menu.mega-light li.current-menu-item > a, .text-light .current-menu-item a:not(.btn):not(.text-dark) {
	color: <?php echo esc_attr($submenu_colors_nav_light_active);?>;
}

<?php // links other ?>

a.primary-hover:not(.btn):not([data-toggle]):hover, a.primary-hover:not(.btn):not([data-toggle]):focus {
	color: <?php echo esc_attr($color_1);?>!important;
}
a.secondary-hover:not(.btn):not([data-toggle]):hover, a.secondary-hover:not(.btn):not([data-toggle]):focus {
	color: <?php echo esc_attr($color_2);?>!important;
}
a.tertiary-hover:not(.btn):not([data-toggle]):hover, a.tertiary-hover:not(.btn):not([data-toggle]):focus {
	color: <?php echo esc_attr($color_3);?>!important;
}		

<?php // footer ?>

@media (min-width: 992px) {
  	.site-branding.text-light a.site-title .h1 {
    	color: <?php echo esc_attr($heading_colors_light);?>;  
	}
  	.site-branding.text-dark a.site-title .h1 {
    	color: <?php echo esc_attr($heading_colors_dark);?>;
	} 
}

.text-dark, .text-light .text-dark {
  color: <?php echo esc_attr($paragraph_colors_dark);?>;
}

<?php // headings ?>
<?php 
	$heading_h1_font_color_hex = orion_get_theme_option_css('h1_font_color', '#000' );
	$heading_h1_font_color_opacity = orion_get_theme_option_css('h1_opacity', '.6' );
	$heading_h1_font_color = orion_hextorgba($heading_h1_font_color_hex, $heading_h1_font_color_opacity );
	$heading_h2_font_color_hex = orion_get_theme_option_css('h2_font_color', '#000' );
	$heading_h2_font_color_opacity = orion_get_theme_option_css('h2_opacity', '.8' );
	$heading_h2_font_color = orion_hextorgba($heading_h2_font_color_hex, $heading_h2_font_color_opacity );
	$heading_h3_font_color_hex = orion_get_theme_option_css('h3_font_color', '#000' );
	$heading_h3_font_color_opacity = orion_get_theme_option_css('h3_opacity', '.8' );	
	$heading_h3_font_color = orion_hextorgba($heading_h3_font_color_hex, $heading_h3_font_color_opacity );	
	$heading_h4_font_color_hex = orion_get_theme_option_css('h4_font_color', '#000' );
	$heading_h4_font_color_opacity = orion_get_theme_option_css('h4_opacity', '.8' );	
	$heading_h4_font_color = orion_hextorgba($heading_h4_font_color_hex, $heading_h4_font_color_opacity );
	$heading_h5_font_color_hex = orion_get_theme_option_css('h5_font_color', '#000');
	$heading_h5_font_color_opacity = orion_get_theme_option_css('h5_opacity', '.8' );
	$heading_h5_font_color = orion_hextorgba($heading_h5_font_color_hex, $heading_h5_font_color_opacity );
	$heading_h6_font_color_hex = orion_get_theme_option_css('h6_font_color', '#000' );
	$heading_h6_font_color_opacity = orion_get_theme_option_css('h6_opacity', '.8' );
	$heading_h6_font_color = orion_hextorgba($heading_h6_font_color_hex, $heading_h6_font_color_opacity );

	$heading_h1_font_size = orion_get_theme_option_css(array('h1-font','font-size'), '45');
	$heading_h1_font_size_mobile = ceil(intval($heading_h1_font_size * .8)) . 'px';

?>
<?php /* resize H1 for mobile*/ ?>
@media (max-width: 767px) {
	body h1, body .h1 {
		font-size: <?php echo esc_attr($heading_h1_font_size_mobile);?>;
	}
}


h1, .h1, h1 > a:not(:hover), .h1 > a:not(:hover) {
	color: <?php echo esc_attr($heading_h1_font_color);?>;
}
h2, .h2, h2 > a:not(:hover), .h2 > a:not(:hover) {
	color: <?php echo esc_attr($heading_h2_font_color);?>;
}
h3, .h3, h3 > a:not(:hover), .h3 > a:not(:hover) {
	color: <?php echo esc_attr($heading_h3_font_color);?>;
}
h4, .h4 {
	color: <?php echo esc_attr($heading_h4_font_color);?>;
}
h5, .h5 {
	color: <?php echo esc_attr($heading_h5_font_color);?>;
}
h6, .h6 {
	color: <?php echo esc_attr($heading_h6_font_color);?>;
}

<?php // light btn Hover ?>
.text-light button.btn-empty:hover, .text-light .btn.btn-empty:hover, .text-light input.btn-empty[type="submit"]:hover, .text-dark .text-light button.btn-empty:hover, .text-dark .text-light .btn.btn-empty:hover, .text-dark .text-light input.btn-empty[type="submit"]:hover,
.text-light input.search-submit[type="submit"]:hover, .text-light input:not(.btn)[type="submit"]:hover

{
  color: <?php echo esc_attr($heading_colors_light);?>!important; 
}

<?php // dark btn Hover ?>
.text-dark button.btn-empty:hover, .text-dark .btn.btn-empty:hover, .text-dark input.btn-empty[type="submit"]:hover, .text-light .text-dark button.btn-empty:hover, .text-light .text-dark .btn.btn-empty:hover, .text-light .text-dark input.btn-empty[type="submit"]:hover,
.text-dark input.search-submit[type="submit"]:hover, .text-dark input:not(.btn)[type="submit"]:hover
{
  color: <?php echo esc_attr($heading_colors_dark);?>!important; 
}

.text-dark h2.item-title, .text-dark h3.item-title, .text-dark h4.item-title, 
.text-light .text-dark h2.item-title, .text-light .text-dark h3.item-title, .text-light .text-dark h4.item-title,
.text-dark > h1, .text-dark > h2, .text-dark > h3, .text-dark > h4, .text-dark > h5, .text-dark > h6,
h1.text-dark, h2.text-dark, h3.text-dark, h4.text-dark, h5.text-dark, h6.text-dark {
	color: <?php echo esc_attr($heading_colors_dark);?>;
}

/* separator colors */

.separator-style-1.style-text-light:before {
	border-bottom: 2px solid <?php echo esc_attr(orion_hextorgba($heading_colors_light_color, '0.2'));?>; 
}

.separator-style-2.style-text-light:before {
  	background-color: <?php echo esc_attr($heading_colors_light);?>;
}

.separator-style-2 h1.text-light:before, .separator-style-2 h2.text-light:before, .separator-style-2 h3.text-light:before, .separator-style-2 h4.text-light:before, .separator-style-2 h5.text-light:before, .separator-style-2 h6.text-light:before, .separator-style-2.text-center h1.text-light:before, .separator-style-2.text-center h2.text-light:before, .separator-style-2.text-center h3.text-light:before, .separator-style-2.text-center h4.text-light:before, .separator-style-2.text-center h5.text-light:before, .separator-style-2.text-center h6.text-light:before, .separator-style-2.text-center h1.text-light:after, .separator-style-2.text-center h2.text-light:after, .separator-style-2.text-center h3.text-light:after, .separator-style-2.text-center h4.text-light:after, .separator-style-2.text-center h5.text-light:after, .separator-style-2.text-center h6.text-light:after {
  	border-bottom: 2px solid <?php echo esc_attr(orion_hextorgba($heading_colors_light_color, '0.2'));?>; 
}

/* tabs and accordions */

.panel-group.text-light .panel-title > a:after {
  color: <?php echo esc_attr($paragraph_colors_light);?>; 
}

.panel-group.default_bg.text-dark {
  background-color: <?php echo esc_attr($paragraph_colors_light);?>;
}

.panel-group.default_bg.text-light {
  	background-color: <?php echo esc_attr($heading_colors_dark);?>; 
}


/* MOBILE */
@media (max-width: 992px) {
	/* mobile text dark */
	.mobile-text-dark, .mobile-text-dark lead, .mobile-text-dark small {
		color: <?php echo esc_attr($paragraph_colors_dark);?>;
	}
	.mobile-text-dark a:not(.btn):not(:hover), .mobile-text-dark a > .item-title, .mobile-text-dark a > .item-title, .mobile-text-dark .widget .search-submit {
		color: <?php echo esc_attr($link_colors_dark_regular);?>;
	}

	.mobile-text-dark a:not(.btn):hover, .mobile-text-dark a:hover > .item-title, .text-dark a:hover > .item-title, .mobile-text-dark .widget .search-submit:hover {
		color: <?php echo esc_attr($link_colors_dark_hover);?>;
	}

	.mobile-text-dark a:not(.btn):focus, .mobile-text-dark a:not(.btn):not(.owl-nav-link):not([data-toggle]):focus {
		color: <?php echo esc_attr($link_colors_dark_active);?>;
	}

	/* mobile text-light */
	.mobile-text-light, .mobile-text-light lead, .mobile-text-light small {
		color: <?php echo esc_attr($paragraph_colors_light);?>;
	}

	.mobile-text-light a:not(.btn):not(.text-dark), .mobile-text-light a:not(.btn):not(.text-dark) > span, .mobile-text-light a > .item-title, .mobile-text-light a > .item-title, .mobile-text-light .widget .search-submit {
		color: <?php echo esc_attr($link_colors_light_regular);?>;
	}
	.mobile-text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):hover, .mobile-text-light a:hover > .item-title, .mobile-text-light .widget .search-submit:hover{
		color: <?php echo esc_attr($link_colors_light_hover);?>;
	}

	.mobile-text-light a:not(.btn):not(.text-dark):not(.owl-nav-link):not([data-toggle]):focus {
		color: <?php echo esc_attr($link_colors_light_active);?>;
	}
}

/* autofill */
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus
input:-webkit-autofill, 
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  border: 1px solid <?php echo esc_attr($color_1);?>;
  -webkit-text-fill-color: <?php echo esc_attr($color_1);?>;
  -webkit-box-shadow: 0 0 0px 1000px #fff inset;
  transition: background-color 5000s ease-in-out 0s;
}
<?php // end css
}
