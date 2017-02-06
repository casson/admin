<?php

namespace app\module\admin\controllers;

use yii;
use app\component\EController;
use app\component\ActionMenuHelper;
use app\model\Admin;
use app\module\admin\model\AdminEditForm;
use app\module\admin\model\AdminAddForm;

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
	public function actionAddadmin()
	{
		$this->layout = 'main';
		$this->son_menu=1;
		$model = new AdminAddForm;
		
        //ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
        
		if(Yii::$app->request->post('AdminAddForm'))
        {	
			$model->setAttributes(Yii::$app->request->post('AdminAddForm'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate())
            {	
				if($model->addAdmin())
                {
					return $this->showMessage(Yii::t('info','operation success'),'admin/admin/adminmanage');
				} else {
					return $this->showMessage(Yii::t('info','operation failed'),'admin/admin/adminmanage');
				}				
			}
		}
		return $this->render('add',array('model'=>$model));
	}
	
	//编辑管理员
	public function actionEditadmin()
	{
		$this->layout='pop';
		$admin_id = $this->_getAdminId();
		$admin = Admin::findOne($admin_id);
		$model = new AdminEditForm;
		$model->setAttributes($admin->getAttributes(), false);
		$model->user_pwd='';
        
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
        
		if(Yii::$app->request->post('AdminEditForm'))
		{	
			$model->setAttributes(Yii::$app->request->post('AdminEditForm'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate())
			{	
				if($model->editAdmin($admin_id))
				{
					Yii::$app->session->setFlash('success',Yii::t('info','operation success'));
				} else {
					Yii::$app->session->setFlash('failed',Yii::t('info','operation failed'));
				}
			}
		}
		return $this->render('edit',array('model'=>$model,'admin'=>$admin));
	}
    
	//删除管理员
	public function actionDeleteadmin()
	{
		$admin_id = $this->_getAdminId();
		if(Admin::findOne($admin_id)->delete())
		{			
			return $this->showMessage(Yii::t('info','operation success'));
		} else {
			return $this->showMessage(Yii::t('info','operation failed'));
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