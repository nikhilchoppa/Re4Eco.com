<?php

namespace PWAForWP;

class Shake {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_footer', [ $this, 'add_shake' ] );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Add shake to refresh feature for iPhone and Android mobile users', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_shake', __( '📳 Shake To Refresh', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'shake-enabled', __( 'Enable Shake to Refresh', 'pwa' ) );
	}

	public function add_shake() {
		if ( pwa_get_setting( 'shake-enabled' ) && wp_is_mobile() ) {
		    echo "<script type='text/javascript'>
		    		    document.addEventListener('DOMContentLoaded', function(event) { 
                            var shakeEvent = new Shake({threshold: 15});
                            shakeEvent.start();
                            window.addEventListener('shake', function(){
                                location.reload();
                            }, false);

			                function stopShake(){
			                	shakeEvent.stop();
			                }
                        });
                 </script>";
        }
	}
}
