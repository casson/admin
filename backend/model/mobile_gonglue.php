<?php
 
class mobile_gonglue extends logCAr
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
		return '{{gonglue}}';
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
			  array('typeid,title,editor,id', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('typeid',$this->typeid,true);  
		$criteria->compare('editor',$this->editor,false); 
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
	static public function gettype($str)
	{
		$arr = explode(",", $str);
		foreach ($arr as $value) $newarr[] = Yii::app()->params['gongluetype'][$value];
		return implode(",", $newarr);
	}
}