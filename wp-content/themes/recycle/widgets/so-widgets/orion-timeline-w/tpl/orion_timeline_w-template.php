<?php  //prepare variables
	
	switch ($instance['widget_style']['skin']) {
	    case "text-light":
	    	$text_color = 'text-light';
	    	break;
		case "text-dark":
			$text_color = 'text-dark';
			break;
		default:	
			$text_color = 'text-dark';
			break;
	}	
?>

<div class="timeline <?php echo esc_attr($text_color);?>">
	<?php foreach ($instance['repeater'] as $timeline) :?>
	
	<?php // variables */
	switch ($instance['widget_style']['skin']) {
	    case "text-light":
	    	$oposite_color = 'text-dark';
	    	$highlight_color_bg = 'white-color-bg';
	    	break;
		case "text-dark":
			$oposite_color = 'text-light';
			$highlight_color_bg = 'white-rgba-bg';
			$highlight_color = 'white-rgba';
			break;
		default:	
			$highlight_color_bg = 'white-rgba-bg';
			$oposite_color = 'text-light';
			$highlight_color = 'black-rgba';
			break;
	}

		$date = $timeline['date'];
		$title = $timeline['timeline-title'];
		$description = $timeline['description'];
		$highlight = $timeline['highlight'];


		
		// $highlight_color_bg = $text_color;
		$span_color = $text_color;

		if ($instance['widget_style']['skin'] == 'text-dark') {
			if($highlight == true) {
				$font_weight_class = 'text-bold';
				$highlight_class = ' highlight';
				$highlight_color_bg = 'primary-color-bg';
				$highlight_color = 'primary-color';
				$span_color = $oposite_color;
			} else {
				$highlight_class = '';
				$font_weight_class = '';
			}
		} else {
			if($highlight == true) {
				$font_weight_class = 'text-bold';
				$highlight_class = ' highlight';
				$highlight_color_bg = 'white-bg';
				$highlight_color = 'white-color';
				$span_color = 'primary-color';
			} else {
				$highlight_class = '';
				$font_weight_class = '';
				$highlight_color_bg = 'black-rgba-bg-xlight';
				$highlight_color = 'black-rgba-xlight';

			}
		}

		switch ($instance['widget_style']['skin']) {
		    case "text-light":
		    	$timeline_item_color_class = 'white-color';
		    	break;
			case "text-dark":
				$timeline_item_color_class = 'primary-color';
				break;
			default:	
				$timeline_item_color_class = 'primary-color';
				break;
		}	
	?>
    <div class="timeline-item <?php echo esc_attr($timeline_item_color_class);?> <?php echo esc_attr($highlight_class);?>">
        <div class="timeline-year font-2 <?php echo esc_attr($highlight_color);?> <?php echo esc_attr($highlight_color_bg);?> text-center ">
        <span class="<?php echo esc_attr($font_weight_class);?> <?php echo esc_attr($span_color);?>"><?php echo esc_html($date);?></span>
        </div>
    	<div class="timeline-content">
        	<h3 class="item-title"><?php echo esc_html($title);?></h3>
        	<div class="timeline-text <?php echo esc_attr($text_color);?>"><?php echo wp_kses_post($description);?></div>
   		</div>
	</div>
	<?php endforeach;?>
</div>