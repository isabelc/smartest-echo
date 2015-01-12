<?php 
if( ! is_page('checkout')) { if( ! is_front_page() ) { 
	?> 	<span id="isa-edd-qty" class="edd-cart-quantity"><?php 
	echo edd_get_cart_quantity(); 
	?></span> <?php 
} ?><a class="navcart" href="<?php bloginfo('url'); ?>/checkout/" title="<?php _e('View your shopping cart', 'storefront'); ?>"></a> <?php } ?>