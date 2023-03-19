<?php
 
/*
Widget Name: (OrionThemes) Advanced Tabs
Description: Build tabbed content with Page Builder
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_advanced_carousel_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_advanced_carousel_w',
			esc_html__('(OrionThemes) Advanced Tabs', 'recycle'),
			array(
				'description' => esc_html__('Build tabbed content with Page Builder.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-editor-table',
			),
			array(

			),
			array(
				'slide_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Slide' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to edit', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='navigation_label']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(   		
					    'navigation_label' => array(
					        'type' => 'text',
					        'label' => esc_html__('Navigation label', 'recycle'),
					        'default' => ''
					    ),
						'layoutbuilder' => array(
							'type' => 'builder',
							'builder_type' => 'layout_slider_builder',
							'label' => esc_html__( 'Create Layout', 'recycle' ),
							'description' => esc_html__( 'Selecting this will override Tab content below.', 'recycle' ),	
						),						    				    				    
					),
		        ),
				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget Style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
				        'nav_align' => array(
							'type' => 'select',
							'label' => esc_html__('Tab Navigation alignment', 'recycle'),
							'default' => 'text-center',
							'options' => array(
								'text-left' => esc_html__( 'Left align', 'recycle' ),
								'text-center' => esc_html__( 'Center align', 'recycle' ),
								'text-right' => esc_html__( 'Right align', 'recycle' ),
							)		
				       	),
					    'space_below_nav' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Space below navigation', 'recycle' ),
					        'min' => 0,
					        'max' => 120,
					        'integer' => true
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
         return 'orion_advanced_carousel_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_advanced_carousel_w', __FILE__, 'orion_advanced_carousel_w');