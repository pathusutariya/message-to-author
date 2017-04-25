<?php


/**
 * Plugin Name: Message to Auther
 * Plugin URI:  https://www.pathusutariya.blogspot.com
 * Description: Just Message/feedback/query to Auther, You can Also ask for product to seller with woocommerce | USE shortcode -> [m2a_message_button]button text[/m2a_message_button] for put messaging button And [m2a_deshboard] for deshboard 
 * Author:      Parth Sutariya
 * Version:     1.0.1
 * Author URI: http://www.facebook.com/parth.sutariya
 * License:     GPLv2+
 * Text Domain: message-to-author
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require 'admin/admin.php';
require 'functions/functions.php';

// On Active plugin   creation of database table
register_activation_hook( __FILE__ , 'm2a_activate' );


// this function is postponded to next version
register_uninstall_hook( __FILE__ , 'm2a_uninstall' );

function vardump($input){
	echo '<pre>';
	print_r($input);
	echo '</pre>';
}
?>