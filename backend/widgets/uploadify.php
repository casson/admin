<?php

namespace app\widgets;

use Yii;
use yii\Helpers\Html;
use yii\base\Widget;

/**附件上传组件
*结合upf模块使用  
* mode  1:多图片上传  
* 注意: 所有频道的水印图片 均要放到  public/images/thumb/ 下面 
*/
class Uploadify extends Widget
{
	
	private $_assetsUrl;//资源文件路径
    private $assetsId;//资源id
	public $result_name='pic_list';//最终保存缩略图路径的隐藏域名称
	public $mode=0;//模式
	public $style=0;//类型
	public $ext = '*.gif;*.GIF;*.jpg;*.JPG;*.png;*.PNG;*.jpeg;*.JPEG';//上传文件类型限制
	public $max_num =1;//最大上传文件数目
	public $max_size = '300KB';//最大上传文件大小
	 
 
	public $thumbImg="文字|1.png,图片|2.png"; //缩略//$thumb="100X129,400X129"; //缩略
	public $thumb=""; //缩略//$thumb="100X129,400X129"; //缩略
	
	public $multi='false';//允许上传多个
	public $auto='false';//自动上传
	public $module;//模块名称

	public $file_list;//已上传文件 
	public $model ;
	public $base_url;
	public $cname; //唯一标识识别
	public function init()
	{
	    $this->model = Yii::$app->controller->module->id;
		$this->base_url = Yii::$app->request->hostInfo.Yii::$app->homeUrl;
		$this->registerClientScript();
	}
	//上传多张图片
	public function uploadMultiImg()
	{
			$form_id = 'upload';
			$title = "图片上传";
			$url = Yii::$app->urlManager->createAbsoluteUrl('upf/upf/')."?ext=".$this->ext."&max_num=".$this->max_num."&cname=".$this->cname."&max_size=".$this->max_size."&multi=".$this->multi."&auto=".$this->auto."&thumbImg=".$this->thumbImg."&thumb=".$this->thumb."&style=".$this->style."&model=".$this->model."&assetsUrl=".$this->assetsId;
			$html="";
			$label =" 上传图片";
			if($this->style==1)
			{
                $label = "  上传图片到编辑器";
                $script = "";
			}
			if($this->style==2)
			{
                $label = "  添加组图";
			}
			 /*
		 	$html.="<span   style='color:#fff;font-weight:bold;color:#666' class=\"multi_pic_btn\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."','".$this->cname."')\" >".$label."</span>";
			*/
			$html.="<input type=\"button\" class=\"default_btn\"  onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."','".$this->cname."')\" value='".$label."'>";
			echo $html;
	}
 
	public function run()
	{
        $this->uploadMultiImg();
	}
	
	protected function registerClientScript()
	{
      	//调用attachment模块的资源文件
		$this->_assetsUrl = Yii::$app->getAssetManager()->publish(Yii::getAlias('@backend/module/upf/assets'));
        $this->_assetsUrl = $this->_assetsUrl[1];
        $this->assetsId   = pathinfo($this->_assetsUrl, PATHINFO_BASENAME); 
        
        echo Html::cssFile($this->_assetsUrl.'/css/common.css?111');
	    echo Html::jsFile($this->_assetsUrl.'/js/common.js?'.time());
		//artdialog
		echo Html::jsFile(Yii::$app->request->baseUrl."/public/js/art_dialog/artDialog.source.js?skin=blue");
		echo Html::jsFile(Yii::$app->request->baseUrl."/public/js/art_dialog/plugins/iframeTools.source.js");
		echo Html::jsFile(Yii::$app->request->baseUrl."/public/js/art_dialog/_doc/highlight/highlight.pack.js");
		echo Html::jsFile(Yii::$app->request->baseUrl."/public/js/art_dialog/_doc/highlight/languages/javascript.js");
	}
}