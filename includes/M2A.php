<?php

class M2A{
	protected $loader;

	public function __construct(){
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->create_master_settings();
		$this->define_public_hooks();
	}

	private function define_public_hooks(){
		$plugin_public = new M2A_Public();

		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		$this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
		$this->loader->add_filter('the_content',$plugin_public,'content_filter');
		// Filter posts for author
		$this->loader->add_filter('pre_get_posts', $plugin_public,'current_author_posts_filter');


		$shortcode = new M2A_Shortcode();
		$this->loader->add_shortcode('message2author', $shortcode, 'register_shortcode');

		$request = new M2A_Request();
		$this->loader->add_action('admin_post_nopriv_m2a_new_message', $request, 'handle_visitor_message');
		$this->loader->add_action('admin_post_m2a_new_message', $request, 'handle_message');
		$this->loader->add_action('wp_ajax_nopriv_m2a_new_message', $request, 'ajax_handle_visitor_message');
		$this->loader->add_action('wp_ajax_m2a_new_message', $request, 'ajax_handle_message');

	}

	private function define_admin_hooks(){
		$plugin_admin = new M2A_Admin();
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
		$this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
		$messages_cpt = new M2A_cpt_messages();
		$this->loader->add_action('init', $messages_cpt, 'register_post_type');
		$this->loader->add_action('add_meta_boxes', $messages_cpt, 'add_meta_box_support');
	}

	private function create_master_settings(){
		require_once M2A_DIR.'admin/M2A_Settings.php';
		$setting_page = new M2A_Settings();
		$this->loader->add_action('admin_init', $setting_page, 'init_settings');
		$this->loader->add_action('admin_menu', $setting_page, 'add_setting_page');
	}

	private function load_dependencies(){
		require_once M2A_DIR.'includes/M2A_Loader.php';
		require_once M2A_DIR.'includes/M2A_Abstruct.php';
		require_once M2A_DIR.'admin/M2A_Admin.php';
		require_once M2A_DIR.'admin/M2A_cpt_messages.php';
		require_once M2A_DIR.'admin/M2A_cpt_messages.php';
		require_once M2A_DIR.'public/M2A_Public.php';
		require_once M2A_DIR.'public/M2A_Shortcode.php';
		require_once M2A_DIR.'public/M2A_Request.php';
		require_once M2A_DIR.'public/M2A_Emails.php';
		$this->loader = new M2A_Loader();
	}

	private function set_locale(){
		require_once M2A_DIR.'includes/M2A_i18n.php';
		$plugin_i18n = new M2A_i18n();
		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
	}

	public function run(){
		$this->loader->run();
	}

}
