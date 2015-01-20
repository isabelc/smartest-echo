<?php 
/**
 * This file is not currently used, but may use it in the future.
 */
while ( have_posts() ) : the_post(); ?>
	<div id="post-<?php the_ID(); ?>" class="post">
		<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
		<?php 
		if(has_post_thumbnail()) {
			$blogimageheight = 150;
			$blogimagewidth = 200;
		$thumb = get_post_thumbnail_id(); 
		$image = vt_resize( $thumb, '', $blogimagewidth, $blogimageheight, true );
 		$largeimage = vt_resize( $thumb, '', 900, 700, true );

		?><div class="blog-featured-image fr">
		<a href="<?php echo $largeimage[url]; ?>" class="fancybox-image">
		<img alt="<?php the_title(); ?>" src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
		</a>
		</div><?php } ?>
		
		<div class="post-meta">
		Posted on <?php the_time('F j, Y') ?> by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author() ?></a> in <?php the_category(', ') ?><br />
		<?php the_tags( '<p>Tags: ', ', ', '</p>'); ?>
		</div>
		<div class="entry"><?php the_excerpt(); ?></div>
		<br class="clear" />
	</div>
<?php endwhile;?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<div id="nav-below" class="navigation">
					<div class="nav-previous fl"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'storefront' ) ); ?></div>
					<div class="nav-next fr"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'storefront' ) ); ?></div>
				</div><!-- #nav-below -->
<?php endif; ?>