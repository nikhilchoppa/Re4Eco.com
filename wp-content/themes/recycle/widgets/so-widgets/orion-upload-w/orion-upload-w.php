<?php
 
/*
Widget Name: (OrionThemes) Document Download
Description: Displays Document Download button
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_upload_w extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'orion_upload_w',
			esc_html__('(OrionThemes) Document Download', 'recycle'),
			array(
				'description' => esc_html__('A customizable document download widget.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-paperclip',
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
			        'label' => esc_html__( 'Add Document' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add a document', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='document_name']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
					    'document_name' => array(
					        'type' => 'text',
					        'label' => esc_html__('Document Title', 'recycle'),
					        'default' => ''
					    ),
						'document_icon' => array(
						    'type' => 'icon',
						    'label' => esc_html__('Icon', 'recycle'),
						),					    
						'document_upload' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Upload a document', 'recycle' ),
					        'choose' => esc_html__( 'Choose a document', 'recycle' ),
					        'update' => esc_html__( 'Upload a document', 'recycle' ),
					        'library' => 'application',
					        'fallback' => true
						),
					),
		        ),	        
			    'btn_color' => array(
			        'type' => 'select',
			        'label' => esc_html__( 'Button Color', 'recycle' ),
			        'default' => 'btn',
			        'options' => array(
			            'btn' => esc_html__( 'Default', 'recycle' ),
			            'btn btn-c1' => esc_html__( 'Main Theme Color', 'recycle' ),
			            'btn btn-c2' => esc_html__( 'Secondary Theme Color', 'recycle' ),
			            'btn btn-c3' => esc_html__( 'Tertiary Theme Color', 'recycle' ),
			            'btn btn-blue' => esc_html__( 'Blue', 'recycle' ),
			            'btn btn-green' => esc_html__( 'Green', 'recycle' ),
			            'btn btn-pink' => esc_html__( 'Pink', 'recycle' ),
			            'btn btn-yellow' => esc_html__( 'Yellow', 'recycle' ),
			            'btn btn-red' => esc_html__( 'Red', 'recycle' ),
			            'btn btn-orange' => esc_html__( 'Orange', 'recycle' ),
			            'btn btn-black' => esc_html__( 'Black', 'recycle' ),
			            'btn btn-white' => esc_html__( 'White', 'recycle' ),			            
			        ),
			    ),
		        'text_color' => array(
					'type' => 'select',
					'label' => esc_html__('Widget Title Color', 'recycle'),	
				    'options' => array(
				    	'text-default'	=> esc_html__('Default', 'recycle'),
				    	'text-dark'	=> esc_html__('Dark', 'recycle'),
				    	'text-light'	=> esc_html__('Light', 'recycle'),			    	
		       		),
				    'default' => 'text-default',		
		       	),			    		    
			    'btn_type' => array(
			        'type' => 'select',
			        'label' => esc_html__( 'Button Style', 'recycle' ),
			        'default' => 'btn-flat',
			        'options' => array(
			            'btn-flat' => esc_html__( 'Flat', 'recycle' ),
			            'btn-wire' => esc_html__( 'Wire', 'recycle' ),
			        ),
			    ),
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_upload_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_upload_w', __FILE__, 'orion_upload_w');