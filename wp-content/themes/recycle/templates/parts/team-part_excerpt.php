
<?php $post_id = get_the_ID(); ?>
				
<header class="entry-header team-header top_align<?php if (is_single()) : ?> row <?php endif;?>">
		

		<?php if (is_single()) : ?>
		<div class="col-sm-4">
		<?php else : ?>
		<div class="col-sm-3">
		<?php endif; ?>

			<?php $img = get_the_post_thumbnail($post_id, 'size-orion_tablet');?>
			<?php if ($img != "") : ?>

				<?php if (!is_single()) : ?>
					<a href="<?php echo get_permalink($post_id);?>" class="image-wrap">
				<?php endif;?>	

					<?php echo wp_kses_post($img);?>

				<?php if (!is_single()) : ?>
					</a>
				<?php endif;?>

			<?php else :?>

				<?php if (!is_single()) : ?>
					<a href="<?php echo get_permalink($post_id);?>" class="image-wrap no-image orion_square">
				<?php else:?>
					<span class="image-wrap no-image orion_square">
				<?php endif;?>

				<span class="sow-icon-eleganticons" data-sow-icon="&#xe08b;"></span>
				
				<?php if (!is_single()) : ?>
					</a>
				<?php else:?>
					</span>
				<?php endif;?>

			<?php endif;?>		
		</div>
		<?php if (is_single()) : ?>
		<div class="col-sm-8">
		<?php else : ?>
		<div class="col-sm-9">
		<?php endif; ?>
			<div class="team-title clearfix row">
				<div class="title-wrap text-left style-text-dark col-md-12">
				
					<?php if (is_single()) : ?>
						<h1 class="entry-title h1"><?php the_title(); ?></h1>
					<?php else : ?>
						<h2 class="entry-title h2"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_title(); ?></a></h2>
					<?php endif; ?>					
				</div>				
			</div>
	
			<?php $job_title = get_post_meta( $post->ID, 'job_title');
				if (isset($job_title[0])) : ?>
				<div class="job-title h6">
					<?php echo wp_kses_post($job_title[0]);?>
				</div>
				<?php endif; ?>	

			<?php $additional_info = get_post_meta( $post->ID, 'short_about');
			if (isset($additional_info[0])) : ?>
			<div class="additional-info">
				<?php if (is_single()) : ?>
					<div class="lead">
						<?php echo wpautop(wp_kses_post($additional_info[0]), true);?>
					</div>
				<?php else : ?>
					<?php echo wpautop(wp_kses_post($additional_info[0]), true);?>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			<hr>
			<div class="row">
				<div class="col-xs-4">
					<?php if (get_the_term_list( $post->ID, 'department') != "" ) : ?>
						<?php $department_name = get_option( 'orion_department_base_name', 'Department' );

						echo $department_name.':';?>
						<?php echo get_the_term_list( $post->ID, 'department', '<ul class="departments clearfix"><li>', ', </li><li>', '</li></ul>' ); ?>
		   			<?php endif; ?>	
	   			</div>

	   			<div class="col-xs-8">
			 		<?php if (get_post_meta(get_the_ID(), 'member_social_icons') != "") : ?>
				 		<?php $social_links = get_post_meta(get_the_ID(), 'member_social_icons');?>
				 		<?php if (isset($social_links[0])) :?>
							<ul class="social-links clearfix pull-right">
							 	<?php foreach ($social_links[0] as $key => $value) : ?>
							 		<?php if (isset($value['social_icons']) && isset($value['social_links']) ) :?>
							 			<?php
							 			if ($value['social_icons'] == 'fa-envelope-o') : ?>
								 		 <li> 
								 		 	<a class='btn icon btn-sm btn-round' href="mailto:<?php echo esc_html(orion_removehttp(($value['social_links'])));?>">
								 		 		<i class="fa <?php echo esc_attr($value['social_icons']);?>"></i>
								 		 	</a>
								 		 </li>
								 		<?php else : ?>
								 		 <li> 
								 		 	<a class='btn icon btn-sm btn-round' href="<?php echo esc_url(orion_addhttp($value['social_links']));?>">
								 		 		<i class="fa <?php echo esc_attr($value['social_icons']);?>"></i>
								 		 	</a>
								 		 </li>
								 		<?php endif;?>
									<?php endif;?>							 		
							 	<?php endforeach;?>
						 	</ul>
					 	<?php endif;?>
					<?php endif;?>
				</div>
			</div>  					
		</div>		
	</header> 