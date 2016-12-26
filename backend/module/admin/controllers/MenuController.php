<?php

namespace app\module\admin\controllers;

use yii;
use app\component\Tree;
use app\component\EController;
use app\model\Resource;
use app\model\Menu;
use app\model\RoleResource;
use app\component\ActionMenuHelper;
use app\module\admin\model\MenuEditForm;
use app\module\admin\model\MenuAddForm;

class MenuController extends EController
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
	
	
	//模块管理
	public function actionModule()
	{
	
		$this->layout = 'main';
		$this->son_menu = 0 ;
		$act_list=ActionMenuHelper::getHiddenMenu();

		$model=new Menu();  
		if(isset($_GET['Menu'])) 
		{
			$model->attributes=$_GET['Menu'];
 		}
 		return  $this->render('list',array(
					'dataProvider'=>$model->search(),
					'act_list'=>$act_list,
					'tp_act_list'=>$tp_act_list,
					'model'=>$model
				)); 
	} 
		
	//添加
	public function actionAddmodule()
	{
		$this->layout = 'pop';
		$this->son_menu=1 ;
		$model = new MenuAddForm;
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if($_GET['parent_id']){
			$parent_id_get = $_GET['parent_id'];	
		}
		
		if(isset($_POST['MenuAddForm'])){
			$model->attributes=$_POST['MenuAddForm'];
			if($model->validate()){	
				if($model->addMenu()){
					//$this->showMessage(Yii::t('info','operation success'),'admin/menu/module');
					Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
				}else{
					//$this->showMessage(Yii::t('info','operation failed'),'admin/menu/module');
					Yii::app()->user->setFlash('failed',Yii::t('info','operation failed'));
				}	
				//$this->refresh();			
			}
		}
		return 	$this->render('add',array(
					'model'=>$model,
					'parent_id_get'=>$parent_id_get
				));
	
	}

	
	//修改
	public function actionEdit()
	{
		$this->layout='pop';
		$this->son_menu=1 ;
		$id = $this->_getAdminId();
		$admin = Menu::findOne($id);
		$model = new MenuEditForm;
		$model->attributes = $admin->attributes;
		
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		if(isset($_POST['MenuEditForm'])){
			$model->attributes=$_POST['MenuEditForm'];
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate()){	
				if($model->editMenu($id)){
					Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
				}else{
					Yii::app()->user->setFlash('failed',Yii::t('info','operation failed'));
				}
				//$this->refresh();
			}
		}
		return $this->render('edit',array('model'=>$model,'admin'=>$admin));
	}
	
	
	//获取id
	private function _getAdminId(){
		if(!isset($_GET['resource_id']) || !is_numeric($_GET['resource_id'])){
			throw new CHttpException(400,'Invalid request. resource_id is required!');
		}
		return $_GET['resource_id'];
	}
	
	//获取id
	private function _getId(){
		$_GET['id']=1;
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
			throw new CHttpException(400,'Invalid request. id is required!');
		}
		return $_GET['id'];
	}	
	
	/**
	 * 获取菜单深度
	 * @param $id
	 * @param $obj
	 * @param $i
	 */
	public function _get_level($id,$obj,$i=0) {
		foreach($obj as $o){
			if($o->resource_id== $id)
			{
				if($o->parent_id== 0) return $i;
				$i++;
				return $this->_get_level($o->parent_id,$obj,$i);
			}
		}
	}
	
	
	//菜单结构预览
	public function actionMenustr()
	{
		$this->son_menu = 0 ;
		$role_id = $this->_getId();	
		if ($role_id) 
		{
			$menu = new Tree;
			$menu->icon = array('│ ','├─ ','└─ ');
			$menu->nbsp = '&nbsp;&nbsp;&nbsp;';
			$resource_list = Resource::find()->all();
			$n=0;
			foreach ($resource_list as $o) {
				$result[$n]['id'] = $o->resource_id;
				$result[$n]['parent_id'] = $o->parent_id;
				$result[$n]['name'] = Yii::t('resource',$o->name);
				$result[$n]['level'] = $this->_get_level($o->resource_id,$resource_list);
				$result[$n]['parentid_node'] = ($o->parent_id)? ' class="child-of-node-'.$o->parent_id.'"' : '';
				$n++;
			}		
			$str  = "<tr id='node-\$id' \$parentid_node>
						<td style='padding-left:30px;'>\$spacer \$name 
							<a href='javascript:void(0);' onclick='javascript:edit(&quot;/admin/backend/web/admin/menu/addmodule?parent_id=\$id &quot;,&quot;pop_original&quot;,&quot;添加菜单&quot;)' title='添加'><b>+</b></a>
							<a href='javascript:void(0);' onclick='javascript:edit(&quot;/admin/backend/web/admin/menu/edit?resource_id=\$id &quot;,&quot;pop_original&quot;,&quot;修改『 \$name 』&quot;)' title='修改'><b>←</b></a>
						</td>
					</tr>";	
			$menu->init($result);
			$categorys = $menu->get_tree(0, $str);
		}
		return $this->render('menu_str',array('categorys'=>$categorys,'role_id'=>$role_id)); 
	}
	
	
	//删除菜单
	public function actionmenudel()
	{
		$resource_id = $this->_getAdminId();
		
		if(Menu::model()->deleteByPk($resource_id))
		{
			
			$this->showMessage(Yii::t('info','operation success'));
			
		}
		else
		{
			$this->showMessage(Yii::t('info','operation failed'));
		}
	
	}
	
	
}