<?php
/*
作者 :张仁美
时间 :2014年7月21日
用法
<?php $this->widget('ext.ubutton',array('cname'=>"video","class"=>"ckeditor"));?>
<?php $this->widget('ext.ubutton',array('cname'=>"special","class"=>"ckeditor"));?>
<?php $this->widget('ext.ubutton',array('cname'=>"pic","class"=>"ckeditor"));?>
<?php $this->widget('ext.ubutton',array('cname'=>"link","class"=>"ckeditor"));?>
*/
class ubutton extends CWidget
{
	
	private $_assetsUrl;//资源文件路径
	public $cname; //唯一标识识别
	public $title; //标题
	public $class; //id

	public function init()
	{
		$this->title=$this->gettitle($this->cname);
		$this->registerClientScript();
	}

	private function gettitle($cname){
	
	    switch($cname){
		   
            case "video":
				return "选择视频";
			break;
			case "idvideo":
				return "选择视频";
				break;
			case "idpic":
				return "选择图片";
			break;
			case "special":
				return "选择专题";
			break;
			case "pic":
				return "选择图库图片";
			break;
			case "link":
				return "选择链接";
			break;
			case "indexpic":
				return "图库图片";
			break;
			case "htmltoubb":
				return "转UBB代码";
			break;
			case "newsid":
				return "选择评测";
			break;
					
		}

	}

	public function cycini()
	{
			$form_id = 'ubutton';
			$title=$label=$this->title;
			switch($this->cname){
			    case "video":
				   $url = Yii::app()->createUrl('ubutton/ubutton/video');
			       break;
			    case "special":
				   $url = Yii::app()->createUrl('ubutton/ubutton/special');
			       break;
			    case "pic":
				   $url = Yii::app()->createUrl('ubutton/ubutton/pic');
			       break;
			    case "link":
				   $url = Yii::app()->createUrl('ubutton/ubutton/link');
			       break;
				case "indexpic":
				   $url = Yii::app()->createUrl('ubutton/ubutton/indexpic');
			       break;
			    case "htmltoubb":
			       	$url = Yii::app()->createUrl('ubutton/ubutton/htmltoubb/class/'.$this->class);
			    break;
			    case "idvideo":
			    	$url = Yii::app()->createUrl('ubutton/ubutton/idvideo');
			    break;
			    case "idpic":
			    	$url = Yii::app()->createUrl('ubutton/ubutton/idpic');
			    break;
			    case "newsid":
			    	$url = Yii::app()->createUrl('ubutton/ubutton/newsid?class='.$this->class);
			    break;
			}
			
			$html="";
			/*
			$html.="<span  style='color:#fff;font-weight:bold;color:#666' class=\"multi_pic_btn\" onclick=\"javascript:showDialogs('".$url."','".$form_id."','".$title."','".$this->class."','".$this->cname."')\" >".$label."</span>";
			*/
			$html.="<input type=\"button\" class=\"default_btn\"  onclick=\"javascript:showDialogs('".$url."','".$form_id."','".$title."','".$this->class."','".$this->cname."')\" value='".$label."'>";
			echo $html;
	}
 
	public function run()
	{
	    $this->cycini();
	}
	
	protected function registerClientScript()
	{
      	//调用attachment模块的资源文件
		$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.ubutton.assets'));
		$cs=Yii::app()->clientScript;
		$cs->registerCssFile($this->_assetsUrl.'/css/common.css');
	    $cs->registerScriptFile($this->_assetsUrl.'/js/common.js');
		//artdialog
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/art_dialog/artDialog.source.js?skin=blue");
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/art_dialog/plugins/iframeTools.source.js");
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/art_dialog/_doc/highlight/highlight.pack.js");
		$cs->registerScriptFile(Yii::app()->request->baseUrl."/public/js/art_dialog/_doc/highlight/languages/javascript.js");
		
		
	}
}