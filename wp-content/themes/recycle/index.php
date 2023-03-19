<?php 
get_header(); 
$orion_sidebars = orion_get_orion_sidebars();
if (is_home() && is_front_page() == false) {
	$page_for_posts = get_option( 'page_for_posts' );

	$orion_wp_meta = get_post_meta( $page_for_posts );
	if ( isset($orion_wp_meta['_recycle_heading_type']) && $orion_wp_meta['_recycle_heading_type'][0] != '') {
		if (isset($orion_wp_meta['_recycle_hide_heading']) && ($orion_wp_meta['_recycle_hide_heading'][0] == 'on')) {
		} else {			
			$blog_type = $orion_wp_meta['_recycle_heading_type'][0];
		}
	} else {
		$blog_type = orion_get_option('post_heading_type', false);
	}
} else {
	$blog_type = orion_get_option('post_heading_type', false);
}?>

<?php 
	if(isset( $blog_type )) {
		get_template_part( 'templates/heading/content-heading', $blog_type); 
	}
?>
<div class="site-content" id="content">
	<div class="container">
		<main id="main" class="site-main section row">
				<div id="primary" class="<?php echo esc_attr($orion_sidebars['primary_class']);?>">				
					<?php if ( have_posts() ) : ?>	
						<?php $blog_type = orion_get_blog_type();
							if (strpos($blog_type, 'grid') !== false) {
								$row_class = 'grid';
							} elseif (strpos($blog_type, 'masonry') !== false){
								$row_class = orion_get_blog_type() . ' masonry row';
							} else {
								$row_class = orion_get_blog_type();
							}
						?>
						<div class="<?php echo esc_attr($row_class);?>">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part( 'templates/blog/content-blog', orion_get_blog_type() ); ?>
							<?php endwhile; ?>
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

<?php get_footer(); 