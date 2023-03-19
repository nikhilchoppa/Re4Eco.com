<?php 
/*
Template Name: Single Team member
*/

get_header(); 
$orion_sidebars = orion_get_orion_sidebars();
$padding_classes = get_orion_page_padding();?>
<?php orion_get_orion_page_heading(); ?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row<?php echo esc_attr($padding_classes);?>">
				<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php if ( have_posts() ) : ?>			
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/posts/post-types/team', 'member' ); ?>
						<?php endwhile; ?>
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

<?php get_footer(); 

