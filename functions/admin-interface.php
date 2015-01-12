<?php
// storefrontThemes Admin Interface

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- storefrontThemes Admin Interface - storefrontthemes_add_admin
- storefrontThemes Reset Function - storefront_reset_options
- Framework options panel - storefrontthemes_options_page
- Framework Settings page - storefrontthemes_framework_settings_page
- storefront_load_only
- Ajax Save Action - storefront_ajax_callback
- Generates The Options - storefrontthemes_machine
- storefrontThemes Uploader - storefrontthemes_uploader_function

-----------------------------------------------------------------------------------*/

// Load static framework options pages 
$functions_path = TEMPLATEPATH . '/functions/';

function storefrontthemes_add_admin() {

    global $query_string;
    global $current_user;
    $current_user_id = $current_user->ID;
    
    $themename =  get_option('smartestb_themename');      
    $shortname =  get_option('smartestb_shortname'); 
   
    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'storefrontthemes' ) {
		if (isset($_REQUEST['smartestb_save']) && 'reset' == $_REQUEST['smartestb_save']) {

			$options =  get_option('smartestb_template'); 
			storefront_reset_options($options,'storefrontthemes');
			header("Location: admin.php?page=storefrontthemes&reset=true");
			die;
		}
    }

    
    // Check all the Options, then if the no options are created for a relative sub-page... it's not created.
	if(get_option('framework_storefront_backend_icon')) { $icon = get_option('framework_storefront_backend_icon'); }
	else { $icon = get_bloginfo('template_url'). '/functions/images/storefront-icon.png'; }
	
    if(function_exists('add_object_page'))
    {
    //Changed title by Matt to just Storefront
        add_object_page ('Page Title', 'Storefront', 'administrator','storefrontthemes', 'storefrontthemes_options_page', $icon);
    }
    else
    {
    //Changed title by Matt to just Storefront
        add_menu_page ('Page Title', 'Storefront', 'administrator','storefrontthemes_home', 'storefrontthemes_options_page', $icon); 
    }
    //Changed title by Matt to just Storefront
    $storefrontpage = add_theme_page('storefrontthemes', 'Storefront', 'manage_options', 'storefrontthemes','storefrontthemes_options_page'); // Default
	
	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$storefrontpage", 'storefront_load_only');    
} 

add_action('admin_menu', 'storefrontthemes_add_admin');

/*-----------------------------------------------------------------------------------*/
/* storefrontThemes Reset Function - storefront_reset_options */
/*-----------------------------------------------------------------------------------*/

function storefront_reset_options($options,$page = ''){

	global $wpdb;
	$query_inner = '';
	$count = 0;
	
	$excludes = array( 'blogname' , 'blogdescription' );
	
	
	foreach($options as $option){
			
		if(isset($option['id'])){ 
			$count++;
			$option_id = $option['id'];
			$option_type = $option['type'];
			
			//Skip assigned id's
			if(in_array($option_id,$excludes)) { continue; }
			
			if($count > 1){ $query_inner .= ' OR '; }
			if($option_type == 'multicheck'){
				$multicount = 0;
				foreach($option['options'] as $option_key => $option_option){
					$multicount++;
					if($multicount > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '" . $option_id . "_" . $option_key . "'";
					
				}
				
			} else if(is_array($option_type)) {
				$type_array_count = 0;
				foreach($option_type as $inner_option){
					$type_array_count++;
					$option_id = $inner_option['id'];
					if($type_array_count > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '$option_id'";
				}
				
			} else {
				$query_inner .= "option_name = '$option_id'";
			}
		}
			
	}
	
	//When Theme Options page is reset - Add the storefront_options option
	if($page == 'storefrontthemes'){
		$query_inner .= " OR option_name = 'smartestb_options'";
	}
	
	//echo $query_inner;
	
	$query = "DELETE FROM $wpdb->options WHERE $query_inner";
	$wpdb->query($query);
		
}

function storefrontthemes_options_page(){
    $options =  get_option('smartestb_template');      
    $themename =  get_option('smartestb_themename');      
    $shortname =  get_option('smartestb_shortname');
    $manualurl =  get_option('smartestb_manual');
    $version =  get_option('smartestb_version'); 
?>
<div class="wrap" id="storefront_container">
<div id="storefront-popup-save" class="storefront-save-popup"><div class="storefront-save-save">Options Updated</div></div>
<div id="storefront-popup-reset" class="storefront-save-popup"><div class="storefront-save-reset">Options Reset</div></div>
    <form action="" enctype="multipart/form-data" id="storefrontform">
        <div id="header">
           <div class="logo">

                <img alt="storefrontThemes" src="<?php echo bloginfo('template_url'); ?>/functions/images/logo.png"/>

            </div>
             <div class="theme-info">
				<span class="theme" style="margin-top:10px;"><?php echo $themename; ?></span>
			</div>
			<div class="clear"></div>
		</div>
        <?php 
		// Rev up the Options Machine
        $return = storefrontthemes_machine($options);
        ?>
		<div id="support-links">
<!--[if IE]>
<div class="ie">
<![endif]-->
			<ul>
            <li class="right"><img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-top.gif" class="ajax-loading-img ajax-loading-img-top" alt="Working..." /><a href="#" id="expand_options">[+]</a> <input type="submit" value="Save All Changes" class="button submit-button" /></li>
			</ul> 
<!--[if IE]>
</div>
<![endif]-->
		</div>
        <div id="main">
	        <div id="storefront-nav">
				<ul>
					<?php echo $return[1] ?>
					<?php if (defined('BP_VERSION')) { ?><li><a class="buddypress" title="BuddyPress" href="#storefront-option-buddypress"><span class="storefront-nav-icon"></span>BuddyPress</a></li><?php } ?>
					<li><a class="theme-support" title="Theme Support" href="#storefront-option-themesupport"><span class="storefront-nav-icon"></span>Theme Support</a></li>
					

				</ul>		
			</div>
			<div id="content">
	         <?php echo $return[0]; /* Settings */ ?>
	         
	         <!-- ADD THE THEME SUPPORT SECTION -->
	         <div class="group" id="storefront-option-themesupport" style="display:block;">
	         <h2>Theme Support</h2>
	         <div class="section support-section">
	         <h3 class="support-title">Theme Support</h3>
	         </div>
	         
	         <div class="section support-section">
	         <p class="support-content">Stuck?  Need some help?  We have an extensive collection of support materials that is growing all the time to help you get up and running with Storefront Themes...</p>
	         </div>
	         <div class="support-divider"></div>
	         
	         <div class="section support-section">
	         <div class="support-section-icon video-icon"></div>
	         <h4 class="support-section-title">Video</h4>
	         <p class="support-content">Our video tutorials cover topics like installation, using the wp-e-commerce plugin (products, categories, shipping, etc.), and customizing our themes for use with different types of sites.</p>
	         <div class="clear"></div>
	         </div>
	         <div class="support-divider"></div>
	         
	         <div class="section support-section">
	         <div class="support-section-icon forums-icon"></div>
	         <h4 class="support-section-title">Support Forums</h4>
	         <p class="support-content">We're very active on our support forums.  We focus on answering and fixing bugs and helping people to use the default functionality of the themes.  However, the forums can be a great place for users to share customization techniques as well!.</p>
	         <div class="clear"></div>
	         </div>
	         <div class="support-divider"></div>
	         
	         <div class="section support-section">
	         <div class="support-section-icon gift-icon"></div>
	         <h4 class="support-section-title">Additional Materials</h4>
	         <p class="support-content">One of the ways we add value to our service is by providing additional <strong>FREE</strong> materials to help your online shop succeed.  From time to time we post things like logo templates, icons, marketing tips and more.</p>
	         <div class="clear"></div>
	         </div>
	         <div class="support-divider"></div>
	         
	         <div class="section support-section">
	         <a class="support-button" target="_blank" title="Theme Support & Video Tutorials" href="http://storefrontthemes.com/members-home">Get Theme Support &raquo;</a>
	         </div>
	         
	         </div><!-- END THEME SUPPORT SECTION -->
	         
	         
	        
	         

	         
	        </div>
	        <div class="clear"></div>
	        
        </div>
        <!--[if IE]>
		<div class="ie">
		<![endif]-->
        <div class="save_bar_top">
        <img style="display:none" src="<?php echo bloginfo('template_url'); ?>/functions/images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
        <input type="submit" value="Save All Changes" class="button submit-button" />        
        </form>
     
        <form action="<?php echo esc_html( $_SERVER['REQUEST_URI'] ) ?>" method="post" style="display:inline" id="storefrontform-reset">
            <span class="submit-footer-reset">
            <input name="reset" type="submit" value="Reset Options" class="button submit-button reset-button" onclick="return confirm('Click OK to reset. Any settings will be lost!');" />
            <input type="hidden" name="smartestb_save" value="reset" /> 
            </span>
        </form>
       
        </div>
        <!--[if IE 6]>
		</div>
		<![endif]-->
        
<div style="clear:both;"></div>    
</div><!--wrap-->

 <?php
}
function storefront_load_only() {
	add_action('admin_head', 'storefront_admin_head');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_register_script('jquery-input-mask', get_bloginfo('template_directory').'/functions/js/jquery.maskedinput-1.3.1.min.js', array( 'jquery' ));
	wp_enqueue_script('jquery-input-mask');
	function storefront_admin_head() { 
		echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/functions/admin-style.css" media="screen" />';
		echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/functions/css/jquery-ui-datepicker.css" />'
		 // COLOR Picker ?>
		<link rel="stylesheet" media="screen" type="text/css" href="<?php echo get_bloginfo('template_directory'); ?>/functions/css/colorpicker.css" />

	<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/colorpicker.js"></script>
		<script type="text/javascript" language="javascript">
		jQuery(document).ready(function(){
			
			//JQUERY DATEPICKER
			jQuery('.storefront-input-calendar').each(function (){
				jQuery('#' + jQuery(this).attr('id')).datepicker({showOn: 'button', buttonImage: '<?php echo get_bloginfo('template_directory');?>/functions/images/calendar.gif', buttonImageOnly: true});
			});
			
			//JQUERY TIME INPUT MASK
			jQuery('.storefront-input-time').each(function (){
				jQuery('#' + jQuery(this).attr('id')).mask("99-9999999");
			});
			
			//Color Picker
			<?php $options = get_option('smartestb_template');
			
			foreach($options as $option){ 
			if($option['type'] == 'color' OR $option['type'] == 'typography' OR $option['type'] == 'border'){
				if($option['type'] == 'typography' OR $option['type'] == 'border'){
					$option_id = $option['id'];
					$temp_color = get_option($option_id);
					$option_id = $option['id'] . '_color';
					$color = $temp_color['color'];
				}
				else {
					$option_id = $option['id'];
					$color = get_option($option_id);
				}
				?>
				 jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '<?php echo $color; ?>');    
				 jQuery('#<?php echo $option_id; ?>_picker').ColorPicker({
					color: '<?php echo $color; ?>',
					onShow: function (colpkr) {
						jQuery(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						jQuery(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						//jQuery(this).css('border','1px solid red');
						jQuery('#<?php echo $option_id; ?>_picker').children('div').css('backgroundColor', '#' + hex);
						jQuery('#<?php echo $option_id; ?>_picker').next('input').attr('value','#' + hex);
						
					}
				  });
			  <?php } } ?>
		 
		});
		
		</script> 
		<?php
		//AJAX Upload
		?>
		<script type="text/javascript" src="<?php echo get_bloginfo('template_directory'); ?>/functions/js/ajaxupload.js"></script>
		<script type="text/javascript">
			jQuery(document).ready(function(){
			
			var flip = 0;
				
			jQuery('#expand_options').click(function(){
				if(flip == 0){
					flip = 1;
					jQuery('#storefront_container #storefront-nav').hide();
					jQuery('#storefront_container #content').width(755);
					jQuery('#storefront_container .group').add('#storefront_container .group h2').show();
	
					jQuery(this).text('[-]');
					
				} else {
					flip = 0;
					jQuery('#storefront_container #storefront-nav').show();
					jQuery('#storefront_container #content').width(585);
					jQuery('#storefront_container .group').add('#storefront_container .group h2').hide();
					jQuery('#storefront_container .group:first').show();
					jQuery('#storefront_container #storefront-nav li').removeClass('current');
					jQuery('#storefront_container #storefront-nav li:first').addClass('current');
					
					jQuery(this).text('[+]');
				
				}
			
			});
			
				jQuery('.group').hide();
				jQuery('.group:first').fadeIn();
				
				jQuery('.group .collapsed').each(function(){
					jQuery(this).find('input:checked').parent().parent().parent().nextAll().each( 
						function(){
           					if (jQuery(this).hasClass('last')) {
           						jQuery(this).removeClass('hidden');
           						return false;
           					}
           					jQuery(this).filter('.hidden').removeClass('hidden');
           				});
           		});
           					
				jQuery('.group .collapsed input:checkbox').click(unhideHidden);
				
				function unhideHidden(){
					if (jQuery(this).attr('checked')) {
						jQuery(this).parent().parent().parent().nextAll().removeClass('hidden');
					}
					else {
						jQuery(this).parent().parent().parent().nextAll().each( 
							function(){
           						if (jQuery(this).filter('.last').length) {
           							jQuery(this).addClass('hidden');
									return false;
           						}
           						jQuery(this).addClass('hidden');
           					});
           					
					}
				}
				
				jQuery('.storefront-radio-img-img').click(function(){
					jQuery(this).parent().parent().find('.storefront-radio-img-img').removeClass('storefront-radio-img-selected');
					jQuery(this).addClass('storefront-radio-img-selected');
					
				});
				jQuery('.storefront-radio-img-label').hide();
				jQuery('.storefront-radio-img-img').show();
				jQuery('.storefront-radio-img-radio').hide();
				jQuery('#storefront-nav li:first').addClass('current');
				jQuery('#storefront-nav li a').click(function(evt){
				
						jQuery('#storefront-nav li').removeClass('current');
						jQuery(this).parent().addClass('current');
						
						var clicked_group = jQuery(this).attr('href');
		 
						jQuery('.group').hide();
						
							jQuery(clicked_group).fadeIn();
		
						evt.preventDefault();
						
					});
				
				if('<?php if(isset($_REQUEST['reset'])) { echo $_REQUEST['reset'];} else { echo 'false';} ?>' == 'true'){
					
					var reset_popup = jQuery('#storefront-popup-reset');
					reset_popup.fadeIn();
					window.setTimeout(function(){
						   reset_popup.fadeOut();                        
						}, 2000);
						//alert(response);
					
				}
					
			//Update Message popup
			jQuery.fn.center = function () {
				this.animate({"top":( jQuery(window).height() - this.height() - 200 ) / 2+jQuery(window).scrollTop() + "px"},100);
				this.css("left", 250 );
				return this;
			}
		
			
			jQuery('#storefront-popup-save').center();
			jQuery('#storefront-popup-reset').center();
			jQuery(window).scroll(function() { 
			
				jQuery('#storefront-popup-save').center();
				jQuery('#storefront-popup-reset').center();
			
			});
			
			
		
			//AJAX Upload
			jQuery('.image_upload_button').each(function(){
			
			var clickedObject = jQuery(this);
			var clickedID = jQuery(this).attr('id');	
			new AjaxUpload(clickedID, {
				  action: '<?php echo admin_url("admin-ajax.php"); ?>',
				  name: clickedID, // File upload name
				  data: { // Additional data to send
						action: 'storefront_ajax_post_action',
						type: 'upload',
						data: clickedID },
				  autoSubmit: true, // Submit file after selection
				  responseType: false,
				  onChange: function(file, extension){},
				  onSubmit: function(file, extension){
						clickedObject.text('Uploading'); // change button text, when user selects file	
						this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
						interval = window.setInterval(function(){
							var text = clickedObject.text();
							if (text.length < 13){	clickedObject.text(text + '.'); }
							else { clickedObject.text('Uploading'); } 
						}, 200);
				  },
				  onComplete: function(file, response) {
				   
					window.clearInterval(interval);
					clickedObject.text('Upload Image');	
					this.enable(); // enable upload button
					
					// If there was an error
					if(response.search('Upload Error') > -1){
						var buildReturn = '<span class="upload-error">' + response + '</span>';
						jQuery(".upload-error").remove();
						clickedObject.parent().after(buildReturn);
					
					}
					else{
						var buildReturn = '<img class="hide storefront-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';

						jQuery(".upload-error").remove();
						jQuery("#image_" + clickedID).remove();	
						clickedObject.parent().after(buildReturn);
						jQuery('img#image_'+clickedID).fadeIn();
						clickedObject.next('span').fadeIn();
						clickedObject.parent().prev('input').val(response);
					}
				  }
				});
			
			});
			
			//AJAX Remove (clear option value)
			jQuery('.image_reset_button').click(function(){
			
					var clickedObject = jQuery(this);
					var clickedID = jQuery(this).attr('id');
					var theID = jQuery(this).attr('title');	
	
					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
				
					var data = {
						action: 'storefront_ajax_post_action',
						type: 'image_reset',
						data: theID
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var image_to_remove = jQuery('#image_' + theID);
						var button_to_hide = jQuery('#reset_' + theID);
						image_to_remove.fadeOut(500,function(){ jQuery(this).remove(); });
						button_to_hide.fadeOut();
						clickedObject.parent().prev('input').val('');
						
						
						
					});
					
					return false; 
					
				});   	 	
	
	
		
			//Save everything else
			jQuery('#storefrontform').submit(function(){
				
					function newValues() {
					  var serializedValues = jQuery("#storefrontform").serialize();
					  return serializedValues;
					}
					jQuery(":checkbox, :radio").click(newValues);
					jQuery("select").change(newValues);
					jQuery('.ajax-loading-img').fadeIn();
					var serializedReturn = newValues();
					 
					var ajax_url = '<?php echo admin_url("admin-ajax.php"); ?>';
				
					 //var data = {data : serializedReturn};
					var data = {
						<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'storefrontthemes'){ ?>
						type: 'options',
						<?php } ?>


						action: 'storefront_ajax_post_action',
						data: serializedReturn
					};
					
					jQuery.post(ajax_url, data, function(response) {
						var success = jQuery('#storefront-popup-save');
						var loading = jQuery('.ajax-loading-img');
						loading.fadeOut();  
						success.fadeIn();
						window.setTimeout(function(){
						   success.fadeOut(); 
						   
												
						}, 2000);
					});
					
					return false; 
					
				});   	 	
				
			});
		</script>
		
	<?php }
}

/*-----------------------------------------------------------------------------------*/
/* Ajax Save Action - storefront_ajax_callback */
/*-----------------------------------------------------------------------------------*/

add_action('wp_ajax_storefront_ajax_post_action', 'storefront_ajax_callback');

function storefront_ajax_callback() {
	global $wpdb; // this is how you get access to the database
	
		
	$save_type = $_POST['type'];
	//Uploads
	if($save_type == 'upload'){
		
		$clickedID = $_POST['data']; // Acts as the name
		$filename = $_FILES[$clickedID];
       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
		
		$override['test_form'] = false;
		$override['action'] = 'wp_handle_upload';    
		$uploaded_file = wp_handle_upload($filename,$override);
		 
				$upload_tracking[] = $clickedID;
				update_option( $clickedID , $uploaded_file['url'] );
				
		 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
		 else { echo $uploaded_file['url']; } // Is the Response
	}
	elseif($save_type == 'image_reset'){
			
			$id = $_POST['data']; // Acts as the name
			global $wpdb;
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE '$id'";
			$wpdb->query($query);
	
	}	
	elseif ($save_type == 'options') {
		$data = $_POST['data'];
		
		parse_str($data,$output);
		//print_r($output);
		
		//Pull options
        	$options = get_option('smartestb_template');
				
		foreach($options as $option_array){

			if(isset($option_array['id'])) { 
				$id = $option_array['id'];
			}
			$old_value = get_option($id);
			$new_value = '';
			
			if(isset($output[$id])){
				$new_value = $output[$option_array['id']];
			}
	
			if(isset($option_array['id'])) { // Non - Headings...
				
				//Import of prior saved options
				if($id == 'framework_storefront_import_options'){
					
					//Decode and over write options.
					$new_import = $new_value;
					$new_import = unserialize($new_import);
					
					//echo '<pre>';
					//print_r($new_import);
					//echo '</pre>';
					if(!empty($new_import)) {
						foreach($new_import as $id2 => $value2){
							if(is_serialized($value2)) {
								update_option($id2,unserialize($value2));
							} else {
								update_option($id2,$value2);
							}
						}
					}
					
				} else {
			
					$type = $option_array['type'];
					
					if ( is_array($type)){
						foreach($type as $array){
							if($array['type'] == 'text'){
								$id = $array['id'];
								$new_value = $output[$id];
								update_option( $id, stripslashes($new_value));
							}
						}                 
					}
					elseif($new_value == '' && $type == 'checkbox'){ // Checkbox Save
						
						update_option($id,'false');
					}
					elseif ($new_value == 'true' && $type == 'checkbox'){ // Checkbox Save
						
						update_option($id,'true');
					}
					elseif($type == 'multicheck'){ // Multi Check Save
						
						$option_options = $option_array['options'];
						
						foreach ($option_options as $options_id => $options_value){
							
							$multicheck_id = $id . "_" . $options_id;
							
							if(!isset($output[$multicheck_id])){
							  update_option($multicheck_id,'false');
							}
							else{
							   update_option($multicheck_id,'true'); 
							}
						}
					} 
					elseif($type == 'typography'){
							
						$typography_array = array();	
						
						$typography_array['size'] = $output[$option_array['id'] . '_size'];
							
						$typography_array['face'] = stripslashes($output[$option_array['id'] . '_face']);
							
						$typography_array['style'] = $output[$option_array['id'] . '_style'];
							
						$typography_array['color'] = $output[$option_array['id'] . '_color'];
							
						update_option($id,$typography_array);
							
					}
					elseif($type == 'border'){
							
						$border_array = array();	
						
						$border_array['width'] = $output[$option_array['id'] . '_width'];
							
						$border_array['style'] = $output[$option_array['id'] . '_style'];
							
						$border_array['color'] = $output[$option_array['id'] . '_color'];
							
						update_option($id,$border_array);
							
					}
					elseif($type != 'upload_min'){
					
						update_option($id,stripslashes($new_value));
					}
				}
			}	
		}
	}
	
	
	if( $save_type == 'options'){
		/* Create, Encrypt and Update the Saved Settings */
		global $wpdb;
		//$options = get_option('smartestb_template');
		$storefront_options = array();
		$query_inner = '';
		$count = 0;

		print_r($options);
		foreach($options as $option){
			
			if(isset($option['id'])){ 
				$count++;
				$option_id = $option['id'];
				$option_type = $option['type'];
				
				if($count > 1){ $query_inner .= ' OR '; }
				
				if(is_array($option_type)) {
				$type_array_count = 0;
				foreach($option_type as $inner_option){
					$type_array_count++;
					$option_id = $inner_option['id'];
					if($type_array_count > 1){ $query_inner .= ' OR '; }
					$query_inner .= "option_name = '$option_id'";
					}
				}
				else {
				
					$query_inner .= "option_name = '$option_id'";
					
				}
			}
			
		}
		
		$query = "SELECT * FROM $wpdb->options WHERE $query_inner";
				
		$results = $wpdb->get_results($query);
		
		$output = "<ul>";
		
		foreach ($results as $result){
				$name = $result->option_name;
				$value = $result->option_value;
				
				if(is_serialized($value)) {
					
					$value = unserialize($value);
					$storefront_array_option = $value;
					$temp_options = '';
					foreach($value as $v){
						if(isset($v))
							$temp_options .= $v . ',';
						
					}	
					$value = $temp_options;
					$storefront_array[$name] = $storefront_array_option;
				} else {
					$storefront_array[$name] = $value;
				}
				
				$output .= '<li><strong>' . $name . '</strong> - ' . $value . '</li>';
		}
		$output .= "</ul>";
		
		update_option('smartestb_options',$storefront_array);
		update_option('smartestb_settings_encode',$output);
	
	}



  die();

}



/*-----------------------------------------------------------------------------------*/
/* Generates The Options - storefrontthemes_machine */
/*-----------------------------------------------------------------------------------*/

function storefrontthemes_machine($options) {
        
    $counter = 0;
	$menu = '';
	$output = '';
	foreach ($options as $value) {
	   
		$counter++;
		$val = '';
		//Start Heading
		 if ( $value['type'] != "heading" )
		 {
		 	$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
			//$output .= '<div class="section section-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
			$output .= '<div class="section section-'.$value['type'].' '. $class .'">'."\n";
			$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
			$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";

		 } 
		 //End Heading
		$select_value = '';                                   
		switch ( $value['type'] ) {
		
		case 'text':
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
			$output .= '<input class="storefront-input" name="'. $value['id'] .'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $val .'" />';
		break;
		
		case 'select':

			$output .= '<select class="storefront-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';
		
			$select_value = get_option($value['id']);
			 
			foreach ($value['options'] as $option) {
				
				$selected = '';
				
				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';} 
			     } else {
					 if ( isset($value['std']) )
						 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
				 }
				  
				 $output .= '<option'. $selected .'>';
				 $output .= $option;
				 $output .= '</option>';
			 
			 } 
			 $output .= '</select>';

			
		break;
		case 'select2':

			$output .= '<select class="storefront-input" name="'. $value['id'] .'" id="'. $value['id'] .'">';
		
			$select_value = get_option($value['id']);
			 
			foreach ($value['options'] as $option => $name) {
				
				$selected = '';
				
				 if($select_value != '') {
					 if ( $select_value == $option) { $selected = ' selected="selected"';} 
			     } else {
					 if ( isset($value['std']) )
						 if ($value['std'] == $option) { $selected = ' selected="selected"'; }
				 }
				  
				 $output .= '<option'. $selected .' value="'.$option.'">';
				 $output .= $name;
				 $output .= '</option>';
			 
			 } 
			 $output .= '</select>';

			
		break;
		case 'calendar':
		
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
            $output .= '<input class="storefront-input-calendar" type="text" name="'.$value['id'].'" id="'.$value['id'].'" value="'.$val.'">';
		
		break;
		case 'time':
			$val = $value['std'];
			$std = get_option($value['id']);
			if ( $std != "") { $val = $std; }
			$output .= '<input class="storefront-input-time" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
		break;
		case 'textarea':
			
			$cols = '8';
			$ta_value = '';
			
			if(isset($value['std'])) {
				
				$ta_value = $value['std']; 
				
				if(isset($value['options'])){
					$ta_options = $value['options'];
					if(isset($ta_options['cols'])){
					$cols = $ta_options['cols'];
					} else { $cols = '8'; }
				}
				
			}
				$std = get_option($value['id']);
				if( $std != "") { $ta_value = stripslashes( $std ); }
				$output .= '<textarea class="storefront-input" name="'. $value['id'] .'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';
			
			
		break;
		case "radio":
			
			 $select_value = get_option( $value['id']);
				   
			 foreach ($value['options'] as $key => $option) 
			 { 

				 $checked = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; } 
				   } else {
					if ($value['std'] == $key) { $checked = ' checked'; }
				   }
				$output .= '<input class="storefront-input storefront-radio" type="radio" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />' . $option .'<br />';
			
			}
			 
		break;
		case "checkbox": 
		
		   $std = $value['std'];  
		   
		   $saved_std = get_option($value['id']);
		   
		   $checked = '';
			
			if(!empty($saved_std)) {
				if($saved_std == 'true') {
				$checked = 'checked="checked"';
				}
				else{
				   $checked = '';
				}
			}
			elseif( $std == 'true') {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';
			}
			$output .= '<input type="checkbox" class="checkbox storefront-input" name="'.  $value['id'] .'" id="'. $value['id'] .'" value="true" '. $checked .' />';

		break;
		case "multicheck":
		
			$std =  $value['std'];         
			
			foreach ($value['options'] as $key => $option) {
											 
			$storefront_key = $value['id'] . '_' . $key;
			$saved_std = get_option($storefront_key);
					
			if(!empty($saved_std)) 
			{ 
				  if($saved_std == 'true'){
					 $checked = 'checked="checked"';  
				  } 
				  else{
					  $checked = '';     
				  }    
			} 
			elseif( $std == $key) {
			   $checked = 'checked="checked"';
			}
			else {
				$checked = '';                                                                                    }
			$output .= '<input type="checkbox" class="checkbox storefront-input" name="'. $storefront_key .'" id="'. $storefront_key .'" value="true" '. $checked .' /><label for="'. $storefront_key .'">'. $option .'</label><br />';
										
			}
		break;
		case "upload":
			
			$output .= storefrontthemes_uploader_function($value['id'],$value['std'],null);
			
		break;
		case "upload_min":
			
			$output .= storefrontthemes_uploader_function($value['id'],$value['std'],'min');
			
		break;
		case "color":
			$val = $value['std'];
			$stored  = get_option( $value['id'] );
			if ( $stored != "") { $val = $stored; }
			$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="storefront-color" name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $val .'" />';
		break;   
		
		case "typography":
		
			$default = $value['std'];
			$typography_stored = get_option($value['id']);
			
			/* Font Size */
			$val = $default['size'];
			if ( $typography_stored['size'] != "") { $val = $typography_stored['size']; }
			$output .= '<select class="storefront-typography storefront-typography-size" name="'. $value['id'].'_size" id="'. $value['id'].'_size">';
				for ($i = 9; $i < 71; $i++){ 
					if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; }
			$output .= '</select>';
			
			/* Font Unit 
			$val = $default['unit'];
			if ( $typography_stored['unit'] != "") { $val = $typography_stored['unit']; }
				$em = ''; $px = '';
			if($val == 'em'){ $em = 'selected="selected"'; }
			if($val == 'px'){ $px = 'selected="selected"'; }
			$output .= '<select class="storefront-typography storefront-typography-unit" name="'. $value['id'].'_unit" id="'. $value['id'].'_unit">';
			$output .= '<option value="px '. $px .'">px</option>';
			$output .= '<option value="em" '. $em .'>em</option>';
			$output .= '</select>';
			*/
			
			/* Font Face */
			/* Font Face */
			$val = $default['face'];
			if ( $typography_stored['face'] != "") 
				$val = $typography_stored['face']; 

			$font01 = ''; 
			$font02 = ''; 
			$font03 = ''; 
			$font04 = ''; 
			$font05 = ''; 
			$font06 = ''; 
			$font07 = ''; 
			$font08 = '';
			$font09 = ''; 
			$font10 = '';
			$font11 = '';
			$font12 = '';
			$font13 = '';
			$font14 = '';
			$font15 = '';

			if (strpos($val, 'Arial, sans-serif') !== false){ $font01 = 'selected="selected"'; }
			if (strpos($val, 'Verdana, Geneva') !== false){ $font02 = 'selected="selected"'; }
			if (strpos($val, 'Trebuchet') !== false){ $font03 = 'selected="selected"'; }
			if (strpos($val, 'Georgia') !== false){ $font04 = 'selected="selected"'; }
			if (strpos($val, 'Times New Roman') !== false){ $font05 = 'selected="selected"'; }
			if (strpos($val, 'Tahoma, Geneva') !== false){ $font06 = 'selected="selected"'; }
			if (strpos($val, 'Palatino') !== false){ $font07 = 'selected="selected"'; }
			if (strpos($val, 'Helvetica') !== false){ $font08 = 'selected="selected"'; }
			if (strpos($val, 'Calibri') !== false){ $font09 = 'selected="selected"'; }
			if (strpos($val, 'Myriad') !== false){ $font10 = 'selected="selected"'; }
			if (strpos($val, 'Lucida') !== false){ $font11 = 'selected="selected"'; }
			if (strpos($val, 'Arial Black') !== false){ $font12 = 'selected="selected"'; }
			if (strpos($val, 'Gill') !== false){ $font13 = 'selected="selected"'; }
			if (strpos($val, 'Geneva, Tahoma') !== false){ $font14 = 'selected="selected"'; }
			if (strpos($val, 'Impact') !== false){ $font15 = 'selected="selected"'; }
			
			$output .= '<select class="storefront-typography storefront-typography-face" name="'. $value['id'].'_face" id="'. $value['id'].'_face">';
			$output .= '<option value="Arial, sans-serif" '. $font01 .'>Arial</option>';
			$output .= '<option value="Verdana, Geneva, sans-serif" '. $font02 .'>Verdana</option>';
			$output .= '<option value="&quot;Trebuchet MS&quot;, Tahoma, sans-serif"'. $font03 .'>Trebuchet</option>';
			$output .= '<option value="Georgia, serif" '. $font04 .'>Georgia</option>';
			$output .= '<option value="&quot;Times New Roman&quot;, serif"'. $font05 .'>Times New Roman</option>';
			$output .= '<option value="Tahoma, Geneva, Verdana, sans-serif"'. $font06 .'>Tahoma</option>';
			$output .= '<option value="Palatino, &quot;Palatino Linotype&quot;, serif"'. $font07 .'>Palatino</option>';
			$output .= '<option value="&quot;Helvetica Neue&quot;, Helvetica, sans-serif" '. $font08 .'>Helvetica*</option>';
			$output .= '<option value="Calibri, Candara, Segoe, Optima, sans-serif"'. $font09 .'>Calibri*</option>';
			$output .= '<option value="&quot;Myriad Pro&quot;, Myriad, sans-serif"'. $font10 .'>Myriad Pro*</option>';
			$output .= '<option value="&quot;Lucida Grande&quot;, &quot;Lucida Sans Unicode&quot;, &quot;Lucida Sans&quot;, sans-serif"'. $font11 .'>Lucida</option>';
			$output .= '<option value="&quot;Arial Black&quot;, sans-serif" '. $font12 .'>Arial Black</option>';
			$output .= '<option value="&quot;Gill Sans&quot;, &quot;Gill Sans MT&quot;, Calibri, sans-serif" '. $font13 .'>Gill Sans*</option>';
			$output .= '<option value="Geneva, Tahoma, Verdana, sans-serif" '. $font14 .'>Geneva*</option>';
			$output .= '<option value="Impact, Charcoal, sans-serif" '. $font15 .'>Impact</option>';
			$output .= '</select>';
			
			/* Font Weight */
			$val = $default['style'];
			if ( $typography_stored['style'] != "") { $val = $typography_stored['style']; }
				$normal = ''; $italic = ''; $bold = ''; $bolditalic = '';
			if($val == 'normal'){ $normal = 'selected="selected"'; }
			if($val == 'italic'){ $italic = 'selected="selected"'; }
			if($val == 'bold'){ $bold = 'selected="selected"'; }
			if($val == 'bold italic'){ $bolditalic = 'selected="selected"'; }
			
			$output .= '<select class="storefront-typography storefront-typography-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
			$output .= '<option value="normal" '. $normal .'>Normal</option>';
			$output .= '<option value="italic" '. $italic .'>Italic</option>';
			$output .= '<option value="bold" '. $bold .'>Bold</option>';
			$output .= '<option value="bold italic" '. $bolditalic .'>Bold/Italic</option>';
			$output .= '</select>';
			
			/* Font Color */
			$val = $default['color'];
			if ( $typography_stored['color'] != "") { $val = $typography_stored['color']; }			
			$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="storefront-color storefront-typography storefront-typography-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';

		break;  
		
		case "border":
		
			$default = $value['std'];
			$border_stored = get_option( $value['id'] );
			
			/* Border Width */
			$val = $default['width'];
			if ( $border_stored['width'] != "") { $val = $border_stored['width']; }
			$output .= '<select class="storefront-border storefront-border-width" name="'. $value['id'].'_width" id="'. $value['id'].'_width">';
				for ($i = 0; $i < 21; $i++){ 
					if($val == $i){ $active = 'selected="selected"'; } else { $active = ''; }
					$output .= '<option value="'. $i .'" ' . $active . '>'. $i .'px</option>'; }
			$output .= '</select>';
			
			/* Border Style */
			$val = $default['style'];
			if ( $border_stored['style'] != "") { $val = $border_stored['style']; }
				$solid = ''; $dashed = ''; $dotted = '';
			if($val == 'solid'){ $solid = 'selected="selected"'; }
			if($val == 'dashed'){ $dashed = 'selected="selected"'; }
			if($val == 'dotted'){ $dotted = 'selected="selected"'; }
			
			$output .= '<select class="storefront-border storefront-border-style" name="'. $value['id'].'_style" id="'. $value['id'].'_style">';
			$output .= '<option value="solid" '. $solid .'>Solid</option>';
			$output .= '<option value="dashed" '. $dashed .'>Dashed</option>';
			$output .= '<option value="dotted" '. $dotted .'>Dotted</option>';
			$output .= '</select>';
			
			/* Border Color */
			$val = $default['color'];
			if ( $border_stored['color'] != "") { $val = $border_stored['color']; }			
			$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div></div></div>';
			$output .= '<input class="storefront-color storefront-border storefront-border-color" name="'. $value['id'] .'_color" id="'. $value['id'] .'_color" type="text" value="'. $val .'" />';

		break;   
		
		case "images":
			$i = 0;
			$select_value = get_option( $value['id']);
				   
			foreach ($value['options'] as $key => $option) 
			 { 
			 $i++;

				 $checked = '';
				 $selected = '';
				   if($select_value != '') {
						if ( $select_value == $key) { $checked = ' checked'; $selected = 'storefront-radio-img-selected'; } 
				    } else {
						if ($value['std'] == $key) { $checked = ' checked'; $selected = 'storefront-radio-img-selected'; }
						elseif ($i == 1  && !isset($select_value)) { $checked = ' checked'; $selected = 'storefront-radio-img-selected'; }
						elseif ($i == 1  && $value['std'] == '') { $checked = ' checked'; $selected = 'storefront-radio-img-selected'; }
						else { $checked = ''; }
					}	
				
				$output .= '<span>';
				$output .= '<input type="radio" id="storefront-radio-img-' . $value['id'] . $i . '" class="checkbox storefront-radio-img-radio" value="'.$key.'" name="'. $value['id'].'" '.$checked.' />';
				$output .= '<div class="storefront-radio-img-label">'. $key .'</div>';
				$output .= '<img src="'.$option.'" alt="" class="storefront-radio-img-img '. $selected .'" onClick="document.getElementById(\'storefront-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
				$output .= '</span>';
				
			}
		
		break; 
		
		case "info":
			$default = $value['std'];
			$output .= $default;
		break;                                   
		
		case "heading":
			
			if($counter >= 2){
			   $output .= '</div>'."\n";
			}
			$jquery_click_hook = ereg_replace("[^A-Za-z0-9]", "", strtolower($value['name']) );
			$jquery_click_hook = "storefront-option-" . $jquery_click_hook;
//			$jquery_click_hook = "storefront-option-" . str_replace("&","",str_replace("/","",str_replace(".","",str_replace(")","",str_replace("(","",str_replace(" ","",strtolower($value['name'])))))));
			$menu .= '<li><a class="'.  $value['class'] .'" title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'"><span class="storefront-nav-icon"></span>'.  $value['name'] .'</a></li>';
			$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
		break;                                  
		} 
		
		// if TYPE is an array, formatted into smaller inputs... ie smaller values
		if ( is_array($value['type'])) {
			foreach($value['type'] as $array){
			
					$id =   $array['id']; 
					$std =   $array['std'];
					$saved_std = get_option($id);
					if($saved_std != $std && !empty($saved_std) ){$std = $saved_std;} 
					$meta =   $array['meta'];
					
					if($array['type'] == 'text') { // Only text at this point
						 
						 $output .= '<input class="input-text-small storefront-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';  
						 $output .= '<span class="meta-two">'.$meta.'</span>';
					}
				}
		}
		if ( $value['type'] != "heading" ) { 
			if ( $value['type'] != "checkbox" ) 
				{ 
				$output .= '<br/>';
				}
			if(!isset($value['desc'])){ $explain_value = ''; } else{ $explain_value = $value['desc']; } 
			$output .= '</div><div class="explain">'. $explain_value .'</div>'."\n";
			$output .= '<div class="clear"> </div></div></div>'."\n";
			}
	   
	}
    $output .= '</div>';
    return array($output,$menu);

}



/*-----------------------------------------------------------------------------------*/
/* storefrontThemes Uploader - storefrontthemes_uploader_function */
/*-----------------------------------------------------------------------------------*/

function storefrontthemes_uploader_function($id,$std,$mod){

    //$uploader .= '<input type="file" id="attachement_'.$id.'" name="attachement_'.$id.'" class="upload_input"></input>';
    //$uploader .= '<span class="submit"><input name="save" type="submit" value="Upload" class="button upload_save" /></span>';
    
	$uploader = '';
    $upload = get_option($id);
	
	if($mod != 'min') { 
			$val = $std;
            if ( get_option( $id ) != "") { $val = get_option($id); }
            $uploader .= '<input class="storefront-input" name="'. $id .'" id="'. $id .'_upload" type="text" value="'. $val .'" />';
	}
	
	$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">Upload Image</span>';
	
	if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
	
	$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">Remove</span>';
	$uploader .='</div>' . "\n";
    $uploader .= '<div class="clear"></div>' . "\n";
	if(!empty($upload)){
		//$upload = cleanSource($upload); // Removed since V.2.3.7 it's not showing up
    	$uploader .= '<a class="storefront-uploaded-image" href="'. $upload . '">';
    	$uploader .= '<img class="storefront-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
    	$uploader .= '</a>';
		}
	$uploader .= '<div class="clear"></div>' . "\n"; 


return $uploader;
}
?>