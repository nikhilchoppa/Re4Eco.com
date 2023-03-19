<?php

/*
Widget Name: (OrionThemes) CTA
Description: Display a Call to Action
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_cta_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_cta_w',
			esc_html__('(OrionThemes) CTA', 'recycle'),
			array(
				'description' => esc_html__('Add call to action.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-megaphone',
			),
			array(

			),
			array(
			    'cta_text' => array(
			        'type' => 'text',
			        'label' => esc_html__( 'Call to Action Text', 'recycle' ),
					'default' => esc_html__('Call to action', 'recycle'),
			    ),				
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
			        'label' => esc_html__( 'Button Icon' , 'recycle' ),
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
			        	'text_align' => array(
							'type' => 'select',
							'label' => esc_html__( 'Text align', 'recycle' ),
							'default' => 'left',
							'options' => array(
								'text-left' => esc_html__( 'Left', 'recycle' ),
								'text-center' => esc_html__( 'Center', 'recycle' ),
							)
						),
			        	'text_size' => array(
							'type' => 'select',
							'label' => esc_html__( 'Text Size', 'recycle' ),
							'default' => 'h3',
							'options' => array(
								'h1' => esc_html__( 'h1', 'recycle' ),
								'h2' => esc_html__( 'h2', 'recycle' ),
								'h3' => esc_html__( 'h3', 'recycle' ),
								'h4' => esc_html__( 'h4', 'recycle' ),
								'h5' => esc_html__( 'h5', 'recycle' ),
								'h6' => esc_html__( 'h6', 'recycle' ),
								'lead' => esc_html__( 'Lead text', 'recycle' ),
								'' => esc_html__( 'Standard text', 'recycle' ),
							)
						),
			        	'button_align' => array(
							'type' => 'select',
							'label' => esc_html__( 'Button position', 'recycle' ),
							'default' => 'bottom',
							'options' => array(
								'block' => esc_html__( 'Bottom', 'recycle' ),
								'inline-block' => esc_html__( 'Right', 'recycle' ),
							)
						),						
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
					    'top_bottom_padding' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Top and bottom spacing', 'recycle' ),
					        'default' => 36,
					        'min' => 0,
					        'max' => 120,
					        'integer' => true
					    ),					    
					),
				),					    		    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_cta_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_cta_w', __FILE__, 'orion_cta_w');