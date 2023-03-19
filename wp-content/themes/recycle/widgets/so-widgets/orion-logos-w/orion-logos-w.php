<?php

/*
Widget Name: (OrionThemes) Logos
Description: Displays Logos
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_logos_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_logos_w',
			esc_html__('(OrionThemes) Logos', 'recycle'),
			array(
				'description' => esc_html__('Display logos in a grid or carousel.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-awards',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),    
				'repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Logo' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a Logo', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='logo-title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
					    'logo-title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Logo title', 'recycle'),
					        'default' => '',
					    ),  
						'logo' => array(		        		
					        'type' => 'media',
					        'label' => esc_html__( 'Choose a Logo', 'recycle'),
					        'choose' => esc_html__( 'Choose logo', 'recycle'),
					        'update' => esc_html__( 'Set logo', 'recycle'),
					        'library' => 'image',
					        'fallback' => true,
						),			        		
					    'link' => array(
					        'type' => 'text',
					        'label' => esc_html__('Logo Link', 'recycle'),
					        'default' => '',
					    ),  		    
					),
		        ),
		        'display_as' => array(
					'type' => 'select',
					'label' => esc_html__('Display as', 'recycle'),	
				    'options' => array(
						'grid'	=> 'Grid',
				    	'carousel'	=> 'Carousel',		            			            
		       		),
				    'default' => 'carousel',
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
			            '12' => '12'		            			            
		       		),
				    'default' => 4,
		       	),

				'text_color' => array(
					'type' => 'select',
					'label' => esc_html__( 'Light or dark color', 'recycle' ),
					'default' => 'text-default',
					'options' => array(
					'text-default' => esc_html__( 'Default', 'recycle' ),
					'text-light' => esc_html__( 'Light text', 'recycle' ),
					'text-dark' => esc_html__( 'Dark text', 'recycle' ),
					)
				),

				'border_color' => array(
			        'type' => 'color',
			        'label' => esc_html__( 'Grid border color', 'recycle' ),
			        'default' => '#f2f2f2'
			    ),

			    'logo_height' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Row height (px)', 'recycle' ),
			        'default' => 180,
			        'min' => 60,
			        'max' => 360,
			        'integer' => true
			    ),

				'logo_img_size' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Logo size (%)', 'recycle' ),
			        'default' => 80,
			        'min' => 40,
			        'max' => 100,
			        'integer' => true,
			    ),

				'logo_img_hover_size' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Logo size on hover (%)', 'recycle' ),
			        'default' => 90,
			        'min' => 40,
			        'max' => 100,
			        'integer' => true,
			    ),

				'option_carousel' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Carousel Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'navigation_carousel' => array(
							'type' => 'select',
							'label' => esc_html__( 'Navigation', 'recycle' ),
							'default' => 'none',
							'options' => array(
								'arrows_aside' => esc_html__( 'Arrows', 'recycle' ),
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
							'label' => esc_html__( 'Enable autoplay', 'recycle' ),
							'default' => false,
						),
						'autoplay_timeout' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Autoplay Transition Delay', 'recycle' ),
					        'default' => 5000,
					        'min' => 100,
					        'max' => 7000,
					        'integer' => true,
					    ),
			        ),
			    ),  
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_logos_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_logos_w', __FILE__, 'orion_logos_w');