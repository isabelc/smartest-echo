<div id="content-bottom-border" class="col_12"></div>
<div id="content-bottom" class="col_12">
<div class="row">
<div class="widget col_3">
<?php if( is_page('checkout')) { 
	dynamic_sidebar('Checkout Widget 1'); 
	} elseif( class_exists('bbPress') && is_bbpress() ) {
	dynamic_sidebar('Forum Widget 1'); 
	} else { 
	dynamic_sidebar('Footer Widget 1');
} ?>
</div>
<div class="widget col_3">
<?php 
if( class_exists('bbPress') ) {

	if ( is_bbpress() ) {
		dynamic_sidebar('Forum Widget 2'); 
	} else {
		dynamic_sidebar('Footer Widget 2'); 		
	}
} else {
	dynamic_sidebar('Footer Widget 2'); 
} ?>
</div>
<div class="widget col_3">
<?php dynamic_sidebar('Footer Widget 3'); ?><br />
</div>
<div class="widget col_3 last">
<?php dynamic_sidebar('Footer Widget 4'); ?>
</div>
</div><!-- .row -->
</div><!-- #content-bottom -->
