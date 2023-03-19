<?php
 
/*
Widget Name: (OrionThemes) Features
Description: Displays features
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_features_w extends SiteOrigin_Widget {

	function __construct() {
		$main_theme_color = orion_get_theme_option_css('main_theme_color', '#22AA86' );
		parent::__construct(
			'orion_features_w',
			esc_html__('(OrionThemes) Features', 'recycle'),
			array(
				'description' => esc_html__('Displays animated features in a grid.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-star-filled',
			),
			array(

			),
			array(
	    
				'icon_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Feature' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to edit', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='icon_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
						'the_icon' => array(
						    'type' => 'icon',
						    'label' => esc_html__('Icon', 'recycle'),
						),
					    'custom_image_file' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Or choose an image', 'recycle' ),
					        'choose' => esc_html__( 'Choose image', 'recycle' ),
					        'update' => esc_html__( 'Set image', 'recycle' ),
					         'description' => esc_html__('setting the image will override the icon field', 'recycle'),
					        'library' => 'image',
					        'fallback' => false
					    ),
					    'icon_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Title', 'recycle'),
					        'default' => ''
					    ),
				    
						'description' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Description', 'recycle' ),
					        'rows' => 4
					    ),
					    'read_more' => array(
					        'type' => 'text',
					        'label' => esc_html__('Button Text', 'recycle'),
					        'default' => 'Read more',
					    ),					    
					    'url' => array(
					        'type' => 'link',
					        'label' => esc_html__('Destination URL', 'recycle'),
					        'default' => esc_html__('#', 'recycle'),
					    ),					    
						'style' => array(
					        'type' => 'section',
					        'label' => esc_html__( 'Element Style' , 'recycle' ),
					        'hide' => true,
					        'fields' => array(
								'icon_color' => array(
							        'type' => 'color',
							        'label' => esc_html__( 'Icon color', 'recycle' ),
							        'default' => $main_theme_color,
							    ),
							    'bg_image' => array(
							        'type' => 'media',
							        'label' => esc_html__( 'Background image', 'recycle'  ),
							        'choose' => esc_html__( 'Choose image', 'recycle' ),
							        'update' => esc_html__( 'Upload image', 'recycle' ),
							        'fallback' => true
							    ),					    		
								'bg_color' => array(
							        'type' => 'color',
							        'label' => esc_html__( 'Background Color Overlay', 'recycle' ),
							        'default' => 'transparent',
							    ),
							    'bg_opacy' => array(
							        'type' => 'slider',
							        'label' => esc_html__( 'Overlay opacity', 'recycle' ),
							        'description' => esc_html__('Values from 0 (transparent) to 100 (no opacity)', 'recycle'),
							        'default' => 100,
							        'min' => 0,
							        'max' => 100,
							        'integer' => true
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
							    'title_hover_color' => array(
							        'type' => 'select',
							        'label' => esc_html__( 'Title Hover Color', 'recycle' ),
							        'default' => 'primary-hover',
							        'options' => array(
							            'primary-hover' => esc_html__( 'Main Theme Color', 'recycle' ),
							            'secondary-hover' => esc_html__( 'Secondary Theme Color', 'recycle' ),
							            'tertiary-hover' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
							            'blue-hover' => esc_html__( 'Blue', 'recycle' ),
							            'green-hover' => esc_html__( 'Green', 'recycle' ),
							            'pink-hover' => esc_html__( 'Pink', 'recycle' ),
							            'orange-hover' => esc_html__( 'Orange', 'recycle' ),
							            'black-hover' => esc_html__( 'Black', 'recycle' ),
							            'white-hover' => esc_html__( 'White', 'recycle' ),
							        ),
							    ),							    
							),
						),
					),
		        ),

				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Style & layout' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
				        'per_row' => array(
							'type' => 'select',
							'label' => esc_html__('Elements per row', 'recycle'),	
						    'options' => array(
								'1'	=> '1',
						    	'2'	=> '2',
					            '3'	=> '3',
					            '4'	=> '4',
				       		),
						    'default' => 3,		
				       	),
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
				        'text_alignment' => array(
							'type' => 'select',
							'label' => esc_html__('Text alignment', 'recycle'),	
							'default' => 'text-center',
							'options' => array(
								'text-center' => esc_html__( 'Center', 'recycle' ),
								'text-left' => esc_html__( 'Left', 'recycle' ),
							),
				       	),					       	
				        'icon_size' => array(
							'type' => 'select',
							'label' => esc_html__('Icon size', 'recycle'),	
							'default' => 'normal',
							'options' => array(
								'normal' => esc_html__( 'Normal', 'recycle' ),
								'large' => esc_html__( 'Large', 'recycle' ),
							),
				       	),				       	
					    'feature_height' => array(
					        'type' => 'number',
					        'label' => esc_html__( 'Height in pixels', 'recycle' ),
					        'default' => 336,
					    ),
						'always_open' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Always show description?', 'recycle' ),
					        'default' => false
					    ),
						'add_borders' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Add borders', 'recycle' ),
					        'default' => false
					    ),
						'border_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Border color', 'recycle' ),
					        'default' => ''
					    ),						    
						'option_button' => array(
					        'type' => 'section',
					        'label' => esc_html__( 'Button' , 'recycle' ),
					        'hide' => true,
					        'fields' => array(
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
			        ),
			    ),			    

			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_features_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_features_w', __FILE__, 'orion_features_w');