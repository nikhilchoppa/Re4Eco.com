<?php

/*
Widget Name: (OrionThemes) Icon With Text
Description: Displays Icon with some text
Author: OrionThemes
Author URI: http://orionthemes.com
*/

class orion_icon_text_w extends SiteOrigin_Widget {

	function __construct() {
		$main_theme_color = orion_get_theme_option_css('main_theme_color', '#22AA86' );

		parent::__construct(
			'orion_icon_text_w',
			esc_html__('(OrionThemes) Icon With Text', 'recycle'),
			array(
				'description' => esc_html__('A customizable icon with text widget.', 'recycle'),
				'panels_groups' => array('recycle'),
				'panels_icon' => 'orion dashicons dashicons-visibility',
			),
			array(

			),
			array(
    
				'icon_repeater' => array(
			        'type' => 'repeater',
			        'label' => esc_html__( 'Add Icon with text' , 'recycle' ),
			        'item_name'  => esc_html__( 'Click to add an Icon', 'recycle' ),
			        'item_label' => array(
			            'selector'     => "[id*='icon_title']",
			            'update_event' => 'change',
			            'value_method' => 'val'
			        ),
		        	'fields' => array(
						'the_icon' => array(
						    'type' => 'icon',
						    'label' => esc_html__('Select an icon', 'recycle'),
						),
					    'custom_image_file' => array(
					        'type' => 'media',
					        'label' => esc_html__( 'Or choose an image', 'recycle' ),
					        'choose' => esc_html__( 'Choose image', 'recycle' ),
					        'update' => esc_html__( 'Set image', 'recycle' ),
					         'description' => esc_html__('setting the image will override the icon field', 'recycle'),
					        'library' => 'image',
					        'fallback' => false
					    ),					    
					    'icon_title' => array(
					        'type' => 'text',
					        'label' => esc_html__('Icon Title', 'recycle'),
					        'default' => ''
					    ),
						'description' => array(
					        'type' => 'textarea',
					        'label' => esc_html__( 'Description', 'recycle' ),
					        'rows' => 4
					    ),
					    'icon_link' => array(
					        'type' => 'link',
					        'label' => esc_html__('Destination URL', 'recycle'),
					        'description' => esc_html__('Optionally add a link', 'recycle'),
					    ),
					    'link_new_tab' => array(
					        'type' => 'checkbox',
					        'label' => esc_html__( 'Open in new tab', 'recycle' ),
					        'default' => false,
					    ),
						'icon_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Icon color', 'recycle' ),
					        'default' => '#fff'
					    ),			    
						'icon_bg_color' => array(
					        'type' => 'color',
					        'label' => esc_html__( 'Icon container background', 'recycle' ),
					        'default' => $main_theme_color,
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
		       		),
				    'default' => 1,
		       	),
		        'style' => array(
					'type' => 'select',
					'label' => esc_html__('Widget Style', 'recycle'),	
				    'options' => array(
						'short'	=> esc_html__('Icon Aside', 'recycle'),
				    	'long'	=> esc_html__('Title on top', 'recycle'),
				    	'icon-top'	=> esc_html__('Large icon on top', 'recycle'),
		       		),
				    'default' => 'short',
		       	),
		        'icon_style' => array(
					'type' => 'select',
					'label' => esc_html__('Icon Container', 'recycle'),	
				    'options' => array(
						'circle' => esc_html__('Circle', 'recycle'),
				    	'square'	=> esc_html__('Square', 'recycle'),
				    	'simple'	=> esc_html__('none', 'recycle'),
		       		),
				    'default' => 'square',		
		       	),	
		        'text_style' => array(
					'type' => 'select',
					'label' => esc_html__('Text color', 'recycle'),	
				    'options' => array(
				    	'text-default'	=> esc_html__('Default', 'recycle'),
						'text-light'	=> esc_html__('Light', 'recycle'),
				    	'text-dark'	=> esc_html__('Dark', 'recycle'),
		       		),
				    'default' => 'text-default',		
		       	),
		        'alignment' => array(
					'type' => 'select',
					'label' => esc_html__('Alignment', 'recycle'),	
				    'options' => array(
				    	''	=> esc_html__('Default', 'recycle'),
						'text-left'	=> esc_html__('Left', 'recycle'),
						'text-center'	=> esc_html__('Center', 'recycle'),
						'text-right'	=> esc_html__('Right', 'recycle'),
		       		),
				    'default' => 'text-default',		
		       	),
			    'bottom_margin' => array(
			        'type' => 'slider',
			        'label' => esc_html__( 'Bottom Margin', 'recycle' ),
			        'default' => 36,
			        'min' => 0,
			        'max' => 120,
			        'integer' => true
			    ),
			    'align_icons_center_mobile' =>  array(
			        'type' => 'checkbox',
			        'label' => esc_html__( 'Center on mobile', 'recycle' ),
			        'default' => false
			    ),	        
			),
			plugin_dir_path(__FILE__)
		);
	}

    function get_template_name($instance) {
         return 'orion_icon_text_w-template';
    }
	function get_template_dir($instance) {
	    return 'tpl';
	}
    function get_style_name($instance) {
        return '';
    }
}

siteorigin_widget_register('orion_icon_text_w', __FILE__, 'orion_icon_text_w');