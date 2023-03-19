<?php 
//check meta data, if we need to override anything
$allowed_html = array(
     'style' => array(
         'background-image' => array(),
         'padding-top' => array(),
         'padding-bottom' => array(),
    )
);

$heading_style = orion_heading_style();
$orion_heading_classes = orion_heading_classes();
?>

<div class="page-heading section secondary-color-bg heading-left <?php echo esc_attr($orion_heading_classes);?>" <?php echo wp_kses($heading_style, $allowed_html);?>>
	<div class="container">
		<div class="mobile-text-center desktop-left inline-block">
			<h1 class="page-title"><?php orion_page_title(); ?></h1>
			<?php orion_get_breadcrumbs('left'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>