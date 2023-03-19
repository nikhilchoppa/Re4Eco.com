<?php

namespace PWAForWP;

class Offlineusage {

	public $capability = '';

	public function __construct() {
		$this->capability     = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'settings' ] );
		add_filter( pwa_settings()->sanitize_filter . '_offline-content', [ $this, 'sanitize_offline_content' ] );
		add_filter( 'pwa_sw_content', [ $this, 'sw_content' ] );
		add_action( 'pwa_settings', [ $this, 'offline_indicator_settings' ] );
		add_action( 'pwa_settings', [ $this, 'offline_forms_settings' ] );
		add_action( 'wp_footer', [ $this, 'offline_forms_handle' ] );
	}

	public function settings() {
        $section_desc = '';
		$section_desc .= __( 'Offline usage adds offline support and reliable performance on your web app. This allows a visitor to load any previously viewed page while they are offline or on low connectivity network. The plugin also defines a special “offline page”, which allows you to customize a message and the experience if the app is offline and the page is not in the cache.', 'pwa' );
		$section      = pwa_settings()->add_section( pwa_settings_page_offlineusage(), 'pwa_offlineusage', __( '📴️ Offline Usage', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'offline-enabled', __( 'Enable Offline Usage', 'pwa' ) );

		$choices = [];
		foreach ( get_pages() as $post ) {
			if ( get_option( 'page_on_front' ) == $post->ID ) {
				continue;
			}
			$choices[ $post->ID ] = get_the_title( $post );
		}
		pwa_settings()->add_select( $section, 'offline-page', __( 'Offline Page', 'pwa' ), $choices, '', [
			'after_field' => '<p class="pwa-smaller">' . __( 'This page should contain a message explaining why the requested content is not available.', 'pwa' ) . '</p>',
		] );

		$text = __( 'Pages and files that should be saved for offline usage on first interaction. One URL per line.', 'pwa' ) . '<br>';
		// translators: Every URL has to start with: [site_url]
		$text .= sprintf( __( 'Every URL has to start with: %1$s', 'pwa' ), '<code>' . untrailingslashit( get_site_url() ) . '</code>' );

		pwa_settings()->add_textarea( $section, 'offline-content', __( 'Offline Content', 'pwa' ), '', [
			'after_field' => '<p class="pwa-smaller">' . $text . '</p>',
		] );
	}

	public function sanitize_offline_content( $content ) {
		$files = explode( "\n", $content );
		if ( ! is_array( $files ) ) {
			return $files;
		}

		$new_files = [];
		foreach ( $files as $key => $file ) {

			$file     = esc_url( $file );
			$site_url = untrailingslashit( get_site_url() );

			if ( strpos( $file, $site_url ) === 0 ) {
				$new_files[] = $file;
			}
		}

		return implode( "\n", $new_files );
	}

	public function sw_content( $content ) {

		$offline_enabled = pwa_get_setting( 'offline-enabled' );
		if ( ! $offline_enabled ) {
			return $content;
		}

		$offline_content = '';
		$cache_pages     = [];
		$site_url        = pwa_register_url( trailingslashit( get_site_url() ) );
		$cache_pages[]   = $site_url;

		$offline_page_id = intval( pwa_get_setting( 'offline-page' ) );
		if ( 'page' == get_post_type( $offline_page_id ) ) {
			$offline_url   = pwa_register_url( get_permalink( $offline_page_id ) );
			$cache_pages[] = $offline_url;
		}

		$additional_urls = pwa_get_setting( 'offline-content' );
		$additional_urls = explode( "\n", $additional_urls );
		if ( is_array( $additional_urls ) ) {
			foreach ( $additional_urls as $url ) {
				$cache_pages[] = pwa_register_url( $url );
			}
		}

		$cache_pages        = apply_filters( 'pwa_cache_pages', $cache_pages );
		$cache_pages_quoted = [];
		foreach ( $cache_pages as $url ) {
			$cache_pages_quoted[] = "'$url'";
		}

		$sw_data = [
			'offline'      => $offline_enabled,
			'offline_page' => str_replace( trailingslashit( get_site_url() ), '', get_permalink( $offline_page_id ) ),
			'cached_pages' => '[' . implode( ',', $cache_pages_quoted ) . ']',
		];

		$offline_file = plugin_dir_path( pwa_get_instance()->file ) . '/assets/serviceworker/offline.js';
		if ( file_exists( $offline_file ) && $offline_enabled ) {
			$offline_content .= file_get_contents( $offline_file );
		} else {
			return $content;
		}

		foreach ( $sw_data as $key => $val ) {
			$offline_content = str_replace( "{{{$key}}}", $val, $offline_content );
		}

		return $content . $offline_content;
	}

	public function offline_indicator_settings() {
		$section_desc = __( 'Adds a notice which will be displayed if the user is offline.', 'pwa' ) . '<br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_offlineusage(), 'pwa_offlineindicator', __( '🏴 Offline Indicator', 'pwa' ), $section_desc );
		pwa_settings()->add_checkbox( $section, 'offline-indicator-enabled', __( 'Enable Offline Indicator', 'pwa' ), false );
	}

	public function offline_forms_settings() {
		$section_desc = '<b>' . __( 'Add functionality to save forms submitted by your users when they were offline, then automatically sync once the user is online and submit pending forms using AJAX.', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_offlineusage(), 'pwa_offlineforms', __( '📝 Offline Forms', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'offlineforms-enabled', __( 'Enable Offline Forms', 'pwa' ) );		
	}

	public function offline_forms_handle() {
		if ( pwa_get_setting( 'offlineforms-enabled' ) ) {
		    echo "<script type='text/javascript'>
		    		    document.addEventListener('DOMContentLoaded', function(event) { 
                        	Array.from(document.querySelectorAll('form')).forEach(function (form) {
                            	new OfflineForm(form);
                            });
                        });
                 </script>";
        }	
	}
}