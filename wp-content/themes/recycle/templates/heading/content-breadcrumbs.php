	<div class="breadcrumbs">
			<ol>
				<?php
					$allowed_html = array(
					    'a' => array(
					        'href' => array(),
					        'title' => array()
					    ),
					    'li' => array(),
					);

					echo '<li><a href="' . esc_url(home_url( '/' )) . '">' . esc_html__('Home', 'recycle') . '</a></li>';

					if( is_category() ) {

						$parents = explode('|', get_category_parents(get_queried_object_id(), true, '|'));
						/* Remove empty item and the current category */
						array_pop($parents);
						array_pop($parents);

						/* Display category parents */
						if( count($parents) > 0 ) {
							foreach ($parents as $parent) {
								echo '<li>' . wp_kses($parent, $allowed_html) . '</li>';
							}
						}
						echo '<li><span>' . single_cat_title('', false) . '</span></li>';
					} else if( is_tax() ) {

						$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) ); 
						if (is_tax('portfolio_category')) {
							$post_type_name = get_option( 'orion_portfolio_category_base_name', 'Project Category' );
							$post_type_url = get_option( 'orion_portfolio_base_slug', 'projects' );
							echo '<li><a href="'. esc_url( home_url( '/' ) ) . $post_type_url .'/">' . $post_type_name . '</a></li>';
						} else if (is_tax('department')) {

							$post_type_name = get_option( 'orion_department_base_name', 'Department' );
							$post_type_url = get_option( 'orion_base_slug', 'team-member' ); 
							
							echo '<li><a href="'. esc_url( home_url( '/' ) ) . $post_type_url .'/">' . $post_type_name . '</a></li>';
						} else if (is_tax('product_cat')) {
							$shop_page_id = get_option( 'woocommerce_shop_page_id');
							$shop_title = get_the_title($shop_page_id);
							$post_type_url = get_permalink($shop_page_id); 
							echo '<li><a href="'. esc_url( $post_type_url) .'">' . $shop_title . '</a></li>';
							
						} else if (is_tax('product_tag')) {
							$shop_page_id = get_option( 'woocommerce_shop_page_id');
							$shop_title = get_the_title($shop_page_id);
							$post_type_url = get_permalink($shop_page_id); 
							echo '<li><a href="'. esc_url( $post_type_url) .'">' . $shop_title . '</a></li>';
						} else {
							echo '<li><span>' . wp_kses($term->taxonomy, $allowed_html) . '</span></li>';
						}
						echo '<li><span>' . wp_kses($term->name, $allowed_html) . '</span></li>';
					} else if( is_search() ) {
						echo '<li><span>' . esc_html__('Search results', 'recycle') . '</span></li>';
					} else if( is_tag() ) {
						echo '<li><span>' . esc_html__('Posts tagged', 'recycle') . ' ' . single_tag_title('', false) . '</span></li>';
					} else if( is_author() ) {
						echo '<li><span>' . esc_html__('Articles posted by', 'recycle') . ' ' . get_the_author() . '</span></li>';
					} else if( is_404() ) {
						echo '<li><span>' . esc_html__('Page not found', 'recycle') . '</span></li>';
                	} else if( function_exists('is_shop') && is_shop() ) {
                    	echo '<li><span>' . get_the_title(get_option( 'woocommerce_shop_page_id' )) . '</span></li>';					
					} else if( is_page() ) {
						$ancestors = array_reverse(get_post_ancestors(get_the_id()));

						foreach( $ancestors as $ancestor ) {
							echo '<li><a href="' . get_the_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
						}

						echo '<li><span>' . get_the_title() . '</span></li>';
					} else if( is_day() ) {
						echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
						echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li>';
						echo '<li><span>' . get_the_time('d') . '</span></li>';
					} else if( is_month() ) {
						echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a></li>';
						echo '<li><span>' . get_the_time('F') . '</span></li>';
					} else if( is_year() ) {
						echo '<li><span>' . get_the_time('Y') . '</span></li>';
					} else if( is_single() ) {
						if (get_post_type() == "orion_portfolio") {

							$post_type_name = get_option( 'orion_portfolio_base_name', 'Projects' );

							echo '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $post_type_name . '</a></li>';
							echo '<li><span>' . get_the_title() . '</span></li>';
						}
						else if (get_post_type() == "team-member") {
							$post_type_name = get_option( 'orion_base_name', 'Team' );
							echo '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . $post_type_name . '</a></li>';
							echo '<li><span>' . get_the_title() . '</span></li>';
						}
						else if (get_post_type() == "product") { 
							$terms = get_the_terms( $post->ID, 'product_cat' );
							if (isset($terms) && !empty($terms) && !empty($terms[0])) {
								$term = $terms[0];
								$term_name = $terms[0]->name; 
								$term_id = $terms[0]->term_id;
								$term_link = get_term_link( $term_id );
								
			                    echo '<li><a href="'. esc_url( $term_link) .'">' . esc_html($term_name) . '</a></li>';
		                    }
		                    echo '<li><span>' . get_the_title() . '</span></li>';
		                } else if (get_post_type() != "orion_portfolio" && get_post_type() != "post" && get_post_type() != "product") { 
		                    $obj = get_post_type_object( get_post_type() );
		                    if( $obj->has_archive ) {
		                        echo '<li><a href="' . get_post_type_archive_link(get_post_type()) . '">' . esc_html($obj->labels->name) . '</a></li>';
		                    }
		                    echo '<li><span>' . get_the_title() . '</span></li>';
		                } else {

		                    $custom_breadcrumbs = get_post_meta( get_the_ID(), $key = 'custom_breadcrumbs', $single = true );
		                    if( $custom_breadcrumbs != ""  && $custom_breadcrumbs != '0' ) { 
		                        echo '<li><a href="' . get_permalink($custom_breadcrumbs).'">' . get_the_title($custom_breadcrumbs) . "</a></li>";
		                    }
		                    echo '<li><span>' . get_the_title() . '</span></li>';
		                }

		            } else if(is_home() && is_front_page()) {

		            } else if(is_post_type_archive('team-member')) {
		            	$post_type_name = get_option( 'orion_base_name', 'Team' );
		            	echo '<li><span>' . $post_type_name . '</span></li>';

 					} else if(is_post_type_archive('orion_portfolio')) {
 						$post_type_name = get_option( 'orion_portfolio_base_name', 'Projects' );
		            	echo '<li><span>' . $post_type_name . '</span></li>';		            	
		            } else if( is_home() && !is_front_page()) {
		            	echo '<li><span>' . get_the_title(get_option('page_for_posts')) . '</span></li>';
					} else {
						echo '<li><span>' . get_the_title() . '</span></li>';
					} 
				?>
			</ol>
		</div>
