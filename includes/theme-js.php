<?php
function smartestecho_enqueue_scripts( ) {
	
	if(is_front_page()) {
		wp_enqueue_style( 'homeslider', get_template_directory_uri() . '/css/homeslider.css');
	}
	wp_enqueue_style( 'smartest-echo', get_template_directory_uri(). '/style.css');
	if(is_front_page()) {
		wp_enqueue_script( 'homeslider', get_template_directory_uri() . '/js/homeslider.2014.4.28.js', array('jquery'), false, true );
	
	} else {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js', '','1.11.0', true);// move to footer
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
add_action( 'wp_enqueue_scripts', 'smartestecho_enqueue_scripts' ); ?>