<?php

     class WorkCount extends logCAr{
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
			self::$db=Yii::app()->tongji;
			if(self::$db instanceof CDbConnection) return self::$db;
 	 
		}
		
		public function tableName()
		{
			return '{{writerwork}}';
		}
		
		/* replace  */
		public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
		{
			return array(
				'title' => Yii::t('global','title'),  
				'typeid' => Yii::t('global','typeid'),  
			);
		}
		
		/* rules */
		public function rules() //返回属性的验证规则
		{
			return array(
				array('date,wtid', 'safe', 'on'=>'search'),
			);
		}
	
		public function primaryKey()
		{
			return 'id';
		}	
	
	
		public function search()
		{
			$criteria=new CDbCriteria; 
			$criteria->compare('date',$this->date,true,"or");  
			$criteria->compare('wtid',$this->wtid,false);  
			$criteria->order='wtid desc';
			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
			));
		}
}