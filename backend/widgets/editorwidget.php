<?php

/**附件上传组件
*结合attachment模块使用，完全使用attachment模块资源
*结合artdislog js组件使用
* mode 0:内容页缩略图 1:多图片上传  2:多文件上传
*/
class EditorWidget extends CWidget
{
	
	private $_assetsUrl;//资源文件路径
	private $upload_img_file;
	private $upload_flash_file;
	
	public function init()
	{
		$this->registerClientScript();
		$this->upload_img_file=Yii::app()->createUrl('attachment/attachment/UploadEditorFile')."?type=img&".Yii::app()->request->csrfTokenName.'='.Yii::app()->request->getCsrfToken();
		$this->upload_flash_file.=Yii::app()->createUrl('attachment/attachment/UploadEditorFile')."?type=flash&".Yii::app()->request->csrfTokenName.'='.Yii::app()->request->getCsrfToken();
	}
	
	public function run()
	{
		
?>
		
	<script language="javascript">
	function CKupdate() {
				for (instance in CKEDITOR.instances)
					CKEDITOR.instances[instance].updateElement();
			}
	CKEDITOR.editorConfig = function( config ) {
		config.language = '<?php echo Yii::t('editor',Yii::app()->language);?>';
		// Define changes to default configuration here.
		// For the complete reference:
		// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	
		// The toolbar groups arrangement, optimized for two toolbar rows.
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
		config.filebrowserImageUploadUrl = '<?php echo $this->upload_img_file?>';
		config.filebrowserFlashUploadUrl = '<?php echo $this->upload_flash_file?>';
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
	
	protected function registerClientScript()
	{

		
		$cs=Yii::app()->clientScript;
	    $cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/ckeditor/ckeditor.js");
		
		
		
	}
}