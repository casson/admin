<?php

namespace app\component;

use yii;
use yii\db\ActiveRecord;

class DataSelect extends ActiveRecord
{	
    /**database handler**/
    private static $db ;
    
    /**switch a database **/
    public static  function selectBs($db){
    	
    	self::$db=Yii::$app->$db;
    	if(self::$db instanceof CDbConnection) return self::$db;	
    }	 
}