<?php 
/*
Template Name: Homepage
*/
get_header(); 
?><div class="att-grab">The Smartest WordPress Themes For Small Business</div>

<div class="fullwide-row splash selfclear">
	<a href="<?php bloginfo('url'); ?>/downloads" title="WordPress Themes For Business"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2015/01/smartest-themes-fullwidth-1756.png" alt="WordPress Themes For Business" title="WordPress Themes For Business" width="1756" height="250" /></a>
</div>

<div class="col_12" itemscope itemtype="http://schema.org/LocalBusiness"><div id="entry" class="pad10bottom pad20both"><?php
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
		the_content();
	endwhile;
else : 
	?><h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1><p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'storefront' ); ?></p><?php get_search_form();
endif;
wp_reset_query();
?></div><!-- #pad20both --></div><!-- #col_12 --><div class="clear"></div><?php get_footer(); ?>