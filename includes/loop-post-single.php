<?php while ( have_posts() ) : the_post();
	?><div id="post-<?php the_ID(); ?>" class="post"><h1><?php the_title(); ?></h1><?php 
	if(has_post_thumbnail()) {
		if (get_option('smartestb_featured_image_height')) {
			$blogimageheight = get_option('smartestb_blog_image_height');
		} else {
			$blogimageheight = 200;
		}
		if (get_option('smartestb_featured_image_width')) {
			$blogimagewidth = get_option('smartestb_blog_image_width');
		} else {
			$blogimagewidth = 300;
		}
		$thumb = get_post_thumbnail_id(); 
		$image = vt_resize( $thumb, '', $blogimagewidth, $blogimageheight, true );
		$largeimage = vt_resize( $thumb, '', 900, 700, true );
			
		?><div class="blog-featured-image fr"><a href="<?php echo $largeimage[url]; ?>" class="fancybox-image"><img alt="<?php the_title(); ?>" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" /></a></div><?php 
	} 
		
	?><div class="post-meta">Posted on <?php the_time('F j, Y') ?> by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author() ?></a> in <?php the_category(', ') ?><br /><?php
	the_tags( '<p>Tags: ', ', ', '</p>'); 
	?></div><div class="entry"><?php the_content();?></div><br class="clear" /></div><?php  

	comments_template();
endwhile; ?>