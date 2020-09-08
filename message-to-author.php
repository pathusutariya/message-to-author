<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Message To Author
 * Plugin URI:        #
 * Description:       Send a message from post to author with message management
 * Version:           4.0.0
 * Author:            Codelab7
 * Author URI:        https://codelab7.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       M2A
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if( !defined('WPINC')){
	die;
}

define('M2A_DIR', plugin_dir_path(__FILE__));
define('M2A_NAME', plugin_basename(__FILE__));
define('M2A_VERSION', '1.0.0');

function activate_M2A(){
	require_once M2A_DIR.'includes/M2A_Activator.php';
	M2A_Activator::activate();
}

function deactivate_M2A(){
	require_once M2A_DIR.'includes/M2A_Deactivator.php';
	M2A_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_M2A');
register_deactivation_hook(__FILE__, 'deactivate_M2A');

require plugin_dir_path(__FILE__).'includes/M2A.php';

function run_M2A(){
	$plugin = new M2A();
	$plugin->run();
}

run_M2A();
