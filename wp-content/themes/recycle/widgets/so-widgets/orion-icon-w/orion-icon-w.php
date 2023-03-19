<?php

/*
Widget Name: (OrionThemes) Icon
Description: Add an Icon
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_icon_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_icon_w',
			esc_html__('(OrionThemes) Icon', 'recycle'),
			array(
				'description' => esc_html__('Display social media Icons.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-arrow-right-alt',
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
			        'label' => esc_html__( 'Add Icon' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add an Icon', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='icon_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
			        'fields' => array(				
					    'icon' => array(
					        'type' => 'text',
					        'label' => esc_html__( 'Icon Title', 'recycle' ),
							'default' => esc_html__('Icon', 'recycle'),
					    ),
					    'url' => array(
					        'type' => 'link',
					        'label' => esc_html__('Destination URL', 'recycle'),
					    ),
					    'new_tab' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Open in a new window', 'recycle' ),
					        'default' => false,
					    ),

					    'icon' => array(
					        'type' => 'icon',
					        'label' => esc_html__('Select Icon', 'recycle'),
					    ),
						'icon_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Icon Color', 'recycle' ),
					        'default' => '',
						),					
					),
				),

				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(	

					    'icons_type' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Icon Style', 'recycle' ),
					        'default' => 'btn-empty',
					        'options' => array(
					            'btn-flat' => esc_html__( 'Flat', 'recycle' ),
					            'btn-wire' => esc_html__( 'Wire', 'recycle' ),
					            'btn-empty' => esc_html__( 'Empty', 'recycle' ),
					        ),
					    ),
					    'icon_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Icon Color', 'recycle' ),
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
					    'icon_size' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Icon Size', 'recycle' ),
					        'default' => 'btn-md',
					        'options' => array(
					        	'btn-xs' => esc_html__( 'Tiny', 'recycle' ),
					            'btn-sm' => esc_html__( 'Small', 'recycle' ),
					            'btn-md' => esc_html__('Normal', 'recycle'),
					            'btn-lg' => esc_html__('Large', 'recycle'),
					        ),
					    ),
					    'space_between_icons' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Space between icons', 'recycle' ),
					        'min' => 0,
					        'max' => 60,
					        'integer' => true
					    ),
					    'icon_style' => array(
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
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_icon_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_icon_w', __FILE__, 'orion_icon_w');