
<?php

$orion_status = get_post_meta(get_the_ID(), '_recycle_status');
if (!isset($orion_status) || empty($orion_status)) : ?> 
	<?php get_template_part( 'templates/posts/formats/format', 'standard' );?> 
<?php else : ?> 

	<?php
	$content_wrap_class = 'col-md-12';
	$header_class = '';
	$content_wrap_css = '';
	$header_css = '';
	$content_col_css = '';
	// $padding_class = "class='col-md-12'";
	$wrap_class = 'col-md-12';
	$entry_title_h1_class = "";
	$content_wrap_css = '';

	$blog_content_bg = orion_get_option('blog_content_bg', false, "#ffffff");
	if ($blog_content_bg == 'transparent') {
		$content_wrap_class = ' bg-transparent';
		$content_wrap_css = "style='background-color: transparent;'";
		$content_col_css = "style='padding-left:0; padding-right:0;'";
		// $padding_class = '';
		$header_css = "style='padding-left:0; padding-right:0; padding-top:0; background-color: transparent;'";
		$wrap_class = '';
	} else if ($blog_content_bg != '') {
		$header_css = "style='background-color:".$blog_content_bg.";'";
		$content_wrap_css = "style='background-color:".$blog_content_bg.";'";
		if (orion_isColorLight($blog_content_bg) == false) {
			$entry_title_h1_class = " text-light";
			$header_class .= " text-light";
			$wrap_class .= " text-light";
		}
	};
	?>

	<div class="header-status clearfix<?php echo esc_attr($header_class);?>" <?php echo wp_kses_post($header_css);?>>		
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="<?php echo esc_attr($wrap_class);?>" <?php echo wp_kses_post($content_col_css);?>>
			<div class="status-content-wrap">
				<div class="image pull-left">
					<?php if(!is_single()) :?>
						<a href="<?php the_permalink(); ?>">
						<?php the_post_thumbnail('orion_square' );?>
						</a>
					<?php else :?>
						<?php the_post_thumbnail('orion_square' );?>
					<?php endif;?>
				</div>
			
				<div class="status-content lead">
					<?php echo esc_html($orion_status['0']); ?>
				</div>
				<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
			</div>
		</div>	
	<?php else : ?>
		<div class="<?php echo esc_attr($wrap_class);?>" <?php echo wp_kses_post($content_col_css);?>>
			<div class="image">
				<?php if(!is_single()) :?>
					<a href="<?php the_permalink(); ?>">
					<i class="fa fa-commenting primary-color-bg text-light"></i>
					</a>
				<?php else : ?>
					<i class="fa fa-commenting primary-color-bg text-light"></i>
				<?php endif;?>
			</div>
			<div class="status-content-wrap <?php echo esc_attr($wrap_class);?>">
				<div class="status-content lead">
					<?php echo esc_html($orion_status['0']); ?>
				</div>
				<?php get_template_part( 'templates/parts/single', 'part_meta' ); ?>
			</div>
		</div>			
	<?php endif;?>	
	</div>
	
	<div class="content-wrap clearfix <?php echo esc_attr($content_wrap_class);?>" <?php echo wp_kses_post($content_wrap_css);?>>
		<div class="<?php echo esc_attr($wrap_class);?>" <?php echo wp_kses_post($content_col_css);?>>
		<?php if(is_single()) :?>
			<h1 class="entry-title<?php echo esc_attr($entry_title_h1_class);?>"><?php the_title(); ?></h1>
		<?php endif;?>
		</div>
<?php endif; ?>