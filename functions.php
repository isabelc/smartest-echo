<?php 
require_once TEMPLATEPATH .'/isa_framework/functions.php';

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
BLOG SETTINGS
===============================================================
*/

function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 * BLOG COMMENTS
*/
function storefront_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   ?><li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>" itemprop="comment" itemscope itemtype="http://schema.org/UserComments"><div id="comment-<?php comment_ID(); ?>"><div class="comment-author"><?php echo get_avatar( $comment->comment_author_email, 75 ); ?></div><div class="comment-content"><?php if ($comment->comment_approved == '0') : ?><em><?php _e('Your comment is awaiting moderation.','storefront') ?></em><br /><?php endif; ?><div class="comment-meta commentmetadata"><meta itemprop="commentTime" content="<?php comment_date('c'); ?>" /><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s','storefront'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'storefront'),'  ','') ?></div>
		  <?php printf(__('<strong>%s says:</strong>','storefront'), get_comment_author_link()) ?><div itemprop="commentText"><?php comment_text() ?></div><div class="reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div></div></div><?php
} 

/*
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 * Modified by Isabel Castillo
 *
 * php 5.2+
 *
 * Example of use:
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );// or image url for 2nd param
 * 
 * echo $image['url']; ? >" width="< ? p h p  echo $image[width]; ? >" height=" < ? p h p echo $image[height]; ? >" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {

    // this is an attachment, so we have the ID
    if ( $attach_id ) {
    
        $image_src = wp_get_attachment_image_src( $attach_id, 'full' );
        $file_path = get_attached_file( $attach_id );
    
    // this is not an attachment, let's use the image url
    } else if ( $img_url ) {
    
        $file_path = parse_url( $img_url );
            $file_path = rtrim( ABSPATH, '/' ).$file_path['path'];//isa use this path instead
            
            $orig_size = getimagesize( $file_path );
            
            $image_src[0] = $img_url;
            $image_src[1] = $orig_size[0];
            $image_src[2] = $orig_size[1];

    }
    
    $file_info = pathinfo( $file_path );
    $extension = !empty($file_info['extension']) ? '.'. $file_info['extension'] : '';

    // the image path without the extension
    $no_ext_path = !empty($file_info['dirname']) ? $file_info['dirname'].'/'.$file_info['filename'] : '';
    $cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

    // checking if the file size is larger than the target size
    // if it is smaller or the same size, stop right here and return
    if ( $image_src[1] > $width || $image_src[2] > $height ) {

        // the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
        if ( file_exists( $cropped_img_path ) ) {

            $cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
            
            $vt_image = array (
                'url' => $cropped_img_url,
                'width' => $width,
                'height' => $height
            );
            
            return $vt_image;
        }

        // $crop = false
        if ( $crop == false ) {
        
            // calculate the size proportionaly
            $proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
            $resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;            
            // checking if the file already exists
            if ( file_exists( $resized_img_path ) ) {
            
                $resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );

                $vt_image = array (
                    'url' => $resized_img_url,
                    'width' => $proportional_size[0],
                    'height' => $proportional_size[1]
                );
                
                return $vt_image;
            }
        }
        // no cache files - let's finally resize it

    $editor = wp_get_image_editor( $file_path );
    if ( is_wp_error( $editor ) )
        return $editor;
    $editor->set_quality( 100 );
    $resized = $editor->resize( $width, $height, $crop );
    $dest_file = $editor->generate_filename( NULL, NULL );
    $saved = $editor->save( $dest_file );
    if ( is_wp_error( $saved ) )
        return $saved;
    $new_img_path=$dest_file;

        $new_img_size = getimagesize( $new_img_path );
        $new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );

        // resized output
        $vt_image = array (
            'url' => $new_img,
            'width' => $new_img_size[0],
            'height' => $new_img_size[1]
        );
        
        return $vt_image;
    }

    // default output - without resizing
    $vt_image = array (
        'url' => $image_src[0],
        'width' => $image_src[1],
        'height' => $image_src[2]
    );
    
    return $vt_image;
}

function smartestecho_enqueue_scripts( ) {
	
	wp_enqueue_style( 'smartest-echo', get_template_directory_uri(). '/style.css');
	
	wp_deregister_script( 'jquery' );
    if( ! is_front_page() ) {
        wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', '','1.11.2', true);// move to footer
        
    }
	
	// remove Q and A from all but FAQS pages
	if (! is_page(array('faqs', 'license-faqs'))) {
		wp_dequeue_script( 'q-a-plus' );
		wp_dequeue_style( 'q-a-plus');
	}
	if(is_single()) {
		wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/css/jquery.fancybox.css');
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/js/jquery.fancybox.pack.js', array('jquery'), false, true );
	}
	if ( class_exists('bbPress') ) {
	  if ( ! is_bbpress() ) {
		wp_dequeue_style('bbp-default');
		wp_dequeue_style( 'bbp_private_replies_style');
		wp_dequeue_script('bbpress-editor');
	  }
	}
	// move edd-ajax.js to footer
	wp_dequeue_script( 'edd-ajax' );
	wp_enqueue_script( 'edd-ajax', plugins_url( '/easy-digital-downloads/assets/js/edd-ajax.min.js'), array( 'jquery' ), EDD_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'smartestecho_enqueue_scripts' );

?>