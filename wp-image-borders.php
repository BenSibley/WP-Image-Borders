<?php
/*
Plugin Name: WP Image Borders
Version: 1.5.3
Description: WP Image Borders makes it easy to add or remove image borders from pictures in your blog posts.
Author: Compete Themes
Author URI: https://www.competethemes.com
License: GPLv2
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Image Borders WordPress Plugin, Copyright 2015 Compete Themes
WP Image Borders is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// prevent direct access
if ( ! defined( 'ABSPATH' ) ) exit;

// set constant for main plugin file
if ( ! defined( 'BS_WIB_FILE' ) ) {
	define( 'BS_WIB_PRO_FILE', __FILE__ );
}

// set constant for plugin directory
if ( ! defined( 'BS_WIB_PRO_PATH' ) ) {
	define( 'BS_WIB_PRO_PATH', plugin_dir_path( BS_WIB_PRO_FILE ) );
}

// set constant for plugin url
if ( ! defined( 'BS_WIB_PRO_URL' ) ) {
	define( 'BS_WIB_PRO_URL', plugin_dir_url( __FILE__ ) );
}

// set constant for plugin basename
if ( ! defined( 'BS_WIB_PRO_BASENAME' ) ) {
	define( 'BS_WIB_PRO_BASENAME', plugin_basename( BS_WIB_PRO_FILE ) );
}

// require colors (needs to be before customizer.php)
require_once( BS_WIB_PRO_PATH . 'inc/options.php' );

// Add settings link on plugin page
function bs_wib_settings_link($links) {

	// set url
	$link = admin_url('options-general.php?page=wp-image-borders.php');

	// set link markup
	$settings_link = '<a href="' . esc_url( $link ) . '">Settings</a>';

	// add settings link to plugin's links
	array_unshift($links, $settings_link);

	// return the links
	return $links;
}
add_filter("plugin_action_links_wp-image-borders/wp-image-borders.php", 'bs_wib_settings_link' );

// add menu
function bs_wib_add_page() {
    add_options_page( 
        'WP Image Borders Options', // Page Title
        'WP Image Borders', // Title of Menu
        'manage_options', // capability level
        'wp-image-borders', // Menu slug
        'wp_image_borders_options_content' // callback function
    );
}
add_action('admin_menu', 'bs_wib_add_page');

// creates content in options page and calls settings sections & fields
function wp_image_borders_options_content() {
    ?>
    <div class="wrap">
        <?php screen_icon( 'themes' ); ?>
        <h2>WP Image Borders Options</h2>
        <form action="options.php" method="post">
            <?php settings_fields( 'wp_image_borders_options' ); ?>
            <?php do_settings_sections( 'wp-image-borders' ); ?>
            <input class="button-primary" name="Submit" type="submit" value="<?php esc_attr_e( 'Save Changes' ); ?>" />
        </form>
        <p>If you liked this plugin, please take <a href="http://wordpress.org/support/view/plugin-reviews/wp-image-borders">1 minute to leave a review</a>.</p>
    </div><?php 
}



// add the wp-image-borders class to the post container if the post_checkbox is checked
function bs_wib_add_post_class($classes) {

    // access the plugin options
    $options = get_option( 'wp_image_borders_options' );

    // if the checkbox is not empty and is checked, add the wp-image-borders class
    if ( 1 == $options['bs_wib_post_checkbox'] ) {
        $classes[] = "wp-image-borders";
    }
    return $classes;
}
add_filter('post_class', 'bs_wib_add_post_class');

function bs_wib_output_styles() {

    // access plugin options
    $options = get_option( 'wp_image_borders_options' );

    // create $css variable
    $css = '';

	// access the plugin options
	$options = get_option( 'wp_image_borders_options' );

	// if the classes section isn't empty
	if( $options['bs_wib_classes'] ) {

		// add the classes to the beginning of the output
		$css .= $options['bs_wib_classes'] . ',';
	}

    wp_enqueue_style( 'wp-image-borders-styles', plugins_url( 'wp-image-borders.css' , __FILE__ ) );

	// add all the selectors need to precisely select all images
	$css .= '
		.wp-image-borders .alignright,
		.wp-image-borders .alignleft,
		.wp-image-borders .aligncenter,
		.wp-image-borders .alignnone,
		.wp-image-borders .size-auto,
		.wp-image-borders .size-full,
		.wp-image-borders .size-large,
		.wp-image-borders .size-medium,
		.wp-image-borders .size-thumbnail,
		.wp-image-borders .alignright img,
		.wp-image-borders .alignleft img,
		.wp-image-borders .aligncenter img,
		.wp-image-borders .alignnone img,
		.wp-image-borders .size-auto img,
		.wp-image-borders .size-full img,
		.wp-image-borders .size-large img,
		.wp-image-borders .size-medium img,
		.wp-image-borders .size-thumbnail img';
	$css .= ' {
	   border-style: ' . $options["bs_wib_border_style"] . ' !important;
	   border-width: ' . $options["bs_wib_border_width"] . 'px !important;
	   border-radius: ' . $options["bs_wib_border_radius"] . 'px !important;
	   border-color: ' . $options["bs_wib_border_color"] . ' !important;
	   -moz-box-shadow: ' . $options["bs_wib_box_shadow_horizontal"] . 'px ' . $options["bs_wib_box_shadow_vertical"] . 'px ' . $options["bs_wib_box_shadow_blur"] . 'px ' . $options["bs_wib_box_shadow_spread"] . 'px ' . $options["bs_wib_box_shadow_color"] . ' !important;
	   -webkit-box-shadow: ' . $options["bs_wib_box_shadow_horizontal"] . 'px ' . $options["bs_wib_box_shadow_vertical"] . 'px ' . $options["bs_wib_box_shadow_blur"] . 'px ' . $options["bs_wib_box_shadow_spread"] . 'px ' . $options["bs_wib_box_shadow_color"] . ' !important;
	   box-shadow: ' . $options["bs_wib_box_shadow_horizontal"] . 'px ' . $options["bs_wib_box_shadow_vertical"] . 'px ' . $options["bs_wib_box_shadow_blur"] . 'px ' . $options["bs_wib_box_shadow_spread"] . 'px ' . $options["bs_wib_box_shadow_color"] . ' !important;
   }';

    wp_add_inline_style('wp-image-borders-styles',$css);
}
add_action('wp_enqueue_scripts','bs_wib_output_styles');

// sanitizes the inputs from the options pages and outputs clean data
// ONLY does one checkbox right now
function bs_wib_validation( $input ) {
    
    // Create our array for storing the validated options
    $output = array();
    
    // Loop through each of the incoming options 
    foreach( $input as $key => $value ) {
    
        // Check to see if the current option has a value. If so, process it.  
        if( isset( $input[$key] ) ) {
        
            // Strip all HTML and PHP tags and properly handle quoted strings
            $output[$key] = strip_tags( stripslashes( $input[$key] ) );
        
        } // end if
    
    } // end foreach
    
    // Return the array processing any additional functions filtered by this action
    return apply_filters( 'bs_wib_validation', $output, $input );
}

?>