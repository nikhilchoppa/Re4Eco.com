<?php global $orion_options; ?>
<header class="header-slim site-header ">
	<div class="mainheader section <?php orion_get_class_cb('is_header_sticky', 'stickynav', 'noclass');?>"> 
		<div class="container">
			<div class="row"> 
				<div class="site-branding col-lg-2">		
				<?php // Logo
				if (isset($orion_options['logo-upload']['id']) && $orion_options['logo-upload']['id'] != "") : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo bloginfo('name');?>" class="logo">
						<img src="<?php echo esc_url($orion_options['logo-upload']['url']); ?>" alt="<?php echo bloginfo('name');?>" />
					<?php else :?>
						<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span class="h1"><?php echo get_bloginfo('name');?></span></a>
					<?php endif; ?>	
					</a>			
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
							
				<?php // Navigation ?>
				<div class="col-lg-10 nav-container">
					<nav id="primary-navigation" class="site-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu text-left', 'container_class' => 'main-nav-wrap text-right', 'items_wrap' => orion_nav_wrap() ) ); ?>
	                </nav>
				</div>			
			</div>
		</div>
	</div>
</header>