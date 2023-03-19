<?php 

/*
Widget Name: (OrionThemes) Opening Hours
Description: Displays Working hours
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_working_hours_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_working_hours_w',
			esc_html__('(OrionThemes) Opening Hours', 'recycle'),
			array(
				'description' => esc_html__('Displays opening hours.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-clock',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
					'default' => 'Opening Hours',			        
			    ),	    
			    'monday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Monday', 'recycle'),
					'default' => '8:00 - 16:00',
			    ),	
			    'tuesday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Tuesday', 'recycle'),
					'default' => '8:00 - 16:00',
			    ),
			    'wednesday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Wednesday', 'recycle'),
					'default' => '8:00 - 16:00',		        
			    ),	
			    'thursday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Thursday', 'recycle'),
					'default' => '8:00 - 16:00',			        
			    ),		
			    'friday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Friday', 'recycle'),
					'default' => '8:00 - 16:00',			        
			    ),	
			    'saturday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Saturday', 'recycle'),
					'default' => '8:00 - 13:00',			        
			    ),	
			    'sunday' => array(
			        'type' => 'text',
			        'label' => esc_html__('Sunday', 'recycle'),
			    ),
			    'lunch_break' => array(
			        'type' => 'text',
			        'label' => esc_html__('Lunch Break', 'recycle'),
			    ),			    
				'text_color_class' => array(
					'type' => 'select',
					'label' => esc_html__( 'Text color style', 'recycle' ),
					'default' => 'text-default',
					'options' => array(
					'text-default' => esc_html__( 'Default', 'recycle' ),
					'text-light' => esc_html__( 'Light text', 'recycle' ),
					'text-dark' => esc_html__( 'Dark text', 'recycle' ),
					)
				),
				'week_starts_with' => array(
					'type' => 'select',
					'label' => esc_html__( 'Week starts with', 'recycle' ),
					'default' => 'monday',
					'options' => array(
					'monday' => esc_html__( 'Monday', 'recycle' ),
					'sunday' => esc_html__( 'Sunday', 'recycle' ),
					'saturday' => esc_html__( 'Saturday', 'recycle' ),
					)
				),				

			   'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'text_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Text color', 'recycle' ),
					        'default' => ''
					    ),
						'current_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Current day color', 'recycle' ),
					        'default' => '',
					    ),			        	
						'bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Background color', 'recycle' ),
					        'default' => '',
					    ),
					    'bg_opacy' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Background color opacity', 'recycle' ),
					        'default' => 100,
					        'min' => 1,
					        'max' => 100,
					        'integer' => true,
					    ),
					    'has_border' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Display borders', 'recycle' ),
					        'default' => false
					    )
					),
				),
			   'translations_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Translations' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
					    'monday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Monday', 'recycle'),
							'default' => 'Monday',
					    ),	
					    'tuesday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Tuesday', 'recycle'),
							'default' => 'Tuesday',
					    ),
					    'wednesday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Wednesday', 'recycle'),
							'default' => 'Wednesday',		        
					    ),	
					    'thursday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Thursday', 'recycle'),
							'default' => 'Thursday',			        
					    ),		
					    'friday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Friday', 'recycle'),
							'default' => 'Friday',			        
					    ),	
					    'saturday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Saturday', 'recycle'),
							'default' => 'Saturday',			        
					    ),	
					    'sunday' => array(
					        'type' => 'text',
					        'label' => esc_html__('Sunday', 'recycle'),
					        'default' => 'Sunday',
					    ),
					    'lunch_break' => array(
					        'type' => 'text',
					        'label' => esc_html__('Lunch Break', 'recycle'),
					        'default' => 'Lunch Break',
					    ),					    
					),
				), 			   
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_working_hours_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_working_hours_w', __FILE__, 'orion_working_hours_w');