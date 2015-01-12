<?php
/*-----------------------------------------------------------------------------------*/
/* Add default options and show Options Panel after activate  */
/*-----------------------------------------------------------------------------------*/
if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) {

	//Call action that sets
	add_action('admin_head','storefront_option_setup');
	
	//Do redirect
	header( 'Location: '.admin_url().'admin.php?page=storefrontthemes' ) ;
}

function storefront_option_setup(){
	//Update EMPTY options
	$storefront_array = array();
	add_option('smartestb_options',$storefront_array);

	$template = get_option('smartestb_template');
	$saved_options = get_option('smartestb_options');
	
	foreach($template as $option) {
		if($option['type'] != 'heading'){
			$id = $option['id'];
			$std = $option['std'];
			$db_option = get_option($id);
			if(empty($db_option)){
				if(is_array($option['type'])) {
					foreach($option['type'] as $child){
						$c_id = $child['id'];
						$c_std = $child['std'];
						update_option($c_id,$c_std);
						$storefront_array[$c_id] = $c_std; 
					}
				} else {
					update_option($id,$std);
					$storefront_array[$id] = $std;
				}
			}
			else { //So just store the old values over again.
				$storefront_array[$id] = $db_option;
			}
		}
	}
	update_option('smartestb_options',$storefront_array);
}
?>