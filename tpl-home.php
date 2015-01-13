<?php 
/*
Template Name: Homepage
*/
get_header(); 

if(get_option('smartestb_show_slider') == 'true') {
	// @todo remove all slider code when I stop using it.
	$slidertransspeed = 5;
	$slideranimspeed = 500;
	if(get_option('smartestb_slider_trans_speed')) {$slidertransspeed = get_option('smartestb_slider_trans_speed');}
	if(get_option('smartestb_slider_anim_speed')) {$slideranimspeed = get_option('smartestb_slider_anim_speed');} ?>			
	<script>
	jQuery(window).load(function() {
		jQuery('.blueberry').blueberry({
		interval:<?php echo $slidertransspeed;?>000,
		duration:<?php echo $slideranimspeed;?>,
		hoverpause:false,
		pager:true,
		keynav:true
		});
	});
	</script><?php
	
$sliderheight = 365; 
if(get_option('smartestb_slider_height')) {$sliderheight = get_option('smartestb_slider_height');} ?><style>#mainslider {min-height:<?php echo $sliderheight + 40;?>px;}</style><div id="mainslider" class="blueberry"><ul class="slides"><?php //BEGIN Slider LOOP
$loop = new WP_Query( array( 'post_type' => 'slide' ) );
while ( $loop->have_posts() ) : $loop->the_post();
$buttontext = get_post_meta($post->ID, "text", true);
$buttonlink = get_post_meta($post->ID, "link", true);
if(has_post_thumbnail()) {
		$thumb = get_post_thumbnail_id();
		$image = vt_resize( $thumb, '', 960, $sliderheight, true );
} 
?><li><a href="<?php echo $buttonlink;?>"><img alt="<?php the_title(); ?>" title="<?php echo $buttontext; ?>" src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" /></a></li><?php endwhile; wp_reset_query(); //END SLIDER LOOP 
?></ul></div><?php 
} //END OF CHECK TO SHOW SLIDER 
?><div class="col_12" itemscope itemtype="http://schema.org/LocalBusiness"><div id="entry" class="pad10bottom pad20both"><?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
else : 
	?><h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1><p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'storefront' ); ?></p><?php get_search_form();
endif;
wp_reset_query();
?></div><!-- #pad20both --></div><!-- #col_12 --><div class="clear"></div><?php

if(get_option('smartestb_show_carousel') == 'true') {
// require(TEMPLATEPATH . '/includes/home-carousel-jigoshop.php');
} //END OF CHECK TO SHOW CAROUSEL
get_footer(); ?>