<?php
$blog_type = 'classic';

$post_format = get_post_format();

if ($post_format == false) { $post_format = 'standard';	}; 

$post_class = 'clearfix';
$content_class = 'col-md-12';

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent' || $blog_content_bg == '') {
	$post_class .= " bg-transparent";
	$content_class = 'bg-transparent';
} else if($blog_content_bg != 'transparent' && $blog_content_bg != '') {
	if (orion_isColorLight($blog_content_bg) == false) {
		$post_class .= ' text-light';
	}
};
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<?php get_template_part( 'templates/posts/formats/format', $post_format );?>
	<?php if ($post_format != 'quote' && $post_format != 'status' && $post_format != 'link' && $post_format != 'image') : ?>
		<div class="<?php echo esc_attr($content_class);?>">
			<?php the_excerpt();?>
			<a class="btn btn-c1" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html_e('read more', 'recycle');?></a>
		</div>
	<?php endif; ?>
	</div> <!--content-wrap-->
</article>

