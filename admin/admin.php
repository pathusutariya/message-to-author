<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<?php

// for future use
function m2a_uninstall() {
    //option for dropping table
}

function m2a_admin_settings_page() {
    add_menu_page('message to author', 'm2a', 'edit_posts', 'm2a-message', 'm2a_messagePage', 'dashicons-email', 80);
    add_submenu_page('m2a-message', 'Message to author Settings', 'Settings', 'manage_options', 'm2a-settings', 'm2a_settings');
}
add_action('admin_menu', 'm2a_admin_settings_page');


//render all html table
function m2a_messagePage() {
    global $wpdb;
    $table_name      = $wpdb->prefix . 'm2a_message';
    $userid = get_current_user_id();
    
    if(get_userdata($userid)->roles[0] == 'administrator'){
        $messages = $wpdb->get_results( "SELECT * FROM $table_name" );
    }elseif(get_userdata($userid)->roles[0] == 'author'){
        $messages = $wpdb->get_results( "SELECT * FROM $table_name WHERE author_id = $userid" );
    }
    
    
    require 'admin_message.php';
}



//setting option page setting
function m2a_register_settings() {
    register_setting('m2a_setting_options', 'm2a_setting');
}
add_action('admin_init', 'm2a_register_settings');

//echo option page for admin
function m2a_settings() {
    require 'option_page.php';
}


//create activation table
function m2a_activate() {
    /*
     * Database Name:   used by wordpress 
     * table Name:  {prefix}m2a_messages
     * creating fields for     userid, authorid, postid, subject and message
     */

    global $wpdb;
    $table_name      = $wpdb->prefix . 'm2a_message';
    $charset_collate = $wpdb->get_charset_collate();
    $sql             = "CREATE TABLE $table_name (
		id int(9) NOT NULL AUTO_INCREMENT,
                time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
		user_id varchar(255) NOT NULL,
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
       "nonuser"                => "1",
       "showas"                 => "messagebox",
       "googlecaptchapublickey" => "",
       "googlecaptchasecretkey" => "",
    );
    add_option('m2a_setting', $defultoptions);
}

?>