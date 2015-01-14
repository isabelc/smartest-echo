<?php get_header(); 
$schema = ''; 
$rowclass = 'row reading-row';
if ( is_home() ) {
	$schema = 'Blog';
} 

if ( is_post_type_archive( 'download' ) ) {
	$rowclass = 'row';
}

?>
<div class="<?php echo $rowclass; ?>">
<div class="col_12" <?php if ( $schema ) echo ' itemscope itemtype="http://schema.org/'.$schema.'"'; ?>>
<article id="entry" class="pad20both pad20vertical">
<?php if ( have_posts() ) : ?><h1><?php if(is_home()) {
_e( 'Blog', 'smartestb' );
	} elseif ( is_category() ) {
	printf( __( '%s', 'smartestb' ), '<span>' . single_cat_title( '', false ) . '</span>' );
} elseif ( is_tag() ) {
	printf( __( '"%s" Code Snippets', 'smartestb' ), '<span>' . single_tag_title( '', false ) . '</span>' );
} 
if ( $paged >= 2 ) {
	printf(' - Page %s', max( $paged ) );
} ?></h1><?php

while ( have_posts() ) : the_post();
get_template_part( 'content', get_post_type() );
endwhile;
if (  $wp_query->max_num_pages > 1 ) :
	?><div id="nav-below" class="navigation">
<div class="nav-previous fl"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'storefront' ) ); ?></div>
<div class="nav-next fr"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'storefront' ) ); ?></div></div><!-- #nav-below -->
<?php endif;
else : ?>
<h1><?php _e( 'Nothing Found', 'storefront' ); ?></h1>
<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'storefront' ); ?></p>
<?php get_search_form(); ?>
<?php endif; ?>
</article>
</div></div><?php get_footer(); ?>