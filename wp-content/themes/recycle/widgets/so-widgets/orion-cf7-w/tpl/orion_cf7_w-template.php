<?php  //prepare variables
$cf7_id = $instance['cf7_option'];
$cf7_name = get_post_field( 'post_name', $cf7_id); 
?>

<?php //title
if(!empty($instance['title'])) : ?>
	<div class="widget-header">
		<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
	</div>
<?php endif; ?>

<?php echo do_shortcode('[contact-form-7 id="' . $cf7_id . '" title="' .$cf7_name . ' "]');?>