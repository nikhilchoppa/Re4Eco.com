<?php

namespace PWAForWP;

class AddToHomeScreen {

	public $capability = '';
	public $manifest_query_var = 'pwa_manifest';
	public $manifest_path = '';
	public $manifest_url = '';

	public function __construct() {
		$this->capability = pwa_get_instance()->Init->capability;
	}

	public function run() {
		add_action( 'pwa_settings', [ $this, 'register_settings' ] );
		add_action( 'parse_request', [ $this, 'generate_manifest' ] );
		add_filter( 'query_vars', [ $this, 'add_manifest_query_var' ] );
		
		add_action( 'wp_head', [ $this, 'add_to_header' ], 1 );
		add_action( 'wp_head', [ $this, 'meta_tags_to_header' ], 1 );
		add_action( 'wp_footer', [ $this, 'add_overlays' ] );

		add_filter( 'pwa_admin_footer_js', [ $this, 'admin_footer_js' ] );
		add_filter( 'pwa_footer_js', [ $this, 'footer_js' ] );
	}

	public function register_settings() {
		$section_desc = __( 'Add to Home Screen, sometimes referred to as the web app install prompt, makes it easy for users to install your Progressive Web App on their mobile or desktop device. After the user accepts the prompt, your PWA will be added to their launcher, and it will run like any other installed app. Fill the information about your application such as its name, author, icon, and description.', 'pwa' );
		$section      = pwa_settings()->add_section( pwa_settings_page_addtohomescreen(), 'pwa_manifest', __( '➕ Add To Home Screen', 'pwa' ), $section_desc );

		pwa_settings()->add_input( $section, 'manifest-name', __( 'Name', 'pwa' ) );
		pwa_settings()->add_input( $section, 'manifest-short-name', __( 'Short Name', 'pwa' ), '', [
			'after_field' => '<p class="pwa-smaller">' . __( 'max. 12 Chars', 'pwa' ) . '</p>',
		] );

		pwa_settings()->add_select( $section, 'manifest-starturl', __( 'Start Page', 'pwa' ), pwa_get_pages() );

		pwa_settings()->add_textarea( $section, 'manifest-description', __( 'Description', 'pwa' ), '', [] );

		$query['autofocus[control]'] = 'site_icon';
		$url                         = add_query_arg( $query, admin_url( 'customize.php' ) );
		$siteicon                    = get_site_icon_url(32);
		$customizer_title            = __( 'Select Site Icon', 'pwa' );
		$content = '<p><small>' . sprintf( __( 'Manifest icon will be same as Site Icon -> %s', 'pwa' ), "<img style='vertical-align:middle' src='".$siteicon."'/> <a href='{$url}' class='button'>{$customizer_title}</a>" ) . '</small></p>';
		pwa_settings()->add_message( $section, 'manifest-icon-message', __( 'Icon', 'pwa' ), $content );

		$choices = [
			'fullscreen' => __( 'Fullscreen - App takes whole display', 'pwa' ),
			'standalone' => __( 'Standalone - Native app feeling', 'pwa' ),
			'minimal-ui' => __( 'Minimal browser controls', 'pwa' ),
		];
		
		pwa_settings()->add_select( $section, 'manifest-display', __( 'Display mode', 'pwa' ), $choices, 'standalone', [
			'after_field' => '<p class="pwa-smaller">' . __( 'Recommended mode', 'pwa' ) . ": Standalone</p>",
		] );

		pwa_settings()->add_select( $section, 'manifest-orientation', __( 'Orientation', 'pwa' ), [
			'any'       => __( 'Both', 'pwa' ),
			'landscape' => __( 'Landscape', 'pwa' ),
			'portrait'  => __( 'Portrait', 'pwa' ),
		], 'any' );

		pwa_settings()->add_select( $section, 'manifest-statusbar', __( 'iOS Status Bar Style', 'pwa' ), [
			'default'            => __( 'White bar with black text', 'pwa' ),
			'black'              => __( 'Black bar with white text', 'pwa' ),
			'black-translucent'  => __( 'Transparent bar with white text', 'pwa' ),
		], 'default' );

		pwa_settings()->add_color( $section, 'manifest-theme-color', __( 'Theme Color', 'pwa' ), '#000000' );
		pwa_settings()->add_color( $section, 'manifest-background-color', __( 'Background Color', 'pwa' ), '#ffffff' );


		$section_desc = '<b>' . __( 'Display an "Add to Homescreen" overlays for major mobile browsers to make your website installable and grant a prominent place on the users home screen, right next to the native apps', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_addtohomescreen(), 'pwa_installoverlays', __( '📲 Installation Overlays', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'instovrlyschrome-enabled', __( 'Enable for Chrome', 'pwa' ) );
		pwa_settings()->add_checkbox( $section, 'instovrlyssafari-enabled', __( 'Enable for Safari', 'pwa' ) );
		pwa_settings()->add_checkbox( $section, 'instovrlysfirefox-enabled', __( 'Enable for Firefox', 'pwa' ) );
		pwa_settings()->add_number( $section, 'instovrlys-hidefordays', __( 'Overlays timeout in days', 'pwa' ), '2' );


		$section_desc = '<b>' . __( 'Add functionality to restore last browsed page on iOS standalone mode', 'pwa' ) . '</b><br>';
		$section      = pwa_settings()->add_section( pwa_settings_page_addtohomescreen(), 'pwa_iospersist', __( '🕓 iOS Restore Session', 'pwa' ), $section_desc );

		pwa_settings()->add_checkbox( $section, 'iospersist-enabled', __( 'Enable iOS Restore Session', 'pwa' ) );
	}

	public function generate_manifest() {
        if ( isset( $GLOBALS['wp']->query_vars['pwa_manifest'] ) ) {
			if ( 1 == $GLOBALS['wp']->query_vars['pwa_manifest'] ) {
				header( 'Content-Type: text/javascript; charset=utf-8' );

				$language = get_bloginfo( 'language' );
				if ( $language ) {
					$manifest['lang'] = $language;
				}

				if ( '' == pwa_get_setting( 'manifest-name' ) ) {
					return $manifest;
				}
		
				$manifest                     = [];
        		$manifest['name']             = pwa_get_setting( 'manifest-name' );

        		if ( strlen( pwa_get_setting( 'manifest-short-name' ) ) > 12 ) {
					$manifest['short_name'] = substr( pwa_get_setting( 'manifest-short-name' ), 0, 9 ) . '...';
				} else {
					$manifest['short_name'] = pwa_get_setting( 'manifest-short-name' );
				}

				$manifest['start_url']        = pwa_get_setting( 'manifest-starturl' );
				$manifest['description']      = pwa_get_setting( 'manifest-description' );
				$manifest['dir']              = is_rtl() ? 'rtl' : 'ltr';
				$manifest['theme_color']      = $this->sanitize_hex( pwa_get_setting( 'manifest-theme-color' ), '#000000' );
				$manifest['background_color'] = $this->sanitize_hex( pwa_get_setting( 'manifest-background-color' ), '#ffffff' );
				$manifest['display']          = pwa_get_setting( 'manifest-display' );
				$manifest['orientation']      = pwa_get_setting( 'manifest-orientation' );

				$sizes = [ 192, 512 ];

				$icon       = get_option( 'site_icon' );
				$icon_width = wp_get_attachment_image_src( $icon, 'full' )[1];
				if ( wp_attachment_is_image( intval( $icon ) ) ) {
					foreach ( $sizes as $size ) {
						if ( $icon_width < $size ) {
							continue;
						}
						$new_image = pwa_get_instance()->image_resize( $icon, $size, $size, true, 'png' );
						if ( $new_image[1] != $size ) {
							continue;
						}
						$manifest['icons'][] = [
							'src'   => $new_image[0],
							'sizes' => "{$size}x{$size}",
							'type'  => 'image/png',
						];
					}
				}
        
        		$manifest = apply_filters( 'pwa_manifest_values', $manifest );
        		$manifest = json_encode( $manifest, JSON_UNESCAPED_SLASHES );
				echo $manifest;
				exit;
			}
		}
	}

	public function add_manifest_query_var( $query_vars ) {
		$query_vars[] = 'pwa_manifest';

		return $query_vars;
	}

	public function add_to_header() {
		if ( pwa_onesignal() ) {
			return;
		}

		echo '<link rel="manifest" href=' . $this->get_manifest_url( false ) . '>';
	}

	public function meta_tags_to_header() {
		if ( pwa_get_setting( 'manifest-theme-color' ) ) {
			echo '<meta name="theme-color" content="' . pwa_get_setting( 'manifest-theme-color' ) . '">';
		}
		
        $appshortname = str_replace( ' ', '', pwa_get_setting( 'manifest-short-name' ) );
        $statusbar = pwa_get_setting( 'manifest-statusbar' );
        echo '<meta name="apple-mobile-web-app-capable" content="yes">';
        echo '<meta name="apple-mobile-web-app-title" content="'.$appshortname.'">';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="'.$statusbar.'">';
        if ( file_exists( pwa_get_instance()->upload_dir.'apple-launch.png' ) ) {
            $devices  = array(
                'iPhone X' => array(
                    'device-width'               => '375px',
                    'device-height'              => '812px',
                    '-webkit-device-pixel-ratio' => '3',
                    'launch-width'               => '1125',
                    'launch-height'              => '2436',
                ),
                
                'iPhone 8, 7, 6, s6' => array(
                    'device-width'               => '375px',
                    'device-height'              => '667px',
                    '-webkit-device-pixel-ratio' => '2',
                    'launch-width'               => '750',
                    'launch-height'              => '1334',
                ),
                
                'iPhone 8 Plus, 7 Plus, 6s Plus, 6 Plus' => array(
                    'device-width'               => '414px',
                    'device-height'              => '736px',
                    '-webkit-device-pixel-ratio' => '3',
                    'launch-width'               => '1242',
                    'launch-height'              => '2208',
                ),

                'iPhone 5' => array(
                    'device-width'               => '320px',
                    'device-height'              => '568px',
                    '-webkit-device-pixel-ratio' => '2',
                    'launch-width'               => '640',
                    'launch-height'              => '1136',
                ),

                'iPad Mini, Air' => array(
                    'device-width'               => '768px',
                    'device-height'              => '1024px',
                    '-webkit-device-pixel-ratio' => '2',
                    'launch-width'               => '1536',
                    'launch-height'              => '2048',
                ),
        
                'iPad Pro 10.5' => array(
                    'device-width'               => '834px',
                    'device-height'              => '1112px',
                    '-webkit-device-pixel-ratio' => '2',
                    'launch-width'               => '1668',
                    'launch-height'              => '2224',
                ),

                'iPad Pro 12.9' => array(
                    'device-width'               => '1024px',
                    'device-height'              => '1366px',
                    '-webkit-device-pixel-ratio' => '2',
                    'launch-width'               => '2048',
                    'launch-height'              => '2732',
                ),
            );

            foreach ($devices as $device) {
                echo '<link rel="apple-touch-startup-image" media="(device-width: '.$device['device-width'].') and (device-height: '.$device['device-height'].') and (-webkit-device-pixel-ratio: '.$device['-webkit-device-pixel-ratio'].')" href="'.pwa_get_instance()->upload_url.'apple-launch-'.$device['launch-width'].'x'.$device['launch-height'].'.png'.'">';
            }
        }
	}

	public function add_overlays() {	
		if ( wp_is_mobile() ) {
			$appname = pwa_get_setting( 'manifest-name' );
			$appicon = get_site_icon_url(150);
		    $cib     = __( 'Continue in browser', 'pwa' );
		    $tit     = __( 'To install tap', 'pwa' );
		    $ac      = __( 'and choose', 'pwa' );
		    $aths    = __( 'Add to Home Screen', 'pwa' );
		    $rs      = __( 'Restore Session', 'pwa' );
		    $rspg    = __( 'Would you like to restore last page you were browsing?', 'pwa' );
		    $restore = __( 'Restore', 'pwa' );
		    $cancel  = __( 'Cancel', 'pwa' );
		    $pryd    = __( 'Please rotate your device', 'pwa' );

			if ( pwa_get_setting( 'instovrlyssafari-enabled' ) ) {
		    	echo '<div class="add-to-home addiphone" id="instovrlyssafari-enabled">
                   	    <div class="browser-preview" onclick="hideiPhoneOverlay();">'.$cib.'</div>
                   		<div class="logo-name-container" style="background-image:url('.$appicon.')">'.$appname.'</div>
                   		<div class="homescreen-text">
                     		'.$tit.'      
                    	  <div class="icon-addToHome"></div>
                     		'.$ac.'      <br> '.$aths.'    
                   		</div>
                   	    <div class="icon-homePointer"></div>
                  	  </div>';
			}
            
            if ( pwa_get_setting( 'instovrlyschrome-enabled' ) ) {
		    	echo '<div class="add-to-home addchrome" id="instovrlyschrome-enabled">
            	       <div class="browser-preview" onclick="hideChromeOverlay();">'.$cib.'</div>
            	       <div class="logo-name-container" style="background-image:url('.$appicon.')">'.$appname.'</div>
            	       <div class="homescreen-text">
            	         '.$tit.' '.$aths.'         
            	       </div>
            	       <div class="icon-homePointer"></div>
            	       <div id="button-addtohome">'.$aths.'</div>
            	      </div>';

            	echo '<div class="add-to-home addchrome2">
            	       <div class="icon-homePointer"></div>
            	       <div class="logo-name-container" style="background-image:url('.$appicon.')">'.$appname.'</div>
            	       <div class="homescreen-text">
            	         '.$tit.'      
            	         <div class="icon-addToHome"></div>
            	         '.$ac.'      <br> '.$aths.'          
            	       </div>
            	       <div class="browser-preview" onclick="hideChromeOverlay2();">'.$cib.'</div>
            	      </div>';
            }

            if ( pwa_get_setting( 'instovrlysfirefox-enabled' ) ) {
            	echo '<div class="add-to-home addfirefox" id="instovrlysfirefox-enabled">
            	       <div class="icon-homePointer"></div>
            	       <div class="logo-name-container" style="background-image:url('.$appicon.')">'.$appname.'</div>
            	       <div class="homescreen-text">
            	         '.$tit.'      
            	         <div class="icon-addToHome"></div>
            	         '.$ac.'      <br> '.$aths.'          
            	       </div>
            	       <div class="browser-preview" onclick="hideFirefoxOverlay();">'.$cib.'</div>
            	      </div>';
            }

            if ( pwa_get_setting( 'iospersist-enabled' ) && (is_front_page() || is_home()) ) {
                echo  '<div class="iosmodal-overlay" id="iospersist-enabled">
                        <div class="iosmodal iosmodal-in">
                            <div class="iosmodal-inner">
                                <div class="iosmodal-title">'.$rs.'</div>
                                <div class="iosmodal-text">'.$rspg.'</div>
                             </div>
                            <div class="iosmodal-buttons">
                                <span class="iosmodal-button iosmodal-button-bold" onclick="restoreSession();">'.$restore.'</span>
                                <span class="iosmodal-button" onclick="hideRestoreSession();">'.$cancel.'</span>
                            </div>
                        </div>
                      </div>';
            }

            if ( pwa_get_setting( 'manifest-orientation' ) !== 'any' ) {
                echo  '<div class="rotateNotice" id="rotatenotice-enabled">
                        <div class="rotatePhone"></div>
                        <div class="rotateMessage">'.$pryd.'</div>
                      </div>';
            }
        }
	}

	public function admin_footer_js( $args ) {
		if (has_site_icon()) {
		    $args['site_icon'] = get_site_icon_url(512);
		    $args['bg_color']  = $this->sanitize_hex( pwa_get_setting( 'manifest-background-color' ), '#ffffff' );

		    return $args;
		}
	}

	public function footer_js( $args ) {      
        $args['hideForDays']  = pwa_get_setting( 'instovrlys-hidefordays' );
        $args['orientation']  = pwa_get_setting( 'manifest-orientation' );
		
		return $args;
	}

	/**
	 * Helpers
	 */

	public function sanitize_hex( $hex, $default = '#ffffff' ) {
		$hex = sanitize_hex_color( $hex );
		if ( '' == $hex ) {
			return $default;
		} else {
			return $hex;
		}
	}

	public function get_manifest_url( $encoded = true ) {
		$url = add_query_arg( [
			'pwa_manifest' => 1,
		], site_url( '/', 'https' ) );

		if ( $encoded ) {
			return wp_json_encode( $url );
		}

		return $url;
	}
}