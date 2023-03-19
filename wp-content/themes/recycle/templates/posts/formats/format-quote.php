
<?php

$orion_quote = get_post_meta(get_the_ID(), '_recycle_quote');
$orion_quote_author = get_post_meta(get_the_ID(), '_recycle_quote_source_name');
if (!isset($orion_quote) || empty($orion_quote)) : ?> 
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


<?php if ( has_post_thumbnail() ) : ?>
	<?php  
		$thumbnail_id = get_post_thumbnail_id( get_the_ID());
		$bg_img_url = wp_get_attachment_image_src($thumbnail_id, 'orion_container_width');
	?>
	<header class="entry-header text-light overlay-c3 primary-color-bg" style="background-image: url(<?php echo esc_url($bg_img_url[0]);?>)" >
	<?php else : ?>
	<header class="entry-header text-light primary-color-bg" >
	<?php endif; ?>

		<div class="header-quote clearfix">
			<?php if (is_single()) :?>
				<div class="absolute">
					<i class="fa fa-quote-left"></i>
				</div>
			<?php else: ?>
				<a href="<?php the_permalink(); ?>" class="absolute">
					<i class="fa fa-quote-left"></i>
				</a>
			<?php endif; ?>	

			<p class="lead">
				<?php echo esc_html($orion_quote['0']); ?>
			</p>
			<?php if (isset($orion_quote_author) && !empty($orion_quote_author)) : ?>
				<p class="author clearfix text-light">
				<?php echo esc_html($orion_quote_author['0']); ?>
				</p>
			<?php endif; ?>
		</div>		 
	</header> 
	<div class="content-wrap clearfix" <?php echo wp_kses_post($content_wrap_css);?>>
		
		<?php if(is_single()) :?>
		<div <?php echo wp_kses_post($padding_class);?> <?php echo wp_kses_post($content_col_css);?>>
			<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
			<h1 class="entry-title<?php echo esc_attr($entry_title_h1_class);?>"><?php the_title(); ?></h1>
		</div>
		<?php endif;?>		

<?php endif; ?>
