<?php
/*
Widget Name: (OrionThemes) Testimonials
Description: Displays testimonials
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_testimonial_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_testimonial_w',
			esc_html__('(OrionThemes) Testimonials', 'recycle'),
			array(
				'description' => esc_html__('Display your testimonials in a carousel.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-format-quote',
			),
			array(
			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			        'default' => ''
			    ),	    
				'widget_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Testimonial' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a testimonial', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='item_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
					    'description' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Testimonial', 'recycle' ),
					        'rows' => 6,
					        'default' => 'Testimonial quote.'
					    ),
					    'item_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Company/Organization (optional)', 'recycle'),
					    ),
					    'name' => array(
					        'type' => 'text',
					        'label' => esc_html__('Name', 'recycle'),
					        'default' => 'Mr. Orion'
					    ),
						'image' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Upload Image (optional)', 'recycle'),
					        'choose' => esc_html__( 'Choose image', 'recycle'),
					        'update' => esc_html__( 'Set image', 'recycle'),
					        'library' => 'image',
					        'fallback' => true
					    ),
					),
		        ),
				'display_layout' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose Layout', 'recycle' ),
					'default' => 'carousel',
					'options' => array(
			            'carousel' => esc_html__( 'Carousel', 'recycle' ),
			            'grid' => esc_html__( 'Grid', 'recycle' ),
					)			            					
				),
		        'per_row' => array(
					'type' => 'select',
					'label' => esc_html__('Elements per Row', 'recycle'),	
				    'options' => array(
						'1'	=> '1',
				    	'2'	=> '2',
				    	'3'	=> '3',
		       		),
				    'default' => '1',		
		       	),
				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget Style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
			        	
						'text_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Text Color', 'recycle' ),
							'default' => 'text-default',
							'options' => array(
								'text-default' => esc_html__( 'Default', 'recycle' ),
								'text-light' => esc_html__( 'Light text', 'recycle' ),
								'text-dark' => esc_html__( 'Dark text', 'recycle' ),
							)
						),
						'bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Background Color', 'recycle' ),
					        'default' => ''
					    ),
					    'bg_opacy' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Background Opacity', 'recycle' ),
					        'default' => 100,
					        'min' => 1,
					        'max' => 100,
					        'integer' => true,
					    ),
						'text_size' => array(
							'type' => 'select',
							'label' => esc_html__( 'Text Size', 'recycle' ),
							'default' => '',
							'options' => array(
								'small' => esc_html__( 'Small', 'recycle' ),
								'' => esc_html__( 'Normal', 'recycle' ),
								'lead' => esc_html__( 'Large', 'recycle' ),
							)
						),
					    'border-radius' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Rounded Corners', 'recycle' ),
					        'default' => true
					    ),
					    'hide_image' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Hide Image', 'recycle' ),
					        'default' => false
					    ),
						'option_carousel' => array(
					        'type' => 'section',
					        'label' => esc_html__( 'Carousel Settings' , 'recycle' ),
					        'hide' => true,
					        'fields' => array(
								'navigation_carousel' => array(
									'type' => 'select',
									'label' => esc_html__( 'Navigation Style', 'recycle' ),
									'default' => 'dots',
									'options' => array(
										'dots' => esc_html__( 'Dots', 'recycle' ),
										'arrows_top' => esc_html__( 'Arrows on top', 'recycle' ),
										'arrows_bottom' => esc_html__( 'Arrows on bottom', 'recycle' ),
										'arrows_aside' => esc_html__( 'Arrows on side', 'recycle' ),
										'none' => esc_html__( 'None', 'recycle' ),
									),					
								),
								'display_mobile_nav' => array(		
									'type' => 'checkbox',		
									'label' => esc_html__( 'Display carousel navigation on mobile devices', 'recycle' ),		
									'default' => true,		
								),								
								'autoplay' => array(
									'type' => 'checkbox',
									'label' => esc_html__( 'Enable Autoplay', 'recycle' ),
									'default' => false,
								),
								'autoplay_timeout' => array(
							        'type' => 'slider',
							        'label' => esc_html__( 'Autoplay Transition Delay', 'recycle' ),
							        'default' => 5000,
							        'min' => 100,
							        'max' => 10000,
							        'integer' => true,
							    ),								
					        ),
					    ),   
			        ),
			    ),			    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_testimonial_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_testimonial_w', __FILE__, 'orion_testimonial_w');