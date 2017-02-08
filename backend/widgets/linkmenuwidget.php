<?php

/**
*联动菜单
*结合extend模块使用
*/

class LinkmenuWidget extends CWidget
{
	
	private $_assetsUrl;//资源文件路径
	public  $base_url;  //包含域名的根目录访问地址
	public  $style=1; //1:下拉风格
	public  $key_id;//根节点ID
	public  $menu_id;//菜单ID
	public  $setting;//设置
	public  $level=3;//显示层级数
	public  $record_menu_id;//记录关联的选中值
	public  $array_id=array(0);//记录关联的ID，按层级排列的数组 1,12 ,45
	public  $model;
	public  $is_open=0;//如果该值1，则读取下级数据时，加入该条件
	public function init()
	{
	    
		if($this->record_menu_id==$this->key_id)
		{
			$this->record_menu_id='';
		}
		if(empty($this->key_id))
		{
			echo Yii::t('info','failed to initialize linkmenu').",".Yii::t('info','arguments lack')."(key_id)";
			exit;
		}
		if(empty($this->menu_id))
		{
			echo Yii::t('info','failed to initialize linkmenu').",".Yii::t('info','arguments lack')."(menu_id)";
			exit;
		}
		if(empty($this->model))
		{
			echo Yii::t('info','failed to initialize linkmenu').",".Yii::t('info','arguments lack')."(model)";
			exit;
		}
		$this->base_url = Yii::app()->request->hostInfo.Yii::app()->homeUrl;
		$this->registerClientScript();
		if($this->record_menu_id!='')
		{
			$this->array_id='';
			$this->getArrayId();	
			
		}
		else//读取默认选中值
		{
			$default_obj = Linkmenu::model()->find('is_default=1 and key_id='.$this->key_id);
			if(!empty($default_obj))
			{
				$this->array_id='';
				$this->record_menu_id =  $default_obj->menu_id;
				$this->getArrayId();	
			}
		}
		
	}
	
	public function run()
	{
		
		if($this->style==1)
		{
			$string = $this->selectMenu();
		}
		
	
	}
	//返回下拉风格菜单
	public function selectMenu()
	{
		
		$this->setting = $this->getSetting();
		if($this->setting=='')
		{
			$this->level = $this->setting['level'];
			
		}
		
		$str = '';
		$str.=CHtml::activeHiddenField($this->model,$this->menu_id, array('class'=>'input_text','value'=>$this->record_menu_id,'id'=>$this->menu_id));
		$str.="<div class='select_linkmenu'>";
		for($i=0;$i<$this->level;$i++)
		{
		
			
			if($this->array_id[$i]!=='')
			{
				
				$menu_list = $this->getNextLevel($this->array_id[$i]);
			}
			
			$str.="<select id='".$this->menu_id."_".$i."' name='".$this->menu_id."_".$i."' ";
			
			//如果下一级还未有数据暂且隐藏下一层级
			
			if(empty($menu_list))
			{
				$str.="style='display:none;'";
			}
			
			$str.=" >";
			
			$str.="<option value=''>".Yii::t('admin','please select')."</option>";
			if(!empty($menu_list))
			{
				foreach($menu_list as $o)
				{
	
					$str.="<option value='".$o->menu_id."'";
					if($o->menu_id==$this->array_id[($i+1)])
					{
						$str.=" selected='selected' ";
					}
					$str.=" >".$o->name."</option>";
					
				}
			}
			
			$str.="</select>";
			
			
			$str.="<script type='text/javascript'>
						$(function(){
						
							$('#".$this->menu_id."_".$i."').bind('change',onchange);
							function onchange(e)
							{
								 
								 if(this.value=='')
								 {
								 	var j=".($i+1).";
									for(var j=".($i+1).";j<".$this->level.";j++)
									{
										var option_str='<option value=\"\">".Yii::t('admin','please select')."</option>';
										$('#".$this->menu_id."_'+j).html(option_str);
										$('#".$this->menu_id."_'+j).hide();
									}
									 $('#".$this->menu_id."').val('');
									
									return;
								 }
								 $('#".$this->menu_id."').val(this.value);
								
								 //更新下一层级选项并显示
								 if($('#".$this->menu_id."_".($i+1)."').length>0&&this.value!=0)
								 { 
									$.get('".Yii::app()->createUrl('ajax/GetNextLevel/')."', {parent_id:this.value,key_id:".$this->key_id.",is_open:".$this->is_open."}, function(data){
											 if(data!='')
											 {
												 var menu_list = eval('('+data+')');
												 var option_str='<option value=\"\">".Yii::t('admin','please select')."</option>';
												 for(var i=0;i<menu_list.length;i++)
												 {
													option_str+='<option value='+menu_list[i].menu_id+'>'+menu_list[i].name+'</option>';
												 }
											
												$('#".$this->menu_id."_".($i+1)."').html(option_str);
												$('#".$this->menu_id."_".($i+1)."').show();
											}
											else
											{
												var option_str='<option value=\"\">".Yii::t('admin','please select')."</option>';
												$('#".$this->menu_id."_".($i+1)."').html(option_str);
												$('#".$this->menu_id."_".($i+1)."').hide();
											}
											
										
									});
									
								}
							}
						
						})
				 </script>";
			
			unset($menu_list);
		}
		
		$str.="</div>";
		
		echo $str;
		
		
	
	}
	
	
	//取出下级菜单信息
	public function getNextLevel($parent_id=0)
	{
		if($parent_id!=0)
		{
			$parent_obj = Linkmenu::model()->findByPk($parent_id);
			if($parent_obj->key_id==0)$parent_id=0;
		}
		if($this->is_open)
		{
			$menu_list = Linkmenu::model()->findAll(array('condition'=>'key_id=:key_id and parent_id=:parent_id and is_open=:is_open','params'=>array(':key_id'=>$this->key_id,':parent_id'=>$parent_id,':is_open'=>$this->is_open),'order'=>'list_order asc'));
		}
		else
		{
			$menu_list = Linkmenu::model()->findAll(array('condition'=>'key_id=:key_id and parent_id=:parent_id','params'=>array(':key_id'=>$this->key_id,':parent_id'=>$parent_id),'order'=>'list_order asc'));
		}
		return $menu_list;
		
	
	}
	//根据当前值，取出父级
	function getArrayId($son_id='')
	{
		if($son_id=='')
		{
			$son_id = $this->record_menu_id;
		}

		$model = Linkmenu::model()->findByPk($son_id);
		if($model->parent_id!=0)
		{
			$this->array_id.=$model->parent_id.",";
			$this->getArrayId($model->parent_id);
		}
		else if($model->key_id!=0)
		{
			$this->array_id=$this->record_menu_id.",".$this->array_id.$model->key_id;
			$this->getArrayId($model->key_id);
		}
		else
		{
			
			$this->array_id = explode(",",$this->array_id);
			$this->array_id = array_reverse($this->array_id);

		}
		
	
	}
	
	//根据节点获取设置
	public function getSetting()
	{
		$model = Linkmenu::model()->find('key_id=:key_id and parent_id=0',array(':key_id'=>$this->key_id));
		return string2array($model->setting);
		
	}
	//
	protected function registerClientScript()
	{
      	//调用模块的资源文件
		$this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.extend.assets'));
		$cs=Yii::app()->clientScript;
		$cs->registerCssFile($this->_assetsUrl.'/css/common.css');
	    $cs->registerScriptFile($this->_assetsUrl.'/js/common.js');
	}
	
}