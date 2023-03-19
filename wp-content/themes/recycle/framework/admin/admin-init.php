<?php

// Load the TGM init if it exists
if ( file_exists( get_template_directory() . '/framework/admin/TGM/tgm-init.php' ) ) {
    require_once get_template_directory() . '/framework/admin/TGM/tgm-init.php';
}

// Load Orion custom css generator
if ( file_exists( get_template_directory() . '/framework/css/custom-styles.php' ) ) {
    require_once get_template_directory() . '/framework/css/custom-styles.php';
} 


