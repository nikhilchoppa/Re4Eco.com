<?php 
// same as post format standard
if ( has_post_thumbnail() ) : ?>
<header class="entry-header">
	 <?php 
	 if (is_single()) {
		the_post_thumbnail('orion_container_width' );
	 } else {
		the_post_thumbnail('orion_carousel' );
	 }
	 ?>
</header> 
<?php endif; ?>

<?php
	$content_wrap_css = '';
	$content_col_css = '';
	$padding_class = "class='col-md-12'";
	$entry_title_h1_class = "";

	$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
	if ($blog_content_bg == 'transparent') {
		$content_wrap_css = "style='padding-left:0; padding-right:0; background-color: transparent;'";
		$content_col_css = "style='padding-left:0; padding-right:0;'";
		$padding_class = '';
	} else if ($blog_content_bg != '') {
		$content_wrap_css = "style='background-color:".$blog_content_bg.";'";
		if (orion_isColorLight($blog_content_bg) == false) {
			$entry_title_h1_class = " text-light";
		}
	};
	?>

<div class="content-wrap clearfix" <?php echo wp_kses_post($content_wrap_css);?>>
	<?php if(is_single()) :?>
	<div <?php echo wp_kses_post($padding_class);?> <?php echo wp_kses_post($content_col_css);?>>
		<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
		<h1 class="entry-title<?php echo esc_attr($entry_title_h1_class);?>"><?php the_title(); ?></h1>
	</div>
	<?php else : ?>
	<div <?php echo wp_kses_post($padding_class);?> <?php echo wp_kses_post($content_col_css);?>>
		<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>

		<?php 
		if (!isset($blog_type)) {
			$blog_type = orion_get_blog_type();
		}
		if (strpos($blog_type, 'grid') !== false || strpos($blog_type, 'masonry') !== false) : ?>
			<h2 class="h3 entry-title">
		<?php else : ?>
			<h2 class="entry-title">
		<?php endif;?>	
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?>
				</a>
			</h2>
	</div>	
	<?php endif;?>
