<?php

/*
Widget Name: (OrionThemes) Button
Description: Add a button
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_button_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_button_w',
			esc_html__('(OrionThemes) Button', 'recycle'),
			array(
				'description' => esc_html__('Add a button.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-arrow-right-alt',
			),
			array(

			),
			array(
			    'button' => array(
			        'type' => 'text',
			        'label' => esc_html__( 'Button Text', 'recycle' ),
					'default' => esc_html__('Button', 'recycle'),
			    ),
			    'url' => array(
			        'type' => 'link',
			        'label' => esc_html__('Destination URL', 'recycle'),
			        'default' => esc_html__('#', 'recycle'),
			    ),
			    'new_tab' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Open in a new window', 'recycle' ),
			        'default' => false,
			    ),
				'icon_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Icon' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(	
					    'icon' => array(
					        'type' => 'icon',
					        'label' => esc_html__('Select Icon', 'recycle'),
					    ),
						'icon_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Icon Color', 'recycle' ),
					        'default' => '',
					    ),					    		    
					    'icon_position' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Icon Position', 'recycle' ),
					        'default' => '',
					        'options' => array(
					            'icon-left' => esc_html__( 'Left', 'recycle' ),
					            'icon-right' => esc_html__( 'Right', 'recycle' ),
					            'inset-left' => esc_html__( 'Inset Left', 'recycle' ),
					            'inset-right' => esc_html__( 'Inset Right', 'recycle' ),
					        ),
					    ),

					),
				),
				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Style & Layout' , 'recycle' ),
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
					            'btn btn-yellow' => esc_html__( 'Yellow', 'recycle' ),
					            'btn btn-red' => esc_html__( 'Red', 'recycle' ),
					            'btn btn-orange' => esc_html__( 'Orange', 'recycle' ),
					            'btn btn-black' => esc_html__( 'Black', 'recycle' ),
					            'btn btn-white' => esc_html__( 'White', 'recycle' ),
					        ),
					    ),
					    'btn_size' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Button Size', 'recycle' ),
					        'default' => 'btn-md',
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
					    'btn_alignment' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Align', 'recycle' ),
					        'default' => '',
					        'options' => array(
					            'float-left' => esc_html__( 'Left', 'recycle' ),
					            'float-right' => esc_html__( 'Right', 'recycle' ),
					            'center' => esc_html__( 'Center', 'recycle' ),
					            'block' => esc_html__( 'Fullwidth', 'recycle' ),
					            '' => esc_html__( 'None', 'recycle' ),
					        ),
					    ),
					),
				),	    		    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_button_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_button_w', __FILE__, 'orion_button_w');