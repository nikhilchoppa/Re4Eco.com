<?php  //prepare variables
	$listsliders = $instance['listsliders'];

	if ( class_exists( 'RevSlider' ) ) : ?>
		<?php $rev_slider = new RevSlider();
		$sliders = $rev_slider->getAllSliderAliases(); 

		if (in_array($listsliders, $sliders)) : ?>
			<?php 
			if (function_exists('putRevSlider')) {
				putRevSlider($listsliders);
			} else {
				esc_html_e('Slider can not be displayed.', 'recycle');
			}		
			?>
		<?php else :?>
			<h2><?php esc_html_e('Please select a slider', 'recycle');?></h2>
		<?php endif;?>
	<?php else :?>
		<h2><?php esc_html_e('Revolution slider not installed', 'recycle');?></h2>
	<?php endif;?>
