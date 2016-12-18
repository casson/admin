<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;


class AjaxController extends Controller
{
	
	
	//取出下级菜单信息(供联动菜单组件调用)
	public function actionGetNextLevel()
	{
		$parent_id = intval($_GET['parent_id']);
		$key_id = intval($_GET['key_id']);
		$is_open = intval($_GET['is_open']);
		if($parent_id!==''&&$key_id!==''&&$parent_id!==0)
		{
			
			if($parent_id!=0)
			{
				$parent_obj = Linkmenu::model()->find('key_id=:key_id and parent_id=:parent_id',array(':key_id'=>$key_id,':parent_id'=>$parent_id));
				if($parent_obj->key_id==0)$parent_id=0;
			}
			if($is_open)
			{
				$list = Linkmenu::model()->findAll(array('condition'=>'key_id=:key_id and parent_id=:parent_id and is_open=:is_open','params'=>array(':key_id'=>$key_id,':parent_id'=>$parent_id,':is_open'=>$is_open),'order'=>'list_order asc','select'=>'menu_id,name'));
			}
			else
			{
				$list = Linkmenu::model()->findAll(array('condition'=>'key_id=:key_id and parent_id=:parent_id','params'=>array(':key_id'=>$key_id,':parent_id'=>$parent_id),'order'=>'list_order asc','select'=>'menu_id,name'));
			}
			$i=0;
			foreach($list as $o)
			{
				$menu_list[$i]['menu_id']=$o->menu_id;
				$menu_list[$i]['name']=$o->name;
				$i++;
			}
			if($menu_list!='') echo json_encode($menu_list);
		}
		
	
	}
	
	//控制搜索框显示状态
	public function actionSearchform()
	{
		if(intval($_GET['search_form_show'])==1)
		{
			Yii::app()->session['search_form_show']=1;
			
		} else {
			Yii::app()->session['search_form_show']=0;
		}
		echo 1;
		exit;
	}

	//公用测试控制器
	public function actionTest()
	{
		echo Yii::$app->urlManager->createAbsoluteUrl('index');
		echo "dddddd";
	}

	
}