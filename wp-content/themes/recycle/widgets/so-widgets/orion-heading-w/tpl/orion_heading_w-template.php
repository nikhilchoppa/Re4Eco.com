<?php  //prepare variables
	$heading = $instance['title'];
	$case = $instance['case'];
	$headingsize = $instance['size'];
	$text_color = $instance['text_color'];
	$separator_style = $instance['separator_style'];
	$text_align = $instance['text_align'];
	$heading_margin = $instance['heading_margin'];
	if ($heading_margin == '') {
		$heading_margin = 0;
	}
	$heading_margin = intval($heading_margin);
	$heading_margin .= 'px;'
?>

<?php if(!empty($instance['title'])) : ?>
	<?php 
	$html_classes = ' '. $separator_style . ' ' . $text_align . ' style-' . $headingsize . ' style-' . $text_color;

	$kses_array = array(
	    'span' => array(
	        'style' => array(),
	        'strong' => array(),
	        'class' => array(),
	        'id' => array(),
	        'em' => array(),
	    ),
	    'strong' => array(),
	    'em' => array(),
	);?>

	<?php $heading_class = $text_color;
		if ($case == true) {
			$heading_class .= ' text-uppercase';
		}
	?>
	
	<div class="row orion-heading" style="margin-bottom:<?php echo esc_attr($heading_margin);?>">
		<div class="col-md-12 <?php echo esc_attr($html_classes);?>">
			<<?php echo esc_attr($headingsize);?> class="<?php echo esc_attr($heading_class);?>">
				<?php echo wp_kses($heading, $kses_array);?>
			</<?php echo esc_attr($headingsize);?>>
		</div>
	</div>

<?php endif; ?>	