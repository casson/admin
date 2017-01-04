<?php

namespace app\module\admin\model;

use yii\base\Model;

class AdminEditForm extends Model
{
	
	public $role_id;
	public $user_name;
	public $user_pwd;
	public $confirm_pwd;
	public $email;
	public $real_name;
	public $disabled;
	
	//表单验证规则
	public function rules()
	{
		return array(
			//array('user_pwd', 'length','min'=>1),
			//array('user_pwd', 'match','pattern'=>'/^[.+]{6,20}$/'),
			//array('confirm_pwd', 'compare', 'compareAttribute'=>'user_pwd'),
			//array('real_name', 'length','min'=>2),
			//array('real_name', 'length','max'=>20),
			//array('role_id', 'match','pattern'=>'/^[\d]+$/'),
			//array('user_name', 'match','pattern'=>'/^[\w\_]{5,16}$/'),
			//array('disabled', 'numerical', 'integerOnly'=>true),
		);
	}

	//字段标签
	public function attributeLabels()
	{
		return array(
			'disabled' => Yii::t('attr','disabled'),
			'user_name' => Yii::t('attr','user_name'),
			'user_pwd' => Yii::t('attr','user_pwd'),
			'confirm_pwd' => Yii::t('attr','confirm_pwd'),
			'real_name' => Yii::t('attr','real_name'),
			'role_id' => Yii::t('attr','role_id'),
		);
	}
	
	//返回角色
	public function getRoleOptions()
	{
	   $role_list = Role::model()->findAll(array('condition'=>'disabled=0'));
	   foreach($role_list as $o)
	   {
			
			$list[$o->role_id] = $o->role_name;
	   }
	   return $list;
	}
	//返回状态选项
	public function getDisabledOptions()
	{
	   $list=array('0'=>Yii::t('attr','set_usable'),'1'=>Yii::t('attr','set_disable'));
	   return $list;
	}
	//编辑管理员
	public function editAdmin($id)
	{
		$admin = Admin::model()->findByPk($id);
		$admin->real_name = $this->real_name;
		$admin->role_id = $this->role_id;
		$admin->disabled = $this->disabled;
		if($this->user_pwd!='')
		{
			$admin->user_pwd = password($this->user_pwd,$admin->encrypt);
		}
		$admin->save();
		
		return true;

	}
	
}