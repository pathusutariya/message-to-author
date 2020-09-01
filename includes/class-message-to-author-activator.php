<?php

/**
 * Fired during plugin activation
 *
 * @link       https://codelab7.com
 * @since      1.0.0
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Message_To_Author
 * @subpackage Message_To_Author/includes
 * @author     pathusutariya <pathusutariya@gmail.com>
 */
class Message_To_Author_Activator
{

    /**
     * Creating Table. (use period)
     *
     * Database Name:   used by wordpress
     * table Name:  {prefix}m2a_messages
     * creating fields for     userid, authorid, postid, subject and message
     *
     * @since    1.0.0
     */
    public static function activate()
    {
        global $wpdb;
        $table_name = MESSAGE_TO_AUTHOR_TABLE;
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
    id int(9) NOT NULL AUTO_INCREMENT,
    time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    sender varchar(255) NOT NULL,
    author_id int(9) NOT NULL,
    post_id int(9) NOT NULL,
    subject varchar(255) NOT NULL,
    message text NULL,
    PRIMARY KEY (`id`)
    )" . $charset_collate;

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');
        dbDelta($sql);

        //adding defult options for managing plugin
        $defultoptions = array(
            "aftercontent"           => 0,
            "nonuser"                => "0",
            "showas"                 => "messagebox",
            "googlecaptcha"          => "0",
            "googlecaptchapublickey" => "",
            "googlecaptchasecretkey" => "",
        );
        add_option('m2a_settings', $defultoptions);
    }
}
