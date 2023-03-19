<?php 

class OrionNavWalker extends Walker_Nav_Menu {

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$meta = get_post_meta($item->ID);

        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // ************************* //
        // add MegaMenu HTML classes //
		
		$item_mega_menu_meta = get_post_meta($item->ID, '_orion-megamenu', true);
        $mega_menu_borders = orion_get_theme_option_css('mega_menu_borders', 'false');
		$menu_parent = $item->menu_item_parent;
		
		if ($item_mega_menu_meta == true){
			$classes[] = 'orion-megamenu';         
		}
        if ($mega_menu_borders) {
            $classes[] = $mega_menu_borders;   
        }        

		if ($menu_parent != '0' && $menu_parent != '') {
			$parent_meta = get_post_meta($menu_parent, '_orion-megamenu', true);
			if ($parent_meta == true){ get_post_meta($menu_parent, '_orion-megamenu', true);

				$orion_sidebars = get_post_meta($item->ID, '_orion-sidebars', true);
				$remove_link = get_post_meta($item->ID, '_orion-no-link', true);
				$hide_title = get_post_meta($item->ID, '_orion-hide-title', true);
				$column_class = get_post_meta($item->ID, '_orion-column-size', true);

				$classes[] = 'orion-megamenu-subitem';
				$classes[] = $column_class;

				if( isset($orion_sidebars) && $orion_sidebars != '') {
					$classes[] = 'megamenu-sidebar';	
				}
				if( isset($remove_link) && $remove_link == 1) {
					$classes[] = 'meganav-no-link';	
				}
			}
		}
		// end MegaMenu HTML classes //
		// ************************* //
	

        /**
         * Filters the arguments for a single nav menu item.
         *
         * @since 4.4.0
         *
         * @param array  $args  An array of arguments.
         * @param object $item  Menu item data object.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );
        /**
         * Filters the CSS class(es) applied to a menu item's list item element.
         *
         * @since 3.0.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array  $classes The CSS classes that are applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
        /**
         * Filters the ID applied to a menu item's list item element.
         *
         * @since 3.0.1
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
         * @param object $item    The current menu item.
         * @param array  $args    An array of wp_nav_menu() arguments.
         * @param int    $depth   Depth of menu item. Used for padding.
         */
        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $class_names .'>';
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
        $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
        $atts['href']   = ! empty( $item->url )        ? $item->url        : '';
        /**
         * Filters the HTML attributes applied to a menu item's anchor element.
         *
         * @since 3.6.0
         * @since 4.1.0 The `$depth` parameter was added.
         *
         * @param array $atts {
         *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
         *
         *     @type string $title  Title attribute.
         *     @type string $target Target attribute.
         *     @type string $rel    The rel attribute.
         *     @type string $href   The href attribute.
         * }
         * @param object $item  The current menu item.
         * @param array  $args  An array of wp_nav_menu() arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attributes = '';
        foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                }
        }
        /** This filter is documented in wp-includes/post-template.php */
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        /**
         * Filters a menu item's title.
         *
         * @since 4.4.0
         *
         * @param string $title The menu item's title.
         * @param object $item  The current menu item.
         * @param array  $args  An array of wp_nav_menu() arguments.
         * @param int    $depth Depth of menu item. Used for padding.
         */
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        /**
         * Filters a menu item's starting output.
         *
         * The menu item's starting output only includes `$args->before`, the opening `<a>`,
         * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
         * no filter for modifying the opening and closing `<li>` for a menu item.
         *
         * @since 3.0.0
         *
         * @param string $item_output The menu item's starting HTML output.
         * @param object $item        Menu item data object.
         * @param int    $depth       Depth of menu item. Used for padding.
         * @param array  $args        An array of wp_nav_menu() arguments.
         */
        

        // ********************* //
        // Modify MegaMenu HTML  //

        if (in_array( 'orion-megamenu-subitem' , $classes )){
        	if( isset($orion_sidebars) && $orion_sidebars != '') {
            	$item_output = $args->before;

				if ($hide_title == 1 ) {
                    $item_output = '';
                    $item_output .= '<a class="hidden-md hidden-lg" '. $attributes .'>';
                    $item_output .= $args->link_before . $title . $args->link_after;
                    $item_output .= '</a>';                    
	        	} else if( $remove_link == 1) {
	            	$item_output .= '<span>';
	            	$item_output .= $args->link_before . $title . $args->link_after;
	            	$item_output .= '</span>';         	
	        	} else {
	                $item_output .= '<a'. $attributes .'>';
	                $item_output .= $args->link_before . $title . $args->link_after;
	                $item_output .= '</a>';               		
	        	}


				if ( is_active_sidebar( $orion_sidebars ) ) {
					$item_output .= '<div class="mega-sidebar widget-area" role="complementary">';
					
					ob_start();
					$sidebar_content = '';
					dynamic_sidebar($orion_sidebars);
					$sidebar_content = ob_get_contents();
					ob_end_clean();
					
					$item_output .= $sidebar_content;
					$item_output .= '</div>';
				}
            	$item_output .= $args->after;

        	// Empty:
        	} else if ($hide_title == 1 ) {
                    $item_output = '';
                    $item_output .= '<a class="hidden-md hidden-lg" '. $attributes .'>';
                    $item_output .= $args->link_before . $title . $args->link_after;
                    $item_output .= '</a>';                
        	} else if( $remove_link == 1) {
            	$item_output = $args->before;
            	$item_output .= '<span>';
            	$item_output .= $args->link_before . $title . $args->link_after;
            	$item_output .= '</span>';         	
            	$item_output .= $args->after;
        	} else {
                $item_output = $args->before;
                $item_output .= '<a'. $attributes .'>';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;                		
        	}
        }
		
		// End: Modify MegaMenu HTML //
        // ************************* //
        
        if ($classes[] = 'orion-megamenu-subitem')
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

    function start_lvl( &$output, $depth = 0, $args = array() ) {

        $mega_menu_submenu_class = '';

        /* megamenu nav colors */
        $megamenu_nav_color = orion_get_theme_option_css(array('mega_menu_background','background-color'), 'false');

        if ($megamenu_nav_color != 'false') {
            if(orion_isColorLight($megamenu_nav_color)) {
                $mega_menu_submenu_class .= " mega-dark";
            } else  {
                $mega_menu_submenu_class .= " mega-light";
            }
        }

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = str_repeat( $t, $depth );
        $output .= "{$n}{$indent}<ul class=\"sub-menu".$mega_menu_submenu_class."\">{$n}";
    }
}
