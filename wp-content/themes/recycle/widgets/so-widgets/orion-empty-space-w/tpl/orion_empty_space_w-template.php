<?php  //prepare variables
	$empty_space = $instance['empty_space'];
	
	$classes = '';
	$displays = array('visible-lg','visible-md','visible-sm','visible-xs');

	foreach ($displays as $display) {
		if($instance[$display])	 {
			$classes .= ' '. $display;
		}	
	}
?>
	<div class="row empty-space <?php echo esc_attr($classes);?>" style="height:<?php echo esc_attr($empty_space);?>px;">
	</div>