<?php

namespace PWAForWP;

class Optify {

	public $base_path = '';
	public $base_url = '';
	public $default_cache_path = '';
	public $minify_files = '';

	public function __construct() {
		$this->base_path          = trailingslashit( ABSPATH );
		$this->base_url           = trailingslashit( get_site_url() );
		$this->default_cache_path = trailingslashit( WP_CONTENT_DIR ) . 'cache/pwa/';
		$this->minify_files       = [ 'css', 'js' ];
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'wp_ajax_pwa_do_clear_minify_cache', [ $this, 'clear_cache' ] );

		add_filter( 'mod_rewrite_rules', [ $this, 'add_htaccess_rules' ] );
		add_action( 'pwa_after_save', 'pwa_rewrite_htaccess_file' );

		if ( is_admin() ) {
			return;
		}

		if ( pwa_is_frontend() ) {
			add_filter( 'script_loader_tag', [ $this, 'add_defer_attribute' ], 10, 2 );
			add_filter( 'style_loader_tag', [ $this, 'render_loadcss' ], 999, 4 );
			add_action( 'wp_footer', [ $this, 'add_relpreload_js' ] );
		}

		add_filter( 'script_loader_src', [ $this, 'change_url' ], 30, 1 );
		add_filter( 'style_loader_src', [ $this, 'change_url' ], 30, 1 );
	}

	public function register_settings() {

		$cache_dir = $this->get_cache_dir();

		$file_count = 0;
		$file_size  = 0;

		foreach ( $this->minify_files as $folder ) {

			$dir = $cache_dir . $folder . '/';

			if ( ! is_dir( $dir ) ) {
				mkdir( $dir, 0777, true );
			}

			$files = scandir( $dir );
			foreach ( $files as $file ) {
				if ( '.' == $file || '..' == $file ) {
					continue;
				}
				//echo $dir . $file . ': ' . filesize( $dir . $file ) . '<br>';
				$file_count ++;
				$file_size = $file_size + filesize( $dir . $file );
			}
		}
		$file_size = $this->format_bytes( $file_size );
        
		$section_desc = '<b>' . __( 'Minify your CSS / JS and store them in cache to load your web app faster', 'pwa' ) . '</b><br>';
		$section = pwa_settings()->add_section( pwa_settings_page_optimize(), 'pwa_cacheminify', __( '♻️ Caching and Minify', 'pwa' ), $section_desc );
		pwa_settings()->add_checkbox( $section, 'minify', __( 'Cache and Minify CSS / JS Files', 'pwa' ), true );
		$text = sprintf( _n( '%1$s File, %2$s', '%1$s Files, %2$s', $file_count, 'pwa' ), "<span class='count'>$file_count</span>", "<span class='size'>$file_size</span>" );
		$html = '<p class="pwa-minify-content">';
		$html .= $text;
		$html .= '<span class="clear-cache" id="pwa-clear-cache" data-nonce="' . wp_create_nonce( 'pwa-clear-cache-nonce' ) . '" data-ajaxurl="' . admin_url( 'admin-ajax.php' ) . '">' . __( 'Clear', 'pwa' ) . '</span>';
		$html .= '</p>';
		pwa_settings()->add_message( $section, 'clear_cache', __( 'Clear Cache', 'pwa' ), $html );

        $section_desc = '<b>' . __( 'Optimize your CSS and JS delivery for better web app performance', 'pwa' ) . '</b><br>';
		$section = pwa_settings()->add_section( pwa_settings_page_optimize(), 'pwa_deliveryopt', __( '⚡ Delivery Optimization' ), $section_desc );
		pwa_settings()->add_checkbox( $section, 'deliverycss', __( 'Optimize CSS Delivery', 'pwa' ) );
		pwa_settings()->add_checkbox( $section, 'deliveryjs', __( 'Optimize JS Delivery', 'pwa' ) );

		$section_desc = '<b>' . __( 'Compress static files and set Cache-Control Headers to your .htaccess for better assets serving', 'pwa' ) . '</b><br>';
		$section = pwa_settings()->add_section( pwa_settings_page_optimize(), 'pwa_compressheaders', __( '🔧 Compression and Caching Headers' ), $section_desc );
		pwa_settings()->add_checkbox( $section, 'compressfiles', __( 'Compress Static Files', 'pwa' ) );
		pwa_settings()->add_checkbox( $section, 'cachingheaders', __( 'Set Caching Headers', 'pwa' ) );
	}

	public function clear_cache() {
		if ( !wp_verify_nonce( $_POST['nonce'], 'pwa-clear-cache-nonce' ) ) {
			pwa_exit_ajax( 'error', __( 'Invalid nonce', 'pwa' ) );
		}

		$cache_dir     = $this->get_cache_dir();
		$files_deleted = 0;
		foreach ( $this->minify_files as $folder ) {
			$files_deleted = $files_deleted + $this->rrmdir( "{$cache_dir}{$folder}/" );
		}

		pwa_exit_ajax( 'success', sprintf( '%s Files deleted', $files_deleted ) );
	}
	
	public function add_htaccess_rules( $existing_rules ) {
    	$custom_rules = '
    		### START Custom rules by PWA plugin ###
    	';

    	if ( pwa_get_setting( 'compressfiles' ) ) {
        	$custom_rules .= '
        		## START Compress static files ##
        		# Compress all output labeled with one of the following MIME-types
            		<IfModule mod_deflate.c>
                		<IfModule mod_filter.c>
                    		AddOutputFilterByType DEFLATE            application/atom+xml
                    		AddOutputFilterByType DEFLATE            application/javascript
                    		AddOutputFilterByType DEFLATE            application/x-javascript
                    		AddOutputFilterByType DEFLATE            application/json
                    		AddOutputFilterByType DEFLATE            application/rss+xml
                    		AddOutputFilterByType DEFLATE            application/vnd.ms-fontobject
                    		AddOutputFilterByType DEFLATE            application/x-font
                    		AddOutputFilterByType DEFLATE            application/x-font-opentype
                    		AddOutputFilterByType DEFLATE            application/x-font-otf
                    		AddOutputFilterByType DEFLATE            application/x-font-truetype
                    		AddOutputFilterByType DEFLATE            application/x-font-ttf
                    		AddOutputFilterByType DEFLATE            application/xhtml+xml
                    		AddOutputFilterByType DEFLATE            application/xml
                    		AddOutputFilterByType DEFLATE            font/otf
                    		AddOutputFilterByType DEFLATE            font/ttf
                    		AddOutputFilterByType DEFLATE            font/opentype
                    		AddOutputFilterByType DEFLATE            image/svg+xml
                    		AddOutputFilterByType DEFLATE            image/x-icon
                    		AddOutputFilterByType DEFLATE            text/css
                    		AddOutputFilterByType DEFLATE            text/html
                    		AddOutputFilterByType DEFLATE            text/javascript
                    		AddOutputFilterByType DEFLATE            text/plain
                    		AddOutputFilterByType DEFLATE            text/x-component
                    		AddOutputFilterByType DEFLATE            text/xhtml
                    		AddOutputFilterByType DEFLATE            text/xml
                		</IfModule>
                		<IfModule mod_setenvif.c>
                    		<IfModule mod_headers.c>
                        		SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ ^((gzip|deflate)\s*,?\s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
                        		RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding
                    		</IfModule>
                		</IfModule>
                		BrowserMatch ^Mozilla/4 gzip-only-text/html
                		BrowserMatch ^Mozilla/4\.0[678] no-gzip
                		#BrowserMatch \bMSIE !no-gzip !gzip-only-text/html
               			SetEnvIfNoCase Request_URI \.(?:gif|jpe?g|png)$ no-gzip dont-vary
                		Header append Vary User-Agent env=!dont-vary
            		</IfModule>
			';
    	}

    	if ( pwa_get_setting( 'cachingheaders' ) ) {
        	$custom_rules .= '
        		## START Caching files in the browser ##
            	<IfModule mod_expires.c>
            	    ExpiresActive On
            	
            	    # Perhaps better to whitelist expires rules? Perhaps.
            	    ExpiresDefault                              "access plus 1 month"
            	
            	    # cache.appcache needs re-requests in FF 3.6 (thanks Remy ~Introducing HTML5)
            	    ExpiresByType text/cache-manifest           "access plus 0 seconds"
            	
            	    # Your document html
            	    ExpiresByType text/html                     "access plus 0 seconds"
            	
            	    # Data
            	    ExpiresByType text/xml                      "access plus 0 seconds"
            	    ExpiresByType application/xml               "access plus 0 seconds"
            	    ExpiresByType application/json              "access plus 0 seconds"
            	    ExpiresByType application/pdf               "access plus 0 seconds"
            	
            	    # Feed
            	    ExpiresByType application/rss+xml           "access plus 1 hour"
            	    ExpiresByType application/atom+xml          "access plus 1 hour"
            	
            	    # Webfonts
            	    ExpiresByType application/x-font-ttf        "access plus 1 month"
            	    ExpiresByType font/opentype                 "access plus 1 month"
            	    ExpiresByType application/x-font-woff       "access plus 1 month"
            	    ExpiresByType application/x-font-woff2      "access plus 1 month"
            	    ExpiresByType image/svg+xml                 "access plus 1 month"
            	    ExpiresByType application/vnd.ms-fontobject "access plus 1 week"
            	
            	    # Media: images, video, audio
            	    ExpiresByType image/gif                     "access plus 1 month"
            	    ExpiresByType image/png                     "access plus 1 month"
            	    ExpiresByType image/PNG                     "access plus 1 month"
            	    ExpiresByType image/jpeg                    "access plus 1 month"
            	    ExpiresByType image/jpg                     "access plus 1 month"
            	    ExpiresByType video/ogg                     "access plus 1 month"
            	    ExpiresByType audio/ogg                     "access plus 1 month"
            	    ExpiresByType video/mp4                     "access plus 1 month"
            	    ExpiresByType video/webm                    "access plus 1 month"
            	
            	    # HTC files  (css3pie)
            	    ExpiresByType text/x-component              "access plus 1 month"
            	
            	    # CSS and JavaScript
            	    ExpiresByType text/css                      "access plus 3 week"
            	    ExpiresByType application/javascript        "access plus 3 week"
            	
            	    # Favicon (cannot be renamed)
            	    ExpiresByType image/x-icon                  "access plus 1 week"
            	    ExpiresByType application/x-shockwave-flash "access plus 1 week"
            	</IfModule>
            	<ifModule mod_headers.c>
            	    <filesMatch "\.(ico|pdf|flv|jpg|jpeg|jpe?g|png|PNG|gif|swf|mp3|mp4)$">
            	        Header set Cache-Control "public"
            	    </filesMatch>
            	    <filesMatch "\.(css)$">
            	        Header set Cache-Control "public"
            	    </filesMatch>
            	    <filesMatch "\.(js)$">
            	        Header set Cache-Control "private"
            	    </filesMatch>
            	    <filesMatch "\.(x?html?|php)$">
            	        Header set Cache-Control "private, must-revalidate"
            	    </filesMatch>
            	</ifModule>
            	# ----------------------------------------------------------------------
            	# Proper MIME type for all files
            	# ----------------------------------------------------------------------
            	
            	AddType application/javascript                   js jsonp
            	AddType application/json                         json
            	
            	# Audio
            	AddType audio/ogg                                oga ogg
            	AddType audio/mp4                                m4a f4a f4b
            	
            	# Video
            	AddType video/ogg                                ogv
            	AddType video/mp4                                mp4 m4v f4v f4p
            	AddType video/webm                               webm
            	AddType video/x-flv                              flv
            	
            	# SVG
            	#   Required for svg webfonts on iPad
            	#   twitter.com/FontSquirrel/status/14855840545
            	AddType     image/svg+xml                        svg svgz
            	AddEncoding gzip                                 svgz
            	
            	# Webfonts
            	AddType application/vnd.ms-fontobject            eot
            	AddType application/x-font-ttf                   ttf ttc
            	AddType font/opentype                            otf
            	AddType application/x-font-woff                  woff
            	
            	# Assorted types
            	AddType image/x-icon                             ico
            	AddType image/webp                               webp
            	AddType text/cache-manifest                      appcache manifest
            	AddType text/x-component                         htc
            	AddType application/xml                          rss atom xml rdf
            	AddType application/x-chrome-extension           crx
            	AddType application/x-opera-extension            oex
            	AddType application/x-xpinstall                  xpi
            	AddType application/octet-stream                 safariextz
            	AddType application/x-web-app-manifest+json      webapp
            	AddType text/x-vcard                             vcf
            	AddType application/x-shockwave-flash            swf
            	AddType text/vtt                                 vtt
    		';
    	}

    	$custom_rules .='
    		### END Custom rules by PWA plugin ###
    	';

    	return $existing_rules . $custom_rules;
	}

	public function change_url( $url ) {

		if ( is_admin() ) {
			return $url;
		}

		if ( ! pwa_get_setting( 'minify' ) || strstr( $url, '/js/jquery/jquery.js' ) ) {
			return $url;
		}

		$cache_dir = $this->get_cache_dir();

		$type = '';
		foreach ( $this->minify_files as $file ) {
			if ( strpos( $url, '.' . $file ) !== false ) {
				$type = $file;
			}
		}

		if ( '' == $type ) {
			return $url;
		}

		if ( strpos( $url, $this->base_url ) === false ) {
			return $url;
		}

		$new_filename = str_replace( $this->base_url, '', $url );
		$new_filename = hash( 'crc32', $new_filename, false );
		$new_filename = $new_filename . '.' . $type;

		$cache_type_dir = $cache_dir . $type . '/';

		$new_path = $cache_type_dir . $new_filename;
		$old_path = str_replace( $this->base_url, $this->base_path, $url );
		$new_url  = str_replace( $this->base_path, $this->base_url, $new_path );

		if ( strpos( $old_path, '?' ) != false ) {
			$old_path = explode( '?', $old_path )[0]; // Remove ?ver..
		}

		if ( file_exists( $new_path ) ) {
			return $new_url;
		}

		if ( ! file_exists( $cache_type_dir ) ) {
			mkdir( $cache_type_dir, 0777, true );
		}

		$path = plugin_dir_path( pwa_get_instance()->file ) . 'classes/Libs';
		require_once $path . '/minify/autoload.php';
		require_once $path . '/path-converter/autoload.php';

		if ( 'js' == $type ) {
			$minifier = new \MatthiasMullie\Minify\JS( $old_path );
		} else {
			$minifier = new \MatthiasMullie\Minify\CSS( $old_path );
		}
		$minifier->minify( $new_path );

		return $new_url;
	}

	/**
	 * Helpers
	 */

	public function format_bytes( $bytes, $precision = 2 ) {
		$units = [ 'B', 'KB', 'MB', 'GB', 'TB' ];

		$bytes = max( $bytes, 0 );
		$pow   = floor( ( $bytes ? log( $bytes ) : 0 ) / log( 1024 ) );
		$pow   = min( $pow, count( $units ) - 1 );

		// Uncomment one of the following alternatives
		// $bytes /= pow(1024, $pow);
		$bytes /= ( 1 << ( 10 * $pow ) );

		return round( $bytes, $precision ) . ' ' . $units[ $pow ];
	}

	public function rrmdir( $path ) {
		if ( ! is_dir( $path ) ) {
			return false;
		}
		$objects = scandir( $path );
		$count   = 0;
		foreach ( $objects as $object ) {
			if ( '.' != $object && '..' != $object ) {
				if ( filetype( $path . '/' . $object ) == 'dir' ) {
					$count = $count + $this->rrmdir( $path . '/' . $object );
				} else {
					$count ++;
					unlink( $path . '/' . $object );
				}
			}
		}

		return $count;
	}

	public function get_cache_dir() {

		$cache_dir = apply_filters( 'pwa_cache_dir', $this->default_cache_path );
		$cache_dir = trailingslashit( $cache_dir );

		if ( strpos( $cache_dir, $this->base_url ) !== false ) {
			$cache_dir = str_replace( $this->base_url, ABSPATH, $cache_dir );
		}

		if ( '' == $cache_dir || '/' == $cache_dir ) {
			$cache_dir = $this->default_cache_path;
		}

		if ( is_multisite() ) {
			$cache_dir = trailingslashit( $cache_dir ) . get_current_blog_id() . '/';
		}

		return $cache_dir;
	}

	public function add_defer_attribute( $tag, $handle ) {
		if ( !pwa_get_setting( 'deliveryjs' ) || strstr( $tag, '/js/jquery/jquery.js' ) ) {
			return $tag;
		}

		return str_replace( ' src', ' defer="defer" src', $tag );
	}

	/**
	 * Styles
	 */

	public function render_loadcss( $html, $handle, $href, $media ) {

		if ( ! pwa_get_setting( 'deliverycss' ) ) {
			return $html;
		}

		$html = str_replace( '\'', '"', $html );
		$html = str_replace( 'rel="stylesheet"', 'rel="preload" as="style" onload="this.onload=null;this.rel=\'stylesheet\'"', $html );

		return "$html<noscript><link rel='stylesheet' data-push-id='$handle' id='$handle' href='$href' type='text/css' media='$media'></noscript>\n";
	}

	public function add_relpreload_js() {

		if ( ! pwa_get_setting( 'deliverycss' ) ) {
			return;
		}

		$preload = plugin_dir_path( pwa_get_instance()->file ) . 'assets/scripts/cssrelpreload.js';
		if ( ! file_exists( $preload ) ) {
			wp_die( 'cssrelpreload.js not found!' );
		}

		echo '<script id="loadCSS">';
		echo file_get_contents( $preload );
		echo '</script>';
	}
}