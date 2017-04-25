<style>
    .m2a-option{padding: 10px;}
    .googlecaptcha{display: none;}
</style>
<div class="dashboard">
    <h1>Message to Author</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('m2a_setting_options');
        do_settings_sections('m2a_setting_options');
        $form_group = get_option('m2a_setting');
        ?>
        <div class="m2a-option">  
            <label><input type="checkbox" name="m2a_setting[aftercontent]" value="1" <?php echo isset($form_group['aftercontent']) ? 'checked' : ''; ?> />After Content?</label>
        </div>
        <div class="m2a-option">
            <label><input type="checkbox" name="m2a_setting[nonuser]" value="1" <?php echo isset($form_group['nonuser']) ? 'checked' : ''; ?> />Allow only Registered User To Message</label>
        </div>
<!--        <div class="m2a-option">
            <label><input type="checkbox" name="m2a_setting[googlecaptcha]" class="googlecaptchaenable" value="1" <?php echo isset($form_group['googlecaptcha']) ? 'checked' : ''; ?> />Add Google Captcha?</label>	
        </div>
        <div class="m2a-option googlecaptcha">
            <label>public key:<input type="text" name="m2a_setting[googlecaptchapublickey]" value="<?php echo $form_group['googlecaptchapublickey']; ?>" /></label>
            <label>secret key:<input type="password" name="m2a_setting[googlecaptchasecretkey]" value="<?php echo $form_group['googlecaptchasecretkey']; ?>" /></label>
        </div>-->
        <div class="m2a-option">
            Show as:  &nbsp; 
            <label><input type="radio" name="m2a_setting[showas]" value="popup" <?php echo (isset($form_group['showas']) && $form_group['showas'] == 'popup') ? 'checked' : ''; ?> >popup 
            </label><label><input type="radio" name="m2a_setting[showas]" value="messagebox" <?php echo (isset($form_group['showas']) && $form_group['showas'] == 'messagebox') ? 'checked' : ''; ?> >messagebox</label>
        </div>
        <div class="m2a-option">
            <label><input type="checkbox" name="m2a_setting[emailtoauthor]" value="1" <?php echo isset($form_group['emailtoauthor']) ? 'checked' : ''; ?> />Send E-mail To Author?</label>	
        </div>
        <div class="m2a-option">
            <label><input type="checkbox" name="m2a_setting[emailtouser]" value="1" <?php echo isset($form_group['emailtouser']) ? 'checked' : ''; ?> />Send Confirmation E-mail To Customer?</label>	
        </div>

        <?php submit_button(); ?>
    </form>
</div>
<script type="text/javascript">
    (function($) {
        if($('.googlecaptchaenable').attr('checked') == 'checked'){
            $('.googlecaptcha').show();
        }
        $('.googlecaptchaenable').on('change',function(){
            if(this.checked){
                $('.googlecaptcha').show();
            }else{
                $('.googlecaptcha').hide();
            }
        });
    }(jQuery));
</script>