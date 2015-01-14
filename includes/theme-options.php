<?php
add_action('init','storefront_options');  
function storefront_options(){

$themename = wp_get_theme();
$shortname = "smartestb";

// Populate storefrontThemes option in array for use in theme
global $storefront_options;
$storefront_options = get_option('smartestb_options');

$GLOBALS['template_path'] = get_bloginfo('template_directory');

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