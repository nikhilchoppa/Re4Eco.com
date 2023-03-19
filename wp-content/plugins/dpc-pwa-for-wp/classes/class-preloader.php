<?php

namespace PWAForWP;

class Preloader {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_footer', [ $this, 'add_preloader' ], 1 );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Add a nice page preloader with bouncing website icon and background color', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_preloader', __( '⏱ Preloader', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'preloader-enabled', __( 'Enable Preloader', 'pwa' ) );
	}

	public function add_preloader() {
		if ( pwa_get_setting( 'preloader-enabled' ) ) {
			$appicon = get_site_icon_url(150);
			$bgcolor = pwa_get_instance()->AddToHomeScreen->sanitize_hex( pwa_get_setting( 'manifest-background-color' ), '#ffffff' );;
			echo '<div id="splashscreen" style="background-color: '.$bgcolor.';">
                    <div id="splashicon" style="background-image: url('.$appicon.');"></div>
                  </div>';
        }
	}
}
