<?php

	//prepare variables
	$style = $instance['widget_style']['style'];
	$active_color = $instance['widget_style']['active_color'];
	$navigation_color = $instance['widget_style']['navigation_color'];
	$content_color = 'text-dark';
	$border_color = $instance['widget_style']['border_color'];
	if ($border_color == '') {
		$border_color = 'transparent';
	}
	$content_bg_color = '#fff';
	$style_nav_class = 'col-sm-12';
	$style_content_class = 'col-sm-12';
	$nav_tabs_class = 'nav-tabs';
	$uniqid = uniqid();
	//set style
	if($style != 'tabs-top') {
		$style_nav_class = 'col-sm-3';
		$style_content_class = 'col-sm-9';
		$nav_tabs_class = 'nav-stacked';

		if($style == 'tabs-right') {
			$style_nav_class .= ' col-sm-push-9';
			$style_content_class .= ' col-sm-pull-3';
		}
	}
?>

<div class="row tabs-wrap <?php echo esc_attr($style);?> <?php echo esc_attr($active_color);?> ">
	<?php

	if(!empty($instance['title'])) : ?>
		<div class="col-sm-12 entry-header">
			<h2 class="h5 widget-title"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>	

	<ul class="nav <?php echo esc_attr($nav_tabs_class);?> <?php echo esc_attr($style_nav_class);?>" role="tablist">
		<?php $counter = 0 ;?>
		<?php foreach ($instance['tab_repeater'] as $tabtitle) :?>
				
			<?php
			$counter++; 
			$active_class = "";
			if ($counter == 1) {
				$active_class = "active";
			}
			$tab_title = $tabtitle['tab_title'];
			$tab_bg_color = $tabtitle['tab_bg_color'];
			if ($tab_bg_color == '') {
				$tab_bg_color = 'rgba(255,255,255,0.7)';
			}
			$uniqe_HTML_id = preg_replace("/[^a-zA-Z0-9]+/", "", $tab_title) . $counter . $uniqid;
			$the_icon = $tabtitle['the_icon'];
			
			$icon_styles = array();	
			
			?>
		    <li role="presentation" class="<?php echo esc_attr($active_class);?>" style="background-color:<?php echo esc_attr($tab_bg_color);?>"><a class="<?php echo esc_attr($navigation_color);?>" style="border-color:<?php echo esc_attr($border_color);?>" href="#<?php echo esc_html($uniqe_HTML_id);?>" aria-controls="<?php echo esc_html($uniqe_HTML_id);?>" role="tab" data-toggle="tab" >
		    	<?php if(isset($the_icon) && $the_icon != "") : ?>
		    	<span class="icon"><?php echo siteorigin_widget_get_icon( $the_icon, $icon_styles); ?></span>
				<?php endif;?>
				<?php echo esc_html($tab_title);?>
		    </a></li>

		<?php endforeach;?>
	</ul>	

    <div class="tab-content <?php echo esc_attr($style_content_class);?>">
    	<?php $counter = 0;?>
    	<?php foreach ($instance['tab_repeater'] as $tabcontent) :?>

    		<?php 
    		$layoutdata = false;
    		$counter++;
    		$active_class = '';
			if ($counter == 1) {
				$active_class = "active";
			} else {
				$active_class = "";
			}
			$tab_title = $tabcontent['tab_title'];
			$uniqe_HTML_id = preg_replace("/[^a-zA-Z0-9]+/", "", $tab_title) . $counter .$uniqid;
			if(isset($tabcontent['layoutbuilder']) && !empty($tabcontent['layoutbuilder']['widgets']) ) {
				$layoutdata = true;
			} else {
    			$tab_content = $tabcontent['tab_content'];
    			$tab_content = wpautop($tab_content); 
    		}
			?>
	        <div class="tab-pane clearfix <?php echo esc_attr($active_class);?> <?php echo esc_attr($content_color);?>" role="tabpanel" id="<?php echo esc_html($uniqe_HTML_id);?>" style="border-color:<?php echo esc_attr($border_color);?>; background-color:<?php echo esc_attr($content_bg_color);?>;" >
	            <?php 
	            if($layoutdata == true) {
	            	orion_process_pagebuilder_content($tabcontent['layoutbuilder']);
	            } else {
	            	echo wp_kses_post($tab_content);
	            }?>
	        </div>

		<?php endforeach;?>        
    </div>	

</div>