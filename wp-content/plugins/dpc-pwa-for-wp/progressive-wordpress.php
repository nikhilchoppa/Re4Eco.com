<?php

/*
Plugin Name: Progressive Web Apps For WordPress
Plugin URI: https://daftplug.com/demo/
Description: Turn your website into a Progressive Web App and make it installable, send push notifications, offline ready and more.
Author: DaftPlug
Author URI: https://daftplug.com/demo/
Version: 3.0
Text Domain: pwa
Domain Path: /languages
*/

global $wp_version;
if ( version_compare( $wp_version, '4.7', '<' ) || version_compare( PHP_VERSION, '5.6', '<' ) ) {
	function pwa_compatability_warning() {
		echo '<div class="error"><p>';

		echo sprintf( __( '“%1$s” requires PHP %2$s (or newer) and WordPress %3$s (or newer) to function properly. Your site is using PHP %4$s and WordPress %5$s. Please upgrade. The plugin has been automatically deactivated.', 'pwa' ), 'Progressive Web Apps For WordPress', '5.5', '4.7', PHP_VERSION, $GLOBALS['wp_version'] );
		echo '</p></div>';
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}
	}

	add_action( 'admin_notices', 'pwa_compatability_warning' );

	function pwa_deactivate_self() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	add_action( 'admin_init', 'pwa_deactivate_self' );

	return;

} else {

	define( 'PWA_SETTINGS_PARENT', 'pwa-for-wp' );
	define( 'PWA_SETTINGS_OPTION', 'pwa-option' );

	require_once 'inc/funcs.php';

	/**
	 * Init Plugin
	 */
	require_once 'classes/class-plugin.php';
	function pwa_get_instance() {
		return PWAForWP\Plugin::get_instance( __FILE__ );
	}

	pwa_get_instance();

	require_once 'classes/class-init.php';
	pwa_get_instance()->Init = new PWAForWP\Init();
	pwa_get_instance()->Init->run();

	/**
	 * Init Settings
	 */

	require_once 'classes/Libs/class-settings.php';
	function pwa_settings() {
		return PWAForWP\Settings::get_instance( 'pwa' );
	}

	pwa_settings()->set_parent_page( PWA_SETTINGS_PARENT );
	//pwa_settings()->set_debug( true );

	/**
	 * ServiceWorker
	 */

	require_once 'classes/class-serviceworker.php';
	pwa_get_instance()->ServiceWorker = new PWAForWP\ServiceWorker();
	pwa_get_instance()->ServiceWorker->run();

	/**
	 * Add To Home Screen
	 */

	require_once 'classes/class-addtohomescreen.php';
	pwa_get_instance()->AddToHomeScreen = new PWAForWP\AddToHomeScreen();
	pwa_get_instance()->AddToHomeScreen->run();

	/**
	 * Offline Usage
	 */

	require_once 'classes/class-offlineusage.php';
	pwa_get_instance()->Offlineusage = new PWAForWP\Offlineusage();
	pwa_get_instance()->Offlineusage->run();

	/**
	 * Optify
	 */

	require_once 'classes/class-optify.php';
	pwa_get_instance()->Optify = new PWAForWP\Optify();
	pwa_get_instance()->Optify->run();

	/**
	 * Pull to Navigate
	 */

	require_once 'classes/class-pulltonavigate.php';
	pwa_get_instance()->PullToNavigate = new PWAForWP\PullToNavigate();
	pwa_get_instance()->PullToNavigate->run();

	/**
	 * Shake
	 */

	require_once 'classes/class-preloader.php';
	pwa_get_instance()->Preloader = new PWAForWP\Preloader();
	pwa_get_instance()->Preloader->run();

	/**
	 * Shake
	 */

	require_once 'classes/class-shake.php';
	pwa_get_instance()->Shake = new PWAForWP\Shake();
	pwa_get_instance()->Shake->run();

	/**
	 * Reactify
	 */

	require_once 'classes/class-reactify.php';
	pwa_get_instance()->Reactify = new PWAForWP\Reactify();
	pwa_get_instance()->Reactify->run();
	
	/**
	 * Toast
	 */

	require_once 'classes/class-toast.php';
	pwa_get_instance()->Toast = new PWAForWP\Toast();
	pwa_get_instance()->Toast->run();

	/**
	 * Transition
	 */

	require_once 'classes/class-transition.php';
	pwa_get_instance()->Transition = new PWAForWP\Transition();
	pwa_get_instance()->Transition->run();

	/**
	 * Swipe
	 */

	require_once 'classes/class-swipe.php';
	pwa_get_instance()->Swipe = new PWAForWP\Swipe();
	pwa_get_instance()->Swipe->run();

	/**
	 * Vibrate
	 */

	require_once 'classes/class-vibrate.php';
	pwa_get_instance()->Vibrate = new PWAForWP\Vibrate();
	pwa_get_instance()->Vibrate->run();

	/**
	 * Tracking
	 */

	require_once 'classes/class-tracking.php';
	pwa_get_instance()->Tracking = new PWAForWP\Tracking();
	pwa_get_instance()->Tracking->run();

	/**
	 * Status
	 */

	require_once 'classes/class-status.php';
	pwa_get_instance()->Status = new PWAForWP\Status();
	pwa_get_instance()->Status->run();

	/**
	 * Push
	 */
	
    if ( !pwa_onesignal() ) {
	    require_once 'classes/class-pushcredentials.php';
	    pwa_get_instance()->PushCredentials = new PWAForWP\PushCredentials();
	    pwa_get_instance()->PushCredentials->run();
    
    	require_once 'classes/class-push.php';
    	pwa_get_instance()->Push = new PWAForWP\Push();
    	pwa_get_instance()->Push->run();
    
    	require_once 'classes/class-pushpost.php';
    	pwa_get_instance()->PushPost = new PWAForWP\PushPost();
	    pwa_get_instance()->PushPost->run();
    } else {
		require_once 'classes/class-onesignal.php';
		pwa_get_instance()->OneSignal = new PWAForWP\OneSignal();
		pwa_get_instance()->OneSignal->run();    	
    }
} // End if().