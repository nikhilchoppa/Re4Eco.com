<?php 
$text_color_class = ''; 
$site_search_bg = orion_get_option('site_search_bg_color', false);
if (isset($site_search_bg)&& $site_search_bg != '' && orion_isColorLight($site_search_bg)) {
$text_color_class = ' text-dark';
}
?>

<div class="site-search<?php echo esc_attr($text_color_class);?>" id="site-search">
	<div class="container">
		<form role="search" method="get" class="site-search-form" action="<?php echo esc_url(home_url( '/' )); ?>">
			<input name="s" type="text" class="site-search-input" placeholder="<?php _e("Search", 'recycle'); ?>">
		</form>
		<span class="search-toggle eleganticons-icon_close"></span>
	</div>
</div>