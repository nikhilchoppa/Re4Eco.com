<?php
 
$post_format = get_post_format();
if ($post_format == false) { $post_format = 'standard';	}; 
$col_12_margin = 'margin-top:24px;';

$post_class = 'clearfix';
$content_class = 'col-md-12';
$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent') {
	$post_class .= " bg-transparent";
	$content_class = 'bg-transparent';
} else if($blog_content_bg != 'transparent' && $blog_content_bg != '') {
	if (orion_isColorLight($blog_content_bg) == false) {
		$post_class .= ' text-light';
	}
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<?php get_template_part( 'templates/posts/formats/format', $post_format );?>
	
	<div class="entry-content <?php echo esc_attr($content_class);?>">

		<?php if ($post_format == 'quote' || $post_format == 'link') : ?>
		<div class="<?php echo esc_attr($content_class);?>">
		<?php endif; ?> 

		<?php if ($post_format == 'quote' || $post_format == 'link' || $post_format == 'status') :?>
			<?php if ($post_format == 'quote' || $post_format == 'link') : ?>
				<div class="col-md-12" style="<?php echo esc_attr($col_12_margin);?>"></div>
			<?php endif;?>	
			<h2 class="h3 entry-title"><?php the_title(); ?></h2>				
		<?php endif; ?> 	
		
		<?php the_content();?>
		<?php get_template_part( 'templates/parts/single', 'part_bottom_meta' ); ?>

		<?php if ($post_format == 'quote' || $post_format == 'link') :?>
		</div>
		<?php endif; ?> 
	</div>
	</div> <!--content-wrap-->
</article>

