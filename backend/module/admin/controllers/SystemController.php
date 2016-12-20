<?php
namespace app\module\admin\controllers;

use yii;
use app\component\EController;
use app\model\Admin;
use app\module\admin\model\AccountSettingForm;

class SystemController extends EController
{
	
	//过滤器
	public function filters()
	{
		return array(
			array(
				'application.filters.BackEndAuthRequestFilter',
			)
		);
	}
	
	//系统起始
	public function actionStart()
	{				
		return $this->renderPartial('start');
	}
	
	
	//修改密码
	public function actionChangePassword()
	{	
		$this -> layout = 'main' ;
		$admin= Admin::find(array("admin_id"=>Yii::app()->session['admin_id']));
		$model = new ChangePasswordForm;	
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		
		if(isset($_POST['ChangePasswordForm']))
		{	
			// 收集用户输入的数据
			$admin->attributes=$_POST['ChangePasswordForm'];
			$original_pwd = password($_POST['ChangePasswordForm']['original_pwd'],$admin->encrypt);
			if($original_pwd!=$admin->user_pwd)//原密码出错
			{
				Yii::app()->user->setFlash('failed',Yii::t('admin','incorrect original pwd'));
				$this->refresh();	
			}else{
				$admin->user_pwd=password($_POST['ChangePasswordForm']['new_pwd'],$admin->encrypt);
				if($admin->save()){
					 Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
					 $this->refresh();
				}else{
					 Yii::app()->user->setFlash('failed',Yii::t('info','operation failed'));
					 $this->refresh();
				}
			}	
		}	
		$this->render('changepassword',array('model'=>$model,'admin'=>$admin));
	}
	
	
	//账号设置
	public function actionAccountsetting()
	{
		$this -> layout = 'main' ;
		$admin= Admin::find(array("admin_id"=>Yii::$app->session['admin_id']))->one();
		$model = new AccountSettingForm;
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
		if(isset($_POST['AccountSettingForm']))
		{		
			// 收集用户输入的数据
			$model->attributes=$_POST['AccountSettingForm'];
			if($model->validate())
			{	
				$admin->attributes=$_POST['AccountSettingForm'];			
				if($admin->save())
				{		
					 Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
                     $this->refresh();
				}else{	
					Yii::app()->user->setFlash('failed',Yii::t('info','operation failed'));
					$this->refresh();
				}
			}	
		}
		return $this->render('accountsetting',array('model'=>$model,'admin'=>$admin));
	}
	
	
	
}