<?php

/*
Widget Name: (OrionThemes) Static Block
Description: Add Static block content
Author: OrionThemes
Author URI: http://orionthemes.com
*/

if(!function_exists('orion_get_static_blocks')) {
	function orion_get_static_blocks() {
		$block_args = array(
			'posts_per_page'   => -1,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => 'date',
			'order'            => 'DESC',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'static_blocks',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'	   => '',
			'author_name'	   => '',
			'post_status'      => 'publish',
			'suppress_filters' => false 
		);
		$posts_array = get_posts( $block_args ); 

		$static_blocks = array( 'none' => 'None');
		foreach ($posts_array as $block) {
			$id = $block->ID;
			$name = $block->post_title;
			$static_blocks[$id] = $name;
		}
		return $static_blocks;
	}
}

class orion_static_block_w extends SiteOrigin_Widget {

	function __construct() {
		parent::__construct(
			'orion_static_block_w',
			esc_html__('(OrionThemes) Static blocks', 'recycle'),
			array(
				'description' => esc_html__('Add Static block content.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-admin-page',
			),
			array(

			),
			array(
			    'title' => array(
			        'type' => 'text',
			        'label' => esc_html__('Widget Title', 'recycle'),
			    ),						
				'static_block' => array(
					'type' => 'select',
					'label' => esc_html__( 'Choose a static block', 'recycle' ),
					'description' => esc_html__( 'Select a static block.', 'recycle' ),
					'default' => 'all',
					'options' => orion_get_static_blocks()	
				),			 
			),		    				
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_static_block_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_static_block_w', __FILE__, 'orion_static_block_w');