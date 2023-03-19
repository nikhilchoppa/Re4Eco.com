<?php

function pwa_get_notification_button( $attributes = [] ) {
	$dir      = plugin_dir_path( pwa_get_instance()->file ) . 'assets/img/icon/';
	$icon_on  = $dir . 'bell-ring.svg';
	$icon_off = $dir . 'bell-off.svg';
	if ( ! is_file( $icon_on ) || ! is_file( $icon_off ) ) {
		return '';
	}
	$icon_on  = file_get_contents( $icon_on );
	$icon_off = file_get_contents( $icon_off );

	$atts       = apply_filters( 'pwa_notification_button_attributes', $attributes );
	$attributes = [];
	foreach ( $atts as $key => $val ) {
		$key = sanitize_title( $key );
		$val = esc_attr( $val );
		if ( 'class' == $key ) {
			$val = 'notification-button ' . $val;
		}
		$attributes[] = "$key='$val'";
	}

	$attributes = implode( ' ', $attributes );

	$html = '';
	$html .= "<button id='pwa-notification-button' $attributes>";
	$html .= "<span class='notification-button__icon notification-button__icon--on'>$icon_on</span>";
	$html .= "<span class='notification-button__icon notification-button__icon--off'>$icon_off</span>";
	$html .= "<span class='notification-button__icon notification-button__icon--spinner'></span>";
	$html .= '</button>';

	return $html;
}

function pwa_push_set() {
	return ( get_option( 'pwa_firebase_credentials_set' ) == 'yes' );
}

function pwa_exit_ajax( $type, $msg = '', $add = [] ) {

	$return = [
		'type'    => $type,
		'message' => $msg,
		'add'     => $add,
	];

	echo json_encode( $return );

	wp_die();
}

function pwa_is_frontend() {
	if ( is_admin() || 'wp-login.php' == $GLOBALS['pagenow'] ) {
		return false;
	}

	return true;
}

function pwa_get_setting( $key ) {
	return pwa_settings()->get_setting( $key );
}

function pwa_settings_page_main() {
	return pwa_settings()->add_page( PWA_SETTINGS_PARENT, __( 'Status', 'pwa' ) );
}

function pwa_settings_page_optimize() {
	return pwa_settings()->add_page( 'pwa-optimize', __( 'Optimize', 'pwa' ) );
}

function pwa_settings_page_accessibility() {
	return pwa_settings()->add_page( 'pwa-accessibility', __( 'Accessibility', 'pwa' ) );
}

function pwa_settings_page_addtohomescreen() {
	return pwa_settings()->add_page( 'pwa-addtohomescreen', __( 'Add To Home Screen', 'pwa' ) );
}

function pwa_settings_page_offlineusage() {
	return pwa_settings()->add_page( 'pwa-offlineusage', __( 'Offline Usage', 'pwa' ) );
}

function pwa_settings_page_push() {
	return pwa_settings()->add_page( 'pwa-push', __( 'Push Notifications', 'pwa' ) );
}

function pwa_register_url( $url ) {

	$site_url  = untrailingslashit( get_site_url() );
	$url_parts = parse_url( $site_url );

	$base_url = $url_parts['scheme'] . '://' . $url_parts['host'];
	if ( strpos( $url, $site_url ) != 0 ) {
		return '';
	}

	return str_replace( $base_url, '', $url );
}

function pwa_put_contents( $file, $content = null ) {

	if ( is_file( $file ) ) {
		unlink( $file );
	}

	if ( empty( $file ) ) {
		return false;
	}

	pwa_wp_filesystem_init();
	global $wp_filesystem;

	if ( ! $wp_filesystem->put_contents( $file, $content, 0644 ) ) {
		return false;
	}

	return true;
}

function pwa_delete( $file ) {

	// Return false if no filename is provided
	if ( empty( $file ) ) {
		return false;
	}

	// Initialize the WP filesystem
	pwa_wp_filesystem_init();
	global $wp_filesystem;

	return $wp_filesystem->delete( $file );
}

function pwa_wp_filesystem_init() {

	global $wp_filesystem;

	if ( empty( $wp_filesystem ) ) {
		require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/file.php' );
		WP_Filesystem();
	}
}

function pwa_get_pages() {
	$pages = [];

	foreach ( get_pages() as $page ) {
		$pages[ get_permalink( $page ) ] = get_the_title( $page );
	}

	if ( ! array_key_exists( './', $pages ) ) {
		$pages = array_merge( [ './' => 'Front Page' ], $pages );
	}

	return $pages;
}

function pwa_plugin_active( $plugin ) {
	$all_plugins = get_option( 'active_plugins' );

	if ( is_multisite() ) {
		$network_plugins = get_site_option( 'active_sitewide_plugins' );
		if ( is_array( $network_plugins ) ) {
			foreach ( $network_plugins as $key => $network_plugin ) {
				if ( ! in_array( $key, $all_plugins ) ) {
					$all_plugins[] = $key;
				}
			}
		}
	}

	if ( ! is_array( $all_plugins ) ) {
		return false;
	}

	if ( in_array( $plugin, $all_plugins ) ) {
		return true;
	}

	return false;
}

function pwa_onesignal() {
	return pwa_plugin_active( 'onesignal-free-web-push-notifications/onesignal.php' );
}

function pwa_rewrite_htaccess_file() {
	global $wp_rewrite;
    $wp_rewrite->flush_rules();

    return false;
}