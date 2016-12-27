<?php

namespace app\module\admin\model;

use yii;
use yii\base\Model;
use yii\web\Cookie;
use yii\web\HttpSession;
use app\model\Admin;
use app\model\Role;
use app\extension\Util;


class LoginForm extends Model
{
	
	public $user_name;
	public $user_pwd;
	public $check_code;
	
	//表单验证规则
	public function rules()
	{
		return array(
			array('user_name', 'match','pattern'=>'/^[\w\_]{5,16}$/','message'=>Yii::t('attr','user_name').Yii::t('attr','invalid')),
			//array('user_pwd', 'require','min'=>1),
			array('user_pwd', 'match','pattern'=>'/^[\w\_]{6,20}$/','message'=>Yii::t('attr','user_pwd').Yii::t('attr','invalid')),
			array('check_code', 'match','pattern'=>'/^[\w]{4,6}$/','message'=>Yii::t('attr','check_code').Yii::t('attr','invalid')),
			array('check_code', 'is_correct_check_code'),
		);
	}
	
    
	//字段标签  test
	public function attributeLabels()
	{
		return array(
			'user_name' => Yii::t('admin','user name'),
			'user_pwd' => Yii::t('admin','user pwd'),
			'check_code' => Yii::t('admin','check code'),
		);
	}
	
	//校验验证码
	public function is_correct_check_code()
	{
		
		if(time()-Yii::$app->session['code_time']>3000)
		{
			$this->addError('check_code',Yii::t('admin','check code time out'));
		}
		if(strtolower($this->check_code)!=Yii::app()->session['check_code'])
		{
			$this->addError('check_code',Yii::t('admin','incorrect check code'));
			
		}	
	}
	
	//登录
	public function login()
	{   
		//获取管理员信息
		$admin = new Admin();
		$admin = $admin->find('user_name=:user_name',array(':user_name'=>$this->user_name))->one();
		if(empty($admin))
		{
			$this->addError('login_error',Yii::t('admin','incorrect user name or password'));
			return false;
		}
		
		if($admin->disabled==1)
		{
			$this->addError('login_error',Yii::t('admin','disabled user'));
			return false;
		}     
		if(Util::password($this->user_pwd,$admin->encrypt)!=$admin->user_pwd)
		{	
			$this->addError('login_error','用户名和密码不对');
			return false;
		} else {
			
			$role = new Role();
			$role->findOne( $admin->role_id);
			if(empty($role)||$role->disabled)
			{
				$this->addError('login_error',Yii::t('admin','invalid role,please contact manager'));
				return false;

			}else{
				
				Yii::$app->session['admin_real_name']	= $admin->real_name;
				Yii::$app->session['admin_id']			= $admin->admin_id;
				Yii::$app->session['admin_name']		= $admin->user_name;
				Yii::$app->session['role_id']			= $admin->role_id;
				Yii::$app->session['role_name']			= $admin->role->role_name;
				Yii::$app->session['last_login_ip']		= $admin->last_login_ip;
				Yii::$app->session['last_login_time']	= $admin->last_login_time;

				//设置登陆时长；
				//HttpSession::setTimeout(3600);

				$cookies = Yii::$app->response->cookies;
				$cookies->add(new Cookie(['name'=>$admin->lang,'value'=>'admin_lang']));


				//设置管理界面语言
				//$cookie_admin_lang = new Cookie(array('admin_lang'=>$admin->lang));
				//Yii::$app->request->cookies['admin_lang']=$cookie_admin_lang;
				
				//更新用户最后登录时间和IP
				//$admin->last_login_ip = ip();
				
				$admin->last_login_time = date('Y-m-d H:i:s');
				
				if(!$admin->save())
				{
					$this->addError('login_error','受外星人干扰，暂时无法登陆！');
					return false ;
				}
				return true;
			}
			
		}
		
		
	}
}