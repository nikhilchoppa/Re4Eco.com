<?php
/**
 * The template used for displaying page content in single-orion_portfolio.php
 *
 * @package recycle
 */
?>
<?php 
$orion_options = get_option('recycle');
if(empty($orion_options)) {
	$orion_options = orion_get_orion_defaults();
}	
$permalink = get_permalink(); 
?>
<?php 

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent') {
	$post_class = "bg-transparent";
	$entry_content_class = 'text-dark clearfix';

} else if($blog_content_bg != 'transparent' && $blog_content_bg != '') {
	if (orion_isColorLight($blog_content_bg) == false) {
		$entry_content_class = 'col-md-12 clearfix text-light';
		
	} else {
		$entry_content_class = 'col-md-12 clearfix text-dark';
	}

};
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php $post_format = get_post_format();
	if ($post_format == false) { $post_format = 'standard';	}; ?>

	<?php get_template_part( 'templates/posts/formats/format', $post_format );?>

		<div class="entry-content <?php echo esc_attr($entry_content_class);?>">
			<?php the_content(); ?>
			<?php wp_link_pages( array(
			'before'      => '<ul class="page-numbers p-numbers"><li>',
			'after'       => '</li></ul>',
			'separator'   =>  '</li><li>',
			) );
			?>
			<div class="row bottom-meta">
				<div class="col-md-8">
					<span class="meta clearfix text-block">
					<?php $project_categories = get_option( 'orion_portfolio_category_base_name', 'Categories' );
						echo esc_html($project_categories);
					?>
					</span>			
					<div class="tagcloud">
						<?php echo get_the_term_list(get_the_ID(),'portfolio_category');?>
					</div>
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
			</div> <!-- bottom-meta -->
			<footer class="entry-footer">
				<?php edit_post_link( '<i class="fa fa-pencil" aria-hidden="true"></i>' . esc_html__( 'Edit', 'recycle' ), '<span class="edit-link">', '</span>', false, 'btn btn-sm btn-c1 icon-left' ); ?>
			</footer><!-- .entry-footer -->			
		</div><!-- .entry-content -->
	</div> <!--content-wrap-->	
	
	<?php // get_template_part( 'templates/parts/single', 'part_bottom_meta' ); ?>
	
	<section class="row">
		<div class="post-navigation col-md-12">

			<?php //advanced previous and next post navigation	
			$prev_post = get_previous_post();
			$next_post = get_next_post();
			
			$pull_right = "";
			if ($prev_post=="" && $next_post!="") {
				$pull_right = "pull-right";
			} else if($prev_post!="" && $next_post==""){
				$pull_right = "pull-left";
			}?>

			<?php if (empty( $prev_post ) &&  empty( $next_post ) ):?>
			<p></p>
			<?php else : ?>
			<div class="wrapper <?php echo esc_attr($pull_right);?> clearfix orion-equal-height">
				
				<?php if (!empty( $prev_post )): ?>
					<?php
						$prev_thumbnail_id = get_post_thumbnail_id( $prev_post->ID );
						$prev_thumbnail_src = wp_get_attachment_image_src($prev_thumbnail_id, 'large');
					?>
					<div class="text-left prev-post <?php if ($prev_thumbnail_id != "") :?>bg-img<?php endif;?> "
						<?php if ($prev_thumbnail_id != "") :?> 
							style='background-image:url("<?php echo esc_url($prev_thumbnail_src[0]);?>");'
						<?php endif;?>>
					
						<a class="equal-height-item" href="<?php echo esc_url(get_permalink($prev_post->ID));?>">	
						<span class="text-uppercase primary-color small" >
							<?php echo esc_html__( 'Previous Project', 'recycle' );?>
						</span>	
							<?php $orion_prev_post_title = $prev_post->post_title;
							if ($orion_prev_post_title == '') {
								$orion_prev_post_title = 'Post with no title';
							}?>
							<h6><?php echo esc_html($orion_prev_post_title); ?></h6>
						</a>
					</div>
				<?php endif;?>

				<?php if (!empty( $next_post )): ?>
					<?php 
						$next_thumbnail_id = get_post_thumbnail_id( $next_post->ID );
						$next_thumbnail_src = wp_get_attachment_image_src($next_thumbnail_id, 'large'); 
					?>
					 <div class="text-right next-post <?php if ($next_thumbnail_id != "") :?>bg-img<?php endif;?>"
							<?php if ($next_thumbnail_id != "") :?> 
								style='background-image:url("<?php echo esc_url($next_thumbnail_src[0]);?>");'
							<?php endif;?>>

						<a class="equal-height-item" href="<?php echo esc_url(get_permalink($next_post->ID));?>">	
						<span class="text-uppercase primary-color small" >
							<?php echo esc_html__( 'Next Project', 'recycle' );?>
							
						</span>	
							<?php $orion_next_post_title = $next_post->post_title;
							if ($orion_next_post_title == '') {
								$orion_next_post_title = 'Porfolio without title';
							}?>
							<h6><?php echo esc_html($orion_next_post_title); ?></h6>						
						</a>
					</div>
				<?php endif;?>
	    	</div> 
	    	<?php endif;?> 
	    </div>  
	</section>		
</article><!-- #post-## -->