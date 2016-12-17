<?php

class Tags extends logCAr{
		
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
		
	public function getDbConnection()
	{ 
	  self::$db = Yii::app()->yly;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
	
    public function tableName()
	{
		return '{{tags}}';
	}
	
	/* replace  */
	public function attributeLabels() //表单字段label,如不定义，默认使用字段名称做为label
	{
		return array(
			'title'        => '标题',
            'typeid'       => '类型',
            'generatepath' => '路径',			
		);
	}
	
	/* rules */
	public function rules() //返回属性的验证规则
	{
		return array(
			  array('title,typeid,generatepath' ,'safe', 'on'=>'search'),
		);
	}
	
	public function primaryKey()
	{
		
		return 'id';
		
	}

	
    public function search(){
		$criteria=new CDbCriteria; 
	 	$criteria->compare('title',$this->title,true,"or");  
	 	$criteria->compare('typeid',$this->typeid,false);  
 		$criteria->order='id desc';
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));	
	}	
		
		
		
		
		
		
		
	} 