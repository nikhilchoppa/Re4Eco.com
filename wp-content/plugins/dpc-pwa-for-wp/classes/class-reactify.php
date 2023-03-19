<?php

namespace PWAForWP;

class Reactify {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_footer', [ $this, 'add_reactify' ], 50 );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Speed up click events by removing 300ms delay to trigger immediately on mobile browsers', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_optimize(), 'pwa_reactify', __( '⏭ Reactify', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'reactify-enabled', __( 'Enable Reactify', 'pwa' ) );
	}

	public function add_reactify() {
		if ( pwa_get_setting( 'reactify-enabled' ) && wp_is_mobile() ) {
		    echo "<script type='text/javascript'>
			        document.addEventListener('DOMContentLoaded', function(event) { 
	                  FastClick.attach(document.body);
				    });
                  </script>";
        }
	}
}