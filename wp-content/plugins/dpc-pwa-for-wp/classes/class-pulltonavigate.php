<?php

namespace PWAForWP;

class PullToNavigate {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_footer', [ $this, 'add_pulltonavigate' ] );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Add pull to navigate feature for iPhone and Android mobile users', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_pulltonavigate', __( '🔄 Pull To Navigate', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'pulltonavigate-enabled', __( 'Enable Pull to Navigate', 'pwa' ) );
		pwa_settings()->add_color( $section, 'pulltonavigate-color', __( 'Background Color', 'pwa' ), '#9E8DDA' );
	}

	public function add_pulltonavigate() {
		$bgcolor = pwa_get_setting( 'pulltonavigate-color' );
		if ( pwa_get_setting( 'pulltonavigate-enabled' ) && wp_is_mobile() ) {
		    echo "<script type='text/javascript'>
		    		    document.addEventListener('DOMContentLoaded', function(event) { 
                            PullToNavigate();
							document.getElementById('share-wrap').style.background = '".$bgcolor."';
                        });
                 </script>";
        }
	}
}
