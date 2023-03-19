<?php 
get_header(); 
?>

<?php get_template_part( 'templates/heading/content-heading', orion_get_option('post_heading_type', false) ); ?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row">
				<div id="primary" class="col-md-12">				
					<?php if ( have_posts() ) : ?>	
						<div class="row">
							<?php while ( have_posts() ) : the_post(); ?>
								<div class="team-member clearfix wrap-12">
									<div class="row">
									<?php get_template_part( 'templates/posts/post-types/team-member', 'archive' ); ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
						<?php orion_paging_nav(); ?>
					<?php else : ?>
						<?php get_template_part( 'content', 'none' ); ?>
					<?php endif; ?>		
				</div><!-- #primary -->
		</main><!-- #main -->
	</div> <!-- container-->
</div> <!-- #content-->

<?php get_footer(); 