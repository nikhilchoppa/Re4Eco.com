<?php

/*
Widget Name: (OrionThemes) Contact Form 7 Widget
Description: Add a Contact Form
Author: OrionThemes
Author URI: http://orionthemes.com
*/

function orion_get_cf7_forms() {
	$cf7args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'wpcf7_contact_form',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'author_name'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts_array = get_posts( $cf7args ); 

	$all_forms = array();
	foreach ($posts_array as $contact_form) {
		$id = $contact_form->ID;
		$name = $contact_form->post_title;
		$all_forms[$id] = $name;
	}
	return $all_forms;
}

class orion_cf7_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_cf7_w',
			esc_html__('(OrionThemes) Contact Form 7', 'recycle'),
			array(
				'description' => esc_html__('Add a Contact form.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-email-alt',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),						
				'cf7_option' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a contact form', 'recycle' ),
					'description' => esc_html__( 'Select a contact form.', 'recycle' ),
					'default' => 'all',
					'options' => orion_get_cf7_forms()		
				),			 
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_cf7_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_cf7_w', __FILE__, 'orion_cf7_w');