<?php
namespace app\module\admin\controllers;

use app\component\EController;
use app\component\ActionMenuHelper;
use app\model\admin_log;

class LogController extends EController
{
	
	public $layout = 'main';
	
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
	public function actionIndex()
	{
	
		$this->layout='main';
		$this->son_menu=0;	
		$act_list=ActionMenuHelper::getHiddenMenu();
		$model=new admin_log();  
		 if(isset($_GET['admin_log']))
			$model->attributes=$_GET['admin_log'];
 		return  $this->render('list',array(
					'dataProvider'=>$model->search(),
					'act_list'=>$act_list,
					'model'=>$model
				)); 
	} 
	
	//删除
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