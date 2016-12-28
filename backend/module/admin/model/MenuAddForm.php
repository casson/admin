<?php

namespace app\module\admin\model;

use yii;
use yii\base\Model;
use app\model\Menu;

class MenuAddForm extends Model
{
	
	public $name;
	public $parent_id;
	public $module;
	public $controller;
	public $action;
	public $at_bottom;
	public $menu;
	public $disabled;
	public $btn_class;
	public $title_field;
	public $list_order;
	
	
	//表单验证规则
	public function rules()
	{
		return array(
			array('name', 'required'),
			array('parent_id','required'),
			array('module','required'),
			array('at_bottom','required'),
			array('menu','required'),
			array('disabled','required'),
			//array('controller,action,btn_class,title_field,list_order','length',min=>0),
		);
	}

	//字段标签
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('attr','name'),
			'parent_id' => Yii::t('attr','parent_id'),
			'module' => Yii::t('attr','module'),
			'controller' => Yii::t('attr','controller'),
			'action' => Yii::t('attr','action'), 
			'at_bottom' => Yii::t('attr','at_bottom'), 
			'menu' => Yii::t('attr','menu'), 
			'disabled' => Yii::t('attr','disabled'), 
			'btn_class' => Yii::t('attr','btn_class'), 
			'title_field' => Yii::t('attr','title_field'), 
			'list_order' => Yii::t('attr','list_order'), 
		);
	}
	
	//添加
	public function addMenu()
	{
		$admin = new Menu() ;
		
		$admin->name = $this->name;
		$admin->parent_id = $this->parent_id;
		$admin->module = $this->module;
		$admin->controller = $this->controller;
		$admin->action = $this->action;
		$admin->at_bottom = $this->at_bottom;
		$admin->menu = $this->menu;
		$admin->disabled = $this->disabled;
		$admin->btn_class = $this->btn_class;
		$admin->title_field = $this->title_field;
		$admin->list_order = $this->list_order;

		if($admin->save()){
			return true;	
		}
		return false;

	}
	
	//返回是否在底部选项
	public function getBottomOptions()
	{
		$list=array('0'=>'否','1'=>'是');
		return $list;
	}
	
	//返回是否是菜单选项
	public function getMenuOptions()
	{
		$list=array('0'=>'否','1'=>'是');
		return $list;
	}
	
	//返回状态选项
	public function getDisabledOptions()
	{
		$list=array('0'=>'启用','1'=>'禁用');
		return $list;
	}
	
	//返回链接样式
	public function getBtnClassOptions()
	{
		$list=array(
			''=>'无',
			'pop_full'=>'弹出全屏框',
			'pop_original'=>'弹出自适应尺寸框',
			'pop_full_no_btn'=>'弹出全屏框-无按钮',
			'pop_original_no_btn'=>'弹出自适应尺寸框-无按钮',
			'action_delete'=>'单条记录删除',
			'btn_batch'=>'列表页底部按钮',
			'btn_delete'=>'列表页底部按钮-删除',
			'btn_ok'=>'列表页底部按钮-确定'
		);
		return $list;
	}	
	
}