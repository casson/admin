<?php

namespace app\module\admin\controllers;

use app\component\EController;
use app\component\ActionMenuHelper;
use app\model\Admin;

class AdminController extends EController
{
	
	//public $layout = 'main';
	
	//过滤器
	public function filters()
	{
		return array(
			array(
				'application.filters.BackEndAuthRequestFilter',
			)
		);
	}
	
	//管理员管理
	public function actionAdminmanage()
	{
		$this->layout   = 'main';
		$this->son_menu = 0;	
		$act_list=ActionMenuHelper::getHiddenMenu(0);
		//$model=new Admin('search'); 
		$model=new Admin();  	 
		//send model object for search
		return  $this->render('list',array(
                    'dataProvider'=>$model->search(),
                    'act_list'=>$act_list
                )); 
	}
	
	//添加管理员
	public function actionAddAdmin()
	{
		$this->layout = 'main';
		$this->son_menu=1;
		$model = new AdminAddForm;
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['AdminAddForm'])){	
			$model->attributes=$_POST['AdminAddForm'];
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate()){	
				if($model->addAdmin()){
					$this->showMessage(Yii::t('info','operation success'),'admin/admin/adminmanage');
				}else{
					$this->showMessage(Yii::t('info','operation failed'),'admin/admin/adminmanage');
				}				
			}
		}
		$this->render('add',array('model'=>$model));
	}
	
	//编辑管理员
	public function actionEditAdmin()
	{
		$this->layout='pop';
		$admin_id = $this->_getAdminId();
		$admin = Admin::model()->findByPk($admin_id);
		$model = new AdminEditForm;
		$model->attributes = $admin->attributes;
		$model->user_pwd='';
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['AdminEditForm']))
		{	
			$model->attributes=$_POST['AdminEditForm'];
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate())
			{	
				if($model->editAdmin($admin_id))
				{
					Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
				}
				else
				{
					Yii::app()->user->setFlash('failed',Yii::t('info','operation failed'));
				}
				$this->refresh();	
			}
		}
		
		$this->render('edit',array('model'=>$model,'admin'=>$admin));
	}
	//删除管理员
	public function actionDeleteAdmin()
	{
		$admin_id = $this->_getAdminId();
		if(Admin::model()->deleteByPk($admin_id))
		{			
			$this->showMessage(Yii::t('info','operation success'));
		}
		else
		{
			$this->showMessage(Yii::t('info','operation failed'));
		}
	}
	
	//获取id
	private function _getAdminId(){
		if(!isset($_GET['admin_id']) || !is_numeric($_GET['admin_id'])){
			throw new CHttpException(400,'Invalid request. admin_id is required!');
		}
		return $_GET['admin_id'];
	}
	
}