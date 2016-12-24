<?php

namespace app\model;

use yii;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
 
class Menu extends ActiveRecord
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
		return '{{%resource}}';
	}
	
	/* reles */
	public function rules()
	{
		return array(
				array('name,module,parent_id', 'safe', 'on'=>'search'),
		);
	}
	/* replace  */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('attr','name'),
			'parent_id' => Yii::t('attr','parent_id'),
			'module' => Yii::t('attr','module'),
			'controller' => Yii::t('attr','controller'),
			'action' => Yii::t('attr','action'), 
			'at_bottom' => Yii::t('attr','at_bottom'), 
			'menu' => Yii::t('attr','menu'), 
			'disabled' => Yii::t('attr','disabled'), 
			'btn_class' => Yii::t('attr','btn_class'), 
			'title_field' => Yii::t('attr','title_field'), 
			'list_order' => Yii::t('attr','list_order'), 
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=self::find(); 
 		return new ActiveDataProvider(array(
				'query'=>$criteria,
		));
	}
	
	
	public function getTypeOptions()
	{
		$menuinfo = Menu::find()->where(array("parent_id"=>0))->all(); //,"order"=>"resource_id desc"));
		foreach($menuinfo as $_v){
    		$list[$_v->module]=Yii::t('resource',$_v->name);
    	}
		return $list;
	}
 
 
	

}






