<?php
$recycle_meta = orion_post_meta_array();
?>

<div class="entry-meta font-3 small text-light">
	<?php if ($recycle_meta[1] == '1') : ?>
		<span class="time text-bold">
			<?php the_time(get_option('date_format'),'','', FALSE) ?>
		</span>
	<?php endif;?>

	<?php if ($recycle_meta[2] == '1') : ?>
		<span class="author vcard"><?php _e( 'by ', 'recycle' );?><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
		</span>	
	<?php endif;?>

	<?php if ($recycle_meta[3] == '1') : ?>
	<span class="category">in <?php the_category(',&nbsp;'); ?></span>
	<?php endif;?>

	<?php if ($recycle_meta[4] == '1') {
		$num_comments = get_comments_number( get_the_ID() );  
		$write_comments = "";
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$write_comments = '';
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments . esc_html__(' Comments', 'recycle' );
				$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
			} else {
				$comments = esc_html__('1 Comment', 'recycle' );
				$write_comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
			}
		} 
		
		echo wp_kses($write_comments, array(
			'span' => array(),
			'a' => array(
		        'href' => array()
		    )
		));	
	}?>
</div>	
