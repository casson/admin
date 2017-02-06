<?php

namespace app\model;

use yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class admin_log extends ActiveRecord
{
	
	/**
	*@return String the connection of database
	*/
	public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->admin;  
    }
	
    public static function tableName()
	{
		return '{{%log}}';
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
		$criteria = self::find(); 
        $criteria->orderBy('id desc');
 		return  new ActiveDataProvider(array(
					'query'=>$criteria,
				));
	}
	
 
 
	

}






