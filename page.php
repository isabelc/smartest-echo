<?php get_header(); 
$schema = '';
$single_q = '';
$single_answer = '';

if(is_page('contact') ) {
	$schema = 'ContactPage';
} elseif (is_page('faqs')) {
	$schema = 'CollectionPage';
} elseif (is_page('checkout')) {
	$schema = 'CheckoutPage';
} elseif ( 'qa_faqs' == get_post_type() ) {

	$schema = 'QAPage';
	$single_q = ' itemscope itemtype="http://schema.org/Question"';
	$single_answer = ' itemprop="acceptedAnswer" itemscope itemtype="http://schema.org/Answer"';
	
} ?><div class="col_12" <?php if ( $schema ) echo ' itemscope itemtype="http://schema.org/'.$schema.'"'; ?>>
<?php if(has_post_thumbnail()) {
	$thumb = get_post_thumbnail_id(); 
	$image = vt_resize( $thumb, '', 960, 500, true ); ?>
<img class="pagefeaturedimage" src="<?php echo $image['url']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" <?php if ( $schema ) echo ' itemprop="image"'; ?> />
<?php } ?>
<article id="entry" class="pad20both pad20vertical" <?php if ( $single_q ) echo $single_q; ?>>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

if( class_exists('bbPress')) {
	if( bbp_is_forum_archive() ) { ?>
		<h1><i class="fa fa-bell"></i> Support Forums</h1>
	<?php } elseif (bbp_is_single_forum()) { ?>
		<h1><i class="fa fa-bell"></i> Support for <?php echo ' ' . get_the_title(); ?></h1>
	<?php } else { ?>
		<h1 <?php if($schema) echo ' itemprop="name"'; ?>><?php the_title(); ?></h1>
	<?php }
	if ( bbp_is_single_forum() ) { ?>
		<div class="bbp-template-notice"><p>Create a new topic below. When you post, be sure to mark <strong>'Notify me of follow-up replies via email'</strong> if you want to receive an email when your question is answered. <a href="<?php bloginfo('url'); ?>/faqs/what-are-your-support-hours/" title="Support Hours" target="_blank">Support Hours</a></p></div>
<div class="bbp-search-form"><?php bbp_get_template_part( 'form', 'search' ); ?></div>
<?php }
	} else { ?>
		<h1 <?php if ( $schema ) echo ' itemprop="name"'; ?>><?php the_title(); ?></h1>
	<?php } 
	
if($single_answer) echo '<div ' . $single_answer . '><div itemprop="text">';
the_content(); 
if($single_answer) echo '</div></div>';
endwhile;
else : ?>
	<h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1>
	<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'twentyeleven' ); ?></p>
	<?php get_search_form();
endif; ?>
</article>
</div><!-- #col_12 -->
<?php get_footer(); ?>