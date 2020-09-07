<?php

class M2A_Public extends M2A_Abstruct{

	public function enqueue_styles(){
		$style = $this->options('style');
		if($style=='style1')
			wp_enqueue_style($this->plugin_name.'-preset-style', plugin_dir_url(__FILE__).'css/m2a-style1.css', array(), rand(100, 999), 'all');
		elseif($style=='style2')
			wp_enqueue_style($this->plugin_name.'-preset-style', plugin_dir_url(__FILE__).'css/m2a-style2.css', array(), rand(100, 999), 'all');
		elseif($style=='theme')
			wp_enqueue_style($this->plugin_name.'-style', plugin_dir_url(__FILE__).'css/m2a-public.css', array(), rand(100, 999), 'all');
	}

	public function enqueue_scripts(){
		wp_enqueue_script($this->plugin_name.'-script', plugin_dir_url(__FILE__).'js/M2A-public.js', array('jquery'), $this->version, true);
	}

	public function content_filter($content){
		$front_layout = new M2A_Shortcode();
		if(is_singular() || is_single()):
			$content .= $front_layout->register_shortcode([]);
		else:
			$content;
		endif;
		return $content;
	}

	public function current_author_posts_filter($query) {
		global $pagenow;

		if( 'edit.php' != $pagenow || !$query->is_admin )
			return $query;

		if( !current_user_can( 'edit_others_posts' ) ) {
			global $user_ID;
			$query->set('author', $user_ID );
		}
		return $query;
	}

}