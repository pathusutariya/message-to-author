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
		$this->post->create($this->subject, $this->message);
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

	private function _set_author($post_id){
		$this->post_id   = $post_id;
		$this->author_id = get_post_field('post_author', $post_id);
	}

	private function _sanitize_request($data){
		$this->subject = sanitize_text_field($data['subject']);
		$this->message = $this->_message_envolop($data['message']);
	}

	private function _message_envolop($message){
		$message = 'You have got a message on <br/>';
		$message .= '<a href="'.get_the_permalink($this->post_id).'">'.get_the_title($this->post_id).'</a><br/>';
		$message .= "<strong>Message:</strong><br/>";
		$message .= sanitize_text_field($message);
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