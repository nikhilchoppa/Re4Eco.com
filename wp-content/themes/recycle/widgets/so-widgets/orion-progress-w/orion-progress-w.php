<?php

/*
Widget Name: (OrionThemes) Progress Bar
Description: Progress Bar
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_progress_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_progress_w',
			esc_html__('(OrionThemes) Progress Bar', 'recycle'),
			array(
				'description' => esc_html__('Progress Bar.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-chart-bar',
			),
			array(

			),
			array(
				'progress_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Progress Bar' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to edit', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
			        'fields' => array(
					    'title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Progress Bar Title', 'recycle'),
					        'default' => 'Title'
					    ),
					    'progress_number' => array(
					        'type' => 'Number',
					        'label' => esc_html__( 'Enter a number between 0 and 100', 'recycle' ),
					        'default' => '100',
					    ),
					    'progress_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Progress Bar color', 'recycle' ),
							'default' => 'primary-color-bg',
							'options' => array(
								'primary-color-bg' => esc_html__( 'Primary Theme Color', 'recycle' ),
								'secondary-color-bg' => esc_html__( 'Secondary Theme Color', 'recycle' ),
								'tertiary-color-bg' => esc_html__( 'Tertiary Theme Color', 'recycle' ),								
								'progress-bar-success' => esc_html__( 'Green', 'recycle' ),
								'progress-bar-info' => esc_html__( 'Blue', 'recycle' ),
								'progress-bar-warning' => esc_html__( 'Orange', 'recycle' ),
								'progress-bar-danger' => esc_html__( 'Red', 'recycle' ),
								'primary-color-bg' => esc_html__( 'Main Theme Color', 'recycle' ),
								'secondary-color-bg' => esc_html__( 'Secondary Theme Color', 'recycle' ),
								'tertiary-color-bg' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
								'black-color-bg' => esc_html__( 'Black', 'recycle' ),
								'white-bg' => esc_html__( 'White', 'recycle' ),
							),
					    ),
					    'progress_style' => array(
							'type' => 'select',
							'label' => esc_html__( 'Progress Bar style', 'recycle' ),
							'default' => 'primary',
							'options' => array(
								'simple' => esc_html__( 'Simple', 'recycle' ),
								'stripes' => esc_html__( 'Stripes', 'recycle' ),
								'animated' => esc_html__( 'Animated Stripes', 'recycle' ),
							),
					    ),				    
					),
				),
				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Widget style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
			        	'title_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Progress Bar Title Color', 'recycle' ),
							'default' => 'text-dark',
							'options' => array(
								'text-light' => esc_html__( 'Light', 'recycle' ),
								'text-dark' => esc_html__( 'Dark', 'recycle' ),
								'primary-color' => esc_html__( 'Primary Theme Color', 'recycle' ),
								'secondary-color' => esc_html__( 'Secondary Theme Color', 'recycle' ),
								'tertiary-color' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
							)
						),
					    'progress_percantage_position' => array(
							'type' => 'select',
							'label' => esc_html__( 'Progress Percantage position', 'recycle' ),
							'default' => 'in-title',
							'options' => array(
								'in-title' => esc_html__( 'Next to the title', 'recycle' ),
								'in-progress' => esc_html__( 'Inside Progress bar', 'recycle' ),
							),
					    ),						
					    'progress_size' => array(
							'type' => 'select',
							'label' => esc_html__( 'Progress Bar thickness', 'recycle' ),
							'default' => 'progress-md',
							'options' => array(
								'progress-sm' => esc_html__( 'Slim', 'recycle' ),
								'progress-md' => esc_html__( 'Medium', 'recycle' ),
								'progress-lg' => esc_html__( 'Thick', 'recycle' ),
							),
					    ),
					),
				),
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_progress_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_progress_w', __FILE__, 'orion_progress_w');