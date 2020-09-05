<?php


class M2A_Shortcode extends M2A_Abstruct{

	function register_shortcode($args){
		$this->_handle_args($args);
		if(isset($_GET['message_sent']) && $_GET['message_sent']==1)
			return $this->get_success_message();

		$layout = $this->options('layout');
		if($layout=='messagebox')
			return $this->message_box_render();
		elseif($layout=='popup')
			return $this->popup_render();
	}

	public function get_success_message(){
		return '<div style="background-color: #cff6cf; color: #111; padding: 20px; text-align: inherit; ">'.$this->options('labels')['success_message'].'</div>';
	}

	private function _handle_args($args){
		$label           = $this->options('labels');
		$default_options = [
			'title'        => $label['title'],
			'button_label' => $label['button_label'],
			'style'        => $this->options('layout'),
		];
		$args            = shortcode_atts($default_options, $args);

		//Confirming Style typos
		if( !in_array($args['style'], $this->get_all_available_options('layout')))
			$args['style'] = $this->options('layout');

		$this->override_option('layout', $args['style']);
		$this->override_option('labels', [
			'title'           => $args['title'],
			'button_label'    => $args['button_label'],
			'success_message' => $label['success_message']
		]);
	}

	private function popup_render(){
		$options = $this->options();
		add_thickbox();
		ob_start();
		require plugin_dir_path(__FILE__).'partials/popup.php';

		return ob_get_clean();
	}

	private function message_box_render(){
		$options = $this->options();
		ob_start();
		require plugin_dir_path(__FILE__).'partials/message-box.php';

		return ob_get_clean();
	}

}