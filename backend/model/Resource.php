<?php

namespace app\model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{resource}}".
 *
 * The followings are the available columns in table '{{resource}}':
 * @property integer $resource_id
 * @property string $name
 * @property integer $parent_id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $data
 * @property integer $at_bottom
 * @property integer $menu
 * @property string $btn_class
 * @property string $show_function
 * @property integer $list_order
 * @property integer $disabled
 */
class Resource extends ActiveRecord
{

	private static $_handler = null ;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Resource the static model class
	 */
	public static function model($className=__CLASS__)
	{
		if(is_null(self::$_handler))
		{
			self::$_handler = new self();
		}
		return self::$_handler;	
	}

	/**
	*@return String the connection of database
	*/
	public static function getDb()
    {
        // use the "db2" application component
        return \Yii::$app->admin;  
    }
	
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{%resource}}';
	}

	
	public function scopes()
	{
		return array(
			'list_order_asc'=>array(
				'order'=>'list_order ASC',
			),
			'parent_order_asc'=>array(
				'order'=>'parent_id ASC',
				
			),
		);
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, parent_id, list_order', 'required'),
			array('parent_id, at_bottom, menu, list_order, disabled', 'numerical', 'integerOnly'=>true),
			array('name, module, controller, action', 'length', 'max'=>50),
			array('data', 'length', 'max'=>255),
			array('btn_class', 'length', 'max'=>19),
			array('show_function', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('resource_id, name, parent_id, module, controller, action, data, at_bottom, menu, btn_class, show_function, list_order, disabled', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'resource_id' => Yii::t('attr','resource_id'),
			'name' => Yii::t('attr','name'),
			'parent_id' => Yii::t('attr','parent_id'),
			'module' => Yii::t('attr','module'),
			'controller' => Yii::t('attr','controller'),
			'action' => Yii::t('attr','action'),
			'data' => Yii::t('attr','data'),
			'at_bottom' => Yii::t('attr','at_bottom'),
			'menu' =>Yii::t('attr','menu'),
			'btn_class' => Yii::t('attr','btn_class'),
			'show_function' =>Yii::t('attr','show_function'),
			'list_order' => Yii::t('attr','list_order'),
			'disabled' =>Yii::t('attr','disabled'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('resource_id',$this->resource_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('at_bottom',$this->at_bottom);
		$criteria->compare('menu',$this->menu);
		$criteria->compare('btn_class',$this->btn_class,true);
		$criteria->compare('show_function',$this->show_function,true);
		$criteria->compare('list_order',$this->list_order);
		$criteria->compare('disabled',$this->disabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}