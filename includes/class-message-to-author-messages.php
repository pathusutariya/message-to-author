<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codelab7.com
 * @since      1.0.0
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/public
 * @author     pathusutariya <pathusutariya@gmail.com>
 */
class Message_To_Author_Messages {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    3.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The Options for the plugin to decide behaviours
	 * @since 3.1.0
	 */
	private $options;

	/**
	 * Message array to save post author id and many more
	 */
	private $message;

	/**
	 * Message ID
	 */
	private $message_id;

	private $table_name = MESSAGE_TO_AUTHOR_TABLE;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Setting up Message Array
	 *
	 * @param $postid int Post ID
	 * @param $subject string Subject of message
	 * @param $message string origional message
	 * @param $sender mixed email id or user_id
	 */
	public function setMessage( $postid, $subject, $message, $sender ) {
		$this->message = array(
			'sender'    => $sender,
			'author_id' => (int) get_post_field( 'post_author', $postid ),
			'post_id'   => (int) $postid,
			'subject'   => $subject,
			'message'   => $message
		);
	}

	public function save() {
		if ( $this->_validate() ) {
			global $wpdb;
			$wpdb->insert( $this->table_name, $this->message );
			$this->message_id = $wpdb->insert_id;

			return true;
		}

		return false;
	}

	public function getMessages() {
		global $wpdb;
		$userid = get_current_user_id();

		if ( current_user_can( 'moderate_comments' ) )
			return $wpdb->get_results( "SELECT * FROM $this->table_name" );
		elseif ( is_author() )
			return $wpdb->get_results( "SELECT * FROM $this->table_name WHERE author_id = $userid" );

		return false;
	}

	private function _validate() {
		$flag = true;
		if ( ! is_int( $this->message['sender'] ) && ! is_email( $this->message['sender'] ) )
			$flag = false;
		if ( ! is_string( $this->message['subject'] ) && ! is_string( $this->message['message'] ) )
			$flag = false;

		return $flag;
	}

	public function sendEmailTo( $to ) {
		if ( $to != 'author' && $to != 'sender' ) {
			return false;
		}

		$post_title = get_the_title( $this->message_id );
		$site_name  = get_bloginfo( 'url' );

		if ( is_int( $this->message['sender'] ) ) {
			$senderEmail = get_userdata( $this->message['sender'] )->user_email;
		} else {
			$senderEmail = $this->message['sender'];
		}

		if ( $to = 'author' ) {
			$sendTo  = get_userdata( $this->message['author_id'] )->user_email;
			$message = "You have a message from {$senderEmail}<br/>  Subject: {$this->message['sender']}<br/>Message: {$this->message['message']}  - <a href='{$site_name}'>{$site_name}</a>";
		} elseif ( $to = 'sender' ) {
			$sendTo  = $senderEmail;
			$message = "You sent message successfully<br/>  Subject: {$this->message['sender']}<br/>Message: {$this->message['message']}<br/> -<a href='{$site_name}'>{$site_name}</a>";
		}
		$subject = "Message on {$post_title}";
		wp_mail( $sendTo, $subject, $message, array( 'Content-Type: text/html; charset=UTF-8' ) );
	}

}
