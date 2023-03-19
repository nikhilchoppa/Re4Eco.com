<?php
    if ( ! class_exists( 'Redux' ) ) {
        return;
    }

global $orion_options;
$color_1 = orion_get_option('main_theme_color', false, '#22AA86' );
$color_2 = orion_get_option('secondary_theme_color', false, '#9CC026' );
$color_3 = orion_get_option('color_3', false, '#44514E' );

// patterns
$patterns_dir = get_template_directory() . '/img/patterns/';
$patterns_uri =  get_template_directory_uri() . '/img/patterns/';
$files = array();
foreach (glob($patterns_dir . "*.png") as $file) {
  $files[] = $file;
}
$patterns = array();
foreach ($files as $key => $img) {
    $name = basename($img, '.png');
    $alt  = $name;
    $patterns[$patterns_uri . $name . '.png'] = array("alt" => $name, "img"=> $patterns_uri . $name . '.png');
}

$empty = "no_sidebar";
$sidebar_options[$empty] = "-- None --";
global $orion_options; 
$allsidebars = $GLOBALS['wp_registered_sidebars'];

foreach ($allsidebars as $key => $sidebar) {
    $s_name = $sidebar['name'];
    $s_slug = $sidebar['id'];
    $sidebar_options[$s_slug] = $s_name;
}

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Settings', 'recycle'),
    'icon'      => 'fa fa-toggle-on ',
    'fields'    => array(

        array(
            'id'   => 'info_general_color_settings',
            'type' => 'info',
            'title'    => esc_html__('Theme Colors', 'recycle'),
            'desc' => esc_html__('Use these settings to create a consistent style throughout your website.', 'recycle'),
        ),

        array(
            'id'       => 'main_theme_color',
            'type'     => 'color',
            'title'    => esc_html__('Main Theme color', 'recycle'),
            'subtitle' => esc_html__('Defines the most dominant color of your theme.', 'recycle'),
            'description'    => esc_html__('Automatically sets button and icon color, page title background and more.', 'recycle'),
            'transparent' => false,
            'output'      => array( 
                    'background-color' => 
                        '.primary-color-bg, 
                        .primary-hover-bg:hover, .primary-hover-bg:focus, 
                        .closebar, .hamburger-box,
                        .commentlist .bypostauthor > article, .paging-navigation .page-numbers .current, .paging-navigation .page-numbers a:hover,
                        .tagcloud a:hover, .tagcloud a:focus, .separator-style-2.style-text-dark:before, 
                        .separator-style-2.style-primary-color:before, 
                        .separator-style-2.style-text-default:before,
                        .panel-title .primary-hover:not(.collapsed), 
                        .owl-theme .owl-dots .owl-dot.active, .owl-theme .owl-dots .owl-dot:hover,
                        .overlay-primary .overlay, .overlay-hover-primary:hover .overlay,
                        .calendar_wrap table caption,
                        aside .widget .widget-title:before, .site-footer .widget .widget-title:before, .prefooter .widget .widget-title:before, .mega-sidebar .widget .widget-title:before,
                        mark, .mark, .page-numbers.p-numbers > li, .page-numbers.p-numbers > li:hover a,
                        .ui-slider-range, .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
                        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
                        .woocommerce-store-notice, p.demo_store
                        ',
    
                    'color' => 
                        '.primary-color, .text-light .primary-color, .text-dark .primary-color,
                        a.primary-color, .text-light a.primary-color:not(.btn), .text-dark a.primary-color,
                        .primary-hover:hover .hover-child, .primary-hover:focus .hover-child, .primary-hover:active, .primary-hover:hover:after, .primary-hover:active:after,
                        a.primary-hover:not(.btn):not([data-toggle]):hover, a.primary-hover:not(.btn):hover:after,
                        a.primary-hover:not(.btn):not([data-toggle]):focus,
                        .commentlist .comment article .content-wrap .meta-data .comment-reply-link i, 
                        .dropcap,
                        a:hover, a:active, a:not([class*="hover"]) .item-title:not([class*="hover"]):hover, a.item-title:hover,
                        .wpcf7-form .select:after, .wpcf7-form .name:after, .wpcf7-form .email:after, .wpcf7-form .date:after, .wpcf7-form .phone:after, .wpcf7-form .time:after, .wpcf7-form .company:after, .wpcf7-form .pass:after,
                       .woocommerce-form .select:after, .woocommerce-form .name:after, .woocommerce-form .email:after, .woocommerce-form .date:after, .woocommerce-form .phone:after, .woocommerce-form .time:after, .woocommerce-form .company:after, .woocommerce-form .pass:after,
                        .wpcf7-form label,
                        .team-header .departments a:not(:hover),
                        ol.ordered-list li:before,
                        .widget_archive > ul > li a:before, .widget_categories > ul > li a:before, .widget_pages > ul > li a:before, .widget_meta > ul > li a:before,
                        .list-star > li:before, .list-checklist > li:before, .list-arrow > li:before,
                        .active-c1 .nav-tabs > li.active > a, .active-c1 .nav-stacked > li.active > a, .active-c1 .active > a span,
                        .carousel-navigation.nav-tabs > li.active > a, .carousel-navigation.nav-tabs > li > a:hover, .carousel-navigation.nav-tabs > li > a:focus,
                        .active-c1 .panel-heading a:not(.collapsed), .active-c1 .panel-heading a:not(.collapsed):after , .active-c1 .panel-heading a:not(.collapsed) span,
                        .woocommerce .price del + ins, .product_meta .posted_in > a, .product_meta .tagged_as > a, .orion-select:after,
                        .selectwrapper:after,
                        .widget_nav_menu .current-menu-item > a, .widget_product_categories .current-cat > a, .woocommerce-info:before,
                        .widget_nav_menu .is-active > a, .woocommerce div.product .in-stock
                        ',

                    'border-color' => 
                        '.primary-border-color, 
                        .paging-navigation .page-numbers .current, 
                        input:focus, textarea:focus, .wpcf7-form input:focus, .wpcf7-form input:focus,
                        blockquote, .blockquote-reverse, input:not(.btn):not([type="radio"]):focus,
                        .woocommerce .site-content div.product .woocommerce-tabs ul.tabs li.active,
                        .form-control:focus, select:focus, 
                        .woocommerce form .form-row.woocommerce-validated .select2-container, .woocommerce form .form-row.woocommerce-validated input.input-text, .woocommerce form .form-row.woocommerce-validated select
                        ', 


                    'border-top-color' => '.commentlist .bypostauthor > article:after, .post.sticky .content-wrap',
            ),
            'default'  => '#22AA86',
            'compiler' => true,
        ),        

        array(
            'id'       => 'secondary_theme_color',
            'type'     => 'color',
            'title'    => esc_html__('Secondary Theme Color', 'recycle'),
            'subtitle' => esc_html__('Defines a secondary color for your theme.', 'recycle'),
            'description'    => esc_html__('An additional color option for buttons, overlays and widgets.', 'recycle'),
            'transparent' => false,
            'output'      => array( 
                    'background-color' => 
                        '.secondary-color-bg, 
                        .secondary-hover-bg:hover, .secondary-hover-bg:focus,
                        .panel-title .secondary-hover:not(.collapsed),
                        .separator-style-2.style-secondary-color:before, 
                        .panel-title .secondary-hover:not(.collapsed),
                        .overlay-secondary .overlay, .overlay-hover-secondary:hover .overlay
                        ',
    
                    'color' => 
                        '.secondary-color, 
                        .secondary-color, .text-light .secondary-color, .text-dark .secondary-color,
                        a.secondary-color, .text-light a.secondary-color:not(.btn), .text-dark a.secondary-color,
                        a.secondary-hover:not(.btn):not([data-toggle]):focus, .item-title.secondary-hover:hover,
                        .secondary-hover:hover .hover-child, secondary-hover:focus .hover-child,
                        a.secondary-hover:not(.btn):not([data-toggle]):hover, a.secondary-hover:not(.btn):hover:after,
                        .secondary-hover:active, .secondary-hover:hover:after, .secondary-hover:active:after,
                        .active-c2 .nav-tabs > li.active > a, .active-c2 .nav-stacked > li.active > a, .active-c2 .active > a span,
                        .active-c2 .panel-heading a:not(.collapsed), .active-c2 .panel-heading a:not(.collapsed):after , .active-c2 .panel-heading a:not(.collapsed) span
                        ',


                    'border-color' => '.secondary-border-color',
            ),

            'default'  => '#9CC026',
            'compiler' => true,
        ),  

        array(
            'id'       => 'color_3',
            'type'     => 'color',
            'title'    => esc_html__('Tertiary Theme Color', 'recycle'),
            'subtitle' => esc_html__('For best results select a dark color.', 'recycle'),
            'description'    => esc_html__('Automatically sets the background color of dark navigation and footer.', 'recycle'),
            'transparent' => false,
            'output'      => array( 
                    'background-color' => 
                        '.tertiary-color-bg,                     
                        .tertiary-hover-bg:hover, .tertiary-hover-bg:focus,
                        .panel-title .tertiary-hover:not(.collapsed),
                        .separator-style-2.style-tertiary-color:before, 
                        .panel-title .tertiary-hover:not(.collapsed),
                        .text-light .orion-cart-wrapper,
                        .overlay-tertiary .overlay, .overlay-hover-tertiary:hover .overlay,
                         .hamburger-box + .woocart',
                    'color' => 
                        '.tertiary-color, .text-light .tertiary-color, .text-dark .tertiary-color,
                        a.tertiary-color, .text-light a.tertiary-color:not(.btn), .text-dark a.tertiary-color,
                        .tertiary-hover:hover, .tertiary-hover:focus, .item-title.tertiary-hover:hover,
                        a.tertiary-hover:not(.btn):not([data-toggle]):focus, 
                        .tertiary-hover:hover .hover-child, .tertiary-hover:focus .hover-child, 
                        .tertiary-hover:active, .tertiary-hover:hover:after, .tertiary-hover:active:after,
                        a.tertiary-hover:not(.btn):not([data-toggle]):hover, a.tertiary-hover:not(.btn):hover:after,
                        .tertiary-color,
                        .active-c3 .nav-tabs > li.active > a, .active-c3 .nav-stacked > li.active > a, .active-c3 .active > a span,
                        .active-c3 .panel-heading a:not(.collapsed), .active-c3 .panel-heading a:not(.collapsed):after , .active-c3 .panel-heading a:not(.collapsed) span
                        ',
                    'border-color' => '.tertiary-border-color',
            ),

            'default'  => '#44514E',
            'compiler' => true,
        ),

        array(
            'id'       => 'site_background_color',
            'type'     => 'color',
            'title'    => esc_html__('Site content Background Color', 'recycle'),
            'subtitle' => esc_html__('Defines the background color of your pages.', 'recycle'),
            'output'      => array( 
                    'background-color' => 'body .site-content',
            ),
            'compiler' => true,
            'default'  => '#F2F4F4',
        ),

        array(
            'id'   => 'info_404_settings',
            'type' => 'info',
            'title'    => esc_html__('404 Page', 'recycle'),
        ),  
        array(
            'id'       => 'page_404',
            'type'     => 'select',
            'title'    => esc_html__('404 error page', 'recycle'), 
            'subtitle' => esc_html__('Create a custom 404 page and define it here', 'recycle'),
            'data'     => 'page',
        ),
        array(
            'id'   => 'info_totop_settings',
            'type' => 'info',
            'title'    => esc_html__('Back to top', 'recycle'),
        ),  
        array(
            'id'        => 'back_to_top',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display Back to top button', 'recycle'), 
            'default'   => '0',
        ),
        array(
            'id'   => 'info_onepage_settings',
            'type' => 'info',
            'title'    => esc_html__('One-Page Settings', 'recycle'),
        ),  
        array(
            'id'        => 'one_page',
            'type'      => 'checkbox',
            'title'     => esc_html__('Use recycle as One Page:', 'recycle'), 
            'subtitle'  => esc_html__('Improves navigation if you use recycle as onePage site', 'recycle'),
            'default'   => '0',
            'compiler' => true,
        ),        
        array(
            'id'   => 'info_singlepost_settings',
            'type' => 'info',
            'title'    => esc_html__('Commenting', 'recycle'),
        ),    
        array(
            'id'        => 'comments_posts',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display comments on posts?', 'recycle'), 
            'subtitle'  => esc_html__('Do you want to enable readers to comment your posts?', 'recycle'),
            'default'   => '1'// 1 = on | 0 = off
        ),    
        array(
            'id'        => 'comments_pages',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display comments on pages?', 'recycle'), 
            'subtitle'  => esc_html__('Do you want to enable readers to comment your pages?', 'recycle'),
            'default'   => '1'// 1 = on | 0 = off
        ),
        array(
            'id'   => 'info_swipebox_settings',
            'type' => 'info',
            'title'    => esc_html__('Swipebox', 'recycle'),
        ),
        array(
            'id'        => 'swipebox_bars_mobile',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display lightbox navigation on mobile devices', 'recycle'), 
            'default'   => '0'// 1 = on | 0 = off
        ),
        array(
            'id'   => 'info_css_minimize',
            'type' => 'info',
            'title'    => esc_html__('Minimize CSS', 'recycle'),
        ),         
        array(
            'id'        => 'minimize_css',
            'type'      => 'checkbox',
            'title'     => esc_html__('Minimize Theme Options generated CSS', 'recycle'), 
            'default'   => '1', // 1 = on | 0 = off
            'description' => esc_html__('Uncheck for development purpuses, or if you are experience any issues.', 'recycle'),
            'compiler' => true,            

        ),        
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Logo', 'recycle'),
    'icon'      => 'fa fa-leaf',
    'fields'    => array(

        array(
            'id'   => 'info_logo_settings',
            'type' => 'info',
            'title'    => esc_html__('Logo Upload', 'recycle'),
            'desc' => esc_html__('The theme will automatically change the logo to suit the background color of the header.', 'recycle'),
        ),

        array(
            'id'       => 'logo_upload_dark',
            'type'     => 'media', 
            'url'      => true,
            'title'    => esc_html__('Dark Logo', 'recycle'),
            'subtitle' => esc_html__('Will be displayed on light header backgrounds.', 'recycle'),
            'description' => esc_html__('Upload a .PNG image with transparent background.', 'recycle'),
            'default'  => array(
                'url' => ''
            ),
        ), 
        array(
            'id'       => 'logo_upload_light',
            'type'     => 'media', 
            'url'      => true,
            'title'    => esc_html__('Light Logo', 'recycle'),
            'subtitle' => esc_html__('Will be displayed on dark header backgrounds.', 'recycle'),
            'description' => esc_html__('Upload a .PNG image with transparent background.', 'recycle'),
            'default'  => array(
                'url' => ''
            ),
        ),
        array(
            'id'       => 'logo_upload_sticky',
            'type'     => 'media', 
            'url'      => true,
            'title'    => esc_html__('Sticky Logo', 'recycle'),
            'subtitle' => esc_html__('Logo for sticky header.', 'recycle'),
            'description' => esc_html__('Upload a .PNG image with transparent background.', 'recycle'),
            'default'  => array(
                'url' => ''
            ),
        ),     
        array(
            'id'   => 'info_textlogo_settings',
            'type' => 'info',
            'title'    => esc_html__('Text Based Logo', 'recycle'),
        ),
        array(
            'id'       => 'text_logo',
            'type'     => 'text',
            'title'    => esc_html__('Text based logo', 'recycle'),
            'subtitle' => esc_html__('Will only display if no Logo image is selected.', 'recycle'),
            'desc'     => esc_html__('Accepts HTML tags.', 'recycle'),
            'validate' => 'html',
            'default'  => 'Recycle',
        ),
        array(
            'id'   => 'info_logo_dimension',
            'type' => 'info',
            'title'    => esc_html__('Logo dimensions', 'recycle'),
        ),       
        array(
            'id'       => 'logo_max_dimensions',
            'type'     => 'dimensions',
            'title'    => __('Maximum Logo width and height', 'recycle'),
            'subtitle' => esc_html__('The size is set in pixels.', 'recycle'),
            'default'  => array(
                'Width'   => '300',
                'Height'  => '72',
            ),
            'units' => false,
            'compiler' => true, 
        ),          
    )
));

Redux::setSection( $opt_name, array(
    'id'       => 'text-styles',
    'title'     => esc_html__('Typography', 'recycle'),
    'icon'      => 'fa fa-font',
    'fields'    => array(
        
        array(
            'id'   => 'info_general_font_settings',
            'type' => 'info',
            'title'    => esc_html__('Fonts', 'recycle'),
            'desc' => esc_html__('Use these settings to create a consistent style throughout your website.', 'recycle'),
        ),
        array(
            'id'          => 'content_font',
            'type'        => 'typography', 
            'title'       => esc_html__('Content & Paragraphs Font Family', 'recycle'),
            'subtitle' => esc_html__('Defines the most dominant font of your theme.', 'recycle'),
            'font-backup' => false,
            'text-align' => false,
            'output'      => array('html, body, p, input:not(.btn), textarea, select, .wpcf7-form select, .wpcf7-form input:not(.btn), .font-1'),
            'units'       =>'px',
            'line-height' => false,
            'font-weight' => false,
            'color'       => false,
            'font-style'  => false,
            'font-size'   => false,
            'default'     => array( 
                'font-family' => 'Source Sans Pro', 
            ),
        ),
        array(
            'id'          => 'title_font',
            'type'        => 'typography', 
            'title'       => esc_html__('Titles & Headings Font Family', 'recycle'),
            'subtitle' => esc_html__('Defines the default font of headings and widget titles.', 'recycle'),
            'font-backup' => false,
            'text-align' => false,
            'output'      => array('h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a,h6 a, .panel-heading, .font-2, .team-header .departments a, .dropcap, .widget_recent_entries a,.h1,.h2,.h3,.h4,.h5,.h6'),
            'units'       =>'px',
            'line-height' => false,
            'font-weight' => false,
            'color'       => false,
            'font-style'  => false,
            'font-size'   => false,
            'default'     => array(
                'font-family' => 'Montserrat',
            ),
        ),
        array(
            'id'          => 'button_nav_font',
            'type'        => 'typography', 
            'title'       => esc_html__('Navigation & Buttons Links Font Family', 'recycle'),
            'subtitle' => esc_html__('Defines the default font of the main navigation, buttons, and similar elements.', 'recycle'),
            'font-backup' => false,
            'text-align' => false,
            'output'      => array('button, .button, .btn, .site-navigation .menu-item > a, .site-navigation li.menu-item > span, .breadcrumbs li a, .breadcrumbs li span, .so-widget-orion_mega_widget_topbar .widget-title, input, .page-numbers, .tagcloud, .meta, .post-navigation, .nav-item, .nav-tabs li a, .nav-stacked li a, .font-3, .wpcf7-form label, input[type="submit"], .widget_nav_menu ul li a, ol.ordered-list li:before, .widget_product_categories ul .cat-item > a'),
            'units'       =>'px',
            'line-height' => false,
            'font-weight' => false,
            'color'       => false,
            'font-style'  => false,
            'font-size'   => false,
            'default'     => array( 
                'font-family' => 'Montserrat', 
            ),
        ),
                array(
            'id'   => 'info_darktext_widgets',
            'type' => 'info',
            'title'    => esc_html__('Dark Text Color Settings', 'recycle'),
            'subtitle'    => esc_html__('Sets the colors of dark text and headings.', 'recycle'),
        ),
        array(
            'id'        => 'paragraph_colors_dark',
            'type'      => 'color',
            'title'     => esc_html__('Paragraph text color (dark)', 'recycle'),
            'transparent'   => false,
            'default'   => '#000',
            'compiler' => true,
        ),
        array(
            'id' => 'paragraph_colors_dark_opacity',
            'type' => 'slider',
            'title' => esc_html__('Paragraph Color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of the paragraph text.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .6,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'        => 'heading_colors_dark',
            'type'      => 'color',
            'title'     => esc_html__('Headings (dark)', 'recycle'),
            'transparent'   => false,
            'default'   => '#000',
            'compiler' => true,
        ),
        array(
            'id' => 'heading_colors_dark_opacity',
            'type' => 'slider',
            'title' => esc_html__('Heading Color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of headings.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'       => 'link_colors_dark',
            'type'     => 'link_color',
            'title'    => esc_html__('Link colors', 'recycle'),
            'subtitle' => esc_html__('General colors for links on the website', 'recycle'),
            'default'  => array(
                'regular'  => '#000',
            ),
            'compiler' => true,
        ),
        array(
            'id' => 'link_colors_dark_opacity',
            'type' => 'slider',
            'title' => esc_html__('Regular Link color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of links.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .7,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'        => 'pagetitle_colors_dark',
            'type'      => 'color',
            'title'     => esc_html__('Page Title (dark)', 'recycle'),
            'transparent'   => false,
            'default'   => '#000',
            'compiler' => true,
        ),
        array(
            'id' => 'pagetitle_colors_dark_opacity',
            'type' => 'slider',
            'title' => esc_html__('Page Title Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of headings.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .85,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'       => 'meta_colors_dark',
            'type'     => 'link_color',
            'title'    => esc_html__('Meta & Caption Text Colors (dark)', 'recycle'),
            'output'      => '',
            'active' => false,
            'default'  => array(
                'regular'  => '#000',
                'hover'  => '#000',
            ),
            'compiler' => true,
        ),
        array(
            'id' => 'meta_colors_dark_opacity',
            'type' => 'slider',
            'title' => esc_html__('Meta & Caption Text Opacity (dark)', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of meta & caption text.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => 0.7,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),

        //Light Text
        
        array(
            'id'   => 'info_lighttext_widgets',
            'type' => 'info',
            'title'    => esc_html__('Light Text Color Settings', 'recycle'),
            'subtitle'    => esc_html__('Sets the colors of light text and headings.', 'recycle'),
        ),
        array(
            'id'        => 'paragraph_colors_light',
            'type'      => 'color',
            'title'     => esc_html__('Paragraph text color (light)', 'recycle'),
            'transparent'   => false,
            'default'   => '#ffffff',
            'compiler' => true,
        ),
        array(
            'id' => 'paragraph_colors_light_opacity',
            'type' => 'slider',
            'title' => esc_html__('Paragraph Color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of light paragraph text.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'        => 'heading_colors_light',
            'type'      => 'color',
            'title'     => esc_html__('Headings (light)', 'recycle'), 
            'transparent'   => false,                   
            'default'   => '#ffffff',
            'compiler' => true,
        ),
        array(
            'id' => 'heading_colors_light_opacity',
            'type' => 'slider',
            'title' => esc_html__('Heading Color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of headings.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .95,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'       => 'link_colors_light',
            'type'     => 'link_color',
            'title'    => esc_html__('Link colors (light)', 'recycle'),
            'output'      => '',
            'default'  => array(
                'regular'  => '#ffffff',
                'hover'  => '#ffffff',
                'active'  => '#ffffff',
            ),
            'compiler' => true,
        ),
        array(
            'id' => 'link_colors_light_opacity',
            'type' => 'slider',
            'title' => esc_html__('Regular Link color Opacity', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of light links.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => 0.9,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'        => 'pagetitle_colors_light',
            'type'      => 'color',
            'title'     => esc_html__('Page Title (light)', 'recycle'),
            'transparent'   => false,
            'default'   => '#fff',
            'compiler' => true,
        ),
        array(
            'id' => 'pagetitle_colors_light_opacity',
            'type' => 'slider',
            'title' => esc_html__('Page Title Opacity (light)', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of headings.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .95,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'       => 'meta_colors_light',
            'type'     => 'link_color',
            'title'    => esc_html__('Meta & Caption Text Colors (light)', 'recycle'),
            'output'      => '',
            'active'    => false,
            'default'  => array(
                'regular'  => '#ffffff',
                'hover'  => '#ffffff',
            ),
            'compiler' => true,
        ),
        array(
            'id' => 'meta_colors_light_opacity',
            'type' => 'slider',
            'title' => esc_html__('Meta & Caption Text Opacity (light)', 'recycle'),
            'subtitle' => esc_html__('Set the opacithy of light links.', 'rrecycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => 0.7,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),               
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Body', 'recycle'),
    'subsection' => true,
    'fields'    => array(
        array(
            'id'   => 'info_bodytypo_settings',
            'type' => 'info',
            'title'    => esc_html__('Body Text', 'recycle'),
        ),
        array(
            'id'       => 'body-font',
            'type'     => 'typography',
            'title'    => esc_html__('Body font', 'recycle'),
            'subtitle' => esc_html__('Defines styles for paragraphs.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('html, body'),
            'default' => array(
                'font-size' => '14px',
                'line-height' => '24px',
                'font-family' => 'Source Sans Pro',
                'font-weight' => '400'
                )
        ),
        array(
            'id'       => 'lead-font',
            'type'     => 'typography',
            'title'    => esc_html__('Lead Text', 'recycle'),
            'subtitle' => esc_html__('Defines styles for lead text.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('.lead'),
            'default' => array(
                'font-size' => '21px',
                'line-height' => '30px',
                'font-family' => 'Source Sans Pro',
                'font-weight' => '400'
                )
        ),
        array(
            'id'       => 'blockquote-font',
            'type'     => 'typography',
            'title'    => esc_html__('Blockquotes', 'recycle'),
            'subtitle' => esc_html__('Defines styles for blockquotes.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('blockquote'),
            'default' => array(
                'font-size' => '21px',
                'line-height' => '30px',
                'font-family' => 'Source Sans Pro',
                'font-weight' => '400',
                'font-style' => 'italic',
                )
        ),            
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Headings', 'recycle'),
    'subsection' => true,
    'fields'    => array(
        array(
            'id'   => 'info_h1_settings',
            'type' => 'info',
            'title'    => esc_html__('H1 Heading Style', 'recycle'),
        ),   
        array(
            'id'       => 'h1-font',
            'type'     => 'typography',
            'title'    => esc_html__('H1 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H1 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h1, .h1'),
            'default' => array(
                'font-size' => '45px',
                'line-height' => '48px',
            ),
            'compiler' => true,
        ),

        array(
            'id'       => 'h1_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H1 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),   

        array(
            'id' => 'h1_opacity',
            'type' => 'slider',
            'title' => esc_html__('H1 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .6,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,          
        ),
        array(
            'id'   => 'info_h2_settings',
            'type' => 'info',
            'title'    => esc_html__('H2 Heading Style', 'recycle'),
        ), 
        array(
            'id'       => 'h2-font',
            'type'     => 'typography',
            'title'    => esc_html__('H2 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H2 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h2, .h2, h2 > a, .h2 > a'),
            'default' => array(
                'font-size' => '32px',
                'line-height' => '36px',
                )
        ),
        array(
            'id'       => 'h2_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H2 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),          
        array(
            'id' => 'h2_opacity',
            'type' => 'slider',
            'title' => esc_html__('H2 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_h3_settings',
            'type' => 'info',
            'title'    => esc_html__('H3 Heading Style', 'recycle'),
        ), 
        array(
            'id'       => 'h3-font',
            'type'     => 'typography',
            'title'    => esc_html__('H3 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H3 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h3, .h3, .h3 > a'),
            'default' => array(
                'font-size' => '24px',
                'line-height' => '30px',
            )
        ),
        array(
            'id'       => 'h3_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H3 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),

        array(
            'id' => 'h3_opacity',
            'type' => 'slider',
            'title' => esc_html__('H3 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,            
        ),
        array(
            'id'   => 'info_h4_settings',
            'type' => 'info',
            'title'    => esc_html__('H4 Heading Style', 'recycle'),
        ), 
        array(
            'id'       => 'h4-font',
            'type'     => 'typography',
            'title'    => esc_html__('H4 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H4 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h4, .h4, .h4 > a'),
            'default' => array(
                'font-size' => '20px',
                'line-height' => '24px',
                )
        ),
        array(
            'id'       => 'h4_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H4 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),        
        array(
            'id' => 'h4_opacity',
            'type' => 'slider',
            'title' => esc_html__('H4 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_h5_settings',
            'type' => 'info',
            'title'    => esc_html__('H5 Heading Style', 'recycle'),
        ), 
        array(
            'id'       => 'h5-font',
            'type'     => 'typography',
            'title'    => esc_html__('H5 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H5 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h5, .h5, .h5 > a'),
            'default' => array(
                'font-size' => '18px',
                'line-height' => '24px',
                )
        ),
        array(
            'id'       => 'h5_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H5 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),        
        array(
            'id' => 'h5_opacity',
            'type' => 'slider',
            'title' => esc_html__('H5 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_h6_settings',
            'type' => 'info',
            'title'    => esc_html__('H6 Heading Style', 'recycle'),
        ), 
        array(
            'id'       => 'h6-font',
            'type'     => 'typography',
            'title'    => esc_html__('H6 Style', 'recycle'),
            'subtitle' => esc_html__('Defines the style for H6 headings.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => true,
            'font-style' => true,
            'color' => true,
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'font-backup' => true,
            'color' => false,
            'output' => array('h6, .h6, .h6 > a, .rsswidget'),
            'default' => array(
                'font-size' => '16px',
                'line-height' => '24px',
            ),            
        ),
        array(
            'id'       => 'h6_font_color',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('H6 color', 'recycle'),
            'default'  => '#000',
            'compiler' => true,
        ),          
        array(
            'id' => 'h6_opacity',
            'type' => 'slider',
            'title' => esc_html__('H6 Color Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .8,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
       
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Layout', 'recycle'),
    'icon'      => 'fa fa-television',
    'fields'    => array(
        
        array(
            'id'   => 'info_general_layout_settings',
            'type' => 'info',
            'title'    => esc_html__('Website Layout Settings', 'recycle'),
            'subtitle'    => esc_html__('Define the general layout of your website.', 'recycle'),
        ),                 
        array(
            'id'       => 'boxed_fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Choose Layout', 'recycle'), 
            'default'  => '1',// 1 = on | 0 = off
            'on'       => 'Full Width',
            'off'       => 'Boxed',
            'compiler' => true
        ),
        array(
            'id'       => 'boxed_site_background_color',
            'type'     => 'color',
            'title'    => esc_html__('Page Background Color', 'recycle'),
            'subtitle'  => esc_html__('Defines the page background (body) color. ', 'recycle'),
            'transparent' => false,
            'output'    => array(
                'background' => 'body.boxed'
            ),
            'default'  => '#BEC8C6',
            'required' => array('boxed_fullwidth','equals','0'),
        ),
        array(
            'id'       => 'pattern_type',
            'type'     => 'switch',
            'title'    => esc_html__('Page Background Image', 'recycle'), 
            'default'  => '1',// 1 = on | 0 = off
            'on'       => 'Custom',
            'off'       => 'Pattern Library',
            'required' => array('boxed_fullwidth','equals','0'),
        ),

       array(
            'id'       => 'pattern',
            'type'     => 'image_select',
            'title'    => esc_html__('Choose Pattern', 'recycle'), 
            'options'  => $patterns,
            'default' => '',
            'output' => array(
                    'background-image' => 'body.boxed'
                ),
            'required' => array(
                array('boxed_fullwidth','equals','0'),
                array('pattern_type','equals','0'),
            ),
        ),
        array(
            'id'        => 'boxed_site_background',
            'type'     => 'background',
            'title'     => esc_html__('Upload Background Image', 'recycle'),
            'background-color' => false,                 
            'output'    => array(
                'background' => 'body.boxed'
            ),
            'required' => array(
                array('boxed_fullwidth','equals','0'),
                array('pattern_type','equals','1'),
            ),            
        ),             
        array(
            'id'        => 'boxed_site_width',
            'type'      => 'slider',
            'title'     => __('Site Content Width', 'recycle'),
            'subtitle'     => __('Set in pixels.', 'recycle'),
            'desc'      => __('Default: 1140px', 'recycle'),
            "default"   => 1350,
            "min"       => 600,
            "step"      => 1,
            "max"       => 1600,
            'display_value' => 'text',
            'required' => array('boxed_fullwidth','equals','0'),
            'compiler' => true,     
        ),
        array(
            'id'        => 'boxed_site_padding',
            'type'      => 'slider',
            'title'     => __('Site Content Padding', 'recycle'),
            'subtitle'     => __('Sets left and right padding.', 'recycle'),
            'desc'      => __('Default: 60px', 'recycle'),
            "default"   => 90,
            "min"       => 0,
            "step"      => 1,
            "max"       => 120,
            'display_value' => 'text',
            'required' => array('boxed_fullwidth','equals','0'),
            'compiler' => true,     
        ),
        array(
            'id'             => 'boxed_top_margin',
            'type'           => 'spacing',
            // 'output'         => array('.boxed-container'),
            'mode'           => 'margin',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Site Margin', 'recycle'),
            'subtitle'     => __('Sets top and bottom margin.', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'margin-top'     => '36px', 
                'margin-bottom'  => '36px', 
            ),
            'compiler' => true,  
            'required' => array('boxed_fullwidth','equals','0'),
        ),          
        array(
            'id'        => 'passepartout',
            'type'      => 'checkbox',
            'title'     => esc_html__('Passepartout', 'recycle'), 
            'subtitle'  => esc_html__('Enable this option to display a frame around your site. Works with full width layout.', 'recycle'),
            'default'   => '0', // 1 = on | 0 = off
            'required' => array(
                    array('boxed_fullwidth','equals','1'),                    
            )             
        ),
        array(
            'id'             => 'passepartout_size',
            'type'           => 'dimensions',
            'units'          => 'px',
            'title'          => esc_html__('Passpartue size', 'recycle'),
            'subtitle'  => esc_html__('The size is set in pixels.', 'recycle'),
            'units'    => false,
            'default'  => array(
                'width'   => '30', 
                'height'  => '30'
            ),
            'required' => array(
                    array('boxed_fullwidth','equals','1'), 
                    array('passepartout','equals','1')                   
            )       
        ),
        array(
            'id'        => 'passepartout_color',
            'required' => array('passepartout','equals','1'),
            'type'      => 'color',
            'title'     => esc_html__('Passepartout color', 'recycle'),                    
            'default'   => '#BEC8C6',
            'required' => array(
                    array('boxed_fullwidth','equals','1'), 
                    array('passepartout','equals','1')                   
            )              
        ),
        array(
            'id'   => 'info_pagesidebar_settings',
            'type' => 'info',
            'title'    => esc_html__('Single Page Layout', 'recycle'),
            'subtitle'    => esc_html__('Choose a default sidebar to be displayed on your pages. Settings can be overwritten on individual pages. Leave both fields empty for a full-width layout.', 'recycle'),
        ), 
        array(
            'id'        => 'page-sidebar-left-defauts',
            'type'     => 'select',
            'title'     => esc_html__('Left sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Will be displayed on single pages.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
         array(
            'id'        => 'page-sidebar-right-defauts',
            'type'     => 'select',
            'title'     => esc_html__('Right sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Will be displayed on single pages.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
        array(
            'id'   => 'info_pagespaciing_settings',
            'type' => 'info',
            'title'    => esc_html__('Page Spacing', 'recycle'),
        ), 
        array(
            'id'             => 'page_topbottom_spacing',
            'type'           => 'spacing',
            'output'         => array('.site-main'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Page spacing', 'recycle'),
            'subtitle'       => __('Sets the default top and bottom padding on pages and posts (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '60px', 
                'padding-bottom'  => '60px', 
            ),
            'compiler' => true,
        ), 
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Header', 'recycle'),
    'icon'      => 'fa fa-header',
    'fields'    => array(
        array(
            'id'   => 'info_header_layout_settings',
            'type' => 'info',
            'title'    => esc_html__('Header Layout', 'recycle'),
        ),
        array(
            'id'       => 'orion_header_type',
            'type'     => 'image_select',
            'title'    => esc_html__('Choose Header layout', 'recycle'), 
            'subtitle' => esc_html__('Choose a default header layout.', 'recycle'),
            'compiler' => true,
            'options'  => array(
                'classic'      => array(
                    'alt'   => 'Classic', 
                    'img'   => get_template_directory_uri().'/framework/admin/img/header-classic.png'
                ),
                'widgetsfluid'      => array(
                    'alt'   => 'Menu with widgets and fluid navigation bar', 
                    'img'   => get_template_directory_uri().'/framework/admin/img/header-widgets.png'
                ),                                                                          
            ),
            'default' => 'classic'    
        ),
        array(
            'id'       => 'header_transparency',
            'type'     => 'switch',
            'title'    => esc_html__('Use transparent header on all pages', 'recycle'), 
            'description' => 'Does not influence existing pages.',
            'default'  => '0',
            'on'       => 'On',
            'off'       => 'Off',
        ),        

        // CLASSIC HEADER
        
        array(
            'id'   => 'info_classic_header_settings',
            'type' => 'info',
            'title'    => esc_html__('Classic Header Settings', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','classic'),                  
            ) 
        ),
        array(
            'id'       => 'classic_header_background',
            'type'     => 'background',
            'title'    => esc_html__( 'Classic Header Background', 'recycle' ),
            'subtitle'    => esc_html__( 'Default colors are set in Main Navigation Settings.', 'recycle' ),
            'transparent' => false,
            'background-attachment' => false,
            'output'   => array( '.mainheader.header-classic:not(.stickymenu)' ),
            'required' => array(
                    array('orion_header_type','equals','classic'),                  
            ) 
        ),
        array(
            'id'        => 'header_hight_classic',
            'type'      => 'slider',
            'title'     => __('Classic Header Height', 'recycle'),
            'subtitle'  => __('Sets desktop header height.', 'recycle'),
            'desc'      => __('Min: 60px, Max: 180px.', 'recycle'),
            "default"   => 132,
            "min"       => 60,
            "step"      => 2,
            "max"       => 180,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','classic'),                  
            )                       
        ),
        array(
            'id'   => 'info_classic_header_logo_settings',
            'type' => 'info',
            'title'    => esc_html__('Classic Header Logo settings', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','classic'),                  
            ) 
        ),
        array(
            'id'       => 'classicheader_mobile_logo_color',
            'type'     => 'select',
            'title'    => esc_html__( 'Logo color on mobile devices', 'recycle' ),
            'default'  => 'mobile-text-dark',
            'options'  => array(
                'mobile-text-dark' => 'Dark Logo',
                'mobile-text-light' => 'Light Logo',
            ),
            'required' => array(
                    array('orion_header_type','equals','classic'),
            ),
        ),        
        array(
            'id'       => 'header_width_classic',
            'type'     => 'switch',
            'title'    => esc_html__('Full width header', 'recycle'), 
            'default'  => '0',
            'on'       => 'On',
            'off'       => 'Off',
            'required' => array(
                    array('orion_header_type','equals','classic'),                 
            )
        ),

        array(
            'id'        => 'logo_position_hight_classic',
            'type'      => 'slider',
            'title'     => __('Desktop Logo Positioning', 'recycle'),
            'subtitle'  => __('Defines logo vertical position for classic header.', 'recycle'),
            'desc'      => __('Default: 50%', 'recycle'),
            "default"   => 50,
            "min"       => 10,
            "step"      => 1,
            "max"       => 120,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','classic'),                  
            )                  
        ),             
        array(
            'id'   => 'info_classic_header_widgets',
            'type' => 'info',
            'title'    => esc_html__('Classic Header Widget Area Settings', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','classic'),                  
            ) 
        ),
        array(
            'id'       => 'classicheader_widgets_switch',
            'type'     => 'switch', 
            'title'    => __('Display Header Widget Area', 'recycle'),
            'subtitle' => __('Enable to display widgets in classic header.', 'recycle'),
            'default'  => false,
            'required' => array(
                array('orion_header_type','equals','classic'),
            ) 
        ),
        array(
            'id'       => 'classic_headerwidgets_background_color',
            'type'     => 'color',
            'title'    => esc_html__( 'Header Widget Area Background Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Defines the background color of classic header widget area.', 'recycle' ),
            // 'default'  => '',
            'output' =>  array( 'background' => '.header-classic .widget-section' ),
            'transparent' => false,
            'required' => array(
                    array('orion_header_type','equals','classic'),
                    array('classicheader_widgets_switch','equals',true),
            ) 
        ),
        array(
            'id'       => 'classicheader_widgets_colorstyle',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Widget Area Text Color - Desktop', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => 'text-dark',
            'options'  => array(
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
            'required' => array(
                    array('orion_header_type','equals','classic'),
                    array('classicheader_widgets_switch','equals',true),
            ),
            'compiler' => true,
        ),
        array(
            'id'       => 'classicheader_widgets_colorstyle_mobile',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Widgets Text Color - Mobile', 'recycle' ),
            'default'  => '',
            'options'  => array(
                '' => 'Default',
                'mobile-text-dark' => 'Dark Text',
                'mobile-text-light' => 'Light Text',
            ),
            'required' => array(
                    array('orion_header_type','equals','classic'),
                    array('classicheader_widgets_switch','equals',true),
            ),
            'compiler' => true, 
        ),         
        array(
            'id'             => 'classic_header_widgets_spacing',
            'type'           => 'spacing',
            'output'         => array('.header-classic .header-widgets'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Header Widget Area Padding', 'recycle'),
            'subtitle'       => __('Sets spacing for widgets in classic header (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '24px', 
                'padding-bottom'  => '12px', 
            ),
            'required' => array(
                    array('orion_header_type','equals','classic'),
                    array('classicheader_widgets_switch','equals',true),
            ) 
        ),

        // BOTTOM MENU HEADER

        array(
            'id'   => 'info_bottommenu_header_settings',
            'type' => 'info',
            'title'    => esc_html__('Header With Bottom Menu', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),
        array(
            'id'       => 'header_background',
            'type'     => 'background',
            'title'    => esc_html__( 'Header Background', 'recycle'),
            'subtitle'  => __('Defines background style for header with bottom menu.', 'recycle'),
            'transparent' => false,
            'background-attachment' => false,
            'default'  => array(
                'background-color' => '#ffffff',
            ),
            'output'   => array( '.header-with-widgets' ),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),
        array(
            'id'        => 'header_hight_with_widgets',
            'type'      => 'slider',
            'title'     => __('Header Height', 'recycle'),
            'subtitle'  => __('This defines desktop header height.', 'recycle'),
            'desc'      => __('Min: 60px, Max: 240px.', 'recycle'),
            "default"   => 96,
            "min"       => 60,
            "step"      => 2,
            "max"       => 240,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),                  
            )         
        ),
        array(
            'id'        => 'navbar_hight_with_widgets',
            'type'      => 'slider',
            'title'     => __('Main Navigation Height', 'recycle'),
            'desc'      => __('Min: 48px, Max: 180px.', 'recycle'),
            "default"   => 96,
            "min"       => 48,
            "step"      => 2,
            "max"       => 180,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),                  
            )         
        ),        
        array(
            'id'        => 'logo_position_hight_with_widgets',
            'type'      => 'slider',
            'title'     => __('Desktop Logo Positioning', 'recycle'),
            'subtitle'  => __('Defines logo vertical position for header with bottom menu.', 'recycle'),
            'desc'      => __('Default: 50%', 'recycle'),
            "default"   => 50,
            "min"       => 10,
            "step"      => 1,
            "max"       => 120,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),
        array(
            'id'       => 'header_width_with_widgets',
            'type'     => 'switch',
            'title'    => esc_html__('Full width header', 'recycle'), 
            'default'  => '0',
            'on'       => 'On',
            'off'       => 'Off',
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),                  
            )
        ),
        array(
            'id'   => 'info_widgetsfluid_header_logo_settings',
            'type' => 'info',
            'title'    => esc_html__('Header With Widgets Logo settings', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),
        array(
            'id'       => 'widgetsfluid_header_mobile_logo_color',
            'type'     => 'select',
            'title'    => esc_html__( 'Logo color on mobile devices', 'recycle' ),
            'default'  => 'mobile-text-dark',
            'options'  => array(
                'mobile-text-dark' => 'Dark Logo',
                'mobile-text-light' => 'Light Logo',
            ),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),
            ),
        ),
        array(
            'id'        => 'logo_position_hight_with_widgets',
            'type'      => 'slider',
            'title'     => __('Desktop Logo Positioning', 'recycle'),
            'subtitle'  => __('Defines logo vertical position for header with bottom menu.', 'recycle'),
            'desc'      => __('Default: 50%', 'recycle'),
            "default"   => 50,
            "min"       => 10,
            "step"      => 1,
            "max"       => 120,
            'display_value' => 'text',
            'compiler' => true,
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),       
        array(
            'id'   => 'info_bottommenu_header_widgets',
            'type' => 'info',
            'title'    => esc_html__('Header Widget Area Settings', 'recycle'),
            'subtitle'    => esc_html__('For header with bottom menu.', 'recycle'),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),                  
            ) 
        ),
        array(
            'id'       => 'widgetsfluid_widgets_switch',
            'type'     => 'switch', 
            'title'    => __('Display Header Widget Area', 'recycle'),
            'subtitle' => __('Enable to display widgets in classic header.', 'recycle'),
            'default'  => true,
            'required' => array(
                array('orion_header_type','equals','widgetsfluid'),
            ) 
        ),        
        array(
            'id'       => 'header_widgets_width',
            'type'     => 'select',
            'title'    => __('Header Widget Area Width', 'recycle'), 
            'subtitle' => __('Sets widget area width on desktop.', 'recycle'),
            'options'  => array(
                'col-md-6' => '1/2',
                'col-md-8' => '2/3',
                'col-md-9' => '3/4',
            ),
            'default'  => 'col-md-8',
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),
                    array('widgetsfluid_widgets_switch','equals',true),
            ) 
        ),
        array(
            'id'             => 'widgetsfluid_header_widgets_spacing',
            'type'           => 'spacing',
            'output'         => array('.header-with-widgets .header-widgets'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Header Widget Area Padding', 'recycle'),
            'subtitle'       => __('Widget top and bottom spacing (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '24px', 
                'padding-bottom'  => '12px', 
            ),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),
                    array('widgetsfluid_widgets_switch','equals',true),
            ) 
        ),
        array(
            'id'       => 'header_widgets_colorstyle',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Widgets Text Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => 'text-dark',
            'options'  => array(
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),
                    array('widgetsfluid_widgets_switch','equals',true),
            ),
            'compiler' => true,
        ),
        array(
            'id'       => 'header_widgets_colorstyle_mobile',
            'type'     => 'select',
            'title'    => esc_html__( 'Mobile Header Widgets Text Color', 'recycle' ),
            'default'  => '',
            'options'  => array(
                '' => 'Default',
                'mobile-text-dark' => 'Dark Text',
                'mobile-text-light' => 'Light Text',
            ),
            'required' => array(
                    array('orion_header_type','equals','widgetsfluid'),
                    array('widgetsfluid_widgets_switch','equals',true),
            ),
            'compiler' => true, 
        ),         
    )
)); 

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Top Bar', 'recycle'),
    'subsection' => true,
    'fields'    => array(

        array(
            'id'   => 'info_topbar_settings',
            'type' => 'info',
            'title'    => esc_html__('Top Bar', 'recycle'),
        ),
        array(
            'id'        => 'top_bar_onoff',
            'type'      => 'switch',
            'title'     => esc_html__('Display Top Bar', 'recycle'), 
            'subtitle'  => esc_html__('Place checkmark, if you want your site to have a top bar.', 'recycle'),
            'default'   => '1'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'topbar_background',
            'type'     => 'color',
            'title'    => esc_html__( 'Top Bar Background Color', 'recycle' ),
            'transparent' => false,
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
            'compiler' => true,
        ), 
        array(
            'id'       => 'topbar_text_color',
            'type'     => 'select',
            'title'    => esc_html__( 'Top Bar Text Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => 'text-light',
            'options'  => array(                
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),
        array(
            'id'       => 'topbar_divider_left',
            'type'     => 'checkbox',
            'title'    => esc_html__('Display Left Top Bar Dividers', 'recycle'), 
            'default'  => '1',// 1 = on | 0 = off
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),
        array(
            'id'       => 'topbar_divider_right',
            'type'     => 'checkbox',
            'title'    => esc_html__('Display Right Top Bar dividers', 'recycle'), 
            'default'  => '1',// 1 = on | 0 = off
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),        
        array(
            'id'        => 'topbar_border_color',
            'type'      => 'color_rgba',
            'title'     => esc_html__('Top Bar Border & Divider Color', 'recycle'),
            'default'   => array(
                'color'     => '#000',
                'alpha'     => 0.1
            ),
            'output'    => array(
                'border-color' => '.top-bar, .top-bar.left-right .add-dividers .section, .top-bar.equal .top-bar-wrap'
            ),
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),             
        ),  
        array(
            'id'       => 'is_top_bar_fluid',
            'type'     => 'checkbox',
            'title'    => esc_html__('Make top bar fullwidth', 'recycle'), 
            'subtitle' => esc_html__('If not set, it defaults to standard container.', 'recycle'),
            'default'  => '0',// 1 = on | 0 = off
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),
        array(
            'id'       => 'topbar_border',
            'type'     => 'checkbox',
            'title'    => esc_html__('Remove top bar border', 'recycle'), 
            'default'  => '0',// 1 = on | 0 = off
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),        
        array(
            'id'       => 'is_top_bar_always_open',
            'type'     => 'checkbox',
            'title'    => esc_html__('Make top bar always visible on mobile', 'recycle'), 
            'default'  => '0',// 1 = on | 0 = off
            'required' => array(
                array('top_bar_onoff','equals','1'),                    
            ),
        ),        
    )
)); 


Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Menu', 'recycle'),
    'icon'      => 'fa fa-navicon',
    'fields'    => array(
        array(
            'id'   => 'info_navstyle_settings',
            'type' => 'info',
            'title'    => esc_html__('Main Navigation Style', 'recycle'),
        ),
        array(
            'id'       => 'navigation_links_color_style',
            'type'     => 'select',
            'title'    => __('Navigation Color', 'recycle'), 
            'subtitle' => __('Defines the item colors of main navigation.', 'recycle'),
            'options'  => array(
                'nav-dark'  => 'Light text on dark background',
                'nav-light' => 'Dark text on light background',
            ),
            'default'  => 'nav-light',
        ), 
        array(
            'id'       => 'navigation_style',
            'type'     => 'select',
            'title'    => __('Style', 'recycle'),
            'compiler' => true,
            'options'  => array(
                'nav-style-3' => 'Simple',
                'nav-style-2' => 'Button',
                'nav-style-1' => 'Fill',
            ),
            'default'  => 'nav-style-3',
        ),
        array(
            'id'   => 'info_megamenu_settings',
            'type' => 'info',
            'title'    => esc_html__('Megamenu settings', 'recycle'),
        ),
        array(
            'id'       => 'orion_megamenu',
            'type'     => 'switch', 
            'title'    => __('Enable megamenu', 'recycle'),
            'subtitle' => __('Turn this on, to enable advanced menu features.', 'recycle'),
            'default'  => true,
        ),
        array(
            'id'       => 'mega_menu_background',
            'type'     => 'background',
            'output'   => array( 'header .main-nav-wrap .nav-menu li.orion-megamenu > .sub-menu' ),
            'title'    => esc_html__( 'MegaMenu background', 'recycle' ),
            'required' => array(
                    array('orion_megamenu','equals', true),                  
            ),
            'transparent' => false,
            'default'  => array(
                'background-color' => '#ffffff',
            ),            
            'compiler' => true, 
        ),
        array(
            'id'       => 'mega_menu_borders',
            'type'     => 'select',
            'title'    => __('MegaMenu link separator color', 'recycle'), 
            'options'  => array(
                'mega-light-borders'  => 'Light Menu Separators',
                'mega-dark-borders'  => 'Dark Menu Separators',
                'mega-no-borders'  => 'No Separators',
            ),
            'default'  => 'mega-light-borders',
            'required' => array(
                    array('orion_megamenu','equals', true),                  
            ),            
            'compiler' => true,         
        ),
        array(
            'id'   => 'info_navstypo_settings',
            'type' => 'info',
            'title'    => esc_html__('Main Navigation Fonts', 'recycle'),
        ), 
         array(
            'id'          => 'first-lvl-menu',
            'type'        => 'typography', 
            'title'       => esc_html__('1st Level Menu', 'recycle'), 
            'font-backup' => false,
            'text-align' => false,
            'line-height' => false, // btn nav type!
            'letter-spacing' => true,
            'text-transform' => true,
            'color' => false,
            'output'      => array('header .nav-menu > li.menu-item > a, header .nav-menu > ul > li > a'),
            'units'       =>'px',
            'default'     => array(
                'font-size'   => '14px', 
                'text-transform' => 'uppercase',
            ),
            'compiler' => true,
        ),
        array(
            'id'          => 'second-lvl-menu',
            'type'        => 'typography', 
            'title'       => esc_html__('Submenu', 'recycle'), 
            'font-backup' => false,
            'text-align' => false,
            'letter-spacing' => true,
            'text-transform' => true,
            'line-height' => false,
            'color' => false,
            'output'      => array('.nav-menu > li > ul.sub-menu .menu-item > a, .nav-menu > li > ul.sub-menu .menu-item > span'),
            'units'       =>'px',
            'default'     => array(
                'font-size'   => '12px', 
                'text-transform' => 'uppercase',
                'letter-spacing' => '1px',

            )
        ),
        array(
            'id'   => 'info_mobileheader_settings',
            'type' => 'info',
            'title'    => esc_html__('Mobile Settings', 'recycle'),
        ), 
        array(
            'id'       => 'mobile_menu_background',
            'type'     => 'color',
            'title'    => esc_html__( 'Mobile Menu Background', 'recycle' ),
            'transparent' => false,
            'compiler' => true,
        ),
        array(
            'id'       => 'mobile_menu_link_colors',
            'type'     => 'link_color',
            'title'    => esc_html__('Mobile menu item colors', 'recycle'),
            'subtitle' => esc_html__('Colors for links in mobile menu', 'recycle'),
            'hover'     => false,
            'compiler' => true,
        ),
        array(
            'id'   => 'info_navsearch_settings',
            'type' => 'info',
            'title'    => esc_html__('Search Option', 'recycle'),
        ), 
        array(
            'id'        => 'search_icon',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display search in main menu:', 'recycle'), 
            'subtitle'  => esc_html__('Check to display search in menu', 'recycle'),
            'description'  => esc_html__('Make sure you have selected a primary menu.', 'recycle'),
            'default'   => '0',
            'compiler' => true,
        ),
        array(
            'id'        => 'site_search_bg_color',
            'type'      => 'color',
            'title'     => esc_html__('Site search background', 'recycle'),
            'default'   => '#1a7f65',
            'output'    => array(
                'background-color' => '.site-search',
            ),
            'transparent' => false,
            'required' => array(
                array('search_icon','equals','1'),                    
            ),
        ),        
     
        array(
            'id'   => 'info_navigation_sticky_settings',
            'type' => 'info',
            'title'    => esc_html__('Sticky Menu', 'recycle'),
        ),
        array(
            'id'        => 'is_header_sticky',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display sticky header', 'recycle'), 
            'subtitle'  => esc_html__('Check if you want header to stay visible when scrolling.', 'recycle'),
            'default'   => '0'// 1 = on | 0 = off
        ),
        array(
            'id'       => 'sticky_header_background',
            'type'     => 'background',
            'output'   => array( '.stickymenu .nav-container, .stickymenu .orion-cart-wrapper' ),
            'title'    => esc_html__( 'Sticky Header background', 'recycle' ),
            'default'  => array(
                'background-color' => '#ffffff',
            ),
            'required' => array(
                    array('is_header_sticky','equals','1'),                  
            ) 
        ),
        array(
            'id'       => 'sticky_navigation_links_color_style',
            'type'     => 'select',
            'title'    => __('Navigation Colors', 'recycle'), 
            'subtitle' => __('Defines the item colors of sticky navigation.', 'recycle'),
            'options'  => array(
                ''  => 'Default',
                'nav-dark'  => 'Light text on dark background',
                'nav-light' => 'Dark text on light background',
            ),
            'default'  => '',
            'required' => array(
                    array('is_header_sticky','equals','1'),                  
            )             
        ),          
        array(
            'id'       => 'sticky_navigation_style',
            'type'     => 'select',
            'title'    => __('Navigation style', 'recycle'),
            // 'compiler' => true,
            'options'  => array(
                ''  => 'Default',
                'nav-style-1' => 'Fill',
                'nav-style-2' => 'Button',
            ),
            'default'  => '',
            'required' => array(
                    array('is_header_sticky','equals','1'),                  
            ),           
        ), 

    )
));

Redux::setSection( $opt_name, array(
    'id' => 'orion_cta_button',
    'title'  => esc_html__( 'Call to Action', 'recycle' ),
    'subsection' => true,
    'fields' => array(
    	        array(
            'id'   => 'info_cta_button_settings',
            'type' => 'info',
            'title'    => esc_html__('Call to Action Button', 'recycle'),
        ),               
        array(
            'id'        => 'display_header_button',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display button in main menu:', 'recycle'), 
            'subtitle'  => esc_html__('Check to display button in menu', 'recycle'),
            'description'  => esc_html__('A primary menu must be selected in Appearance -> Menus', 'recycle'),
            'default'   => '1',
            'compiler' => true,
        ),
        array(
            'id'       => 'button_link_url',
            'type'     => 'text',
            'title'    => __('Buttton link', 'recycle'),
            'subtitle' => __('Add Button link (url).', 'recycle'),
            'default'  => '#',
            'required' => array(
                array('display_header_button','equals',true),                    
                ),            
        ),
        array(
            'id'       => 'button_text',
            'type'     => 'text',
            'title'    => __('Buttton Text', 'recycle'),
            'subtitle' => __('Add Button Text', 'recycle'),
            'default'  => 'Button',
            'required' => array(
                array('display_header_button','equals',true),                    
                ),            
        ),
        array(
            'id'       => 'header_button_color',
            'type'     => 'select',
            'title'    => __('Button Color', 'recycle'), 
            'subtitle' => __('Set the button color.', 'recycle'),
            'options'  => array(
                '' => esc_html__( 'Default', 'recycle' ),
                'btn-c1' => esc_html__( 'Main Theme Color', 'recycle' ),
                'btn-c2' => esc_html__( 'Secondary Theme Color', 'recycle' ),
                'btn-c3' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
                'btn-blue' => esc_html__( 'Blue', 'recycle' ),
                'btn-green' => esc_html__( 'Green', 'recycle' ),
                'btn-pink' => esc_html__( 'Pink', 'recycle' ),
                'btn-yellow' => esc_html__( 'Yellow', 'recycle' ),
                'btn-red' => esc_html__( 'Red', 'recycle' ),
                'btn-orange' => esc_html__( 'Orange', 'recycle' ),
                'btn-black' => esc_html__( 'Black', 'recycle' ),
                'btn-white' => esc_html__( 'White', 'recycle' ),
            ),
            'default'  => 'btn-c2', 
            'required' => array(
                array('display_header_button','equals',true),                    
                ),
        ),
        array(
            'id'       => 'header_button_rounding',
            'type'     => 'select',
            'title'    => __('Button Rounding', 'recycle'), 

            'options' => array(
                '' => esc_html__( 'None', 'recycle' ),
                'btn-round-2' => esc_html__( 'Slightly Rounded', 'recycle' ),
                'btn-round' => esc_html__( 'Completely Rounded', 'recycle' ),
            ),            
            'default'  => '', 
            'required' => array(
                array('display_header_button','equals',true),                    
                ),
        ),
        array(
            'id'       => 'last_tab_size',
            'type'     => 'select',
            'title'    => __('Size', 'recycle'), 
            'subtitle' => __('Set the size of search and button in main navigation.', 'recycle'),
            'options'  => array(
                's36'  => 'Small',
                's48'  => 'Medium',
                's60' => 'Large',
            ),
            'default'  => 's36',
            'required' => array(
                array('display_header_button','equals',true),                    
                ),                     
        ),
    )
));

Redux::setSection( $opt_name, array(
    'id' => 'orion_nav_colors',
    'title'  => esc_html__( 'Navigation Colors', 'recycle' ),
    'desc'   => esc_html__( 'Customize the dark and light navigation. ', 'recycle' ),
    'subsection' => true,   
    'fields' => array(
    	array(
            'id'   => 'info_lightnavcolors_settings',
            'type' => 'info',
            'title'    => esc_html__('Light Navigation Colors', 'recycle'),
        ), 
    	array(
            'id'        => 'nav_menu_bg_color_nav_light',
            'type'      => 'color',
            'title'     => esc_html__('Navigation background', 'recycle'),
            'default'   => '',
            'output'    => array(
                'background-color' => 'header.site-header.nav-light .nav-container',
            ),
            'transparent' => false,
            'compiler' => true,      
        ),

        array(
            'id'       => 'first_lvl_menu_colors_nav_light',
            'type'     => 'link_color',
            'title'    => esc_html__('1st Level Text Colors', 'recycle'),
            'default'  => array(
                'regular'  => 'rgba(0,0,0,.8)', 
                // 'hover'    => $color_1,
                // 'active'   => 'rgba(0,0,0,.8)', 
            ),
            'compiler' => true,           
        ), 

        array(
            'id'       => 'first_lvl_menu_bg_nav_light',
            'type'     => 'link_color',
            'title'    => esc_html__('1st Level Text Background Colors', 'recycle'),
            'default'  => array(
                'active'   => 'rgba(34, 170, 134, 0.15)', 
            ),
            'compiler' => true,       
        ), 
        array(
            'id'       => 'submenu_colors_nav_light',
            'type'     => 'link_color',
            'title'    => esc_html__('Submenu Text Colors', 'recycle'),
            'default'  => array(
                'regular'  => '#ffffff', 
                // 'active'   => '#ffffff', 
            ),
            'compiler' => true,         
        ),
        array(
            'id'        => 'submenu_background_nav_light',
            'type'      => 'color_rgba',
            'title'    => esc_html__('Submenu Background Color', 'recycle'),
            'subtitle' => esc_html__('Pick a background color for the submenu.', 'recycle'),
            'default'   => array(
                'color'     => '#000',
                'alpha'     => 0.9
            ),            
            'compiler' => true,
        ),
        array(
            'id'        => 'submenu_border_nav_light',
            'type'      => 'color_rgba',
            'title'    => esc_html__('Submenu links border color (desktop)', 'recycle'),
            'options'       => array(
                'clickout_fires_change'     => true,
            ),            
            'compiler' => true,
            'default'   => array(
                'color'     => '#000',
                'alpha'     => 0.2
            ),
        ),
        array(
            'id'   => 'info_darknavcolors_settings',
            'type' => 'info',
            'title'    => esc_html__('Dark Navigation Colors', 'recycle'),
        ), 
        array(
            'id'       => 'nav_menu_bg_color_nav_dark',
            'type'     => 'color',
            'title'    => esc_html__('Navigation bar color', 'recycle'),
            'subtitle' => __('If none selected, tertiary theme color will be used', 'recycle'),
            'transparent' => false,
            'output'    => array(
                'background-color' => 'header.site-header.nav-dark .nav-container',
            ),
            'compiler' => true,          
        ), 
        array(
            'id'       => 'first_lvl_menu_colors_nav_dark',
            'type'     => 'link_color',
            'title'    => esc_html__('1st Level Text Colors', 'recycle'),
            'default'  => array(
                'regular'   => 'rgba(255, 255, 255, 0.8)', 
                'active'   => 'rgba(255, 255, 255, 1)',
                'hover'   => 'rgba(255, 255, 255, 1)', 
            ),       
            'compiler' => true,           
        ), 
        array(
            'id'       => 'first_lvl_menu_bg_nav_dark',
            'type'     => 'link_color',
            'title'    => esc_html__('1st Level Text Background Colors', 'recycle'),
            'default'  => array(
                'active'   => 'rgba(0, 0, 0, 0.15)',
                'hover'   => 'rgba(0, 0, 0, 0.05)', 
            ),
            'compiler' => true,
        ), 
        array(
            'id'       => 'submenu_colors_nav_dark',
            'type'     => 'link_color',
            'title'    => esc_html__('Submenu Text Colors', 'recycle'),
            'default'  => array(
                'regular'  => 'rgba(0,0,0,.8)', 
            ),
            'compiler' => true,          
        ),
        array(
            'id'        => 'submenu_background_nav_dark',
            'type'      => 'color_rgba',
            'title'    => esc_html__('Submenu Background Color', 'recycle'),
            'subtitle' => esc_html__('Pick a background color for the submenu.', 'recycle'),
            'default'   => array(
                'color'     => '#fff',
                'alpha'     => 0.95
            ),
            'compiler' => true,                     
        ),
        array(
            'id'        => 'submenu_border_nav_dark',
            'type'      => 'color_rgba',
            'title'    => esc_html__('Submenu links border color (desktop)', 'recycle'),
            'options'       => array(
                'clickout_fires_change'     => true,
            ),
            'default'   => array(
                'color'     => '#000',
                'alpha'     => 0.1
            ),            
            'compiler' => true,       
        ),
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Page Title', 'recycle'),
    'icon'      => 'el-icon-website',
    'fields'    => array(

        array(
            'id'   => 'info_pagetitle_settings',
            'type' => 'info',
            'title'    => esc_html__('Page Title Layout', 'recycle'),
        ),
        array(
            'id'       => 'post_heading_type',
            'type'     => 'image_select',
            'title'    => esc_html__('Choose Layout', 'recycle'), 
            'subtitle' => esc_html__('Choose a default page title layout for your website. Customize the style under individual sections.', 'recycle'),
            'options'  => array(
                    'classic'      => array(
                        'alt'   => 'classic', 
                        'img'   => get_template_directory_uri().'/framework/admin/img/heading-classic.png'
                    ),
                    'centered'      => array(
                        'alt'   => 'centered', 
                        'img'   => get_template_directory_uri().'/framework/admin/img/heading-centered.png'
                    ),
                    'left'      => array(
                        'alt'   => 'leftright', 
                        'img'   => get_template_directory_uri().'/framework/admin/img/heading-left.png'
                    ),
            ),
            'default' => 'classic'
        ),
        array(
            'id'        => 'title_single_post_onoff',
            'type'      => 'checkbox',
            'title'     => esc_html__('Enable Page Titles on posts?', 'recycle'), 
            'default'   => '0', // 1 = on | 0 = off
        ),
        array(
            'id'       => 'default_overlay',
            'type'     => 'select',
            'title'    => __( 'Default heading overlay', 'recycle' ),
            'subtitle'    => __( 'Set default overlay. You can override this setting on each page/post.' ),
            'default'  => 'classic',
            'options'  => array(
                'none' => esc_html__( 'None', 'recycle' ),
                'overlay-dark' => esc_html__( 'Dark Overlay', 'recycle' ),
                'overlay-light' => esc_html__( 'Light Overlay', 'recycle' ),
                'overlay-c1' => esc_html__( 'Main theme color', 'recycle' ),
                'overlay-c2' => esc_html__( 'Secondary theme color', 'recycle' ),
                'overlay-c3' => esc_html__( 'Tertiary theme color', 'recycle' ),
                'overlay-c2-c1' => esc_html__( 'Gradient 1', 'recycle' ),                  
                'overlay-c1-c2' => esc_html__( 'Gradient 2', 'recycle' ),
                'overlay-c1-t' => esc_html__( 'Primary to Transparent', 'recycle' ),
                'overlay-c2-t' => esc_html__( 'Secondary to Transparent', 'recycle' ),
                'overlay-c3-t' => esc_html__( 'Tertiary to Transparent', 'recycle' ),  
            ),
        ), 
    ),    
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Classic', 'recycle'),
    'subsection'      => true,
    'fields'    => array( 
        array(
            'id'   => 'info_classicheading_settings',
            'type' => 'info',
            'title'    => esc_html__('Classic Page Title Style', 'recycle'),
        ),
        array(
            'id'       => 'post-heading-background-classic',
            'type'     => 'background',
            'output'   => array( '.page-heading.heading-classic' ),
            'title'    => esc_html__( 'Default Page Title Background', 'recycle' ),
            'subtitle' => esc_html__( 'Defines style for classic page titles. You can customize this on individual pages and posts.', 'recycle' ),
            'default'  => array(
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position'=> "center center",
            ),
        ),
        array(
            'id'       => 'post-heading-padding-classic',
            'type'     => 'spacing',
            'mode'     => 'padding',
            'units'    => 'px',
            'output'   => array( '.page-heading.heading-classic' ),
            'title'    => esc_html__( 'Page Title Padding', 'recycle' ),
            'subtitle' => esc_html__( 'Set in pixels.', 'recycle' ),
            'left' => false,
            'right' => false,
                'default'        => array(
                'padding-top'     => '30px', 
                'padding-bottom'  => '30px', 
            ),               
        ),    
        array(
            'id'   => 'info_classic_pagetitle_font_settings',
            'type' => 'info',
            'title'    => esc_html__('Classic Page Title Typography', 'recycle'),
        ), 
        array(
            'id'          => 'post-heading-title-classic',
            'type'        => 'typography', 
            'title'       => esc_html__('Page Title Font', 'recycle'),
            'subtitle'       => esc_html__('Defines classic page title typography.', 'recycle'),  
            'font-backup' => false,
            'text-align' => false,
            'google'      => true,
            'color' => false,
            'output'      => array('.page-heading.heading-classic h1.page-title'),
            'units'       =>'px',
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'subsets' => true,  
            'default'     => array(
                'font-weight'  => '400', 
                'font-family' => 'Montserrat', 
                'font-size'   => '21px', 
                'line-height' => '24px',
                'letter-spacing' => '0',
                'text-transform' => 'none',
            ),
        ),
        array(
            'id'       => 'pagetitle_font_color_classic',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('Page Title Font Color (classic)', 'recycle'),
            'default'  => '#fff',
            'compiler' => true,
        ),          
        array(
            'id' => 'pagetitle_opacity_classic',
            'type' => 'slider',
            'title' => esc_html__('Page Title Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .9,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_breadcrumbs_settings_classic',
            'type' => 'info',
            'title'    => esc_html__('Breadcrumbs', 'recycle'),
        ), 
        array(
            'id'        => 'crumbs-onoff-classic',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display breadcrumbs on classic page titles?', 'recycle'), 
            'default'   => '1', // 1 = on | 0 = off
        ),
        array(
            'id'       => 'crumbs-font-classic',
            'type'     => 'typography',
            'title'    => esc_html__('Breadcrumbs Style', 'recycle'),
            'subtitle' => esc_html__('Defines breadcrumbs styles for classic page titles.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => false,
            'font-style' => true,
            'text-align' => false,
            'letter-spacing' => true,
            'output' => array('.page-heading.heading-classic .breadcrumbs, .page-heading.heading-classic .breadcrumbs ol li a, .page-heading.heading-classic .breadcrumbs ol li:not(:last-child):after, .page-heading.heading-classic .breadcrumbs ol li:after,.page-heading.heading-classic .breadcrumbs span'),
            'default' => array(
                'font-weight' => '400',
                'font-size' => '12px',
                'letter-spacing' => '1px',
                'color' => '#fff',
            ),
            'required' => array(
                    array('crumbs-onoff-classic','equals','1')                    
            ) 
        ), 
    ),                               
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Centered', 'recycle'),
    'subsection'      => true,
    'fields'    => array(
        array(
            'id'   => 'info_centerheading_settings',
            'type' => 'info',
            'title'    => esc_html__('Centered Page Title Style', 'recycle'),
        ),          
        array(
            'id'       => 'post-heading-background-centered',
            'type'     => 'background',
            'output'   => array( '.page-heading.heading-centered' ),
            'title'    => esc_html__( 'Default Page Title Background', 'recycle' ),
            'subtitle' => esc_html__( 'Defines style for centered page titles. You can customize this on individual pages and posts.', 'recycle' ),
            'default'  => array(
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position'=> "center center",
            ),
        ),  
        array(
            'id'       => 'post-heading-padding-centered',
            'type'     => 'spacing',
            'mode'     => 'padding',
            'units'    => 'px',
            'output'   => array( '.page-heading.heading-centered' ),
            'title'    => esc_html__( 'Page Title Padding', 'recycle' ),
            'subtitle' => esc_html__( 'Set in pixels.', 'recycle' ),
            'left' => false,
            'right' => false,
                'default'        => array(
                'padding-top'     => '72px', 
                'padding-bottom'  => '60px', 

            ),               
        ),
        array(
            'id'   => 'info_centered_pagetitle_font_settings',
            'type' => 'info',
            'title'    => esc_html__('Centered Page Title Typography', 'recycle'),
        ), 
                array(
            'id'          => 'post-heading-title-centered',
            'type'        => 'typography', 
            'title'       => esc_html__('Page Title Font', 'recycle'),
            'subtitle'       => esc_html__('Defines centered page title typography.', 'recycle'),  
            'font-backup' => false,
            'text-align' => false,
            'google'      => true,
            'color' => false,
            'output'      => array('.page-heading.heading-centered h1.page-title'),
            'units'       =>'px',
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'subsets' => true,  
            'default'     => array(
                'font-weight'  => '400', 
                'font-family' => 'Montserrat', 
                'font-size'   => '42px', 
                'line-height' => '48px',
                'letter-spacing' => '', 
                'text-transform' => 'capitalize',
            ),
        ),
        array(
            'id'       => 'pagetitle_font_color_centered',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('Page Title Font Color', 'recycle'),
            'default'  => '#fff',
            'compiler' => true,
        ),          
        array(
            'id' => 'pagetitle_opacity_centered',
            'type' => 'slider',
            'title' => esc_html__('Page Title Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .9,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_breadcrumbs_settings_centered',
            'type' => 'info',
            'title'    => esc_html__('Breadcrumbs', 'recycle'),
        ),  
        array(
            'id'        => 'crumbs-onoff-centered',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display breadcrumbs on centered page titles?', 'recycle'), 
            'default'   => '1', // 1 = on | 0 = off
        ),   
        array(
            'id'       => 'crumbs-font-centered',
            'type'     => 'typography',
            'title'    => esc_html__('Breadcrumbs Style', 'recycle'),
            'subtitle' => esc_html__('Defines breadcrumbs styles for centered page titles.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => false,
            'font-style' => true,
            'text-align' => false,
            'color' => true,
            'letter-spacing' => true,
            'output' => array('.page-heading.heading-centered .breadcrumbs, .page-heading.heading-centered .breadcrumbs ol li a, .page-heading.heading-centered .breadcrumbs ol li:not(:last-child):after,.page-heading.heading-centered .breadcrumbs ol li:after, .page-heading.heading-centered .breadcrumbs span'),
            'default' => array(
                'font-weight' => '400',
                'font-size' => '12px',
                'letter-spacing' => '1px',
                'color' => '#fff',
            ),
            'required' => array(
                    array('crumbs-onoff-centered','equals','1')                    
            ) 
        ), 
    ),                                     
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Left Aligned', 'recycle'),
    'subsection'      => true,
    'fields'    => array(
        array(
            'id'   => 'info_leftheading_settings',
            'type' => 'info',
            'title'    => esc_html__('Left Aligned Page Title Style', 'recycle'),
        ),         
        array(
            'id'       => 'post-heading-background-left',
            'type'     => 'background',
            'output'   => array( '.page-heading.heading-left' ),
            'title'    => esc_html__( 'Default Page Title Background', 'recycle' ),
            'subtitle' => esc_html__( 'You can customize this on individual pages and posts.', 'recycle' ),
            'default'  => array(
                'background-repeat' => 'no-repeat',
                'background-size' => 'cover',
                'background-position'=> "center center",
            ),
        ),       
        array(
            'id'       => 'post-heading-padding-left',
            'type'     => 'spacing',
            'mode'     => 'padding',
            'units'    => 'px',
            'output'   => array( '.page-heading.heading-left' ),
            'title'    => esc_html__( 'Page Title Padding ', 'recycle' ),
            'subtitle'       => esc_html__('Set in pixels.', 'recycle'), 
            'left' => false,
            'right' => false,
                'default'        => array(
                'padding-top'     => '72px', 
                'padding-bottom'  => '72px', 
            ),             
        ),
        array(
            'id'   => 'info_centered_pagetitle_font_settings',
            'type' => 'info',
            'title'    => esc_html__('Left Aligned Page Title Typography', 'recycle'),
        ), 
        array(
            'id'          => 'post-heading-title-left',
            'type'        => 'typography', 
            'title'       => esc_html__('Page Title Font', 'recycle'),
            'subtitle'       => esc_html__('Defines left aligned page title typography.', 'recycle'), 
            'font-backup' => false,
            'text-align' => false,
            'google'      => true,
            'color' => false,
            'output'      => array('.page-heading.heading-left h1.page-title'),
            'units'       =>'px',
            'letter-spacing' => true,
            'word-spacing' => true,
            'text-transform' => true,
            'subsets' => true,  
            'default'     => array(
                'font-weight'  => '400', 
                'font-family' => 'Montserrat', 
                'font-size'   => '42px', 
                'line-height' => '48px',
                'letter-spacing' => '', 
                'text-transform' => 'none',
            ),
        ),
        array(
            'id'       => 'pagetitle_font_color_leftaligned',
            'type'     => 'color',
            'transparent' => false,
            'title'    => esc_html__('Page Title Font Color', 'recycle'),
            'default'  => '#fff',
            'compiler' => true,
        ),          
        array(
            'id' => 'pagetitle_opacity_leftaligned',
            'type' => 'slider',
            'title' => esc_html__('Page Title Opacity', 'recycle'),
            'desc' => esc_html__('Min: 0.01, max: 1', 'recycle'),
            "default" => .9,
            "min" => .01,
            "step" => .01,
            "max" => 1,
            'resolution' => .01,
            'display_value' => 'text',
            'compiler' => true,
        ),
        array(
            'id'   => 'info_breadcrumbs_settings_leftaligned',
            'type' => 'info',
            'title'    => esc_html__('Breadcrumbs', 'recycle'),
        ),    
        array(
            'id'        => 'crumbs-onoff-left',
            'type'      => 'checkbox',
            'title'     => esc_html__('Display breadcrumbs on left aligned page titles?', 'recycle'), 
            'default'   => '1', // 1 = on | 0 = off 
        ),                                            
        array(
            'id'       => 'crumbs-font-left',
            'type'     => 'typography',
            'title'    => esc_html__('Breadcrumbs Style', 'recycle'),
            'subtitle' => esc_html__('Defines styles for breadcrumbs.', 'recycle'),
            'google' => true,
            'subsets' => true,
            'font-weight' => true,
            'font-size' => true,
            'line-height' => false,
            'font-style' => true,
            'text-align' => false,
            'color' => true,
            'letter-spacing' => true,
            'output' => array('.page-heading.heading-left .breadcrumbs, .page-heading.heading-left .breadcrumbs ol li a, .page-heading.heading-left .breadcrumbs ol li:not(:last-child):after,.page-heading.heading-left .breadcrumbs ol li:after, .page-heading.heading-left .breadcrumbs span'),
            'default' => array(
                'font-weight' => '400',
                'font-size' => '12px',
                'letter-spacing' => '1px',
                'color' => '#fff',
            ),
            'required' => array(
                    array('crumbs-onoff-left','equals','1')                    
            ) 
        ),         
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Blog', 'recycle'),
    'icon'      => 'fa fa-bold',
    'fields'    => array(
        array(
            'id'   => 'info_blogsettings_settings',
            'type' => 'info',
            'title'    => esc_html__('Blog Layout', 'recycle'),
        ), 
         array(
            'id'       => 'blog_layout',
            'type'     => 'select',
            'title'    => __( 'Default Blog Layout', 'recycle' ),
            'subtitle'    => __( 'Choose a default layout for blog, category and archive pages.' ),
            'default'  => 'classic',
            'options'  => array(
                'classic' => 'Classic',
                'classic-full' => 'Classic full content',
                'masonry-2' => '2 Columns Masonry',
                'masonry-3' => '3 Columns Masonry',
            ),
        ), 
        array(
            'id'        => 'archive_blog_sidebar_left_defaults',
            'type'     => 'select',
            'title'     => esc_html__('Left sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on blog and archive pages. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
        array(
            'id'        => 'archive_blog_sidebar_right_defaults',
            'type'     => 'select',
            'title'     => esc_html__('Right sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on blog and archive pages. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
            'default' => 'sidebar-default',
        ),
        array(
            'id'   => 'info_blogposts_bg',
            'type' => 'info',
            'title'    => esc_html__('Style', 'recycle'),
        ),
        array(
            'id'        => 'blog_content_bg',
            'type'      => 'color',
            'title'     => esc_html__('Post Content background color ', 'recycle'),
            'transparent'   => true,
            'default'   => '#ffffff',
            'compiler' => true,
        ),        
        array(
            'id'   => 'info_postmeta_settings',
            'type' => 'info',
            'title'    => esc_html__('Post Meta Settings', 'recycle'),
        ),
        array(
            'id'       => 'postmeta_settings',
            'type'     => 'checkbox',
            'mode'     => 'checkbox', // checkbox or text
            'title'    => __( 'Enable/disable post meta on blog pages', 'recycle' ),
            'options'  => array(
                '1' => 'Date',
                '2' => 'Post Author',
                '3' => 'Category',
                '4' => 'Comments',
            ),
            'default'  => array(
                '1' => 1,
                '2' => 1,
                '3' => 1,
                '4' => 0,
            )
        ),  
        array(
            'id'   => 'info_blogposts_settings',
            'type' => 'info',
            'title'    => esc_html__('Single Post Settings', 'recycle'),
        ),              
        array(
            'id'        => 'post-sidebar-left-defauts',
            'type'     => 'select',
            'title'     => esc_html__('Left sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on your posts. Settings can be overwritten on individual posts. Leave both fields empty for a full-width layout.', 'recycle'),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle'),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
         array(
            'id'        => 'post-sidebar-right-defauts',
            'type'     => 'select',
            'title'     => esc_html__('Right sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on your posts. Settings can be overwritten on individual posts. Leave both fields empty for a full-width layout.', 'recycle'),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle'),
            'default' => 'sidebar-default',
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
        array(
            'id'       => 'share-icons',
            'type'     => 'sortable',
            'mode'     => 'checkbox', // checkbox or text
            'title'    => __( 'Share Icons', 'recycle' ),
            'subtitle' => __( 'Which share icons do you want to display? You can reorder them, if you want.', 'recycle' ),
            'options'  => array(
                'facebook' => 'Facebook',
                'twitter' => 'Twitter',
                'google' => 'Google +',
            ),
            'default'  => array(
                'facebook' => true,
                'twitter' => true,
                'google' => true,
            )
        ),   
    )
));

Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Portfolio', 'recycle'),
    'icon'      => 'fa fa-picture-o',
    'fields'    => array(
        array(
            'id'   => 'info_portfolio_settings',
            'type' => 'info',
            'title'    => esc_html__('Portfolio Settings', 'recycle'),
        ),        
        array(
            'id'        => 'portfolio_sidebar_left_defaults',
            'type'     => 'select',
            'title'     => esc_html__('Left sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on portfolio pages. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
        array(
            'id'        => 'portfolio_sidebar_right_defaults',
            'type'     => 'select',
            'title'     => esc_html__('Right sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a default sidebar to be displayed on portfolio pages. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
            'default' => 'sidebar-default',
        ),
        array(
            'id'       => 'portfolio_number_columns',
            'title'    => esc_html__('Number of columns in a row', 'recycle'),
            'type'     => 'select',
            'options'  => array(
                'col-md-6' => '2',
                'col-md-4' => '3',
                'col-md-3' => '4',
            ),
            'default'  => 'col-md-4',
        ),        
    )
));

Redux::setSection( $opt_name, array(
    'id' => 'woocommerce',
    'title'  => esc_html__( 'Shop', 'recycle' ),
    'icon'   => 'fa fa-shopping-cart',
    'fields' => array(
    	array(
            'id'   => 'info_shop_settings',
            'type' => 'info',
            'title'    => esc_html__('Shop Settings', 'recycle'),
            'desc'   => esc_html__( 'Only applicable if WooCommerce is installed.', 'recycle' ),
        ),
        array(
            'id'       => 'woo_products_per_page',
            'type'     => 'text',
            'title'    => esc_html__('Numer of products per page ', 'recycle'),
            'desc'     => esc_html__('Accepts numbers.', 'recycle'),
            'validate' => 'numeric',
            'default'  => 12,
        ),
        array(
            'id'       => 'woo_product_columns',
            'title'    => esc_html__('Number of Products in a row', 'recycle'),
            'type'     => 'select',
            'default'  => 'col-lg-4 col-sm-6',
            'options'  => array(
                'col-lg-6' => '2 in row',
                'col-lg-4 col-sm-6' => '3 in row',
                'col-lg-3 col-sm-6' => '4 in row',
            ),
        ),
    	array(
            'id'   => 'info_shop_sidebars',
            'type' => 'info',
            'title'    => esc_html__('Shop Sidebar', 'recycle'),
            'desc'   => esc_html__( 'Only applicable if WooCommerce is installed.', 'recycle' ),
        ),
        array(
            'id'        => 'woo_sidebar_left',
            'type'     => 'select',
            'title'     => esc_html__('Left sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a sidebar to be displayed on a shop pages and product categories. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
        array(
            'id'        => 'woo_sidebar_right',
            'type'     => 'select',
            'title'     => esc_html__('Right sidebar', 'recycle'),
            'subtitle'       => esc_html__( 'Choose a sidebar to be displayed on a shop pages and product categories. Leave both fields empty for a full-width layout.', 'recycle' ),
            'desc'       => esc_html__( 'Leave blank for none.', 'recycle' ),
            'show_empty' => 'true',
            'data'  => 'sidebar',
        ),
    )
));

Redux::setSection( $opt_name, array(
    'id' => 'orion_shop_cart',
    'title'  => esc_html__( 'Cart Settings', 'recycle' ),
    'subsection' => true,
	'fields' => array(
	    array(
	        'id'   => 'info_minicart_settings',
	        'type' => 'info',
	        'title'    => esc_html__('MiniCart Settings', 'recycle'),
	        'desc'   => esc_html__( 'Only applicable if WooCommerce is installed.', 'recycle' ),
	    ),
	    array(
	        'id'        => 'woo_cart',
	        'type'      => 'checkbox',
	        'title'     => esc_html__('Display mini cart in main menu:', 'recycle'), 
	        'subtitle'  => esc_html__('WooCommerce must be installed, for this option to work', 'recycle'),
	        'default'   => '0',
	        'compiler' => true,
	    ),
	),        
));


Redux::setSection( $opt_name, array(
    'title'     => esc_html__('Footer', 'recycle'),
    'icon'      => 'el-icon-inbox',
    'fields'    => array(
        array(
            'id'   => 'info_footer_settings',
            'type' => 'info',
            'title'    => esc_html__('Footer Settings', 'recycle'),
        ),
        array(
            'id'       => 'uncoveringfooter_switch',
            'type'     => 'switch', 
            'title'    => __('Uncovering Footer', 'recycle'),
            'subtitle' => __('Makes footer gradually appear on scroll.', 'recycle'),
            'default'  => false,
        ),
        array(
            'id'       => 'mainfooter-sidebars',
            'type'     => 'select',
            'title'    => esc_html__( 'Footer Columns', 'recycle' ),
            'subtitle'    => __( 'Sets number of widget areas in footer.', 'recycle' ),
            'default'  => '4',
            'options'  => array(
                '1' => '1 column',
                '2' => '2 columns',
                '3' => '3 columns',
                '4' => '4 columns'
            ),
        ),
        array(
            'id'       => 'footer_text_colors',
            'type'     => 'select',
            'title'    => esc_html__( 'Footer Text Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => 'auto',
            'options'  => array(
                'auto' => 'Auto',                
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
        ),
        array(         
            'id'       => 'footer_background',
            'type'     => 'background',
            'title'    => esc_html__('Footer Background', 'recycle'), 
            'subtitle' => esc_html__('Defines the style of footer background.', 'recycle'),
            'transparent' => false,
            'background-attachment' => false,
            'output'         => array('.site-footer'),
        ),
        array(
            'id'             => 'footer_spacing',
            'type'           => 'spacing',
            'output'         => array('.site-footer .main-footer'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Footer Padding', 'recycle'),
            'subtitle'       => __('Sets spacing for footer widgets (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '60px', 
                'padding-bottom'  => '48px', 
            )
        ), 
        array(
            'id'   => 'info_prefooter_settings',
            'type' => 'info',
            'title'    => esc_html__('Prefooter Settings', 'recycle'),
        ),
        array(
            'id'       => 'prefooter_switch',
            'type'     => 'switch', 
            'title'    => __('Show Prefooter', 'recycle'),
            'subtitle' => __('Enable to show prefooter area.', 'recycle'),
            'default'  => false,
        ),
        array(
            'id'       => 'prefooter-sidebars',
            'type'     => 'select',
            'title'    => __( 'Prefooter Columns', 'recycle' ),
            'subtitle'    => __( 'Sets number of widget areas in prefooter.', 'recycle' ),
            'default'  => '2',
            'options'  => array(
                '1' => '1 column',
                '2' => '2 columns',
                '3' => '3 columns',
                '4' => '4 columns'
            ),
            'required' => array(
                array('prefooter_switch','equals','1'),                    
            ),
        ),      
        array(
            'id'       => 'prefooter_text_colors',
            'type'     => 'select',
            'title'    => esc_html__( 'Prefooter Text Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => '1',
            'options'  => array(
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
            'required' => array(
                array('prefooter_switch','equals','1'),                    
            ),
        ),
        array(         
            'id'       => 'prefooter_background',
            'type'     => 'background',
            'title'    => esc_html__('Prefooter Background', 'recycle'), 
            'subtitle' => esc_html__('Defines the style of prefooter background.', 'recycle'),
            'transparent' => false,
            'background-attachment' => false,
            'output'         => array('.prefooter'),
            'required' => array(
                array('prefooter_switch','equals','1'),                    
            ),
        ),
        array(
            'id'             => 'prefooter_spacing',
            'type'           => 'spacing',
            'output'         => array('.prefooter'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Prefooter Padding', 'recycle'),
            'subtitle'       => __('Sets spacing for widgets in prefooter (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '60px', 
                'padding-bottom'  => '60px', 
            ),
            'required' => array(
                array('prefooter_switch','equals','1'),                    
            ),
        ),
        array(
            'id'   => 'info_copyrightarea_settings',
            'type' => 'info',
            'title'    => esc_html__('Copyright Area', 'recycle'),
        ),
        array(
            'id'       => 'copyrightarea_switch',
            'type'     => 'switch', 
            'title'    => __('Show Copyright Area', 'recycle'),
            'subtitle' => __('Enable to show copyright area.', 'recycle'),
            'default'  => true,
        ),
        array(
            'id'       => 'copyrightfooter-sidebars',
            'type'     => 'select',
            'title'    => __( 'Copyright Area Columns', 'recycle' ),
            'subtitle'    => __( 'Sets number of widget areas in copyright footer.', 'recycle' ),
            'default'  => '2',
            'options'  => array(
                '1' => '1 column',
                '2' => '2 columns',
            ),
            'required' => array(
                array('copyrightarea_switch','equals','1'),                    
            ), 
        ),      
        array(
            'id'       => 'copyright_text_colors',
            'type'     => 'select',
            'title'    => esc_html__( 'Copyright Footer Text Color', 'recycle' ),
            'subtitle'    => esc_html__( 'Text style customization is available under the Typography section.', 'recycle' ),
            'default'  => 'auto',
            'options'  => array(
                'auto' => 'Auto',                
                'text-dark' => 'Dark Text',
                'text-light' => 'Light Text',
            ),
            'required' => array(
                array('copyrightarea_switch','equals','1'),                    
            ),
        ),
        array(         
            'id'       => 'copyright_background',
            'type'     => 'background',
            'title'    => esc_html__('Copyright Footer Background', 'recycle'), 
            'subtitle' => esc_html__('Defines the style of copyright footer background.', 'recycle'),
            'transparent' => false,
            'background-attachment' => false,
            'output'         => array('.copyright-footer'),
            'required' => array(
                array('copyrightarea_switch','equals','1'),                    
            ),
        ),
        array(
            'id'             => 'copyright_footer_spacing',
            'type'           => 'spacing',
            'output'         => array('.copyright-footer'),
            'mode'           => 'padding',
            'units'          => array('px'),
            'units_extended' => 'false',
            'title'          => __('Copyright Footer Padding', 'recycle'),
            'subtitle'       => __('Sets spacing for widgets in copyright area (in pixels).', 'recycle'),
            'left'          => false,
            'right'         => false,
            'display_units' => false,
            'default'            => array(
                'padding-top'     => '17px', 
                'padding-bottom'  => '17px', 
            ),
            'required' => array(
                array('copyrightarea_switch','equals','1'),                    
            ),
        ),
    )
));

Redux::setSection( $opt_name, array(
   'title'     => esc_html__('Sidebar Generator', 'recycle'),
    'icon'      => 'fa fa-columns',
    'fields'    => array(
        array(
            'id'   => 'info_sidebargenerator',
            'type' => 'info',
            'title'    => esc_html__('Create custom sidebars', 'recycle'),
        ),  
        array(
            'id'        => 'add-sidebars',
            'type'      => 'multi_text',
            'title'     => esc_html__('Add a sidebar', 'recycle'),
            'validate'  => 'not_empty',
            'show_empty' => 'false',
            'default' => array('Orion custom sidebar'),
        )        
    )   
) );


Redux::setSection( $opt_name, array(
    'id' => 'wbc_importer_section',
    'title'  => esc_html__( 'Demo Content', 'recycle' ),
    'desc'   => esc_html__( 'Make sure all required plugins are activated before importing demo content. Please disable WordPress Importer plugin if enabled.', 'recycle' ),
    'icon'   => 'el el-gift',
    'fields' => array(
        array(
            'id'   => 'wbc_demo_importer',
            'type' => 'wbc_importer'
            )
        )
    )
);

Redux::setSection( $opt_name, array(
    'id' => 'orion_custom_css',
    'title'  => esc_html__( 'Custom Css', 'recycle' ),
    'desc'   => esc_html__( 'Customize the style with the power of CSS. ', 'recycle' ),
    'icon'   => 'fa fa-code',
    'fields' => array(
        array(
            'id'       => 'orion_custom_css_editor',
            'type'     => 'ace_editor',
            'title'    => esc_html__('CSS Code', 'recycle'),
            'subtitle' => esc_html__('Paste your CSS code here.', 'recycle'),
            'mode'     => 'css',
            'theme'    => 'monokai',
            'default'  => "",
            'compiler' => true,
        ),
    )
));

?>