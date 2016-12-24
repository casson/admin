<?php
	use yii\Helpers\Html;
	use yii\widgets\ActiveForm;
?>
<div class="list_search_form" >
	<?php $form=ActiveForm::begin(array(
		'action' => Yii::$app->urlManager->createAbsoluteUrl($controller->route),
		'method' => 'get',
	)); ?>
	<div>
		<span>模块</span>
		<span>
		<?php  echo Html::activeDropDownList($model,'module',$model->getTypeOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
		</span>
		<span style="float:left">&nbsp;名称</span>
		<span style="float:left">
		<?php echo Html::activeTextInput($model,'name',  array('class'=>'text')) ?>
		</span>
	</div>
	<div>
		<span style="float:left"></span>
		<span style="float:left"></span>
	</div>
	<div >
	<?php echo Html::submitButton(Yii::t('admin','search'),array("class"=>'default_btn')); ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<!-- form -->