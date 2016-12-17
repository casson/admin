<?php
 
class mobile_tag extends logCAr
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
		return '{{tag}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'name' => Yii::t('shouyou','title'),  
			'pid' => "平台",  
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('name,pid', 'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		return 'id';
	}	
	
	public function search()
	{
		$criteria=new CDbCriteria; 
	 	$criteria->compare('name',$this->name,true,"or"); 
	 	$criteria->compare('pid',$this->pid,false);
		
	 	$criteria->order='addtime desc'; 
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	} 
	
}