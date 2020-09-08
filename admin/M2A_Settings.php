<?php

class M2A_Settings extends M2A_Abstruct{

	private $page_title = "M2A/Settings";
	private $page_id = "m2a_settings";
	private $option_group = 'm2a';

	/**
	 * Adding Setting page in wordpress admin menu
	 */
	public function add_setting_page(){
		add_submenu_page('edit.php?post_type=m2a_messages', $this->page_title, 'Settings', 'manage_options', $this->page_id, array($this, 'render_setting_page'), 1);
	}

	public function render_setting_page(){
		if( !current_user_can('manage_options'))
			wp_die('You do not have sufficient permissions to access this page.');
		?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <div class="instructions card" style="max-width: 100%;">
                <h2 class="title">How to use.</h2>
                <p>You can put a Message-box anywhere in content with shortcode <code>[message2author]</code> Or in php file with <code>&lt;?php echo do_shortcode("[message2author]"); ></code></p>
                <p>You can pass few preset to have various layouts like <code>[message2author title="{Title of form}" button_label="{label text of button}" layout="{messagebox|popup}" style="{theme|style1|style2}"]</code></p>
                <p>Or you can simply elect the option <strong>Show after post?</strong> and it will inject after every Post's content</p>
            </div>
            <form action="options.php" method="post">
				<?php
				settings_fields($this->option_group);
				do_settings_sections($this->page_id);
				submit_button();
				?>
            </form>
<!--            <a href="https://codelab7.com/wpm2a" target="_blank">-->
<!--                <img src="https://codelab7.com/assets/m2a-banner.png" alt="Codelab7.com">-->
<!--            </a>-->
        </div>
		<?php
	}

	public function init_settings(){
		add_settings_section('general_settings', 'General', false, $this->page_id);
		register_setting($this->option_group, 'm2a_after_post');
		add_settings_field('m2a_after_post', 'Show After Post?', [$this, 'render_after_post'], $this->page_id, 'general_settings');

		add_settings_section('security_settings', 'Security & Privacy', false, $this->page_id);
		/* Todo: Setup google captcha */ //register_setting($this->option_group, 'm2a_captcha_flag');
		//register_setting($this->option_group, 'm2a_captcha_conf');
		//add_settings_field('m2a_captcha_flag', 'Enable Google Captcha', [$this, 'render_google_captcha'], $this->page_id, 'security_settings');

		register_setting($this->option_group, 'm2a_allow_visitor');
		add_settings_field('m2a_allow_visitor', 'Allow Anyone to send message', [$this, 'render_allow_visitor'], $this->page_id, 'security_settings');

		add_settings_section('layout_settings', 'Layouts', false, $this->page_id);
		register_setting($this->option_group, 'm2a_layout');
		add_settings_field('m2a_layout', 'Default Layout', [$this, 'render_layout_options'], $this->page_id, 'layout_settings');
		register_setting($this->option_group, 'm2a_style');
		add_settings_field('m2a_style', 'Default Style', [$this, 'render_style_selector'], $this->page_id, 'layout_settings');
		register_setting($this->option_group, 'm2a_labels');
		add_settings_field('m2a_labels', 'Default Labels', [$this, 'render_labels'], $this->page_id, 'layout_settings');

	}

	public function render_mail_setting(){
		$value = $this->options('mail'); ?>
        <label><input type="checkbox" name="m2a_mail_setting" value="1" <?= ($value==1)? 'checked' : '' ?>>Show Admin?</label>
        <p class="description">It will trail all post with message box</p>
		<?php
	}

	public function render_labels(){
		$value = $this->options('labels');
		?>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td><strong>Title: </strong></td>
                <td><input name="m2a_labels[title]" type="text" id="m2a_label_title" value="<?= $value['title'] ?>" class="regular-text" placeholder="Enter Title"></td>
            </tr>
            <tr>
                <td><strong>Button Label:</strong></td>
                <td><input name="m2a_labels[button_label]" type="text" id="m2a_label_btn" value="<?= $value['button_label'] ?>" class="regular-text" placeholder="Enter Button label"></td>
            </tr>
            <tr>
                <td><strong>Success Message:</strong></td>
                <td><textarea class="regular-text" name="m2a_labels[success_message]" id="m2a_success_message" rows="5" cols="30" placeholder="Enter Success Message"><?= $value['success_message'] ?></textarea></td>
            </tr>
            <tr>
                <td><strong>Popup button Label:</strong></td>
                <td><input name="m2a_labels[popup_button]" type="text" id="m2a_popup_button" value="<?= $value['popup_button'] ?>" class="regular-text" placeholder="Enter Button label"></td>
            </tr>
        </table>

		<?php
	}

	public function render_layout_options(){
		$value = $this->options('layout'); ?>
        <select name="m2a_layout" id="layout_style">
            <option value="messagebox" <?php selected($value, 'messagebox'); ?>>Message Box</option>
            <option value="popup" <?php selected($value, 'popup'); ?>>PopUp</option>
        </select>
		<?php
	}

	public function render_after_post(){
		$value = $this->options('after_post'); ?>

        <label><input type="checkbox" name="m2a_after_post" value="1" <?= ($value==1)? 'checked' : '' ?>>Show After Post?</label>
        <p class="description">It will trail all post with message box</p>
		<?php
	}

	public function render_style_selector(){
		$value = $this->options('style'); ?>
        <select name="m2a_style" id="allow_to_message">
            <option value="theme" <?php selected($value, 'theme'); ?>>Theme Native style</option>
            <option value="style1" <?php selected($value, 'style1'); ?>>Style1</option>
            <option value="style2" <?php selected($value, 'style2'); ?>>Style2</option>
        </select>
		<?php
	}

	public function render_allow_visitor(){
		$value = $this->options('allow_visitor'); ?>
        <select name="m2a_allow_visitor" id="allow_to_message">
            <option value="visitor"<?php selected($value, 'visitor'); ?>>Visitor ( Only Non-logged-in Users )</option>
            <option value="user" <?php selected($value, 'user'); ?>>User ( Only Logged-in Users )</option>
            <option value="anyone" <?php selected($value, 'anyone'); ?>>Visitor & User ( Anyone )</option>
        </select>
		<?php
	}

	public function render_google_captcha(){
		$value        = $this->options('captcha');
		$captcha_conf = $this->options('captcha_config'); ?>
        <div>
            <label><input type="checkbox" name="m2a_captcha_flag" class="google-captcha-check" value="1" <?= ($value==1)? 'checked' : '' ?>>Add Google Captcha?</label>
        </div>
        <br>
        <div class="google-captcha-config-box <?= ($value==1)? 'active' : '' ?>">
            <label><strong>key: </strong><input type="text" class="regular-text code" name="m2a_captcha_conf[key]" value="<?= $captcha_conf['key']; ?>"></label>
            <label><strong>Secret: </strong><input type="text" class="regular-text code" name="m2a_captcha_conf[secret]" value="<?= $captcha_conf['secret']; ?>"></label>
        </div>
		<?php

	}
}