<?php

namespace app\module\admin\model;

use yii;
use yii\base\Model;
use app\model\Role;

class AdminAddForm extends Model
{
	
	public $role_id;
	public $user_name;
	public $user_pwd;
	public $confirm_pwd;
	public $real_name;
	


	//表单验证规则
	public function rules()
	{
		return array(
		
			array('user_name,user_pwd,real_name,role_id,confirm_pwd', 'required'),
			array('user_name', 'is_unique_admin'),
			//array('user_pwd', 'match','pattern'=>'/^[.+]{6,20}$/'),
			array('confirm_pwd', 'compare', 'compareAttribute'=>'user_pwd'),
			array('real_name', 'length','min'=>2),
			array('real_name', 'length','max'=>20),
			array('role_id', 'match','pattern'=>'/^[\d]+$/'),
			array('user_name', 'match','pattern'=>'/^[\w\_]{5,16}$/'),
		);
	}
	//判断是否是唯一
	public function is_unique_admin()
	{
		$admin = Admin::find()->where(array('user_name'=>$this->user_name))->one();
		if(!empty($admin))
		{
			$this->addError('user_name', Yii::t('attr','user_name')."'".$this->user_name."'".Yii::t('admin','be used'));
		}	
	}
	//字段标签
	public function attributeLabels()
	{
		return array(
			'user_name' => Yii::t('attr','user_name'),
			'user_pwd' => Yii::t('attr','user_pwd'),
			'confirm_pwd' => Yii::t('attr','confirm_pwd'),
			'real_name' => Yii::t('attr','real_name'),
			'role_id' => Yii::t('attr','role_id'), 
		);
	}
	
	//返回语言
	public function getRoleOptions()
	{
	   $role_list = Role::find()->where(array('disabled'=>'0'))->all();
	   foreach($role_list as $o)
	   {
			
			$list[$o->role_id] = $o->role_name;
	   }
	   return $list;
	}
	
	//编辑管理员
	public function addAdmin()
	{
		$admin = new Admin;
		$admin->disabled =0;
		$admin->lang =Yii::app()->language;
		$admin->user_name = $this->user_name; 
		$admin->real_name = $this->real_name;
		$admin->role_id = $this->role_id;
		$password = password($this->user_pwd);
		$admin->encrypt = $password['encrypt'];
		$admin->user_pwd = $password['password'];
		$admin->save();
		return true;

	}
	
}