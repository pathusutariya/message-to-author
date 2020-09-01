<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://codelab7.com
 * @since      1.0.0
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Message_To_Author
 * @subpackage Message_To_Author/admin
 * @author     pathusutariya <pathusutariya@gmail.com>
 */
class Message_To_Author_Admin {

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
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The Object for Messaging System
	 * @since 3.1.0
	 */
	private $messages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->messages    = new Message_To_Author_Messages( $plugin_name, $version );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Message_To_Author_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Message_To_Author_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_register_style( $this->plugin_name . '-admin', plugin_dir_url( __FILE__ ) . 'css/message-to-author-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Message_To_Author_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Message_To_Author_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/message-to-author-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function m2a_admin_settings_page() {
		add_menu_page( 'Message to Author', 'M2 Author', 'edit_posts', 'm2a-message', array( $this, 'all_messages' ), 'dashicons-email', 80 );
		add_submenu_page( 'm2a-message', 'Author\'s Messages', 'Messages', 'edit_posts', 'm2a-message', array( $this, 'all_messages' ) );
		add_submenu_page( 'm2a-message', 'M2A Settings', 'Settings', 'manage_options', 'm2a-settings', array( $this, 'settings_page' ) );
	}

	public function all_messages() {
		wp_enqueue_style( $this->plugin_name . '-admin' );
		$messages = $this->messages->getMessages();
        require plugin_dir_path( __FILE__ ) . 'partials/admin_message.php';

	}

	public function settings_page() {
		add_settings_section( 'Message to Author', 'Message to Author', false, 'm2a-settings' );
		require plugin_dir_path( __FILE__ ) . 'partials/m2a-admin-settings-display.php';
	}

	public function m2a_register_settings() {
		register_setting( 'm2a_setting_options', 'm2a_settings' );
	}

}
