
<?php
$orion_link_title = get_post_meta(get_the_ID(), '_recycle_link_title');
$orion_link_url = get_post_meta(get_the_ID(), '_recycle_url');
$orion_link_desc = get_post_meta(get_the_ID(), '_recycle_link_desc');


if (!isset($orion_link_url) || empty($orion_link_url)) : ?> 
	<?php get_template_part( 'templates/posts/formats/format', 'standard' );?> 
<?php  else : ?> 


<?php
$content_wrap_css = '';
$content_col_css = '';
$padding_class = "class='col-md-12'";
$entry_title_h1_class = "";

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent') {
	$content_wrap_css = "style='padding-left:0; padding-right:0; background-color: transparent;'";
	$content_col_css = "style='padding-left:0; padding-right:0;'";
	$padding_class = '';
} else if ($blog_content_bg != '') {
	$content_wrap_css = "style='background-color:".$blog_content_bg.";'";
	if (orion_isColorLight($blog_content_bg) == false) {
		$entry_title_h1_class = " text-light";
	}
};
?>

	<?php
	$orion_link_url['0'] = orion_addhttp($orion_link_url['0']);

	if(empty($orion_link_title)) {
		$orion_link_title = $orion_link_url;
	}?>
	<?php if ( has_post_thumbnail() ) : ?>
		<?php  
			$thumbnail_id = get_post_thumbnail_id( get_the_ID());
			$bg_img_url = wp_get_attachment_image_src($thumbnail_id, 'orion_container_width');
		?>
		<header class="entry-header overlay-c1 primary-color-bg" style="background-image: url(<?php echo esc_url($bg_img_url[0]);?>)" >
	<?php else : ?>
		<header class="entry-header primary-color-bg" >
	
	<?php endif; ?>

			<div class="header-link clearfix text-light">
				<?php if (is_single()) : ?>
					<div class="absolute">
						<i class="fa fa-link"></i>
					</div>
				<?php else: ?>
					<a href="<?php the_permalink(); ?>" class="absolute">
						<i class="fa fa-link "></i>
					</a>
				<?php endif; ?>
				<?php if(is_single()) :?>
					<h2 class="text-light link">
				<?php else : ?> 
					<?php 
					if (!isset($blog_type)) {
						$blog_type = orion_get_blog_type();
					}
					if (strpos($blog_type, 'grid') !== false || strpos($blog_type, 'masonry') !== false) : ?>
						<h2 class="h3 text-light link">
					<?php else :?>
						<h2 class="text-light link">
					<?php endif;?>
				<?php endif;?>
					<a target="_blank" href="<?php echo esc_url($orion_link_url['0']);?>"><?php echo esc_html($orion_link_title['0']); ?></a>
				</h2>
				<?php if (isset($orion_link_desc['0']) && !empty($orion_link_desc['0'])) : ?>
					<p class="link-desc clearfix text-light lead block">
						<?php echo esc_html($orion_link_desc['0']); ?>
					</p>
				<?php endif; ?>

				<?php get_template_part( 'templates/parts/single', 'part_meta_light' ); ?>
			</div>
		</header>
	<div class="content-wrap clearfix" <?php echo wp_kses_post($content_wrap_css);?>>
		<?php if (is_single()) :?>
		<div <?php echo wp_kses_post($padding_class);?> <?php echo wp_kses_post($content_col_css);?>>
			<h1 class="entry-title<?php echo esc_attr($entry_title_h1_class);?>"><?php the_title(); ?></h1>
		</div>
		<?php endif;?>
<?php endif; ?>
