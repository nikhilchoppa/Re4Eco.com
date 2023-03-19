<?php 

get_header(); 

$orion_sidebars = orion_get_orion_sidebars();?>

<?php orion_get_orion_page_heading(); ?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section">
			<div class="row">
				<article id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php if ( have_posts() ) : ?>			
						<?php while ( have_posts() ) : the_post(); ?>
						
 						<header class="entry-header">
 						<a href="<?php echo wp_get_attachment_url(get_the_ID()); ?>"><?php echo wp_get_attachment_image(get_the_ID(), 'full'); ?></a>
 						</header>
 						
						<div class="entry-content">
							<?php the_content(); ?>	
						</div>
						<?php endwhile; ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>

								
				<?php 
				if (orion_get_option('comments_posts', false) == '1') {
					 comments_template();
				}?>					
				</article><!-- #primary -->
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
			</div>
		</main><!-- #main -->
	</div> <!-- container-->
</div> <!-- #content-->

<?php get_footer(); ?>