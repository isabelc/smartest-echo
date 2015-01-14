<div class="post" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
<?php if(has_post_thumbnail()) {
	$blogimageheight = 200;
	$blogimagewidth = 200;
	$thumb = get_post_thumbnail_id(); 
	$image = vt_resize( $thumb, '', $blogimagewidth, $blogimageheight, true );
	$largeimage = vt_resize( $thumb, '', 900, 700, true );
?>
<a href="<?php echo $largeimage['url']; ?>" class="fancybox-image" rel="<?php the_title(); ?>">
<img alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" itemprop="thumbnailUrl" />
</a>
<?php } ?><h2><a href="<?php the_permalink();?>" itemprop="name" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<div class="post-meta">
<p><span class="blogicon time"></span> <?php the_time('F j, Y \a\t g:i a') ?></p>
<p><span class="blogicon cats"></span> <?php the_category(', ') ?>&nbsp;
<?php the_tags( '<span class="blogicon tag"></span> ', ', ', ''); ?></p>
</div><?php the_excerpt(); ?><a class="button" href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php _e( 'See More...', 'storefront' ); ?></a>
<div class="clear pad20bottom"></div>
<div class="contenthr"></div>
</div><!-- .post -->