<?php
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );
if ( function_exists('register_sidebar') ) {
    register_sidebar(array(
    	'name'=>'Footer Widget 1',
        'before_widget' => '<div class="footwidget1 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

    register_sidebar(array(
    	'name'=>'Footer Widget 2',
        'before_widget' => '<div class="footwidget2 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

    register_sidebar(array(
    	'name'=>'Footer Widget 3',
        'before_widget' => '<div class="footwidget3 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

    register_sidebar(array(
    	'name'=>'Footer Widget 4',
        'before_widget' => '<div class="footwidget4 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));
    register_sidebar(array(
    	'name'=>'Checkout Widget 1',
        'before_widget' => '<div class="footwidget1 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

register_sidebar(array(
    	'name'=>'Forum Widget 1',
        'before_widget' => '<div class="footwidget1 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

register_sidebar(array(
    	'name'=>'Forum Widget 2',
        'before_widget' => '<div class="footwidget2 widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));

register_sidebar(array(
    	'name'=>'Regular Sidebar',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '<div class="clear"></div></div>',
        'before_title' => '<h3>',
        'after_title' => '</h3><div class="underline"></div>',
    ));


}

/* REGISTER CUSTOM MENUS ======================== */
add_theme_support( 'menus' );
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Main Navigation','storefront' )
		)
	);
}
add_theme_support( 'post-thumbnails' );
/*
===============================================================
Custom Post Type For Slider
===============================================================
*/

add_action('init', 'create_slider_post_type');

		function create_slider_post_type() {
	    	$args = array(
	        	'label' => __('Slider','storefront'),
	        	'singular_label' => __('Slide','storefront'),
	        	'public' => true,
	        	'show_ui' => true,
	        	'capability_type' => 'post',
	        	'hierarchical' => false,
	        	'rewrite' => true,
	        	'exclude_from_search' => true,
        		'labels' => array(
					'name' => __( 'Slider','storefront' ),
					'singular_name' => __( 'Slide','storefront' ),
					'add_new' => __( 'Add New','storefront' ),
					'add_new_item' => __( 'Add New Slide','storefront' ),
					'edit' => __( 'Edit','storefront' ),
					'edit_item' => __( 'Edit Slide','storefront' ),
					'new_item' => __( 'New Slide','storefront' ),
					'view' => __( 'View Slide','storefront' ),
					'view_item' => __( 'View Slide','storefront' ),
					'search_items' => __( 'Search Slides','storefront' ),
					'not_found' => __( 'No slides found','storefront' ),
					'not_found_in_trash' => __( 'No slides found in Trash','storefront' ),
					'parent' => __( 'Parent Slide','storefront' ),
				),
	        	'supports' => array('title', 'thumbnail')
	        );

	    	register_post_type( 'slide' , $args );
		}

/* Options For Slider */

		add_action("admin_init", "admin_init");
		add_action('save_post', 'save_slide_meta');

		function admin_init(){
			add_meta_box("slider-meta", "Slider Options", "meta_options", "slide", "normal", "low");
		}

		function meta_options(){
			global $post;
			$custom = get_post_custom($post->ID);
			$link = $custom["link"][0];
	?>
	<p>Set a featured image for this slide using the built-in WordPress featured image feature which is normally located on the right hand side of this page.  </p><p>Then, enter a url (beginning with "http://") of a page, post, product, category or even an off-site link using the field below.</p><br />
		<label style="width:80px;float:left;display:block;font-weight:bold;padding:5px;">Link URL:</label><input style="width:400px;border:1px solid #ccc;" name="link" value="<?php echo $link; ?>" /><br />
	<?php
		}

	function save_slide_meta(){
		global $post;
		if ( isset($_POST["link"]) )
			update_post_meta($post->ID, "link", $_POST["link"]);
	}

/*
===============================================================
BLOG SETTINGS
===============================================================
*/

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* TRUNCATE TITLES @todo maybe do not need this */
if (get_option('smartestb_product_title_shorten')) {
add_action ('wp_head','add_jquery_stuff');  //put the query in the header
function add_jquery_stuff () { ?>
	<script type="text/javascript">
          function shorten(sometext,maxlen) { return ((sometext.length<=maxlen)?sometext:(sometext.substr(0,maxlen-3)+"...")); }
     </script><?php $shorten = get_option('smartestb_product_title_shorten'); ?>
     <script type="text/javascript">
     jQuery(document).ready( function () {
          jQuery('h2.prodtitle,#content #entry ul.products li h3,body.jigoshop .products li strong').each(function(index){ //gets the link in all teaser headlines
                var t = jQuery(this).text();
                jQuery(this).text(shorten(t,<?php echo $shorten;?>)); //truncate to 28
          });
     });
</script>
<?php
}
}

/**
 * BLOG COMMENTS
*/
function storefront_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   ?><li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/UserComments"><div id="comment-<?php comment_ID(); ?>"><div class="comment-author"><?php echo get_avatar( $comment->comment_author_email, 75 ); ?></div><div class="comment-content"><?php if ($comment->comment_approved == '0') : ?><em><?php _e('Your comment is awaiting moderation.','storefront') ?></em><br /><?php endif; ?><div class="comment-meta commentmetadata"><meta itemprop="commentTime" content="<?php comment_date('c'); ?>" /><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s','storefront'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'storefront'),'  ','') ?></div>
		  <?php printf(__('<strong>%s says:</strong>','storefront'), get_comment_author_link()) ?><div itemprop="commentText"><?php comment_text() ?></div><div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div></div></div><?php
} ?>