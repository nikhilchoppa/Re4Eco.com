<?php
// @author: Orion Themes

/********************************************************************/
/*****************         Site Origin panels       *****************/
/********************************************************************/

/*no row bottom margin */
add_action( 'after_setup_theme', 'orion_panel_setup' );

function orion_panel_setup() { 
	add_theme_support( 'siteorigin-panels', array(
		'margin-bottom' => '0',
		'padding-bottom' => '24px',
		'padding-top' => '24px',
	) );
}

/********************************************************************/
/*  						Row attributes							*/
/********************************************************************/
if(!function_exists('orion_orion_custom_row_style_attributes')) {
	function orion_orion_custom_row_style_attributes( $attributes, $args ) {

	    /*Bottom to top parallax*/
	    if (isset($args['background_display']) && $args['background_display'] == 'para-bottom') {
	    	array_push($attributes['class'], 'vertical_up');
	    	array_push($attributes['class'], 'orion-parallax');
	    }
	    /*Bottom to top parallax*/
	    if (isset($args['background_display']) && $args['background_display'] == 'para-top') {
	    	array_push($attributes['class'], 'vertical_down');
	    	array_push($attributes['class'], 'orion-parallax');
	    }	    
	    /*Bottom to top parallax*/
	    if (isset($args['background_display']) && $args['background_display'] == 'para-left') {
	    	array_push($attributes['class'], 'horizontal_left');
	    	array_push($attributes['class'], 'orion-parallax');
	    }
	    /*Bottom to top parallax*/
	    if (isset($args['background_display']) && $args['background_display'] == 'para-right') {
	    	array_push($attributes['class'], 'horizontal_right');
	    	array_push($attributes['class'], 'orion-parallax');
	    }
	    /* Additional style options
	    /*this isn't exactly for parallax, but just a fixed backround*/
	    if (isset($args['background_display']) && $args['background_display'] == 'fixed') {
	    	array_push($attributes['class'], 'fixed-bg');
	    }		  	    	    	    
	    return $attributes;   
	}
}	
add_filter('siteorigin_panels_row_style_attributes', 'orion_orion_custom_row_style_attributes', 1, 2);

if(!function_exists('orion_add_row_stretch_style')) {
	function orion_add_row_stretch_style( $form_options, $fields ) {
		$form_options["row_stretch"]["options"]['padding-5'] = esc_html__('Stretched, with padding ', 'recycle');
		$form_options["row_stretch"]["options"]['standard-no-padding'] = esc_html__('Standard, no padding', 'recycle');
		return $form_options;
	}
}	
add_filter('siteorigin_panels_row_style_fields', 'orion_add_row_stretch_style', 10, 2);
		
if(!function_exists('orion_add_row_bg_styles')) {
	function orion_add_row_bg_styles( $form_options, $fields ) {
		//paralax styles
		$form_options['background_display']['options']['fixed'] = esc_html__('Fixed', 'recycle');
		$form_options['background_display']['options']['para-bottom'] = esc_html__( 'Parallax Top to bottom', 'recycle' );
		$form_options['background_display']['options']['para-top'] = esc_html__( 'Parallax Bottom to top', 'recycle' );
		$form_options['background_display']['options']['para-left'] = esc_html__( 'Parallax Right to left', 'recycle' );
		$form_options['background_display']['options']['para-right'] = esc_html__( 'Parallax Left to right', 'recycle' );

		//additional styles: 
		$form_options['background_display']['options']['cover-center'] = esc_html__( 'Cover and Centered', 'recycle' );
		$form_options['background_display']['options']['right-top'] = esc_html__( 'Align top-right', 'recycle' );
		$form_options['background_display']['options']['center-top'] = esc_html__( 'Align top-center', 'recycle' );
		$form_options['background_display']['options']['center-bottom'] = esc_html__( 'Align bottom-center', 'recycle' );
		$form_options['background_display']['options']['right-bottom'] = esc_html__( 'Align bottom-right', 'recycle' );
		$form_options['background_display']['options']['left-bottom'] = esc_html__( 'Align bottom-left', 'recycle' );
		$form_options['background_display']['options']['left-top'] = esc_html__( 'Align top-left', 'recycle' );
		$form_options['background_display']['options']['responsive-fit'] = esc_html__( 'Responsive Fit', 'recycle' );
		$form_options['background_display']['options']['contain-left'] = esc_html__( 'Contain left', 'recycle' );
		$form_options['background_display']['options']['contain-right'] = esc_html__( 'Contain right', 'recycle' );
		return $form_options;
	}
}	
add_filter('siteorigin_panels_row_style_fields', 'orion_add_row_bg_styles', 10, 2);

/********************************************************************/
/*						Background positions						*/
/********************************************************************/
if(!function_exists('orion_dumprowdata')) {
	function orion_dumprowdata( $attributes, $args ) {
	 
	    if (isset($args['background_display'])) {

	    	$style_css = $attributes["style"];

	    	switch ($args['background_display']) {
	    		case 'right-top':
	    		$style_css .= 'background-position: right top; background-repeat: no-repeat;';
	    			break;
	    		case 'left-top':
	    		$style_css .= 'background-position: left top; background-repeat: no-repeat;';
	    			break;
	    		case 'right-bottom':
	    		$style_css .= 'background-position: right bottom; background-repeat: no-repeat;';
	    			break;
	    		case 'center-bottom':
	    		$style_css .= 'background-position: center bottom; background-repeat: no-repeat;';
	    			break;
	    		case 'center-top':
	    		$style_css .= 'background-position: center top; background-repeat: no-repeat;';
	    			break;		    			 			
	    		case 'left-bottom':
	    		$style_css .= 'background-position: left bottom; background-repeat: no-repeat;';
	    			break;
	    		case 'responsive-fit':
	    		array_push($attributes['class'], 'responsive-fit');
	    			break;
	    		case 'contain-left':
	    		$style_css .= 'background-position: left bottom; background-repeat: no-repeat; background-size:contain;';
	    			break;
	    		case 'contain-right':
	    		$style_css .= 'background-position: right bottom; background-repeat: no-repeat; background-size:contain;';
	    			break;
	    		case 'cover-center':
	    		$style_css .= 'background-position: center center; background-repeat: no-repeat; background-size:cover;';
	    			break;
	    	}
	    	$attributes["style"] = $style_css;
	    }
		return $attributes; 	    
	}
}	
add_filter('siteorigin_panels_row_style_attributes', 'orion_dumprowdata', 20, 2);

/********************************************************************/
/*								Separators							*/
/********************************************************************/

function orion_separator_group( $groups ) {
    $groups['separators'] = array(
    	'name' => esc_html__('Separators', 'recycle'),
   	 	'priority' => 30
    );
    return $groups;
}
add_filter( 'siteorigin_panels_row_style_groups', 'orion_separator_group', 2, 3 );

if(!function_exists('orion_separator_row_style_fields')) {
	function orion_separator_row_style_fields($fields) {

		$fields['separator_top'] = array(
	    	'name' => esc_html__('Top Separator', 'recycle'),
	        'type' => 'select',
	        'group' => 'separators',
	        'description' => esc_html__('Will add a separator to the row.', 'recycle'),
	        'default' => 'none',
	        'options' => array(
	        	'none' => esc_html__( 'No separator', 'recycle' ),
	            'top-svg-1' => esc_html__( 'Arrow', 'recycle' ),
	            'top-svg-2' => esc_html__( 'Half circle', 'recycle' ),
	            'top-svg-3' => esc_html__( 'Arc', 'recycle' ),
	            'top-svg-4' => esc_html__( 'Zigzag', 'recycle' ),
	            'top-svg-5' => esc_html__( 'Small waves', 'recycle' ),
	            'top-svg-6' => esc_html__( 'Lift', 'recycle' ),
	            'top-svg-7' => esc_html__( 'Triangle', 'recycle' ),
	            'top-svg-8' => esc_html__( 'Clouds', 'recycle' ),
	            'top-svg-9' => esc_html__( 'Crack', 'recycle' ),	            
	        ),
	        'priority' =>  '100'
		);
		$fields['separator_top_position'] = array(
	    	'name' => esc_html__('Top Separator position', 'recycle'),
	        'type' => 'select',
	        'group' => 'separators',
	        'description' => esc_html__('Will add a separator to the row.', 'recycle'),
	        'default' => 'top-svg-inside',
	        'options' => array(
	            'top-svg-outside' => esc_html__( 'outside row', 'recycle' ),
	            'top-svg-inside' => esc_html__( 'inside row', 'recycle' ),
	        ),
	        'priority' =>  '101'
		);
		$fields['separator_top_color'] = array(
	    	'name'      => esc_html__('Top Separator color', 'recycle'),
	        'type' 		=> 'color',
	        'group'     => 'separators',
	        'description' => esc_html__('Choose a color', 'recycle'),
	        'priority' =>  '101'
		);		
		$fields['separator_bottom'] = array(
	    	'name'        => esc_html__('Bottom Separator', 'recycle'),
	        'type' => 'select',
	        'group'       => 'separators',
	        'description' => esc_html__('Will add a separator to the row.', 'recycle'),
	        'default' => 'none',
	        'options' => array(
	        	'none' => esc_html__( 'No separator', 'recycle' ),
	            'bottom-svg-1' => esc_html__( 'Arrow', 'recycle' ),
	            'bottom-svg-2' => esc_html__( 'Half circle', 'recycle' ),
	            'bottom-svg-3' => esc_html__( 'Arc', 'recycle' ),
	            'bottom-svg-4' => esc_html__( 'Zigzag', 'recycle' ),
	            'bottom-svg-5' => esc_html__( 'Small waves', 'recycle' ),
	            'bottom-svg-6' => esc_html__( 'Lift', 'recycle' ),
	            'bottom-svg-7' => esc_html__( 'Triangle', 'recycle' ),
	            'bottom-svg-8' => esc_html__( 'Clouds', 'recycle' ),
	            'bottom-svg-9' => esc_html__( 'Crack', 'recycle' ),
	        ),
	        'priority' =>  '102'
		);
		$fields['separator_bottom_position'] = array(
	    	'name'      => esc_html__('Bottom Separator position', 'recycle'),
	        'type' 		=> 'select',
	        'group'     => 'separators',
	        'description' => esc_html__('Will add a separator to the row.', 'recycle'),
	        'default' => 'bottom-svg-inside',
	        'options' => array(
	            'bottom-svg-outside' => esc_html__( 'outside row', 'recycle' ),
	            'bottom-svg-inside' => esc_html__( 'inside row', 'recycle' ),
	        ),
	        'priority' =>  '103'
		);	
		$fields['separator_bottom_color'] = array(
	    	'name'      => esc_html__('Bottom Separator color', 'recycle'),
	        'type' 		=> 'color',
	        'group'     => 'separators',
	        'description' => esc_html__('Choose a color', 'recycle'),
	        'priority' =>  '103'
		);	
	return $fields;
	}
}
add_filter( 'siteorigin_panels_row_style_fields', 'orion_separator_row_style_fields', 10, 2 );

if(!function_exists('orion_custom_row_style_attributes')) {
	function orion_custom_row_style_attributes( $attributes, $args ) {
		if ( (!empty($args['separator_top']) && $args['separator_top']!= 'none') || (!empty($args['separator_bottom']) && $args['separator_bottom']!= 'none' )) {
			array_push($attributes['class'], 'orion-separator');
		}
	    if( !empty( $args['separator_top'] ) && ($args['separator_top']!= 'none') ) {
	        array_push($attributes['class'], $args['separator_top']);
	        array_push($attributes['class'], $args['separator_top_position']);
	    } 
	    if( !empty( $args['separator_bottom'] ) && ($args['separator_bottom']!= 'none') ) {   
	        array_push($attributes['class'], $args['separator_bottom']);
	        array_push($attributes['class'], $args['separator_bottom_position']);
	    }
	    if( !empty( $args['separator_bottom_color'] ) && ($args['separator_bottom_color']!= 'none') ) {   
	        $attributes['data-svg-bottom-color'] = $args['separator_bottom_color'];	        
	    }
	    if( !empty( $args['separator_top_color'] ) && ($args['separator_top_color']!= 'none') ) {   
	        $attributes['data-svg-top-color'] = $args['separator_top_color'];
	    }
	    return $attributes;
	}
}	
add_filter('siteorigin_panels_row_style_attributes', 'orion_custom_row_style_attributes', 10, 2);

/********************************************************************/
/*							Responsive options  					*/
/********************************************************************/
if(!function_exists('orion_responsive_group')) {
	function orion_responsive_group( $groups ) {
	    $groups['responsive'] = array(
	    	'name' => esc_html__('Responsive options', 'recycle'),
	   	 	'priority' => 31
	    );
	    return $groups;
	}
}
add_filter( 'siteorigin_panels_row_style_groups', 'orion_responsive_group', 2, 3 );
add_filter('siteorigin_panels_widget_style_groups', 'orion_responsive_group', 2, 3);

if(!function_exists('orion_responsive_row_style_fields_responsive_options')) {
	function orion_responsive_row_style_fields_responsive_options($fields) {
		$fields['mobile'] = array(
		    	'name'        => esc_html__('Mobile display', 'recycle'),
		        'type' => 'select',
		        'group'       => 'responsive',
		        'description' => esc_html__('Defines behaviour of the row on small (mobile) displays.', 'recycle'),
		        'default' => 'mobile-1-in-row',
		        'options' => array(
		        	'mobile-default' => esc_html__( 'Default', 'recycle' ),
		        	'mobile-1-in-row' => esc_html__( '1 column (default)', 'recycle' ),
		            'mobile-2-in-row' => esc_html__( '2 columns', 'recycle' ),
		            'hidden-xs' => esc_html__( 'Hide', 'recycle' ),
		        ),
		        'priority' =>  '100'
		);
		$fields['tablet'] = array(
		    	'name'      => esc_html__('Tablet display', 'recycle'),
		        'type' 		=> 'select',
		        'group'     => 'responsive',
		        'description' => esc_html__('Defines behaviour of the row on medium size devices.', 'recycle'),
		        'default' => 'tablet-default',
		        'options' => array(
		            'tablet-default' => esc_html__( 'Default', 'recycle' ),
		            'tablet-1-in-row' => esc_html__( '1 column', 'recycle' ),
		            'tablet-2-in-row' => esc_html__( '2 column', 'recycle' ),
		            'tablet-3-in-row' => esc_html__( '3 column', 'recycle' ),
		            'tablet-4-in-row' => esc_html__( '4 column', 'recycle' ),
		            'hidden-sm' => esc_html__( 'Hide', 'recycle' ),
		        ),
		        'priority' =>  '101'
		);
		$fields['desktop'] = array(
		    	'name'      => esc_html__('Desktop display', 'recycle'),
		        'type' 		=> 'select',
		        'group'     => 'responsive',
		        'description' => esc_html__('Defines behaviour of the row on Desktop devices.', 'recycle'),
		        'default' => 'desktop-default',
		        'options' => array(
		            'desktop-default' => esc_html__( 'Default', 'recycle' ),
		            'desktop-1-in-row' => esc_html__( '1 column', 'recycle' ),
		            'desktop-2-in-row' => esc_html__( '2 column', 'recycle' ),
		            'desktop-3-in-row' => esc_html__( '3 column', 'recycle' ),
		            'desktop-4-in-row' => esc_html__( '4 column', 'recycle' ),
		            'hidden-md-lg' => esc_html__( 'Hide', 'recycle' ),
		        ),
		        'priority' =>  '101'
		);		
		$fields['full_width_small'] = array(
		  'name'        => esc_html__('Remove margins on mobile devices', 'recycle'),
		  'type'        => 'checkbox',
		  'group'       => 'responsive',
		  'description' => esc_html__('Stretches the content on small devices.', 'recycle'),
		  'priority'    => 102,
		);
		$fields['full_width_tablets'] = array(
		  'name'        => esc_html__('Remove margins on tablets', 'recycle'),
		  'type'        => 'checkbox',
		  'group'       => 'responsive',
		  'description' => esc_html__('Stretches the content on Tablets.', 'recycle'),
		  'priority'    => 102,
		);

		return $fields;
	}
}
add_filter( 'siteorigin_panels_row_style_fields', 'orion_responsive_row_style_fields_responsive_options', 10, 2 );

if(!function_exists('orion_widget_hide_on_mobile_checkbox')) {
	function orion_widget_hide_on_mobile_checkbox($fields) {
		$fields['hide_mobile'] = array(
		  'name'        => esc_html__('Hide on Mobile', 'recycle'),
		  'type'        => 'checkbox',
		  'group'       => 'responsive',
		  'description' => esc_html__('Check to hide widget on mobile.', 'recycle'),
		  'priority'    => 101,
		);
		return $fields;
	}
}
add_filter( 'siteorigin_panels_widget_style_fields', 'orion_widget_hide_on_mobile_checkbox', 10, 2);

if(!function_exists('orion_hide_widget_mobile')) {
	function orion_hide_widget_mobile( $attributes, $args ) {

		if (!empty($args['hide_mobile']) && $args['hide_mobile'] == true) {
			$add_class = 'hidden-sm';
			$add_class = 'hidden-xs';
			
			$attributes['class'][] = $add_class;
		}
		return $attributes;

	}
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_hide_widget_mobile', 10, 2);


if(!function_exists('orion_custom_row_style_attributes_responsive_options')) {
	function orion_custom_row_style_attributes_responsive_options( $attributes, $args ) {
		if (!empty($args['tablet']) && $args['tablet']!= 'none') {
			array_push($attributes['class'], $args['tablet']);
		}
		if (!empty($args['mobile']) && $args['mobile']!= 'none') {
			array_push($attributes['class'], $args['mobile']);
		}
		if (!empty($args['desktop']) && $args['desktop']!= 'none') {
			array_push($attributes['class'], $args['desktop']);
		}		
		if (!empty($args['full_width_small']) && $args['full_width_small']== 'true') {
			array_push($attributes['class'], 'full-width-on-small-devices');
		}
		if (!empty($args['full_width_tablets']) && $args['full_width_tablets']== 'true') {
			array_push($attributes['class'], 'full-width-on-tablets');
		}		
	    return $attributes;
	}
}	
add_filter('siteorigin_panels_row_style_attributes', 'orion_custom_row_style_attributes_responsive_options', 10, 2);

/********************************************************************/
/*						END Responsive options  					*/
/********************************************************************/


/********************************************************************/
/*						Row Position  								*/
/********************************************************************/

if(!function_exists('orion_row_position')) {
	function orion_row_position($fields) {

		$fields['row_position'] = array(
	    	'name'      => esc_html__('Row Position', 'recycle'),
	        'type' 		=> 'select',
	        'group'     => 'layout',
	        'description' => esc_html__('Change row position.', 'recycle'),
	        'default' => 'default',
	        'options' => array(
	            'default' => esc_html__( 'Default', 'recycle' ),
	            'push-up-row' => esc_html__( 'Push up 100%', 'recycle' ),		            
	            'row-divide' => esc_html__( 'Push up 50%', 'recycle' ),
	            'push-up-120' => esc_html__( 'Push up 120px', 'recycle' ),
	            'push-up-60' => esc_html__( 'Push up 60px', 'recycle' ),
	        ),
	        'priority' =>  100,
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_row_style_fields', 'orion_row_position', 10, 2);

function orion_row_position_class( $attributes, $args ) {
    if( !empty( $args['row_position'] ) && $args['row_position'] != 'default' ) {
        array_push($attributes['class'], $args['row_position']);
    }
    return $attributes;
}

add_filter('siteorigin_panels_row_style_attributes', 'orion_row_position_class', 10, 2);

/********************************************************************/
/*						Equal Height  								*/
/********************************************************************/
/* new */

if(!function_exists('orion_equal_height_layout_options')) {
	function orion_equal_height_layout_options($fields) {
		$fields['cell_alignment']['options']['equal_height'] = esc_html__( 'Equal Height', 'recycle' );
		return $fields;
	}
}
add_filter('siteorigin_panels_row_style_fields', 'orion_equal_height_layout_options', 10, 2);

function orion_equal_height_class_layout( $attributes, $args ) {
    if( !empty( $args['cell_alignment'] ) && $args['cell_alignment'] == 'equal_height' ) {
        array_push($attributes['class'], 'orion-equal-height');
    }
    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_equal_height_class_layout', 10, 2);

/* end new */
/* left for backward compatibility */
function orion_equal_height_class( $attributes, $args ) {
    if( !empty( $args['equal_height'] ) && $args['equal_height'] != 'default' ) {
        array_push($attributes['class'], $args['equal_height']);
    }
    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_equal_height_class', 10, 2);


// commented out, but left for compatibility reasons.
// if(!function_exists('orion_equal_height_options')) {
// 	function orion_equal_height_options($fields) {

// 		$fields['equal_height'] = array(
// 	    	'name'      => esc_html__('Vertical alignment', 'recycle'),
// 	        'type' 		=> 'select',
// 	        'group'     => 'layout',
// 	        'description' => esc_html__('Set specific behaviour of widgets in this row.', 'recycle'),
// 	        'default' => 'default',
// 	        'options' => array(
// 	            'default' => esc_html__( 'Align to top', 'recycle' ),
// 	            'middle_align' => esc_html__( 'Middle align', 'recycle' ),		            
// 	            'bottom_align' => esc_html__( 'Align to bottom', 'recycle' ),
// 	            'orion-equal-height' => esc_html__( 'Equal Height', 'recycle' ),
// 	        ),
// 	        'priority' =>  102,
// 		);
// 		return $fields;
// 	}
// }
// commented out, but left for compatibility reasons.
// add_filter('siteorigin_panels_row_style_fields', 'orion_equal_height_options', 10, 2);

// function orion_equal_height_class( $attributes, $args ) {
//     if( !empty( $args['equal_height'] ) && $args['equal_height'] != 'default' ) {
//         array_push($attributes['class'], $args['equal_height']);
//     }
//     return $attributes;
// }
// commented out, but left for compatibility reasons.
// add_filter('siteorigin_panels_row_style_attributes', 'orion_equal_height_class', 10, 2);

/********************************************************************/
/*						Full screen option 	(row)					*/
/********************************************************************/

function orion_fullscreen_checkbox($fields) {
  $fields['full_screen'] = array(
      'name'        => esc_html__('Full screen row height', 'recycle'),
      'type'        => 'checkbox',
      'group'       => 'layout',
      'description' => esc_html__('Set height of the row to height of the screen.', 'recycle'),
      'priority'    => 101,
  );
  return $fields;
}
add_filter( 'siteorigin_panels_row_style_fields', 'orion_fullscreen_checkbox', 10, 2);

function orion_fullscreen_layout( $attributes, $args ) {
    if( !empty( $args['full_screen'] ) && $args['full_screen'] == '1' ) {
        array_push($attributes['class'], 'full-screen-row');
    }
    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_fullscreen_layout', 10, 2);

/********************************************************************/
/*						text color / rows   						*/
/********************************************************************/

if(!function_exists('orion_row_text_style')) {
	function orion_row_text_style($fields) {

		$fields['text_style'] = array(
	    	'name'      => esc_html__('Text color', 'recycle'),
	        'type' 		=> 'select',
	        'group'     => 'design',
	        'description' => esc_html__('Text color.', 'recycle'),
	        'default' => 'default',
	        'options' => array(
	            'default' => esc_html__( 'Default', 'recycle' ),
	            'text-dark' => esc_html__( 'Dark text', 'recycle' ),
	            'text-light' => esc_html__( 'Light text', 'recycle' ),
	        ),
	        'priority' =>  '101'
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_row_style_fields', 'orion_row_text_style', 10, 2);

function orion_row_text_style_class( $attributes, $args ) {
    if( !empty( $args['text_style'] ) && $args['text_style'] != 'default' ) {
        array_push($attributes['class'], $args['text_style']);
    }
    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_row_text_style_class', 10, 2);

/********************************************************************/
/*						text color / Widget  						*/
/********************************************************************/

add_filter('siteorigin_panels_widget_style_fields', 'orion_row_text_style', 10);

function orion_cell_text_style_class( $attributes, $args) {
	if (!empty($args["text_style"])) {
		$add_class = $args["text_style"];
		$attributes['class'][] = $add_class;
	}
	return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_cell_text_style_class', 20, 2);


/********************************************************************/
/*						Center on mobile / Widget  						*/
/********************************************************************/

if(!function_exists('orion_text_center_on_mobile')) {
	function orion_text_center_on_mobile($fields) {

		$fields['center_on_mobile'] = array(
		    	'name'      => esc_html__('Align to center on Mobile', 'recycle'),
		        'type' 		=> 'checkbox',
		        'group'     => 'responsive',
		        'default' => false,
		        'priority' =>  '101'
		);
		$fields['center_on_tablets'] = array(
		    	'name'      => esc_html__('Align to center on Tablets', 'recycle'),
		        'type' 		=> 'checkbox',
		        'group'     => 'responsive',
		        'default' => false,
		        'priority' =>  '101'
		);		
		return $fields;
	}
}
add_filter('siteorigin_panels_widget_style_fields', 'orion_text_center_on_mobile', 10, 2);

function orion_text_center_mobile_html_class( $attributes, $args ) {
    if( !empty($args['center_on_mobile']) && $args['center_on_mobile'] == true ) {
	    $attributes['class'][] = 'mobile-text-center';
    }
    if( !empty($args['center_on_tablets']) && $args['center_on_tablets'] == true ) {
	    $attributes['class'][] = 'tablets-text-center';
    }    
    return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_text_center_mobile_html_class', 11, 2);


/********************************************************************/
/*					shadows and borders / Widget  					*/
/********************************************************************/

if(!function_exists('orion_widget_shadow')) {
	function orion_widget_shadow($fields) {

		$fields['widget_shadow'] = array(
		    	'name'      => esc_html__('Drop Shadow Effect', 'recycle'),
		        'type' 		=> 'select',
		        'group'     => 'design',
		        'description' => esc_html__('Add shadow to an element.', 'recycle'),
		        'default' => 'none',
		        'options' => array(
		            'none' => esc_html__( 'None', 'recycle' ),
		            'shadow-1' => esc_html__( 'Raised Box', 'recycle' ),
		            'shadow-2' => esc_html__( 'Lifted Corners', 'recycle' ),
		            'shadow-3' => esc_html__( 'Horizontal Curves', 'recycle' ),
		        ),
		        'priority' =>  '101'
		);

		$fields['widget_border_radius'] = array(
		    	'name'      => esc_html__('Border radius', 'recycle'),
		        'type' => 'measurement',
		        'group'     => 'design',
		        'label' => esc_html__( 'Add rounded quarners', 'recycle' ),
		        'priority' =>  '15'
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_widget_style_fields', 'orion_widget_shadow', 10, 2);

function orion_cell_shadow_class( $attributes, $args) {
	if (!empty($args["widget_shadow"]) && $args["widget_shadow"]!= 'none') {
		$add_class = $args["widget_shadow"];
		$attributes['class'][] = $add_class;
	}
	if (!empty($args["widget_border_radius"]) && $args["widget_border_radius"] != 0) {
		$style_css = $attributes["style"];
		$style_css .= 'border-radius:' .$args["widget_border_radius"] .';';
		$attributes["style"] = $style_css;
	}	
	return $attributes;
}

add_filter('siteorigin_panels_widget_style_attributes', 'orion_cell_shadow_class', 20, 2);

/********************************************************************/
/*						remove cell side padding					*/
/********************************************************************/
if(!function_exists('orion_remove_side_padding_mobile')) {
	function orion_remove_side_padding_mobile($fields) {

		$fields['remove_padding_mobile'] = array(
	    	'name'      => esc_html__('Remove side padding on Mobile devices', 'recycle'),
	        'type' 		=> 'checkbox',
	        'group'     => 'responsive',
	        'default' => false,
	        'priority' =>  '101'
		);
		$fields['remove_margin_mobile'] = array(
	    	'name'      => esc_html__('Remove side margin on small devices', 'recycle'),
	        'type' 		=> 'checkbox',
	        'group'     => 'layout',
	        'default' => false,
	        'priority' =>  '101'
		);			
		return $fields;
	}
}
add_filter('siteorigin_panels_widget_style_fields', 'orion_remove_side_padding_mobile', 10, 2);

function orion_remove_side_padding_mobile_html_class( $attributes, $args ) {
    if( !empty($args['remove_padding_mobile']) && $args['remove_padding_mobile'] == true ) {
	    $attributes['class'][] = 'remove-padding-mobile';
    }
    if( !empty($args['remove_margin_mobile']) && $args['remove_margin_mobile'] == true ) {
	    $attributes['class'][] = 'remove-margin-mobile';
    }        
    return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_remove_side_padding_mobile_html_class', 11, 2);

/********************************************************************/
/*						Absolute positions 							*/
/********************************************************************/

if(!function_exists('orion_widget_absolute_position')) {
	function orion_widget_absolute_position($fields) {
		
		$fields['absolute'] = array(
		    	'name'      => esc_html__('Overlap Row', 'recycle'),
		        'type' 		=> 'select',
		        'group'     => 'layout',
		        'default' => '',
		        'options' => array(
		            '' => esc_html__( 'None', 'recycle' ),
		            'absolute-bottom-left' => esc_html__( 'Left', 'recycle' ),
		            'absolute-bottom-center' => esc_html__( 'Center', 'recycle' ),
		            'absolute-bottom-right' => esc_html__( 'right', 'recycle' ),
		        ),
		        'priority' =>  '111'
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_widget_style_fields', 'orion_widget_absolute_position', 10, 2);

function orion_widget_absolute_position_class( $attributes, $args ) {
    if( !empty($args['absolute']) && $args['absolute'] != '' ) {
	    $attributes['class'][] = 'absolute-bottom';
	    $attributes['class'][] = $args['absolute'];
    }
    return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_widget_absolute_position_class', 11, 2);


/********************************************************************/
/*						Panel Row overlay 							*/
/********************************************************************/

if(!function_exists('orion_row_overlay')) {
	function orion_row_overlay($fields) {

		$fields['row_overlay'] = array(
		    	'name'      => esc_html__('Overlay', 'recycle'),
		        'type' 		=> 'select',
		        'group'     => 'design',
		        'description' => esc_html__('Lighten or Darken background.', 'recycle'),
		        'default' => 'default',
		        'options' => array(
		            'default' => esc_html__( 'None', 'recycle' ),
		            'overlay-dark' => esc_html__( 'Dark Overlay', 'recycle' ),
		            'overlay-light' => esc_html__( 'Light Overlay', 'recycle' ),
		            'overlay-c1' => esc_html__( 'Main theme color', 'recycle' ),
		            'overlay-c2' => esc_html__( 'Secondary theme color', 'recycle' ),
		            'overlay-c3' => esc_html__( 'Tertiary theme color', 'recycle' ),
		            'overlay-c2-c1' => esc_html__( 'Gradient 1', 'recycle' ),		            
		            'overlay-c1-c2' => esc_html__( 'Gradient 2', 'recycle' ),
		            'overlay-c1-t' => esc_html__( 'Primary to Transparent', 'recycle' ),
		            'overlay-c2-t' => esc_html__( 'Secondary to Transparent', 'recycle' ),
		            'overlay-c3-t' => esc_html__( 'Tertiary to Transparent', 'recycle' ),
		        ),
		        'priority' =>  '10'
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_row_style_fields', 'orion_row_overlay', 10, 2);

function orion_row_overlay_html_class( $attributes, $args ) {

    if( !empty( $args['row_overlay'] ) && $args['row_overlay'] != 'default' ) {
        array_push($attributes['class'], $args['row_overlay']);
    }
    return $attributes;
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_row_overlay_html_class', 10, 2);

/********************************************************************/
/*						Cell BG Opacity 							*/
/********************************************************************/

if(!function_exists('orion_bg_opacity_field')) {
	function orion_bg_opacity_field($fields) {

		$fields['bg_opacity'] = array(
		    	'name'      => esc_html__('Background opacity', 'recycle'),
		        'type' 		=> 'text',
		        'group'     => 'design',
		        'description' => esc_html__('Must be a number between 1 and 100. 1 is almost transparent, 100 is opaque.', 'recycle'),
		        'default' => 100,
		        'priority' =>  '5'
		);
		return $fields;
	}
}
add_filter('siteorigin_panels_widget_style_fields', 'orion_bg_opacity_field', 10, 2);

function orion_cell_bg_color( $attributes, $args) {

	if (!empty($args['background']) && !empty($args['bg_opacity']) && intval($args['bg_opacity']) > 0 && intval($args['bg_opacity']) < 100 ) {
		preg_match("/background-color:(.*?);/", $attributes["style"], $preg_match_result);
		if( count( $preg_match_result ) > 0 ) {
			// get color:
	        $color_to_replace = $preg_match_result[1];
			$opacity_100 = intval(preg_replace('/[^0-9]+/', '', $args['bg_opacity']), 10);

			if( count( $opacity_100 ) > 0 ) {
				if ($opacity_100 != '' && $opacity_100 != '0') {
					$opacity = intval($opacity_100) / 100;
				} else {
					$opacity = 100;
				}
				$color_rgba = orion_hextorgba($color_to_replace, $opacity);

		        // set background color with rgba value
		        $attributes["style"] = str_replace('background-color:' . $color_to_replace, 'background-color:'.$color_rgba, $attributes["style"]);
			}
	    }
	}
	return $attributes;
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_cell_bg_color', 1, 2);

/* changing rendered css */
if(!function_exists('orion_cell_bg_color_2')) {
	function orion_cell_bg_color_2 ($layout_data, $post_id) {
		if (is_array($layout_data)){
		foreach ($layout_data as $key => $row) {
			if (is_array($row)){
			foreach ($row['cells'] as $cellkey => $widgets) {
				if (is_array($widgets)){
				foreach ($widgets['widgets'] as $widgetkey => $data) {
					if (count($data) > 0 && isset($data['panels_info']['style']['bg_opacity']) && isset($data['panels_info']['style']['background'])) {
						
						$bg_opacity = $data['panels_info']['style']['bg_opacity'];
						$color_to_replace = $data['panels_info']['style']['background'];
						if(intval($bg_opacity) > 0 && intval($bg_opacity) < 100 ) {
							$bg_opacity = intval($bg_opacity)/100;

							$new_color = orion_hextorgba($color_to_replace, $bg_opacity);

							$layout_data[$key]['cells'][$cellkey]['widgets'][$widgetkey]['panels_info']['style']['background'] = $new_color;
						}	
					}
				}
				}
			}
			}
		}
		}
		return $layout_data;
	}
}

// add_filter('siteorigin_panels_layout_data', 'orion_cell_bg_color_2', 10, 2);


/********************************************************************/
/*						basic widget class  						*/
/********************************************************************/

function orion_panels_cell( $attributes, $args ) {
	array_push($attributes['class'], 'orion');
	return $attributes; 
}
add_filter('siteorigin_panels_widget_style_attributes', 'orion_panels_cell', 10, 2);

/********************************************************************/
/*				Remove SO premium refferences  						*/
/********************************************************************/

add_filter( 'siteorigin_premium_upgrade_teaser', '__return_false' );

/********************************************************************/
/*				add a field multiple media upload					*/
/********************************************************************/

// experimental features
$orion_experimental = false;

function orion_widgets_collection_folder($folders){
	$folders[] = get_template_directory(). '/framework/so-fields/';
	return $folders;
} 

function orion_fields_class_prefixes( $class_prefixes ) {
	$class_prefixes[] = 'Orion_';
	return $class_prefixes;
}

function orion_fields_class_paths( $class_paths ) {
	$class_paths[] = get_template_directory(). '/framework/so-fields/';
	return $class_paths;
}

if ($orion_experimental == true) {
	add_filter('siteorigin_widgets_widget_folders', 'orion_widgets_collection_folder');
	add_filter('siteorigin_widgets_field_class_prefixes', 'orion_fields_class_prefixes');
	add_filter('siteorigin_widgets_field_class_paths', 'orion_fields_class_paths');
}

/********************************************************************/
/*						Force Collapse on medium screens			*/
/********************************************************************/

if(!function_exists('force_collapse_medium')) {
	function force_collapse_medium($form_options, $fields) {
	$form_options["collapse_behaviour"]["options"]["collapse_below_lg"] = esc_html__('Force Collapse on medium screens', 'recycle');
		return $form_options;
	}
}
add_filter('siteorigin_panels_row_style_fields', 'force_collapse_medium', 10, 2);

/* collapse if not screen-lg */
if(!function_exists('orion_collapse_lg_row_style_attributes')) {
	function orion_collapse_lg_row_style_attributes( $attributes, $args ) {
		
		if (!empty($args["collapse_behaviour"]) && $args['collapse_behaviour'] == 'collapse_below_lg') {
		array_push( $attributes['class'], 'orion-collapse-below-lg');
		}
	    return $attributes;
	}
}	
add_filter('siteorigin_panels_row_style_attributes', 'orion_collapse_lg_row_style_attributes', 10, 2);


/********************************************************************/
/*						SO settings 	  							*/
/********************************************************************/

// Add recycle Widgets to Siteorigin Panels
function orion_add_widget_tabs_to_siteorigin ($tabs) {
    $tabs[] = array(
        'title' => esc_html__('OrionThemes', 'recycle'),
        'filter' => array(
            'groups' => array('recycle')
        )
    );

    return $tabs;
}
add_filter('siteorigin_panels_widget_dialog_tabs', 'orion_add_widget_tabs_to_siteorigin', 10);