<?php

namespace app\module\news\model;

use yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use app\extension\Util;

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
     * 验证用户的权限
     * @param var 验证的资讯的id或者是验证的资讯的模型
     */
    public function _validate($var)
    {
        $role_id = Yii::$app->session['role_id'];
        if(Util::isAdministrator())
        {
            return true;
        } else {
            if($var instanceof ActiveRecord)
            {
                if($var->admin_id == Yii::$app->session['role_id'])
                {
                    return true;
                } else {
                    return false;
                }    
            } else {
                if(is_numeric($var))
                {
                    $news = self::findOne($var);
                    return $this->_validate($news);
                } else {
                    return false;
                }    
            }    
        }    
    }
    
    /**
     * 获取数据模型
     *
     */
    public function search()
    {
        $criteria= self::find();
        if(!Util::isAdministrator())
        {
            $criteria->filterWhere(array('admin_id'=>Yii::$app->session['admin_id']));
        }    
        return new ActiveDataProvider( array(
			'query'=> $criteria,
			'pagination' => array(
		        'pageSize' => 15
		    )
		));
    }
}