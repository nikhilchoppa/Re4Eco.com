<?php

/*
Widget Name: (OrionThemes) Image
Description: Add an image
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_image_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_image_w',
			esc_html__('(OrionThemes) Image', 'recycle'),
			array(
				'description' => esc_html__('Add an image.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-format-image',
			),
			array(

			),
			array(
				'image' => array (
					'type' => 'media',
					'label' => esc_html__( 'Add image', 'recycle' ),
					'library' => 'image',
					'fallback' => false,
				),				
			    'hovertext' => array(
			        'type' => 'textarea',
			        'label' => esc_html__( 'Hover description Text', 'recycle' ),
					'default' => esc_html__('', 'recycle'),
			    ),
			    'url' => array(
			        'type' => 'link',
			        'label' => esc_html__('Destination URL (optional)', 'recycle'),
			        'default' => esc_html__('', 'recycle'),
			    ),
				'onclick' => array(
					'type' => 'select',
					'label' => esc_html__( 'On click', 'recycle' ),
					'default' => 'nothing',
					'options' => array(
						'link' => esc_html__( 'Open a link', 'recycle' ),
						'lightbox' => esc_html__( 'Open image in lightbox', 'recycle' ),
						'nothing' => esc_html__( 'Do nothing', 'recycle' ),
					),
				),
				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Style & Layout' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'image_style' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image style', 'recycle' ),
							'default' => 'orion_carousel',
							'options' => array(
								'orion_portrait' => esc_html__( 'Portrait', 'recycle' ),
								'orion_circle' => esc_html__( 'Circle', 'recycle' ),
								'orion_square' => esc_html__( 'Square', 'recycle' ),
								'orion_carousel' => esc_html__( '3:2 ratio', 'recycle' ),
								'orion_tablet' => esc_html__( '750px width', 'recycle' ),
								'' => esc_html__( 'Original image ratio', 'recycle' ),
							),					
						),				        	
					    'text_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Hover text color', 'recycle' ),
					        'default' => 'text-light',
							'options' => array(
								'primary-color' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary-color' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary-color' => esc_html__( 'Tertiary theme color', 'recycle' ),	
								'text-dark' => esc_html__( 'Dark', 'recycle' ),	
								'text-light' => esc_html__( 'Light', 'recycle' ),
							),	
					    ),
						'image_overlay' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image overlay', 'recycle' ),
							'default' => 'overlay-none',
							'options' => array(
								'overlay-none' => esc_html__( 'None', 'recycle' ),
								'overlay-black' => esc_html__( 'Darken', 'recycle' ),	
								'overlay-white' => esc_html__( 'Lighten', 'recycle' ),
								'overlay-primary' => esc_html__( 'Main theme color', 'recycle' ),	
								'overlay-secondary' => esc_html__( 'Secondary theme color', 'recycle' ),	
								'overlay-tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),
								'overlay-greyscale' => esc_html__( 'Greyscale', 'recycle' ),
							),					
						),
						'image_overlay_hover' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image overlay on hover', 'recycle' ),
							'default' => 'overlay-none',
							'options' => array(
								'overlay-hover-none' => esc_html__( 'None', 'recycle' ),
								'overlay-hover-black' => esc_html__( 'Darken', 'recycle' ),	
								'overlay-hover-white' => esc_html__( 'Lighten', 'recycle' ),
								'overlay-hover-primary' => esc_html__( 'Main theme color', 'recycle' ),	
								'overlay-hover-secondary' => esc_html__( 'Secondary theme color', 'recycle' ),	
								'overlay-hover-tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),
								'overlay-hover-greyscale' => esc_html__( 'Greyscale', 'recycle' ),
							),					
						),					    
					),
				),		    		    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_image_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_image_w', __FILE__, 'orion_image_w');