<?php
$class = '';
if(is_user_logged_in()):
	$class = 'login';
endif;
?>
<div id="my-content-id" style="display: none;">
    <div class="m2a-message m2a-popup <?= $class ?>">
		<?php include M2A_DIR.'templates/form.php'; ?>
    </div>
</div>
<?php
$style = 'width=auto&height=460';
if($options['style']=='style1'):
	if(is_user_logged_in()):
		$style = 'width=670&height=470';
	else:
		$style = 'width=670&height=470';
	endif;
elseif($options['style']=='style2'):
	if(is_user_logged_in()):
		$style = 'width=auto&height=480';
	else:
		$style = 'width=600&height=550';
	endif;
else:
	if(is_user_logged_in()):
		$style = 'width=auto&height=390';
	else:
		$style;
	endif;
endif;

if(wp_is_mobile()){
	$style = 'width=320&height=550';
}
?>

<a href="#TB_inline?<?= $style; ?>&inlineId=my-content-id" class="thickbox btn button"><?= $options['labels']['popup_button'] ?></a>
