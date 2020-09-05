<?php
$login = true;
if( is_user_logged_in())
	$login = false;
?>
<div class="m2a-title"><h2><?= $options['labels']['title']?></h2></div>
<form class="form" method="post" action="<?= esc_url(admin_url('admin-post.php')) ?>">

    <input class="m2a-subject <?= (!$login)? 'full' : '' ?>" type="text" name="subject" placeholder="Subject" autocomplete="off" required>
	<?php if($login): ?>
        <input class="m2a-email" type="email" name="user_email" placeholder="Email" required>
	<?php endif; ?>

    <textarea class="m2a-text" name="message" placeholder="Message" rows="4" required></textarea>
    <input type="hidden" name="action" value="m2a_new_message"/>
    <input type="hidden" name="post_id" value="<?= get_the_ID() ?>"/>
	<?php
	/**
	 * ToDo: [Waiting]  For google captcha Option to set at below condition currently condtion is from old used file.
	 */
	?>
	<?php if(isset($this->options['captcha']) && $this->options['captcha_config']): ?>
        <div class="g-recaptcha" data-sitekey="<?= $this->options['captcha_config']['secret']; ?>"></div>
	<?php endif; ?>
    <input class="m2a-submit" type="submit" class="button btn" name="submit_message" value="<?= $options['labels']['button_label'] ?>"/>
</form>