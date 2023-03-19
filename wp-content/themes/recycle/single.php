<?php 
/*
Template Name: Single post
*/
get_header(); 
$orion_sidebars = orion_get_orion_sidebars();?>
<?php // post title
	if(orion_get_theme_option_css('title_single_post_onoff', '0' ) == '1') {
		orion_get_orion_page_heading();	
	}
?>

<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row">
				<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php if ( have_posts() ) : ?>			
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'templates/posts/content', 'single' ); ?>
						<?php endwhile; ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>	
				<?php if (orion_get_option('comments_posts', false, true) == '1') {
					 comments_template();
				}?>
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