<?php


class M2A_Emails extends M2A_Abstruct{
	private $receiver;
	private $type;
	private $body;
	private $data;
	private $message;
	private $subject;

	public function to($attr){
		if(is_int($attr)){
			$this->receiver = get_userdata($attr)->user_email;
		}
		elseif(is_email($attr))
			$this->receiver = $attr;
		else{
			$this->receiver = get_option('admin_email');
		}
	}

	public function set_type($type){
		$this->type = $type;
	}

	public function send(){
		wp_mail($this->receiver, $this->subject, $this->message);
	}

	private function make_email_body(){

	}


	public function set_subject($subject){
		$this->subject = $subject;
	}

	public function set_message($message){
		ob_start();
		require plugin_dir_path(__FILE__).'partials/email-template.php';
		$this->message = ob_get_clean();
	}

}