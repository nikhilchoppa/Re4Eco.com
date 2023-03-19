<?php

/*
Widget Name: (OrionThemes) Accordion
Description: Displays accordion
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_accordion_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_accordion_w',
			esc_html__('(OrionThemes) Accordion', 'recycle'),
			array(
				'description' => esc_html__('A customizable accordion widget.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-editor-justify',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),		    
				'icon_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Panel' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a panel', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='panel_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(		        		
					    'panel_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Panel Title', 'recycle'),
					        'default' => '',
					        'description' => esc_html__('All Panel titles must be unique.', 'recycle'),
					    ),					    
						'panel_content' => array(
					        'type' => 'tinymce',
					        'label' => esc_html__( 'Panel content', 'recycle' ),
					        'rows' => 10
					    ),	
					    'the_icon' => array(
						    'type' => 'icon',
						    'label' => esc_html__('Select an icon (optional)', 'recycle'),
						),	
						'icon_title_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Icon color', 'recycle' ),
					        'default' => ''
					    ),
					    'collapse' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Open', 'recycle' ),
					        'default' => false
					    ),		    
					),
		        ),	        	
			   'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'text_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Content Text Color', 'recycle' ),
							'default' => 'text-dark',
							'options' => array(
								'text-light' => esc_html__( 'Light', 'recycle' ),
								'text-dark' => esc_html__( 'Dark', 'recycle' ),
							)
						),
						'nav_text_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Panel Title Color', 'recycle' ),
							'default' => 'text-dark',
							'options' => array(
								'text-light' => esc_html__( 'Light', 'recycle' ),
								'text-dark' => esc_html__( 'Dark', 'recycle' ),
							)
						),						        	
						'bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Background color', 'recycle' ),
					        'default' => '#fff',
					    ),				    
					    'bg_opacy' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Background color opacity', 'recycle' ),
					        'default' => 100,
					        'min' => 1,
					        'max' => 100,
					        'integer' => true,
					    ),
						'border_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Border color', 'recycle' ),
					        'default' => '#F2F4F4',
					    ),					    
					    'hover_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Title hover color', 'recycle' ),
							'default' => 'primary-hover',
							'options' => array(
								'primary-hover' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary-hover' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary-hover' => esc_html__( 'Tertiary theme color', 'recycle' ),
								'black-hover' => esc_html__( 'Black', 'recycle' ),
								'white-hover' => esc_html__( 'White', 'recycle' ),
							)
					    ),
			        )
			    )			    			    		    	                
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_accordion_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_accordion_w', __FILE__, 'orion_accordion_w');