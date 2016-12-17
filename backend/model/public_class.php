<?php
  /*
    公共类 各种公共部分相关
   */
  class public_class
  {  
       /*所有频道内容图片处理
	      $content 内容
		  $style 0=默认模式 给图片加上a链接 
		         1=新闻模式 点击幻灯大图 需配合js 
		  return $content;		 
	   */
       static function picdispose($content,$style=0)
	   {
          //替换584_	
		 $content = preg_replace('/(\/admin\/uploads\/[a-zA-Z]*\/contents\/[0-9]*\/[0-9]*\/[0-9]*\/)(584)_/i',"$1",$content);
	      preg_match_all('/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/',$content,$matches);
		  $rp = "uploads/";
		  $i=0;
		  foreach($matches[1] as $key=>$url)
		  {
 		    if(strchr($url,"/admin/"))
			{
			   $urls = str_replace("/admin/","",$url);
			   /*取出模块*/
			   $parr = explode("/",str_replace($rp,"",$urls));
			   $model =  $parr[0];
			   $type =   $parr[1];
			   $replace = $rp.$model."/".$type."/";			   
			    /*读取ftp 并且上传*/
  			   //$ftpinfo = get_ftp($model);
			   $r = Yii::app()->params['ylyftp_pic'];
			   if($r){
			   if($i==0)
			   {  
			      $ftp = new ftp($r["host"],$r["port"],$r["usr"],$r["pwd"]);
			   }			   
			   /*取出缩图信息*/
		       $fileA =  explode("/",$urls); 
	           $basename = $fileA[count($fileA)-1];
			   $TbArr = Yii::app()->params["picupload"][$model]["thumb"][$type];
			   $splits = "";			 
			   $linktargetpic = implode('/',array_slice($parr,2,count($parr)-2));
			   /*同步缩略图*/			   			 
			   foreach($TbArr as $rs)
			   {
				 $size = $rs["size"];
				 preg_match("/[^\d]+/",$size,$matchArr);
				 $split = $matchArr[0];
				 $splits="";
				 if($split)
				 {
					$sizeArr = explode($split,$size) ;
					$width = !empty($sizeArr[0])?$sizeArr[0]:"";
					$height=!empty($sizeArr[1])?$sizeArr[1]:0; 
					/*如果高度为空 则按照宽度计算同比例高度*/
					//if(!$height)  $height = intval(($width/$w)*$h);
					$splits = $split;
				 }else{
					$width =  $size;
					$height = "";
				 }
				   $name =   $width.$splits.$height;				   				  				 
				   $targetdir =  str_replace($basename,"",$urls) ;
    	           $yuan = $targetdir.$name."_".$basename;
				   $target = str_replace($replace,"",$yuan);/*584原图*/ 
			//	   $target = str_replace("2014/","test/",$target);
			       $ftp->up_file($yuan,$rp.$model."/".$target); 
				   if($size=="584") $linktargetpic = $target;
				  // echo $name."<br>";
			   } 		
			   			 
			   /*原图*/ 
               $target_url = str_replace($replace,"",$urls);
		//	   $target_url = str_replace("2014/","test/",$target_url); 
			   $ftp->up_file($urls,$rp.$model."/".$target_url); 
			   /*---------处理内容返回---------*/
			   /*默认简单模式*/
			   if(!$style)
			   {
			       $replaceurl = "<a target=\"_blank\" href=\"http://img.game333.net/".$rp.$model."/".$target_url."\">".$matches[0][$key]."</a>";
			       $content = str_replace($matches[0][$key],$replaceurl,$content);
			       $content = str_replace($url,"http://img.game333.net/".$rp.$model."/".$linktargetpic.'" alt="'.($model=="shouyou" ? "游乐园手游 m.game333.net" : "游乐园单机 www.game333.net").'',$content);
			   }
			   /*新闻模式*/
			   if($style==1){			 
			       $replaceurl = "<a href=\"javascript:void(0);\"><img id=\"img".$i."_1\" alt=\"游乐园\" onclick=\"showbigpic(this,'".$r["url"].$target_url."')\" onmouseover=\"showMenu({'ctrlid':this.id,'pos':'12'})\" src=\"".$r["url"].$linktargetpic."\" /></a>";
			       $content = str_replace($matches[0][$key],$replaceurl,$content);			    
			   }			 
			   /*专题首页推荐/系列专题/内容模式*/
			   if($style==2){
			       $content = str_replace($url,$r["url"].$target_url,$content);
			   }			   
			   /*---------处理内容返回---------*/			  
			  /* 
			   echo $url."----".$target_url."<br>";
			   echo $stb."--".$target_stb."<br><br><br>";
             */	
			  	  $i++;	
              }			 				 
			}
		  }
		    if($i>0)$ftp->close();/*关闭ftp*/
		    return $content;	 
	   }   
  }

 