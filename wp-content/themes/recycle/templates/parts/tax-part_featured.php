<?php $format = get_post_format(); 
if (!$format) : ?>
		<a href="<?php the_permalink(); ?>" class="featured image">
			<?php the_post_thumbnail('large');?>
		</a>
<?php else : ?>
	<?php get_template_part( 'templates/post/featured', $format ); ?>
<?php endif;

