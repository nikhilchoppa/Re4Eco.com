<?php // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit; 

/* define root path */
define('ORION_ROOT', get_template_directory_uri());
/*
* Theme setup
*/
/* helper functions*/
require_once( get_template_directory() . '/framework/helpers.php' );
/* builder functions*/
require_once( get_template_directory() . '/framework/sobuilder.php' );
/* option framework*/
require_once( get_template_directory() . '/framework/admin/admin-init.php' );
/* theme init*/
require_once( get_template_directory() . '/framework/init.php' );
/* create sidebars*/
require_once( get_template_directory() . '/framework/sidebars.php' );
/* create metaboxes*/
require_once( get_template_directory() . '/framework/meta/orion_meta_2.php');
/* site origin specific */
require_once( get_template_directory() . '/widgets/orion_so_filters.php' );

/*
* Tiny MCS specific:
*/
function orion_tinymce_style() {
    add_editor_style( '/framework/css/tiny_mce_styles.css' );
}
add_action( 'admin_init', 'orion_tinymce_style' );

/*
* Mega Menu
*/
if (orion_get_option('orion_megamenu', false) == true) {
    if(is_admin()) {
        include_once(get_template_directory() . '/framework/megamenu.php');
    } else {
        include_once(get_template_directory() . '/framework/orion-walker.php');
    }
}
/* shortcodes */
include_once(get_template_directory() . '/framework/shortcodes.php');

/*
* Admin scripts
*/
function orion_admin_scripts($hook) {
    wp_enqueue_script( 'orion_posts_admin', get_template_directory_uri(). '/framework/js/admin.js' );
    if (orion_get_option('orion_megamenu', false) == true) {
      wp_enqueue_script( 'orion-megamenu', get_template_directory_uri(). '/framework/js/megamenu.js' );      
    }
    wp_enqueue_style( 'orion_admin-css', get_template_directory_uri(). '/css/admin.css' );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri(). '/libs/font-awesome/css/font-awesome.min.css' );

    /* Enqueues CSS for TinyMCE icons */    
    wp_enqueue_style( 'tinymce-orion-shortcodes', get_template_directory_uri () ."/framework/tinymce/" . 'tinymce-orion-shortcodes.css' ); 
}

add_action( 'admin_enqueue_scripts', 'orion_admin_scripts' );

/*
* Enqueue script for Redux framework.
*/
function orion_add_redux_css() {
    wp_enqueue_style( 'orion-redux-css', get_template_directory_uri(). '/framework/css/redux.css');  
}
add_action( 'redux/page/recycle/enqueue', 'orion_add_redux_css' );

/*
* Enqueue script for customizer.
*/
function orion_customizer_scripts() {
    wp_enqueue_script( 'orion_admin', get_template_directory_uri(). '/framework/js/admin.js' );
}
add_action( 'customize_preview_init', 'orion_customizer_scripts' );

/*
* Front end scripts
*/

function orion_frontend_scripts($hook) {
    // third-party styles
    wp_enqueue_style( 'bootstrap', get_template_directory_uri(). '/libs/bootstrap/css/bootstrap.css' );	 
    wp_enqueue_style( 'fontawesome', get_template_directory_uri(). '/libs/font-awesome/css/font-awesome.min.css' ); 
    wp_enqueue_style( 'elegant-icons', get_template_directory_uri(). '/libs/elegant_font/HTMLCSS/style-ot-5.css' ); 
    wp_enqueue_style( 'owl', get_template_directory_uri(). '/libs/owlcarousel/assets/owl.carousel.min.css');
    wp_enqueue_style( 'owl-theme', get_template_directory_uri(). '/libs/owlcarousel/assets/owl.theme.default.min.css');
    wp_enqueue_style( 'swipebox', get_template_directory_uri(). '/libs/swipebox/css/swipebox.min.css' ); 

    // theme style
    wp_enqueue_style( 'recycle_components', get_template_directory_uri(). '/css/components.css' );

    if(get_option( 'orion_theme_option_css', 'false' ) != 'false') {
        wp_add_inline_style( 'recycle_components' , get_option('orion_theme_option_css') );
    } else {
        wp_enqueue_style( 'orion-redux', get_template_directory_uri(). '/framework/css/orion-redux.css', false, rand(1, 99999) );
        if(get_option('recycle', 'load-css') == 'load-css' ) {
            wp_enqueue_style( 'default-options', get_template_directory_uri(). '/css/default-options.css' ); 
        }
    }
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'orion-woo', get_template_directory_uri(). '/css/woo.css' );
    // code that requires WooCommerce
    } 
    // also add theme option custom CSS
    $orion_options = get_option('recycle', '' );
    if($orion_options != '' && array_key_exists("orion_custom_css_editor", $orion_options) && $orion_options["orion_custom_css_editor"] != '' && $orion_options["orion_custom_css_editor"]!= false) {
        wp_add_inline_style( 'recycle_components' , $orion_options["orion_custom_css_editor"] );
    }
    /* 
        load new page builder CSS
    */

    wp_enqueue_script( 'bootstrap', get_template_directory_uri(). '/libs/bootstrap/js/bootstrap.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'smooth-scroll', get_template_directory_uri(). '/libs/smoothscroll/jquery.smooth-scroll.min.js',array('jquery'), '', true );
	wp_enqueue_script( 'owl', get_template_directory_uri(). '/libs/owlcarousel/owl.carousel.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'tab-collapse', get_template_directory_uri(). '/libs/tab-collapse/bootstrap-tabcollapse.js', array( 'jquery', 'bootstrap' ) );
    wp_enqueue_script( 'waypoints', get_template_directory_uri(). '/libs/waypoints/jquery.waypoints.min.js', 'jQuery');
    wp_enqueue_script( 'waypoints-inview', get_template_directory_uri(). '/libs/waypoints/shortcuts/inview.js', 'waypoints');
    wp_enqueue_script( 'waypoints-sticky', get_template_directory_uri(). '/libs/waypoints/shortcuts/sticky.js', 'waypoints'); 
    wp_enqueue_script( 'swipebox', get_template_directory_uri(). '/libs/swipebox/js/jquery.swipebox.min.js', 'jQuery');    

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    wp_enqueue_script( 'recycle_functions', get_template_directory_uri(). '/js/functions.js', array( 'jquery' ) ); 
}
add_action( 'wp_enqueue_scripts', 'orion_frontend_scripts' );

/* Optional scripts which load only when needed */

function orion_set_masonry() {
    add_action( 'orion_footer', 'orion_enqueue_masonry' );
}
function orion_set_counter() {
    add_action( 'orion_footer', 'orion_enqueue_counter' );
}
function orion_set_progress_bars() {
    add_action( 'orion_footer', 'orion_enqueue_progress_bars' );
}
function orion_set_isotope() {
    add_action( 'orion_footer', 'orion_enqueue_isotope' );
}

function orion_enqueue_masonry() {
    wp_enqueue_script( 'masonry', get_template_directory_uri(). '/libs/masonry/masonry.pkgd.min.js');
    wp_enqueue_script( 'orion-masonry', get_template_directory_uri().'/js/orion-masonry.js', array('masonry', 'jquery'));   
}
function orion_enqueue_counter() {
    wp_enqueue_script( 'inview', get_template_directory_uri(). '/libs/inview/in-view.min.js');
    wp_enqueue_script( 'count-to', get_template_directory_uri(). '/libs/jQueryCountTo/jquery.countTo.js');
    wp_enqueue_script( 'orion-count-to-widget', get_template_directory_uri().'/widgets/so-widgets/orion-count-up-w/tpl/count_up.js', array('inview', 'count-to'));
}
function orion_enqueue_progress_bars() {
    wp_enqueue_script( 'inview', get_template_directory_uri(). '/libs/inview/in-view.min.js');
    wp_enqueue_script( 'orion-progress', get_template_directory_uri().'/widgets/so-widgets/orion-progress-w/tpl/orion-progress.js', array('inview'));
}
function orion_enqueue_isotope() {
    wp_enqueue_script( 'isotope', get_template_directory_uri(). '/libs/isotope/isotope.pkgd.min.js'); 
    wp_enqueue_script( 'orion-isotope', get_template_directory_uri().'/js/orion-isotope.js', array('isotope', 'jquery'));   
}

/*image sizes */
add_image_size( 'orion_container_width', 1140, 640, true );
add_image_size( 'orion_carousel', 750, 500, true );
add_image_size( 'orion_tablet', 750 );
add_image_size( 'orion_square', 750 , 750, true );

add_filter( 'image_size_names_choose', 'orion_custom_sizes' );
function orion_custom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'orion_container_width' => esc_html__( 'Container width', 'recycle' ),
        'orion_carousel' => esc_html__( '3:2 ratio', 'recycle' ),
        'orion_tablet' => esc_html__( 'Tablet width', 'recycle' ),
        'orion_square' => esc_html__( 'Square', 'recycle' ),
    ) );
}

/* add support for excerpt on pages */ 
function orion_page_excerpt() {
    add_post_type_support( 'page', 'excerpt' );
}
add_action( 'init', 'orion_page_excerpt' );

/* revolution remove anoying notices and not used metaboxes */ 
if ( is_admin() ) {
    function orion_remove_revolution_slider_meta_boxes() {
        remove_meta_box( 'mymetabox_revslider_0', 'page', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'post', 'normal' );
        remove_meta_box( 'mymetabox_revslider_0', 'Team', 'normal' );
    }

    add_action( 'do_meta_boxes', 'orion_remove_revolution_slider_meta_boxes' );
}

// disable HTML5 calender       
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );


/* Woocommerce */
if ( class_exists( 'WooCommerce' ) ) {
    require_once( get_template_directory() . '/framework/woo.php' );
}

add_action( 'after_setup_theme', 'orion_woocommerce_support' );
function orion_woocommerce_support() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' ); 
    add_theme_support( 'wc-product-gallery-slider' );

}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 40 );
// add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
