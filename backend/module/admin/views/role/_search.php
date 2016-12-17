<div class="list_search_form" >
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>
	<div>
		<span style="float:left"><?php echo $form->label($model, 'role_name'); ?></span>
		<span style="float:left">
		<?php echo CHtml::activeTextField($model,'role_name',  array('class'=>'text')) ?>
		</span>
	</div>
	<div>
		<span style="float:left"></span>
		<span style="float:left"></span>
	</div>
	<div >
	<?php echo CHtml::submitButton(Yii::t('admin','search')); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
<!-- form -->