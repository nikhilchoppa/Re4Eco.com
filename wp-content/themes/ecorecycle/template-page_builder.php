<?php
/*
Template Name: Template for page builder
*/
?>
<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<div class="usercontent">	
			<?php
		if(!class_exists('AQ_Page_Builder')) { 
			echo '<h1>'.get_the_title().'</h1>';
		} ?>
		<?php
		if(!class_exists('AQ_Page_Builder')) { 
			echo '<h1>'.get_the_title().'</h1>';
		} ?>	
		<?php 	
		global $pmc_data;	
		$post_custom = get_post_custom($post->ID);		
		if(isset($post_custom['page_builder'][0]) && $post_custom['page_builder'][0] != 'none'){			
			echo do_shortcode( stripslashes('[template id="'.esc_attr($post_custom['page_builder'][0]).'"]') );
		}
		?>	
		<?php the_content(); ?>		
	</div>
	<?php endwhile; endif; ?>
<?php get_footer(); ?>
