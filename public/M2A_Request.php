<?php


class M2A_Request extends M2A_Abstruct{

	private $options;
	private $post;
	private $subject;
	private $message;
	private $post_id;
	private $author_id;
	private $user;

	public function __construct(){
		$this->post    = new M2A_cpt_messages();
		$this->options = new M2A_Settings();
	}

	public function handle_message(){
		$data       = $_POST;
		$this->user = get_current_user_id();
		$this->_set_author($data['post_id']);
		$this->_sanitize_request($data);
		$this->post->create($this->subject, $this->message,$this->author_id);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');
		wp_redirect(wp_get_referer().'?message_sent=1');
	}

	public function handle_visitor_message($data){
		$data       = $_POST;
		$this->user = sanitize_email($data['user_email']);
		$this->_sanitize_request($data);
		$this->_set_author($data);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');
		add_query_arg('test');
		global $wp;
		wp_safe_redirect(esc_url(site_url($wp->request).'?message_sent=1'));
		exit();
	}

	public function ajax_handle_message(){
		$data = $_POST;
		/**
		 * ToDo
		 * validate data and save via ajax
		 */
		if( !empty($error = $this->_check_error_of_message($data))){
			echo wp_json_encode(['response' => 0, 'error' => $error]);
			wp_die();
		}
		$success = $this->options('labels')['success_message'];
		echo wp_json_encode(['response' => 1, 'success' => $success]);
		$this->user = get_current_user_id();
		$this->_set_author($data['post_id']);
		$this->_sanitize_request($data);
		$this->post->create($this->subject, $this->message,$this->author_id);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');
		die();
	}

	public function ajax_handle_visitor_message($data){
		$data = $_REQUEST;
		/**
		 * ToDo
		 * validate data and save via ajax
		 */
		if( !empty($error = $this->_check_error_of_message($data))){
			echo wp_json_encode(['response' => 0, 'error' => $error]);
			wp_die();
		}

		$success = $this->options('labels')['success_message'];
		echo wp_json_encode(['response' => 1, 'success' => $success]);

		$this->user = sanitize_email($data['user_email']);
		$this->_sanitize_request($data);
		$this->_set_author($data['post_id']);
		$this->post->create($this->subject, $this->message,$this->author_id);
		$this->_send_mail('author_notification');
		//$this->_send_mail('user_notification');
		die();
	}

	private function _check_error_of_message($data){
		$error = array();
		if( !$data['subject'])
			$error[] = "Please Enter subject";
		if( !$data['message'])
			$error[] = "Please Enter Message";
		if( !is_user_logged_in())
			if( !$data['user_email'])
				$error[] = "Please Enter email";
		return $error;
	}

	private function _set_author($post_id){
		$this->post_id   = $post_id;
		$this->author_id = get_post_field('post_author', $post_id);
	}

	private function _sanitize_request($data){
		$this->subject = sanitize_text_field($data['subject']);
		$this->message = $this->_message_envolop($data['message']);
	}

	private function _message_envolop($main_message){
		$message = 'You have got a message on'.'<a href="'.get_the_permalink($this->post_id).'">'.get_the_title($this->post_id).'</a><br/>';
		$message .= "<strong> Message:</strong>".sanitize_text_field($main_message);

		return $message;
	}

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