<?php // OrionThemes Custom post types

/*********************************** O.o ***********************************/
/*                                 ACTIONS                                 */ 
/***************************************************************************/

/* Post types */
add_action( 'init', 'orion_register_static_blocks_post_type', 0 );
add_action( 'init', 'orion_register_team_post_type' );
add_action( 'init', 'orion_register_portfolio_post_type', 0 );

/* taxonomies */
add_action( 'init', 'orion_register_team_department_taxonomy', 0 );
add_action( 'init', 'orion_register_portfolio_category', 0 );
// add_action( 'init', 'orion_register_portfolio_tags', 0 );

/*********************************** O.o ***********************************/
/*                              Static Blocks                              */ 
/***************************************************************************/
if ( ! function_exists('orion_register_static_blocks_post_type') ) {
    function orion_register_static_blocks_post_type() {

      $labels = array(
        'name'                  => esc_html__( 'Static Blocks', 'Post Type General Name', 'recycle' ),
        'singular_name'         => esc_html__( 'Static Block', 'Post Type Singular Name', 'recycle' ),
        'menu_name'             => esc_html__( 'Static Blocks', 'recycle' ),
        'name_admin_bar'        => esc_html__( 'Static Blocks', 'recycle' ),
        'archives'              => esc_html__( 'Item Archives', 'recycle' ),
        'attributes'            => esc_html__( 'Item Attributes', 'recycle' ),
        'parent_item_colon'     => esc_html__( 'Parent Item:', 'recycle' ),
        'all_items'             => esc_html__( 'All Items', 'recycle' ),
        'add_new_item'          => esc_html__( 'Add New Item', 'recycle' ),
        'add_new'               => esc_html__( 'Add New', 'recycle' ),
        'new_item'              => esc_html__( 'New Item', 'recycle' ),
        'edit_item'             => esc_html__( 'Edit Item', 'recycle' ),
        'update_item'           => esc_html__( 'Update Item', 'recycle' ),
        'view_item'             => esc_html__( 'View Item', 'recycle' ),
        'view_items'            => esc_html__( 'View Items', 'recycle' ),
        'search_items'          => esc_html__( 'Search Item', 'recycle' ),
        'not_found'             => esc_html__( 'Not found', 'recycle' ),
        'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'recycle' ),
        'featured_image'        => esc_html__( 'Featured Image', 'recycle' ),
        'set_featured_image'    => esc_html__( 'Set featured image', 'recycle' ),
        'remove_featured_image' => esc_html__( 'Remove featured image', 'recycle' ),
        'use_featured_image'    => esc_html__( 'Use as featured image', 'recycle' ),
        'insert_into_item'      => esc_html__( 'Insert into item', 'recycle' ),
        'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'recycle' ),
        'items_list'            => esc_html__( 'Items list', 'recycle' ),
        'items_list_navigation' => esc_html__( 'Items list navigation', 'recycle' ),
        'filter_items_list'     => esc_html__( 'Filter items list', 'recycle' ),
      );

      $args = array(
        'label'                 => esc_html__( 'Static Block', 'recycle' ),
        'description'           => esc_html__( 'Content blocks, which can be loaded anywhere.', 'recycle' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'hierarchical'          => true,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 23, 
        'menu_'             => 'dashicons-admin-page',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => true,    
        'exclude_from_search'   => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        "menu_icon" => "dashicons-layout",        
      );
      register_post_type( 'static_blocks', $args );
    }
}

/*********************************** O.o ***********************************/
/*                                  Team                                   */ 
/***************************************************************************/

// Create team post type

if ( ! function_exists('orion_register_team_post_type') ) {
    function orion_register_team_post_type() {
        $labels = array(
            "name" => esc_html__( 'Team', 'recycle' ),
            "singular_name" => esc_html__( 'Team member', 'recycle' ),
            "menu_name" => esc_html__( 'Team', 'recycle' ),
            "all_items" => esc_html__( 'Team', 'recycle' ),
            "add_new_item" => esc_html__( 'Add new member', 'recycle' ),
            "edit_item" => esc_html__( 'Edit Team Member', 'recycle' ),
            "new_item" => esc_html__( 'New Team Member', 'recycle' ),
            "view_item" => esc_html__( 'View Team Member', 'recycle' ),
            "search_items" => esc_html__( 'Search Team Members', 'recycle' ),
            "not_found" => esc_html__( 'No Team Members found', 'recycle' ),
            );

        $args = array(
            "label" => esc_html__( 'Team', 'recycle' ),
            "labels" => $labels,
            "description" => "Team members",
            "public" => true,
            "show_ui" => true,
            "show_in_rest" => false,
            "rest_base" => "",
            "has_archive" => true,
            "show_in_menu" => true,
            "exclude_from_search" => false,
            "capability_type" => "post",
            "map_meta_cap" => true,
            "hierarchical" => false,
            "rewrite" => array( "slug" => get_option( 'orion_base_slug', 'team-member' ), "with_front" => true ),
            "query_var" => true,
            "menu_icon" => "dashicons-admin-users",     
            "supports" => array( "title", "editor", "thumbnail", "excerpt" ),   
            'menu_position' => 21,          
        );
        register_post_type( "team-member", $args );
    }
}

// Create department taxonomy
if ( ! function_exists('orion_register_team_department_taxonomy') ) {
    function orion_register_team_department_taxonomy() {
        $labels = array(
            "name" => esc_html__( 'Department', 'recycle' ),
            "singular_name" => esc_html__( 'Department', 'recycle' ),
            "separate_items_with_commas" => esc_html__( 'Separate multiple departments with comma.', 'recycle' ),
            "choose_from_most_used" => esc_html__( 'Choose from the most used.', 'recycle' ),
        );

        $args = array(
            "label" => esc_html__( 'Departments', 'recycle' ),
            "labels" => $labels,
            "public" => true,
            "hierarchical" => false,
            "show_ui" => true,
            "query_var" => true,
            "rewrite" => array( 'slug' => 'department', 'with_front' => true ),
            "show_admin_column" => false,
            "show_in_rest" => false,
            "rest_base" => "",
            "show_in_quick_edit" => true,
            "rewrite" => array( "slug" => get_option( 'orion_department_base_url', 'project' ), "with_front" => true ),            
        );
        register_taxonomy( "department", array( "team-member" ), $args );
    }
}
/*********************************** O.o ***********************************/
/*                                Portfolio                                */ 
/***************************************************************************/

// Register Portfolio
if ( ! function_exists('orion_register_portfolio_post_type') ) {
    function orion_register_portfolio_post_type() {

        $labels = array(
            'name'                  => esc_html__( 'Projects', 'Post Type General Name', 'recycle' ),
            'singular_name'         => esc_html__( 'Project', 'Post Type Singular Name', 'recycle' ),
            'menu_name'             => esc_html__( 'Portfolio', 'recycle' ),
            'name_admin_bar'        => esc_html__( 'Portfolio', 'recycle' ),
            'archives'              => esc_html__( 'Portfolio Archives', 'recycle' ),
            'attributes'            => esc_html__( 'Portfolio Attributes', 'recycle' ),
            'parent_item_colon'     => esc_html__( 'Parent Project:', 'recycle' ),
            'all_items'             => esc_html__( 'All Projects', 'recycle' ),
            'add_new_item'          => esc_html__( 'Add New Project', 'recycle' ),
            'add_new'               => esc_html__( 'Add New', 'recycle' ),
            'new_item'              => esc_html__( 'New Project', 'recycle' ),
            'edit_item'             => esc_html__( 'Edit Project', 'recycle' ),
            'update_item'           => esc_html__( 'Update Project', 'recycle' ),
            'view_item'             => esc_html__( 'View Project', 'recycle' ),
            'view_items'            => esc_html__( 'View Projects', 'recycle' ),
            'search_items'          => esc_html__( 'Search Projects', 'recycle' ),
            'not_found'             => esc_html__( 'Not found', 'recycle' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'recycle' ),
            'featured_image'        => esc_html__( 'Featured Image', 'recycle' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'recycle' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'recycle' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'recycle' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'recycle' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'recycle' ),
            'items_list'            => esc_html__( 'Items list', 'recycle' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'recycle' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'recycle' ),
        );
        $args = array(
            'label'                 => esc_html__( 'Portfolio', 'recycle' ),
            'description'           => esc_html__( 'Display Projects', 'recycle' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'post-formats' ),
            'taxonomies'            => array( 'portfolio_category'),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 22, 
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,        
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'post',
            "menu_icon" => "dashicons-format-gallery",   
            "rewrite" => array( "slug" => get_option( 'orion_portfolio_base_slug', 'project' ), "with_front" => true ),
        );
        register_post_type( 'orion_portfolio', $args );
    }
}

if ( ! function_exists( 'orion_register_portfolio_category' ) ) {
    // Register Custom Taxonomy
    function orion_register_portfolio_category() {
        $labels = array(
            'name'                       => esc_html__( 'Portfolio Categories', 'Taxonomy General Name', 'recycle' ),
            'singular_name'              => esc_html__( 'Project Category', 'Taxonomy Singular Name', 'recycle' ),
            'menu_name'                  => esc_html__( 'Portfolio Categories', 'recycle' ),
            'all_items'                  => esc_html__( 'All Items', 'recycle' ),
            'parent_item'                => esc_html__( 'Parent Item', 'recycle' ),
            'parent_item_colon'          => esc_html__( 'Parent Item:', 'recycle' ),
            'new_item_name'              => esc_html__( 'New Item Name', 'recycle' ),
            'add_new_item'               => esc_html__( 'Add New Item', 'recycle' ),
            'edit_item'                  => esc_html__( 'Edit Item', 'recycle' ),
            'update_item'                => esc_html__( 'Update Item', 'recycle' ),
            'view_item'                  => esc_html__( 'View Item', 'recycle' ),
            'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'recycle' ),
            'add_or_remove_items'        => esc_html__( 'Add or remove items', 'recycle' ),
            'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'recycle' ),
            'popular_items'              => esc_html__( 'Popular Items', 'recycle' ),
            'search_items'               => esc_html__( 'Search Items', 'recycle' ),
            'not_found'                  => esc_html__( 'Not Found', 'recycle' ),
            'no_terms'                   => esc_html__( 'No items', 'recycle' ),
            'items_list'                 => esc_html__( 'Items list', 'recycle' ),
            'items_list_navigation'      => esc_html__( 'Items list navigation', 'recycle' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
            "rewrite" => array( "slug" => get_option( 'orion_portfolio_category_base_slug', 'portfolio-category' ), "with_front" => true ),            
        );
        register_taxonomy( 'portfolio_category', array( 'orion_portfolio' ), $args );
    }
}

if ( ! function_exists( 'orion_register_portfolio_tags' ) ) {
    // Register Custom Taxonomy
    function orion_register_portfolio_tags() {

        $labels = array(
            'name'                       => esc_html__( 'Portfolio Tags', 'Taxonomy General Name', 'recycle' ),
            'singular_name'              => esc_html__( 'Portfolio Tag', 'Taxonomy Singular Name', 'recycle' ),
            'menu_name'                  => esc_html__( 'Portfolio Tags', 'recycle' ),
            'all_items'                  => esc_html__( 'All Items', 'recycle' ),
            'parent_item'                => esc_html__( 'Parent Item', 'recycle' ),
            'parent_item_colon'          => esc_html__( 'Parent Item:', 'recycle' ),
            'new_item_name'              => esc_html__( 'New Item Name', 'recycle' ),
            'add_new_item'               => esc_html__( 'Add New Item', 'recycle' ),
            'edit_item'                  => esc_html__( 'Edit Item', 'recycle' ),
            'update_item'                => esc_html__( 'Update Item', 'recycle' ),
            'view_item'                  => esc_html__( 'View Item', 'recycle' ),
            'separate_items_with_commas' => esc_html__( 'Separate items with commas', 'recycle' ),
            'add_or_remove_items'        => esc_html__( 'Add or remove items', 'recycle' ),
            'choose_from_most_used'      => esc_html__( 'Choose from the most used', 'recycle' ),
            'popular_items'              => esc_html__( 'Popular Items', 'recycle' ),
            'search_items'               => esc_html__( 'Search Items', 'recycle' ),
            'not_found'                  => esc_html__( 'Not Found', 'recycle' ),
            'no_terms'                   => esc_html__( 'No items', 'recycle' ),
            'items_list'                 => esc_html__( 'Items list', 'recycle' ),
            'items_list_navigation'      => esc_html__( 'Items list navigation', 'recycle' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => false,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
        );
        register_taxonomy( 'portfolio_tag', array( 'orion_portfolio' ), $args );

    }
}

if ( ! function_exists( 'orion_allowed_portfolio_formats' ) ) {
    function orion_allowed_portfolio_formats() {
        return array( 'audio', 'gallery', 'video' );
    }
}

/*********************************** O.o ***********************************/
/*                        Portfolio post formats                           */ 
/***************************************************************************/

add_action( 'load-post.php',     'orion_post_format_support_filter' );
add_action( 'load-post-new.php', 'orion_post_format_support_filter' );
add_action( 'load-edit.php',     'orion_post_format_support_filter' );

if ( ! function_exists( 'orion_post_format_support_filter' ) ) {
    function orion_post_format_support_filter() {

        $screen = get_current_screen();

        // if anything else but portfolio
        if ( empty( $screen->post_type ) ||  $screen->post_type !== 'orion_portfolio' )
            return;

        if ( current_theme_supports( 'post-formats' ) ) {
            $formats = get_theme_support( 'post-formats' );

            // If we have formats, add theme support for only the allowed formats.
            if ( isset( $formats[0] ) ) {
                $new_formats = array_intersect( $formats[0], orion_allowed_portfolio_formats() );

                // Remove post formats support.
                remove_theme_support( 'post-formats' );

                // If the theme supports the allowed formats, add support for them.
                if ( $new_formats )
                    add_theme_support( 'post-formats', $new_formats );
            }
        }

        // Filter the default post format.
        add_filter( 'option_default_post_format', 'orion_default_post_format_filter', 95 );
    }
}

function orion_default_post_format_filter( $format ) {
    return in_array( $format, orion_allowed_portfolio_formats() ) ? $format : 'gallery';
}