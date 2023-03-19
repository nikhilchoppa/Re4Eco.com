<?php

/*
Widget Name: (OrionThemes) Divider
Description: Add a divider
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_dividers_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_dividers_w',
			esc_html__('(OrionThemes) Divider', 'recycle'),
			array(
				'description' => esc_html__('Add divider.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-minus',
			),
			array(

			),
			array(
				'divider_color' => array(
			        'type' => 'color',
			        'label' => esc_html__( 'Divider color', 'recycle' ),
			        'default' => '#f2f2f2'
			    ),
			    'divider_color_opacity' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Divider Color Opacity in %', 'recycle' ),
			        'default' => 100,
			        'min' => 1,
			        'max' => 100,
			        'integer' => true,
			    ),				    			
			    'divider_style' => array(
			        'type' => 'select',
			        'label' => esc_html__( 'Divider style', 'recycle' ),
			        'default' => '',
			        'options' => array(
			            'solid' => esc_html__( 'Solid', 'recycle' ),
			            'dashed' => esc_html__( 'Dashed', 'recycle' ),
			            'dotted' => esc_html__( 'Dotted', 'recycle' ),
			            'double' => esc_html__( 'Double', 'recycle' ),
			        ),
			    ),
			    'width' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Divider width in %', 'recycle' ),
			        'default' => 100,
			        'min' => 1,
			        'max' => 100,
			        'integer' => true,
			    ),			    
			    'height' => array(
			        'type' => 'number',
			        'label' => esc_html__( 'Height in px', 'recycle' ),
			        'default' => '2'
			    ),
			    'margin_top' => array(
			        'type' => 'number',
			        'label' => esc_html__( 'Top margin in px', 'recycle' ),
			        'default' => ''
			    ),
			    'margin_bottom' => array(
			        'type' => 'number',
			        'label' => esc_html__( 'Bottom margin in px', 'recycle' ),
			        'default' => ''
			    ),
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_dividers_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_dividers_w', __FILE__, 'orion_dividers_w');