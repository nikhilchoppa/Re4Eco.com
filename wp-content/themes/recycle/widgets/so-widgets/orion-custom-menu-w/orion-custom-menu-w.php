<?php

/*
Widget Name: (OrionThemes) Custom Menu Widget
Description: Add a stylized custom menu widget
Author: OrionThemes
Author URI: http://orionthemes.com
*/

function orion_get_all_wordpress_menus(){
	$all_menus = array();
	$term_args = array('taxonomy' => 'nav_menu');
	$term_query = new WP_Term_Query( $term_args );
	if ( ! empty( $term_query->terms ) ) {
	    foreach ( $term_query ->terms as $term ) {
	        $id = $term->term_id;
	        $name = $term->name;
	        $all_menus[$id] = $name;
	    }
	}
	return $all_menus;
}
class orion_custom_menu_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_custom_menu_w',
			esc_html__('(OrionThemes) Custom Menu Widget', 'recycle'),
			array(
				'description' => esc_html__('Display a Menu.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-menu',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),						
				'menu_option' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a menu', 'recycle' ),
					'description' => esc_html__( 'Select a menu.', 'recycle' ),
					'default' => 'all',
					'options' => orion_get_all_wordpress_menus()
				),			 
			   'style_section' => array(
			        'type' => 'section',
			        'label' => esc_html__( 'Settings' , 'recycle' ),
			        'hide' => true,
			        'fields' => array(
						'text_color_class' => array(
							'type' => 'select',
							'label' => esc_html__( 'Text color style', 'recycle' ),
							'default' => 'text-light',
							'options' => array(
							'text-light' => esc_html__( 'Light text', 'recycle' ),
							'text-dark' => esc_html__( 'Dark text', 'recycle' ),
							)
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
					),
				), 				
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_custom-menu_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_custom_menu_w', __FILE__, 'orion_custom_menu_w');