<?php 

$grid_class = 'col-md-6';
if (!is_sticky(get_the_ID())) {
	$grid_class = 'col-md-6';
} else {
	$grid_class = 'col-md-12';
}
?>
	<?php if ( is_sticky(get_the_ID())) : ?>
		<div class="wrapper sticky col-md-6">
	<?php endif;?>

		<article id="post-<?php the_ID(); ?>" <?php post_class($grid_class); ?>>
			<?php get_template_part( 'templates/posts/content', 'archive-grid' ); ?>
		</article>

	<?php if (is_sticky(get_the_ID())) : ?>
	</div>
	<?php endif;?>
