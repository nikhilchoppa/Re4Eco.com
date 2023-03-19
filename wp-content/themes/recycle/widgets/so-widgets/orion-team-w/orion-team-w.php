<?php

/*
Widget Name: (OrionThemes) Team members
Description: With optional department filter.
Author: OrionThemes
Author URI: http://orionthemes.com
Widget URI: http://orionthemes.com
*/

function orion_get_department_array() { 
	$all_departments = array();
	$all_departments['all'] = 'All';
	$taxonomy = 'department';
	$terms = get_terms();
	foreach ($terms as $key => $term) {
		if ($term->taxonomy == 'department') {
			$slug = $term->slug;
			$cat_title = $term->name;
			$all_departments[$slug] = $cat_title;
		}
	}
	return  $all_departments;
}

function orion_team_limit_array(){
	$select = array();
    for($i=1; $i < 25; $i++) { 
		$select[$i] = $i;
	}
	return $select;
}

class orion_team_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_team_w',
			esc_html__('(OrionThemes) Team members', 'recycle'),
			array(
				'description' => esc_html__('Displays team members in a grid or carousel with multiple options.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-groups'
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),
				'category_option' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a department', 'recycle' ),
					'description' => esc_html__( 'Select a department.', 'recycle' ),
					'default' => 'all',
					'options' => orion_get_department_array()		
				),
			
				'display_layout' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose Layout', 'recycle' ),
					'default' => 'carousel',
					'options' => array(
			            'carousel' => esc_html__( 'Carousel', 'recycle' ),
			            'grid' => esc_html__( 'Grid', 'recycle' ),
					)			            					
				),				
		        'per_row' => array(
					'type' => 'select',
					'label' => esc_html__('Elements per row', 'recycle'),	
				    'options' => array(
						'1'	=> '1',
				    	'2'	=> '2',
			            '3'	=> '3',
			            '4'	=> '4',
		       		),
				    'default' => 3,		
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
				'option_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'order_by' => array(
							'type' => 'select',
							'label' => esc_html__( 'Order members by', 'recycle' ),
							'default' => 'title',
							'options' => array(
								'title' => esc_html__( 'Name', 'recycle' ),								
								'date' => esc_html__( 'Date', 'recycle' ),
								'modified' => esc_html__( 'Modified', 'recycle' ),
							),					
						),
						'order' => array(
							'type' => 'select',
							'label' => esc_html__( 'Order members by', 'recycle' ),
							'default' => 'ASC',
							'options' => array(
								'ASC' => esc_html__( 'Ascending', 'recycle' ),								
								'DESC' => esc_html__( 'Descending', 'recycle' ),
							),					
						),				        				
						'display_department' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display department', 'recycle' ),
							'default' => true,
						),	
						'display_about' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display intro text', 'recycle' ),
							'default' => false,
						),
						'display_social' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display social links', 'recycle' ),
							'default' => true,
						),									    
						'option_carousel' => array(
					        'type' => 'section',
					        'label' => esc_html__( 'Carousel' , 'recycle' ),
					        'hide' => true,
					        'fields' => array(
								'autoplay' => array(
									'type' => 'checkbox',
									'label' => esc_html__( 'Enable autoplay', 'recycle' ),
									'default' => false,
								),
								'autoplay_timeout' => array(		
							        'type' => 'slider',		
							        'label' => esc_html__( 'Autoplay Transition Delay', 'recycle' ),		
							        'default' => 5000,		
							        'min' => 100,		
							        'max' => 10000,		
							        'integer' => true,		
							    ),								
								'navigation_carousel' => array(
									'type' => 'select',
									'label' => esc_html__( 'Navigation', 'recycle' ),
									'default' => 'arrows_top',
									'options' => array(
										'dots' => esc_html__( 'Dots', 'recycle' ),
										'arrows_top' => esc_html__( 'Arrows on top', 'recycle' ),
										'arrows_bottom' => esc_html__( 'Arrows on bottom', 'recycle' ),
										'arrows_aside' => esc_html__( 'Arrows on side', 'recycle' ),
										'none' => esc_html__( 'None', 'recycle' ),
									),					
								),
								'display_mobile_nav' => array(		
									'type' => 'checkbox',		
									'label' => esc_html__( 'Display carousel navigation on mobile devices', 'recycle' ),		
									'default' => true,		
								),			
					        ),
					    ),
			        ),
			    ),
			    'style_section'  => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'image_style' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image style', 'recycle' ),
							'default' => 'portrait',
							'options' => array(
								'orion_portrait' => esc_html__( 'Portrait', 'recycle' ),								
								'orion_circle' => esc_html__( 'Circle', 'recycle' ),
								'orion_square' => esc_html__( 'Square', 'recycle' ),
								'orion_carousel' => esc_html__( '3:2 ratio', 'recycle' ),
								'orion_tablet' => esc_html__( 'Original image ratio', 'recycle' ),
							),					
						),				        	
						'hover_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Hover color', 'recycle' ),
							'default' => 'primary',
							'options' => array(
								'primary' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),	
							),					
						),			        	
						'bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Background color', 'recycle' ),
					        'default' => ''
					    ),
					    'bg_opacy' => array(
					        'type' => 'slider',
					        'label' => esc_html__( 'Background color opacity', 'recycle' ),
					        'default' => 100,
					        'min' => 1,
					        'max' => 100,
					        'integer' => true,
					    ),

						'image_overlay' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image overlay', 'recycle' ),
							'default' => 'overlay-none',
							'options' => array(
								'overlay-none' => esc_html__( 'None', 'recycle' ),
								'overlay-black' => esc_html__( 'Darken', 'recycle' ),	
								'overlay-white' => esc_html__( 'Lighten', 'recycle' ),
								'overlay-primary' => esc_html__( 'Main theme color', 'recycle' ),	
								'overlay-secondary' => esc_html__( 'Secondary theme color', 'recycle' ),	
								'overlay-tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),
								'overlay-greyscale' => esc_html__( 'Greyscale', 'recycle' ),
							),					
						),
						'image_overlay_hover' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image overlay on hover', 'recycle' ),
							'default' => 'overlay-hover-none',
							'options' => array(
								'overlay-hover-none' => esc_html__( 'None', 'recycle' ),
								'overlay-hover-black' => esc_html__( 'Darken', 'recycle' ),	
								'overlay-hover-white' => esc_html__( 'Lighten', 'recycle' ),
								'overlay-hover-primary' => esc_html__( 'Main theme color', 'recycle' ),	
								'overlay-hover-secondary' => esc_html__( 'Secondary theme color', 'recycle' ),	
								'overlay-hover-tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),
								'overlay-hover-greyscale' => esc_html__( 'Greyscale', 'recycle' ),
								// 'overlay-hover-blur' => esc_html__( 'Blur', 'recycle' ),
							),
						),						
						'scale_efect' => array(
							'type' => 'select',
							'label' => esc_html__( 'Scale image on hover', 'recycle' ),
							'default' => 'scale-zoomin',
							'options' => array(
								'scale-none' => esc_html__( 'None', 'recycle' ),
								'scale-zoomin' => esc_html__( 'Zoom in', 'recycle' ),	
								'scale-zoomout' => esc_html__( 'Zoom out', 'recycle' ),
							),					
						),
						'display_border' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display border', 'recycle' ),
							'default' => true,
						),
					),
			    ),
			),	    	
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_team_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_team_w', __FILE__, 'orion_team_w');