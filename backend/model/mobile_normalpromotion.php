<?php
 
class mobile_normalpromotion extends logCAr
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
		return '{{normal_promotion}}';
	}
	
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
				array('typeid,title', 'safe', 'on'=>'search'),
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
		$criteria->order='sortnum desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static public function cachenormal()
	{
		$normal = self::model()->findAllBySql('select * from normal_promotion where is_promoted=1 order by sortnum desc'); //生成前台json
		$normaltype = json_decode(file_get_contents("public/js/shouyou/normaltypedata.js"),true);
		$normalcache = array();
		foreach ($normal as $value)
		{
			if (count($normalcache[$value->typeid])<$normaltype[$value->typeid]['vnum'])
			{
				$normalcache[$value->typeid][] = array(
						'id' => $value->id,
						'title' => $value->title,
						'link' => $value->link,
						'is_lighted' => $value->is_lighted,
						'is_hot' => $value->is_hot,
				);
			}
		}
		$normalsingletype = self::model()->findAll();
		$singletype = array();
		foreach ($normalsingletype as $value)
		{
			if (!in_array($value->typeid,$singletype)) $singletype[] = $value->typeid;
		}
		file_put_contents("data/shouyou/normalpromotion", json_encode($normalcache));
		file_put_contents("../schtml/shouyou/json/normalpromotion", json_encode($normalcache));
		$sync = new sync('json/normalpromotion', Yii::app()->params['shouyouftp']['img'],'../schtml/shouyou/json/normalpromotion');
		$sync->upload(true);
		file_put_contents("data/shouyou/normaltypeids", json_encode($singletype));
	}

	static public function gethotArr()
	{
		$arr=array("0"=>"无","1"=>"热门","2"=>"最新","3"=>"即玩");
		return $arr;
	}
	
	static public function gettype()
	{
		$arr1 = json_decode(file_get_contents('public/js/shouyou/normaltypedata.js'),true);
		foreach ($arr1 as $key => $value) $arr2[$key] = $value['title'];
		return $arr2;
	}
}