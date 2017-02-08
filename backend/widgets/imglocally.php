<?php

/**
**网络图片本地化；
*/
class imglocally extends CWidget
{
	//设置button的style；
	public $style ;
	public $imgid ; //水印；
		
	//初始化；
	public function init(){
		$imgid = $this->imgid ? $this->imgid : 1 ;
		echo '<input  style="'.$this->style.'" type="button" value="采集图片" id="imglocally" >';
		echo '<script> var imgid='.$imgid.'; </script>' ;
	}
	
	
	
	//结束标签；
	public function run(){
		
		$this->registerClientScript();
	}
	
	protected function registerClientScript()
	{
		$cs=Yii::app()->clientScript;
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/Params.js");
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/imglocally.js?time=".time().'&imgid='.$this->imgid );
	}
	
	

}