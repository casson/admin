<?php

/**百度编辑器 class等于 baidu
*/
class getbaidu extends CWidget
{
	
	
	
	public function init()
	{
	}
	
	public function run()
	{
		
?>
   <script type="text/javascript" charset="utf-8" src="/admin/public/js/baidu/ueditor.config.js"></script>  
  <script type="text/javascript" charset="utf-8" src="/admin/public/js/baidu/ueditor.all.min.js"> </script>  
  <script type="text/javascript" charset="utf-8" src="/admin/public/js/baidu/lang/zh-cn/zh-cn.js"></script>    
  <script type="text/javascript">   
    $a = $(".baidu").attr("id");
	  var ue = UE.getEditor($a);    
  </script>	

		
<?php 
		
	
	}
	
	protected function registerClientScript()
	{
		$cs=Yii::app()->clientScript;
	}
}