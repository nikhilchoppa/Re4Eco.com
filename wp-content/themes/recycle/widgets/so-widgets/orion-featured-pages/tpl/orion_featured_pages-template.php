<?php 
/* prepare variables */
$column_class = 'col-md-'.(12 / $instance['per_row'].' col-sm-6');
if ($column_class != 'col-md-12') {		
	$column_class .= ' col-sm-6';		
}

$per_row = $instance['per_row'];
$count_elements = count($instance['pages_repeater']);
$layout = $instance['display_layout'];

//text color:
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
 
// options section
$display_feeatured = $instance['option_section']['display_feeatured'];
$display_excerpt = $instance['option_section']['display_excerpt'];
$display_readmore = $instance['option_section']['display_readmore'];
$readmore_text = $instance['option_section']['readmore_text'];
// carousel options
$navigation_carousel = $instance['option_section']['option_carousel']['navigation_carousel'];
$autoplay_timeout = $instance['option_section']['option_carousel']['autoplay_timeout'];
$display_mobile_nav = false;
if (isset($instance['option_section']['option_carousel']['display_mobile_nav'])) {
	$display_mobile_nav = $instance['option_section']['option_carousel']['display_mobile_nav'];
}
if($instance['option_section']['option_carousel']['autoplay'] == '1') {
	$autoplay = 'true';
} else {
	$autoplay = 'false';
}
$autoplay_data = '';

// style
$bg_color = 'transparent';
$title_hover_color = $instance['style_section']['title_hover_color'];
switch ($title_hover_color) {
	case 'primary':
		$btn_color = 'c1';
		break;
	case 'secondary':
		$btn_color = 'c2';
		break;	
	case 'tertiary':
		$btn_color = 'c3';
		break;
	case 'white':
		$btn_color = 'white';
		break;
	case 'black':
		$btn_color = 'black';
		break;				
	default:
	 $btn_color = $title_hover_color;
}
$entry_content_class = '';
$hex = $instance['style_section']['bg_color'];
$alpha = ($instance['style_section']['bg_opacy']/100);
$article_class = '';
if ($hex) {
	$bg_color = orion_hextorgba($hex, $alpha);	
	$entry_content_class = 'padding-medium';
	$article_class = 'has_padding';
} 

$image_overlay = $instance['style_section']['image_overlay'];
$image_hover_overlay = $instance['style_section']['image_overlay_hover'];
$scale_efect = $instance['style_section']['scale_efect'];
$hover_resize = $instance['style_section']['hover_resize'];

if ($hover_resize == true) {
	$article_class .= ' hover-resize';
}

$effect_classes = $image_overlay . ' ' . $image_hover_overlay . ' ' . $scale_efect;
?>
<?php /* row class */
$row_class = $layout;
if ($navigation_carousel == 'arrows_top') {
	$row_class .= ' top-nav';
}
if ($navigation_carousel == 'arrows_aside') {
	$row_class .= ' aside-nav';
}
if ($text_color != '') {
	$row_class .= ' ' . $text_color;
} ?>

<?php 
$wrapper_class = '';
if ($layout == 'carousel') {
	$wrapper_class = ' type-' . $navigation_carousel;
}
?>
<?php 
$display_mobile_nav_class = '';
if ($layout == 'carousel' && $display_mobile_nav != true) {
	$display_mobile_nav_class = ' hide-mobile-nav';
}
?>

<?php 
?>
<div class="row featured-pages <?php echo esc_attr($row_class);?><?php echo esc_attr($display_mobile_nav_class);?>">

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

		<div class="owl-carousel owl-theme clearfix" data-col="<?php echo esc_html($instance['per_row']);?>" data-autoplay="<?php echo esc_attr($autoplay);?>" data-dots="<?php echo ($navigation_carousel == 'dots');?>"<?php echo esc_attr($autoplay_data);?>>

			<?php $column_class = 'col-md-12';?>
	<?php endif; ?>
		<?php // render pages ?>
		<?php foreach ($instance['pages_repeater'] as $page) : ?>
			<?php 
			$page_id = $page['page_id'];
			?>
			<article class="item <?php echo esc_attr($column_class);?> <?php echo esc_attr($article_class);?>">

				<?php if ($display_feeatured != false) : ?>			
					<?php 
					if($per_row == 1) {
						$img = get_the_post_thumbnail($page_id, 'large');
					} else {
						$img = get_the_post_thumbnail($page_id, 'orion_carousel');
					};?>
					<header class="entry-header">
				
					<?php if ($img != "") : ?>
						<a href="<?php echo get_permalink($page_id);?>" class="image-wrap <?php echo esc_attr($effect_classes);?>">
							<?php echo wp_kses_post($img);?>
							<div class="overlay"></div>
						</a>
					<?php else :?>		
						<a href="<?php echo get_permalink($page_id);?>" class="image-wrap no-image">
						<span class="sow-icon-eleganticons" data-sow-icon="&#xe006;" ></span>
						</a>
					<?php endif;?>						

					</header>
				<?php endif; ?>
				<div class="entry-content <?php echo esc_attr($text_color);?> <?php echo esc_attr($entry_content_class);?>" style="background-color: <?php echo esc_attr($bg_color);?>">
					<?php //render post title
					$heading_class = '';
					if (get_post_field('post_title', $page_id)) :?>
						
						<a class="item-title" title="<?php echo get_post_field('post_title', $page_id);?>" href="<?php echo get_permalink($page_id);?>"> 
							<h4 class="<?php echo esc_attr($heading_class);?> <?php echo esc_attr($title_hover_color);?>-hover <?php echo esc_attr($text_color);?>">
							<?php echo get_post_field('post_title', $page_id);?>
							</h4>
						</a>
					<?php endif; ?>	

					<?php if ($display_excerpt != false) : ?>		
						<?php // the excerpt
						$excerpt = apply_filters('the_excerpt', get_post_field('post_excerpt', $page_id)); ?>	
						<?php if ($excerpt == ""){
							$content = get_post_field('post_content', $page_id); 
							$content = preg_replace('/(<script[^>]*>.+?<\/script>|<style[^>]*>.+?<\/style>)/s', '', $content);
							// only till read more:
							$content_parts = get_extended( $content );

							if($content_parts['extended'] != '') {
								$content = $content_parts['main'];
								$excerpt .= '<p>';
								$excerpt .= $content;
								$excerpt .= '</p>';
							} else {
								// strip out shortcodes:
								$content = strip_shortcodes( $content );
								$content = strip_tags($content);
								$content = str_replace(']]>', ']]&gt;', $content);
								$excerpt_length = apply_filters('excerpt_length', 20);
								$excerpt .= '<p>';
								$excerpt .= wp_trim_words( $content, $excerpt_length, '' );
								$excerpt .= '...</p>';
							}	
						};?>
						<?php //render excerpt
						if ($excerpt != "") : ?>
							<div class="excerpt"> 
								<?php echo wp_kses_post($excerpt); ?>
							</div>
						<?php endif; ?>
					<?php endif; ?>
				
					<?php if ($display_readmore == true) : ?>
						<a class="btn btn-sm btn-<?php echo esc_attr($btn_color);?>" title="<?php echo get_post_field('post_title', $page_id);?>" href="<?php echo get_permalink($page_id);?>"><?php echo esc_html($readmore_text);?></a>
					<?php endif; ?>
				</div>
			</article>
		<?php endforeach; ?>
		
		<?php //end carousel div
		if ($layout == 'carousel' ) : ?>
			</div>
			<?php if ($navigation_carousel == 'arrows_aside') : ?>
				<div class="nav-controll arrows-aside">
					<div class="owl-nav aside <?php echo esc_attr($text_color);?>">
						<a class="btn btn-sm btn-empty owlprev icon btn-<?php echo esc_attr($btn_color);?>" ><i class="fa fa-angle-left"></i></a>
						<a class="btn btn-sm btn-empty owlnext icon btn-<?php echo esc_attr($btn_color);?>" ><i class="fa fa-angle-right"></i></a>
					</div>
				</div>
			<?php endif; ?>				
			<?php if($navigation_carousel == 'arrows_bottom' ) : ?>
				<div class="nav-controll bottom">
					<div class="owl-nav style-1 bottom text-right col-md-12 <?php echo esc_attr($text_color);?>">
						<a class="btn btn-sm btn-flat owlprev icon <?php echo esc_attr($text_color);?>" ><i class="eleganticons-arrow_left"></i></a>
						<a class="btn btn-sm btn-flat owlnext icon <?php echo esc_attr($text_color);?>" ><i class="eleganticons-arrow_right"></i></a>
					</div>
				</div>
			<?php endif;?>
		<?php endif; ?>
	</div>
</div>