<?php
 
class indextj extends logCAr
{
	
	
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
 
	
	/* reset db */
	public function getDbConnection()
	{ 
	  self::$db=Yii::app()->yly;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
	
	
	
    public function tableName()
	{
		return '{{tj}}';
	}
	
	/* reles */
	public function rules()
	{
	 
		return array(
				array('title,typeid,channel', 'safe', 'on'=>'search'),
		);
	 
	}
	
 

	/* replace  */
	public function attributeLabels()
	{
		return array(

				'title' => "标题",
				'typeid' => "类型",
				'channel' => "频道",
					
		);
	}

	public function search()
	{
	 
		$criteria=new CDbCriteria; 
		$criteria->order = " uptime desc";
		$criteria->compare('title',$this->title,true,"or"); 
		$criteria->compare('typeid',$this->typeid,false); 
		$criteria->compare('channel',$this->channel,false); 
		
		
 		
 		
 		
 		
 		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
 	
 	
 
	

}