<?php
/**
 * Update class.
 *
 * @link  https://www.boldgrid.com
 * @since 1.0.0
 *
 * @package    Boldgrid_Backup
 * @subpackage Boldgrid_Backup/admin
 * @copyright  BoldGrid
 * @version    $Id$
 * @author     BoldGrid <support@boldgrid.com>
 */

/**
 * BoldGrid update class.
 */
class Boldgrid_Backup_Premium_Admin_Update {
	/**
	 * Plugin configuration array.
	 *
	 * @var array
	 */
	private $configs = array();

	/**
	 * Constructor.
	 *
	 * @param array $configs Plugin configuration array.
	 */
	public function __construct( array $configs ) {
		$this->configs = $configs;
	}

	/**
	 * Adds filters for plugin update hooks.
	 *
	 * @see self::wpcron()
	 * @see self::wp_update_this_plugin()
	 */
	public function add_hooks() {
		$is_cron  = ( defined( 'DOING_CRON' ) && DOING_CRON );
		$is_wpcli = ( defined( 'WP_CLI' ) && WP_CLI );

		if ( $is_cron || $is_wpcli || is_admin() ) {
			/*
			 * The plugins_api filter allows a plugin to override the WordPress.org Plugin Installation
			 * API entirely.
			 */
			add_filter( 'plugins_api',
				array(
					$this,
					'custom_plugins_transient_update',
				), 11, 3
			);

			// Filter the value of the update_plugins site transient.
			add_filter( 'site_transient_update_plugins',
				array(
					$this,
					'site_transient_update_plugins',
				), 11
			);

			// Filter the value of the update_plugins site transient before it is set.
			add_filter( 'pre_set_site_transient_update_plugins',
				array(
					$this,
					'custom_plugins_transient_update',
				), 11, 2
			);
		}

		if ( $is_cron ) {
			$this->wpcron();
		}

		if ( $is_cron || $is_wpcli ) {
			$this->wp_update_this_plugin();
		}
	}

	/**
	 * WP-CRON init.
	 */
	public function wpcron() {
		// Ensure required definitions for pluggable.
		if ( ! defined( 'AUTH_COOKIE' ) ) {
			define( 'AUTH_COOKIE', null );
		}

		if ( ! defined( 'LOGGED_IN_COOKIE' ) ) {
			define( 'LOGGED_IN_COOKIE', null );
		}

		// Load the pluggable class, if needed.
		require_once ABSPATH . 'wp-includes/pluggable.php';
	}

	/**
	 * Update the plugin transient.
	 *
	 * @global $pagenow    The current WordPress page filename.
	 * @global $wp_version The WordPress version.
	 *
	 * @param  object $transient WordPress plugin update transient.
	 * @param  string $action    Action name.
	 * @param  array  $args      Optional arguments.
	 * @return object $transient
	 */
	public function custom_plugins_transient_update( $transient, $action, $args = array() ) {
		$slug = ! empty( $args->slug ) ? $args->slug : '';

		/*
		 * If we're looking for information about a specific plugin, and it's not this plugin, abort.
		 *
		 * We may be in various $actions.
		 * @see plugins_api()
		 *
		 * If the $action is 'plugin_information', we are looking for information on a specific plugin.
		 * If that specific plugin is not this plugin, there's no need to filter anything, just return.
		 *
		 * The 'plugin_information' is generally set when a plugin is being installed.
		 * @see wp_ajax_install_plugin()
		 * @see WP_REST_Plugins_Controller::create_item()
		 * @see wp-admin/update.php
		 */
		if ( 'plugin_information' === $action && $slug !== $this->confings['plugin_name'] ) {
			return $transient;
		}

		$version_data = get_site_transient( $this->configs['plugin_transient_name'] );

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data = get_plugin_data( $this->configs['main_file_path'], false );

		$is_force_check = isset( $_GET['force-check'] ); // phpcs:ignore

		// Was the version data recently updated?
		$is_data_old = ( empty( $version_data->updated ) || $version_data->updated < time() - 5 );

		global $wp_version;

		// If we have no transient or force-check is called, and we do have configs, then get data and set transient.
		if ( ! $version_data || ( $is_force_check && $is_data_old ) ) {
			$options = get_site_option( 'boldgrid_settings' );

			$channel = isset( $options['release_channel'] ) ? $options['release_channel'] : 'stable';

			$params = http_build_query( array(
				'key'                  => $this->configs['plugin_key_code'],
				'channel'              => $channel,
				'installed_' . $this->configs['plugin_key_code'] . '_version' => $plugin_data['Version'],
				'installed_wp_version' => $wp_version,
				'site_hash'            => get_option( 'boldgrid_site_hash' ),
			) );

			$query = $this->configs['asset_server'] .
				$this->configs['ajax_calls']['get_plugin_version'] . '?' . $params;

			$version_data = json_decode( wp_remote_retrieve_body( wp_remote_get( $query ) ) ); // phpcs:ignore

			// Set the version data transient, expire in 8 hours.
			if ( ! empty( $version_data ) && 200 === $version_data->status &&
				! empty( $version_data->result->data ) ) {
					// Add the current timestamp (in seconds).
					$version_data->updated = time();

					// Set version data transient, expire in 8 hours.
					delete_site_transient( $this->configs['plugin_transient_name'] );
					set_site_transient(
						$this->configs['plugin_transient_name'],
						$version_data,
						8 * HOUR_IN_SECONDS
					);
			} else {
				// Something went wrong, so just skip adding update data; return unchanged transient data.
				return $transient;
			}
		}

		global $pagenow;

		// Create a new object to be injected into transient.
		if ( 'plugin-install.php' === $pagenow && isset( $_GET['plugin'] ) && // phpcs:ignore
			 $this->configs['plugin_name'] === $_GET['plugin'] ) { // phpcs:ignore
			// For version information iframe (/plugin-install.php).
			$transient = new stdClass();

			// If we have section data, then prepare it for use.
			if ( ! empty( $version_data->result->data->sections ) ) {
				// Remove new lines and double-spaces, to help prevent a broken JSON set.
				$version_data->result->data->sections = preg_replace(
					'/\s+/', ' ',
					trim( $version_data->result->data->sections )
				);

				// Convert the JSON set into an array.
				$transient->sections = json_decode( $version_data->result->data->sections, true );

				// If we have data, format it for use, else set a default message.
				if ( ! empty( $transient->sections ) && count( $transient->sections ) ) {
					foreach ( $transient->sections as $section => $section_data ) {
						$transient->sections[ $section ] = html_entity_decode(
							$section_data,
							ENT_QUOTES
						);
					}
				} else {
					$transient->sections['description'] = 'Data not available';
				}
			} else {
				$transient->sections['description'] = 'Data not available';
			}

			// Set the other elements.
			$transient->name          = $version_data->result->data->title;
			$transient->requires      = $version_data->result->data->requires_wp_version;
			$transient->tested        = $version_data->result->data->tested_wp_version;
			$transient->last_updated  = $version_data->result->data->release_date;
			$transient->download_link = $this->configs['asset_server'] .
				$this->configs['ajax_calls']['get_asset'] . '?id=' .
				$version_data->result->data->asset_id . '&installed_plugin_version=' .
				$plugin_data['Version'] . '&installed_wp_version=' . $wp_version;

			if ( ! empty( $version_data->result->data->compatibility ) &&
				( $compatibility = json_decode( $version_data->result->data->compatibility, true ) ) ) { // phpcs:ignore
					$transient->compatibility = $version_data->result->data->compatibility;
			}

			$transient->added = '2015-03-19';

			if ( ! empty( $version_data->result->data->siteurl ) ) {
				$transient->homepage = $version_data->result->data->siteurl;
			}

			if ( ! empty( $version_data->result->data->tags ) &&
				( $tags = json_decode( $version_data->result->data->tags, true ) ) ) { // phpcs:ignore
					$transient->tags = $version_data->result->data->tags;
			}

			if ( ! empty( $version_data->result->data->banners ) &&
				( $banners = json_decode( $version_data->result->data->banners, true ) ) ) { // phpcs:ignore
					$transient->banners = $banners;
			}

			$transient->plugin_name = basename( $this->configs['main_file_path'] );
			$transient->slug        = $this->configs['plugin_name'];
			$transient->version     = $version_data->result->data->version;
			$transient->new_version = $version_data->result->data->version;
		} elseif ( 'update_plugins' === $action || 'plugin_information' === $action ) {
			$obj              = new stdClass();
			$obj->slug        = $this->configs['plugin_name'];
			$obj->plugin      = $this->configs['plugin_name'] . '/' .
				basename( $this->configs['main_file_path'] );
			$obj->new_version = $version_data->result->data->version;
			$obj->tested      = $version_data->result->data->tested_wp_version;

			if ( ! empty( $version_data->result->data->siteurl ) ) {
				$obj->url = $version_data->result->data->siteurl;
			}

			$obj->package = $this->configs['asset_server'] .
				$this->configs['ajax_calls']['get_asset'] . '?id=' .
				$version_data->result->data->asset_id . '&installed_plugin_version=' .
				$plugin_data['Version'] . '&installed_wp_version=' . $wp_version;

			if ( $plugin_data['Version'] !== $version_data->result->data->version ) {
				if ( ! empty( $version_data->result->data->autoupdate ) ) {
					$obj->autoupdate = true;
				}
				$transient->response[ $obj->plugin ] = $obj;
				$transient->tested                   = $obj->tested;
			} else {
				/*
				 * Fail-safe. This is a band-aid to avoid updating a property on a non object.
				 *
				 * @todo Fix the underlying issue. Most likely when 'plugin_information' === $action.
				 */
				$transient = is_object( $transient ) ? $transient : new stdClass();

				$transient->no_update[ $obj->plugin ] = $obj;
			}
		}

		return $transient;
	}

	/**
	 * Force WP to check for updates, don't rely on cache / transients.
	 *
	 * @global $pagenow The current WordPress page filename.
	 *
	 * @param object $value WordPress plugin update transient.
	 * @return object
	 */
	public function site_transient_update_plugins( $value ) {
		global $pagenow;

		// Only require fresh data if user clicked "Check Again".
		if ( 'update-core.php' !== $pagenow || ! isset( $_GET['force-check'] ) ) { // phpcs:ignore
			return $value;
		}

		// Set the last_checked to 1, so it will trigger the timeout and check again.
		if ( isset( $value->last_checked ) ) {
			$value->last_checked = 1;
		}

		return $value;
	}

	/**
	 * Action to add a filter to check if this plugin should be auto-updated.
	 *
	 * @see wp_maybe_auto_update()
	 */
	public function wp_update_this_plugin() {
		add_filter( 'auto_update_plugin',
			array(
				$this,
				'auto_update_this_plugin',
			), 11, 2
		);

		add_filter( 'auto_update_plugins',
			array(
				$this,
				'auto_update_this_plugin',
			), 11, 2
		);

		// Have WordPress check for plugin updates.
		wp_maybe_auto_update();
	}

	/**
	 * Filter to check if this plugin should be auto-updated.
	 *
	 * @param bool   $update Whether or not this plugin is set to update.
	 * @param object $item   The plugin transient object.
	 * @return bool          Whether or not to update this plugin.
	 */
	public function auto_update_this_plugin( $update, $item ) {
		if ( isset( $item->slug[ $this->configs['plugin_name'] ] ) && isset( $item->autoupdate ) ) {
			return true;
		} else {
			return $update;
		}
	}
}
