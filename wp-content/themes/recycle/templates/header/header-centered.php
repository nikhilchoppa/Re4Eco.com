<?php global $orion_options; ?> 
<header class="header-centered with-top-border site-header">
	<div class="mainheader section <?php orion_get_class_cb('is_header_sticky', 'stickynav', 'noclass');?>"> 
		<div class="container">
			<div class="row"> 
				<div class="site-branding col-lg-12 text-center">		
				<?php // Logo
				if (isset($orion_options['logo-upload']['id']) && $orion_options['logo-upload']['id'] != "") : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo bloginfo('name');?>" class="logo">
						<img src="<?php echo esc_url($orion_options['logo-upload']['url']); ?>" alt="<?php echo bloginfo('name');?>" />
					<?php else :?>
						<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="h1"><?php echo get_bloginfo('name');?></span></a>
					<?php endif; ?>	
					</a>			
				</div> 
			</div>
		</div>	
		<div class="hidden-lg text-center burger-container">
			<div class="to-x">
				<div class="hamburger-box">
					<div class="bun top"></div>
					<div class="meat"></div>
					<div class="bun bottom"></div>
				</div>
			</div>
		</div>
		<div class="container nav-container"> 
			<div class="row">
				<?php // Navigation ?>
				<div class="col-lg-12">
					<nav id="primary-navigation" class="site-navigation" role="navigation">
			 			<?php orion_get_navigation(array('text-center'), array('text-left'));?>		
	                </nav>
				</div>			
			</div>
		</div>
	</div>
</header>


