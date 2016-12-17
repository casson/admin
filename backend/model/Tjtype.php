<?php
 
class Tjtype extends logCAr
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
	  self::$db=Yii::app()->yly;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{tjtype}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'title' => Yii::t('global','title'),  
			'cid' => "频道",
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('title,cid', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('cid',$this->cid,false); 
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
    
    public static function gettypearr($typeid)
	{
		$array=array();
		$model=self::model()->findAll();
		foreach($model as $value){

                $array[$value['id']]=$value['title'];

		}
		return $typeid ? $array[$typeid] : $array;
	}	
	
	
	
}