<?php

/**
 * initialize plugin
 */
function tvo_plugin_init() {
	if ( is_admin() ) {
		if ( ! session_id() ) {
			//session_start();
		}
		require_once TVO_ADMIN_PATH . 'start.php';
	}

	if ( ! function_exists( 'Thrive_List_Manager' ) ) {
		/**
		 * File included for initializing API connections from Thrive Dashboard
		 * Anything relating email/connections uses this
		 */
		require_once TVE_DASH_PATH . '/inc/auto-responder/misc.php';
	}

	/* check database version and run any necessary update scripts */
	require_once TVO_PATH . 'init/database/class-tvo-database-manager.php';
	Tvo_Database_Manager::check();
}

/**
 * Verify for plugin update
 */
function tvo_update_checker() {
	new TVE_PluginUpdateChecker(
		TVO_UPDATE_URL,
		TVO_PLUGIN_FILE_PATH,
		'thrive-ovation',
		12,
		'',
		'thrive_ovation'
	);
	add_filter( 'puc_request_info_result-thrive-ovation', 'ovation_set_product_icon' );
}


/**
 * Adding the product icon for the update core page
 *
 * @param $info
 *
 * @return mixed
 */

function ovation_set_product_icon( $info ) {
	$info->icons['1x'] = TVO_ADMIN_URL . '/img/tvo-logo-icon.png';

	return $info;
}

/**
 * Check if the default capability for admin & editor is set otherwise we need to set it
 */
function tve_ovation_dash_loaded() {
	require_once dirname( __FILE__ ) . '/classes/class-tvo-product.php';
}

/**
 * Loads dashboard's version file
 */
function tvo_load_dash() {
	$dash_path      = dirname( dirname( __FILE__ ) ) . '/thrive-dashboard';
	$dash_file_path = $dash_path . '/version.php';

	if ( is_file( $dash_file_path ) ) {
		$version                                  = require_once( $dash_file_path );
		$GLOBALS['tve_dash_versions'][ $version ] = array(
			'path'   => $dash_path . '/thrive-dashboard.php',
			'folder' => '/thrive-ovation',
			'from'   => 'plugins',
		);
	}

}

/**
 * make sure all the features required by TVO are shown in the dashboard
 *
 * @param array $features
 *
 * @return array
 */
function tvo_dashboard_add_features( $features ) {
	$features['api_connections']  = true;
	$features['general_settings'] = true;

	return $features;
}

/**
 * Load plugin text domain @const TVO_TRANSLATE_DOMAIN
 */
function tvo_load_plugin_textdomain() {
	$domain = TVO_TRANSLATE_DOMAIN;
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	$path   = 'thrive-ovation/languages/';

	load_textdomain( $domain, WP_LANG_DIR . '/thrive/' . $domain . '-' . $locale . '.mo' );
	load_plugin_textdomain( $domain, false, $path );
}

/**
 * make sure the TO_product is displayed in thrive dashboard
 *
 * @param $items
 *
 * @return array
 */
function tvo_add_to_dashboard( $items ) {
	$items[] = new Tvo_Product();

	return $items;
}


/**
 * Check if there is a valid activated license for the TO plugin
 *
 * @return bool
 */
function tvo_check_license() {
	return TVE_Dash_Product_LicenseManager::getInstance()->itemActivated( TVE_Dash_Product_LicenseManager::TVO_TAG );
}

/**
 * show a box with a warning message and a link to take the user to the license activation page
 * this will be called only when no valid / activated license has been found
 *
 * @return mixed
 */
function tvo_license_warning() {
	return include TVO_ADMIN_PATH . 'views/license_inactive.php';
}

/**
 * Register REST Routes
 */
function tvo_create_initial_rest_routes() {

	$endpoints = array(
		'TVO_REST_Settings_Controller',
		'TVO_REST_Testimonials_Controller',
		'TVO_REST_Tags_Controller',
		'TVO_REST_Social_Media_Controller',
		'TVO_REST_Comments_Controller',
		'TVO_REST_Shortcodes_Controller',
		'TVO_REST_Post_Meta_Controller',
		'TVO_REST_Filters_Controller',
	);

	foreach ( $endpoints as $e ) {
		$controller = new $e();
		$controller->register_routes();
	}
}

/**
 * Register post type for testimonial post type
 */
function tvo_register_post_types() {

	// Set UI labels for Custom Post Type
	$labels = array(
		'name'               => __( 'Thrive Testimonials', TVO_TRANSLATE_DOMAIN ),
		'singular_name'      => __( 'Thrive Testimonial', TVO_TRANSLATE_DOMAIN ),
		'menu_name'          => __( 'Thrive Testimonials', TVO_TRANSLATE_DOMAIN ),
		'parent_item_colon'  => __( 'Parent Thrive Testimonials', TVO_TRANSLATE_DOMAIN ),
		'all_items'          => __( 'All Thrive Testimonials', TVO_TRANSLATE_DOMAIN ),
		'view_item'          => __( 'View Thrive Testimonials', TVO_TRANSLATE_DOMAIN ),
		'add_new_item'       => __( 'Add New Thrive Testimonial', TVO_TRANSLATE_DOMAIN ),
		'add_new'            => __( 'Add New', TVO_TRANSLATE_DOMAIN ),
		'edit_item'          => __( 'Edit Thrive Testimonial', TVO_TRANSLATE_DOMAIN ),
		'update_item'        => __( 'Update Thrive Testimonial', TVO_TRANSLATE_DOMAIN ),
		'search_items'       => __( 'Search Thrive Testimonial', TVO_TRANSLATE_DOMAIN ),
		'not_found'          => __( 'Not Found', TVO_TRANSLATE_DOMAIN ),
		'not_found_in_trash' => __( 'Not found in Trash', TVO_TRANSLATE_DOMAIN ),
	);

	// Set other options for Custom Post Type
	$args = array(
		'label'               => __( TVO_TESTIMONIAL_POST_TYPE, TVO_TRANSLATE_DOMAIN ),
		'description'         => __( 'Thrive Ovation is a  Testimonial Management Plugin', TVO_TRANSLATE_DOMAIN ),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'comments' ),
		// You can associate this custom post type with a taxonomy or custom taxonomy.
		'taxonomies'          => array( 'tvo_tags', 'tvo_properties' ),
		'hierarchical'        => false,
		'public'              => false,
		'show_ui'             => false,
		'show_in_menu'        => false,
		'show_in_nav_menus'   => false,
		'show_in_admin_bar'   => false,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => false,
		'exclude_from_search' => true,
		'publicly_queryable'  => false,
		'capability_type'     => 'page',
	);

	// Registering your Custom Post Type
	register_post_type( TVO_TESTIMONIAL_POST_TYPE, $args );

	$args = array(
		'labels'             => array( 'name' => __( 'Thrive Ovation Shortcode', TVO_TRANSLATE_DOMAIN ) ),
		'public'             => false,
		'rewrite'            => false,
		'publicly_queryable' => true,
	);

	register_post_type( TVO_SHORTCODE_POST_TYPE, $args );
}

/**
 * Creating the taxonomies associated to testimonial post type
 */
function tvo_taxonomy() {

	/**
	 * Register the tags taxonomy
	 */
	register_taxonomy(
		TVO_TESTIMONIAL_TAG_TAXONOMY,  //The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
		'TVO Tags',        //post type name
		array(
			'hierarchical' => true,
			'label'        => 'TVO Tags',  //Display name
			'query_var'    => true,
			'rewrite'      => array(
				'slug'       => TVO_TESTIMONIAL_TAG_TAXONOMY, // This controls the base slug that will display before each term
				'with_front' => false, // Don't display the category base before
			),
		)
	);

}

/**
 * Adds an extra column to the comments view
 *
 * @param $columns
 *
 * @return mixed
 */
function tvo_comment_columns( $columns ) {
	global $comment_ids;

	$filters      = array(
		'meta_key'   => TVO_SOURCE_META_KEY,
		'meta_value' => TVO_SOURCE_COMMENTS,
	);
	$testimonials = tvo_get_testimonials( $filters );
	$comment_ids  = tvo_comment_check_testimonial( $testimonials );

	$columns['tvo-testimonial-column'] = __( 'Save as Testimonial', TVO_TRANSLATE_DOMAIN );

	return $columns;
}

/**
 * Populates the extra column previously added with values
 *
 * @param $column
 * @param $comment_id
 */
function tvo_comment_column( $column, $comment_id ) {
	global $comment_ids;

	if ( 'tvo-testimonial-column' == $column ) {
		if ( ! in_array( $comment_id, $comment_ids ) ) {
			include TVO_ADMIN_PATH . 'views/comments/comment-column-value.php';
		} else {
			echo '<p class="tvo-green-text"><span class="dashicons dashicons-yes"></span> ' . __( 'Saved', TVO_TRANSLATE_DOMAIN ) . '</p>';
		}
	}
}


/**
 * Filter available connection types
 *
 * @param $types
 *
 * @return array
 */
function tvo_filter_api_types( $types ) {
	$types['email'] = __( 'Email Delivery', TVO_TRANSLATE_DOMAIN );

	return $types;
}

/**
 * Adds custom code in the admin footer
 */
function tvo_add_code_after_footer() {

	$screen = get_current_screen();

	switch ( $screen->base ) {
		case 'edit-comments':
			/*Includes the modal iframe*/
			include TVO_ADMIN_PATH . 'views/comments/modal-iframe.php';

			break;
		default:
			break;
	}
}

/**
 * Hooks the process testimonial email link action on wordpress initialization
 */
function tvo_process_testimonial_actions() {

	if ( ! empty( $_GET['tvo_status'] ) && ! empty( $_GET['tvo_testimonial'] ) ) {
		$status         = $_GET['tvo_status'];
		$testimonial_id = (int) $_GET['tvo_testimonial'];
		/* added as a unique key for a testimonial, only available for a single testimonial */
		$email_key = isset( $_REQUEST['tvo_key'] ) ? (string) $_REQUEST['tvo_key'] : false;

		if ( $testimonial_id && $email_key && in_array( $status, array( 'approve', 'not_approve' ) ) ) {
			$db_key = tvo_get_testimonial_approval_key( $testimonial_id );

			if ( $email_key === $db_key ) {
				$landing_page_options = tvo_get_option( TVO_LANDING_PAGE_SETTINGS_OPTION );
				if ( $landing_page_options[ $status ] === 'tvo_existing_content' ) {
					$redirect_url = get_permalink( $landing_page_options[ $status . '_post_id' ] );
				} else {
					$redirect_url = $landing_page_options[ $status . '_url' ];
				}

				if ( $status === 'approve' ) {
					do_action( 'tvo_log_testimonial_status_activity', array( 'id' => $testimonial_id, 'status' => TVO_STATUS_READY_FOR_DISPLAY ) );
					update_post_meta( $testimonial_id, TVO_STATUS_META_KEY, TVO_STATUS_READY_FOR_DISPLAY );
				} else {
					do_action( 'tvo_log_testimonial_status_activity', array( 'id' => $testimonial_id, 'status' => TVO_STATUS_REJECTED ) );
					update_post_meta( $testimonial_id, TVO_STATUS_META_KEY, TVO_STATUS_REJECTED );
				}

				if ( strpos( $redirect_url, 'https://' ) === false && strpos( $redirect_url, 'http://' ) === false ) {
					$redirect_url = 'https://' . $redirect_url;
				}

				wp_redirect( $redirect_url );
				exit();
			}
		}
	}
}

/**
 * Include libraries for slider and capture testimonials
 *
 * @param $forms
 *
 * @return mixed
 */
function tvo_ajax_load_library( $forms ) {
	$exists = false;

	if ( shortcode_exists( 'tvo_shortcode' ) ) {
		foreach ( $forms['html'] as $form ) {
			if ( strpos( $form, 'tvo-testimonials-display-slider' ) !== false ) {
				$exists = true;
			}
		}

		if ( $exists ) {
			$forms['res']['js'][] = TVO_URL . 'tcb-bridge/js/libs/thrlider.min.js';
		}
	}

	if ( isset( $forms['html'] ) && is_array( $forms['html'] ) ) {
		$exists = false;
		foreach ( $forms['html'] as $form ) {
			//if we have a testimonial in leads inserted with display / capture testimonials from tcb or with shortcode we need the js related to the form.
			if ( strpos( $form, 'thrv_tvo_capture_testimonials' ) !== false || strpos( $form, 'tvo_testimonial_form' ) !== false ) {
				$exists = true;
			}
		}

		if ( ! $exists ) {
			$exists = ! empty( $forms['body_end'] ) && ( strpos( $forms['body_end'], 'thrv_tvo_capture_testimonials' ) !== false );
		}

		if ( $exists ) {
			$forms['res']['js'][]    = TVO_URL . 'tcb-bridge/frontend/js/forms.min.js';
			$forms['js']['TVO_Form'] = array(
				'testimonial_route' => tvo_get_route_url( 'testimonials' ) . '/form',
				'gravatar_route'    => tvo_get_route_url( 'socialmedia' ) . '/gravatar',
				'translate'         => array(
					'required'   => __( 'Please fill the required fields.', TVO_TRANSLATE_DOMAIN ),
					'validEmail' => __( 'Please enter a valid email.', TVO_TRANSLATE_DOMAIN ),
					'validURL'   => __( 'Please enter a valid URL, /n Make  \n sure you also use the website protocol (http, https, ftp)', TVO_TRANSLATE_DOMAIN ),
					'submit'     => __( 'Submit', TVO_TRANSLATE_DOMAIN ),
					'sending'    => __( 'Sending...', TVO_TRANSLATE_DOMAIN ),
				),
			);
		}
	}

	return $forms;
}

/**
 * Hook into TD Notification Manager and push trigger types
 *
 * @param $trigger_types
 *
 * @return array
 */
function tvo_filter_nm_trigger_types( $trigger_types ) {
	if ( ! in_array( 'testimonial_submitted', array_keys( $trigger_types ) ) ) {
		$trigger_types['testimonial_submitted'] = __( 'Testimonials', TVO_TRANSLATE_DOMAIN );
	}

	return $trigger_types;
}

/**
 * Get a unique key for a testimonial
 *
 * @param int|string $testimonial_id      ID of the testimonial
 * @param bool       $create_if_not_found whether or not to generate a key if none is found
 *
 * @return string the generated key
 */
function tvo_get_testimonial_approval_key( $testimonial_id, $create_if_not_found = false ) {
	$approval_key = get_post_meta( $testimonial_id, 'tvo_approval_key', true );

	if ( $create_if_not_found && empty( $approval_key ) ) {
		$approval_key = md5( uniqid( 'tvo-approval', true ) );
		update_post_meta( $testimonial_id, 'tvo_approval_key', $approval_key );
	}

	return (string) $approval_key;
}

