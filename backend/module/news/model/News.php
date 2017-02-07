<?php

namespace app\module\news\model;

use yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;

class News extends ActiveRecord
{
    
    /**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{%news}}';
	}

	/**
	*@return String the connection of database
	*/
	public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->app;  
    }
    
    /**
     * 构造函数
     *
     */
    public function __construct()
    {
        
    }
    
    
    /**
     * 获取数据模型
     *
     */
    public function search()
    {
        $criteria= self::find();
        return new ActiveDataProvider( array(
			'query'=> $criteria,
			'pagination' => array(
		        'pageSize' => 15
		    )
		));
    }
}