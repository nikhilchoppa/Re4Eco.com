<?php

namespace PWAForWP;

class Vibrate {

    public $capability = '';

    public function __construct() {
        $this->capability = pwa_get_instance()->Init->capability;
    }

    public function run() {
        add_action( 'pwa_settings', [ $this, 'register_settings' ] );
        add_action( 'wp_footer', [ $this, 'add_vibrate' ] );
    }

    public function register_settings() {
        $section_desc = '<b>' . __( 'Enable vibrate on tapping for mobile users', 'pwa' ) . '</b><br>';
        $section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_vibrate', __( '📳 Vibration', 'pwa' ), $section_desc );

        pwa_settings()->add_checkbox( $section, 'vibrate-enabled', __( 'Enable Vibration', 'pwa' ) );
    }

    public function add_vibrate() {
        if ( pwa_get_setting( 'vibrate-enabled' ) && wp_is_mobile() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery('body').vibrate();
                            });
                    </script>";
        }
    }
}