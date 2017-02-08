<?php

/**
*附件处理
*/
class AttachmentWidget extends CWidget
{
	
	private $ds = DIRECTORY_SEPARATOR;//目录分割符
	private $root_folder_name;//文件存放根最上层目录名称
	private $root_path;//储存文件顶级目录
	private $root_url ;//文件上传目录路径对应的url
	
	public  $dir_arg; //目录生成所需参数
	public  $file_list;//文件信息
	public  $read=0;
	public  $filename_list;//前端传过来的文件名列表
	public  $base_path ;
	public  $base_url;//项目url
	public  $owner_id;//属主ID
	public  $owner_type;//属主类型 0:用户 1:场所
	public  $modifier;//操作人员ID
	public  $file_checked;
	public  $file_order;
	public function init()
	{
		
		$this->root_folder_name = Yii::app()->params['rootUploadFolder'];//文件存放根最上层目录名称
		$this->base_url = Yii::app()->request->hostInfo.Yii::app()->homeUrl ;
		$this->base_path =rtrim(dirname(Yii::app()->BasePath),$this->ds); ;// 项目路径
		Yii::import('application.inc.dirFunc',true);//引入目录操作函数
		$this->root_path = $this->ds.$this->root_folder_name.$this->ds;
		$this->root_url = str_replace($this->ds,'/',Yii::app()->request->baseUrl.$this->root_path);
	
	}
	public function run()
	{
		if($this->read==0)
		{
			return $this->processFileList();
		}
		else
		{
			return $this->getFileList();
		}
	}
	
	
	/** 处理批量上传的文件
	* array $dir_arg 目录生成所需参数
	* array $pic_list 文件列表 
	*/
	public function processFileList()
	{
		
		
		$target_folder = $this->owner_type;
		
		if(!is_array($this->file_list))
		{
			$temp[0] = $this->file_list;
			$this->file_list = $temp;
		}
		for($i=0;$i<count($this->dir_arg);$i++)
		{
			$target_folder.= $this->ds.$this->dir_arg[$i];//目标目录
	
		}
		$target_folder = $this->base_path.$this->root_path.$target_folder;
		
		dir_create($target_folder);//生成存储目录或返回
		//删除数据库中已经存在的记录及文件
		
		$exist_file_list = Album::model()->with()->findAll(array('condition'=>'owner_id=:owner_id and owner_type=:owner_type','params'=>array(':owner_id'=>$this->owner_id,':owner_type'=>$this->owner_type)));
		foreach($this->file_list as $key=>$value)
		{
			$url_list[]=str_replace(Yii::app()->params['cloudPic'],'',$value);
		}
		foreach($exist_file_list as $o)
		{
			
			if(!in_array($o->attachment->file_path,$url_list))
			{
				Attachment::model()->deleteByPK($o->attachment_id);
				
				Album::model()->deleteAll(array('condition'=>'owner_id=:owner_id and owner_type=:owner_type and attachment_id=:attachment_id','params'=>array(':owner_id'=>$this->owner_id,':owner_type'=>$this->owner_type,':attachment_id'=>$o->attachment_id)));
			}
				
			
		}
		
		
		
		
		
		//拷贝文件并写库
		foreach($this->file_list as $key=>$original_value)
		{
			
			$attachment = new Attachment;
			
			$value = $this->ds.ltrim(str_replace($this->base_url,'',$original_value),$this->ds);

			//路径处理
			$value = $this->base_path.str_replace(array('/', '\\'),$this->ds,$value);
			
			if((is_file($value)&&file_exists($value)))
			{	
				
				
				$pathinfo = pathinfo($value);
				
				$target_file = $target_folder.$this->ds.$pathinfo['basename'];
				
				//从临时目录复制到真实目录(前提是系统中不存在该文件)
				if(copy($value,$target_file)){
					//@unlink($value);
					//上传到网盘
					
				
				    $uploadobj = new UploadFile($this->owner_type,$this->owner_id);
					$file_path = $uploadobj->upload($target_file);
					$file_path =  str_replace(Yii::app()->params['cloudPic'],'',$file_path);
			
					//$attachment->file_path = str_replace($this->ds,'/',str_replace($this->base_path,"",$target_file));
					$attachment->file_path = $file_path;
					$attachment->file_size = filesize($target_file);
					if($this->filename_list[$key]=='')
					{
						$attachment->file_name = basename($target_file);
					}
					else
					{
						$attachment->file_name = $this->filename_list[$key];
					}
					
					$attachment->file_extname =  $pathinfo['extension'];
					$attachment->created_time = date('Y-m-d H:i:s');
					$attachment->modifier = $this->modifier;
					if($attachment->save())
					{
						
						$album = new Album;
						$album->attachment_id = Yii::app()->db->getLastInsertID();
						$album->owner_id =$this->owner_id;
						$album->created_time =date('Y-m-d H:i:s');
						$album->owner_type = $this->owner_type;
						
						$album->is_cover = $this->file_checked[$key];
						if(count($this->file_list)==1)
						{
							$album->is_cover =1;
						}
						$album->list_order = $this->file_order[$key];
						$album->save();
						
					}
					else
					{
						return false;
					}
				}
			}
			else
			{
				if(!empty($original_value)){
					$original_value = str_replace(Yii::app()->params['cloudPic'],'',$original_value);
					
					
					$attachment = Attachment::model()->find("file_path='".$original_value."'");
					if(!empty($attachment))
					{
						$album = Album::model()->find("attachment_id='".$attachment->id."'");
						
						$album->is_cover = $this->file_checked[$key];
						if(count($this->file_list)==1)
						{
							$album->is_cover =1;
						}
						$album->list_order = $this->file_order[$key];
						$album->save();
					}
				}
			}				
		}

	}
	
	//读取记录关联文件
	public function getFileList()
	{
		$criteria = new CDbCriteria;
		$criteria->condition = "t.owner_id=".$this->owner_id." and t.owner_type = ".$this->owner_type." ";
		$this->file_list = Album::model()->with()->findAll($criteria);
		return $this->file_list;
		
		
	}
	
	
	
}