<?php

add_action( 'cmb2_admin_init', 'recycle_metaboxes' );
/**
 * Define the metabox and field configurations.
 */

function recycle_metaboxes() {
    global $orion_options;
    if(empty($orion_options)) {
        $orion_options = orion_get_orion_defaults();
    }    
    // Start with an underscore to hide fields from custom fields list
    $prefix = '_recycle_';

 
/*********************************** O.o ***********************************/
/*                               Post formats                              */ 
/***************************************************************************/

    $quote = new_cmb2_box( array(
        'id'            => 'recycle_post_format_quote',
        'title'         => esc_html__( 'Quote Post Format', 'recycle' ),
        'object_types'  => array( 'post' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );


    $status = new_cmb2_box( array(
        'id'            => 'recycle_post_format_status',
        'title'         => esc_html__( 'Status Post Format', 'recycle' ),
        'object_types'  => array( 'post' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );
    // Status text field
    $status->add_field( array(
          'name' => esc_html__('Status', 'recycle'),
          'desc' => '',
          'id'   => $prefix.'status',
          'type' => 'textarea_small',
        )
    );

    // Quote text field
    $quote->add_field( array(
          'name' => esc_html__('Quote', 'recycle'),
          'desc' => '',
          'id'   => $prefix.'quote',
          'type' => 'textarea_small',
        )
    );
    $quote->add_field( array(
          'name' => esc_html__('Source Name', 'recycle'),
          'desc' => '',
          'id'   => $prefix.'quote_source_name',
          'type' => 'text',
        )
    );

    $video = new_cmb2_box( array(
        'id'            => 'recycle_post_format_video',
        'title'         => esc_html__( 'Video Post Format', 'recycle' ),
        'object_types'  => array( 'post', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    $video->add_field( array(
        'name' => esc_html__( 'oEmbed', 'recycle' ),
        'desc' => esc_html__( 'Enter a youtube, Vimeo, or TED URL. Supports services listed at codex.wordpress.org/Embeds', 'recycle' ),
        'id'   => $prefix . 'video_embed',
        'type' => 'oembed',
        )
    );

    $link = new_cmb2_box( array(
        'id'            => 'recycle_post_format_link',
        'title'         => esc_html__( 'Link Post Format', 'recycle' ),
        'object_types'  => array( 'post', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );
    $link->add_field( array(
        'name' => esc_html__( 'link title', 'recycle' ),
        'desc' => esc_html__( 'Text displayed', 'recycle' ),
        'id'   => $prefix . 'link_title',
        'type' => 'text',
        )
    ); 
    $link->add_field( array(
        'name' => esc_html__( 'URL', 'recycle' ),
        'desc' => esc_html__( 'Paste a link', 'recycle' ),
        'id'   => $prefix . 'url',
        'type' => 'text_url',
        )
    );
    $link->add_field( array(
          'name' => esc_html__('Link description', 'recycle'),
          'desc' => '',
          'id'   => $prefix.'link_desc',
          'type' => 'textarea_small',
        )
    );    
    $audio = new_cmb2_box( array(
        'id'            => 'recycle_post_format_audio',
        'title'         => esc_html__( 'Audio Post Format', 'recycle' ),
        'object_types'  => array( 'post', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    $audio->add_field( array(
        'name' => esc_html__( 'oEmbed', 'recycle' ),
        'desc' => esc_html__( 'Enter a SoundCloud, Spotify, or similar URL. Supports services listed at http://codex.wordpress.org/Embeds.', 'recycle' ),
        'id'   => $prefix . 'audio_embed',
        'type' => 'oembed',
        )
    );   
    $audio->add_field( array(
        'name'         => esc_html__( 'Multiple Files', 'recycle' ),
        'desc'         => esc_html__( 'Upload or add multiple audio files. Accepts mp3, ogg, and wav formats', 'recycle' ),
        'id'           => $prefix . 'audio_file',
        'type'         => 'file_list',
        'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
    ) );

    // gallery
    $gallery = new_cmb2_box( array(
        'id'            => 'recycle_post_format_gallery',
        'title'         => esc_html__( 'Gallery Post Format', 'recycle' ),
        'object_types'  => array('post', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

   $gallery->add_field( array(
        'name' => esc_html__( 'Gallery', 'recycle' ),
        'desc' => '',
        'id'   => $prefix .'mutiple_img_upload',
        'type' => 'file_list',
        'object_types'  => array('orion_portfolio' ), // Post type
    ) );
    $gallery->add_field( array(
        'name'             => 'Display gallery images in header as:',
        'id'   => $prefix .'gallery_display',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'carousel',
        'options'          => array(
            'carousel'    => esc_html__( 'Carousel', 'recycle' ),
            'col-sm-12'   => esc_html__( '1 column', 'recycle' ),
            'col-sm-6'   => esc_html__( '2 column grid', 'recycle' ),
            'col-sm-4'   => esc_html__( '3 column grid', 'recycle' ),
            'col-sm-3'   => esc_html__( '4 column grid', 'recycle' ),
            'hide'   => esc_html__( 'Hide', 'recycle' ),
        )
    ) );

    $gallery->add_field( array(
        'name'             => esc_html__( 'Thumbnail size:', 'recycle' ),
        'id'   => $prefix .'gallery_img_size',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            '' => esc_html__( 'Default', 'recycle' ),
            'orion_square' => esc_html__( 'Square', 'recycle' ),
            'large' => esc_html__( 'Large', 'recycle' ),
            'medium' => esc_html__( 'Medium', 'recycle' ),
            'thumbnail' => esc_html__( 'Thumbnail', 'recycle' ),
            'orion_container_width' => esc_html__( 'Container width', 'recycle' ),
            'full' => esc_html__( 'Original size', 'recycle' ),
            'orion_carousel' => esc_html__( '3:2 ratio', 'recycle' ),
            'orion_tablet' => esc_html__( '750px width', 'recycle' ),
        )
    ) );

/*********************************** O.o ***********************************/
/*                            Header Settings                              */ 
/***************************************************************************/

    $header_settings = new_cmb2_box( array(
        'id'            => 'header_settings',
        'title'         => esc_html__( 'Header Settings', 'recycle' ),
        'object_types'  => array( 'post', 'page', 'team-member', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) ); 


    $default_transparent_header = orion_get_option('header_transparency', false);
    $header_settings->add_field( array( 
        'name' => esc_html__( 'Enable transparent header', 'recycle' ),
        'id'   => $prefix .'transparent_header',
        'type' => 'checkbox',
        'default' => $default_transparent_header,
    ) );
    
    $header_settings->add_field( array(
        'name'             => 'Header overlay',
        'id'   => $prefix .'header_overlay',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            ''    => esc_html__( 'None', 'recycle' ),
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
        )
    ) );    
    $header_settings->add_field( array(
        'name'             => 'Set header text color',
        'id'   => $prefix .'transparent_header_text_color',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            ''    => esc_html__( 'Default', 'recycle' ),
            'text-light'   => esc_html__( 'Light', 'recycle' ),
            'text-dark' => esc_html__( 'Dark', 'recycle' ),    
        )
    ) );
    $header_settings->add_field( array(
        'name'             => 'Mobile Logo color',
        'id'   => $prefix .'mobile_logo_color',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            ''    => esc_html__( 'Default', 'recycle' ),
            'mobile-text-light'   => esc_html__( 'Light Logo', 'recycle' ),
            'mobile-text-dark' => esc_html__( 'Dark Logo', 'recycle' ),    
        ),
        'desc'    => esc_html__( 'Default mobile logo color can be set in Theme Options', 'recycle' ),
    ) );
    
    $header_settings->add_field( array(
        'name'    => 'Header Button custom text',
        'desc'    => esc_html__( 'Header button text', 'recycle' ),
        'default' => '',
        'id'      => $prefix .'button_text',
        'type'    => 'text',
    ) );
    $header_settings->add_field( array(
        'name'    => 'Header Button custom link',
        'desc'    => esc_html__( 'Header button link', 'recycle' ),
        'default' => '',
        'id'      => $prefix .'button_link',
        'type'    => 'text',
    ) );     

/*********************************** O.o ***********************************/
/*                              Page Title                                 */ 
/***************************************************************************/

    if(orion_get_theme_option_css('title_single_post_onoff', '0' ) == '1') {
        $post_heading = new_cmb2_box( array(
            'id'            => 'post_heading',
            'title'         => esc_html__( 'Page Title Settings', 'recycle' ),
            'object_types'  => array( 'post', 'page', 'team-member', 'orion_portfolio' ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
        ) ); 
    } else {
        $post_heading = new_cmb2_box( array(
            'id'            => 'post_heading',
            'title'         => esc_html__( 'Page Title Settings', 'recycle' ),
            'object_types'  => array( 'page', 'team-member', 'orion_portfolio' ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
        ) );       
    }

    $post_heading->add_field( array(
        'name' => esc_html__( 'Hide Page title?', 'recycle' ),
        'id'   => $prefix .'hide_heading',
        'type' => 'checkbox',
    ) );

    $default_heading = orion_get_option('post_heading_type', false);
    $post_heading->add_field( array(
        'name'             => 'Page title layout',
        'id'   => $prefix .'heading_type',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $default_heading,
        'options'          => array(
            'classic'    => esc_html__( 'Classic', 'recycle' ),
            'centered'   => esc_html__( 'Centered', 'recycle' ),
            'left' => esc_html__( 'Left', 'recycle' ),    
        )
    ) );

    $post_heading->add_field( array(
        'name'             => 'Page title text color',
        'id'   => $prefix .'heading_text_color',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'text-default',
        'options'          => array(
            'text-default'    => esc_html__( 'Default color', 'recycle' ),
            'text-light'   => esc_html__( 'Light color', 'recycle' ),
            'text-dark' => esc_html__( 'Dark color', 'recycle' ),    
        )
    ) );

    $post_heading->add_field( array(
        'name'    => 'Top Padding',
        'desc'    => esc_html__( 'Value in px', 'recycle' ),
        'default' => '',
        'id'      => $prefix .'top_padding',
        'type'    => 'text_small',
    ) );

    $post_heading->add_field( array(
        'name'    => 'Bottom Padding',
        'desc'    => esc_html__( 'Value in px', 'recycle' ),
        'default' => '',
        'id'      => $prefix .'bottom_padding',
        'type'    => 'text_small',
    ) );     

/*********************************** O.o ***********************************/
/*                        Page Title Background                            */ 
/***************************************************************************/

    $post_title_background = new_cmb2_box( array(
        'id'            => 'post_title_background',
        'title'         => esc_html__( 'Page Title Background', 'recycle' ),
        'object_types'  => array( 'post', 'page', 'team-member', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) ); 


    $post_title_background->add_field( array(
        'name'    => 'Page title background image',
        'id'      => $prefix . 'heading_bg_image',
        'type'    => 'file',
        'options' => array(
            'url' => false, // Hide the text input for the url
        ),
        'text'    => array(
            'add_upload_file_text' => 'Add image' // Change upload button text. Default: "Add or Upload File"
        ),
    ) );
    $post_title_background->add_field( array(
        'name'    => 'Background image repeat',
        'id'   => $prefix .'heading_bg_img_repeat',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            'default'    => esc_html__( 'Theme options defaults', 'recycle' ),
            'bg-no-repeat'   => esc_html__( 'No repeat', 'recycle' ),
            'bg-repeat' => esc_html__( 'Repeat', 'recycle' ),    
        )
    ) );
    $post_title_background->add_field( array(
        'name'    => 'Background Image sizing',
        'id'   => $prefix .'heading_bg_img_sizing',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            'default'    => esc_html__( 'Theme options defaults', 'recycle' ),
            'bg-size-auto'   => esc_html__( 'Auto', 'recycle' ),
            'bg-cover'   => esc_html__( 'Cover', 'recycle' ),
            'bg-contain'   => esc_html__( 'Contain', 'recycle' ),
            'bg-100'   => esc_html__( 'Width 100%', 'recycle' ),
            'responsive-fit'   => esc_html__( 'Responsive Fit', 'recycle' ), 
        )
    ) );
    $post_title_background->add_field( array(
        'name'    => 'Background Image alignment',
        'id'   => $prefix .'heading_bg_img_align',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            'default'    => esc_html__( 'Theme options defaults', 'recycle' ),
            'bg-left-top'   => esc_html__( 'Left Top', 'recycle' ),
            'bg-center-top'   => esc_html__( 'Center Top', 'recycle' ),
            'bg-right-top'   => esc_html__( 'Right Top', 'recycle' ),
            'bg-left-center'   => esc_html__( 'Left Center', 'recycle' ),
            'bg-center-center'   => esc_html__( 'Center Center', 'recycle' ),
            'bg-right-center'   => esc_html__( 'Right Center', 'recycle' ),
            'bg-left-bottom'   => esc_html__( 'Left Bottom', 'recycle' ),
            'bg-center-bottom'   => esc_html__( 'Center Bottom', 'recycle' ),
            'bg-right-bottom'   => esc_html__( 'Right Bottom', 'recycle' ),
            'responsive-fit'   => esc_html__( 'Responsive Fit', 'recycle' ), 
        )
    ) );
    
    $post_title_background->add_field( array(
        'name'             => 'Background image behaviour',
        'id'   => $prefix .'orion_parallax',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'default',
        'options'          => array(
            'default' => esc_html__( 'Default', 'recycle' ),
            'bg-fixed' => esc_html__( 'Fixed', 'recycle' ),
            'vertical_up' => esc_html__( 'Parallax Top to bottom', 'recycle' ),
            'vertical_down' => esc_html__( 'Parallax Bottom to top', 'recycle' ),
            'horizontal_left' => esc_html__( 'Parallax Right to left', 'recycle' ),
            'horizontal_right' => esc_html__( 'Parallax Left to right', 'recycle' ),
        )
    ) );

    $post_title_background->add_field( array(
        'name'             => 'Background image overlay',
        'id'   => $prefix .'orion_overlay',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => 'default',
        'options'          => array(
            'default' => esc_html__( 'Default', 'recycle' ),
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
        )
    ) );

/*********************************** O.o ***********************************/
/*                             Sidebars Posts                              */ 
/***************************************************************************/
/* Sidebars (posts) */
    $post_sidebars = new_cmb2_box( array(
        'id'            => 'post_sidebars',
        'title'         => esc_html__( 'Sidebars', 'recycle' ),
        'object_types'  => array( 'post', 'team-member'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

/*get sidebars from wp_registered_sidebars*/
    $sidebar_options = array();
    $empty = "no_sidebar";
    $sidebar_options[$empty] = "-- None --";
    
    $allsidebars = $GLOBALS['wp_registered_sidebars'];

    foreach ($allsidebars as $key => $sidebar) {
        $s_name = $sidebar['name'];
        $s_slug = $sidebar['id'];
        $sidebar_options[$s_slug] = $s_name;
    }      

/*check if there are any defaults in theme options */
    if (isset($orion_options['post-sidebar-left-defauts']) && ($orion_options['post-sidebar-left-defauts'] != "")) {
        $default_left = $orion_options['post-sidebar-left-defauts'];
    } else {
        $default_left = array('no_sidebar');
    }

    if (isset($orion_options['post-sidebar-right-defauts']) && ($orion_options['post-sidebar-right-defauts'] != "")) {
        $default_right = $orion_options['post-sidebar-right-defauts'];
    } else {
        $default_right = array('no_sidebar');
    }

/* add sidebar metaboxes (posts) */
    $post_sidebars->add_field( array(
        'name'             => esc_html__( 'Left sidebar', 'recycle' ),
        'id'               => $prefix . 'post_sidebar_select_left',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $default_left,
        'options'          => $sidebar_options 
    ) );

    $post_sidebars->add_field( array(
        'name'             => esc_html__( 'Right sidebar', 'recycle' ),
        'id'               => $prefix . 'post_sidebar_select_right',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $default_right,
        'options'          => $sidebar_options 
    ) );          

/* Sidebars (pages) */
    $page_sidebars = new_cmb2_box( array(
        'id'            => 'pages_sidebars',
        'title'         => esc_html__( 'Sidebars', 'recycle' ),
        'object_types'  => array( 'page', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    if (isset($orion_options['page-sidebar-left-defauts']) && ($orion_options['page-sidebar-left-defauts'] != "")) {
        $page_default_left = $orion_options['page-sidebar-left-defauts'];
    } else {
        $page_default_left = array('no_sidebar');
    }

    if (isset($orion_options['page-sidebar-right-defauts']) && ($orion_options['page-sidebar-right-defauts'] != "")) {
        $page_default_right = $orion_options['page-sidebar-right-defauts'];
    } else {
        $page_default_right = array('no_sidebar');
    }

    $page_sidebars->add_field( array(
        'name'             => esc_html__( 'Left sidebar', 'recycle' ),
        'id'               => $prefix . 'page_sidebar_select_left',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $page_default_left,
        'options'          => $sidebar_options 
    ) );

    $page_sidebars->add_field( array(
        'name'             => esc_html__( 'Right sidebar', 'recycle' ),
        'id'               => $prefix . 'page_sidebar_select_right',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $page_default_right,
        'options'          => $sidebar_options 

    ) ); 
/*********************************** O.o ***********************************/
/*                             Portfolio sidebars                          */ 
/***************************************************************************/  
    $portfolio_sidebars = new_cmb2_box( array(
        'id'            => 'portfolio_sidebars',
        'title'         => esc_html__( 'Sidebars', 'recycle' ),
        'object_types'  => array( 'orion_portfolio'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    if (isset($orion_options['portfolio_sidebar_left_defaults']) && ($orion_options['portfolio_sidebar_left_defaults'] != "")) {
        $portfolio_default_left = $orion_options['portfolio_sidebar_left_defaults'];
    } else {
        $portfolio_default_left = array('no_sidebar');
    }

    if (isset($orion_options['portfolio_sidebar_right_defaults']) && ($orion_options['portfolio_sidebar_right_defaults'] != "")) {
        $portfolio_default_right = $orion_options['portfolio_sidebar_right_defaults'];
    } else {
        $portfolio_default_right = array('no_sidebar');
    }

    $portfolio_sidebars->add_field( array(
        'name'             => esc_html__( 'Left sidebar', 'recycle' ),
        'id'               => $prefix . 'portfolio_sidebar_select_left',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $portfolio_default_left,
        'options'          => $sidebar_options 
    ) );

    $portfolio_sidebars->add_field( array(
        'name'             => esc_html__( 'Right sidebar', 'recycle' ),
        'id'               => $prefix . 'portfolio_sidebar_select_right',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $portfolio_default_right,
        'options'          => $sidebar_options 

    ) );

/*********************************** O.o ***********************************/
/*                           Woo Product sidebars                          */ 
/***************************************************************************/  
    $portfolio_sidebars = new_cmb2_box( array(
        'id'            => 'woo_sidebars',
        'title'         => esc_html__( 'Sidebars', 'recycle' ),
        'object_types'  => array( 'product'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    if (isset($orion_options['woo_sidebar_left_defaults']) && ($orion_options['woo_sidebar_left_defaults'] != "")) {
        $woo_default_left = $orion_options['woo_sidebar_left_defaults'];
    } else {
        $woo_default_left = array('no_sidebar');
    }

    if (isset($orion_options['woo_sidebar_right_defaults']) && ($orion_options['woo_sidebar_right_defaults'] != "")) {
        $woo_default_right = $orion_options['woo_sidebar_right_defaults'];
    } else {
        $woo_default_right = array('no_sidebar');
    }

    $portfolio_sidebars->add_field( array(
        'name'             => esc_html__( 'Left sidebar', 'recycle' ),
        'id'               => $prefix . 'woo_sidebar_select_left',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $woo_default_left,
        'options'          => $sidebar_options 
    ) );

    $portfolio_sidebars->add_field( array(
        'name'             => esc_html__( 'Right sidebar', 'recycle' ),
        'id'               => $prefix . 'woo_sidebar_select_right',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => $woo_default_right,
        'options'          => $sidebar_options 

    ) );              
/*********************************** O.o ***********************************/
/*                             Other Widget areas                          */ 
/***************************************************************************/

    $sidebars_and_widget_areas = new_cmb2_box( array(
        'id'            => 'sidebars_and_widget_areas',
        'title'         => esc_html__( 'Widget areas', 'recycle' ),
        'object_types'  => array( 'post', 'page', 'team-member', 'orion_portfolio' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) ); 

    $sidebars_and_widget_areas->add_field( array(
        'name' => esc_html__( 'Hide the top bar?', 'recycle' ),
        'id'   => $prefix .'hide_top-bar',
        'type' => 'checkbox',
    ) );

    $sidebars_and_widget_areas->add_field( array(
        'name' => esc_html__( 'Hide header widget area?', 'recycle' ),
        'id'   => $prefix .'hide_header_widget',
        'type' => 'checkbox',
    ) );  
    $sidebars_and_widget_areas->add_field( array(
        'name' => esc_html__( 'Hide Prefooter widget area (if active)?', 'recycle' ),
        'id'   => $prefix .'hide_prefooter',
        'default' => false,
        'type' => 'checkbox',
    ) );   

/*********************************** O.o ***********************************/
/*                               Page Spacing                              */ 
/***************************************************************************/

/* post paddings */

    $post_paddings = new_cmb2_box( array(
        'id'            => 'post_paddings',
        'title'         => esc_html__( 'Page Spacing', 'recycle' ),
        'object_types'  => array( 'post', 'page', 'team-member' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ) );

    $post_paddings->add_field( array(
        'name' => esc_html__( 'Remove Top Spacing?', 'recycle' ),
        'id'   => $prefix .'remove_padding_top',
        'type' => 'checkbox',
    ) );

    $post_paddings->add_field( array(
        'name' => esc_html__( 'Remove Bottom Spacing?', 'recycle' ),
        'id'   => $prefix .'remove_padding_bottom',
        'type' => 'checkbox',
    ) );     

/*********************************** O.o ***********************************/
/*                               Team Members                              */ 
/***************************************************************************/

    $team_info = new_cmb2_box( array(
        'id'            => 'team_members_info',
        'title'         => esc_html__( 'Team Settings', 'recycle' ),
        'object_types'  => array( 'team-member', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ));
    $team_info->add_field( array(
        'name'    => esc_html__( 'Job position', 'recycle' ),
        'id'      => 'job_title',
        'type'    => 'text',
    ));        
    $team_info -> add_field( array(
        'name'    => esc_html__( 'Intro text', 'recycle' ),
        'id'      => 'short_about',
        'type'    => 'wysiwyg',
        'options' => array(),
    ) );

    $team_contact = new_cmb2_box( array(
        'id'            => 'team_members_contact_metabox',
        'title'         => esc_html__( 'Social info', 'recycle' ),
        'object_types'  => array( 'team-member', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ));

    $team_contact -> add_field( array(
        'id'          => 'member_social_icons',
        'type'        => 'group',
        'description' => esc_html__( 'Add social links', 'recycle' ),
        'repeatable'  => true, // use false if you want non-repeatable group
        'options'     => array(
            'group_title'   => __( 'Entry {#}', 'recycle' ), // since version 1.1.4, {#} gets replaced by row number
            'add_button'    => esc_html__( 'Add Another Entry', 'recycle' ),
            'remove_button' => esc_html__( 'Remove Entry', 'recycle' ),
            'sortable'      => true, // beta
            'closed'     => true, // true to have the groups closed by default
        ),
    ) );

    $team_contact->add_group_field( 'member_social_icons', array(
        'name'             => 'Add social icons',
        'id'               => 'social_icons',
        'type'             => 'select',
        'show_option_none' => false,
        'default'          => '',
        'options'          => array(
            'fa fa-linkedin'    => esc_html__( 'LinkedIn', 'recycle' ),
            'fa-google-plus'   => esc_html__( 'Google +', 'recycle' ),
            'fa-facebook' => esc_html__( 'Facebook', 'recycle' ),
            'fa-twitter'    => esc_html__( 'Twitter', 'recycle' ),
            'fa-youtube'   => esc_html__( 'Youtube', 'recycle' ),
            'fa-snapchat' => esc_html__( 'SnapChat', 'recycle' ),      
            'fa-envelope-o' => esc_html__( 'Email', 'recycle' ),      
        )
    ) );

    $team_contact->add_group_field( 'member_social_icons', array(
    'name' => esc_html__( 'Link to social profile', 'recycle' ),
    'id'   => 'social_links',
    'type' => 'text_url',
    ) );

/* static blocks */
    function get_sb_shortcode() {
        $shortcode = '[staticblock block="' . $_GET['post'].'"]';
        return $shortcode;
    }  
    if (isset($_GET['post'])) {
        $static_blocks = new_cmb2_box( array(
            'id'            => 'static_blocks_meta',
            'title'         => esc_html__( 'Static block shortcode', 'recycle' ),
            'object_types'  => array( 'static_blocks', ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => false, // Show field names on the left
        ));        
        $static_blocks->add_field( array(
            'name' => 'Copy shortcode',
            'desc' => get_sb_shortcode(),
            'type' => 'title',
            'id'   => 'static_block_title'
        ) );    
    }



}
