<?php

namespace app\model;

use yii\db\ActiveRecord;
use app\model\Role;

/**
 * This is the model class for table "{{admin}}".
 *
 * The followings are the available columns in table '{{admin}}':
 * @property integer $admin_id
 * @property string $user_name
 * @property string $user_pwd
 * @property string $real_name
 * @property integer $role_id
 * @property string $encrypt 
 * @property string $last_login_ip
 * @property string $last_login_time
 * @property integer $disabled
 * @property string $lang
 */
class Admin extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Admin the static model class
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
		return '{{%admin}}';
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
			array(['user_name', 'user_pwd', 'encrypt',  'disabled', 'lang'], 'required'),
			//array('role_id, disabled', 'numerical', 'integerOnly'=>true),
			//array('username','yii\validators\NumberValidator','integerOnly'=>true,'message'=>'must be int'),
			//array('user_name, encrypt', 'yii\validators\StringValidator', 'max'=>20),
			//array('user_pwd, real_name', 'yii\validators\StringValidator', 'max'=>32), 
			//array('last_login_ip', 'yii\validators\StringValidator', 'max'=>30),
			//array('lang', 'yii\validators\StringValidator', 'max'=>6),
			//array('last_login_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('admin_id, user_name, user_pwd, real_name, role_id, encrypt, last_login_ip, last_login_time, disabled, lang', 'safe', 'on'=>'search'),
			
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function getRole()
    {
        return $this->hasOne(Role::className(), ['role_id' =>'role_id']);
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'admin_id' => Yii::t('attr','admin_id'),
			'user_name' => Yii::t('attr','user_name'),
			'user_pwd' => Yii::t('attr','user_pwd'),
			'real_name' => Yii::t('attr','real_name'),
			'role_id' => Yii::t('attr','role_id'),
			'encrypt' => Yii::t('attr','encrypt'), 
			'last_login_ip' => Yii::t('attr','last_login_ip'),
			'last_login_time' => Yii::t('attr','last_login_time'),
			'disabled' => Yii::t('attr','disabled'),
			'lang' => Yii::t('attr','lang'),
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
		$criteria->with = array('role');
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('real_name',$this->real_name,true);
		$criteria->compare('t.role_id',$this->role_id); 
		$criteria->compare('disabled',$this->disabled);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	//返回语言
	public function getLangOptions()
	{
	   $list=array('zh_cn'=>'中文','en_us'=>'English');
	   return $list;
	}
}