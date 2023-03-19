<?php 
/**
 * The template for displaying 404 pages (Not Found)
 *
 */
$error_page = orion_get_theme_option_css(array('page_404'), '');
get_header();
orion_get_orion_page_heading();
if ($error_page != '') {
	$query = new WP_Query( array( 'page_id' => $error_page ) );
    if ( $query->have_posts() ) {
	    while ( $query->have_posts() ) : ?>
	    <?php $padding_classes = get_orion_page_padding($query->query['page_id']);?>
			<div class="site-content page-404" id="content">
				<div class="container">
					<main id="main" class="site-main section page-404 row <?php echo esc_attr($padding_classes);?>">
						<div class="row">
							<div id="primary" class="col-md-12">	    	
							    <?php $query->the_post(); ?>				      
								<?php the_content(); ?>
							</div><!-- #primary -->		
						</div>
					</main><!-- #main -->
				</div> <!-- container-->
			</div> <!-- #content-->
	      <?php get_footer(); ?>
    	<?php endwhile; 
    }	
} else { ?>
	<div class="site-content page-404 color-primary" id="content">
		<div class="container">
			<main id="main" class="site-main section" role="main">
				<div class="row">
					<div id="primary" class="col-md-12">
						<div class="col-md-12 separator-style-2 text-center style-primary-color er404">
							<h1 class="error404 text-center primary-color">404</h1>
						</div>
						<div class="col-md-12 error-msg">
							<h5 class="text-center text-uppercase"><?php esc_html_e('The page you are looking for could not be found.' , 'recycle');?></h5>
							<div class="text-center"><?php esc_html_e('If you think this is a technical issue, please contact the site administrator.', 'recycle'); ?></div>
						</div>
						<div class="text-center footer-404 col-md-12">
							<a class="btn btn-md" href="<?php echo esc_url(get_home_url('/'));?>"><?php esc_html_e('Return home' , 'recycle');?></a>
						</div>						
					</div><!-- #primary -->		
				</div>
			</main><!-- #main -->
		</div> <!-- container-->
	</div> <!-- #content-->
	<?php get_footer(); 
}