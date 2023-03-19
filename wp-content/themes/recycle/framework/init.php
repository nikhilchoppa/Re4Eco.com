<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* Beam me up, Scotty */
if ( ! function_exists( 'orion_theme_setup' ) ) :
function orion_theme_setup() { 
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	*/
	load_theme_textdomain( 'recycle', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	/* custom bg **/
	add_theme_support('custom-background');
	add_theme_support('custom-header'); 
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/**
	 * feature image support
	 */
	add_theme_support( 'post-thumbnails' ); 
	
	/*
	 * Enable support for Post Formats.
	 * See: https://codex.wordpress.org/Post_Formats
	 */
  	add_theme_support( 'post-formats', array(
    'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio'
  	) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'recycle' ),
	) );

	// If the world falls appart, we still have the content width - mostly for theme check
	if ( ! isset( $content_width ) ) $content_width = 980;
}
endif; // orion_theme_setup
add_action( 'after_setup_theme', 'orion_theme_setup' );

/* CMB 2 */
require_once(get_template_directory() ."/framework/meta/CMB2/init.php");

/* tinyMCE addon */
require_once(get_template_directory() ."/framework/tinymce/tinymce-orion-shortcodes.php");
