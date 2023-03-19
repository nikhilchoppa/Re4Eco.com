<?php  //prepare variables
	$orion_video = $instance['video_url'];
	$lightbox = $instance['lightbox_options']['lightbox'];
	$image = $instance['lightbox_options']['image'];
	$play_icon = $instance['lightbox_options']['play_icon'];

	$video_image = '';
	if ($image) {
		$get_image = wp_get_attachment_image_src($image, 'full');
		$video_image = $get_image[0];
	};
?>	

<?php if ($orion_video != '') :?>
	<?php if($lightbox != true) :?>
	<div class="video embed-responsive embed-responsive-16by9">
		<?php echo wp_oembed_get( $orion_video, array( 'width' => 1140 ) ); ?>
	</div>
	<?php else : ?>
	<?php $unique_rel = uniqid(); ?>
	<a rel="<?php echo esc_attr($unique_rel);?>" class="swipebox-video swipebox relative" href="<?php echo esc_url($orion_video);?>">
		<img src="<?php echo esc_url($video_image);?>" alt="<?php _e('Play video', 'recycle');?>"/>
		<?php if ($play_icon != '') :?>
			<div class="play-icon absolute <?php echo esc_attr($play_icon);?>">
				<i class="fa fa-play-circle-o" aria-hidden="true"></i>
			</div>
		<?php endif;?>
	</a>
	<?php endif;?>
<?php else :?>
	<h2>Please select a video</h2>
<?php endif;?>