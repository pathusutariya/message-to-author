<?php


class M2A_Request extends M2A_Abstruct{

	private $post;
	private $subject;
	private $message;
	private $post_id;
	private $author_id;
	private $user;
	private $response = ['response'=>0,'error'=>[],'success'=>''];

	public function __construct(){
		$this->post = new M2A_cpt_messages();
		$this->response['success'] = $this->options('labels')['success_message'];
	}

	public function handle_message(){
		$data = $_REQUEST;
		$this->user = get_current_user_id();
		$this->_set_author($data['post_id']);
		$this->_sanitize_request($data);
		$this->post->create($this->subject, $this->message, $this->author_id);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');
		$this->response['response'] = 1;
		$this->_print_and_die();
		die();
	}

	public function handle_visitor_message(){
		$data = $_REQUEST;
		$data['user_email'] = $this->user = sanitize_email($data['user_email']);
		$this->_sanitize_request($data);
		$this->_set_author($data['post_id']);
		$this->post->create($this->subject, $this->message, $this->author_id);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');

		$this->response['response'] = 1;
		$this->_print_and_die();
		die();
	}

	private function _print_and_die(){
		echo wp_json_encode($this->response);
		wp_die();
	}

	private function _set_author($post_id){
		$this->post_id   = $post_id;
		$this->author_id = get_post_field('post_author', $post_id);
	}

	private function _sanitize_request($data){
		foreach($this->_getValidations() as $key=>$error){
			if( !$data[$key])
				$this->response['error'][] = $error;
		}

		if(!empty($this->response['error']))
			$this->_print_and_die();

		$this->subject = sanitize_text_field($data['subject']);
		$this->message = $this->_message_envolop($data['message']);
		if( !is_user_logged_in())
			$this->user = $data['user_email'];
	}

	private function _getValidations(){
		$validators = [
			'subject' => 'Please enter subject',
			'message' => 'Please add some message',
		];
		if(is_user_logged_in())
			return $validators;
		return $validators['user_email'] = 'Please add email address';
	}

	/**
	 * @param $main_message the core message from user.
	 *
	 * @return string After adding envelop
	 */
	private function _message_envolop($main_message){
		$message = 'You have got a message on'.'<a href="'.get_the_permalink($this->post_id).'" target="_new">'.get_the_title($this->post_id).'</a><br/>';
		$message .= "<strong> Message:</strong>".sanitize_text_field($main_message);
		return $message;
	}

	/**
	 * @param $token send a message for what
	 */
	private function _send_mail($token){
		$email = new M2A_Emails();
		if($token=='author_notification'){
			$email->to($this->author_id);
			$email->set_subject('You have new Message from a user: ['.$this->subject.']');
			$email->set_message($this->message);
			$email->send();
		}
		elseif($token=='user_notification'){
			$email->to($this->user);
			$email->set_subject('Your Message Received: '.$this->subject);
			$email->set_message($this->message);
			$email->send();
		}
	}

}