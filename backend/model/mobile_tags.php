<?php
 
class mobile_tags extends logCAr
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
		return '{{new_tags}}';
	}
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'name' => Yii::t('shouyou','title'),  
			'pid' => "平台",  
			'cid' => "类型", 
			'title' => "标题", 
		);
	}
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('name,pid,cid,title,nid', 'safe', 'on'=>'search'),
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
	 	$criteria->compare('title',$this->title,true,"or"); 
	 	$criteria->compare('pid',$this->pid); 
	 	$criteria->compare('cid',$this->cid);
		$criteria->compare('nid',$this->nid);
	 	$criteria->order='addtime desc'; 
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	} 
	
}