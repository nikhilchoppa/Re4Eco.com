<?php 
orion_set_masonry();
$grid_class = 'col-sm-6 masonry-item';
?>

<div id="post-<?php the_ID(); ?>" <?php post_class($grid_class); ?>>
	<?php get_template_part( 'templates/posts/content', 'archive-grid' ); ?>
</div>


