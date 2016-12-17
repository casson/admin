<?php
 
class mobile_game extends logCAr
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
		return '{{game}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'),  
			'id' => Yii::t('shouyou','id'),  
			'oid' => Yii::t('shouyou','oid'),  
			'nid' => Yii::t('shouyou','nid'),  
			'pid' => Yii::t('shouyou','pid'),  
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('id,oid,typeid,nid,pid,title', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('typeid',$this->typeid);  
	 	$criteria->compare('id',$this->id);  
		
	 	$criteria->compare('oid',$this->oid,true,'or');
		//$criteria->compare('gid',$this->oid);
		//$criteria->addCondition('oid=:oid or gid=:oid' ,'or');
		$criteria->compare('nid',$this->nid,true);  
	 	$criteria->compare('pid',$this->pid,true);  
 		$criteria->order='uptime desc';
		//$criteria->params[':oid']=$this->oid;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}	
	
	public function typelist(){
		
		$array = array(1 =>'androidgametype',2=>'iosgametype',3=>'shouyousofttype');
		$type = $this->nid ? $this ->nid : 1 ;
		$typearr = Yii::app()->params[$array[$type]];
		$str ='';
		foreach($typearr as $key =>$value ){
			$arrx[$key] = $value[0] ; 
		}
		if($type==3){
			$arrx[34] = "主题锁屏";
			$arrx[35] = "游戏辅助";
			$arrx[36] = "图书阅读";
			$arrx[37] = "团购支付";
			$arrx[38] = "资讯阅读";
			$arrx[38] = "地图导航";
		}
		return $arrx ;	
	}
	
	static public function getplatform($str)
	{
		$arr = explode(",", $str);
		foreach ($arr as $value) $newarr[] = Yii::app()->params['platformtype'][$value];
		return implode(",", $newarr);
	}
	static public function getcover($id,$index)
	{
		$md5str = md5(Yii::t('shouyou', 'md5prefix').$id);
        if(isset($index)){
		    return 'http://img1.ali213.net/shouyou/cutpics/'.$md5str[0].'/'.$id.'_'.$index.'.jpg';
		}else{
		    $data=file_get_contents('http://img1.ali213.net/shouyou/cover/'.$md5str[0].'/'.$id.'.jpg');
			if(strlen($data)>1024) return 'http://img1.ali213.net/shouyou/cover/'.$md5str[0].'/'.$id.'.jpg';
			else return 'http://m.ali213.net/images/yxsm.jpg';
		}

	}
	static public function getpromotion($id,$str='')
	{
		$md5str = md5(Yii::t('shouyou', 'md5prefix').$id);
		return 'http://img1.ali213.net/shouyou/promotion/'.$md5str[0].'/'.$id.($str ? '_'.$str : '').'.jpg';
	}
	static public function getnetworktype($str)
	{
		$arr = explode(",", $str);
		foreach ($arr as $value) $newarr[] = Yii::app()->params['networktype'][$value];
		return implode(",", $newarr);
	}
	static public function getgamename($id)
	{
		$temparr = explode(" ", self::checkgame($id)->title);
		return $temparr[0];
	}
	static public function gettitle($title){
        $titlearr=explode(" ",$title);
		return $titlearr[0];
    }
	static public function getnortitle($title){
		if(!preg_match("/[\s]+/iUs",trim($title),$matcharr)) return trim($title);
		if(preg_match("/(.*:\s+[\w]+)/is",$title,$matcharr)) return $matcharr[1];
        if(preg_match("/(.*)\s+[\w]/iUs",$title,$matcharr)){
		    return $matcharr[1];
		}else{
		    $titlearr=explode(" ",$title);
		    return $titlearr[0];
		}
    }
	static public function getgametype($id)
	{
		$idarr=explode(",",$id);
		$arr = json_decode(file_get_contents("public/js/shouyou/gametype.js"),true);
		foreach ($arr as $value0)
		{
			foreach ($value0 as $value1)
			{
				foreach($idarr as $v){
				    if (in_array($v, array_keys($value1))) $str.=isset($str) ? ",".$value1[$v] : $value1[$v];
				}
			}
		}
		return $str;
	}
	static public function getcompany($id)
	{
		if (!$id) return '互联网';
		$arr = json_decode(file_get_contents('data/shouyou/company'),true);
		return $arr[$id];
	}
	static public function getrubao($rubao){
	    $array=array("0"=>"未入报","1"=>"已入报");
		return $array[$rubao];
	}
	static public function getnewsurl($array,$type){
			switch($type){
			    case "1":
                      $url="/news/".substr(date("Ymd",$array['addtime']),-6)."/".$array['id'].".html";
				break;
                case "2":
                      $url="/gonglue/".substr(date("Ymd",$array['addtime']),-6)."/".$array['id'].".html";
				break;
				case "3":
                      $url="/pingce/".substr(date("Ymd",$array['addtime']),-6)."/".$array['id'].".html";
				break;

			}
			return $url;
	}
	static public function getnewstype($typeid,$typename){
		 switch($typename){
		      case "gl":
				    $typearr=array("iOS单机攻略","iOS网游攻略","iOS软件攻略","Android单机攻略","Android网游攻略","其他攻略","iOS最新攻略","iOS热门攻略","Android最新攻略","Android热门攻略","iOS游戏攻略","Android游戏攻略");
			        if(strchr($typeid,"1") && strchr($typeid,"4")) $type='iOS&安卓单机攻略';
		            else if(strchr($typeid,"2") && strchr($typeid,"5")) $type='iOS&安卓网游攻略';
					else $type=$typearr[$typeid-1];
					break;
			  case "pc":
				    $typearr=array("iOS单机评测","iOS网游评测","iOS软件评测","Android游戏评测","Android软件评测","WP7游戏评测","WP7软件评测","iOS最新评测","iOS热门评测","Android最新评测","Android热门评测","iOS游戏评测");
			        $type=$typearr[$typeid-1];
					break;
			 default:
                    $newstype=new mobile_articletype();
			        $typearr=$newstype->findByPk($typeid);
			        $type=$typearr['title'];
					break;
			 
		 }
		 return $type;
		    
	}
	static public function getversion($arr){
		if($arr['version']) return $arr['version'];
	    else{
		     if($arr['pid']=="5"){
				 return strpos($arr['title'],".") ? substr($arr['title'],(strpos($arr['title'],'.')-2),strrpos($arr['title'],'.')-(strpos($arr['title'],'.')-2)+2) : "1.0";
			 }
			 elseif($arr['pid']=="3"){
				 return strchr($arr['title'],"v") ? substr($arr['title'],strrpos($arr['title'],'v')-1) : "1.0";
			 }else return "1.0";
		}
	}
	static public function geturl($array,$type="0")
	{
		$url="";
		switch($type){
		      case "0":
                  $url="/".$array['path']."/";
			      break;
			  case "1":
				  $url="/ios/".$array['id'].".html";
			      break;
			  case "3":
				  $url="/android/".$array['id'].".html";
			      break;
			  case "5":
				  $url="/wp/".$array['id'].".html";
			      break;
		}
		return $url;
	}
	
	static public function checkgame($id)
	{
		$row = self::model()->findByPk($id);
		return $row;
	}
	static public function checkoid($id)
	{
		$row = self::model()->findBySql('select id from game where oid='.$id);
		return $row;
	}
	
	static public function xiaoxu($id,$xiaoxu=0) //更新小许要下载的状态
	{
		self::model()->updateByPk($id, array('xiaoxu'=>$xiaoxu));
	}
}