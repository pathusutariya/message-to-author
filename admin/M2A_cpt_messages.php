<?php


class M2A_cpt_messages extends M2A_Abstruct{

	private $post_type = 'm2a_messages';

	public function register_post_type(){
		$labels       = array(
			'name'               => _x('M2A/Messages', 'post type general name'),
			'singular_name'      => _x('M2A/Message', 'post type singular name'),
			'add_new'            => _x('Add New', 'Messages'),
			'add_new_item'       => __('Add New Messages'),
			'edit_item'          => __('Manage Thread'),
			'new_item'           => __('New Messages'),
			'all_items'          => __('All Messages'),
			'view_item'          => __('View Messages'),
			'search_items'       => __('Search Messages'),
			'not_found'          => __('No Messages found'),
			'not_found_in_trash' => __('No Messages found in the Trash'),
			'menu_name'          => 'Author\'s Messages'
		);
		$capabilities = array(
			'edit_post'    => 'edit_post',
			'create_posts' => 'do_not_allow',
		);
		$args         = array(
			'labels'              => $labels,
			'description'         => 'All M2A/Messages Administrations.',
			'public'              => true,
			'menu_position'       => 81,
			'supports'            => array('title'),
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'query_var'           => false,
			'can_export'          => false,
			'delete_with_user'    => false,
			'capability_type'     => 'post',
			'capabilities'        => $capabilities,
			'map_meta_cap'        => true,
			'menu_icon'           => 'dashicons-email',
		);
		register_post_type($this->post_type, $args);
		/*register_post_status( 'escalated', array(
			'label'                     => _x( 'Escalate ', 'Message Status', 'm2a' ),
			'public'                    => true,
			'label_count'               => _n_noop( 'Aggregated s <span class="count">(%s)</span>', 'Aggregated s <span class="count">(%s)</span>', 'plugin-domain' ),
			'post_type'                 => array( $this->post_type ), // Define one or more post types the status can be applied to.
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'show_in_metabox_dropdown'  => true,
			'show_in_inline_dropdown'   => true,
			'dashicon'                  => 'dashicons-businessman',
		) );*/
	}

	/**
	 * Todo: [Phase2] envlop for message
	 */

	public function create($title, $content,$author){
		/**
		 * todo: Add new post details
		 * https://developer.wordpress.org/reference/functions/wp_insert_post/
		 */
		wp_insert_post([
			'post_title'   => $title,
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_type'    => $this->post_type,
			'post_author' => $author
		]);
	}

	public function add_meta_box_support(){
		add_meta_box('m2a-message-base', 'Messages', [$this,'render_content'],$this->post_type,'normal','high');
	}

	public function render_content($post){
		echo $post->post_content;
	}

}