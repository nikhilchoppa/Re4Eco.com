<?php 
get_header(); 
$orion_sidebars = orion_get_orion_sidebars();

$blog_type = orion_get_option('post_heading_type', false);
if(isset( $blog_type )) {
	get_template_part( 'templates/heading/content-heading', $blog_type); 
}?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row">
				<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php if ( have_posts() ) : ?>
					<div class="isotope-wrap">	
						<div class="isotope-items relative row">		
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/posts/post-types/content', 'portfolio-archive' );?>
						<?php endwhile; ?>
						</div>
					</div>
					<?php orion_paging_nav(); ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>	
				</div><!-- #primary -->
			<?php if ( $orion_sidebars['ot_left_sidebar_id']): ?>
				<aside class="left-s sidebar <?php echo esc_attr($orion_sidebars['left_sidebar_class']);?>">
				    <section><?php dynamic_sidebar($orion_sidebars['ot_left_sidebar_id']); ?></section>
				</aside>   
			<?php endif; ?>

			<?php if ( $orion_sidebars['ot_right_sidebar_id']): ?>
			    <aside class="right-s sidebar <?php echo esc_attr($orion_sidebars['right_sidebar_class']);?>">
				    <section><?php dynamic_sidebar($orion_sidebars['ot_right_sidebar_id']); ?></section>
			    </aside>   
			<?php endif; ?>			
		</main><!-- #main -->
	</div> <!-- container-->
</div> <!-- #content-->

<?php get_footer(); ?>