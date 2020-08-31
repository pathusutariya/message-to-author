<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://codelab7.com
 * @since             1.0.0
 * @package           Message_To_Author
 *
 * @wordpress-plugin
 * Plugin Name:       Message To Auhtor
 * Plugin URI:        https://wordpress.org/plugins/message-to-author/
 * Description:       Just Message/feedback/query to Auther, You can Also ask for product to seller with woocommerce | enable from settings or use shortcode [message2author] for adding messagebox
 * Version:           3.1.0
 * Author:            Parth Sutariya
 * Author URI:        https://codelab7.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       message-to-author
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MESSAGE_TO_AUTHOR_VERSION', '3.0.1' );

global $wpdb;
/**
 * Table name
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'MESSAGE_TO_AUTHOR_TABLE', $wpdb->prefix . 'm2a_message' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-message-to-author-activator.php
 */
function activate_message_to_author() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-message-to-author-activator.php';
	Message_To_Author_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-message-to-author-deactivator.php
 */
function deactivate_message_to_author() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-message-to-author-deactivator.php';
	Message_To_Author_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_message_to_author' );
register_deactivation_hook( __FILE__, 'deactivate_message_to_author' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-message-to-author.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_message_to_author() {

	$plugin = new Message_To_Author();
	$plugin->run();

}
run_message_to_author();
