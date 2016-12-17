<?php
 
class mobile_glapp_menu extends logCAr
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
		return '{{glapp_menu}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'gid' => Yii::t('shouyou','gid'),  
			'pid' => Yii::t('shouyou','pid'),  
			'title' => Yii::t('shouyou','title'),  
			'editor' => Yii::t('shouyou','editor'),
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('gid,pid,title,editor', 'safe', 'on'=>'search'),
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
		$criteria->compare('pid',$this->pid,true); 
 		$criteria->order='uptime desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
}