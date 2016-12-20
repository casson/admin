<?php

namespace app\module\admin\model; 

use yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
	public $new_pwd;
	public $original_pwd;
	public $retype_pwd; 
	
	
	//表单验证规则
	public function rules()
	{
		return array(
			//array('new_pwd,retype_pwd,original_pwd', 'required'),
			//array('new_pwd,retype_pwd', 'match','pattern'=>'/^[\w\_]{6,20}$/'),
			//array('retype_pwd', 'compare', 'compareAttribute'=>'new_pwd'),
		);
	}
	//字段标签
	public function attributeLabels()
	{
		return array(
			'user_name' => Yii::t('attr','user_name'),
		    'original_pwd' => Yii::t('attr','original_pwd'),
			'new_pwd' => Yii::t('attr','new_pwd'),
			'retype_pwd' => Yii::t('attr','retype_pwd'), 
		);
	}
	

}