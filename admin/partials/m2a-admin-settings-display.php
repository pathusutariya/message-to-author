<div class="dashboard">
    <h1>Message to Author</h1>
    <form method="post" action="options.php">
		<?php
		settings_fields( 'm2a_setting_options' );
		do_settings_sections( 'm2a_setting_options' );
		$form_group = get_option( 'm2a_settings' );
		?>
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row">Display Setting:</th>
                <td>
                    <fieldset>
                        <div class="m2a-option">
                            <label>
                                <input type="checkbox" name="m2a_settings[aftercontent]" value="1" <?php echo isset( $form_group['aftercontent'] ) ? 'checked' : ''; ?> />
                                After All Post's Content?
                            </label>
                            <p class="note">
                                <strong>Note:- </strong> You can put message box anywhere in the website you can use shortcode <code> [message2author]</code> for put anywhere or
                                use PHP <code>&lt;?php echo do_shortcode("[message2author]"); ?></code></p>
                        </div>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Privacy Setting:</th>
                <td>
                    <fieldset>
                        <div class="m2a-option">
                            <label>
                                <input type="checkbox" name="m2a_settings[nonuser]" value="1" <?php echo isset( $form_group['nonuser'] ) ? 'checked' : ''; ?> />
                                Allow only Registered User To Send a Message
                            </label>
                        </div>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Google Captcha:</th>
                <td>
                    <fieldset>
                        <div class="m2a-option">
                            <label>
                                <input type="checkbox" name="m2a_settings[googlecaptcha]" class="googlecaptchaenable" value="1" <?php echo isset( $form_group['googlecaptcha'] ) ? 'checked' : ''; ?> />
                                Enable Google Captcha-v2?
                            </label>
                        </div>
                        <div class="m2a-option googlecaptcha" <?php if ( ! $form_group['googlecaptcha'] ): ?> style="display: none;"  <?php endif; ?>>
                            <label>
                                <strong>public key: </strong>
                                <input class="regular-text" type="text" name="m2a_settings[googlecaptchapublickey]" value="<?php echo $form_group['googlecaptchapublickey']; ?>"/></label><br>
                            <label>
                                <strong>secret key: </strong>
                                <input class="regular-text" type="password" name="m2a_settings[googlecaptchasecretkey]" value="<?php echo $form_group['googlecaptchasecretkey']; ?>"/></label>
                        </div>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">View Setting:</th>
                <td>
                    <fieldset>
                        <div class="m2a-option">
                            Show as
                            <label>
                                <input type="radio" name="m2a_settings[showas]" value="popup" <?php echo ( isset( $form_group['showas'] ) && $form_group['showas'] == 'popup' ) ? 'checked' : ''; ?> >
                                Pop-up
                            </label>
                            <label>
                                <input type="radio" name="m2a_settings[showas]" value="messagebox" <?php echo ( isset( $form_group['showas'] ) && $form_group['showas'] == 'messagebox' ) ? 'checked' : ''; ?> >
                                Message Box
                            </label>
                            <p class="note">
                                You can change the behaviour of message box by passing a parameter to the shortcode. EX- <code> [message2author style="messagebox"]</code>
                                for show message box or <code> [message2author style="popup"]</code> for display it in pop up.<br/> it will not depend on your settings from admin panel.
                            </p>
                        </div>
                    </fieldset>
                </td>
            </tr>
            <tr>
                <th scope="row">Email Setting:</th>
                <td>
                    <fieldset>
                        <div class="m2a-option">
                            <label>
                                <input type="checkbox" name="m2a_settings[emailtoauthor]" value="1" <?php echo isset( $form_group['emailtoauthor'] ) ? 'checked' : ''; ?> />
                                Send E-mail To Author when a new message arrives.</label>
                        </div>
                        <div class="m2a-option">
                            <label><input type="checkbox" name="m2a_settings[emailtouser]" value="1" <?php echo isset( $form_group['emailtouser'] ) ? 'checked' : ''; ?> />
                                Send Confirmation E-mail To Sender?
                            </label>
                        </div>
                    </fieldset>
                </td>
            </tr>
            </tbody>
        </table>
        <p>
			<?php submit_button(); ?>
        </p>
    </form>
</div>
<script type="text/javascript">
    (function ($) {
        $('.googlecaptchaenable').on('change', function () {
            if (this.checked)
                $('.googlecaptcha').show();
            else
                $('.googlecaptcha').hide();
        });
    }(jQuery));
</script>