<?php

class M2A_Admin extends M2A_Abstruct {

	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name . '-style', plugin_dir_url( __FILE__ ) . 'css/M2A-admin.css', array(), $this->version, 'all' );
	}

	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name . '-script', plugin_dir_url( __FILE__ ) . 'js/M2A-admin.js', array( 'jquery' ), $this->version, true );
	}

	public function show_admin_notice() {

	}

	public function plugin_support_link($links){
		$links[] = '<a href="' .
		           admin_url( 'edit.php?post_type=m2a_messages&page=m2a_settings').
		           '">' . __('Settings') . '</a>';
		$links[] = '<a href="https://codelab7.com/wppm2a" target="_blank">' . __('Support') . '</a>';
		return $links;
	}

}
