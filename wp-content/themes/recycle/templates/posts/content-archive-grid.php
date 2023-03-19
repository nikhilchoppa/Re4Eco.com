<?php
/**
 *
 * @package recycle
 */
?>

<?php
$content_wrap_css = '';
$content_col_css = '';
$padding_class = "class='col-md-12'";
$wrapper_class = "";

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent') {
	$content_wrap_css = "style='padding-left:0; padding-right:0; background-color: transparent;'";
	$content_col_css = "style='padding-left:0; padding-right:0;'";
	$padding_class = '';
	$wrapper_class = " bg-transparent";
} else if ($blog_content_bg != '') {
	$content_wrap_css = "style='background-color:".$blog_content_bg.";'";
	if (orion_isColorLight($blog_content_bg) == false) {
		$wrapper_class = ' text-light';
	}	
};
?>


<div class="wrapper<?php echo esc_attr($wrapper_class);?>" <?php echo wp_kses_post($content_wrap_css);?>>
	<?php
		$post_format = get_post_format();
		if ($post_format == false) { $post_format = 'standard';	}; 
	?>
	<?php get_template_part( 'templates/posts/formats/format', $post_format );?>
	<?php if ($post_format != 'quote' && $post_format != 'status' && $post_format != 'link') : ?>
		<div <?php echo wp_kses_post($padding_class);?>>
			<?php echo esc_html(orion_excerpt_length(22));?>	
		</div>
		
		<footer <?php echo wp_kses_post($padding_class);?>>
			<a class="btn btn-c1 btn-sm" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html_e('read more', 'recycle');?></a>
		</footer>
	<?php endif; ?>
	</div> <!--content-wrap-->
</div>