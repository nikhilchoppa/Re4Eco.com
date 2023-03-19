<?php
 
/*
Widget Name: (OrionThemes) Recent Posts
Description: With optional category filter.
Author: OrionThemes
Author URI: http://orionthemes.com
Widget URI: http://orionthemes.com
*/

function get_category_array() { 
	$categories = get_categories( 
		array(
			'taxonomy' => 'category',
		    'orderby' => 'name',
		) 
	);
	$all_categories = array();
	$all_categories['All'] = 'all';
	foreach ( $categories as $category ) {
		$id = $category->term_id;
		$cat_title = $category->name;
		// fill array
		$all_categories[$id] = $cat_title;
	}

	return  $all_categories;
}

function post_limit_array(){
	$select = array();
    for($i=1; $i < 25; $i++) { 
		$select[$i] = $i;
	}
	return $select;
}


class orion_recent_posts_carousel extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_recent_posts_carousel',
			esc_html__('(OrionThemes) Recent Posts', 'recycle'),
			array(
				'description' => esc_html__('Highly coustomizable with category filter.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-edit'
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
					'label' => esc_html__( 'Choose a category', 'recycle' ),
					'description' => esc_html__( 'Select a category.', 'recycle' ),
					'default' => 'all',
					'options' => get_category_array()		
				),
				'display_layout' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose Layout', 'recycle' ),
					'default' => 'grid',
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
		        'number_of_posts' => array(
					'type' => 'select',
					'label' => esc_html__('Number of posts', 'recycle'),	
				    'options' => post_limit_array(),
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
						'display_feeatured' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display featured image', 'recycle' ),
							'default' => true,
						),					
						'display_excerpt' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display post excerpt', 'recycle' ),
							'default' => true,
						),
						'display_meta' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display post meta', 'recycle' ),
							'default' => true,
						),
						'display_readmore' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Display read more button', 'recycle' ),
							'default' => true,
						),
					    'readmore_text' => array(
					        'type' => 'text',
					        'label' => esc_html__('Button text', 'recycle'),
					        'default' => 'Read more'
					    ),
						'display_date' => array(
							'type' => 'select',
							'label' => esc_html__( 'Display date', 'recycle' ),
							'default' => 'on-image',
							'options' => array(
								'on-image' => esc_html__( 'On featured image', 'recycle' ),
								'in-meta' => esc_html__( 'Above post title', 'recycle' ),
								'hide' => esc_html__( 'Do not display', 'recycle' ),	
							),					
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
									'default' => 'dots',
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
						'readmore_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Button & hover color', 'recycle' ),
							'default' => 'primary',
							'options' => array(
								'primary' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),	
								'black' => esc_html__( 'Dark', 'recycle' ),	
								'white' => esc_html__( 'Light', 'recycle' ),
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
								// 'overlay-blur' => esc_html__( 'Blur', 'recycle' ),
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
					),
			    ),
			),	    	
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_recent_posts_carousel-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_recent_posts_carousel', __FILE__, 'orion_recent_posts_carousel');