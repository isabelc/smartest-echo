	<?php
	$cartransspeed = 7;
	$caranimspeed = 600;
	if(get_option('smartestb_carousel_trans_speed')) {$cartransspeed = get_option('smartestb_carousel_trans_speed');}
	if(get_option('smartestb_carousel_anim_speed')) {$caranimspeed = get_option('smartestb_carousel_anim_speed');}
	?>			
			
		<!-- Hook up the FlexSlider -->
		<script type="text/javascript">
			jQuery(window).load(function() {
				jQuery('#productslider').flexslider({
				animation: "slide",
				slideshowSpeed: <?php echo $cartransspeed;?>000, //Integer: Set the speed of the slideshow cycling, in milliseconds
				animationDuration: <?php echo $caranimspeed;?>, 
				controlNav: false,
				controlsContainer: ".flexslider-container"
				});
			/* jQuery('#mainslider').flexslider({
				slideshow: true,
				slideshowSpeed: 4000,
				animationDuration: 500,
				directionNav: false,
				pauseOnAction: true,    
				pauseOnHover: false
				});*/
			});
		</script>
		
	<h2 style="text-align:center;">Latest Products</h2>
	
					<div class="flexslider-container" id="productslidercontainer">
						<div id="productslider" class="flexslider">
						
						    <ul class="slides">
						    	<?php
						  		$carimgwidth = 200;
								$carouselheight = 200;
								if(get_option('smartestb_carousel_height')) {$carouselheight = get_option('smartestb_carousel_height');}
								$cat_name = get_option('smartestb_carousel_prod_category');
						 		?>
	<style>
	#productslidercontainer {min-height:<?php echo $carouselheight;?>px;}
	</style>  
	
	<?php if ($cat_name == "Show All Products") {$prodcat = "";}else{$prodcat = $cat_name;} ?>
	<?php 
	$wp_query = new WP_Query('product_cat='.$prodcat.'&post_type=product');
	$number = $wp_query->found_posts;
	?>
		  		
						  		<li>
						  		<?php $loop = new WP_Query('product_cat='.$prodcat.'&post_type=product&posts_per_page=4');while ( $loop->have_posts() ) : $loop->the_post();?>
						  		
						  		<?php
						  		if(has_post_thumbnail()) {
							  		   $thumb = get_post_thumbnail_id(); 
									   $image = vt_resize( $thumb, '', $carimgwidth, $carouselheight, true );
									 ?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $image['url']; ?>" />
							    	 </a>
						    	 <?php } else {?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $woocommerce->plugin_url() ?>/assets/images/placeholder.png" />
							    	 </a>
						    	 <?php }?>
						    		
								<?php endwhile; //END SLIDER LOOP ?>
								</li>
								
								
								<?php if($number > 4) { ?>
								<li>
						  		<?php $loop = new WP_Query('product_cat='.$prodcat.'&post_type=product&posts_per_page=4&offset=4');while ( $loop->have_posts() ) : $loop->the_post();?>
						    		
						  		<?php
						  		if(has_post_thumbnail()) {
							  		   $thumb = get_post_thumbnail_id(); 
									   $image = vt_resize( $thumb, '', $carimgwidth, $carouselheight, true );
									 ?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $image['url']; ?>" />
							    	 </a>
						    	 <?php } else {?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $woocommerce->plugin_url() ?>/assets/images/placeholder.png" />
							    	 </a>
						    	 <?php }?>
						    		
								<?php endwhile; //END SLIDER LOOP ?>
								</li>
								<?php } ?>
								
								<?php if($number > 8) { ?>
								<li>
						  		<?php $loop = new WP_Query('product_cat='.$prodcat.'&post_type=product&posts_per_page=4&offset=8');while ( $loop->have_posts() ) : $loop->the_post();?>

														    		
						  		<?php
						  		if(has_post_thumbnail()) {
							  		   $thumb = get_post_thumbnail_id(); 
									   $image = vt_resize( $thumb, '', $carimgwidth, $carouselheight, true );
									 ?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $image['url']; ?>" />
							    	 </a>
						    	 <?php } else {?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $woocommerce->plugin_url() ?>/assets/images/placeholder.png"  />
							    	 </a>
						    	 <?php }?>
						    		
								<?php endwhile; //END SLIDER LOOP ?>
								</li>
								<?php } ?>
								
								
								<?php if($number > 12) { ?>
								<li>
						  		<?php $loop = new WP_Query('product_cat='.$prodcat.'&post_type=product&posts_per_page=4&offset=12');while ( $loop->have_posts() ) : $loop->the_post();?>														 
						  		<?php
						  		if(has_post_thumbnail()) {
							  		   $thumb = get_post_thumbnail_id(); 
									   $image = vt_resize( $thumb, '', $carimgwidth, $carouselheight, true );
									 ?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $image['url']; ?>" />
							    	 </a>
						    	 <?php } else {?>
							    	 <a href="<?php echo the_permalink(); ?>" title="<?php the_title(); ?>">
							    	 <img alt="<?php the_title(); ?>"  src="<?php echo $woocommerce->plugin_url() ?>/assets/images/placeholder.png" />
							    	 </a>
						    	 <?php }?>
						    		
								<?php endwhile; //END SLIDER LOOP ?>
								</li>
								<?php } ?>
								
						    </ul>
						    
						  </div>
					</div>