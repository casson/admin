<?php
  class ClFormModel extends CFormModel
  {
    public $attrLableArr = array();
    public function __construct()
	{
		$model =  Yii::app()->controller->Module->id  ;
	    $reflect = new ReflectionClass($this);
		$pros = $reflect->getDefaultProperties();
		$arr =array() ;
		foreach ($pros as $key=>$r) $arr[$key] = Yii::t($model,$key);
		$this->attrLableArr = $arr ;
	}
  }

?>