<?php require_once TEMPLATEPATH .'/isa_framework/functions.php';
$func = TEMPLATEPATH . '/functions/';
$inc = TEMPLATEPATH . '/includes/';


// require_once $func . 'admin-init.php'; @test ebed it here...
require_once $func . 'admin-setup.php';
require_once $func . 'admin-interface.php';
require_once $func . 'storefront-functions.php';

require_once $inc . 'theme-options.php'; 
require_once $inc . 'theme-functions.php';
require_once $inc . 'theme-js.php'; ?>