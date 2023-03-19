<?php

/*
Widget Name: (OrionThemes) Tabs
Description: Displays tabs
Author: OrionThemes
Author URI: http://orionthemes.com
*/
class orion_tabs_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_tabs_w',
			esc_html__('(OrionThemes) Tabs', 'recycle'),
			array(
				'description' => esc_html__('Display tabs in different styles.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-index-card',
			),
			array(

			), 
			array(

			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),	    
				'tab_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Tab' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a tab', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='tab_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(		        		
					    'tab_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Tab Title', 'recycle'),
					        'default' => '',
					        'description' => esc_html__('All Tab titles must be unique', 'recycle'),
					    ),
						'the_icon' => array(
						    'type' => 'icon',
						    'label' => esc_html__('Select an icon (optional)', 'recycle'),
						),
						'tab_bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Tab background color', 'recycle' ),
					        'default' => '#fff'
					    ),
						'layoutbuilder' => array(
							'type' => 'builder',
							'builder_type' => 'layout_slider_builder',
							'label' => esc_html__( 'Create Layout', 'recycle' ),
							'description' => esc_html__( 'Selecting this will override Tab content below.', 'recycle' ),
							// 'default' => 'all',
							// 'options' => orion_get_static_blocks()		
						),					    
						'tab_content' => array(
					        'type' => 'tinymce',
					        'label' => esc_html__( 'Tab content', 'recycle' ),
					        'rows' => 10
					    ),
					),
		        ),
				'widget_style' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(

				        'style' => array(
							'type' => 'select',
							'label' => esc_html__('Layout', 'recycle'),	
						    'options' => array(
								'tabs-top'	=> 'Horizontal',
						    	'tabs-left'	=> 'Vertical ',
						    	'tabs-right' => 'Vertical right',
				       		),
						    'default' => 'tabs-top',		
				       	),
					    'active_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Active Tab Text Color', 'recycle' ),
					        'default' => 'active-c1',
					        'options' => array(
					            'active-c1' => esc_html__( 'Main Theme Color', 'recycle' ),
					            'active-c2' => esc_html__( 'Secondary Theme Color', 'recycle' ),
					            'active-c3' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
					        ),
					    ),
					    'navigation_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Navigation Text Color', 'recycle' ),
					        'default' => 'text-dark',
					        'options' => array(
					            'text-dark' => esc_html__( 'Dark', 'recycle' ),
					            'text-light' => esc_html__( 'Light', 'recycle' ),
					        ),
					    ),
						'border_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Border Color', 'recycle' ),
					        'default' => '#F2F4F4'
					    ),				    				    
 					),
 				), 					
			),
			plugin_dir_path(__FILE__)
		);
	}
	/**
	 * Process the content.
	 *
	 * @param $content
	 * @param $frame
	 *
	 * @return string
	 */
		
    function get_template_name($instance) {
         return 'orion_tabs_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_tabs_w', __FILE__, 'orion_tabs_w');