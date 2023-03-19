<?php  

orion_set_counter();
//prepare variables
$counter_number = $instance['counter_number'];
$counter_number_end = $instance['counter_number_end'];
$counter_speed = $instance['counter_speed'];
$counter_text = $instance['counter_text'];
$text_color = $instance['text_color'];
?>

<div class="counter-table">
	<div class="table-cell content <?php echo esc_attr($text_color);?>">
		<div class="counternumber block text-center font-2 h1 <?php echo esc_attr($text_color);?>" data-from="<?php echo esc_attr($counter_number_end);?>" data-speed="<?php echo esc_attr($counter_speed);?>" data-to="<?php echo esc_attr($counter_number);?>"></div>
		<h6 class="h6 countertext block text-center <?php echo esc_attr($text_color);?>"><?php echo esc_html($counter_text);?></h6>
	</div>
</div>