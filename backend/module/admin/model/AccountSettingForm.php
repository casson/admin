<?php

namespace app\module\admin\model; 
use yii;
use yii\base\Model;

class AccountSettingForm extends Model
{
	public $user_name;
	public $last_login_time;
	public $last_login_ip;
	public $real_name; 
	public $lang;
	
	//表单验证规则
	public function rules()
	{
		return array(
			array('real_name', 'required'),
			//array('real_name', 'length','min'=>2),
			//array('real_name', 'length','max'=>20), 
			//array('lang', 'match','pattern'=>'/^[\[a-z\_]{2,5}$/'),
		);
	}
	//字段标签
	public function attributeLabels()
	{
		return array(
		    'user_name' => Yii::t('attr','user_name'),
			'last_login_time' => Yii::t('attr','last_login_time'),
			'last_login_ip' => Yii::t('attr','last_login_ip'),
			'real_name' => Yii::t('attr','real_name'), 
			'lang' => Yii::t('attr','lang'),
		);
	}
	//返回语言
	public function getLangOptions()
	{
	   $list=array('zh_cn'=>'中文','en_us'=>'English');
	   return $list;
	}

}