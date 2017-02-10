<?php

namespace app\module\upf\controllers;

use yii;
use yii\base\Controller;
use app\extension\dirUtil;
use app\extension\Util;

//附件
class UpfController extends Controller
{
	public $layout = 'main';
    public $assetsUrl;
    
	private $tag=""  ; //前缀
	private $dir;   //上传路径
	private $auto='true';//自动上传
	private $style="0";
	private $ext = '*.gif;*.jpg;*.png;*.jpeg;*.bmp';//上传文件类型限制
	private $max_num =10;//最大上传文件数目
	private $max_size = '1000KB';//最大上传文件大小
	private $multi='true';//允许上传多个
	private $rename=0;   //重命名 1 重命名
	private $model="public"; //上传图片模块 
	private $allselect=1; //1 全部选择  
	private $thumb=""; //缩略//$thumb="100X129,400X129"; //缩略
	private $thumbImg=""; //缩略//$thumb="100X129,400X129"; //缩略
	private $url ;
	private $shui; //水印图片 例如 1.png
	private $st; //缩图 例如 192*168
	private $pic ;
    
	
	public function init()
	{
        //$this->pic = "uploads/oday/content/2014/07/17/1.jpg";
		$this->url=Yii::$app->request->baseUrl;
        
  		//(-------------------------接受传值-------------------)
		//文件格式
		if(isset($_REQUEST['ext'])&&$_REQUEST['ext']!='')
		{
			$this->ext = $_REQUEST['ext'];
		}
		//水印图
		if(isset($_REQUEST['thumbImg'])&&$_REQUEST['thumbImg']!='')
		{
			$this->thumbImg = $_REQUEST['thumbImg'];
		}
		//缩略大小
		if(isset($_REQUEST['thumb'])&&$_REQUEST['thumb']!='')
		{
			$this->thumb = $_REQUEST['thumb'];
		}
		//最大上传文件数目初始化
		if(isset($_GET['max_num'])&&$_GET['max_num']!='')
		{
			$this->max_num = $_GET['max_num'];
		}
		//允许上传多个
		if(isset($_GET['multi'])&&$_GET['multi']!='')
		{
			$this->multi = $_GET['multi'];
		}
		//自动上传
		if(isset($_GET['auto'])&&$_GET['auto']!='')
		{
			$this->auto = $_GET['auto'];
		}
		//最大上传大小
		if(isset($_GET['max_size'])&&$_GET['max_size']!='')
		{
			$this->max_size = $_GET['max_size'];
		}
		//模块名称
		if(isset($_REQUEST['model'])&&$_REQUEST['model']!='')
		{
			$this->model = $_REQUEST['model'];
		//	echo $this->model;
		}
        //资源id
		if(isset($_REQUEST['assetsUrl']) && $_REQUEST['assetsUrl']!='')
        {
            $this->assetsUrl = Yii::$app->request->baseUrl.'/assets/'.$_REQUEST['assetsUrl'];
        }
        /*
		//重命名
		if(isset($_COOKIE['rename'])&&$_COOKIE['rename']!='')
		{
			 $this->rename = $_COOKIE["rename"];
		}
		*/
		if(isset($_REQUEST['rename']))
		{
			$this->rename = $_REQUEST['rename'];
		}
		/*shui*/
		if(isset($_REQUEST['shui']))
		{
			$this->shui = $_REQUEST['shui'];
		}
		if(isset($_REQUEST['st']))
		{
			$this->st = $_REQUEST['st'];
		}
		$tname = "daotu";
		//预处理
		if(!empty($_REQUEST['style']))
		{
			$tname="contents";
			$this->style = 1; 
		}
		$this->dir =  $this->url."/uploads/".$this->model."/".$tname."/".date("Y")."/".date("m")."/".date("d")."/"; 
		if($this->thumb)
        {
			$this->thumb =  explode(",", $this->thumb);
		}
		if($tbimg = $this->thumbImg)
        {
			if(!stristr($tbimg,"无水印")) $tbimg = $tbimg.",无水印|0";
			$this->thumbImg =  explode(",", $tbimg);
		}
	}
	
	public function actionIndex()
	{       
        $dirs      = str_replace( $this->url."/", "", $this->dir);
        $dirlist   = dirUtil::dir_list($dirs) ;
        $newdirArr = $anewdirArr = array();

        foreach($dirlist as $key=>$r)
        {
            //$images =  Yii::$app->imagemod->load($r) ;
            $anewdirArr[$key]["dir"] = $r; 	
            $anewdirArr[$key]["time"] = filemtime($r);
            $anewdirArr[$key]["date"] = date("Y-m-d G:i:s",filemtime($r));
            //$anewdirArr[$key]["type"] = $images->file_src_mime;
            //$anewdirArr[$key]["size"] =  formatBytes($images->file_src_size); 	
            $anewdirArr[$key]["size"] =  filesize($r); 
		} 
	 
		$anewdirArr = Util::array_sort($anewdirArr,"time","desc");
        $allfiles = array();
        
        foreach($anewdirArr as $key=>$row){
            if( !strpos($row["dir"],"584_") 
                && !strpos($row["dir"],"927_")
                && !strpos($row["dir"],"120X90_")
                && !strpos($row["dir"],"100X129_")
                && !strpos($row["dir"],"195X_")
            ){
                 $allfiles[$key] = $row;
                 $allfiles[$key]["dir"]=$row["dir"];
            }
        }	 
	    
        return  $this->render("index",
                array(
                    "auto"=>$this->auto,
                    "ext"=>$this->ext,
                    "max_num"=>$this->max_num,
                    "max_size"=>$this->max_size,
                    "multi"=>$this->multi,  
                    "thumb"=>$this->thumb, 
                    "thumb1"=>$_GET['thumb'],
                    "thumbImg"=>$this->thumbImg, 
                    "thumbImg1"=>$_GET['thumbImg'], 
                    "model"=>$this->model, 
                    "dirlist"=>$allfiles,  
                    "dirs"=>$dirs, 
                    "allselect"=>$this->allselect, 
                    "style"=>$this->style, 
                )
            );
	}
	
	//上传动作
    public function actionUpload()
    { 
    	$targetFolder1 =  str_replace(strstr($this->dir,'uploads', true), "", $this->dir); // Relative to the root
    	$targetFolder  =   $this->dir ; // Relative to the root
    	$fileTypes= array();
    	$verifyToken = md5('unique_salt' . $_POST['timestamp']);
    	$this->model = $_POST["model"];
    	if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
    		
    		$tempFile = $_FILES['Filedata']['tmp_name'];
    		$targetPath = $_SERVER['DOCUMENT_ROOT'] ."/". ltrim($targetFolder,'/'); 
            
    		Util::folder($targetFolder1);
            
    		//重命名判断  
    		if($this->rename)
            {    
    			$targetFile =  '/'.$this->tag.''.date("Ymdgis").rand(0, 1000).".". Util::fileext($_FILES['Filedata']['name']) ;
    		}else{
    			$targetFile =   '/'. str_replace(" ", "", ($_FILES['Filedata']['name']));
            }
    		$targetFile1 = iconv("UTF-8","gb2312", $targetFile);

    		$ar = explode(";",$this->ext);
    		
    		foreach($ar as $type)
    		{
    			$fileTypes[] = str_replace("*.", "", $type);
    		}
    		$fileParts = pathinfo($_FILES['Filedata']['name']);
    	    
    	    if (in_array($fileParts['extension'],$fileTypes)) 
            {
    	    	move_uploaded_file($tempFile, rtrim($targetPath,'/') .$targetFile1);
    	    	$output =  str_replace("..".$this->url,$this->url, rtrim($targetFolder,'/').$targetFile);
    	    	 
				$file =   iconv("UTF-8","gb2312", $output);
				$file= str_replace($this->url."/", "", $file);
				$this->pic = $file;
		        $this->sctb();
    	    	echo   rtrim($targetPath,'/') .$targetFile1."|".$output."|".$this->model;
     		} else {
    			echo 'Invalid file type.';
    		}
    	}
    }
	
	/*
	  自动根据模块生成缩略图||水印
	  配合 params["picupload"]使用
	*/
	public function sctb()
	{  
 	    $type ="daotu";
	    if($this->style) $type = "contents";
        if( isset(Yii::$app->params["picupload"][$this->model]["thumb"][$type]))
        {    
            $TbArr = Yii::$app->params["picupload"][$this->model]["thumb"][$type];
            foreach($TbArr as $r)
            {
               $this->scthumb($r["size"],$r["watermark"]);
            } 		 
		}
  	}
	
	/*缩略图和加水印操作*/
	public function scthumb($size,$watermark)
	{
	   /*获取原图宽高*/
	   $file = $this->pic;
	   $fileA =  explode("/",$file); 
	   $basename = $fileA[count($fileA)-1];
 	   $imageinfo=getimagesize($file);
	   $w =  $imageinfo[0];
	   $h =  $imageinfo[1];
	   
	   preg_match("/[^\d]+/",$size,$matchArr);
	   $split = $matchArr[0];
	   $with = $size;
	   $height = 0;
	   $splits = "";
	   if($split)
	   {
			$sizeArr = explode($split,$size) ;
			$width = !empty($sizeArr[0])?$sizeArr[0]:"";
			$height=!empty($sizeArr[1])?$sizeArr[1]:0; 
			/*如果高度为空 则按照宽度计算同比例高度 
			*/
			if(!$height)  $height = intval(($width/$w)*$h);
			$splits = $split;
	   }else{
	        $width =  $size;
		    $height = "";
	   }
		$name =   $width.$splits.$height;
		$targetdir =  str_replace($basename,"",$file) ;
    	$target = $targetdir.$name."_".$basename;
	    /*如果大于原图宽度直接复制*/
        if($width>=$w){
             file_put_contents($target,file_get_contents($file));
		}else{
			if(!$height)  $height = intval(($width/$w)*$h);
			$img = Yii::$app->simpleImage->load($file);
		    $img->resize($width,$height);
			$img->save($target);
		}
		/*水印*/
		if($this->shui){
			if($watermark){  
			$wimg = "public/images/thumb/".$this->shui;
			$img = Yii::$app->imagemod->load($target);
			$img->file_overwrite =  true;
			$img->image_watermark       = $wimg ;
			$img->image_watermark_position = 'R,b';
			$img->image_watermark_y     = -7;
			$img->process($targetdir);
			$img->image_unsharp         = false;
			$img->processed;
			}
		}

	}
	
}