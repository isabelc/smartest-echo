<?php get_header(); ?>
<div class="row">
<div id="singleDL" class="col_12"><article id="entry" class="pad20both pad20vertical">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="imgcol"><?php 

if(has_post_thumbnail()) {

	$thumb = get_post_thumbnail_id(); 
	$full_feat_img = wp_get_attachment_image_src( $thumb, 'full');
	$full_feat_img_url = $full_feat_img[0];
	$alt = get_post_meta($thumb, '_wp_attachment_image_alt', true);
	$image = vt_resize( '', $full_feat_img_url, 458, 458, false ); ?>
	
	<a href="<?php echo $full_feat_img_url; ?>" id="singleDLimg" class="fancybox"  rel="group-001" title="<?php the_title_attribute(); ?>" ><img src="<?php echo $image['url']; ?>" alt="<?php echo esc_attr( $alt ); ?>" itemprop="screenshot" title="<?php echo esc_attr( $alt ); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" /></a>

<?php } 
// end feat. img
// begins attached imgs
$args = array(
    'post_type'   => 'attachment',
    'numberposts' => -1,
	'post_mime_type' => 'image',
    'post_status' => null,
    'post_parent' => $post->ID,
    'exclude'     => get_post_thumbnail_id()
    );
$attachments = get_posts( $args );
if ( $attachments ) { ?>
<br /><?php foreach ( $attachments as $attachment ) {
	$image_full = wp_get_attachment_image_src( $attachment->ID, 'full' );
	$full_img_url = $image_full[0];
	$image = vt_resize( '', $full_img_url, 138, 138, false ); ?>
	<a href="<?php echo $image_full[0]; ?>" class="fancybox" title="<?php echo get_the_title($attachment->ID); ?>" rel="group-001">
	<img src="<?php echo $image['url']; ?>" title="<?php echo esc_attr( get_the_title($attachment->ID) ); ?>" alt="<?php echo esc_attr( get_the_title($attachment->ID) ); ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" id="sgl_gall_img" />
	</a>
<?php 
    }// end foreach
} ?>
</div><h1 itemprop="name"><?php the_title(); ?></h1>
<?php if( '0.00' != edd_get_download_price( get_the_ID() ) ) { ?>
<div class="edd_download_buy_button"><?php echo edd_get_purchase_link( array( 'id' => get_the_ID() ) ); ?></div><?php 
	$demoslug = $post->post_name;// slug
	$demourl = get_bloginfo('url').'/'.$demoslug.'/';
	echo '<a href="'.$demourl.'" title="Demo '.the_title_attribute('echo=0').' theme" class="button livedemo" target="_blank">Live Demo</a>';
} ?><br /><a target="_blank" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()); ?>" class="simple-share ss-gplus" title="Share on G+">G+ Share</a><a target="_blank" href="https://twitter.com/share?text=<?php echo urlencode(strip_tags(get_the_title())); ?>&amp;hashtags=WordPressTheme,WordPressThemes" class="simple-share ss-twitter" title="Tweet">Tweet</a><a target="_blank" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" class="simple-share ss-facebook" title="Share on Facebook">Share</a><a href="http://www.pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&media=<?php echo $full_feat_img_url; ?>&description=<?php echo urlencode(get_the_title() . ' - ' . get_permalink()); ?>" class="simple-share ss-pinterest" target="_blank">Pin It</a><br /><br /><?php the_content(); ?><div class="clear pad20bottom"></div><?php endwhile; else : ?><h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1><p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'storefront' ); ?></p><?php get_search_form();
endif; ?></article></div></div><!-- .row --><?php get_footer(); ?>