<!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width"><title><?php wp_title( '', true, 'right' ); ?></title><?php $sitename = 'Smartest Themes';
$homedesc = 'Custom WordPress Themes to get your business website up quick and easy by Smartest Themes.';
$homekeys = 'smartest themes, WordPress themes, business themes, app themes,business website';
$fb_id = 'isabel.8991';
$shopdesc = 'WordPress themes for business by Smartest Themes.';
$shopkeys = 'smartest themes, WordPress themes, business themes, app themes';
global $paged, $page;
if (is_front_page()) { ?><meta name="description" content="<?php echo $homedesc; ?>" />
<meta name="keywords" content="<?php echo $homekeys; ?>" /><meta property="og:title" content="Smartest Themes, WordPress Themes" /><meta property="og:site_name" content="<?php echo $sitename; ?>" /><meta property="og:url" content="<?php bloginfo('url'); ?>" /><meta property="og:description" content="<?php echo $homedesc; ?>" /><meta property="og:image" content="<?php echo network_site_url(); ?>wp-content/uploads/2015/01/st-2015-profile-avatar-250x250.png" /><meta property="og:type" content="website" /><meta property="fb:admins" content="<?php echo $fb_id; ?>" />
<?php } //end if front page
elseif ( is_archive() && 'download'==get_post_type() ) {
		echo '<meta name="description" content="'.$shopdesc.'" /><meta name="keywords" content="'.$shopkeys.'" />';
} elseif(is_category()) { ?>
	<meta name="description" content="<?php if ( $paged >= 2 ) {echo sprintf('Page %s - ', max( $paged ) );} echo strip_tags(category_description());?>" />
<?php } elseif(is_tag()) { ?>
		<meta name="description" content="<?php	if ( $paged >= 2 ) { echo sprintf('Page %s - ', max( $paged ) );	} echo strip_tags(tag_description()); ?>" />
<?php } elseif ( is_singular('post') ) { ?>
		<meta name="description" content="<?php if ( have_posts() ) : while(have_posts()) : the_post();
		$meta = strip_tags(get_the_excerpt());echo $meta;
		endwhile; endif; ?>" />
		<meta property="og:title" content="<?php wp_title( '', true, 'right' ); ?>" />
		<meta property="og:site_name" content="<?php echo $sitename; ?>" />
		<meta property="og:url" content="<?php the_permalink(); ?>" />
		<meta property="og:description" content="<?php echo $meta; ?>" />
		<?php if(has_post_thumbnail( $post->ID )) { 
			$thumbnail_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
			echo '<meta property="og:image" content="' . esc_attr( $thumbnail_src[0] ) . '"/>';
			} ?><meta property="og:type" content="article" /><meta property="fb:admins" content="<?php echo $fb_id; ?>" />
<?php } // ends if is single post
if ( $paged >= 2 ) {echo '<meta name="robots" content="noindex, follow, noarchive" />';} ?>
	<!--[if IE]>
    	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" type="text/css" media="screen" />
	<![endif]--> 
<?php wp_head(); ?><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-41426075-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(ga, s);})();</script></head><body <?php body_class(); ?>>

<div class="pad20bottom">
	<header id="header" class="row"><div class="alignleft" id="logo">
	<a href="<?php bloginfo('url'); ?>" title="Smartest Themes <?php bloginfo('description'); ?>"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/2015/01/st_logo_2015.png" alt="<?php bloginfo('name'); ?>" title="Smartest Themes <?php bloginfo('description'); ?>" width="350" height="102" /></a></div>

	<div class="alignright pad20bottom" id="header-right">

		<div class="mobilesearch"><?php get_search_form(); ?><a class="mobilecart" href="<?php bloginfo('url'); ?>/checkout/" title="View your shopping cart"></a></div>

		<nav id="nav-container" class="navigation">

			<div id="navwrap">

				<button class="menu-toggle">Menu</button>

				<?php wp_nav_menu( 'theme_location=primary-menu&container=&menu_class=nav-menu&items_wrap=<ul class="%2$s">%3$s</ul>' );
					get_template_part('includes/nav', 'cart');
		?>
				<div class="clear"></div>
	
			</div>

		</nav>	<!-- #nav-container -->

	</div>

	<div class="clear"></div>
	</header>
	<div id="main">
		<div id="primary">
			<div id="content">
			<?php wp_enqueue_style('font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css'); ?>