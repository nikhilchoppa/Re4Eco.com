<?php

namespace PWAForWP;

class Transition {

	public $capability = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_filter( 'body_class', [ $this, 'add_transition' ] );
		add_filter( 'pwa_footer_js', [ $this, 'footer_js' ] );
	}

	public function register_settings() {

		$section_desc = '<b>' . __( 'Add a nice page transition effect to make web app navigation more native and smooth', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_transition', __( '⏱ Page Transition', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'transition-enabled', __( 'Enable Page Transition', 'pwa' ) );

		pwa_settings()->add_select( $section, 'transition-style', __( 'Transition Style', 'pwa' ), [
			'brightness'        => __( 'Brightness', 'pwa' ),
			'contrast'          => __( 'Contrast', 'pwa' ),
			'opacity'           => __( 'Opacity', 'pwa' ),
			'grayscale'         => __( 'Grayscale', 'pwa' ),
			'invert'            => __( 'Invert', 'pwa' ),
			'blur'              => __( 'Blur', 'pwa' ),
		], 'brightness' );
	}

	public function add_transition( $classes ) {
		if ( pwa_get_setting( 'transition-enabled' ) ) {
            $classes[] = pwa_get_setting( 'transition-style' );
        } else {
        	$classes[] = 'none';
        }

        return $classes;
	}

	public function footer_js( $args ) {
		if ( pwa_get_setting( 'transition-enabled' ) ) {
		    $args['TransitionStyle']  = pwa_get_setting( 'transition-style' );

		    return $args;
		}  else {
        	$args['TransitionStyle']  = 'none';

		    return $args;
        }
	}
}