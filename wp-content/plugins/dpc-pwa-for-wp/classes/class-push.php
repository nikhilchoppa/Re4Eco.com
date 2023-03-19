<?php

namespace PWAForWP;

class Push {

	public $devices_option = 'pwa-push-devices';
	public $latestpushes_option = 'pwa-latest-pushes';
	public $latest_push_path = '';
	public $latest_push_url = '';
	public $upload_dir = '';
	public $upload_url = '';

	public function __construct() {
		$this->latest_push_path          = WP_CONTENT_DIR . '/pwa-latest-push.json';
		$this->latest_push_url           = content_url() . '/pwa-latest-push.json';
		$this->upload_dir                = pwa_get_instance()->upload_dir . '/push-log/';
		$this->upload_url                = pwa_get_instance()->upload_url . '/push-log/';
		$GLOBALS['pwa_push_modal_count'] = 0;
	}

	public function run() {

		if ( ! pwa_push_set() ) {
			return;
		}

		if ( ! is_dir( $this->upload_dir ) ) {
			mkdir( $this->upload_dir );
		}

		add_filter( 'pwa_sw_content', [ $this, 'sw_content' ], 1 );

		add_action( 'pwa_settings', [ $this, 'settings_push' ] );
		add_action( 'pwa_settings', [ $this, 'settings_button' ] );
		add_action( 'pwa_settings', [ $this, 'settings_devices' ] );

		add_filter( 'pwa_footer_js', [ $this, 'footer_js' ] );

		/**
		 * Subscribe Notifications
		 */

		add_action( 'wp_footer', [ $this, 'subscribe_push' ] );
		add_shortcode( 'pwa_notification_button', [ $this, 'shortcode_template' ] );

		/**
		 * Notifications Button
		 */

		add_action( 'wp_footer', [ $this, 'footer_template' ] );
		add_shortcode( 'pwa_notification_button', [ $this, 'shortcode_template' ] );

		/**
		 * Ajax
		 */

		add_action( 'wp_ajax_pwa_ajax_handle_device_id', [ $this, 'handle_device_id' ] );
		add_action( 'wp_ajax_nopriv_pwa_ajax_handle_device_id', [ $this, 'handle_device_id' ] );

		add_action( 'wp_ajax_pwa_push_do_push', [ $this, 'do_modal_push' ] );

		/**
		 * Log
		 */

		add_action( 'pwa_settings', [ $this, 'settings_log' ], 50 );
		add_action( 'wp_ajax_pwa_ajax_download_log-push-log', [ $this, 'download_log' ] );

	}

	public function sw_content( $content ) {

		$push_content = '';
		$push_file    = plugin_dir_path( pwa_get_instance()->file ) . '/assets/serviceworker/push.js';
		if ( file_exists( $push_file ) ) {

			$push_content .= file_get_contents( $push_file );
		} else {
			return $content;
		}

		return $content . $push_content;

	}

	public function settings_push() {

		if ( pwa_onesignal() ) {
			return;
		}

		$section = pwa_settings()->add_section( pwa_settings_page_push(), 'pwa_push_push', __( '📢 Push Notification Settings', 'pwa' ) );

        pwa_settings()->add_checkbox( $section, 'register-push', __( 'Ask users to subscribe notifications on load', 'pwa' ), false );
		pwa_settings()->add_checkbox( $section, 'push-failed-remove', __( 'Remove devices if failed to notify once', 'pwa' ), false );
		pwa_settings()->add_file( $section, 'push-badge', __( 'Notification Bar Icon', 'pwa' ), 0, [
			'mimes'       => 'png',
			'min-width'   => 96,
			'min-height'  => 96,
			'after_field' => '<p class="pwa-smaller">' . __( 'This image will represent the notification when there is not enough space to display the notification itself such as, for example, the Android Notification Bar. It will be automatically masked. For the best result use a single-color graphic with transparent background.', 'pwa' ) . '<br>' . __( 'Has to be at least 92x92px', 'pwa' ) . '</p>',
		] );
	}

	public function settings_button() {
		$section_desc = __( 'Adds "Get Push Notifications" button to your web app.', 'pwa' );
		$section      = pwa_settings()->add_section( pwa_settings_page_push(), 'pwa_push_button', __( '🔔 Push Notifications Button', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'notification-button', __( 'Add Notification Button', 'pwa' ) );
		pwa_settings()->add_color( $section, 'notification-button-icon-color', __( 'Icon Color', 'pwa' ), '#ffffff' );
		pwa_settings()->add_color( $section, 'notification-button-bkg-color', __( 'Background Color', 'pwa' ), '#333333' );
		pwa_settings()->add_select( $section, 'notification-button-position', __( 'Position', 'pwa' ), [
			'bottom-left' => __( 'Bottom Left', 'pwa' ),
			'top-left'    => __( 'Top Left', 'pwa' ),
			'bottom-right'    => __( 'Bottom Right', 'pwa' ),
			'top-right'    => __( 'Top Right', 'pwa' ),
		], 'bottom-left' );
	}

	public function settings_devices() {

		$send = '<p style="margin-bottom: 30px;line-height: 250%;text-align: center;"><b>' . __( 'Send to all devices', 'pwa' ) . ':</b><br>' . $this->render_push_modal() . '</p>';

		$devices = get_option( $this->devices_option );
		$table   = '';
		//$table   .= '<pre>' . print_r( $devices, true ) . '</pre>';
		$table .= '<table class="pwa-devicestable">';
		$table .= '<thead><tr><th>' . __( 'Device', 'pwa' ) . '</th><th>' . __( 'Registered', 'pwa' ) . '</th><th></th></tr></thead>';
		$table .= '<tbody>';
		if ( empty( $devices ) ) {
			$table .= '<tr><td colspan="3" class="empty">' . __( 'No devices registered', 'pwa' ) . '</td></tr>';
		} else {
			foreach ( $devices as $device ) {
				//$table .= '<pre>' . print_r( get_option( $this->devices_option ), true ) . '</pre>';
				$table .= '<tr>';
				$table .= '<td>';
				if ( isset( $device['data']['device']['vendor'] ) && isset( $device['data']['device']['device'] ) ) {
					$table .= "<span class='devices-item devices-item--device'>{$device['data']['device']['vendor']} {$device['data']['device']['device']}</span>";
				}
				if ( isset( $device['data']['browser']['browser'] ) && isset( $device['data']['browser']['major'] ) ) {
					$title = __( 'Browser', 'pwa' );
					$table .= "<span class='devices-item devices-item--browser'>$title: {$device['data']['browser']['browser']} {$device['data']['browser']['major']}</span>";
				}
				if ( isset( $device['data']['os']['os'] ) && isset( $device['data']['os']['version'] ) ) {
					//$title = __( 'Operating system', 'pwa' );
					$table .= "<span class='devices-item devices-item--os'>{$device['data']['os']['os']} {$device['data']['os']['version']}</span>";
				}
				$table .= '</td>';
				$table .= '<td>';
				$date  = date( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $device['time'] );
				$table .= "<span class='devices-item devices-item--date'>{$date}</span>";
				if ( 0 != $device['wp_user'] ) {
					$display_name = get_userdata( $device['wp_user'] )->display_name;
					$table        .= "<span class='devices-item devices-item--user'>{$display_name}</span>";
				}
				$table .= '</td>';
				$table .= '<td>';
				//$table .= '<span class="devices-actions devices-actions--send"><a class="button" onclick="alert(\'Sorry not yet ready\');">send push</a></span>';
				$table .= $this->render_push_modal( '', '', '', 0, $device['id'] );
				$table .= '<span class="devices-actions devices-actions--delete"><a id="pwaDeleteDevice" data-deviceid="' . $device['id'] . '" class="button button-pwadelete">' . __( 'Remove Device', 'pwa' ) . '</a></span>';
				$table .= '</td>';
				$table .= '</tr>';
			}
		}
		$table .= '</tbody>';
		$table .= '</table>';

		$section = pwa_settings()->add_section( pwa_settings_page_push(), 'pwa_devices', __( '📲 Subscribed Devices', 'pwa' ), $send . "<div class='pwa-devicestable__container'>$table</div>" );
	}

	public function footer_js( $args ) {
		$args['message_pushremove_failed'] = __( 'Notifications could not be turned off!', 'pwa' );
		$args['message_pushadd_failed']    = __( 'Notifications are blocked!', 'pwa' );
		$args['message_pushremove_success'] = __( 'Notifications are turned off!', 'pwa' );
		$args['message_pushadd_success']    = __( 'Notifications are turned on!', 'pwa' );

		return $args;
	}

	/**
	 * notification Button
	 */

	public function footer_template() {

		if ( ! pwa_get_setting( 'notification-button' ) ) {
			return;
		}

		$background_color = pwa_get_setting( 'notification-button-bkg-color' );
		$icon_color       = pwa_get_setting( 'notification-button-icon-color' );
		$position         = explode("-",pwa_get_setting( 'notification-button-position' ));

		if ( ! $this->is_hex( $background_color ) ) {
			$background_color = '#dd3333';
		}
		if ( ! $this->is_hex( $icon_color ) ) {
			$icon_color = '#fff';
		}

		$atts = [
			'class' => 'notification-button--fixedfooter',
			'style' => "background-color: $background_color; color: $icon_color; font-size: 35px; $position[0]: .7em; $position[1]: .7em;",
		];

		echo pwa_get_notification_button( $atts );
	}

	public function subscribe_push() {
		if ( ! pwa_get_setting( 'register-push' ) ) {
			return;
		}
        echo '<span id="loadnotify"></span>';
	}

	public function shortcode_template( $atts, $content = '' ) {

		$atts = shortcode_atts( [
			'size'  => '1rem',
			'class' => '',
		], $atts );

		$attributes = [
			'class' => $atts['class'],
			'style' => "font-size: {$atts['size']};",
		];

		return pwa_get_notification_button( $attributes );
	}

	/**
	 * Ajax
	 */

	public function handle_device_id() {

		if ( ! isset( $_POST['user_id'] ) || '' == $_POST['user_id'] ) {
			pwa_exit_ajax( 'error', 'user ID error' );
		}

		if ( ! isset( $_POST['handle'] ) || ! in_array( $_POST['handle'], [ 'add', 'remove' ] ) ) {
			pwa_exit_ajax( 'error', 'handle error' );
		}

		$device_id  = $_POST['user_id'];
		$device_key = sanitize_title( $device_id );
		$handle     = $_POST['handle'];
		$devices    = get_option( $this->devices_option );
		if ( ! is_array( $devices ) ) {
			$devices = [];
		}

		$do_first_push = false;

		if ( 'add' == $handle ) {

			/**
			 * Check if is new device
			 */

			if ( ! array_key_exists( $device_key, $devices ) ) {
				$do_first_push = true;
			}

			/**
			 * Add Device
			 */

			$handled                = 'added';
			$devices[ $device_key ] = [
				'id'      => $device_id,
				'wp_user' => get_current_user_id(),
				'time'    => time(),
				'data'    => $_POST['clientData'],
				'groups'  => [],
			];

			$userdata = get_userdata( get_current_user_id() );

			if ( is_object( $userdata ) && is_array( $userdata->roles ) ) {
				$devices[ $device_key ]['groups'] = array_merge( $devices[ $device_key ]['groups'], $userdata->roles );
			}
		} elseif ( 'remove' == $handle ) {

			/**
			 * Remove Device
			 */

			$handled = 'removed';
			unset( $devices[ $device_key ] );
		} // End if().

		update_option( $this->devices_option, $devices );

		/*
		if ( $do_first_push ) {
			$data = [
				'title'    => 'hello!',
				'body'     => __( 'Sie werden von nun an auf diesem Weg ab und zu ausgewählte Neuigkeiten erhalten.', 'pwa' ),
				'redirect' => '',
				'groups'   => [
					$device_id,
				],
			];
			$this->do_push( $data );
		}
		*/
		pwa_exit_ajax( 'success', "Device ID $device_id successfully $handled" );
	}

	public function do_modal_push() {

		if ( ! wp_verify_nonce( $_POST['pwa-push-nonce'], 'pwa-push-action' ) ) {
			pwa_exit_ajax( 'success', 'Error' );
		}

		$image_id  = $_POST['pwa-push-image'];
		$image_url = '';
		if ( 'attachment' == get_post_type( $image_id ) ) {
			$image = pwa_get_instance()->image_resize( $image_id, 500, 500, true );
			if ( $image ) {
				$image_url = $image[0];
			}
		}

		$data = [
			'title'     => sanitize_text_field( $_POST['pwa-push-title'] ),
			'body'      => sanitize_text_field( $_POST['pwa-push-body'] ),
			'redirect'  => esc_url_raw( $_POST['pwa-push-url'] ),
			'image_url' => esc_url_raw( $image_url ),
			'groups'    => [],
		];

		if ( '' != $_POST['pwa-push-limit'] ) {
			$post_groups = explode( ', ', $_POST['pwa-push-limit'] );
			foreach ( $post_groups as $group ) {
				$data['groups'][] = $group;
			}
		}

		$return = $this->do_push( $data );
		if ( 'success' == $return['type'] && $_POST['pwa-push-pushpost'] ) {
			update_post_meta( $_POST['pwa-push-pushpost'], 'pwa_pushpost', 'done' );
		}

		pwa_exit_ajax( $return['type'], $return['message'], $return );
	}

	/**
	 * Log
	 */

	public function settings_log() {

		if ( ! $this->latest_push_log() ) {
			return;
		}

		$html = '<button class="button pwa-download-log" data-log="push-log">' . __( 'Download Logfile', 'pwa' ) . '</button>';
		pwa_settings()->add_message( 'pwa-section-pwa_intro_help', 'pwa_intro_logs_push', __( 'Latest Push Log', 'pwa' ), $html );
	}

	public function download_log() {

		$log = $this->latest_push_log();
		if ( $log ) {
			pwa_exit_ajax( 'success', '', [
				'url'  => $log,
				'file' => 'pwa-for-wp-latest-push-log.json',
			] );
		} else {
			pwa_exit_ajax( 'error', __( 'Logfile could not be created', 'pwa' ) );
		}

		pwa_exit_ajax( 'error', __( 'Error', 'pwa' ) );
	}

	/**
	 * Send push
	 */

	public function render_push_modal( $title = '', $body = '', $url = '', $image_id = 0, $limit = '', $pushpost = '' ) {

		if ( is_admin() ) {
			add_thickbox();
		}

		$image_thumbnail = '';
		if ( 'attachment' != get_post_type( $image_id ) ) {
			$image_id = 0;
		} else {
			$image_thumbnail = wp_get_attachment_image( $image_id );
		}

		if ( '' == $url ) {
			$url = trailingslashit( get_home_url() );
		}

		$fields = [
			'title' => [
				'name'  => __( 'Title', 'pwa' ),
				'value' => $title,
			],
			'body'  => [
				'name'  => __( 'Body', 'pwa' ),
				'value' => $body,
			],
			'url'   => [
				'name'  => __( 'URL', 'pwa' ),
				'value' => $url,
			],
			'image' => [
				'name'  => __( 'Image', 'pwa' ),
				'value' => $image_id,
			],
		];

		$icon      = '';
		$icon_path = plugin_dir_path( pwa_get_instance()->file ) . 'assets/img/icon/check.svg';
		if ( file_exists( $icon_path ) ) {
			$icon = file_get_contents( $icon_path );
		}

		$GLOBALS['pwa_push_modal_count'] ++;

		$r = '';
		$r .= '<a id="pwa-pushmodal-trigger" href="#TB_inline&inlineId=pwa-pushmodal-container-' . $GLOBALS['pwa_push_modal_count'] . '&width=400&height=510&class=test" class="thickbox button">' . __( 'Send Push Notification', 'pwa' ) . '</a>';
		$r .= '<div id="pwa-pushmodal-container-' . $GLOBALS['pwa_push_modal_count'] . '" style="display: none;">';
		$r .= '<div class="pwa-pushmodal">';
		$r .= '<h3 style="text-align:center">' . __( '📢 New Push Notification', 'pwa' ) . '</h3>';
		if ( '' != $limit ) {
			$r .= '<b>' . __( 'This notification will be sent to the selected device.', 'pwa' ) . '</b><br><br>';
		}
		foreach ( $fields as $key => $args ) {
			$r .= "<label class='pwa-pushmodal__label pwa-pushmodal__label--$key'><b>{$args['name']}:</b>";
			if ( 'image' == $key ) {
				$r .= "<input type='hidden' name='pwa-push-{$key}' value='{$args['value']}' />";
				$r .= '<span class="pwamodal-uploader">';
				$r .= '<span class="pwamodal-uploader__image">' . $image_thumbnail . '</span><a id="uploadImage" class="button">' . __( 'upload image', 'pwa' ) . '</a><a id="removeImage" class="button button-pwadelete">' . __( 'remove image', 'pwa' ) . '</a>';
				$r .= '</span>';
			} else {
				$r .= "<input type='text' name='pwa-push-{$key}' value='{$args['value']}' />";
			}
			$r .= '</label>';
		}
		$r .= "<input type='hidden' name='pwa-push-limit' value='$limit' />";
		$r .= '<input type="hidden" name="pwa-push-action" value="pwa_push_do_push" />';
		$r .= '<input type="hidden" name="pwa-push-pushpost" value="' . $pushpost . '" />';
		$r .= wp_nonce_field( 'pwa-push-action', 'pwa-push-nonce', true, false );
		$r .= '<div class="pwa-pushmodal__label pwa-pushmodal__controls"><a id="send" class="button button-primary">' . __( 'Send push', 'pwa' ) . '</a></div>';
		$r .= '<div class="loader"></div>';
		$r .= '<div class="success"><div class="success__content">' . $icon . __( 'Notifications have been sent', 'pwa' ) . '</div></div>';
		$r .= '</div>';
		$r .= '</div>';

		return $r;
	}

	private function do_push( $data ) {

		$log = [];

		$server_key = pwa_get_setting( 'firebase-serverkey' );
		if ( ! pwa_get_instance()->PushCredentials->validate_serverkey( $server_key ) ) {
			return [
				'type'    => 'error',
				'message' => __( 'Invalid firebase server key', 'pwa' ),
			];
		}

		$send_tos = $data['groups'];
		unset( $data['groups'] );

		$devices = [];
		foreach ( get_option( $this->devices_option ) as $device_data ) {
			$add_device = false;
			if ( empty( $send_tos ) ) {
				// send if no limitation set
				$add_device = true;
			} else {
				foreach ( $send_tos as $send_to ) {
					if ( $device_data['id'] == $send_to ) {
						$add_device = true;
					}
				}
			}
			if ( $add_device ) {
				$devices[]        = $device_data['id'];
				$log['devices'][] = $device_data;
			}
		}

		if ( ! is_array( $devices ) || count( $devices ) == 0 ) {
			return [
				'type'    => 'error',
				'message' => __( 'No devices set', 'pwa' ),
			];
		}

		/**
		 * Badge
		 */

		$badge     = pwa_get_setting( 'push-badge' );
		$badge_url = '';
		if ( 'attachment' == get_post_type( $badge ) ) {
			$badge_image = pwa_get_instance()->image_resize( $badge, 96, 96, true );
			if ( $badge_image ) {
				$badge_url = $badge_image[0];
			}
		} else {
			$badge_url = '';
		}

		/**
		 * Icon
		 */

		$data['icon'] = $data['image_url'];

		/**
		 * Full data
		 */

		$data = shortcode_atts( [
			'title'    => 'Notification Title', // Notification title
			'badge'    => $badge_url, // small Icon for the notificaion bar (96x96 px, png)
			'body'     => '', // Notification message
			'icon'     => '', // small image
			'image'    => '', // bigger image
			'redirect' => '', // url
		], $data );

		$data = apply_filters( 'pwa_push_data_values', $data );

		$log['message'] = $data;

		$fields = [
			'registration_ids' => $devices,
			'data'             => [
				'message' => $data,
			],
		];

		$put_latest_post = pwa_put_contents( $this->latest_push_path, json_encode( $data ) );
		if ( ! $put_latest_post ) {
			return [
				'type'    => 'error',
				'message' => __( 'Could not write latest_push_json', 'pwa' ),
			];
		}

		$headers = [
			'Authorization: key=' . $server_key,
			'Content-Type: application/json',
		];

		$ch = curl_init();

		curl_setopt( $ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
		$result = curl_exec( $ch );
		curl_close( $ch );

		$result = json_decode( $result, true );

		/**
		 * Check for failed push keys and remove them
		 */

		$success = [];
		$failed  = [];

		if ( pwa_get_setting( 'push-failed-remove' ) ) {
			foreach ( $result['results'] as $key => $answer ) {
				if ( array_key_exists( 'error', $answer ) ) {
					$failed[] = $devices[ $key ];
				} else {
					$success[] = $devices[ $key ];
				}
			}

			if ( ! empty( $failed ) ) {
				$old_devices = get_option( $this->devices_option );
				foreach ( $failed as $f ) {
					$f_key = sanitize_key( $f );
					unset( $old_devices[ $f_key ] );
				}
				update_option( $this->devices_option, $old_devices );
			}
		}

		/**
		 * Save Push
		 */

		$log['resp'] = $result;

		$file = 'push_log_' . time() . wp_generate_password( 30, false ) . '.json';
		$put  = pwa_put_contents( $this->upload_dir . $file, json_encode( $log ) );

		return [
			'type'            => 'success',
			'message'         => '',
			'result'          => $result,
			'devices_removed' => $failed,
		];
	}

	/**
	 * Helpers
	 */

	private function is_hex( $value ) {
		return preg_match( '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/', $value );
	}

	private function latest_push_log() {
		$files = scandir( $this->upload_dir, SCANDIR_SORT_DESCENDING );
		if ( ! $files || empty( $files ) ) {
			return false;
		}

		$newest_file = $files[0];
		if ( '..' == $newest_file || '.' == $newest_file ) {
			return false;
		}

		return $this->upload_url . $newest_file;
	}
}