<?php  
/* prepare variables */
$per_row = $instance['per_row'];
$layout = $instance['display_layout'];

// options section
$display_department = $instance['option_section']['display_department'];
$display_social = $instance['option_section']['display_social'];
$display_about = $instance['option_section']['display_about'];
$order = $instance['option_section']['order'];
$order_by = $instance['option_section']['order_by'];

$column_class = 'col-md-'.(12 / $instance['per_row']);
	if ($column_class != 'col-md-12') {		
	$column_class .= ' col-sm-6';		
}

switch ($instance['text_color']) {
    case "text-light":
    	$text_color = 'text-light';
    	break;
	case "text-dark":
		$text_color = 'text-dark';
		break;
	default:	
		$text_color = '';
		break;
}

if ($instance['category_option'] != 'all') {
	$category_option = $instance['category_option'];
} else {
	$category_option = "";
}

// style section
$entry_header_class = '';
$image_style = $instance['style_section']['image_style'];
$image_class = $instance['style_section']['image_style'];


$bg_color = 'transparent';
$hover_color = $instance['style_section']['hover_color'];
switch ($hover_color) {
	case 'primary':
		$btn_color = 'bg1';
		break;
	case 'secondary':
		$btn_color = 'bg2';
		break;	
	case 'tertiary':
		$btn_color = 'bg3';
		break;			
	default:
	 $btn_color = $hover_color;
}
$departments_hover_class = $hover_color . '-hover';

$hex = $instance['style_section']['bg_color'];
$alpha = ($instance['style_section']['bg_opacy']/100);

$content_css_class = '';
if ($hex) {
	$bg_color = orion_hextorgba($hex, $alpha);
	$content_css_class .= 'has_bg_color';
} else {
	$content_css_class .= 'no_bg_color';
}
if ($instance['style_section']['display_border'] == 1 ) {
	$content_css_class .= ' has_border';
} else {
	$content_css_class .= ' no_border';
}

if ($image_style == 'orion_circle') {
	$image_size = 'orion_square';
	$image_class .= ' rounded';
	if ($hex || $instance['style_section']['display_border'] == 1) {
		$entry_header_class = 'padding-medium';
	}
	if ($instance['style_section']['display_border'] == 1 ) {
		$entry_header_class .= ' has_border';
	}	

} else {
	$image_size = $image_style;
}

$image_overlay = $instance['style_section']['image_overlay'];
$image_hover_overlay = $instance['style_section']['image_overlay_hover'];
$scale_efect = $instance['style_section']['scale_efect'];
$effect_classes = $image_overlay . ' ' . $image_hover_overlay . ' ' . $scale_efect;

// get posts
$post_args = array(
	'posts_per_page'   => 100,
	'offset'           => 0,
	'taxonomy'	=> 'department',
	'department' => $category_option,
	'orderby'          => $order_by,
	'order'            => $order,
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'team-member',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => false 
);
$posts_array = get_posts( $post_args );

// carousel
$navigation_carousel = $instance['option_section']['option_carousel']['navigation_carousel'];
$display_mobile_nav = $instance['option_section']['option_carousel']['display_mobile_nav'];		
$display_mobile_nav_class = '';		
if ($layout == 'carousel' && $display_mobile_nav != true) {		
	$display_mobile_nav_class = ' hide-mobile-nav';		
}		
$wrapper_class = '';		
if ($layout == 'carousel') {		
	$wrapper_class = ' type-' . $navigation_carousel;		
}
$autoplay = 'false';
if ($instance['option_section']['option_carousel']['autoplay'] == true) {
	$autoplay = 'true';
}
$autoplay_timeout = $instance['option_section']['option_carousel']['autoplay_timeout'];
$autoplay_data = '';

/* row class */
$row_class = $layout;
if ($navigation_carousel == 'arrows_top') {
	$row_class .= ' top-nav';
}
if ($text_color != '') {
	$row_class .= ' ' . $text_color;
}

?>
<div class="row team-members <?php echo esc_attr($row_class);?><?php echo esc_attr($display_mobile_nav_class);?>">
<?php //title
if(!empty($instance['title'])) : ?>
	<div class="col-md-12 widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>

<div class="wrapper<?php echo esc_attr($wrapper_class);?>">

	<?php if ($layout == 'carousel') : ?>
		<?php 		
		if ($autoplay == 'true' && isset($autoplay_timeout)) {		
			$autoplay_data .= ' data-autoplaytimeout=' . $autoplay_timeout;		
		}		
		?>		
		<?php if ( $navigation_carousel == 'arrows_top') : ?>
			<?php // carousel top navigation ?>
			<div class="owl-nav style-1 top <?php echo esc_attr($text_color);?>">
				<a class="btn btn-sm btn-flat owlprev icon" ><i class="eleganticons-arrow_left"></i></a>
				<a class="btn btn-sm btn-flat owlnext icon" ><i class="eleganticons-arrow_right"></i></a>
			</div>
		<?php endif;?>

		<div class="owl-carousel owl-theme clearfix" data-col="<?php echo esc_html($instance['per_row']);?>" data-autoplay="<?php echo esc_attr($autoplay);?>"<?php echo esc_attr($autoplay_data);?> data-dots="<?php echo ($navigation_carousel == 'dots');?>">
		
		<?php $column_class = 'col-md-12';?>
	<?php endif;?>


	<?php foreach ($posts_array as $post_single) : ?>
		<?php $post_id = $post_single->ID;?>
		<?php $post_title = $post_single->post_title;?>
		<article class="item <?php echo esc_attr($column_class);?>">
			<div class="wrap" style="background-color: <?php echo esc_attr($bg_color);?>">
				<header class="entry-header <?php echo esc_attr($entry_header_class);?>" >
					<?php $img = get_the_post_thumbnail($post_id, $image_size);?>
					<?php if ($img != "") : ?>
						<a href="<?php echo get_permalink($post_id);?>" class="image-wrap <?php echo esc_attr($effect_classes);?> <?php echo esc_attr($image_class);?>">
							<?php echo wp_kses_post($img);?>
							<div class="overlay"></div>
						</a>
					<?php else :?>		
						<a href="<?php echo get_permalink($post_id);?>" class="image-wrap no-image <?php echo esc_attr($image_class);?>">
						<span class="sow-icon-eleganticons" data-sow-icon="&#xe08b;"></span>
						</a>	
					<?php endif;?>						
				</header>	
			<div class="entry-content vcard <?php echo esc_attr($text_color);?> <?php echo esc_attr($content_css_class);?>">
				<div class="basic-info">
					<?php if ($display_department == true) :?> 
						<div class="departments">	
							<?php 
							$departments = get_the_terms( $post_id, 'department' );
					        $counter = 0; 
					 		if($departments) :?> 
						        <?php foreach ($departments as $department) :?>
						        	<?php if ($counter != 0) :?>
										<span class="separator">|</span>
									<?php endif;?>
								<?php $counter++;?>	
								<a class="font-3 small category <?php echo esc_attr($departments_hover_class);?> <?php echo esc_attr($hover_color);?>-color" href="<?php echo get_category_link($department->term_id); ?>"><?php echo get_the_category_by_id($department->term_id); ?></a>
						        <?php endforeach;?>
							<?php endif;?>
					    </div>	
				    <?php endif;?>

				    <?php //render post title
					if ($post_title != '') :?>
						<a title="<?php echo get_post_field('post_title', $post_id);?>" class="<?php echo esc_attr($hover_color);?>-hover" href="<?php echo get_permalink($post_id);?>"> <h4 class="item-title  <?php echo esc_attr($text_color);?>"> <?php echo get_post_field('post_title', $post_id);?></h4>
						</a>
					<?php endif;?>
				
					<?php $title = get_post_meta($post_id, 'job_title');?>
					<?php if (isset($title[0])) : ?>
						<div class="additional-title">
							<?php echo esc_html($title[0]);?>
						</div>
					<?php endif;?>

					<?php if($display_about == true) : ?>
						<?php $about = get_post_meta($post_id, 'short_about');?>
						<?php if (isset($about[0])) : ?>
							<span class="separator-hr <?php echo esc_attr($hover_color);?>-color-bg"></span>
							<div class="short-about">
								<?php echo esc_html($about[0]);?>
							</div>
						<?php endif;?>
				 <?php endif;?>
				</div> 

				<?php if($display_social == true) : ?>
		 		<?php $social_links = get_post_meta($post_id, 'member_social_icons');?>
			 		<?php if (isset($social_links[0])) :?>
						<ul class="social-links clearfix text-center">
							<?php foreach ($social_links[0] as $key => $value) : ?>
								<?php if (isset($value['social_icons']) && isset($value['social_links']) ) :?>	
									<?php if ($value['social_icons'] == 'fa-envelope-o') : ?>
										<li> <a class="<?php echo esc_attr($hover_color);?>-hover" href="mailto:<?php echo esc_html(orion_removehttp($value['social_links']));?>">
												<i class="fa <?php echo esc_attr($value['social_icons']);?>">
												</i>
											</a>
										</li>
									<?php else : ?>
										<li> <a class="<?php echo esc_attr($hover_color);?>-hover" href="<?php echo esc_url(orion_addhttp($value['social_links']));?>">
												<i class="fa <?php echo esc_attr($value['social_icons']);?>">
											</i>
											</a>
										</li>
									<?php endif; ?>
								<?php endif; ?>
							<?php endforeach; ?>
					 	</ul>
				 	<?php endif;?>
				<?php endif;?>	
			</div>
		</div>
		</article>
	<?php endforeach; ?>

	<?php if ($layout == 'carousel') : ?>
		</div>
		<?php if ($navigation_carousel == 'arrows_aside') : ?>		
			<div class="nav-controll arrows-aside">		
				<div class="owl-nav aside <?php echo esc_attr($text_color);?>">		
					<a class="btn btn-sm btn-empty owlprev icon" ><i class="fa fa-angle-left"></i></a>		
					<a class="btn btn-sm btn-empty owlnext icon" ><i class="fa fa-angle-right"></i></a>		
				</div>		
			</div>		
		<?php endif; ?>		
		<?php if($navigation_carousel == 'arrows_bottom' ) : ?>
			<div class="nav-controll bottom">			
				<div class="owl-nav style-1 bottom text-right col-md-12 <?php echo esc_attr($text_color);?>">
					<a class="btn btn-sm btn-flat owlprev icon" ><i class="eleganticons-arrow_left"></i></a>
					<a class="btn btn-sm btn-flat owlnext icon" ><i class="eleganticons-arrow_right"></i></a>
				</div>
			</div>	
		<?php endif;?>
	
	<?php endif; ?>	
	</div>
</div>	
