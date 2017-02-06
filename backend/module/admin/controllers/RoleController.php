<?php

namespace app\module\admin\controllers;

use yii;
use yii\widgets\ActiveForm;
use app\component\Tree;
use app\component\EController;
use app\component\ActionMenuHelper;
use app\model\Role;
use app\model\Resource;
use app\model\RoleResource;
use app\model\Admin;

class RoleController extends EController
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
	
	//角色管理
	public function actionRolemanage(){	

		$this->layout  = 'main';	
		$this->son_menu=0;
		$act_list=ActionMenuHelper::getHiddenMenu();
		$model=new Role();
		//$model->unsetAttributes(); 
		if(isset($_GET['Role'])){
			$model->attributes=$_GET['Role'];
		}	
		return  $this->render('list',array(
					'dataProvider'=>$model->search(),
					'model'=>$model,
					'act_list'=>$act_list
				)); 
	}
	
	
	//添加角色
	public function actionAddrole(){
		$this->layout='main';
		$this->son_menu=1;//取列表操作时，取resource 中menu 为0的记录
		$model=new Role();
		
		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo ActiveForm::validate($model);
			Yii::$app->end();
		}
		
		if(isset($_POST['Role'])){	
			$model->setAttributes(Yii::$app->request->post('Role'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate()){	
				if($model->save()){
					return $this->showMessage(Yii::t('info','operation success'),'admin/role/rolemanage');
				}else{	
					return $this->showMessage(Yii::t('info','operation failed'),'admin/role/rolemanage');
				}
			}			
		}
		return $this->render('add',array('model'=>$model)); 
	}
	
	//编辑角色
	public function actionEditrole()
	{
		$this->layout = 'pop';
		$id = $this->_getId();
		$model = new Role();
		$model = $model->findOne($id);

		//ajax 验证
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'ajax_form') {
			echo ActiveForm::validate($model);
			Yii::$app->end();
		}
		if(Yii::$app->request->post('Role')){
			$model->setAttributes(Yii::$app->request->post('Role'), false);
			// 验证用户输入，并在判断输入正确后重定向到
			if($model->validate()){	
				if($model->save())
				{
					Yii::$app->session->setFlash('success',Yii::t('info','operation success'));
					//$this->refresh();
				}else{
					Yii::$app->session->setFlash('failed',Yii::t('info','operation failed'));
					//$this->refresh();
				}
			}
			
		}	
		return $this->render('edit',array('model'=>$model)); 
	
	}
	
	//权限设置
	public function actionPrivsetting()
	{
		$this->layout='pop';
		$role_id = $this->_getId();
		//数据更新
		if(isset($_POST)&&!empty($_POST))
		{	
			$connection=Yii::$app->admin; 
			$transaction=$connection->beginTransaction();
			try
			{
				//抛出异常
				//throw new CHttpException(400,'Invalid request. id is required!');
				RoleResource::model()->deleteAll(array('condition'=>'role_id=:role_id','params'=>array(':role_id'=>$role_id)));
				if(!empty($_POST['menuid']))
				{
					foreach($_POST['menuid'] as $key=>$value)
					{
						$model = new RoleResource;
						$model->role_id = $role_id;
						$model->resource_id = $value;
						$model->save();
					}	
				}			
				$transaction->commit();
				Yii::app()->user->setFlash('success',Yii::t('info','operation success'));
				$this->refresh();
			} catch(Exception $e) {
				$transaction->rollback();
				Yii::app()->user->setFlash('failed',Yii::t('info',$e->getMessage()));
				$this->refresh();
				
			}	
		}
		if ($role_id) {
			$menu = new Tree;
			$menu->icon = array('│ ','├─ ','└─ ');
			$menu->nbsp = '&nbsp;&nbsp;&nbsp;';
			$resource_list = Resource::find()->all();
			$priv_data = RoleResource::find()->with(['resource'=>function($query){
				$query->orderBy('list_order ASC');
			}])->where(array('role_id'=>$role_id))->all(); //获取权限表数据
			$n=0;
			foreach ($resource_list as $o) {
				$result[$n]['id'] = $o->resource_id;
				$result[$n]['parent_id'] = $o->parent_id;
				$result[$n]['name'] = Yii::t('resource',$o->name);
				$result[$n]['checked'] = ($this->_is_checked($o->resource_id,$role_id,$priv_data))? ' checked' : '';
				$result[$n]['level'] = $this->_get_level($o->resource_id,$resource_list);
				$result[$n]['parentid_node'] = ($o->parent_id)? ' class="child-of-node-'.$o->parent_id.'"' : '';
				$n++;
			}
			
			$str  = "<tr id='node-\$id' \$parentid_node>
						<td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
					</tr>";
		
			$menu->init($result);
			$categorys = $menu->get_tree(0, $str);
		}
		return $this->render('privsetting',array('categorys'=>$categorys,'role_id'=>$role_id)); 
	}
	
	/**
	 *  检查指定菜单是否有权限
	 */
	
	public function _is_checked($resource_id,$role_id,$priv_data) {
		
		foreach($priv_data as $o)
		{
			if($o->resource_id==$resource_id)
			{
				return true;
			}
		}
		return false;
		
	}
	
	//成员管理
	public function actionMembermanage()
	{
		$this->layout='main';
		$this->son_menu=1;//取列表操作时，取resource 中menu 为0的记录
		$role_id = $this->_getId();
		$act_list=ActionMenuHelper::getHiddenMenu();
		$model=new Admin();
		$model->role_id=$role_id;	
		//send model object for search
		return $this->render('membermanage',array(
			'dataProvider'=>$model->search(),
			'act_list'=>$act_list)
		); 
	}
	
	
	//删除角色
	public function actionDeleterole()
	{
		$id = $this->_getId();
		$connection=Yii::$app->admin; 
		$transaction=$connection->beginTransaction();
		try
		{
			if(Role::findOne($id)->delete())
			{
				if(RoleResource::deleteAll('role_id='.$id)>=0)
				{
<<<<<<< HEAD
					$transaction->commit();				
					$this->showMessage(Yii::t('info','operation success'),'admin/role/rolemanage');
				}				
=======
					$transaction->commit();
					return $this->showMessage(Yii::t('info','operation success'),'admin/role/rolemanage');
				}		
>>>>>>> 5cd4fd32054b7b6b45f072994e4167afd8decf3e
			}
		/** an exception is raised if a query fails	**/
		} catch(Exception $e) {
			$transaction->rollback();
			return $this->showMessage(Yii::t('info',$e->getMessage()),'admin/role/rolemanage');
		}
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
	//获取id
	private function _getId(){
		if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
			throw new CHttpException(400,'Invalid request. id is required!');
		}
		return $_GET['id'];
	}
	
	
}