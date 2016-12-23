<?php

namespace app\component;

use yii;
use \app\model\Resource;
use \app\extension\Util;
use \app\extension\Helper;

class ActionMenuHelper 
{
	private function __init(){
		
	}
	private function __clone(){
		
	}
	/**
	* 获取操作
	* param boolean $isShow
	* param boolean $at_bottom
	* return arr $menu_list
	*/
	private static function getActionMenu($isShow=true,$at_bottom)
	{
		$isMenu = ($isShow == true) ? '1':'0';
		$controller = Yii::$app->controller->id; 
		$action = Yii::$app->controller->action->id;
		$module = Yii::$app->controller->module->id;
		$resource = Resource::find()->where(array('module'=>$module, 'controller'=>$controller, 'action'=>$action))->one();
		if(Yii::$app->session['role_id']==1)
		{
			$menu_list = Resource::find()->where(array('parent_id'=>$resource->resource_id, 'menu'=>$isMenu, 'disabled'=>0, 'at_bottom'=>$at_bottom))->all();
		} else {
			$menu_list = RoleResource::model()->with('resource')->findAll(array('condition'=>'role_id=:role_id and resource.parent_id=:resource_id and resource.menu='.$isMenu.' and resource.disabled=0 and resource.at_bottom='.$at_bottom.'','params'=>array(':role_id'=>Yii::$app->session['role_id'],':resource_id'=>$resource->resource_id),'order'=>'resource.list_order ASC'));			
		}
		return $menu_list;
	}

	
	/**
     *获取列表页单条记录操作菜单
     *
     *@param int $at_bottom
     *           是否是底部操作按钮
     *@return Array
     */
    public static function getHiddenMenu($at_bottom=0)
	{
		dataselect::selectBs("db"); 		
		$result = array();
		$actionList = self::getActionMenu(false, $at_bottom);
		foreach($actionList as $o){
			$tmpAction = array();
			if(Yii::$app->session['role_id']!=1)
			{
				$action = $o->resource;
			} else {
				$action = $o;
			}
			
			$actionName = trim(strtolower($action->action));
			$tmpAction['url'] 	 =  Yii::$app->urlManager->createAbsoluteUrl($action->module.'/'.$action->controller.'/'.$action->action.'/');
			$tmpAction['actionName'] = Yii::t('resource',$action->name);
			$tmpAction['action'] = $action->action;
			$tmpAction['actionModel']  = $action;
			$tmpAction['btn_class'] = $action->btn_class;
			$tmpAction['show_function'] = $action->show_function;
			$tmpAction['name_function'] = $action->name_function;
			$tmpAction['data'] = $action->data;
			$tmpAction['title_field'] = $action->title_field;
			$result[] = $tmpAction;
		}
		return $result;
	}
    
    
	//重建url
	public static function reCreateUrl($actionModel,$url){
		return Yii::$app->urlManager->createAbsoluteUrl($actionModel->module.'/'.$actionModel->controller.'/'.$actionModel->action.'/'.$url);
	}
	
	
	//获取列表头菜单
	public static function getListTopMenu($son_menu=1)
	{
		\app\component\DataSelect::selectBs("db");
		$controller = Yii::$app->controller->id;
		$action = Yii::$app->controller->action->id;
		$module = Yii::$app->controller->module->id;
		$resource = Resource::find(array('module'=>$module,'controller'=>$controller,'action'=>$action, 'disabled'=>0))->one();
		if($son_menu==1)
		{
			//$menu_list = Resource::find()->list_order_asc()->parent_order_asc()->findAll('resource_id=:parent_id or parent_id=:parent_id and menu=1 and disabled=0 and (btn_class IS  NULL or (btn_class IS NOT NULL and btn_class!=\'search_trigger\'))',array(':parent_id'=>$resource->parent_id));	
			$menu_list = Resource::findBySql('select * from dt_resource where resource_id=:parent_id or parent_id=:parent_id and menu=1 and disabled=0 and (btn_class IS  NULL or (btn_class IS NOT NULL and btn_class!=\'search_trigger\'))' ,array(':parent_id'=>$resource->parent_id))->all();	
		} else {
			$menu_list = Resource::findBySql('select * from dt_resource where resource_id=:resource_id or parent_id=:resource_id and menu=1 and disabled=0',array(':resource_id'=>$resource->resource_id))->all();
		}        
		$now_url = Yii::$app->request->getUrl();
        
        /**button 列表**/
        $str = '';
        
		foreach($menu_list as $o)
		{
			if(Yii::$app->session['role_id']!=1)
			{
				$obj = RoleResource::model()->find("role_id=".Yii::$app->session['role_id']." and resource_id=".$o->resource_id."");
				if(empty($obj)) 
				{
					continue;
				}
			}
			
			
			$url = $o->module.'/'.$o->controller.'/'.$o->action;
			if($o->data!='')
			{
                $evalphp = $o->data;
                if(@eval("$evalphp;")==false)
                {
                    $url .= "/".str_replace("=","/",$evalphp);
                } else {
                    $evalresult = @eval("$evalphp;");
                    if(preg_match('/\=$/',$evalresult))
                    {
                        $url='';
                    } else if(preg_match('/\=\&/',$evalresult)) {
                        $url='';
                    } else {
                        $url .= "/".str_replace("=","/",$evalresult);
                    }
                }
			}
			//其他可能参数
			if(isset($_GET['module'])&&$_GET['module']!='')
			{
				$url .= "/module/".$_GET['module'];
			}
			if(isset($_GET['parent_id'])&&$_GET['parent_id']!='')
			{
				$url .= "/parent_id/".intval($_GET['parent_id']);
			}
			$url = Yii::$app->urlManager->createAbsoluteUrl($url);
			
			$class_str='';
			if(strtolower($module)==strtolower($o->module)&&strtolower($controller)==strtolower($o->controller)&&strtolower($action)==strtolower($o->action))
			{			
                if($url==$now_url||$o->data=='')
                {
                    $class_str="class='on'";
                    $url = 'javascript:void(0)';
                }
			}
			
			//转换操作名称
			$namephp = $o->name_function;
			if(!empty($namephp))
			{
				$action_name = eval("$namephp;");
			} else {
				$action_name = Yii::t('resource',$o->name);
			}	
			$str .= "<li ".$class_str."><a href='".$url."' class='".$o->btn_class."' >".$action_name."</a></li>";	
		}	
		return $str;
	}
	//处理列表底部操作
	public static function ProcessBtActList($bt_act_list)
	{
		foreach($bt_act_list as $a){
			echo "<a href='".$a['url']."'   class='".$a['btn_class']."'>".Yii::t('base',$a['actionName'])."</a>";
			
		};
	}
	//处理列表底部操作
	public static function getProcessBtActList($bt_act_list,$strx="")
	{
		if(empty($bt_act_list))return '';
		$str='<div  class=\'bt_act\'>';
		foreach($bt_act_list as $a){
			$str.= "<a href='".$a['url']."'   class='".$a['btn_class']."'>".Yii::t('base',$a['actionName'])."</a>";
			
		};
		if($strx) $str .= $strx ;
		return $str."</div>";
	}
	/**处理列表对应操作
	*@ $o 对应记录
	*@ $act_list 操作列表
	*@ $key_field 记录主键
	*@ $art_name  传递主键值的键名，默认为id
	*@ $title_field 记录标题字段名称
	*/
	public static function  ProcessActList($o,$act_list,$key_field,$arg_name='id')
	{
		$i=0;
		foreach($act_list as $a){
			$url_data='';
			$data = $a['data'];
			if($data!='')
			{	
				if(@eval("$data;")==false)
                {
                    $url_data = "/".str_replace("=","/",$data);
                } else {				 	 
                    $evalresult = @eval("$data;");
                    if(preg_match('/\=$/',$evalresult))
                    {
                        $url_data='';
                    } else if(preg_match('/\=\&/',$evalresult)) {
                        $url_data='';
                    } else {
                        $url_data = "/".str_replace("=","/",$evalresult);
                    }
                }
			}
			$url = ActionMenuHelper::reCreateUrl($a['actionModel'],$arg_name."/".$o->$key_field.$url_data);
			//转换操作名称
			$namephp = $a['name_function'];
			if(!empty($namephp))
			{
				$action_name = eval("$namephp;");
			} else {
				$action_name = Yii::t('base',$a['actionName']);
			}
            
			//用于判断操作是否可用
			$evalphp = $a['show_function'];            
			$title_field =$a['title_field'];
			if($evalphp=='')
			{
			 	if($title_field!='')
				{
					echo "<a  href='javascript:void(0);' onclick=\"javascript:edit('".$url."','".$a['btn_class']."','".Yii::t('base',$a['actionName']).'『'.$o->$title_field."』')\" class='with_title'>".$action_name."</a>";
				} else {
					echo "<a href='".$url."' class='".$a['btn_class']."'>".$action_name."</a>";	
				}
			} else {
				if(@eval("$evalphp;")==1)
				{
					if($title_field!='')
					{
						
						echo "<a  href='javascript:void(0);' onclick=\"javascript:edit('".$url."','".$a['btn_class']."','".Yii::t('base',$a['actionName']).'『'. Util::new_add_slashes($o->$title_field)."』')\" class='with_title'>".$action_name."</a>";
					} else {
						echo "<a href='".$url."' class='".$a['btn_class']."'>".$action_name."</a>";	
					}
				} else { 
				 	if(@eval("$evalphp;")!=2){
                        echo "<font color='#ccc'>".$action_name."</font>";	
				 	}
				}
			}
								
			if($i<(count($act_list)-1))
			{
				if(@eval("$evalphp;")==1 or @eval("$evalphp;")==0)
                { 
                    echo " |  ";
				}
			}
			$i++;
		};
	}
	
	
	
	/**处理列表对应操作
	*@ $o 对应记录
	*@ $act_list 操作列表
	*@ $key_field 记录主键
	*@ $art_name  传递主键值的键名，默认为id
	*@ $title_field 记录标题字段名称
	*/
	public static function  getProcessActList($o,$act_list,$key_field,$arg_name='id')
	{        
		$str='';
		$i=0;
		foreach($act_list as $a){
			$url_data='';
			$data = $a['data'];
			if($data!='')
			{	
				if(@eval("$data;")==false)
				 {
				 	 $url_data = "/".str_replace("=","/",$data);
					
				 }
				 else
				 {
				 	 
					 $evalresult = @eval("$data;");
					 if(preg_match('/\=$/',$evalresult))
					 {
					 	
						$url_data='';
					 }
					 else if(preg_match('/\=\&/',$evalresult))
					 {
						$url_data='';
					 }
					 else
					 {
					 	 $url_data = "/".str_replace("=","/",$evalresult);
					 }
					
					
				 }
			}
			$url = ActionMenuHelper::reCreateUrl($a['actionModel'],$arg_name."/".$o->$key_field.$url_data);
			//转换操作名称
			$namephp = $a['name_function'];
			if(!empty($namephp))
			{
				$action_name = eval("$namephp;");
			}
			else
			{
				$action_name = Yii::t('base',$a['actionName']);
			}
			//用于判断操作是否可用
			$evalphp = $a['show_function'];
			$title_field =$a['title_field'];
			 if($evalphp=='')
			 {
			 	if($title_field!='')
				{
					$str.= "<a  href='javascript:void(0);' onclick=\"javascript:edit('".$url."','".$a['btn_class']."','".Yii::t('base',$a['actionName']).'『'.$o->$title_field."』')\" class='with_title'>".$action_name."</a>";
				}
				else
				{
					$str.= "<a href='".$url."' class='".$a['btn_class']."'>".$action_name."</a>";	
				}
			 }
			 else
			 {
				if(@eval("$evalphp;")==1)
				 {
					if($title_field!='')
					{
						
						$str.= "<a  href='javascript:void(0);' onclick=\"javascript:edit('".$url."','".$a['btn_class']."','".Yii::t('base',$a['actionName']).'『'.new_add_slashes($o->$title_field)."』')\" class='with_title'>".$action_name."</a>";
					}
					else
					{
						$str.= "<a href='".$url."' class='".$a['btn_class']."'>".$action_name."</a>";	
					}
				 }
				 else
				 {
				 	if($evalphp==2){
				 		
				 	}else{
				 		$str.= "<font color='#ccc'>".$action_name."</font>";
				 	}
				 }
			 }
								
			if($i<(count($act_list)-1))
			{
				$str.= " | ";
			}
			$i++;
		};
		return $str;
	}
	
}