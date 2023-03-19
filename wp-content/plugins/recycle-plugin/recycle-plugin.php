<?php
/*
Plugin Name: Recycle Theme Plugin
Plugin URI: http://orionthemes.com
Description: Provides features used in Recycle Theme
Author: OrionThemes
Version: 1.7
Author URI: http://www.orionthemes.com
*/

if(!defined('WPINC')) {
    die;
}

// Load the plugin update checker
require 'plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'http://downloads.orionthemes.com/recycle/recycle_plugin_1_5/update.json',
    __FILE__
);

/* debugging and development */
/* set to false for production */
function orion_debug() {
    return true;
}
/* set to false for production */
function orion_devel() {
    return true;
}

/* helper functions */
// Load the embedded Redux Framework
if ( file_exists( dirname( __FILE__ ).'/helpers.php' ) ) {
    require_once dirname(__FILE__).'/helpers.php';
}
// Create post types
if ( file_exists( dirname( __FILE__ ).'/post_types.php' ) ) {
    require_once dirname(__FILE__).'/post_types.php';
}

/* redux admin options */
// Load the embedded Redux Framework
if ( file_exists( dirname( __FILE__ ).'/admin/redux-framework/framework.php' ) ) {
    require_once dirname(__FILE__).'/admin/redux-framework/framework.php';
}

// Load Redux extensions
if ( file_exists( dirname( __FILE__ ) . '/admin/redux-extensions/extensions-init.php' ) ) {
    require_once dirname( __FILE__ ) . '/admin/redux-extensions/extensions-init.php';
}

// Load the theme/plugin options
if ( file_exists( dirname( __FILE__ ) . '/admin/options-init.php' ) ) {
    require_once dirname( __FILE__ ) . '/admin/options-init.php';
}

/* debug functions */

if(orion_debug() == true){
    require_once( dirname( __FILE__ ) . '/dev/debug.php' );
}

function orion_plugin_styles() {
	if( orion_devel() == true){
    	 wp_enqueue_style( 'devel', get_template_directory_uri(). '/css/devel.css' );
    }
}
add_action( 'wp_enqueue_scripts', 'orion_plugin_styles' );


/* debug footer */
function orion_add_dev_footer_function() {
    include(dirname( __FILE__ ).'/dev/dev-footer.php');
}
if( orion_devel() == true){
	add_action( 'wp_footer', 'orion_add_dev_footer_function' );
}



// add image size for team
add_image_size( 'orion_portrait', 555 , 740, true );

// make image size available elsewhere:
add_filter( 'image_size_names_choose', 'recycle_plugin_custom_sizes' );
function recycle_plugin_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'orion_portrait' => esc_html__( 'Portrait', 'recycle' ),
    ) );
}

// widget activation:
function orion_activate_widgets() {
    $widgets = get_option( 'siteorigin_widgets_active', array() );
      $widgets['orion-accordion-w'] = true;
      $widgets['orion-button-w'] = true;
      $widgets['orion-cf7-w'] = true;
      $widgets['orion-count-up-w'] = true;
      $widgets['orion-cta-w'] = true;
      $widgets['orion-custom-carousel-w'] = true;
      $widgets['orion-dividers-w'] = true;
      $widgets['orion-empty-space-w'] = true;
      $widgets['orion-featured-pages'] = true;
      $widgets['orion-features-w'] = true;
      $widgets['orion-heading-w'] = true;
      $widgets['orion-icon-text-w'] = true;
      $widgets['orion-icon-w'] = true;
      $widgets['orion-image-w'] = true;
      $widgets['orion-list'] = true;
      $widgets['orion-logos-w'] = true;
      $widgets['orion-pricelist-w'] = true;
      $widgets['orion-progress-w'] = true;
      $widgets['orion-recent-posts-carousel'] = true;
      $widgets['orion-responsive-video-w'] = true;
      $widgets['orion-revslider-w'] = true;
      $widgets['orion-tabs-w'] = true;
      $widgets['orion-team-w'] = true;
      $widgets['orion-timeline-w'] = true;
      $widgets['orion-testimonial-w'] = true;
      $widgets['orion-upload-w'] = true;
      $widgets['orion-working-hours-w'] = true;
      $widgets['orion-simple-gallery'] = true;
      $widgets['orion-custom-menu-w'] = true;
      $widgets['orion-static-block-w'] = true;
      $widgets['orion-advanced-carousel-w'] = true;
      $widgets['orion-portfolio-w'] = true;
    update_option( 'siteorigin_widgets_active', $widgets );
}

// siteorigin_settings:
function orion_set_siteorigin() {
    $settings = get_option( 'siteorigin_panels_settings', array() );
   
    // add page builder to team member post type:
	if (!array_key_exists('post-types', $settings)) {
		$settings['post-types'] = array();
	}
    array_push($settings['post-types'], 'team-member');
    array_push($settings['post-types'], 'post');
    array_push($settings['post-types'], 'page');
    array_push($settings['post-types'], 'static_blocks');
    array_push($settings['post-types'], 'orion_portfolio');
   	
   	// mobile-width
    $settings['mobile-width'] = 767;
   	$settings['title-html'] = '<h2 class="h5 widget-title">{{title}}</h2>';
   	// update options
    update_option( 'siteorigin_panels_settings', $settings );
}

function recycle_activate() {
	orion_activate_widgets();
	orion_set_siteorigin();
}
register_activation_hook( __FILE__, 'recycle_activate' );

/*********************************** O.o ************************************/
/*                             team members slug                           */ 
/***************************************************************************/

add_action( 'load-options-permalink.php', 'orion_team_permalinks' );
function orion_team_permalinks() {
    if( isset( $_POST['orion_base_slug'] ) ) {
        update_option( 'orion_base_slug', sanitize_title_with_dashes( $_POST['orion_base_slug'] ) );
    }
    if( isset( $_POST['orion_base_name'] ) ) {
        update_option( 'orion_base_name',  $_POST['orion_base_name'] );
    }
    if( isset( $_POST['orion_department_base_name'] ) ) {
        update_option( 'orion_department_base_name',  $_POST['orion_department_base_name'] );
    }
    if( isset( $_POST['orion_department_base_url'] ) ) {
        update_option( 'orion_department_base_url', sanitize_title_with_dashes( $_POST['orion_department_base_url'] ) );
    }    

    // add fields
    add_settings_section( 'orion_permalinks_team', esc_html__( 'Team' ), 'permalinks_team_callback', 'permalink' );
    // Add a settings field to the permalink page
    // team member name
    add_settings_field( 'orion_base_name', esc_html__( 'Team member Name' ), 'orion_name_callback', 'permalink', 'orion_permalinks_team' );
    
    // Team member url
    add_settings_field( 'orion_base_slug', esc_html__( 'Team member URL base' ), 'orion_slug_callback', 'permalink', 'orion_permalinks_team' );
  
    // Department Name    
    add_settings_field( 'orion_department_base_name', esc_html__( 'Department name' ), 'orion_department_base_name_callback', 'permalink', 'orion_permalinks_team' );  

    // Department url
    add_settings_field( 'orion_department_base_url', esc_html__( 'Department URL base' ), 'orion_department_base_slug_callback', 'permalink', 'orion_permalinks_team' );    
}
function permalinks_team_callback() {
  echo '<hr>';
}

function orion_name_callback() {
    $value = get_option( 'orion_base_name', 'Team member' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_base_name" id="orion_base_name" class="regular-text" /><br><small>Used for breadcrumbs and page title.</small>';
}

function orion_slug_callback() {
    $value = get_option( 'orion_base_slug', 'team-member' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_base_slug" id="orion_base_slug" class="regular-text" />';
}

function orion_department_base_name_callback() {
    $value = get_option( 'orion_department_base_name', 'Department' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_department_base_name" id="orion_department_base_name" class="regular-text" /><br><small>Used for breadcrumbs and page title.</small>';
}

function orion_department_base_slug_callback() {
    $value = get_option( 'orion_department_base_url', 'department' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_department_base_url" id="orion_department_base_url" class="regular-text" />';
}
/*********************************** O.o ************************************/
/*                               Portfolio slug                            */ 
/***************************************************************************/

add_action( 'load-options-permalink.php', 'orion_portfolio_permalinks' );
function orion_portfolio_permalinks() {
    // portfolio post type
    if( isset( $_POST['orion_portfolio_base_slug'] ) ) {
        update_option( 'orion_portfolio_base_slug', sanitize_title_with_dashes( $_POST['orion_portfolio_base_slug'] ) );
    }
    if( isset( $_POST['orion_portfolio_base_name'] ) ) {
        update_option( 'orion_portfolio_base_name', $_POST['orion_portfolio_base_name'] );
    }
    // portfolio taxonomy
    if( isset( $_POST['orion_portfolio_category_base_slug'] ) ) {
        update_option( 'orion_portfolio_category_base_slug', sanitize_title_with_dashes( $_POST['orion_portfolio_category_base_slug'] ) );
    }
    if( isset( $_POST['orion_portfolio_category_base_name'] ) ) {
        update_option( 'orion_portfolio_category_base_name', $_POST['orion_portfolio_category_base_name'] );
    }
    
    // Add a settings field to the permalink page
    add_settings_section( 'orion_permalinks_portfolio', esc_html__( 'Portfolio' ), 'permalinks_portfolio_callback', 'permalink' );    
    // portfolio post type
    add_settings_field( 'orion_portfolio_base_name', esc_html__( 'Portfolio Name' ), 'orion_portfolio_field_name', 'permalink', 'orion_permalinks_portfolio' );
    add_settings_field( 'orion_portfolio_base_slug', esc_html__( 'Portfolio URL base' ), 'orion_portfolio_field', 'permalink', 'orion_permalinks_portfolio' );
    // portfolio taxonomy
    add_settings_field( 'orion_portfolio_category_base_name', esc_html__( 'Portfolio Category Name' ), 'orion_portfolio_category_base_name', 'permalink', 'orion_permalinks_portfolio' );
    add_settings_field( 'orion_portfolio_category_base_slug', esc_html__( 'Portfolio Category URL base' ), 'orion_portfolio_category_base_slug', 'permalink', 'orion_permalinks_portfolio' );    
}


function permalinks_portfolio_callback() {
  echo '<hr>';
}
function orion_portfolio_field_name() {
    $value = get_option( 'orion_portfolio_base_name', 'Projects' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_portfolio_base_name" id="orion_portfolio_base_name" class="regular-text" /><br><small>Used for breadcrumbs and page title.</small>';
}

function orion_portfolio_field() {
    $value = get_option( 'orion_portfolio_base_slug', 'projects' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_portfolio_base_slug" id="orion_portfolio_base_slug" class="regular-text" />';
}

function orion_portfolio_category_base_name() {
    $value = get_option( 'orion_portfolio_category_base_name', 'Portfolio Category' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_portfolio_category_base_name" id="orion_portfolio_category_base_name" class="regular-text" /><br><small>Used for breadcrumbs and page title.</small>';
}

function orion_portfolio_category_base_slug() {
    $value = get_option( 'orion_portfolio_category_base_slug', 'portfolio-category' );    
    echo '<input type="text" value="' . esc_attr( $value ) . '" name="orion_portfolio_category_base_slug" id="orion_portfolio_category_base_slug" class="regular-text" />';
}

/************************************* O.o *************************************/
/*                            Update notification                              */ 
/*******************************************************************************/

function orion_new_theme_notification() {
    ?>
    <div class="notice notice-alert is-dismissible">
        <p><?php echo wp_kses_post( 'Update notice: New version of Recycle theme is available. You can <a href="https://themeforest.net/item/recycle-environmental-recycling-wordpress-theme/19347643?ref=orionthemes_com">download it from ThemeForest', 'recycle' ); ?></p>
    </div>
    <?php
}

$orion_push_update_notice = false;
$orion_theme = wp_get_theme('recycle');
$theme_version='';
$theme_version = $orion_theme->get( 'Version' );


if (version_compare($theme_version, "1.7") == "-1") {
    add_action( 'admin_notices', 'orion_new_theme_notification' );
}

/************************************* O.o *************************************/
/*                             2.5 builder support                             */ 
/*******************************************************************************/
add_action('init', 'orion_so_2_5_update_css');

if(!function_exists('orion_so_2_5_update_css')) {
  function orion_so_2_5_update_css() {
    $theme_version='';
    $orion_theme = wp_get_theme('recycle');
    $theme_version = $orion_theme->get( 'Version' );
    if ( defined( 'SITEORIGIN_PANELS_VERSION' ) && $theme_version!= false && (float)substr($theme_version, 0, 3) < 1.6) { 

      if (strpos(SITEORIGIN_PANELS_VERSION, '-') !== false) {
          $so_version = strstr( SITEORIGIN_PANELS_VERSION, "-", true );
      } else {
          $so_version = SITEORIGIN_PANELS_VERSION;
      }     
      $so_version = substr($so_version, 0, 3);

      if ((is_numeric($so_version) || is_float($so_version)) && ($so_version >= 2.5 ) ) {
          wp_enqueue_style( 'new-pagebuilder-support', plugin_dir_url( __FILE__ ) .'css/legacy-page-builder.css' );
      } 
    }  
  }
}
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

add_filter('siteorigin_panels_layout_data', 'orion_cell_bg_color_2', 10, 2);


/* reverse order */
if(!function_exists('orion_reverse_order')) {
    function orion_reverse_order( $attributes, $args ) {
        
        if (isset($args["collapse_order"]) && $args["collapse_order"] == 'right-top') {
            $attributes['class'][] = 'orion-collapse-right-top';
        }

        return $attributes;
    }
}
add_filter('siteorigin_panels_row_style_attributes', 'orion_reverse_order', 10, 2);


/*********************************** O.o ***********************************/
/*                         END 2.5 builder support                         */ 
/***************************************************************************/


/************************************* O.o *************************************/
/*                           Static blocks shortcodes                          */ 
/*******************************************************************************/

function orion_static_block_shortcode_func( $atts, $content = '' ) {
    if (!isset($atts['block']) || $atts['block'] == "") {
      return;
    } else {
        $block_id = $atts['block'];
        $content = '<div class="clearfix staticblock-wrap">';
        $content .= siteorigin_panels_render($block_id); 
        $content .= '</div>';
        return $content;
    }
}
add_shortcode( 'staticblock', 'orion_static_block_shortcode_func' );

/* add shortcode display to backend */
add_filter('manage_static_blocks_posts_columns', 'orion_sb_shortcode_title', 10);
add_action('manage_static_blocks_posts_custom_column', 'orion_sb_shortcode', 10, 2);

function orion_sb_shortcode_title($defaults) {
    $defaults['shortcode'] = 'Copy shortcode';
    return $defaults;
}

function orion_sb_shortcode($column_name, $post_ID) {
    if ($column_name == 'shortcode') {
        echo '[staticblock block="' . $post_ID .'"]';
    }
}
