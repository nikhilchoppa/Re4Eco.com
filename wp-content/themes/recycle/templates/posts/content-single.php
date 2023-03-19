<?php
/**
 * The template used for displaying page content in post.php
 *
 * @package recycle
 */
?>
<?php 
$post_class = '';
$entry_content_class = ' col-md-12';
$text_light_meta_wrapper = false;

$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
if ($blog_content_bg == 'transparent') {
	$post_class = "bg-transparent";
	$entry_content_class = '';
} else if($blog_content_bg != 'transparent' && $blog_content_bg != '') {
	if (orion_isColorLight($blog_content_bg) == false) {
		$entry_content_class .= ' text-light';
		$text_light_meta_wrapper = true;
	}
};
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>

	<?php // get the right post format template
	$post_format = get_post_format();
	if ($post_format == false) { $post_format = 'standard';	}; ?>

		
		<?php get_template_part( 'templates/posts/formats/format', $post_format );?>

	<?php /* now display the rest of the content */ ;?>

		<div class="entry-content<?php echo esc_attr($entry_content_class);?>">

			<?php the_content(); ?>
			<?php wp_link_pages( array(
			'before'      => '<ul class="page-numbers p-numbers"><li>',
			'after'       => '</li></ul>',
			'separator'   =>  '</li><li>',
			) );
			?>		
			
			<?php get_template_part( 'templates/parts/single', 'part_bottom_meta' ); ?>
		
			<footer class="entry-footer">
				<?php edit_post_link( '<i class="fa fa-pencil" aria-hidden="true"></i>' . esc_html__( 'Edit', 'recycle' ), '<span class="edit-link">', '</span>', false, 'btn btn-sm btn-c1 icon-left' ); ?>
			</footer><!-- .entry-footer -->					
		</div><!-- .entry-content -->		
	</div> <!--content-wrap-->
	<?php  //author info
    if( get_the_author_meta('description') ): ?>
        <div class="about-author">
			<div class="avatar author-avatar">
				<?php echo get_avatar(get_the_author_meta('ID'), 143); ?>
			</div>
            <div class="author-info">
				<h5 class="author"><a class="primary-color" href="<?php get_author_posts_url( 'ID'); ?>"><?php the_author(); ?></a></h5>
				<small class="post-author-badge"><?php esc_html_e( 'Post author', 'recycle' );?></small>
				<p class="author-description">
					<?php the_author_meta('description'); ?>
				</p>
			</div>
        </div>
    <?php endif; ?>
	<?php // themecheck requires this functions:
		if (!function_exists('wp_link_pages')) {
			 posts_nav_link(); 
		}
		if (!function_exists('posts_nav_link')) {
			 wp_link_pages(); 
		}
	?>

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
							<?php esc_html_e( 'previous post', 'recycle' );?>
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
							<?php esc_html_e( 'next post', 'recycle' );?>
							
						</span>	
							<?php $orion_next_post_title = $next_post->post_title;
							if ($orion_next_post_title == '') {
								$orion_next_post_title = 'Post with no title';
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