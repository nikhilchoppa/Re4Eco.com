<?php

namespace PWAForWP;

class Plugin {

	private static $instance;

	public $name = '';
	public $prefix = '';
	public $version = '';
	public $debug = '';
	public $file = '';

	public $upload_dir = '';
	public $upload_url = '';

	public $option_key = 'pwa_data';

	/**
	 * Creates an instance if one isn't already available,
	 * then return the current instance.
	 *
	 * @param  string $file The file from which the class is being instantiated.
	 *
	 * @return object       The class instance.
	 */
	public static function get_instance( $file ) {

		if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Plugin ) ) {

			self::$instance = new Plugin;

			if ( get_option( pwa_get_instance()->option_key ) ) {
				$data = get_option( pwa_get_instance()->option_key );
			} elseif ( function_exists( 'get_plugin_data' ) ) {
				$data = get_plugin_data( $file );
			} else {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
				$data = get_plugin_data( $file );
			}

			self::$instance->name    = $data['Name'];
			self::$instance->version = $data['Version'];

			self::$instance->prefix = 'pwa';
			self::$instance->debug  = true;
			self::$instance->file   = $file;

			self::$instance->upload_dir = wp_upload_dir()['basedir'] . '/dpc-pwa-for-wp/';
			self::$instance->upload_url = wp_upload_dir()['baseurl'] . '/dpc-pwa-for-wp/';

			self::$instance->run();
		}

		return self::$instance;
	}

	/**
	 * Non-essential dump function to debug variables.
	 *
	 * @param  mixed $var The variable to be output
	 * @param  boolean $die Should the script stop immediately after outputting $var?
	 */
	public function dump( $var, $die = false ) {
		echo '<pre>' . print_r( $var, 1 ) . '</pre>';
		if ( $die ) {
			die();
		}
	}

	/**
	 * Execution function which is called after the class has been initialized.
	 * This contains hook and filter assignments, etc.
	 */
	private function run() {
		add_action( 'admin_init', array( $this, 'update_plugin_data' ) );

		add_action( 'wp_ajax_pwa_ajax_save_launch', [ $this, 'save_launch' ] );
		add_action( 'wp_ajax_nopriv_pwa_ajax_save_launch', [ $this, 'save_launch' ] );

		register_deactivation_hook( pwa_get_instance()->file, [ $this, 'deactivate' ] );
		register_activation_hook( pwa_get_instance()->file, [ $this, 'activate' ] );

		if ( ! is_dir( pwa_get_instance()->upload_dir ) ) {
			mkdir( pwa_get_instance()->upload_dir );
		}
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'pwa', false, dirname( plugin_basename( pwa_get_instance()->file ) ) . '/languages' );
	}

	/**
	 * Update Plugin Data
	 */
	public function update_plugin_data() {

		$db_data   = get_option( pwa_get_instance()->option_key );
		$file_data = get_plugin_data( pwa_get_instance()->file );

		if ( ! $db_data || version_compare( $file_data['Version'], $db_data['Version'], '>' ) ) {

			pwa_get_instance()->name    = $file_data['Name'];
			pwa_get_instance()->version = $file_data['Version'];

			update_option( pwa_get_instance()->option_key, $file_data );

			if ( ! $db_data ) {
				do_action( 'pwa_on_activate' );
			} else {
				do_action( 'pwa_on_update', $db_data['Version'], $file_data['Version'] );
			}
		}
	}

	public function activate() {
		do_action( 'pwa_on_activate' );
	}

	public function deactivate() {
		do_action( 'pwa_on_deactivate' );
		delete_option( pwa_get_instance()->option_key );
	}	

	public function save_launch() {
		if (has_site_icon()) {
			if (isset($_POST["launchscreen"]) && !empty($_POST["launchscreen"])) {

	            $img             = substr($_POST['launchscreen'], strpos($_POST['launchscreen'], ",")+1);
	            $decoded         = base64_decode( $img );
	            $filename        = pwa_get_instance()->upload_dir.'apple-launch.png';
	            $file_type       = 'image/png';

	            $upload_file = pwa_put_contents( $filename, $decoded );

                if ( file_exists( $filename ) ) {
		            $image = wp_get_image_editor( pwa_get_instance()->upload_dir.'apple-launch.png' );
                    if ( ! is_wp_error( $image ) ) {
        	            $sizes_array = 	array(
        	            	array ('width' => 1125, 'height' => 2436, 'crop' => true),
        	                array ('width' => 750, 'height' => 1334, 'crop' => true),
        	            	array ('width' => 1242, 'height' => 2208, 'crop' => true),
        	            	array ('width' => 640, 'height' => 1136, 'crop' => true),
        	            	array ('width' => 1536, 'height' => 2048, 'crop' => true),
        	                array ('width' => 1668, 'height' => 2224, 'crop' => true),
        	                array ('width' => 2048, 'height' => 2732, 'crop' => true),
        	            );
         
        	            $image->multi_resize( $sizes_array );
                        $image->save();
                    }
                    pwa_exit_ajax( 'success', 'Launch screen images generated and saved successfully!' );
                }
			}
		} else {
			pwa_exit_ajax( 'fail', 'No site icon is set!' );
		}
	}

	/**
	 * Helpers
	 */

	/**
	 * @param $attach_id
	 * @param $width
	 * @param $height
	 * @param bool $crop
	 *
	 * @return false|array Returns an array (url, width, height, is_intermediate), or false, if no image is available.
	 */

	public function image_resize( $attach_id, $width, $height, $crop = false, $ext = false ) {

		/**
		 * wrong attachment id
		 */

		if ( 'attachment' != get_post_type( $attach_id ) ) {
			return false;
		}

		$width  = intval( $width );
		$height = intval( $height );

		$src_img       = wp_get_attachment_image_src( $attach_id, 'full' );

		list($oldwidth, $oldheight) = getimagesize( $src_img[0] );

		$src_img_ratio = $oldwidth / $oldheight;
		$src_img_path  = get_attached_file( $attach_id );

		/**
		 * error: somehow file does not exist ¯\_(ツ)_/¯
		 */

		if ( ! file_exists( $src_img_path ) ) {
			return false;
		}

		$src_img_info = pathinfo( $src_img_path );

		if ( $crop ) {
			$new_width  = $width;
			$new_height = $height;
		} elseif ( $width / $height <= $src_img_ratio ) {
			$new_width  = $width;
			$new_height = 1 / $src_img_ratio * $width;
		} else {
			$new_width  = $height * $src_img_ratio;
			$new_height = $height;
		}

		$new_width  = round( $new_width );
		$new_height = round( $new_height );

		$change_filetype = false;
		if ( $ext && strtolower( $src_img_info['extension'] ) != strtolower( $ext ) ) {
			$change_filetype = true;
		}

		/**
		 * return the source image if the requested is bigger than the original image
		 */

		if ( ( $new_width > $oldwidth || $new_height > $oldheight ) && ! $change_filetype ) {
			return $src_img;
		}

		$extension = $src_img_info['extension'];
		if ( $change_filetype ) {
			$extension = $ext;
		}

		$new_img_path = "{$src_img_info['dirname']}/{$src_img_info['filename']}-{$new_width}x{$new_height}.{$extension}";
		$new_img_url  = str_replace( trailingslashit( ABSPATH ), trailingslashit( get_home_url() ), $new_img_path );

		/**
		 * return if already exists
		 */

		if ( file_exists( $new_img_path ) ) {
			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		/**
		 * crop, save and return image
		 */

		$image = wp_get_image_editor( $src_img_path );
		if ( ! is_wp_error( $image ) ) {
			$image->resize( $width, $height, $crop );
			$image->save( $new_img_path );

			return [
				$new_img_url,
				$new_width,
				$new_height,
			];
		}

		return false;
	}
}