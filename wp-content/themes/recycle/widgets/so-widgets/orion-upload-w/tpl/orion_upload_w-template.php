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
	$btn_classes = 'btn-download icon-right ';
	$btn_color = $instance['btn_color'];
	if ($btn_color) {
		$btn_classes .= $btn_color;
	}
	$btn_type = $instance['btn_type'];
	$btn_classes .= ' ' . $btn_type;

?>
<div class="row button-wrap">
	<?php

	if(!empty($instance['title'])) : ?>
		<div class="col-md-12 entry-header">
			<h2 class="h5 widget-title <?php echo esc_attr($text_color);?>"><?php echo esc_html($instance['title']);?></h2>
		</div>
	<?php endif; ?>

	<?php foreach ($instance['widget_repeater'] as $download_btn) :?>

		<?php // set variables:

		$document_upload = $download_btn['document_upload'];
		$document_upload_url = wp_get_attachment_url($document_upload);
		$document_icon = $download_btn['document_icon'];
		$icon_styles = array();	
		$document_name = $download_btn['document_name'];
		$download_attr = basename(get_attached_file($document_upload ));
		?>
		<div class="<?php echo esc_attr($column_class);?>">		
			<a class="<?php echo esc_attr($btn_classes);?>" href="<?php echo esc_url($document_upload_url);?>" download="<?php echo esc_attr($download_attr);?>">
					<?php echo esc_html($document_name);?>
					<?php 
					if ($document_icon != '') : ?>
						<?php echo siteorigin_widget_get_icon( $document_icon, $icon_styles); ?>	
					<?php else : ?>
						<span class="sow-icon-eleganticons" data-sow-icon="&#xE004;"></span>
					<?php endif;?>
					<span class="sow-icon-eleganticons btn-visited" data-sow-icon="N"></span>
			</a>
		</div>
	<?php endforeach;?>

</div>