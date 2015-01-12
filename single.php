<?php get_header(); 
$post_type = get_post_type();
if ( 'post' == $post_type ) {
 	$schema = 'TechArticle';
} else {
	$schema = 'Article';
} 
?><div class="col_12" <?php echo ' itemscope itemtype="http://schema.org/' . $schema . '"'; ?>>
<?php 
// if is a regular post, add grid 8 and grid 4 for sideabar @Test
if ( 'post' == $post_type ) { 
	?><div class="col_8"><?php 
}

?><article id="entry" class="pad20both pad20vertical"><?php

if ( have_posts() ) :
	while ( have_posts() ) : the_post(); 
		?><div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php
		if(has_post_thumbnail()) {
			$thumb = get_post_thumbnail_id(); 
			$full_img = wp_get_attachment_image_src( $thumb, 'full');
			?><a href="<?php echo $full_img[0]; ?>" class="fancybox" rel="<?php the_title_attribute(); ?>"><img src="<?php echo $full_img[0]; ?>" alt="<?php the_title_attribute(); ?>" itemprop="image" width="<?php echo $full_img[1]; ?>" height="<?php echo $full_img[2]; ?>" /></a><?php
		} 
		?><h1 itemprop="name"><?php the_title(); ?></h1><div class="post-meta"><meta itemprop="datePublished" content="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><span class="blogicon time"></span> <?php the_time('F j, Y \a\t g:i a') ?><br />	<span class="blogicon cats"></span> <?php the_category(', ') ?>&nbsp; <?php

		the_tags( '<span class="blogicon tag"></span> ', ', ', '');

		?><br /></div><?php

		the_content();

		?><div class="clear pad20bottom"></div><div class="contenthr"></div><?php

		if ( (get_option('smartestb_blog_author_section') == "true") && ( 'isa_legal' != $post_type ) ) { 

			?><div class="author-bio"><h3><?php _e('About the Author', 'storefront') ?></h3><div class="author-content" itemprop="author" itemscope itemtype="http://schema.org/Person"><?php

			echo get_avatar( get_the_author_meta('email'), '75' );

			?><div class="author-description"><strong itemprop="name"><?php the_author_meta("user_firstname"); ?> <?php the_author_meta("user_lastname"); ?></strong><p><?php the_author_meta("description"); ?></p></div></div></div><div class="clear pad20bottom"></div><div class="contenthr"></div><?php

		}

		wp_link_pages('before=<p>&after=</p>&next_or_number=number&pagelink=page %'); 

		?></div><?php

		if ( 'isa_legal' != $post_type ) comments_template();

	endwhile;

else : 
	?><h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1><p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'storefront' ); ?></p><?php

		get_search_form();
endif; 

?></article><?php

// if is a regular post, add grid 8 and grid 4 for sideabar @Test

if ( 'post' == $post_type ) {

?></div><!-- .col_8 --><div class="col_4 last"><?php get_sidebar(); ?></div><?php
}
?></div><!-- .col_12 --><?php get_footer(); ?>