<?php
class TinyMCE_orion_menu {
    /**
    * Initialize
    */
    function __construct() {

 		if ( is_admin() ) {
		    add_action( 'init', array( &$this, 'setup_tinymce_plugin' ) );
		}
    }

    /**
	* Check if the current user can edit Posts or Pages, and is using the Visual Editor
	* If so, add some filters so we can register our plugin
	*/
	function setup_tinymce_plugin() {
	 
	    // Check if the logged in WordPress User can edit Posts or Pages
	    // If not, don't register our TinyMCE plugin
	    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
	        return;
	    }
	 
	    // Check if the logged in WordPress User has the Visual Editor enabled
	    // If not, don't register our TinyMCE plugin
	    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
	        return;
	    }
	    // Setup some filters
	    add_filter( 'mce_external_plugins', array( &$this, 'add_tinymce_plugin' ) );
	    add_filter( 'mce_buttons', array( &$this, 'add_tinymce_toolbar_button' ) ); 
	}

	/**
	 * Adds a TinyMCE plugin compatible JS file to the TinyMCE / Visual Editor instance
	 *
	 * @param array $plugin_array Array of registered TinyMCE Plugins
	 * @return array Modified array of registered TinyMCE Plugins
	 */
	function add_tinymce_plugin( $plugin_array ) {
	    $plugin_array['orion_menu'] = get_template_directory_uri () ."/framework/tinymce/" . 'tinymce-orion-shortcodes.js';
	    return $plugin_array; 
	}

	/**
	 * Adds a button to the TinyMCE / Visual Editor which the user can click
	 * to insert a custom CSS class.
	 *
	 * @param array $buttons Array of registered TinyMCE Buttons
	 * @return array Modified array of registered TinyMCE Buttons
	 */
	function add_tinymce_toolbar_button( $buttons ) {
	 
	    array_push( $buttons, 'orion_menu' );
	    return $buttons;
	}

	/**
	* Enqueues CSS for TinyMCE Dashicons
	*/
	function admin_scripts_css() {
		wp_enqueue_style( 'tinymce-orion-shortcodes', get_template_directory_uri () ."/framework/tinymce/" . 'tinymce-orion-shortcodes.css' );
	}
}
$tinymce_orion_menu = new TinyMCE_orion_menu;


