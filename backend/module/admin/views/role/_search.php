<?php
	use yii\Helpers\Html;
	use yii\widgets\ActiveForm;
?>	
<div class="list_search_form" >
	<?php $form=ActiveForm::begin(array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>
	<div>
		<span style="float:left"><?php echo Html::ActiveLabel($model, 'role_name'); ?></span>
		<span style="float:left">
			<?php echo Html::activeTextInput($model,'role_name',  array('class'=>'text')) ?>
		</span>
	</div>
	<div>
		<span style="float:left"></span>
		<span style="float:left"></span>
	</div>
	<div >
	<?php echo Html::submitButton(Yii::t('admin','search')); ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>
<!-- form -->