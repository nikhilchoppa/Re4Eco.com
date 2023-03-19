<?php
/*
Widget Name: (OrionThemes) Portfolio Widget
Description: Displays portfolio
Author: OrionThemes
Author URI: http://orionthemes.com
*/

function orion_get_portfolio_categories() {
	$all_portfolios = array();
	if (taxonomy_exists('portfolio_category')) {
		$terms = get_terms( array(
		    'taxonomy' => 'portfolio_category',
		    'orderby'    => 'count',
		    'hide_empty' => true,
		) );	 
		
		$all_portfolios[0] = 'All';
		foreach ($terms as $key => $portfolio_cat) {
			$id = $portfolio_cat->term_id;
			$name = $portfolio_cat->name;
			$all_portfolios[$id] = $name;
		}
	}
	return $all_portfolios;
}

class orion_portfolio_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_portfolio_w',
			esc_html__('(OrionThemes) Portfolio Widget', 'recycle'),
			array(
				'description' => esc_html__('Display isotope portfolio.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-images-alt',
			),
			array(

			), 
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),
				'portfolio_cat' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose categories to display', 'recycle' ),
					'multiple' => true,
					'description' => esc_html__( 'Select All to display all categories, hold the SHIFT key to select multiple categories.', 'recycle' ),
					'default' => 0,
					'options' => orion_get_portfolio_categories()
				),
				'filter' => array(
					'type' => 'select',
					'label' => esc_html__( 'Display filter', 'recycle' ),
					'default' => true,
				    'options' => array(
						true => 'Display',
						false => 'Do not display',
		       		),
				),				
				'columns' => array(
					'type' => 'select',
					'label' => esc_html__( 'Number of columns', 'recycle' ),
					'description' => esc_html__( 'Select All to display all categories', 'recycle' ),
					'default' => 'col-sm-4',
				    'options' => array(
				    	'col-sm-6' => '2',
						'col-sm-4'	=> '3',
						'col-md-3 col-sm-6' => '4',
		       		),
				),				
				'number_of_posts' => array(
			        'type' => 'number',
			        'description' => esc_html__( '-1 for unlimited', 'recycle' ),
			        'label' => __( 'Max number of items to display', 'recycle' ),
			        'default' => '-1'
			    ),
				'order_by' => array(
					'type' => 'select',
					'label' => esc_html__( 'Order by', 'recycle' ),
					'default' => 'date',
				    'options' => array(
						'date'	=> 'Date',
						'modified' => 'Last modified',
				    	'rand'	=> 'Random',
				    	'menu_order' => 'Menu order',
		       		),
				),
				'order' => array(
					'type' => 'select',
					'label' => esc_html__( 'Order', 'recycle' ),
					'description' => esc_html__( 'Select All to display all categories', 'recycle' ),
					'default' => 'DESC',
				    'options' => array(
						'ASC'	=> 'Ascending',
						'DESC' => 'Descending',
		       		),
				),
				'onclick' => array(
					'type' => 'select',
					'label' => esc_html__( 'On click', 'recycle' ),
					'default' => 'link',
					'options' => array(
						'link' => esc_html__( 'Open single portfolio', 'recycle' ),
						'lightbox' => esc_html__( 'Open image in lightbox', 'recycle' ),
						'nothing' => esc_html__( 'Do nothing', 'recycle' ),
					),
				),
				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'widget style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'image_style' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image style', 'recycle' ),
							'default' => 'orion_carousel',
							'options' => array(
								'orion_portrait' => esc_html__( 'Portrait', 'recycle' ),								
								'orion_circle' => esc_html__( 'Circle', 'recycle' ),
								'orion_square' => esc_html__( 'Square', 'recycle' ),
								'orion_carousel' => esc_html__( '3:2 ratio', 'recycle' ),
								'orion_tablet' => esc_html__( '750px width', 'recycle' ),
								'' => esc_html__( 'Original image ratio', 'recycle' ),
							),					
						),				        	
					    'text_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Hover text color', 'recycle' ),
					        'default' => 'text-light',
							'options' => array(
								'primary-color' => esc_html__( 'Main theme color', 'recycle' ),
								'secondary-color' => esc_html__( 'Secondary theme color', 'recycle' ),
								'tertiary-color' => esc_html__( 'Tertiary theme color', 'recycle' ),	
								'text-dark' => esc_html__( 'Dark', 'recycle' ),	
								'text-light' => esc_html__( 'Light', 'recycle' ),
							),	
					    ),			        	
						'image_overlay' => array(
							'type' => 'select',
							'label' => esc_html__( 'Image overlay', 'recycle' ),
							'default' => 'overlay-black',
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
							'default' => 'overlay-none',
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

					),

				),
				'filter_style' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Filter style' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
					    'btn_type' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Filter Style', 'recycle' ),
					        'default' => '',
					        'options' => array(
					            'btn-flat' => esc_html__( 'Flat', 'recycle' ),
					            'btn-wire' => esc_html__( 'Wire', 'recycle' ),
					            'btn-empty' => esc_html__( 'Empty', 'recycle' ),
					        ),
					    ),
					    'button_color' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Filter Color', 'recycle' ),
					        'default' => 'btn',
					        'options' => array(
					            'btn' => esc_html__( 'Default', 'recycle' ),
					            'btn btn-c1' => esc_html__( 'Main Theme Color', 'recycle' ),
					            'btn btn-c2' => esc_html__( 'Secondary Theme Color', 'recycle' ),
					            'btn btn-c3' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
					            'btn btn-black' => esc_html__( 'Black', 'recycle' ),
					            'btn btn-white' => esc_html__( 'White', 'recycle' ),
					        ),
					    ),
					    'btn_size' => array(
					        'type' => 'select',
					        'label' => esc_html__( 'Filter Size', 'recycle' ),
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
 					),
 				), 					
			),
			plugin_dir_path(__FILE__)
		);
	}
	/**
	 * Process the content.
	 *
	 * @param $content
	 * @param $frame
	 *
	 * @return string
	 */
		
    function get_template_name($instance) {
         return 'orion_portfolio_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_portfolio_w', __FILE__, 'orion_portfolio_w');