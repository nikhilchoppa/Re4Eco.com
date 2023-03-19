<?php
class OrionAdminMenu {
    function __construct() {
        add_action('init', array($this, 'add_filters'));        
    }    
    static function orion_wp_edit_nav_menu_walker() {
        return 'Orion_Walker_Nav_Menu_Edit';
    }
    function add_filters() {
        //edit menu walker
        add_filter('wp_edit_nav_menu_walker', array( 'OrionAdminMenu', 'orion_wp_edit_nav_menu_walker'));
        add_action('save_post', array($this, 'save_data' ), 10, 2);
    }
    function save_data($post_id, $post) {
        if ($post->post_type !== 'nav_menu_item') {
            return $post_id; 
        }
        if(!empty($_POST['menu-item-orion-megamenu'])) {
            foreach($_POST['menu-item-orion-megamenu'] as $key=>$value) { 
                update_post_meta($key, '_orion-megamenu', $value);
            }
        }
        if(!empty($_POST['menu-item-orion-no-link'])) {
            foreach($_POST['menu-item-orion-no-link'] as $key=>$value) { 
                update_post_meta($key, '_orion-no-link', $value);
            }
        }
        if(!empty($_POST['menu-item-orion-hide-title'])) {
            foreach($_POST['menu-item-orion-hide-title'] as $key=>$value) { 
                update_post_meta($key, '_orion-hide-title', $value);
            }
        }        
        if(!empty($_POST['menu-item-orion-sidebars'])) {
            foreach($_POST['menu-item-orion-sidebars'] as $key=>$value) { 
                update_post_meta($key, '_orion-sidebars', $value);
            }
        }
        if(!empty($_POST['menu-item-orion-column-size'])) {
            foreach($_POST['menu-item-orion-column-size'] as $key=>$value) { 
                update_post_meta($key, '_orion-column-size', $value);
            }
        }        
    }
}
require_once ABSPATH . 'wp-admin/includes/nav-menu.php';

class Orion_Walker_Nav_Menu_Edit extends Walker_Nav_Menu_Edit {
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        $item_output = '';
        parent::start_el($item_output, $item, $depth, $args);
        
        //add custom fields to admin menu
        if($depth == 0) {
            $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->orion_field('Megamenu', 'checkbox', $item->ID, 'orion-megamenu', '1'), $item_output);
        }
        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->orion_field('Column Width', 'select', $item->ID, 'orion-column-size', '1'), $item_output);

        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->orion_field('Remove link', 'checkbox', $item->ID, 'orion-no-link', '1'), $item_output);

        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->orion_field('Hide Title', 'checkbox', $item->ID, 'orion-hide-title', '1'), $item_output);

        $item_output = preg_replace('/(?=<div[^>]+class="[^"]*submitbox)/', $this->orion_field('Add sidebar', 'select', $item->ID, 'orion-sidebars', '1'), $item_output);

        $output .= $item_output;
    }
    /* create fields */
    function orion_field($title, $input_type, $item_id, $post_meta_key, $value='') {
        $checked = '';
        $input_hidden = '';
        // hide fields with _ 
        $hidden_post_meta_key = '_'. $post_meta_key;

        if($input_type=='checkbox') {

            $checked_value = get_post_meta($item_id, $hidden_post_meta_key, true);
            if($checked_value=='1') {
                $checked = ' checked';
            } else {
                $checked = '';
            }
            $input_hidden = "<input type='hidden' name='menu-item-$post_meta_key"."["."$item_id]' value='0'>";
        }
        if($post_meta_key =='orion-sidebars') {
            $selected_value = get_post_meta($item_id, $hidden_post_meta_key, true);
            $sidebar_options = array();
            $empty = "";
            $sidebar_options[$empty] = "-- None --";
            
            $allsidebars = $GLOBALS['wp_registered_sidebars'];

            foreach ($allsidebars as $key => $sidebar) {
                $s_name = $sidebar['name'];
                $s_slug = $sidebar['id'];
                $sidebar_options[$s_slug] = $s_name;
            }   
            $input_hidden .= "<select class='widefat' name='menu-item-$post_meta_key"."[".$item_id."]'>";
            foreach ($sidebar_options as $value => $label) {
                if ($selected_value == $value) {

                    $input_hidden .= "<option selected='selected' value='".$value."'>";    
                } else {
                    $input_hidden .= "<option value='".$value."'>";
                }
                $input_hidden .= $label;
                $input_hidden .= "</option>";
            }
            $input_hidden .= "</select>";
        }

        // column size
        if($post_meta_key =='orion-column-size') {

            $selected_value = get_post_meta($item_id, $hidden_post_meta_key, true);
            $column_options = array();
            $column_options['col-md-2'] = "1/6";
            $column_options['col-md-3'] = "1/4";
            $column_options['col-md-4'] = "1/3";
            $column_options['col-md-6'] = "1/2";
            $column_options['col-md-8'] = "2/3";
            $column_options['col-md-9'] = "3/4";
            $column_options['col-md-12'] = "1/1";

            if (!array_key_exists($selected_value, $column_options)){
                $selected_value = "col-md-4";
            }

            $input_hidden .= "<select class='widefat' name='menu-item-$post_meta_key"."[".$item_id."]'>";

            foreach ($column_options as $value => $label) {
                if ($selected_value == $value) {
                    $input_hidden .= "<option selected='selected' value='".$selected_value."'>";    
                } else {
                    $input_hidden .= "<option value='".$value."'>";
                }
                $input_hidden .= $label;
                $input_hidden .= "</option>";
            }
            $input_hidden .= "</select>";
        }

        $data = '';
        $data .= "<p class='$post_meta_key description description-wide'>";
        $data .= "<label for='edit-menu-item-$post_meta_key-$item_id'>";
        $data .= $title.'<br>';
        $data .= $input_hidden;

        if($input_type=='checkbox') {
            $data .= "<input type='$input_type' value='$value' class='widefat code edit-menu-item-$post_meta_key' id='edit-menu-item-$post_meta_key-$item_id' name='menu-item-$post_meta_key"."["."$item_id]'$checked>";
        }

        $data .= '</label>';
        $data .= '</p>';
        return $data;
    }
}
$orion_admin_menu = new OrionAdminMenu();
