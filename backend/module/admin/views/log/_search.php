<?php

use yii\widgets\ActiveForm;
use yii\Helpers\Html;


$controller = Yii::$app->controller;

?>
<div class="list_search_form" >
	<?php $form=ActiveForm::begin(array(
		'action' => Yii::$app->urlManager->createAbsoluteUrl($controller->route),
		'method' => 'get',
	)); ?>
	<div >
	<?php echo Html::submitButton(Yii::t('admin','search'),array("class"=>'default_btn')); ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<!-- form -->