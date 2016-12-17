<?php
 
class mobile_glapp_main extends logCAr
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
		return '{{glapp_main}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'id' => Yii::t('shouyou','id'),  
			'gid' => '关联id',  
			'title' => Yii::t('shouyou','title'),  
			'editor' => '编辑',
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('id,gid,title,editor', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('gid',$this->gid,true);  
		$criteria->compare('editor',$this->editor,false); 
		$criteria->compare('id',$this->id,true); 
 		$criteria->order='addtime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}