<?php

class M2A_Activator{

	public static function activate(){
		add_option('m2a_after_post', 'none');
		add_option('m2a_captcha_flag', false);
		add_option('m2a_captcha_conf', [
			'key'    => '',
			'secret' => ''
		]);
		add_option('m2a_allow_visitor', true);
		add_option('m2a_layout', 'messagebox');
		add_option('m2a_style', 'style1');
		add_option('m2a_labels', [
			'title'           => 'MessageToAuthor',
			'button_label'    => 'Submit',
			'success_message' => 'Your message has been send successfully. Author will contact you ASAP.'
		]);
		add_option('m2a_mail_setting', [
			'author-notification' => true,
			'user-notification'   => true,
		]);
	}

}
