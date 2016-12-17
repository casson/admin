<?php
 
class mobile_quicktype extends logCAr
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
		return '{{quick_promotion_type}}';
	}
	
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
				'title' => Yii::t('shouyou','title'),
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
				array('title', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('title',$this->title,true);
		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static public function cachetype()
	{
		$quicktype = self::model()->findAll();
		foreach ($quicktype as $value) $typecache[$value->id] = array(
				'title' => $value->title,
				'vnum' => $value->vnum,
		);
		file_put_contents("data/shouyou/quicktype", json_encode($typecache));
	}
}