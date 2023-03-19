<div class="entry-title">
<?php if (is_single()) :?>
	<h2 class="post-title"><?php the_title();?></h2>
<?php else :?>
	<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h2>
<?php endif;?>
</div>