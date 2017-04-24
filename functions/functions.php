<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<?php

function m2a_getMessageBoxHTML() {
    $messagebox = '<form class="form" method="post" action="' . esc_url(admin_url('admin-post.php')) . '"><input style="margin-bottom:15px;" type="text" name="subject" placeholder="Subject">';
    if (!is_user_logged_in()) {
        $messagebox .= '<input style="margin-bottom:15px;" type="email" name="user_email" placeholder="Email">';
    }
    $messagebox .= '<textarea style="margin-bottom:15px;" name="message" placeholder="Message"></textarea>
					<input type="hidden" name="action" value="m2a_new_message" />
					<input type="hidden" name="post_id" value="' . get_the_ID() . '" />
					<input type="submit" class="button btn" name="submit_message" value="submit" />
				</form>';
    return $messagebox;
}

function m2a_getPopupHTML() {
    add_thickbox();
    $messagebox = '<div id = "my-content-id" style = "display:none;">
    <form class = "form" method = "post" action = "' . esc_url(admin_url('admin-post.php')) . '" style = "text-align:center;">
    <input style = "margin:10px 0px 15px;" type = "text" name = "subject" placeholder = "Subject">';
    if (!is_user_logged_in()) {
        $messagebox .= '<input style = "margin-bottom:15px;" type = "email" name = "user_email" placeholder = "Email">';
    }
    $messagebox .= '<textarea style = "margin-bottom:15px;" name = "message" placeholder = "Message" rows = "5"></textarea>
    <input type = "hidden" name = "action" value = "m2a_new_message" />
    <input type = "hidden" name = "post_id" value = "' . get_the_ID() . '" />
    <input type = "submit" class = "button btn" name = "submit_message" value = "submit" />
    </form></div>
    <a href = "#TB_inline?width=600&height=350&inlineId=my-content-id" class = "thickbox btn button">message me</a>';
    return $messagebox;
}

function m2a_aftercontent() {
    $m2a_setting = get_option('m2a_setting');
    if (isset($m2a_setting['aftercontent']) && $m2a_setting['aftercontent'] == 1) {
        if ((!isset($m2a_setting['nonuser'])) || ($m2a_setting['nonuser'] == 1 && is_user_logged_in())) {
            function m2a_messagebox($content) {
                $m2a_setting = get_option('m2a_setting');
                if ($m2a_setting['showas'] == 'messagebox')
                    return $content . m2a_getMessageBoxHTML();
                else
                    return $content . m2a_getPopupHTML();
            }
            add_filter('the_content', 'm2a_messagebox');
        }
    }
}
add_action('init', 'm2a_aftercontent');




/*
 * Saving Data to database
 */

function m2a_message_db_store() {
    global $wpdb;
    // global $post;
    $postid   = $_REQUEST['post_id'];
    $authorid = get_post_field('post_author',$postid);
    $subject  = $_REQUEST['subject'];
    $message  = $_REQUEST['message'];

    if (!is_user_logged_in()) {
        $userid = $_REQUEST['user_email'];
    } else {
        $userid = get_current_user_id();
    }
    $tableName = $wpdb->prefix.'m2a_message';
    $wpdb->insert($tableName, array('user_id' => $userid, 'author_id' => $authorid, 'post_id' => $postid, 'subject' => $subject, 'message' => $message));
    wp_safe_redirect(wp_get_referer());
}

add_action('admin_post_nopriv_m2a_new_message', 'm2a_message_db_store');
add_action('admin_post_m2a_new_message', 'm2a_message_db_store');

// Create shortcode
function messagebox($atts = array()) {
    $a    = get_option('m2a_setting');
    $atts = shortcode_atts(array(
       'style' => 'default',
       'target' => 'user',
          ), $atts, 'message2author');
    if ((!isset($a['nonuser'])) || ($a['nonuser'] == 1 && is_user_logged_in())) {
        if ($atts['style'] == 'messagebox') {
            return m2a_getMessageBoxHTML();
        } 
        elseif ($atts['style'] == 'popup') {
            return m2a_getPopupHTML();
        } 
        elseif ($atts['style'] == 'default') {
            if ($a['showas'] == 'messagebox') {
                return m2a_getMessageBoxHTML();
            } elseif ($a['showas'] == 'popup') {
                return m2a_getPopupHTML();
            }
        }
    }
}
    add_shortcode('message2author', 'messagebox');
?>