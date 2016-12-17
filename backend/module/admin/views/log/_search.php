<div class="list_search_form" >
	<?php $form=$this->beginWidget('CActiveForm', array(
		'action' => Yii::app()->createUrl($this->route),
		'method' => 'get',
	)); ?>
	<div>
		<span >频道</span>
		<span >
		<?php   echo CHtml::activeDropDownList($model,'module',array("soso"=>"搜索","xyx"=>"小游戏","manhua"=>"漫画","vd"=>"视频","webgame"=>"浏览器","pk"=>"pk","shouyou"=>"手游","yeyou"=>"页游"),array('empty'=>Yii::t('admin','please select'))); ?>
		</span>
		<span style="float:left">姓名</span>
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