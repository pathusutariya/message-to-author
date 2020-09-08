<?php

class M2A_Activator{

	public static function activate(){
		add_option('m2a_after_post', '');
		add_option('m2a_captcha_flag', false);
		add_option('m2a_captcha_conf', [
			'key'    => '',
			'secret' => ''
		]);
		add_option('m2a_allow_visitor', 'anyone');
		add_option('m2a_layout', 'messagebox');
		add_option('m2a_style', 'style1');
		add_option('m2a_labels', [
			'title'           => 'Message 2 Author',
			'button_label'    => 'Submit',
			'success_message' => 'We have received your Message. We\'ll get back to you ASAP.',
			'popup_button'    => 'Drop a Message'
		]);
		add_option('m2a_mail_setting', [
			'author-notification' => true,
			'user-notification'   => true,
		]);
	}

}
