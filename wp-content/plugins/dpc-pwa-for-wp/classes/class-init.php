<?php

namespace PWAForWP;

class Init {
	public $capability = '';
	public $admin_bar_id = '';
	public $menu_title = '';

	public function __construct() {
		$this->capability   = 'administrator';
		$this->admin_bar_id = pwa_get_instance()->prefix . '-admin-bar';
		$this->menu_title   = __( 'Progressive Apps', 'pwa' );
	}

	public function run() {
		// Basics Page
		add_action( 'admin_menu', [ $this, 'add_menu_page' ] );
		add_action( 'pwa_settings', [ $this, 'settings_intro' ] );

		// Assets
		add_action( 'wp_enqueue_scripts', [ $this, 'add_assets' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_admin_assets' ] );

		// is_ssl() fix for cloudflare: https://snippets.webaware.com.au/snippets/wordpress-is_ssl-doesnt-work-behind-some-load-balancers/
		if ( stripos( get_option( 'siteurl' ), 'https://' ) === 0 ) {
			$_SERVER['HTTPS'] = 'on';
		}

		/**
		 * Default Settings
		 */
		add_action( 'pwa_on_activate', [ $this, 'default_settings' ] );
		add_action( 'init', [ $this, 'StartSession' ] );
		add_action( 'pwa_on_dectivate', [ $this, 'EndSession' ] );
		add_action( 'wp_logout', [ $this, 'EndSession' ] );
        add_action( 'wp_login', [ $this, 'EndSession' ] );
	}

	/**
	 * Basics Page
	 */

	public function settings_intro() {
		$html = '';
		$html .= '<h1 style="text-align:center;color:#ffcc4d;">⚠ '.__( 'PLEASE MAKE SURE THE STATUS BELOW IS ALL GREEN!', 'pwa' ).' ⚠️</h1>';

		$section = pwa_settings()->add_section( pwa_settings_page_main(), 'pwa_intro_text', '', $html );
	}

	public function add_menu_page() {
		$icon = plugin_dir_url( pwa_get_instance()->file ) . 'assets/img/pwa-menu-icon.png';
		add_menu_page( pwa_get_instance()->name, $this->menu_title, $this->capability, PWA_SETTINGS_PARENT, '', $icon, 100 );
	}

	/**
	 * Assets
	 */
	
	public function add_assets() {
		$script_version = pwa_get_instance()->version;
		$dir_uri = trailingslashit( plugin_dir_url( pwa_get_instance()->file ) );
		wp_enqueue_script( 'clientjs', $dir_uri . 'assets/scripts/clientjs.js', [], '1.0.0', true );
		wp_enqueue_script( 'toastjs', $dir_uri . 'assets/scripts/toast.js', ['jquery'], $script_version, true );
		if (pwa_get_setting( 'offline-enabled' )) {
			wp_enqueue_script( pwa_get_instance()->prefix . '-offlineforms', $dir_uri . 'assets/scripts/offlineforms.js', ['jquery', 'toastjs'], $script_version, true );
		}
		if (pwa_get_setting( 'offline-indicator-enabled' )) {
			wp_enqueue_script( pwa_get_instance()->prefix . '-offline-indicator', $dir_uri . 'assets/scripts/offline-indicator.js', [], $script_version, true );
			wp_enqueue_style( pwa_get_instance()->prefix . '-offline-indicator', $dir_uri . 'assets/styles/offline-indicator.css', [], $script_version );
		}
		if (wp_is_mobile()) {
			wp_enqueue_script( pwa_get_instance()->prefix . '-garlic', $dir_uri . 'assets/scripts/garlic.js', ['jquery'], $script_version, true );
			wp_enqueue_script( pwa_get_instance()->prefix . '-addtohomescreenjs', $dir_uri . 'assets/scripts/addtohomescreen.js', ['clientjs', pwa_get_instance()->prefix . '-script'], $script_version, true );
		    wp_enqueue_style( pwa_get_instance()->prefix . '-addtohomescreencss', $dir_uri . 'assets/styles/addtohomescreen.css', [], $script_version );
		    if (pwa_get_setting( 'pulltonavigate-enabled' )) {
		  		wp_enqueue_script( pwa_get_instance()->prefix . '-pulltonavigate', $dir_uri . 'assets/scripts/pulltonavigate.js', [], $script_version, true );
		    }
		    if (pwa_get_setting( 'reactify-enabled' )) {	
		    	wp_enqueue_script( pwa_get_instance()->prefix . '-reactify', $dir_uri . 'assets/scripts/reactify.js', ['jquery'], $script_version, true );
		    }
		    if (pwa_get_setting( 'vibrate-enabled' )) {
		    	wp_enqueue_script( pwa_get_instance()->prefix . '-vibrate', $dir_uri . 'assets/scripts/vibrate.js', ['jquery'], $script_version, true );
		    }
		    if (pwa_get_setting( 'shake-enabled' )) {
		    	wp_enqueue_script( pwa_get_instance()->prefix . '-shake', $dir_uri . 'assets/scripts/shake.js', [], $script_version, true );
		    }	
		    if (pwa_get_setting( 'swipe-enabled' )) {
		    	wp_enqueue_script( pwa_get_instance()->prefix . '-mobileevents', $dir_uri . 'assets/scripts/mobile-events.js', ['jquery'], $script_version, true );
		    }	
        }
		wp_enqueue_style( pwa_get_instance()->prefix . '-style', $dir_uri . 'assets/styles/ui.css', [], $script_version );
		wp_enqueue_script( pwa_get_instance()->prefix . '-script', $dir_uri . 'assets/scripts/ui.js', ['jquery', 'clientjs', 'toastjs'], $script_version, true );

		/**
		 * Footer JS
		 */

		$defaults = [
			'AjaxURL' => admin_url( 'admin-ajax.php' ),
			'homeurl' => trailingslashit( get_home_url() ),
		];

		$vars = json_encode( apply_filters( 'pwa_footer_js', $defaults ) );

		wp_add_inline_script( pwa_get_instance()->prefix . '-script', "var PwaJsVars = {$vars};", 'before' );
	}

	public function add_admin_assets() {
		$script_version = pwa_get_instance()->version;
		$min            = true;
		if ( pwa_get_instance()->debug && is_user_logged_in() ) {
			$min = false;
		}

		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );

		$dir_uri = trailingslashit( plugin_dir_url( pwa_get_instance()->file ) );
		wp_enqueue_style( pwa_get_instance()->prefix . '-admin-style', $dir_uri . 'assets/styles/admin' . ( $min ? '.min' : '' ) . '.css', [], $script_version );
		wp_enqueue_script( pwa_get_instance()->prefix . '-admin-script', $dir_uri . 'assets/scripts/admin' . ( $min ? '.min' : '' ) . '.js', [ 'jquery' ], $script_version, true );

		/**
		 * Admin Footer JS
		 */

		$defaults = [
			'AjaxURL'      => admin_url( 'admin-ajax.php' ),
			'homeurl'      => trailingslashit( get_home_url() ),
			'GeneralError' => __( 'An unexpected error occured', 'pwa' ),
		];

		$vars = json_encode( apply_filters( 'pwa_admin_footer_js', $defaults ) );

		wp_add_inline_script( pwa_get_instance()->prefix . '-admin-script', "var PwaJsVars = {$vars};", 'before' );
	}

	/**
	 * Default Settings
	 */
	public function default_settings() {
		$options = get_option( pwa_settings()->option_key, false );
		if ( ! $options ) {

			$short_name = get_bloginfo( 'name' );
			if ( strlen( $short_name ) > 12 ) {
				$short_name = substr( $short_name, 0, 9 ) . '...';
			}

		    update_option( pwa_settings()->option_key, [
		    	'pulltonavigate-enabled'    => 1,
		    	'shake-enabled'             => 1,
		    	'vibrate-enabled'           => 1,
		    	'reactify-enabled'          => 0,
		    	'register-push'             => 1,
		    	'swipe-enabled'             => 0,
		    	'preloader-enabled'         => 0,
		    	'transition-enabled'        => 0,
		    	'toast-enabled'             => 1,
		    	'manifest-name'             => get_bloginfo( 'name' ),
		    	'manifest-short-name'       => $short_name,
		    	'manifest-starturl'         => './',
		    	'manifest-description'      => get_bloginfo( 'description' ),
		    	'manifest-display'          => 'standalone',
		    	'manifest-orientation'      => 'any',
		    	'manifest-statusbar'        => 'default',
		    	'manifest-theme-color'      => '#000000',
		    	'manifest-background-color' => '#ffffff',
		    	'instovrlyschrome-enabled'  => 1,
		    	'instovrlyssafari-enabled'  => 1,
		    	'instovrlysfirefox-enabled' => 1,
		    	'instovrlys-hidefordays'    => '2',
		    	'iospersist-enabled'        => 1,
		    	'offline-enabled'           => 1,
		    	'offline-indicator-enabled' => 1,
		    	'offline-content'           => '',
		    	'minify'                    => 0,
		    	'deliverycss'               => 0,
		    	'deliveryjs'                => 0,
		    	'compressfiles'             => 0,
		    	'cachingheaders'            => 0
		    ] );
		}
	}

	public function StartSession() {
        if(!session_id()) {

            session_start(); 
        
            $cookieLifetime = 365 * 24 * 60 * 60;
            setcookie(session_name(),session_id(),time()+$cookieLifetime);
        }
    }

    public function EndSession() {
        session_destroy();
    }
}