<?php

namespace app\model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{role}}".
 *
 * The followings are the available columns in table '{{role}}':
 * @property integer $role_id
 * @property string $role_name
 * @property string $description
 * @property integer $disabled
 */
class Role extends ActiveRecord
{

	private $primaryKey = 'role_id';

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Role the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{%role}}';
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
			array('role_name, description', 'required'),
			array('disabled', 'numerical', 'integerOnly'=>true),
			array('role_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('role_id, role_name, description, disabled', 'safe', 'on'=>'search'),
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
			'role_id' => Yii::t('attr','primary_id'),
			'role_name' => Yii::t('attr','role_name'),
			'description' => Yii::t('attr','description'),
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

		$criteria->compare('role_id',$this->role_id);
		$criteria->compare('role_name',$this->role_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('disabled',$this->disabled);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//返回状态选项
	public function getDisabledOptions()
	{
	   $list=array('0'=>Yii::t('attr','set_usable'),'1'=>Yii::t('attr','set_disable'));
	   return $list;
	}
}