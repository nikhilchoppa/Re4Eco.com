<?php  

orion_set_progress_bars();
//prepare variables
	$title_color = $instance['style_section']['title_color'];
	$progress_size = $instance['style_section']['progress_size'];
	$progress_percantage_position = $instance['style_section']['progress_percantage_position'];
?>

<?php foreach ($instance['progress_repeater'] as $progress_bar) : ?>

	<?php // variables:
	$title = '';
	$title = $progress_bar['title'];
	$progress_number = $progress_bar['progress_number'];
	$progress_number = intval($progress_number);
	$progress_color = $progress_bar['progress_color'];
	$progress_style = $progress_bar['progress_style'];

	switch ($progress_style) {
		case 'simple' :
			$style_class = "";
			break;

		case 'stripes' :
			$style_class = " progress-bar-striped";
			break;
		case 'animated' :
			$style_class = " progress-bar-striped active";
			break;
		default :
			$style_class = "";			
			break;
	}

	$progress_html_class = $style_class . ' ' .$progress_color;
	?>

	<div class="orion-progress-bar-wrap">
		<div class="lead clearfix <?php echo esc_attr($title_color);?>"><?php echo esc_html($title);?>
			<?php if($progress_percantage_position == 'in-title'):?>
				<span class="pull-right"><?php echo esc_html($progress_number);?>%</span>
			<?php endif;?>
		</div>
		<div class="progress <?php echo esc_attr($progress_size);?>">
		  <div class="progress-bar <?php echo esc_attr($progress_html_class);?>" role="progressbar"
		  aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0" data-percentage="<?php echo esc_html($progress_number);?>">
		  	<?php if($progress_percantage_position == 'in-progress'):?>
		    	<?php echo esc_html($progress_number);?>%
			<?php endif;?>
		  </div>
		</div>
	</div>
<?php endforeach;?>

	<script type="text/javascript">

	</script> 