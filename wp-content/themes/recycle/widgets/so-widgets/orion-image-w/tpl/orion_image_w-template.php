<?php 
/* prepare input variables */

$image = $instance['image'];
$hovertext = $instance['hovertext'];
$url = $instance['url'];
$onclick = $instance['onclick'];
$image_style = $instance['style_section']['image_style'];
$text_color = $instance['style_section']['text_color'];
$image_overlay = $instance['style_section']['image_overlay'];
$image_overlay_hover = $instance['style_section']['image_overlay_hover'];

/* prepare output variables */
// image
$image_class = $instance['style_section']['image_style'];
if ($image_style == 'orion_circle') {
	$image_size = 'orion_square';
	$image_class .= ' image-wrap rounded';
} else {
	$image_size = $image_style;
}
// link;
if (preg_match('#^post#', $url) === 1) {
	preg_match_all('!\d+!', $url, $post_id);
	$post_url = get_permalink($post_id[0][0]);
	$url = $post_url;
}

// overlay
$image_class .= ' ' . $image_overlay . ' ' . $image_overlay_hover;
?>

<div class="image-w relative">

		<?php $img = wp_get_attachment_image($image, $image_size);?>
		
		<?php // add a link?
		if($onclick == 'link' && $url != '') : ?>
			<a class="<?php echo esc_attr($image_class);?>" href="<?php echo esc_url($url);?>">
		<?php elseif ($onclick == 'lightbox') : ?>
			<?php $large_image = wp_get_attachment_image_src($image, 'large');?>
			<a class="<?php echo esc_attr($image_class);?>" href="<?php echo wp_kses_post($large_image[0]);?>">
		<?php else : ?>
			<div class="<?php echo esc_attr($image_class);?>">
		<?php endif; ?>
			<?php echo wp_kses_post($img);?>
			<div class="overlay"></div>
		<?php if($onclick == 'lightbox' || ($url != '' && $onclick == 'link')) : ?>
			</a>
		<?php else : ?>
			</div>
		<?php endif; ?>	
	
	<div class="absolute">
		<div class="hover-desc table-wrap">
			<div class="cell-wrap">
				<h4 class="<?php echo esc_attr($text_color);?>"><?php echo wp_kses_post($hovertext);?></h4>
			</div>
		</div>
	</div>					
</div>

