<?php
/*
Widget Name: (OrionThemes) Featured Pages
Description: Displays Featured pages
Author: OrionThemes
Author URI: http://orionthemes.com
Widget URI: http://orionthemes.com
*/

function orion_return_pages_array() {
	$pages = get_pages();
	$all_pages = array();
	foreach ( $pages as $page ) {
		$id = $page->ID;
		$page_title = $page->post_title;
		$all_pages[$id] = $page_title;
	}
	return  $all_pages;
}


class orion_featured_pages extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_featured_pages',
			esc_html__('(OrionThemes) Featured Pages', 'recycle'),
			array(
				'description' => esc_html__('Displays selected pages in a grid or carousel.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-screenoptions'
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),				
				'pages_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add pages' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to select a page', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='page_id'] option:selected",
			            'update_event' => 'change',
			            'value_method' => 'text'
			        ),
		        	'fields' => array(
						'page_id' => array(
							'type' => 'select',
							'label' => esc_html__( 'Choose page by title.', 'recycle' ),
							'description' => esc_html__( 'Add excerpt and featured image on page edit screen, to display it inside widget.', 'recycle' ),
							'default' => '',
							'options' => orion_return_pages_array(),
						),
					),
		        ),
		        'per_row' => array(
					'type' => 'select',
					'label' => esc_html__('Elements per row', 'recycle'),	
				    'options' => array(
						'1'	=> '1',
				    	'2'	=> '2',
			            '3'	=> '3',
			            '4'	=> '4',
			            '6'	=> '6',
		       		),
				    'default' => 3,		
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
							'label' => esc_html__( 'Display excerpt', 'recycle' ),
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
						'title_hover_color' => array(
							'type' => 'select',
							'label' => esc_html__( 'Read More Button and Title hover color', 'recycle' ),
							'default' => 'primary',
							'options' => array(
								'primary' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary' => esc_html__( 'Tertiary theme color', 'recycle' ),	
								'black' => esc_html__( 'Dark', 'recycle' ),	
								'white' => esc_html__( 'Light', 'recycle' ),
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
						'hover_resize' => array(
							'type' => 'checkbox',
							'label' => esc_html__( 'Enlarge on hover', 'recycle' ),
							'default' => false,
						),						
					),
			    ),			    
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_featured_pages-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_featured_pages', __FILE__, 'orion_featured_pages');