<?php
 
class mobile_article extends logCAr
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
		return '{{article}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'),  
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('typeid,title,id', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
		$criteria->compare('id',$this->id);
	 	$criteria->compare('title',$this->title,true,"or");  
	 	$criteria->compare('typeid',$this->typeid);  
 		$criteria->order='addtime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	public function getnewsurl($array,$type){
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
	static public function getarticlepic($data,$type)
	{ 
		$md5str = md5(Yii::t('shouyou', 'md5prefix').$data['id']);
		switch($type){
			case "info":
				if(file_get_contents('http://img1.ali213.net/shouyou/article/'.$md5str[0].'/'.$data['id'].'.jpg')){
			         $result='<img src="http://img1.ali213.net/shouyou/article/'.$md5str[0].'/'.$data['id'].'.jpg" width="140" height="140"/><span class="img140"></span>';
			    }else $result='<div class="list_allpic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
			break;
			case "pc":
		        if(file_get_contents('http://img1.ali213.net/shouyou/pingce/'.$md5str[0].'/'.$data['id'].'.jpg')){
			         $result='<img src="http://img1.ali213.net/shouyou/pingce/'.$md5str[0].'/'.$data['id'].'.jpg" width="140" height="140"/><span class="img140"></span>'; 
			    }else{
				      if($data['typeid']<=3) $result='<div class="list_iospic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
					  elseif($data['typeid']==4 || $data['typeid']==5) $result='<div class="list_androidpic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
					  else $result='<div class="list_wp7pic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
				} 
			break;
			default:
		        if(file_get_contents('http://img1.ali213.net/shouyou/gonglue/'.$md5str[0].'/'.$data['id'].'.jpg')){
			         $result='<img src="http://img1.ali213.net/shouyou/gonglue/'.$md5str[0].'/'.$data['id'].'.jpg" width="140" height="140"/><span class="img140"></span>'; 
			    }else{
				      if($data['typeid']<=3) $result='<div class="list_iospic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
					  elseif($data['typeid']==4 || $data['typeid']==5) $result='<div class="list_androidpic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
					  else $result='<div class="list_allpic"><span class="iosyear">'.date("Y",$data['addtime']).'</span><span class="iosmonth">'.date("n",$data['addtime']).'</span><span class="iostxt">月</span><span class="iosday">'.date("d",$data['addtime']).'</span></div>';
				} 
			break;
		}
		return $result;
	}
	static public function getpic($array,$pt){
        $md5str = md5(Yii::t('shouyou', 'md5prefix').$array['id']);
	    switch($pt){
		    case "info":
                if(file_get_contents('http://img1.ali213.net/shouyou/article/'.$md5str[0].'/'.$array['id'].'.jpg')) $url='http://img1.ali213.net/shouyou/article/'.$md5str[0].'/'.$array['id'].'.jpg';
			    elseif($array['gid']) $url=mobile_game::getcover($array['gid']);
				else $url='/images/yxsm.jpg';
			break;
			case "pc":
                if(file_get_contents('http://img1.ali213.net/shouyou/pingce/'.$md5str[0].'/'.$array['id'].'.jpg')) $url='http://img1.ali213.net/shouyou/pingce/'.$md5str[0].'/'.$array['id'].'.jpg';
			    elseif($array['gid']) $url=mobile_game::getcover($array['gid']);
				else $url='/images/yxsm.jpg';
			break;
			default:
                if(file_get_contents('http://img1.ali213.net/shouyou/gonglue/'.$md5str[0].'/'.$array['id'].'.jpg')) $url='http://img1.ali213.net/shouyou/gonglue/'.$md5str[0].'/'.$array['id'].'.jpg';
			    elseif($array['gid']) $url=mobile_game::getcover($array['gid']);
				else $url='/images/yxsm.jpg';
			break;

		}
		return $url;
	}
	
	static public function cachearticle()
	{
		//data/shouyou/articletypeids
		$article = self::model()->findAllBySql('select id,typeid from article');
		$articletype = array();
		foreach ($article as $value)
		{
			if (!in_array($value->typeid, $articletype)) $articletype[] = $value->typeid;
		}
		file_put_contents('data/shouyou/articletypeids', json_encode($articletype));
	}
}