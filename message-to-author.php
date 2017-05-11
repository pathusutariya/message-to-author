<?php


/**
 * Plugin Name: Message to Auther
 * Plugin URI:  https://wordpress.org/plugins/message-to-author
 * Description: Just Message/feedback/query to Auther, You can Also ask for product to seller with woocommerce | enable from settings or use shortcode [message2author] for adding messagebox
 * Author:      Parth Sutariya
 * Version:     2.0.2
 * Author URI:  http://github.com/pathusutariya
 * License:     GPLv2+
 * Text Domain: message-to-author
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require 'admin/admin.php';
require 'functions/functions.php';

// On Active plugin   creation of database table
register_activation_hook( __FILE__ , 'm2a_activate' );


// this function is postponded to next version
register_uninstall_hook( __FILE__ , 'm2a_uninstall' );

?>