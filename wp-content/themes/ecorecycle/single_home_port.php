<?php    $root = dirname(dirname(dirname(dirname(__FILE__))));    require_once($root.'/wp-load.php');	global $wpdb;	$pc = new WP_Query(array('p' => $_POST['id'] ,'post_type'=>$_POST['type'])); 		?><script type="text/javascript">jQuery(document).ready(function(){	    jQuery('#sliderHome').anythingSlider({		hashTags : false,		expand		: true,		autoPlay	: true,		resizeContents  : false,		pauseOnHover    : true,		buildArrows     : false,		buildNavigation : false,		delay		: 5000,		resumeDelay	: 0,		animationTime	: 500,		delayBeforeAnimate:0,			easing : 'easeInOutQuint',		onSlideBegin    : function(e, slider) {				jQuery('.nextbutton').fadeOut();				jQuery('.prevbutton').fadeOut();				},		onSlideComplete    : function(slider) {			jQuery('.nextbutton').fadeIn();			jQuery('.prevbutton').fadeIn();				}			    })	    	    jQuery('.blogsingleimage').hover(function() {		jQuery(".slideforward").stop(true, true).fadeIn();		jQuery(".slidebackward").stop(true, true).fadeIn();	    }, function() {		jQuery(".slideforward").fadeOut();		jQuery(".slidebackward").fadeOut();	    });	    jQuery(".slideforward").click(function(){		jQuery('#sliderHome').data('AnythingSlider').goForward();	    });	    jQuery(".slidebackward").click(function(){		jQuery('#sliderHome').data('AnythingSlider').goBack();	    });  	});	</script>		<div class="mainwrap">	<div class="main clearfix portsingle home">		<?php if ($pc -> have_posts()) : while ($pc ->have_posts()) : $pc ->the_post(); ?>	<?php  $portfolio = get_post_custom($post->ID); ?>	<div class="content fullwidth">		<div class="blogpost postcontent port" >			<div class="projectdetails">							<div class="blogsingleimage">							<?php 												if(isset($portfolio['show_video'][0]) && $portfolio['show_video'][0]){																			echo wp_oembed_get(esc_url($portfolio['video'][0]));							} else { 							$args = array(								'post_type' => 'attachment',								'numberposts' => null,								'post_status' => null,								'post_parent' => $post->ID,								'orderby' => 'menu_order ID',							);							$attachments = get_posts($args);							if ($attachments) {?>								<div id="sliderHome" class="slider">										<?php											$i = 0;											foreach ($attachments as $attachment) {												//echo apply_filters('the_title', $attachment->post_title);												$image =  wp_get_attachment_image_src( $attachment->ID, 'sinbgleport' ); ?>														<div>														<img class="check" src="<?php echo esc_url($image[0]) ?>" />																																	</div>																										<?php 													$i++;													} ?>																								</div>								<?php if($i > 1){ ?>								<div class="prevbutton slidebackward port"><i class="fa fa-angle-left"></i></div>								<div class="nextbutton slideforward port"><i class="fa fa-angle-right"></i></div>								<?php } ?>							  <?php } else { ?>								<a href="<?php echo esc_url($image) ?>" rel="lightbox[port]" title="<?php the_title(); ?>"><?php echo pmc_getImage(get_the_id(),'sinbgleport'); ?></a>							  <?php } 							} ?>						</div>												<div class="bottomborder"></div>			</div>			<div class="projectdescription">				<div class="datecomment">					<p>						<div class = "project-section">							<?php if($portfolio['customer'][0] !='') {?>								<i class="fa fa-user"></i><?php _e('Client','ecorecycle'); ?> <span class="author port"><?php echo esc_attr($portfolio['customer'][0]) ?></span><br>							<?php } ?>						</div>												<div class = "project-section">							<?php if($portfolio['date'][0] !='') {?>								<i class="fa fa-calendar"></i><?php _e('Date of completion','ecorecycle');  ?> <span class="posted-date port"><?php echo esc_attr($portfolio['date'][0]) ?></span><br>							<?php } ?>						</div>												<div class = "project-section">							<?php if($portfolio['author'][0] !='') {?>								<i class="fa fa-user"></i><?php _e('Project designer','ecorecycle');  ?> <span class="authorp port"><?php echo esc_attr($portfolio['author'][0]) ?></span><br>							<?php } ?>						</div>												<div class="single-portfolio-skils">							<?php							if(isset($portfolio['skils'][0])){							echo '<ul>';							foreach(explode("\n", $portfolio['skils'][0]) as $line) {								echo '<li><i class="fa fa-check-square"></i>'.$line.'</li>';							} 							echo '</ul>';							}?>						</div>						<div class = "project-section last">							<span class="link"><a href="<?php the_permalink(); ?>" title="project url"> <?php _e('VIEW THE PROJECT','ecorecycle');  ?></a></span> 						</div>														</p>										</div>												</div>					</div>					</div>								<?php endwhile; endif; ?>		</div></div>	<script type="text/javascript" charset="utf-8"> jQuery(document).ready(function(){    jQuery("a[rel^='lightbox']").prettyPhoto({theme:'light_rounded',overlay_gallery: false,show_title: false});  });</script>