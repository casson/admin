<?php
 
class Zt extends logCAr
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
	  self::$db=Yii::app()->duotegame;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{gamesubject}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'SpeName' => Yii::t('global','title'), 
			'ClsName' => Yii::t('global','gameleixin'),			
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('SpeName,listed', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('SpeName',$this->SpeName,true,"or");  
	 	$criteria->compare('listed',$this->listed,false);  
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	
}