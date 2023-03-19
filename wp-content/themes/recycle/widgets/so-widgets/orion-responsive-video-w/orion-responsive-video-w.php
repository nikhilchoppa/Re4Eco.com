<?php

/*
Widget Name: (OrionThemes) Responsive video
Description: Add Video from Youtube, Vimeo, ...
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_responsive_video_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_responsive_video_w',
			esc_html__('(OrionThemes) Responsive Video', 'recycle'),
			array(
				'description' => esc_html__('Add Video from Youtube or Vimeo.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-format-video',
			),
			array(

			),
			array(
			    'video_url' => array(
			        'type' => 'link',
			        'label' => esc_html__('Paste a link from Youtube or Vimeo:', 'recycle'),
			        'default' => '',
			    ),	    

				'lightbox_options' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Lightbox options' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'lightbox' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Open in lightbox', 'recycle' ),
							'default' => false,
						), 
					    'image' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Video image', 'recycle'  ),
					        'choose' => esc_html__( 'Choose image', 'recycle' ),
					        'update' => esc_html__( 'Upload image', 'recycle' ),
					        'fallback' => true
					    ),
					    'play_icon' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Display a play icon on the image?', 'recycle' ),
					        'default' => 'text-light',
					        'options' => array(
					        	'text-light' => esc_html__( 'Light', 'recycle' ),
					            'text-dark' => esc_html__( 'Dark', 'recycle' ),
					            'primary-color' => esc_html__( 'Main Theme Color', 'recycle' ),
					            'secondary-color' => esc_html__( 'Secondary Theme Color', 'recycle' ),
					            'tertiary-color' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
					            '' => esc_html__('No Icon', 'recycle'),
					        ),
					    ),					    
			        ),	
				),
			),			

			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_responsive_video_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_responsive_video_w', __FILE__, 'orion_responsive_video_w');