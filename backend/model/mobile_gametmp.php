<?php
 
class mobile_gametmp extends logCAr
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
		return '{{game_tmp}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'),  
			'nid' => Yii::t('shouyou','nid'),  
			'pid' => Yii::t('shouyou','pid'),  
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('typeid,nid,pid,title', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('nid',$this->nid,true);  
	 	$criteria->compare('pid',$this->pid,true);  
 		$criteria->order='uptime desc';
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
		return !isset($index) ? 'http://img1.ali213.net/shouyou/cover/'.$md5str[0].'/'.$id.'.jpg' : 'http://img1.ali213.net/shouyou/cutpics/'.$md5str[0].'/'.$id.'_'.$index.'.jpg';
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
	static public function getnewsurl($array,$type){
			return $url="/news/".$type."/".substr(date("Ymd",$array['addtime']),-6)."/".$array['id'].".html";
	}
	static public function getnewstype($typeid){
		    $newstype=new mobile_articletype();
			$newstypearr=$newstype->findByPk($typeid);
			return $newstypearr['title'];
	}
	public function geturl($array,$type="0")
	{
		$url="";
		switch($type){
		      case "0":
                  $url="/0day/".$array['id']."/";
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
	
	static public function xiaoxu($id,$xiaoxu=0) //更新小许要下载的状态
	{
		self::model()->updateByPk($id, array('xiaoxu'=>$xiaoxu));
	}
	
	static public function freefrmmurl($id,$murl,$prefix) //从murl的网址到free字段填充的转换
	{
		$murl = str_replace(array('http://','?f=web'), array('',''), $murl);
		$arr = explode('/', $murl);
		$md5str = md5(Yii::t('shouyou', 'md5prefix').$id);
		$last = array_slice($arr,-1,1);
		return $prefix.'/'.$md5str[0].$md5str[1].'/'.($prefix=='android' ? $id.'_'.preg_replace('%_\d+\.%','.',$last[0]) : preg_replace('%\d+_%iU',$id.'_',urldecode($last[0])));
	}
}