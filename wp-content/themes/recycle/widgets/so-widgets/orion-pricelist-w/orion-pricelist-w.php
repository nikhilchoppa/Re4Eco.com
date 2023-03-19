<?php
/*
Widget Name: (OrionThemes) Price List
Description: Displays Pricelist
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_pricelist_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_pricelist_w',
			esc_html__('(OrionThemes) Price List', 'recycle'),
			array(
				'description' => esc_html__('A customizable price list widget.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-list-view',
			),
			array(

			),
			array(

			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),	    
				'widget_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Service' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a service', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='service_name']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
					    'service_name' => array(
					        'type' => 'text',
					        'label' => esc_html__('Service', 'recycle'),
					        'default' => ''
					    ),
					    'description' => array(
					        'type' => 'tinymce',
					        'label' => esc_html__( 'Description (optional)', 'recycle' ),
					        'rows' => 6
					    ),			    					    
					    'service_price' => array(
					        'type' => 'text',
					        'label' => esc_html__('Price', 'recycle'),
					        'default' => ''
					    ),				    		    
					),
		        ),
				'text_color' => array(
					'type' => 'select',
					'label' => esc_html__( 'Text color style', 'recycle' ),
					'default' => 'text-default',
					'options' => array(
						'text-default' => esc_html__( 'Default', 'recycle' ),
						'text-light' => esc_html__( 'Light text', 'recycle' ),
						'text-dark' => esc_html__( 'Dark text', 'recycle' ),
					)
				),
				'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'service_name_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Service color', 'recycle' ),
					        'default' => ''
					    ),	
						'service_desc_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Description color', 'recycle' ),
					        'default' => ''
					    ),							    				    
						'service_price_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Price color', 'recycle' ),
					        'default' => ''
					    ),	
			        ),
			     ),
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_pricelist_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_pricelist_w', __FILE__, 'orion_pricelist_w');