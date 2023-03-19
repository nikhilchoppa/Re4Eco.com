<?php
/**
 * Displays Masonry in 4 columns (use for posts)
 *
 * Loop Name: 4 columns masonry blog
 *
 * @package recycle
 * @since recycle 1.0
 */
?>


<?php
orion_set_masonry();
$grid_class = 'col-sm-6 col-md-3 masonry-item';
$blog_type = 'masonry';
?>
<?php if ( have_posts() ) : ?>	
	<div class="row masonry masonry-2">
	<?php while ( have_posts() ) : the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class($grid_class); ?>>
			<?php get_template_part( 'templates/posts/content-archive-grid');?>
		</div>
	<?php endwhile; ?>	
	</div>
<?php endif;?>


