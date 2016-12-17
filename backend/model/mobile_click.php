<?php
 
class mobile_click extends CActiveRecord
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
		return '{{click}}';
	}
	/* replace  */
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
			  array('title,plat', 'safe', 'on'=>'search'),
		);
	}
	public static function platArray(){
		return array("iOS"=>"iOS","Android"=>"Android");
	}
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search($start,$end)
	{
		//$time=strtotime(date("Y-m-d",time()));
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true,"or");  
	 	$criteria->compare('plat',$this->plat); 
	 	if($start!="" && $end!="") $criteria->addCondition("time>='".$start."' and time<='".$end."'");
	 	else if($start!="" && $end=="") $criteria->addCondition("time>='".$start."'");
	 	else if($start=="" && $end!="") $criteria->addCondition("time<='".$end."'");
 		$criteria->order='time desc,download desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
}