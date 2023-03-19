<?php

/*
Widget Name: (OrionThemes) Heading
Description: Displays Heading
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_heading_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_heading_w',
			esc_html__('(OrionThemes) Heading', 'recycle'),
			array(
				'description' => esc_html__('Display headings in different styles.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-editor-bold',
			),
			array(

			),
			array(

			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Text', 'recycle'),
			    ),
		        'size' => array(
					'type' => 'select',
					'label' => esc_html__('HTML Tag', 'recycle'),	
				    'options' => array(
						'h1'	=> esc_html__('H1', 'recycle'),
				    	'h2'	=> esc_html__('H2', 'recycle'),
				    	'h3'	=> esc_html__('H3', 'recycle'),
				    	'h4'	=> esc_html__('H4', 'recycle'),
				    	'h5'	=> esc_html__('H5', 'recycle'),
				    	'h6'	=> esc_html__('H6', 'recycle'),
		       		),
				    'default' => '',		
		       	),			    
		        'text_color' => array(
					'type' => 'select',
					'label' => esc_html__('Color', 'recycle'),	
				    'options' => array(
				    	'text-default'	=> esc_html__('Default', 'recycle'),
				    	'text-dark'	=> esc_html__('Dark', 'recycle'),
				    	'text-light'	=> esc_html__('Light', 'recycle'),
				    	'primary-color'	=> esc_html__('Main theme color', 'recycle'),
				    	'secondary-color'	=> esc_html__('Secondary theme color', 'recycle'),
				    	'tertiary-color'	=> esc_html__('Tertiary theme color', 'recycle'),				    	
		       		),
				    'default' => 'text-default',		
		       	),
		        'text_align' => array(
					'type' => 'select',
					'label' => esc_html__('Align', 'recycle'),	
				    'options' => array(
						'text-left'	=> esc_html__('Left', 'recycle'),
				    	'text-right'	=> esc_html__('Right', 'recycle'),						
				    	'text-center'	=> esc_html__('Center', 'recycle'),
		       		),
				    'default' => 'left',		
		       	),

			    'case' => array(
			        'type' => 'checkbox',
			        'label' => esc_html__('Uppercase', 'recycle'),
			        'default' => false,
			    ),
		        'separator_style' => array(
					'type' => 'select',
					'label' => esc_html__('Divider', 'recycle'),	
				    'options' => array(
						''	=> esc_html__('None', 'recycle'),
				    	'separator-style-1'	=> esc_html__('Style 1', 'recycle'),
				    	'separator-style-2'	=> esc_html__('Style 2', 'recycle'),			    	
		       		),
				    'default' => '',		
		       	),
			    'heading_margin' => array(
			        'type' => 'number',
			        'label' => esc_html__( 'Add bottom margin (px)', 'recycle' ),
			        'default' => '',
			    )		       	
				       				       			
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_heading_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_heading_w', __FILE__, 'orion_heading_w');