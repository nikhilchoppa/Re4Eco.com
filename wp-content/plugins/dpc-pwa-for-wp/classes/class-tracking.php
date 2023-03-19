<?php

namespace PWAForWP;

class Tracking {

	public $capability = '';
	public $utm_types = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
		$this->utm_types  = [
			'starturl' => [
				'title' => __( '📈 Start URL Tracking', 'pwa' ),
				'desc'  => __( '%s will be added to the start URL', 'pwa' ),
			]
		];

		if ( ! pwa_onesignal() ) {
			$this->utm_types['pushurl'] = [
				'title' => __( '📈 Push URL Tracking', 'pwa' ),
				'desc'  => __( '%s will be added to the push notification redirect URL', 'pwa' ),
			];
		}
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ], 500 );
		add_filter( 'pwa_manifest_values', [ $this, 'tracking_to_starturl' ], 500 );
		add_filter( 'pwa_push_data_values', [ $this, 'tracking_to_pushurl' ], 500 );
	}

	public function register_settings() {

		$this->utm_parameters();

		foreach ( $this->utm_types as $key => $vals ) {

			$parameters = get_option( "pwa-tracking-$key-parameters" );
			if ( ! $parameters ) {
				$parameters = 'nothing';
			}

			$section_page = '';
			if ( 'starturl' == $key ) {
				$section_page = pwa_settings_page_addtohomescreen();
			} elseif ( 'pushurl' == $key ) {
				if ( ! pwa_push_set() ) {
					continue;
				}
				$section_page = pwa_settings_page_push();
			}

			$section_desc = sprintf( $vals['desc'], '<code>' . $parameters . '</code>' );
			$section      = pwa_settings()->add_section( $section_page, "pwa-tracking-$key", $vals['title'], $section_desc );

			pwa_settings()->add_input( $section, "pwa-tracking-$key-source", __( 'Campaign Source', 'pwa' ), '', [
				'after_field' => '<p class="pwa-smaller">' . __( 'The referrer: (e.g. google, newsletter)', 'pwa' ) . '</p>',
			] );
			pwa_settings()->add_input( $section, "pwa-tracking-$key-medium", __( 'Campaign Medium', 'pwa' ), '', [
				'after_field' => '<p class="pwa-smaller">' . __( 'Marketing medium: (e.g. cpc, banner, email)', 'pwa' ) . '</p>',
			] );
			pwa_settings()->add_input( $section, "pwa-tracking-$key-campaign", __( 'Campaign Name', 'pwa' ), '', [
				'after_field' => '<p class="pwa-smaller">' . __( 'Product, promo code, or slogan (e.g. spring_sale)', 'pwa' ) . '</p>',
			] );
			pwa_settings()->add_input( $section, "pwa-tracking-$key-term", __( 'Campaign Term', 'pwa' ) );
			pwa_settings()->add_input( $section, "pwa-tracking-$key-content", __( 'Campaign Content', 'pwa' ), '', [
				'after_field' => '<p class="pwa-smaller">' . __( 'Use to differentiate ads', 'pwa' ) . '</p>',
			] );
		}
	}

	public function utm_parameters() {

		foreach ( $this->utm_types as $key => $vals ) {

			$parameters = [];
			foreach ( [ 'source', 'medium', 'term', 'content', 'campaign' ] as $p ) {
				$setting = pwa_get_setting( "pwa-tracking-$key-$p" );
				if ( $setting ) {
					$setting      = rawurlencode( $setting );
					$parameters[] = "utm_$p=$setting";
				}
			}
			if ( empty( $parameters ) ) {
				update_option( "pwa-tracking-$key-parameters", false );
			} else {
				update_option( "pwa-tracking-$key-parameters", implode( '&', $parameters ) );
			}
		}
	}

	public function tracking_to_starturl( $values ) {
		$parameters = get_option( 'pwa-tracking-starturl-parameters' );
		if ( $parameters && array_key_exists( 'start_url', $values ) ) {
			$values['start_url'] = $values['start_url'] . '?' . $parameters;
		}

		return $values;
	}

	public function tracking_to_pushurl( $values ) {
		$parameters = get_option( 'pwa-tracking-pushurl-parameters' );
		if ( $parameters && '' != $values['redirect'] ) {
			$values['redirect'] = $values['redirect'] . '?' . $parameters;
		}

		return $values;
	}
}