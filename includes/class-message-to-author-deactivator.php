<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://codelab7.com
 * @since      1.0.0
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Message_To_Author
 * @subpackage Message_To_Author/includes
 * @author     pathusutariya <pathusutariya@gmail.com>
 */
class Message_To_Author_Deactivator {

	/**
	 * Delete Table.
	 *
	 * Dropping Existing table from it
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'm2a_message';
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
        delete_option('m2a_settings');
	}

}
