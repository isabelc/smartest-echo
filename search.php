<?php get_header(); ?>
<div class="row">
<div class="col_12" itemscope itemtype="http://schema.org/SearchResultsPage">
<div id="entry" class="pad20both pad20vertical">
<?php if ( have_posts() ) { /* Start the MAIN Loop */ ?>
<p><span itemprop="name">These are search results for</span> "<strong><?php the_search_query() ?></strong>".</p>
<?php // organize results into Pages, From Blog, etc.

	// pages
	global $wp_query;
	$args = array_merge( $wp_query->query, array( 'post_type' => array('page'), 'post__not_in' => array( 37, 94, 95, 96, 715 ) ) );
	query_posts( $args ); ?><div class="col_2 searchcolumn"><h2><?php _e( 'Pages', 'storefront' ); ?></h2>
	
	<?php if (have_posts()) { while ( have_posts() ) : the_post(); ?><h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3>
	
	<div class="contenthr"></div>
	<?php endwhile; } 
	else { _e( 'There are no pages that match your query.', 'storefront themes' );} ?></div>

	<?php // From the Blog
	global $wp_query;
	$args = array_merge( $wp_query->query, array( 'post_type' => array('post') ) );
	query_posts( $args ); ?><div class="col_6 searchcolumn postcolumn"><h2><?php _e( 'From the Blog', 'storefront' ); ?></h2>
		<?php if (have_posts()) { while ( have_posts() ) : the_post(); ?><div class="post"><?php if(has_post_thumbnail()) {
			$blogimageheight = 125;
			$blogimagewidth = 125;
			$thumb = get_post_thumbnail_id(); 
			$image = vt_resize( $thumb, '', $blogimagewidth, $blogimageheight, true );
			$largeimage = vt_resize( $thumb, '', 900, 700, true ); ?><a href="<?php echo $largeimage['url']; ?>" class="fancybox-image" rel="<?php the_title(); ?>"><img src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" /></a><?php 
			} ?><h3><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?><div class="contenthr"></div></div><?php endwhile; 
			
		} else {
			_e( 'There are no blog posts that match your query.', 'storefront themes' );
		}?></div><!-- .col_6 -->
	
	<?php // begin downloads
	if( function_exists( 'EDD' ) ) {
		// EDD is active
		global $wp_query;
		$args = array_merge( $wp_query->query, array( 'post_type' => array('download')));
		query_posts( $args ); ?><div class="col_3 searchcolumn postcolumn"><h2>Themes</h2>
		
		<?php if (have_posts()) { 
			while ( have_posts() ) : the_post();
						
			if(has_post_thumbnail()) { ?><a href="<?php the_permalink();?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail(); ?></a><?php } ?>
						
			<div class="contenthr"></div>
			<?php endwhile;
		} else { ?>
				There are no themes that match your query.
		<?php } ?>
		</div>
	<?php }
} else { ?>
	<h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1>
	<p><?php _e( 'There were no results found that match your query.', 'storefront themes' ); ?></p>
<?php } ?><div class="clear"></div></div></div></div><!-- .row --><?php get_footer(); ?>