<div class="list_search_form" >
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>
	<div>
		<span>模块</span>
		<span>
		<?php   echo CHtml::activeDropDownList($model,'module',$model->getTypeOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
		</span>
		<span style="float:left">&nbsp;名称</span>
		<span style="float:left">
		<?php echo CHtml::activeTextField($model,'name',  array('class'=>'text')) ?>
		</span>
	</div>
	<div>
		<span style="float:left"></span>
		<span style="float:left"></span>
	</div>
	<div >
	<?php echo CHtml::submitButton(Yii::t('admin','search'),array("class"=>'default_btn')); ?>
	</div>
	<?php $this->endWidget(); ?>
</div>
<!-- form -->