<?php

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
class Message_To_Author_Public {

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
	 * The Object for Messaging System
	 * @since 3.1.0
	 */
	private $messages;

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
		$this->options     = get_option( 'm2a_settings' );
		$this->messages    = new Message_To_Author_Messages( $plugin_name, $version );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/message-to-author-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/message-to-author-public.js', array( 'jquery' ), $this->version, false );
		if ( isset( $this->options['googlecaptcha'] ) && $this->options['googlecaptchapublickey'] ) {
			wp_enqueue_script( $this->plugin_name . '-google-captcha', 'https://www.google.com/recaptcha/api.js', $this->version, false );
		}
	}

	public function messagebox( $atts = array() ) {
		$atts = shortcode_atts( array(
			'style' => 'default',
		), $atts, 'message2author' );

		if ( ( ! isset( $this->option['nonuser'] ) ) || ( $this->options['nonuser'] == 1 && is_user_logged_in() ) ) {
			if ( $atts['style'] == 'messagebox' )
				return $this->messageBoxHTML();
			elseif ( $atts['style'] == 'popup' )
				return $this->popupHTML();
			elseif ( $atts['style'] == 'default' ) {
				if ( $this->options['showas'] == 'messagebox' )
					return $this->messageBoxHTML();
				elseif ( $this->options['showas'] == 'popup' )
					return $this->popupHTML();
			}
		}
	}

	public function store_message() {
		$postid  = $_REQUEST['post_id'];
		$subject = $_REQUEST['subject'];
		$message = $_REQUEST['message'];
		$userid  = ( is_user_logged_in() ) ? get_current_user_id() : $_REQUEST['user_email'];


		//Check Google Captcha
		if ( $this->options['googlecaptcha'] ) {
			$captcha  = $_REQUEST['g-recaptcha-response'];
			$response = json_decode( file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . $this->options['googlecaptchasecretkey'] . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR'] ), true );
			if ( ! $response['success'] )
				wp_safe_redirect( wp_get_referer() );
		}

		$this->messages->setMessage( $postid, $subject, $message, $userid );
		$this->messages->save();

		if ( isset( $this->options['emailtoauthor'] ) && $this->options['emailtoauthor'] == 1 )
			$this->messages->sendEmailTo( 'author' );

		if ( isset( $this->options['emailtouser'] ) && $this->options['emailtouser'] == 1 )
			$this->messages->sendEmailTo( 'sender' );

		wp_safe_redirect( wp_get_referer() );
	}

	public function messagebox_aftercontent( $content ) {
		if ( isset( $this->options['aftercontent'] ) && $this->options['aftercontent'] == 1 ) {
			if ( ( ! isset( $this->options['nonuser'] ) ) || ( $this->options['nonuser'] == 1 && is_user_logged_in() ) ) {
				if ( is_single() ) {
					if ( $this->options['showas'] == 'messagebox' )
						return $content . $this->messageBoxHTML();
					else
						return $content . $this->popupHTML();
				}
			}
		}

		return $content;
	}

	public function messageBoxHTML() {
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'partials/messagebox.php';
		$messagebox = ob_get_contents();
		ob_end_clean();

		return $messagebox;
	}

	public function popupHTML() {
		add_thickbox();
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'partials/popup.php';
		$messagebox = ob_get_contents();
		ob_end_clean();

		return $messagebox;
	}
}
