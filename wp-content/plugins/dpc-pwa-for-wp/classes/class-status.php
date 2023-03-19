<?php

namespace PWAForWP;

class Status {

	public $upload_dir = '';
	public $upload_url = '';

	public function __construct() {

		$this->upload_dir = pwa_get_instance()->upload_dir . '/debug/';
		$this->upload_url = pwa_get_instance()->upload_url . '/debug/';
	}

	public function run() {

		/**
		 * Page
		 */

		add_action( 'pwa_settings', [ $this, 'settings_stats' ] );
		add_action( 'pwa_settings', [ $this, 'settings_logs' ] );

		/**
		 * Ajax
		 */

		add_action( 'wp_ajax_pwa_ajax_download_log-debug-log', [ $this, 'download_log' ] );

		/**
		 * Clear
		 */

		add_action( 'init', [ $this, 'delete_logfiles' ] );
	}

	/**
	 * Page
	 */

	public function settings_stats() {
		$section = pwa_settings()->add_section( pwa_settings_page_main(), 'pwa_intro_stats', __( '✅ Status', 'pwa' ) );

		$check = $this->get_stats();

		foreach ( $check as $key => $vals ) {
			$html       = '';
			$icon_check = $this->get_icon( 'check' );
			$icon_close = $this->get_icon( 'close' );

			if ( $vals['true'] ) {
				$html .= "<span class='pwa-status pwa-status--success'><span class='pwa-status__icon'>$icon_check</span>{$vals['text_true']}</span>";
			} else {
				$html .= "<span class='pwa-status pwa-status--error'><span class='pwa-status__icon'>$icon_close</span>{$vals['text_false']}</span>";
			}
			pwa_settings()->add_message( $section, "pwa_intro_stats_$key", $vals['title'], $html );
		}
	}

	public function settings_logs() {
        $html = '';
		$html .= sprintf( __( 'Still not working? Please contact us through our Codecanyon profile %s.', 'pwa' ), '<a href="https://codecanyon.net/user/daftplug" target="_blank">' . __( 'contact form', 'pwa' ) . '</a>' );
		$html .= '<br><br><small><b>' . __( 'Attention!', 'pwa' ) . '</b> ' . __( 'The Debug Log contains information that should not be public.', 'pwa' ) . '</small>';

		$section = pwa_settings()->add_section( pwa_settings_page_main(), 'pwa_intro_help', __( '🆘 Need Help?', 'pwa' ), '<p>' . $html . '</p>' );

		$html = '<button class="button pwa-download-log" data-log="debug-log">' . __( 'Download Logfile', 'pwa' ) . '</button>';
		pwa_settings()->add_message( $section, 'pwa_intro_logs_debug', __( 'Debug Log', 'pwa' ), $html );
	}

	/**
	 * Ajax
	 */

	public function download_log() {

		$log = $this->generate_debug_log();
		if ( $log ) {
			pwa_exit_ajax( 'success', '', [
				'url'  => $log,
				'file' => 'pwa-for-wp-debug-log.json',
			] );
		} else {
			pwa_exit_ajax( 'error', __( 'Logfile could not be created', 'pwa' ) );
		}

		pwa_exit_ajax( 'error', __( 'Error', 'pwa' ) );
	}

	public function delete_logfiles() {
		if ( is_dir( $this->upload_dir ) ) {
			self::empty_dir( $this->upload_dir );
		}
	}

	/**
	 * Helpers
	 */

	public function generate_debug_log() {

		if ( ! is_dir( $this->upload_dir ) ) {
			mkdir( $this->upload_dir );
		}

		$log              = [];
		$log['generated'] = date( 'Y-m-d H:i (T)' );
		$log['site_url']  = get_option( 'siteurl' );
		$log['home_url']  = get_home_url();
		global $wp_version;
		$log['wpversion']  = $wp_version;
		$log['multisite']  = is_multisite();
		$log['phpversion'] = phpversion();

		$log['stats'] = [];
		$stats        = $this->get_stats();
		foreach ( $stats as $key => $vals ) {
			$log['stats'][ $key ] = $vals['true'];
		}

		$log['settings']       = get_option( pwa_settings()->option_key );
		$log['active_plugins'] = [];
		foreach ( get_option( 'active_plugins' ) as $plugin ) {
			$log['active_plugins'][ $plugin ] = get_plugin_data( ABSPATH . 'wp-content/plugins/' . $plugin );
		}

		$theme               = wp_get_theme();
		$log['active_theme'] = [
			'name'           => $theme->get( 'Name' ),
			'author'         => $theme->get( 'Author' ),
			'authoruri'      => $theme->get( 'AuthorURI' ),
			'version'        => $theme->get( 'Version' ),
			'template_dir'   => get_template_directory(),
			'stylesheet_dir' => get_stylesheet_directory(),
		];

		$file = 'debug_log_' . time() . '.json';
		$put  = pwa_put_contents( $this->upload_dir . $file, json_encode( $log ) );
		if ( ! $put ) {
			return false;
		}

		return $this->upload_url . $file;
	}

	public function get_icon( $key ) {
		$icon_path = plugin_dir_path( pwa_get_instance()->file ) . "assets/img/icon/$key.svg";
		if ( file_exists( $icon_path ) ) {
			return file_get_contents( $icon_path );
		}

		return false;
	}

	public function get_stats() {
		return [
			'siteicon'     => [
				'title'      => __( 'Site Icon', 'pwa' ),
				'true'       => has_site_icon(),
				'text_true'  => __( 'Site Icon selected successfully.', 'pwa' ),
				'text_false' => __( 'Site Icon is not selected.', 'pwa' ),
			],
			'push'         => [
				'title'      => __( 'Push Notifications', 'pwa' ),
				'true'       => pwa_push_set() || pwa_onesignal(),
				'text_true'  => (pwa_onesignal() ? __( 'You are using OneSignal for Push Notifications.', 'pwa' ) : __( 'Push Notifications are set successfully.', 'pwa' )),
				'text_false' => __( 'Your site is not using Push Notifications.', 'pwa' ),
			],
			'https'        => [
				'title'      => __( 'HTTPS', 'pwa' ),
				'true'       => is_ssl(),
				'text_true'  => __( 'Your site is serverd over HTTPS.', 'pwa' ),
				'text_false' => __( 'Your site has to be served over HTTPS.', 'pwa' ),
			],
		];
	}

	public static function empty_dir( $dir ) {
		if ( ! is_dir( $dir ) ) {
			throw new InvalidArgumentException( "$dir must be a directory" );
		}
		if ( substr( $dir, strlen( $dir ) - 1, 1 ) != '/' ) {
			$dir .= '/';
		}
		$files = glob( $dir . '*', GLOB_MARK );
		foreach ( $files as $file ) {
			if ( is_dir( $file ) ) {
				self::empty_dir( $file );
			} else {
				unlink( $file );
			}
		}
		rmdir( $dir );
	}
}