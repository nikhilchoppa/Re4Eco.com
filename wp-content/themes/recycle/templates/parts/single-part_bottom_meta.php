<?php

$orion_options = get_option('recycle');
if(empty($orion_options)) {
	$orion_options = orion_get_orion_defaults();
}	
$permalink = get_permalink(); 

$html_row_class = 'bottom-meta';
$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg != '' && $blog_content_bg != 'transparent') {
	if (orion_isColorLight($blog_content_bg) == false) {
		$html_row_class .= " text-light";
	}
};

?>
<div class="row <?php echo esc_attr($html_row_class);?>">
<div class="col-md-8">
 
		<?php if (has_tag()) : ?>
			<span class="meta text-block">
				<?php echo esc_html__('Tags', 'recycle');?>
			</span>			
		<div class="tagcloud">

			
			<?php echo get_the_tag_list('', ' ', ''); ?>
		</div>
		<?php endif; ?>
</div>


<?php if (isset($orion_options['share-icons'])) : ?> 

	<?php $share_icons_array = $orion_options['share-icons'];
	$icon_fb = '<li><a class="btn btn-sm btn-c1 icon btn-empty" href="https://www.facebook.com/sharer/sharer.php?u=' . esc_url($permalink) . '&amp;t=' . str_replace(' ', '%20', get_the_title()) . '" title="' . esc_html__( "Share on Facebook", "recycle" ) . '" target="_blank"><i class="fa fa-facebook"></i></a></li>';
	$icon_tw = '<li><a class="btn btn-sm btn-c1 icon btn-empty" href="https://twitter.com/intent/tweet?source=' . esc_url($permalink) . '&amp;text=' . str_replace(' ', '%20', get_the_title()) . ':'. esc_url($permalink) . '" target="_blank" title="' . esc_html__( "Tweet", "recycle" ) . '"><i class="fa fa-twitter"></i></a></li>';
	$icon_google = '<li><a class="btn btn-sm btn-c1 icon btn-empty" href="https://plus.google.com/share?url=' . esc_url($permalink) . '" target="_blank" title="' . esc_html__( "Share on Google+", "recycle" ) . '"><i class="fa fa-google-plus"></i></a></li>';

	$enabled_icons = array();
	foreach ($share_icons_array as $icon => $value) {
		if($value == "1") {
			array_push($enabled_icons, $icon);
		}
	}

	if (!$enabled_icons =="") : ?>
		<div class="col-md-4 text-right">
			<span class="meta clearfix text-block">
				<?php echo esc_html__('Share', 'recycle');?>
			</span>
			<ul class="share-links">
				<?php foreach($enabled_icons as $icon) {
					switch($icon) {
					case "facebook": 
						echo wp_kses_post($icon_fb); 
						break;
					case "twitter": 
						echo wp_kses_post($icon_tw); 
						break;
					case "google": 
						echo wp_kses_post($icon_google); 
						break;
					}
				} ?>
			</ul>
		</div>	
	<?php endif; ?>
<?php endif;?>
</div>
