<?php
 
class dataselect extends CActiveRecord
{

  	
    public static  function selectBs($db){
    	
    	self::$db=Yii::app()->$db;
    	if(self::$db instanceof CDbConnection) return self::$db;
    		
    }	
 	
 
	
 
	 

	 
 
}