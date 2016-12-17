<?php
 
class mobiletg_stat extends CActiveRecord
{
	public $sys;
	public $vid;
	public $ccid;
	
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
	  self::$db=Yii::app()->db9;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
    public function tableName()
	{
		return '{{stat}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'sys' => Yii::t('shouyou','sys'),  
			'vid' => Yii::t('shouyou','vid'),  
			'ccid' => Yii::t('shouyou','ccid'),  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  //array('fltmd5', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('fltmd5',$this->fltmd5);  
 		$criteria->order='sdate desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}