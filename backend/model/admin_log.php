 


<?php
 
class admin_log extends CActiveRecord
{

	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/* reset db */
	public function getDbConnection()
	{ 
	  self::$db=Yii::app()->db;
	  if(self::$db instanceof CDbConnection) return self::$db;
 	 
	}
	
	
	
    public function tableName()
	{
		return '{{log}}';
	}
	
	/* reles */
	public function rules()
	{
		return array(
				array('name,module', 'safe', 'on'=>'search'),
		);
	}
	/* replace  */
	public function attributeLabels()
	{
		return array(
				'class' => Yii::t('attr','documents.type'),
				'key' => Yii::t('attr','documents.key'),
					
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria; 
 		 $criteria->compare('name',$this->name,true,"or"); 
 		 $criteria->compare('module',$this->module,true,"or"); 
 
  
   		    $criteria->order='id desc';
  		 
   		
 		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
 
 
	

}






