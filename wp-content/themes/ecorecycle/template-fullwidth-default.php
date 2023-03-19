
<?php get_header(); ?>
<!-- main content start -->
<div class="mainwrap">
	<div class="main clearfix">
		<div class="content fullwidth">
		<?php
		if(!class_exists('AQ_Page_Builder')) { 
			echo '<h1>'.get_the_title().'</h1>';
		} ?>		
			<div class="postcontent">
				<div class="posttext">
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<div class="usercontent"><?php the_content(); ?></div>
					<?php endwhile; endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>