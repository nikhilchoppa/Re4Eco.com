<?php

/*
Widget Name: (OrionThemes) Counter Widget
Description: Count up to a desired number
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_count_up_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_count_up_w',
			__('(OrionThemes) Counter', 'recycle'),
			array(
				'description' => esc_html__('Count up to a specified number.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-dashboard',
			),
			array(

			),
			array(
			    'counter_number' => array(
			        'type' => 'Number',
			        'label' => esc_html__( 'Enter a number', 'recycle' ),
			        'default' => '1234',
			    ),
			    'counter_number_end' => array(
			        'type' => 'Number',
			        'label' => esc_html__( 'Start from number', 'recycle' ),
			        'default' => '0',
			    ),			    
			    'counter_text' => array(
			        'type' => 'text',
			        'label' => esc_html__('Text', 'recycle'),
			        'default' => 'Counter text.'
			    ),
			    'counter_speed' => array(
			        'type' => 'Number',
			        'label' => esc_html__( 'Speed in miliseconds', 'recycle' ),
			        'default' => '2000',
			    ),				    
				'text_color' => array(
					'type' => 'select',
					'label' => esc_html__( 'Text color', 'recycle' ),
					'default' => 'text-default',
					'options' => array(
						'text-default' => esc_html__( 'Default', 'recycle' ),
						'text-light' => esc_html__( 'Light', 'recycle' ),
						'text-dark' => esc_html__( 'Dark', 'recycle' ),
					)
				),
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_count_up_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_count_up_w', __FILE__, 'orion_count_up_w');