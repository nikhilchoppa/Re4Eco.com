<?php

namespace PWAForWP;

class Swipe {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_footer', [ $this, 'add_swipe' ] );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Add swipe left to go back and swipe right to go forward feature for mobile users', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_swipe', __( '👆🏻 Swipe To Back/Forward', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'swipe-enabled', __( 'Enable Swipe To Back/Forward', 'pwa' ) );
	}

	public function add_swipe() {
		$movedback = __( 'Moved Back', 'pwa' );
		$movedforward = __( 'Moved Forward', 'pwa' );
		if ( pwa_get_setting( 'swipe-enabled' ) && wp_is_mobile() ) {
		    echo "<script type='text/javascript'>
		    		    document.addEventListener('DOMContentLoaded', function(event) {
		    		    	jQuery('body').attr('data-xthreshold', '111').swipeleft(function() { 
                                window.history.back();
                                jQuery.toast({
                                  title: '".$movedback."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            }).swiperight(function() { 
                                window.history.forward(); 
                                jQuery.toast({
                                  title: '".$movedforward."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                        });
                  </script>";
        }
	}
}