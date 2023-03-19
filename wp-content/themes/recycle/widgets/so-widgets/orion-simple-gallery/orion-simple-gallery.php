<?php 
/*
Widget Name: (OrionThemes) Gallery
Description: Displays images in grid or carousel
Author: OrionThemes
Author URI: http://orionthemes.com
Widget URI: http://orionthemes.com
*/

class orion_simple_gallery extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_simple_gallery',
			__('(OrionThemes) Gallery', 'recycle'),
			array(
				'description' => esc_html__('Displays images in grid or carousel.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-images-alt2'
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),				
				'images_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add images' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add image', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='image_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
		        		'image_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Admin Label', 'recycle'),
					        'description' => esc_html__('Optional, does not appear on front-end', 'recycle'),
					    ),
						'image' => array(
							'type' => 'media',
							'label' => esc_html__( 'Upload an image.', 'recycle' ),
							'choose' => __( 'Choose image', 'recycle' ),
							'fallback' => true,
						),
					    'hovertext' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Hover description Text', 'recycle' ),
							'default' => esc_html__('', 'recycle'),
					    ),							
					),
				
		        ),
		        'per_row' => array(
					'type' => 'select',
					'label' => esc_html__('Elements per row', 'recycle'),	
				    'options' => array(
						'1'	=> '1',
				    	'2'	=> '2',
			            '3'	=> '3',
			            '4'	=> '4',
			            '6'	=> '6',
		       		),
				    'default' => 3,		
		       	),	 		        
				'display_layout' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose Layout', 'recycle' ),
					'default' => 'grid',
					'options' => array(
			            'carousel' => esc_html__( 'Carousel', 'recycle' ),
			            'grid' => esc_html__( 'Grid', 'recycle' ),
					)			            					
				),
			    'text_color' => array(
			        'type' => 'select',
			        'label' => esc_html__( 'Widget text color', 'recycle' ),
			        'default' => 'text-dark',
					'options' => array(					
						'text-dark' => esc_html__( 'Dark', 'recycle' ),	
						'text-light' => esc_html__( 'Light', 'recycle' ),
						'primary-color' => esc_html__( 'Main theme color', 'recycle' ),
						'secondary-color' => esc_html__( 'Secondary theme color', 'recycle' ),
						'tertiary-color' => esc_html__( 'Tertiary theme color', 'recycle' ),
					),	
			    ),						
				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'onclick' => array(
						'type' => 'select',
						'label' => esc_html__( 'On click', 'recycle' ),
						'default' => 'lightbox',
						'options' => array(
							'lightbox' => esc_html__( 'Open image in lightbox', 'recycle' ),
							'nothing' => esc_html__( 'Do nothing', 'recycle' ),
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
								'autoplay_timeout' => array(
							        'type' => 'slider',
							        'label' => esc_html__( 'Autoplay Transition Delay', 'recycle' ),
							        'default' => 5000,
							        'min' => 100,
							        'max' => 10000,
							        'integer' => true,
							    ),
								'navigation_carousel' => array(
									'type' => 'select',
									'label' => esc_html__( 'Navigation', 'recycle' ),
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
					        ),
					    ),    
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
					    'text_hover_color' => array(
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
						'scale_efect' => array(
							'type' => 'select',
							'label' => esc_html__( 'Scale image on hover', 'recycle' ),
							'default' => 'scale-zoomin',
							'options' => array(
								'scale-none' => esc_html__( 'None', 'recycle' ),
								'scale-zoomin' => esc_html__( 'Zoom in', 'recycle' ),	
								'scale-zoomout' => esc_html__( 'Zoom out', 'recycle' ),
							),					
						),
					),
				),				    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_simple_gallery-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_simple_gallery', __FILE__, 'orion_simple_gallery');