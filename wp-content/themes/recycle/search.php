<?php
/*
Template Name: Search Page
*/

get_header(); 
$orion_sidebars = orion_get_orion_sidebars();
?>

<?php get_template_part( 'templates/heading/content-heading', orion_get_option('post_heading_type', false) ); ?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row">
			<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
				<?php if ( have_posts() ) : ?>	
					<div class="row">
						<div class="col-md-12">
							<?php $total_results = $wp_query->found_posts;?>
							<p class="text-uppercase number-results"><?php echo esc_attr($total_results);?> <?php _e('results found for: ', 'recycle'); ?><?php echo esc_attr($_GET['s']); ?></p></mark>
							
						</div>
						<?php while ( have_posts() ) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" class="col-md-12" >
							<a class="entry-title" href="<?php echo the_permalink(); ?>">
								<h3><?php the_title(); ?></h3>
							</a>
							<?php the_excerpt();?>
							<a class="btn btn-md" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo esc_html_e('read more', 'recycle');?></a>
							<hr>
						</article>

						<?php endwhile; ?>
					</div>					
					
					<?php orion_paging_nav(); ?>

				<?php else : ?>
					<p class="no-results"><span class="text-uppercase"><?php _e('No results found for:', 'recycle'); ?></span> <strong><?php echo esc_attr($_GET['s']); ?></strong>. <?php _e('Modify your search query and try again.', 'recycle'); ?></p>
					<?php get_search_form();?>
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