<?php
/**
 * Displays Content of pages
 *
 * Loop Name: Page display
 *
 * @package recycle
 * @since recycle 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array(
		'before'      => '<ul class="page-numbers p-numbers"><li>',
		'after'       => '</li></ul>',
		'separator'   =>  '</li><li>',
		) );
		?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
