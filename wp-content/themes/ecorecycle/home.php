<?php if(class_exists('AQ_Page_Builder')) {  ?>
	<?php get_header(); ?>
			<div class="usercontent">		
				<?php 	
				global $pmc_data;				
				echo do_shortcode( stripslashes('[template id="'.esc_attr($pmc_data['blog_content']).'"]') );
				?>	
			</div>
	<?php get_footer(); ?>
<?php } else { ?>
	<?php get_template_part('index'); ?>
<?php } ?>
