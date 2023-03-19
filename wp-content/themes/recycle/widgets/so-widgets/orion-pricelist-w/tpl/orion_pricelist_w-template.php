<?php  //prepare variables
	$column_class = 'col-md-12';
	switch ($instance['text_color']) {
	    case "text-light":
	    	$text_color = 'text-light';
	    	break;
		case "text-dark":
			$text_color = 'text-dark';
			break;
		default:	
			$text_color = '';
			break;
	}
	$service_name_color = $instance['style_section']['service_name_color'];
	$service_price_color = $instance['style_section']['service_price_color'];
	$service_desc_color  = $instance['style_section']['service_desc_color'];

	$service_name_color_style = '';
	$service_price_color_style = '';
	$service_desc_color_style = '';

	if($service_name_color != '') {
		$service_name_color_style = 'style="color:'. $service_name_color .';"';
	}
	if($service_price_color != '') {
		$service_price_color_style = 'style="color:'. $service_price_color .';"';
	}
	if($service_desc_color != '') {
		$service_desc_color_style = 'style="color:'. $service_desc_color .';"';
	}		

?>

<div class="orion-pricelist row <?php echo esc_attr($text_color);?>">
	<?php

	if(!empty($instance['title'])) : ?>
		<div class="col-md-12 entry-header">
			<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>	

	<?php foreach ($instance['widget_repeater'] as $price_item) :?>
		<div class="item <?php echo esc_attr($column_class);?>">
			<div class="title relative">
				<h4 class="item-title " <?php echo wp_kses_post($service_name_color_style);?> >
					<?php echo esc_html($price_item["service_name"]);?>		
				</h4>

				<?php if(!empty($price_item["service_price"])) : ?>
					<h4 class="price item-title absolute top-right" <?php echo wp_kses_post($service_price_color_style);?>><?php echo esc_html($price_item["service_price"]);?></h4>
				<?php endif;?>
			</div>

			<div class="description" <?php echo wp_kses_post($service_desc_color_style);?>>
				<?php echo wp_kses_post($price_item["description"]);?>
			</div>
		</div>
	<?php endforeach;?>
</div>