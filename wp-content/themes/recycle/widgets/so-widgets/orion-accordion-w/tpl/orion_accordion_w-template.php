<?php	
	//prepare variables
	$uniqid = uniqid();
	switch ($instance['style_section']['text_color']) {
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
	$nav_text_color = $instance['style_section']['nav_text_color'];

	$bg_color = 'transparent';
	$hex = $instance['style_section']['bg_color'];
	$alpha = ($instance['style_section']['bg_opacy']/100);
	if ($hex) {
		$bg_color = orion_hextorgba($hex, $alpha);
	}
	
	$hover_color = $instance['style_section']['hover_color'];
	if(!empty($instance['style_section']['border_color'])) {
		$border_color = $instance['style_section']['border_color'];	
		$border_style = 'border-color:'. $border_color.';';
		$panel_style = "";
	} else {
		$border_color = 'transparent';
		$border_style = 'border-color:'. $border_color.'; border-bottom: none;';
		$panel_style = 'margin-bottom: 0;';
	}
	if(!empty($instance['title'])) : ?>
		<div class=" entry-header style-<?php echo esc_attr($text_color);?>">
			<h2 class="h5 widget-title <?php echo esc_attr($text_color);?>"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>	

	<div class="panel-group <?php echo esc_attr($text_color);?>" role="tablist" aria-multiselectable="true" id="<?php echo esc_attr($uniqid);?>">
		
		<?php $counter = 0 ;?>
		<?php foreach ($instance['icon_repeater'] as $panel) :?>
				
			<?php
			$counter++; 
			
			$collapse = $panel['collapse'];

			if($collapse == false){
				$active_class = "false";				
				$collapsed_class = "collapsed";
				$in_class = '';				
			} else {
				$active_class = "true";
				$collapsed_class = 'not-collapsed';
				$in_class = 'in';
			} 
			
			$panel_title = $panel['panel_title'];
			$sanitized_title = preg_replace("/[^a-zA-Z0-9]+/", "", $panel_title) . uniqid();	
			
			$panel_id = $sanitized_title.'-panel';
			$the_icon = $panel['the_icon'];
			$panel_content = $panel['panel_content'];
			$panel_content = wpautop($panel_content); 

			
			if($panel['icon_title_color'] == false || $panel['icon_title_color'] == '') {
				$icon_title_color = 'inherit';
			} else {
				$icon_title_color = $panel['icon_title_color'];
			}	
			$icon_styles = array();	
			$icon_styles[] = 'color: '. $icon_title_color;
			?>

		<div class="panel panel-default" style="border-color:<?php echo esc_attr($border_color);?>;<?php echo esc_attr($panel_style);?>">
			<div class="panel-heading" role="tab" id="<?php echo esc_html($sanitized_title);?>">
				<h4 class="panel-title" style="background-color:<?php echo esc_attr($bg_color);?>;">
					<a role="button" data-toggle="collapse" href="#<?php echo esc_html($panel_id);?>" class="<?php echo esc_attr($collapsed_class);?> <?php echo esc_attr($nav_text_color);?> <?php echo esc_attr($hover_color);?>" aria-expanded="<?php echo esc_html($active_class);?>" aria-controls="<?php echo esc_html($sanitized_title);?>" data-parent="#<?php echo esc_attr($uniqid);?>" style="<?php echo esc_attr($border_style);?>">
					<?php if (isset($the_icon) && $the_icon != "") :?>
					  	<span class="icon" style="color: <?php echo esc_attr($icon_title_color);?>">
					  		<?php echo siteorigin_widget_get_icon( $the_icon, $icon_styles); ?></span>
					<?php endif; ?>  	
					  	<?php echo esc_html($panel_title);?>
					</a>
				</h4>

			</div>
			<div class="panel-collapse collapse <?php echo esc_attr($in_class);?>" id="<?php echo esc_html($panel_id)?>" aria-expanded="false" role="tabpanel" aria-labelledby="<?php echo esc_html($sanitized_title);?>">
				<div class="panel-body" style="border-color:<?php echo esc_attr($border_color);?>; background-color:<?php echo esc_attr($bg_color);?>;">
					<?php echo wp_kses_post( $panel_content );?>
				</div>
			</div>
		</div>
		<?php endforeach;?>
	</div>	




