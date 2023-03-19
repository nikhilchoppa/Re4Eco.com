<?php

/*
Widget Name: (OrionThemes) Empty Space
Description: Add vertical space
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_empty_space_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_empty_space_w',
			esc_html__('(OrionThemes) Empty Space', 'recycle'),
			array(
				'description' => esc_html__('Add blank space between widgets.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-editor-insertmore',
			),
			array(

			),
			array(
			    'empty_space' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Space height in pixels.', 'recycle' ),
			        'default' => 24,
			        'min' => 1,
			        'max' => 1200,
			        'integer' => true
			    ),
		    	'visible-lg' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Visible on large screens', 'recycle' ),
			        'default' => true,
			    ),
			    'visible-md' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Visible on medium screens', 'recycle' ),
			        'default' => true,
			    ),		    
			    'visible-sm' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Visible on small screens', 'recycle' ),
			        'default' => true,
			    ),
			    'visible-xs' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Visible on Extra small screens', 'recycle' ),
			        'default' => true,
			    ),				    
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_empty_space_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_empty_space_w', __FILE__, 'orion_empty_space_w');