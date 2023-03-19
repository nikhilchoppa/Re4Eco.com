<?php //title
if(!empty($instance['title'])) : ?>
	<div class="widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>

<?php 
if(isset($instance['static_block']) && $instance['static_block'] != '' ) {
	echo '<div class="staticblock-wrap">';
   	echo siteorigin_panels_render($instance['static_block']);
   	echo '</div>';
} 
?>
