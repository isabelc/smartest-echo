<?php
add_action('init','storefront_options');  
function storefront_options(){

$themename = wp_get_theme();
$shortname = "smartestb";

// Populate storefrontThemes option in array for use in theme
global $storefront_options;
$storefront_options = get_option('smartestb_options');

$GLOBALS['template_path'] = get_bloginfo('template_directory');

$options_slide_interval = array("300","400","500","600","700","800","900","1000","1100","1200","1300","1400","1500","1600","1700","1800","1900","2000");

$animationspeeds = array("300","400","500","600","700","800","900","1000","1100","1200","1300","1400","1500","1600","1700","1800","1900","2000");

$transspeeds = array("1","2","3","4","5","6","7","8","9","10","11","12","13","14","15");

// Select box border-radius
$options_pixels = array("0px","1px","2px","3px","4px","5px","6px","7px","8px","9px","10px","11px","12px","13px","14px","15px","16px","17px","18px","19px","20px");

//More Options
$all_uploads_path = get_bloginfo('url') . '/wp-content/uploads/';
$all_uploads = get_option('smartestb_uploads');
$other_entries = array("Select a number:","0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
// THESE ARE THE DIFFERENT FIELDS
$options = array();

	$options[] = array( "name" => "Welcome","class" => "settings",
						"type" => "heading");
	
	$options[] = array( "name" => "<strong>Welcome to Storefront Echo!</strong>",
						"type" => "info",
						"std" => "<p>To get started, first click the 'Save all Changes' button to save the theme defaults. Good luck creating your site and don't forget to let us know once you're done at the <a href='http://storefrontthemes.com/showcase'  target='blank'>Storefront Themes Showcase!</a></p></ul>");

/*
======================
Style
======================
*/

$options[] = array( "name" => "Style","class" => "style",
					"type" => "heading");
					
$options[] = array( "name" =>  "Site Background Color",
					"desc" => "Customize your site's background color.",
					"id" => $shortname."_bg_color",
					"std" => "",
					"type" => "color");

$options[] = array( "name" => "Background Texture",
					"desc" => "Select a texture for your site background. This will appear above the background color you set above.<br /><strong>NOTE: Some textures may require a darker background color to show up well.</strong>",
					"id" => $shortname."_bg_texture",
					"std" => "sand",
					"type" => "select",
					"options" => array("none", "sand", "speckled", "crosshatch", "wood", "carpet") );
					
$options[] = array( "name" => "Background Image",
					"desc" => "Upload a background image, or specify the image address of your image. (http://yoursite.com/image.png). <strong>NOTE: You must select 'None' for your texture above for this to take effect.</strong>",
					"id" => $shortname."_bg_image",
					"std" => "",
					"type" => "upload");
					
$options[] = array( "name" => "Fix Background Image?",
					"desc" => "Check this if you want the background image to be fixed (no scrolling).",
					"id" => $shortname."_bg_image_fixed",
					"std" => "false",
					"type" => "checkbox");

$options[] = array( "name" => "Background Image Repeat",
					"desc" => "Select how you want your background image to display.",
					"id" => $shortname."_bg_image_repeat",
					"type" => "select",
					"options" => array("No Repeat" => "no-repeat", "Repeat" => "repeat","Repeat Horizontally" => "repeat-x", "Repeat Vertically" => "repeat-y", "Fixed" => "fixed",) );
					
$options[] = array( "name" => "Background Image Position",
					"desc" => "Select how you want your background image to be aligned.",
					"id" => $shortname."_bg_image_position",
					"type" => "select",
					"options" => array("Top Left" => "top left", "Top Right" => "top right", "Top Center" => "top center", "Bottom Left" => "bottom left", "Bottom Right" => "bottom right", "Bottom Center" => "bottom center",) );
					
$options[] = array( "name" => "Container Shadow",
                    "desc" => "Specify the radius in pixels of your container shadow (default is 4px).",
                    "id" => $shortname."_container_shadow_radius",
                    "std" => "",
                    "type" => "text");
					
$options[] = array( "name" => "Custom CSS",
                    "desc" => "Quickly add some CSS to your theme by adding it to this block.",
                    "id" => $shortname."_custom_css",
                    "std" => "",
                    "type" => "textarea");
					
/*
======================
Colors
======================
*/

$options[] = array( "name" => "Colors","class" => "colors",
					"type" => "heading");
					
$options[] = array( "name" => "Button Color",
					"desc" => "Select a color for the base of your gradient buttons.</strong>",
					"id" => $shortname."_button_color",
					"std" => "sand",
					"type" => "select",
					"options" => array("blue", "green", "red", "orange", "pink", "grey") );  
					
$options[] = array( "name" =>  "Frame Shadows Color",
					"desc" => "Customize color of the shadows around the main content frames (navigation bar, main site frame).",
					"id" => $shortname."_frame_shadow_color",
					"std" => "",
					"type" => "color");

$options[] = array( "name" =>  "Main Text Color",
					"desc" => "Customize the color of your main site text.",
					"id" => $shortname."_text_color",
					"std" => "",
					"type" => "color");

$options[] = array( "name" =>  "Links",
					"desc" => "Customize the color of links.",
					"id" => $shortname."_link_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" =>  "Nav Text",
					"desc" => "Customize the color of the navigation bar text.",
					"id" => $shortname."_nav_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" =>  "Bottom Content Text",
					"desc" => "Customize the color of text in the bottom content section (widgetized areas).",
					"id" => $shortname."_bottom_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" =>  "Bottom Content Links",
					"desc" => "Customize the color of links in the bottom content section (widgetized areas).",
					"id" => $shortname."_bottom_link_color",
					"std" => "",
					"type" => "color");

$options[] = array( "name" =>  "Footer Text",
					"desc" => "Customize the color of the footer text.",
					"id" => $shortname."_footer_color",
					"std" => "",
					"type" => "color");
					
$options[] = array( "name" =>  "Footer Links",
					"desc" => "Customize the color of the footer text.",
					"id" => $shortname."_footer_link_color",
					"std" => "",
					"type" => "color");
					

/*
======================
Homepage Slider
======================
*/

$options[] = array( "name" => "Homepage Slider","class" => "home",
					"type" => "heading");
					
$options[] = array( "name" => "Show Slider?",
					"desc" => "Check this if you want to show the slider on your homepage.",
					"id" => $shortname."_show_slider",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => "Homepage Slider Height",
                    "desc" => "Please specify a height in pixels for your slider images. The slider width is 960px. Your slider images will need to be a minimum of this size to look correct.",
                    "id" => $shortname."_slider_height",
                    "std" => "365",
                    "type" => "text");

$options[] = array( "name" => "Slider Transition Speed",
                    "desc" => "How many seconds do you want to pause on each slide?.",
                    "id" => $shortname."_slider_trans_speed",
                    "std" => "5",
                    "type" => "select",
                    "options" => $transspeeds);
                    
$options[] = array( "name" => "Slider Animation Speed",
                    "desc" => "How fast do you want the transition between images to be? (in milliseconds)",
                    "id" => $shortname."_slider_anim_speed",
                    "std" => "500",
                    "type" => "select",
                    "options" => $animationspeeds);

/*
======================
Footer
======================
*/

$options[] = array( "name" => "Footer","class" => "footer",
					"type" => "heading");
					
$options[] = array( "name" => "Footer Text",
                    "desc" => "Add some text and basic html (strong, a, em, etc) here for the footer area.",
                    "id" => $shortname."_footer_text",
                    "std" => "",
                    "type" => "textarea");
					
/*
======================
Blog
======================
*/

$options[] = array( "name" => "Blog Settings","class" => "blog",
					"type" => "heading");
					
/* $options[] = array( "name" => "Default Blog Layout",
					"desc" => "Select which page layout you would like for your blog and archive pages.",
					"id" => $shortname."_blog_layout",
					"type" => "select",
					"std" => "Right Sidebar",
                    "options" => array("Right Sidebar", "Left Sidebar", "3 Column", "Full Width") );
                    
$options[] = array( "name" => "Single Blog Post Layout",
					"desc" => "Select which page layout you would like for your single blog posts.",
					"id" => $shortname."_blog_single_layout",
					"type" => "select",
					"std" => "Right Sidebar",
                    "options" => array("Right Sidebar", "Left Sidebar", "3 Column", "Full Width") );*/
                    
$options[] = array( "name" => "Blog Entry Content",
					"desc" => "Choose to show either the full post or an excerpt from each entry on the main blog page.",
					"id" => $shortname."_blog_content",
					"type" => "select",
					"options" => array("Full Post" => "Full Post", "Excerpt" => "Excerpt") );
					
$options[] = array( "name" => "Show Blog Author Section?",
					"desc" => "Check this to show the post author, avatar and description at the bottom of single posts.",
					"id" => $shortname."_blog_author_section",
					"std" => "true",
					"type" => "checkbox");
					
$options[] = array( "name" => "Blog Thumbnail Height",
					"desc" => "You can set your blog thumbnail image height here in pixels.  If this area is left blank, a default image height of 200px is used.",
					"id" => $shortname."_blog_image_height",
					"std" => "200",
					"type" => "text");
					
$options[] = array( "name" => "Blog Thumbnail Width",
					"desc" => "You can set your blog thumbnail image width here in pixels.  If this area is left blank, a default image width of 200px is used.",
					"id" => $shortname."_blog_image_width",
					"std" => "200",
					"type" => "text");
					
$options[] = array( "name" => "Featured Image Height",
					"desc" => "You can set your blog thumbnail image height here in pixels.  If this area is left blank, a default image height of 200px is used.",
					"id" => $shortname."_featured_image_height",
					"std" => "200",
					"type" => "text");
					
$options[] = array( "name" => "Featured Image Width",
					"desc" => "You can set your blog thumbnail image width here in pixels.  If this area is left blank, a default image width of 200px is used.",
					"id" => $shortname."_featured_image_width",
					"std" => "200",
					"type" => "text"); 

//endif;                                                           
update_option('smartestb_template',$options);      
update_option('smartestb_themename',$themename);   
update_option('smartestb_shortname',$shortname);
}
?>