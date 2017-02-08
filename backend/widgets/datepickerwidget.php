<?php

/**日期选择 组件
*使用示例:<?php $this->widget('ext.datepickerwidget',array('model'=>$model,'name'=>'vip_deadline','style'=>'border:1px solid #c5c5c5'));?>
*/
class DatepickerWidget extends CWidget
{
	
	public $model=null;
	public $name='date';//选择框变量名
	public $value;//初始值
	public $lang = 'zh_cn';//语言
	public $skin='twoer';//皮肤
	public $dateFmt='yyyy-MM-dd HH:mm:ss';//日期格式
	public $minDate=null;//起始日期
	public $maxDate=null;//终止日期
	public $dynamic=null;//动态限制类型 1:今天以前的日期(包括今天) 2:今天以后的日期(不包括今天) 3:本月的日期1号至本月最后一天 4:今天7:00:00至明天21:00:00
	public $style;
	public $autoPickDate = true;//为false时 点日期的时候不自动输入,而是要通过确定才能输入 为true时 即点击日期即可返回日期值 为null时(推荐使用) 如果有时间置为false 否则置为true
	public $readOnly = true;//是否只读
	public $class_name='Wdate';
	public function init()
	{
	
		
		if($this->dynamic==1)
		{
			$this->maxDate = '%y-%M-%d';
		}
		if($this->dynamic==2)
		{
			$this->minDate = '%y-%M-{%d+1}';
		}
		if($this->dynamic==3)
		{
			$this->minDate = '%y-%M-01';
			$this->maxDate = '%y-%M-%ld';
		}
		if($this->dynamic==4)
		{
			$this->minDate = '%y-%M-%d 7:00:00';
			$this->maxDate = '%y-%M-{%d+1} 21:00:00';
		}
		
	}
	
	public function run()
	{
		
		
		if(!empty($this->model))
		{
		
			echo "<div class='date_div'>".CHtml::activeTextField($this->model,$this->name, array('class'=>$this->class_name,'style'=>$this->style,'value'=>$this->value,'onFocus'=>"WdatePicker({lang:'".$this->lang."',skin:'".$this->skin."',dateFmt:'".$this->dateFmt."',minDate:'".$this->minDate."',maxDate:'".$this->maxDate."',autoPickDate:".$this->autoPickDate.",readOnly:".$this->readOnly."})"))."</div>";
		
		}
		else
		{
		
			echo  "<input style=\"".$this->style."\"  value=\"".$this->value."\" class=\"".$this->class_name."\" type=\"text\" name=\"".$this->name."\" onFocus=\"WdatePicker({lang:'".$this->lang."',skin:'".$this->skin."',dateFmt:'".$this->dateFmt."',minDate:'".$this->minDate."',maxDate:'".$this->maxDate."',autoPickDate:".$this->autoPickDate.",readOnly:".$this->readOnly."})\"/>";
		}
		$this->registerClientScript();
	}
	
	protected  function registerClientScript()
	{

		
		$cs=Yii::app()->clientScript;
	    $cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/datepicker/WdatePicker.js");
		
		
		
	}
}