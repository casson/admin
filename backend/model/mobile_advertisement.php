<?php
 
class mobile_advertisement extends logCAr
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function relations(){
		return array(
			 	//'author'=> array(self::BELONGS_TO, 'mh_author', 'authorid'), //可以不保持一致
		);
	}
	
	/* reset db */
	public function getDbConnection()
	{ 
	  self::$db=Yii::app()->db6;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{advertisement}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'pid' => Yii::t('shouyou','pid'),  
			'fid' => Yii::t('shouyou','fid'),  
			'rid' => Yii::t('shouyou','rid'),  
			'lid' => Yii::t('shouyou','lid'),  
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('pid,fid,rid,lid,title', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true,"or");  
	 	$criteria->compare('pid',$this->pid,true);  
	 	$criteria->compare('fid',$this->fid);  
	 	$criteria->compare('lid',$this->lid);  
	 	$criteria->compare('rid',$this->rid,true);  
 		$criteria->order='addtime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static function cacheAds()
	{
		$result = self::model()->findAllBySql('select id,title from advertisement');
		foreach ($result as $value) $narr[$value->id] = $value->title;
		file_put_contents('data/shouyou/allads', json_encode($narr));
	}
	
	static function scAdvertisementScript()
	{
		$adswitcher = @file_get_contents('data/shouyou/adswitcher');
		$farr['switcher'] = (int) $adswitcher;
		if ($farr['switcher'])
		{
			$result = self::model()->findAllBySql('select id,pid,fid,rid,lid,title,brief,url from advertisement where valid=1 order by pid asc,lid asc');
			foreach ($result as $value)
			{
				$parr = explode(',', $value->pid);
				foreach ($parr as $pkey)
				{
					$farr[$pkey][$value->lid][] = array(
							'range' => $value->rid,
							'model' => $value->fid,
							'content' => self::getContent($value->fid,$value->id,$value->url,$value->title,$value->brief),
					);
				}
			}
		}
		$scriptstr = '$(document).ready(function(){
				var ojson = '.json_encode($farr).';
				if (ojson[\'switcher\'] == 1){
						if(/iPhone|iPod|iPad/i.test(navigator.userAgent)){
							var farr = ojson[1];
						}else{
							var farr = ojson[2];
						}
						
						if (typeof(farr) != \'undefined\'){
							var rurl = location.href;
							if (rurl.indexOf(\'http://3g.ali213.net/news\') != -1){
								var rkey = 1; //1是资讯
							}else if(rurl.indexOf(\'http://3g.ali213.net/gl\') != -1){
								var rkey = 2; //2是攻略
							}else if(rurl.indexOf(\'http://game.ali213.net/\') != -1){
								var rkey = 3; //3论坛
							}else if(rurl.indexOf(\'http://3g.ali213.net/pic\') != -1){
								var rkey = 4; //4图库
							}else if(rurl.indexOf(\'http://3g.ali213.net/yxk\') != -1){
								var rkey = 5; //5游戏库
							}else if(rurl.indexOf(\'http://manhua.ali213.net/touch\') != -1){
								var rkey = 6; //6漫画
							}else if(rurl.indexOf(\'http://m.ali213.net/touch\') != -1){
								var rkey = 7; //7手游
							}else if(rurl.indexOf(\'http://m.v.ali213.net\') != -1){
								var rkey = 8; //8视频
							}
							//bottom 1
							var botarr = new Array();
							for (var bx in farr[1]){
								if (farr[1][bx][\'range\'].indexOf(rkey) != -1) botarr.push(farr[1][bx]);
							}
						
							//top 2
							var toparr = new Array();
							for (var tx in farr[2]){
								if (farr[2][tx][\'range\'].indexOf(rkey) != -1) toparr.push(farr[2][tx]);
							}
						
							//mid 3
							var midarr = new Array();
							for (var mx in farr[3]){
								if (farr[3][mx][\'range\'].indexOf(rkey) != -1) midarr.push(farr[3][mx]);
							}
						
							if (botarr.length >0 || toparr.length >0 || midarr.length >0) $("head").append("<link rel=\"stylesheet\" href=\"http://3g.ali213.net/common/css/promotion.css?ver="+Math.random()+"\">");
							
							//top
							if (toparr.length >0){
								var toprkey = Math.floor(Math.random() * toparr.length);
								$(document.body).prepend("<div class=\"common-3g-top common-3g-block\"><div class=\"promotionholder model-"+toparr[toprkey][\'model\']+" holder\" rel=\""+rkey+"-2"+"\">"+toparr[toprkey][\'content\']+"</div><a href=\"#\" class=\"close_icon\"></a></div>");
								$(document).delegate(".common-3g-top > .close_icon","click",function(){
									$(".common-3g-top").hide();
									return false;
								});
							}
							//mid
							if (midarr.length >0){
								var midrkey = Math.floor(Math.random() * midarr.length);
								if (typeof($(".mid3gmark")) != "undefined") $(".mid3gmark").after("<div class=\"common-3g-mid common-3g-block\"><div class=\"promotionholder model-"+midarr[midrkey][\'model\']+" holder\" rel=\""+rkey+"-3"+"\">"+midarr[midrkey][\'content\']+"</div></div>");
							}
							
							//bottom
							if (botarr.length >0){
								var botrkey = Math.floor(Math.random() * botarr.length);
								$(document.body).append("<div class=\"g3woding\"></div><div class=\"common-3g-bottom common-3g-block\"><div class=\"promotionholder model-"+botarr[botrkey][\'model\']+" holder\" rel=\""+rkey+"-1"+"\">"+botarr[botrkey][\'content\']+"</div><a href=\"#\" class=\"close_icon\"></a></div>");
								$(document).delegate(".forheight","load",function(){
									$(".g3woding").height($(".common-3g-bottom").height());
								});
								if (rurl.indexOf(\'http://manhua.ali213.net/touch/show\') != -1){
									$(".common-3g-bottom").css("bottom","40px");
								}
								$(document).delegate(".common-3g-bottom > .close_icon","click",function(){
									$(".common-3g-bottom").hide();
									$(".g3woding").remove();
									return false;
								});
							}
						}
						$(document).delegate(".g3promotiontrigger","click",function(){
							var parentParam = $(this).closest(".promotionholder").attr("rel");
							var triggerParam = $(this).attr("rel");
							var rurl = $(this).attr("data-3gurl");
							$.ajax({url:"http://3g.ali213.net/common/api/promotionstat.php?params="+parentParam+"-"+triggerParam,async:false,dataType:"script",success:function(){
								if (rtmark == true) location.href=rurl;
							}});
							return false;
						});
				}
		});';
		file_put_contents('../schtml/shouyou/img/advertisement/adjson.js', $scriptstr);
		$sync = new sync('common/js/3gcommon.js', Yii::t('shouyou', 'advertisement_3g'),'../schtml/shouyou/img/advertisement/adjson.js');
		$sync->upload();
	}
	
	static function getContent($fid,$id,$url,$title,$brief)
	{
		$time = time();
		$md5str = md5(Yii::t('shouyou', 'md5prefix').$id);
		if ($fid == 1)
		{
			return '<a class="g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"><img class="forheight" src="http://3g.ali213.net/common/promotion/'.$md5str[0].'/'.$id.'.jpg?'.$time.'" /></a>';
		}
		elseif ($fid == 2)
		{
			return '<a class="download-btn g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"></a><a class="sfholder g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"><span class="sfimg"><img class="forheight" src="http://3g.ali213.net/common/promotion/'.$md5str[0].'/'.$id.'.jpg?'.$time.'" ></span><span class="sfname">'.$title.'</span><em class="sfinfo">'.$brief.'</em></a>';
		}
		elseif ($fid == 3)
		{
			return '<a class="download-btn g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"></a><a class="sfholder g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"><span class="sfimg"><img class="forheight" src="http://3g.ali213.net/common/promotion/'.$md5str[0].'/'.$id.'.jpg?'.$time.'" ></span><span class="sfname">'.$title.'</span><em class="sfinfo">'.$brief.'</em></a>';
		}
		elseif ($fid == 4)
		{
			return '<a class="sfholder g3promotiontrigger" rel="'.$id.'" href="javascript:void(0);" data-3gurl="'.$url.'"><span class="sfimg"><img class="forheight" src="http://3g.ali213.net/common/promotion/'.$md5str[0].'/'.$id.'.jpg?'.$time.'" ></span><span class="sfname">'.$title.'</span><em class="sfinfo">'.$brief.'</em></a>';
		}
	}
	
	static function multiExchange($arr,$str)
	{
		$narr = explode(',', $str);
		if (!$narr) return '';
		foreach ($narr as $value)
		{
			if (isset($arr[$value]))
			{
				$nstr .= ($nstr ? ',' : '') . $arr[$value];
			}
		}
		return $nstr;
	}
}