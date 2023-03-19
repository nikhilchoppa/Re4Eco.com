<?php
 
/*
Widget Name: (OrionThemes) Custom carousel
Description: Create Custom Carousel
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_custom_carousel_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_custom_carousel_w',
			esc_html__('(OrionThemes) Custom Carousel', 'recycle'),
			array(
				'description' => esc_html__('Create custom carousel.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-format-gallery',
			),
			array(

			),
			array(
				'slide_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Slide' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to edit', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='slide_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
		        		
					    'slide_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Title', 'recycle'),
					        'default' => ''
					    ),
					    'navigation_label' => array(
					        'type' => 'text',
					        'label' => esc_html__('Navigation label', 'recycle'),
					        'default' => ''
					    ),
						'subtitle' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Subtitle', 'recycle' ),
					        'rows' => 4
					    ),
					    'description' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Description', 'recycle' ),
					        'rows' => 4
					    ),
					    'btn_text' => array(
					        'type' => 'text',
					        'label' => esc_html__('Button Text', 'recycle'),
					        'default' => 'Read more',
					    ),					    
					    'url' => array(
					        'type' => 'link',
					        'label' => esc_html__('Destination URL', 'recycle'),
					        'default' => esc_html__('#', 'recycle'),
					    ),
					    'image' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Slide image', 'recycle'  ),
					        'choose' => esc_html__( 'Choose image', 'recycle' ),
					        'update' => esc_html__( 'Upload image', 'recycle' ),
					        'fallback' => true
					    ),						    				    
					),
		        ),
				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget Style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
				        'text_style' => array(
							'type' => 'select',
							'label' => esc_html__('Text color', 'recycle'),	
							'default' => 'text-default',
							'options' => array(
								'text-default' => esc_html__( 'Default', 'recycle' ),
								'text-light' => esc_html__( 'Light', 'recycle' ),
								'text-dark' => esc_html__( 'Dark', 'recycle' ),
							)		
				       	),
					    'btn_type' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Button Style', 'recycle' ),
					        'default' => '',
					        'options' => array(
					            'btn-flat' => esc_html__( 'Flat', 'recycle' ),
					            'btn-wire' => esc_html__( 'Wire', 'recycle' ),
					            'btn-empty' => esc_html__( 'Empty', 'recycle' ),
					        ),
					    ),
					    'button_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Button Color', 'recycle' ),
					        'default' => 'btn',
					        'options' => array(
					            'btn' => esc_html__( 'Default', 'recycle' ),
					            'btn btn-c1' => esc_html__( 'Main Theme Color', 'recycle' ),
					            'btn btn-c2' => esc_html__( 'Secondary Theme Color', 'recycle' ),
					            'btn btn-c3' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
					            'btn btn-blue' => esc_html__( 'Blue', 'recycle' ),
					            'btn btn-green' => esc_html__( 'Green', 'recycle' ),
					            'btn btn-pink' => esc_html__( 'Pink', 'recycle' ),
					            'btn btn-orange' => esc_html__( 'Orange', 'recycle' ),
					            'btn btn-black' => esc_html__( 'Black', 'recycle' ),
					            'btn btn-white' => esc_html__( 'White', 'recycle' ),
					        ),
					    ),					    
					    'btn_size' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Button Size', 'recycle' ),
					        'default' => 'btn-sm',
					        'options' => array(
					        	'btn-xs' => esc_html__( 'Tiny', 'recycle' ),
					            'btn-sm' => esc_html__( 'Small', 'recycle' ),
					            'btn-md' => esc_html__('Normal', 'recycle'),
					            'btn-lg' => esc_html__('Large', 'recycle'),
					        ),
					    ),
					    'btn_style' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Rounding', 'recycle' ),
							'default' => '',
					        'options' => array(
					        	'' => esc_html__( 'None', 'recycle' ),
					            'btn-round-2' => esc_html__( 'Slightly Rounded', 'recycle' ),
					            'btn-round' => esc_html__( 'Completely Rounded', 'recycle' ),
					        ),
					    ),    
					),
				),					
				'option_carousel' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Carousel' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'autoplay' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Enable autoplay', 'recycle' ),
							'default' => false,
						), 								
			        ),		
				),	    
			),
			plugin_dir_path(__FILE__)
		);
	}
    function get_template_name($instance) {
         return 'orion_custom_carousel_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_custom_carousel_w', __FILE__, 'orion_custom_carousel_w');