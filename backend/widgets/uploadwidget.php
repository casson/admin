<?php

/**附件上传组件
*结合attachment模块使用，完全使用attachment模块资源
*结合artdislog js组件使用
* mode 0:内容页缩略图 1:多图片上传  2:多文件上传
*/
class UploadWidget extends CWidget
{
	
	private $_assetsUrl;//资源文件路径
	public $result_name='pic_list';//最终保存缩略图路径的隐藏域名称
	public $mode=0;//模式
	public $ext = '*.gif; *.jpg; *.png;*.jpeg';//上传文件类型限制
	public $max_num =1;//最大上传文件数目
	public $max_size = '300KB';//最大上传文件大小
	public $resize =0;//上传后是否先进行缩略
	public $resize_width=320;//缩略宽度
	public $resize_height=320;//缩略高度
	public $cut_width=320;//裁切宽度
	public $cut_height=320;//裁切高度
	public $multi='false';//允许上传多个
	public $auto='false';//自动上传
	public $module;//模块名称

	public $file_list;//已上传文件
	public $thumb;//已上传的缩略图
	public $base_url;
	public function init()
	{
		$this->base_url = Yii::app()->request->hostInfo.Yii::app()->homeUrl;
		$this->registerClientScript();
	
	}
	//内容缩略图
	public function contentThumb()
	{
	

		$form_id = 'upload';
		$title = "附件上传";
		
		$url = Yii::app()->createUrl('attachment/Attachment/UploadFileToThumb')."?ext=".$this->ext."&max_num=".$this->max_num."&max_size=".$this->max_size."&resize=".$this->resize."&resize_width=".$this->resize_width."&resize_height=".$this->resize_height."&multi=".$this->multi."&auto=".$this->auto;
		
		$cut_form_id = 'cut';
		$cut_title="裁切图片";
		$cut_url = Yii::app()->createUrl('attachment/Attachment/CutFileToThumb')."?ext=".$this->ext."&max_num=".$this->max_num."&max_size=".$this->max_size."&resize=".$this->resize."&cut_width=".$this->cut_width."&cut_height=".$this->cut_height."&multi=".$this->multi."&auto=".$this->auto;
		
		$html="";
		$html.="<div  class=\"small_content_right\">";
		$html.="<div  class=\"thumb_block\">";
		
			
		if(!empty($this->thumb))
		{
			$html.="<a  href=\"javascript:void(0)\"    style='display:none' class=\"add_thumb_trigger\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."')\"></a>";
			$temp_path = $this->thumb[0]->attachment->file_path;
		
			$html.="<img src=\"".$temp_path."\" style='display:block' class=\"thumb_img\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."')\">";
		}
		else
		{
			$html.="<a href=\"javascript:void(0)\" class=\"add_thumb_trigger\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."')\"></a>";
			$html.="<img class=\"thumb_img\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."')\">";
		}
		$html.="<input type=\"hidden\" id=\"".$this->result_name."\" name=\"".$this->result_name."\" value=\"".$temp_path."\">";
		$html.="<div  class=\"thumb_btn_block\">";
		$html.="<div class=\"thumb_btn_ctn\">";
		$html.="<div class=\"thumb_cut_btn\" onclick=\"javascript:showCutFileToThumbBlock('".$this->result_name."','".$cut_url."','".$cut_form_id."','".$cut_title."')\">裁切图片</div><div class='thumb_cancel_btn' onclick=\"javascript:cancelThumbOrignal('".$this->result_name."')\">取消图片</div></div>";
		$html.="</div></div></div></div>";
		echo $html;
	
	}
	//上传多张图片
	public function uploadMultiImg()
	{
			$form_id = 'upload';
			$title = "附件上传";
		
			 $url = Yii::app()->createUrl('attachment/Attachment/UploadFileToThumb')."?ext=".$this->ext."&max_num=".$this->max_num."&max_size=".$this->max_size."&resize=".$this->resize."&resize_width=".$this->resize_width."&resize_height=".$this->resize_height."&multi=".$this->multi."&auto=".$this->auto;
			 
			$html="";
			$html.="<div  class=\"multi_pic_block f5_border\" id='imglist'>";
			$html.="<fieldset class=\"multi_pic\" id='multi_pic_filedset' >";
			$html.="<legend>列表</legend>";
			//如果已经存在图片
			if($this->file_list!='')
			{
				$i=0;
				foreach($this->file_list as $o)
				{
					
					$html.="<div class='pic_unit' id='pic_unit_".$i."' style=\"width:150px;height:200px;float:left;margin:5px;padding:5px;text-align:center;background:#f5f5f5;border:1px solid #ccc\">";
					$temp_path =$o->attachment->file_path;
					if(!preg_match('/^http.*/i',$temp_path))
					{
						$temp_path = Yii::app()->params['cloudPic'].$temp_path;
					}
					$html.="<img src='".$temp_path."' style=\"width:100px;height:100px;\">";
					$html.="<input type='hidden' name='".$this->result_name."[".$i."]'  value='".$temp_path."'  class='pic_url_now' />";
					$html.="<input type=\"hidden\" name='filename_list[".$i."]'  value='".$o->attachment->file_name."'    class=\"original_url\"/>";
					$html.="<div style=\"width:150px;float:left;text-align:left;\">封面:<input type=\"checkbox\" name='file_checked[".$i."]'  value='1'";
					if($o->is_cover)
					{
						$html.=" checked=\"checked\" ";
					}
					$html.="/></div><div style=\"width:150px;float:left;text-align:left;\">排序:<input type=\"text\" name='file_order[".$i."]'  value='".$o->list_order."'  size='10'  /></div>";
					
					$html.="<div style=\"width:150px;float:left;text-align:left;\"><div style=\"width:90px;height:20px;overflow:hidden;float:left\">".$o->attachment->file_name."</div><div style=\"float:left;\"><a class=\"delete_pic_unit\"  title=\"".$o->attachment->file_name."\"style=\"float:left\" onclick=\"$('#pic_unit_".$i."').remove();\" href=\"javascript:void(0)\">移除</a></div></div>";
					$html.="</div>";
					$i++;
				}
			}
			
			$html.="</fieldset>";
			$html.="<div class=\"multi_pic_btn\" onclick=\"javascript:showUploadBlock('".$this->result_name."',".$this->mode.",'".$url."','".$form_id."','".$title."')\" >添加图片</div>";
			$html.="</div>";
			echo $html;
	}
	//上传多个文件
	public function uploadMultiFile()
	{
		
	
	}
	public function run()
	{
		
		if($this->mode==0)
		{
			$this->contentThumb();
		}
		else if($this->mode==1)
		{
			$this->uploadMultiImg();
		}
		else
		{
			$this->uploadMultiFile();
		
		}
		
	
	}
	
	protected function registerClientScript()
	{
      	//调用attachment模块的资源文件
		$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.attachment.assets'));
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