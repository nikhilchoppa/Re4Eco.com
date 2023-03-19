<?php

namespace PWAForWP;

class Toast {

    public $capability = '';

    public function __construct() {
        $this->capability = pwa_get_instance()->Init->capability;
    }

    public function run() {
        add_action( 'pwa_settings', [ $this, 'register_settings' ] );
        add_action( 'wp_footer', [ $this, 'add_toast' ] );
    }

    public function register_settings() {
        $section_desc = '<b>' . __( 'Enable toast messages for mobile phone users', 'pwa' ) . '</b><br>';
        $section      = pwa_settings()->add_section( pwa_settings_page_accessibility(), 'pwa_toast', __( '💡 Toast Messages', 'pwa' ), $section_desc );

        pwa_settings()->add_checkbox( $section, 'toast-enabled', __( 'Enable Toast Messages', 'pwa' ) );
    }

    public function add_toast() {
    	$homemsg = __( 'Welcome on Homepage', 'pwa' );
    	$postmsg = __( 'Post Opened', 'pwa' );
    	$pagemsg = __( 'Page Opened', 'pwa' );
    	$errormsg = __( 'Page Not Found!', 'pwa' );
    	$searchmsg = __( 'Search Results', 'pwa' );
    	$categorymsg = __( 'Category Opened', 'pwa' );
    	$archivemsg = __( 'Archive Opened', 'pwa' );

        if ( pwa_get_setting( 'toast-enabled' ) && wp_is_mobile() ) {
            if ( is_front_page() || is_home() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$homemsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } elseif ( is_single() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$postmsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } elseif ( is_page() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$pagemsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } elseif ( is_404() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$errormsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } elseif ( is_search() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$searchmsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } elseif ( is_category() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$categorymsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            }  elseif ( is_archive() ) {
              echo "<script type='text/javascript'>
                            document.addEventListener('DOMContentLoaded', function(event) { 
                                jQuery.toast({
                                  title: '".$archivemsg."',
                                  duration: 3000,
                                  position: 'bottom',
                                });
                            });
                    </script>";
            } 
        }
    }
}