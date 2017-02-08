<?php

namespace app\widgets;

use Yii;
use yii\Helpers\Html;
use yii\base\Widget;

class Ckeditorwidget extends Widget
{
	
	private $_assetsUrl;//资源文件路径
	private $upload_img_file;
	private $upload_flash_file;
	
	public function init()
	{
		$this->registerClientScripts();
	}
	
	public function run()
	{
		
?>
		


<script language="javascript">
	function CKupdate() {
				for (instance in CKEDITOR.instances)
                {    
					CKEDITOR.instances[instance].updateElement();
                }
            }
            
	CKEDITOR.editorConfig = function( config ) {
        
		config.language = '<?php echo Yii::t('editor',Yii::$app->language);?>';
		config.toolbarGroups = [
			{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
			{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
			{ name: 'links' },
			{ name: 'insert' },
			{ name: 'forms' },
			{ name: 'tools' },
			{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
			{ name: 'others' },
			'/',
			{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
			{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
			{ name: 'styles' },
			{ name: 'colors' },
			{ name: 'about' }
		];
		//定义上传请求处理路径
 
		// Remove some buttons, provided by the standard plugins, which we don't
		// need to have in the Standard(s) toolbar.
		config.removeButtons = 'Underline,Subscript,Superscript';
	};
	//绑定提交按钮点击事件
	$(document).ready(function(){
		$("input[type='submit']").bind('click',function(){CKupdate();return true;});
	});

</script>

		
<?php
        
	}
    
	protected function registerClientScripts()
	{	
        echo Html::jsFile(Yii::$app->request->baseUrl."/public/js/ckeditor_ali213/ckeditor.js");
	}
}