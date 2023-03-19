<?php 
/* prepare variables */
$per_row = $instance['per_row'];
$column_class = 'col-md-'.(12 / $per_row);
if ($per_row == 1) {
	$column_class .= ' col-sm-12';
} else {
	$column_class .= ' col-sm-6';
}

$number_of_posts = $instance['number_of_posts'];
$layout = $instance['display_layout'];
// options section
$display_feeatured = $instance['option_section']['display_feeatured'];
$display_excerpt = $instance['option_section']['display_excerpt'];
$display_readmore = $instance['option_section']['display_readmore'];
$display_meta = $instance['option_section']['display_meta'];
$readmore_text = $instance['option_section']['readmore_text'];
$display_date = $instance['option_section']['display_date'];

// carousel options
$navigation_carousel = $instance['option_section']['option_carousel']['navigation_carousel'];

$display_mobile_nav = $instance['option_section']['option_carousel']['display_mobile_nav'];		
$autoplay_timeout = $instance['option_section']['option_carousel']['autoplay_timeout'];
$autoplay_data = '';


if($instance['option_section']['option_carousel']['autoplay']) {
	$autoplay = $instance['option_section']['option_carousel']['autoplay'];
} else {
	$autoplay = 'false';
}
$display_mobile_nav_class = '';
if ($layout == 'carousel' && $display_mobile_nav != true) {		
	$display_mobile_nav_class = ' hide-mobile-nav';		
}		
$wrapper_class = '';		
if ($layout == 'carousel') {		
	$wrapper_class = ' type-' . $navigation_carousel;		
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

$bg_color = 'transparent';
$readmore_color = $instance['style_section']['readmore_color'];

switch ($readmore_color) {
	case 'primary':
		$btn_classes = 'btn-c1';
		break;
	case 'secondary':
		$btn_classes = 'btn-c2';
		break;	
	case 'tertiary':
		$btn_classes = 'btn-c3';
		break;
	case 'white':
		$btn_classes = 'btn-white';
		break;
	case 'black':
		$btn_classes = 'btn-black';
		break;				
	default:
	 $btn_classes = 'btn-' . $readmore_color;
}

$btn_classes .= ' ' . $instance['style_section']['btn_size'];

if (isset($instance['style_section']['btn_style']) && $instance['style_section']['btn_style'] != '') {
	$btn_classes .= ' ' . $instance['style_section']['btn_style'];
}

$entry_content_class = '';
$hex = $instance['style_section']['bg_color'];
$alpha = ($instance['style_section']['bg_opacy']/100);
$has_padding_class = '';
if ($hex) {
	$bg_color = orion_hextorgba($hex, $alpha);	
	$entry_content_class = 'padding-medium';
	$has_padding_class = 'has_padding';
} 

$image_overlay = $instance['style_section']['image_overlay'];
$image_hover_overlay = $instance['style_section']['image_overlay_hover'];
$scale_efect = $instance['style_section']['scale_efect'];
$effect_classes = $image_overlay . ' ' . $image_hover_overlay . ' ' . $scale_efect;

// get posts
$post_args = array(
	'posts_per_page'   => $number_of_posts,
	'offset'           => 0,
	'category'         => $category_option,
	'category_name'    => '',
	'orderby'          => 'date',
	'order'            => 'DESC',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'author'	   => '',
	'author_name'	   => '',
	'post_status'      => 'publish',
	'suppress_filters' => false 
);
$posts_array = get_posts( $post_args );


/* row class */
$row_class = $layout;
if ($navigation_carousel == 'arrows_top') {
	$row_class .= ' top-nav';
}
if ($text_color != '') {
	$row_class .= ' ' . $text_color;
}
?>
<div class="row recent-post-carousel <?php echo esc_attr($row_class);?><?php echo esc_attr($display_mobile_nav_class);?>">
<?php //title
if(!empty($instance['title'])) : ?>
	<div class="col-md-12 widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>

	<div class="wrapper<?php echo esc_attr($wrapper_class);?>">

	<?php if ($layout == 'carousel') : ?>
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
		<article class="item <?php echo esc_attr($column_class);?> <?php echo esc_attr($has_padding_class);?>">

		<?php if ($display_feeatured != false) : ?>
			<header class="entry-header">
				<?php if ($display_date == 'on-image') : ?>
					<div class="thedate absolute top left">
						<?php //get the date
						$date_day = get_the_date('j',$post_id); 
						$date_month = get_the_date('M',$post_id);
						?>
						<span class="date date-day text-dark font-2">
							<?php echo esc_html($date_day)?>
						</span>

						<?php if($readmore_color == 'white') {
							$month_text = 'text-dark';
						} else {
							$month_text = 'text-light';
						};?>
						<span class="date date-month <?php echo esc_attr($readmore_color);?>-color-bg <?php echo esc_attr($month_text);?> font-2">
							<?php echo esc_html($date_month)?>
						</span>			
					</div>
				<?php endif;?>
				<?php 
				if($per_row == 1) {
					$img = get_the_post_thumbnail($post_id, 'large');
				} else {
					$img = get_the_post_thumbnail($post_id, 'orion_carousel');
				}
				?>
				<?php if ($img != "") : ?>
					<a href="<?php echo get_permalink($post_id);?>" class="image-wrap <?php echo esc_attr($effect_classes);?>">
						<?php echo wp_kses_post($img);?>
						<div class="overlay"></div>
					</a>
				<?php else :?>		
					<a href="<?php echo get_permalink($post_id);?>" class="image-wrap no-image">
					<span class="sow-icon-eleganticons" data-sow-icon="&#xe006;" ></span>
					</a>	
				<?php endif;?>						
			</header>
		<?php endif;?>		
		<div class="entry-content <?php echo esc_attr($text_color);?> <?php echo esc_attr($entry_content_class);?>" style="background-color: <?php echo esc_attr($bg_color);?>">

			<?php if ($display_meta != false) :?>
			<div class="meta">
				<?php if ($display_date == 'in-meta') : ?>
					<span class="date small <?php echo esc_attr($readmore_color);?>-color font-3 opacity">
						<?php echo get_the_date( '', $post_id );?>
					</span>
					<span class="separator">|</span>
				<?php endif;?>	
				<?php 
				$categories = get_the_category($post_id);
		        $counter = 0; 
		        foreach ($categories as $category) :?>
		        	<?php if ($counter != 0) :?>
						<span class="separator">|</span>
					<?php endif;?>
				<?php $counter++;?>	
				<span class="entry-meta">
				<a class="font-3 small category opacity entry-meta" href="<?php echo get_category_link($category->term_id); ?>"><?php echo get_the_category_by_id($category->term_id); ?></a>
				</span>
		        <?php endforeach;?>
		    </div>
			<?php endif;?>
		    <?php //render post title
			if ($post_title != '') :?>
				<a class="<?php echo esc_attr($readmore_color);?>-hover" title="<?php echo get_post_field('post_title', $post_id);?>" href="<?php echo get_permalink($post_id);?>"> <h4 class="item-title <?php echo esc_attr($readmore_color);?>-hover <?php echo esc_attr($text_color);?>" > <?php echo get_post_field('post_title', $post_id);?></h4>
				</a>
			<?php endif;?>
			<?php if ($display_excerpt != false) : ?>
				<?php $excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $post_id)); ?>	
				<?php if ($excerpt == ""){
					$content = get_post_field('post_content', $post_id);
					// only till read more:
					$content_parts = get_extended( $content );

					if($content_parts['extended'] != '') {
						$content = $content_parts['main'];
						$excerpt .= '<p>';
						$excerpt .= $content;
						$excerpt .= '</p>';
					} else {
						$content = strip_shortcodes( $content );
						$content = strip_tags($content);
						$content = str_replace(']]>', ']]&gt;', $content);
						$excerpt_length = apply_filters('excerpt_length', 20);
						$excerpt .= '<p>';
						$excerpt .= wp_trim_words( $content, $excerpt_length, '' );
						$excerpt .= '...</p>';
					}
				};?>
				<div class="excerpt"> 
					<?php echo wp_kses_post($excerpt); ?>
				</div>
			<?php endif;?>
			<?php if ($display_readmore != false) : ?>
				<a class="btn <?php echo esc_attr($btn_classes);?>" title="<?php echo get_post_field('post_title', $post_id);?>" href="<?php echo get_permalink($post_id);?>"><?php echo esc_html($readmore_text);?></a>
			<?php endif;?>	
			</div>	
		</article>
	<?php endforeach; ?>
		<?php if ($layout == 'carousel') : ?>
		</div> <!-- owl-carousel -->
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
		<!-- </div>  -->
		<?php endif;?>
	</div>	<!-- wrapper -->
</div>	<!-- recent-post-carousel -->
