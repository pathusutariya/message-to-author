<?php
$class = '';
if(is_user_logged_in()):
	$class= 'login';
endif;
?>
<div id="my-content-id" style="display: none;">
    <div class="m2a-message m2a-popup <?= $class ?>">
		<?php include M2A_DIR.'templates/form.php'; ?>
    </div>
</div>
<?php

$login = true;
if(is_user_logged_in()):
	$login = false;
endif;
$style = 'width=auto&height=auto';
if($options['style']=='style1')
	$style = 'width=700&height=450';
elseif($options['style']=='style2')
	$style = 'width=600&height=595';
else
	$style;
?>

<a href="#TB_inline?<?= $style; ?>&inlineId=my-content-id" class="thickbox btn button"><?= $options['labels']['button_label'] ?></a>
