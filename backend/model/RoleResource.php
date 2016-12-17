<?php

namespace app\model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{role_resource}}".
 *
 * The followings are the available columns in table '{{role_resource}}':
 * @property string $role_resource_id
 * @property integer $role_id
 * @property integer $resource_id
 */
class RoleResource extends ActiveRecord
{
	private static $_handler = null ;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoleResource the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return self::find();
	}
		
	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{%role_resource}}';
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
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role_id, resource_id', 'required'),
			array('role_id, resource_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('role_resource_id, role_id, resource_id', 'safe', 'on'=>'search'),
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
			'role'=>array(self::BELONGS_TO,'Role','role_id'),
			//'resource'=>array(self::MANY_MANY,'Resource',$this->tableName().'(role_id, resource_id)')
			'resource'=>array(self::BELONGS_TO,'Resource','resource_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'role_resource_id' =>Yii::t('attr','role_resource_id'),
			'role_id' => Yii::t('attr','role_id'),
			'resource_id' => Yii::t('attr','resource_id'),
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

		$criteria->compare('role_resource_id',$this->role_resource_id,true);
		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('resource_id',$this->resource_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}