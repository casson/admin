<?php
 
class mobile_0day extends logCAr
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
		return '{{0day}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'typeid' => Yii::t('shouyou','typeid'),  
			'id' => Yii::t('shouyou','id'),  
			'title' => Yii::t('shouyou','title'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('id,typeid,title', 'safe', 'on'=>'search'),
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
 		$criteria->order='uptime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	static public function getdaily($pid,$type){
		 $moudel=new mobile_0day();
	     switch($type){
		      case "android":
                 $dataarr=$moudel->findBySql("select * from 0day where androidid='".$pid."'");
			  break;
              case "ios":
                 $dataarr=$moudel->findBySql("select * from 0day where iosid='".$pid."'");
			  break;
			  case "wp":
                 $dataarr=$moudel->findBySql("select * from 0day where wp7id='".$pid."'");
			  break;
		 }  
		 return $dataarr;
	}
	static public function getgid($dailydata){
	       if($dailydata['iosurl']) $gid=intval(substr($dailydata['iosurl'],strrpos($dailydata['iosurl'],"/")+1));
		   elseif($dailydata['androidurl']) $gid=intval(substr($dailydata['androidurl'],strrpos($dailydata['androidurl'],"/")+1));
		   else $gid=intval(substr($dailydata['wp7url'],strrpos($dailydata['wp7url'],"/")+1));
		   return $gid;
	}
	static public function cacheweekpromotion()
	{
		$week0day = self::model()->findAllBySql('select id,title,typeid,oid,path from 0day where week_promoted=1 order by addtime desc limit 7'); //生成前台json
		foreach ($week0day as $value)
		{
			$week0daycache[] = array(
						'id' => $value->id,
						'title' => $value->title,
						'path' => $value->path,
						'typeid' => $value->typeid,
						'oid' => $value->oid,
			);
		}
		file_put_contents("../schtml/shouyou/json/week0daypromotion", json_encode($week0daycache));
		$sync = new sync('json/week0daypromotion', Yii::app()->params['shouyouftp']['html'],'../schtml/shouyou/json/week0daypromotion',FALSE);
		$sync->upload();
	}
	static public function cacheKeyword() //缓存关键词
	{
		$connection=Yii::app()->db6;
		$command=$connection->createCommand('select distinct(title) as keyword from 0day');
		$keyword = $command->queryAll();
		foreach ($keyword as $value)
		{
			if (trim($value["keyword"])) $arr[] = trim($value["keyword"]);
		}
		file_put_contents('data/shouyou/keyword', serialize($arr));
	}
	static public function checkKeyword($keyword) //用于攻略验证关键词
	{
		$arr = unserialize(file_get_contents('data/shouyou/keyword'));
		return in_array($keyword, $arr);
	}
}