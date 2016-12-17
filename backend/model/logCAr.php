<?php
 
class logCAr extends CActiveRecord
{

   //更新前
   public function beforesave(){
     
	  return true;
   }
   //更新后
   public function aftersave(){
      $this->saves();
	  return true;
   }
   //删除前
   public function beforeDelete(){
    
	 return true;
   }
   //删除后
   public function afterdelete(){

    $this->saves(1);
    return true;
   }
   
   
   public function saves($type=0)
   {
     $controller = Yii::app()->controller->id ; //控制器
	 $action = Yii::app()->controller->Action->id;//动作名称
	 $name =  Yii::app()->session['admin_real_name']; //用户真实姓名
	 $admin_id =  Yii::app()->session['admin_id']; //用户id
	 $pdate = time();//删除日期
	 $recid =  $this->getPrimaryKey();  //记录id
	 if($type==1) 
	    $type= "delete";   //删除
	  else 
	    $type =  $this->scenario ;   //操作类型(update insert)
	$module =  Yii::app()->controller->module->id ; //模块名称
	//查询资源名称
	$criteria=new CDbCriteria;
	$criteria->select='name';
	$criteria->limit='1'; 
	$criteria->condition='module=:module and controller=:controller and action=:action';
	$criteria->params=array(':module'=>$module,':controller'=>$controller,':action'=>$action);
	$rs=Resource::model()->find($criteria); 
	$resName =  $rs->name;  
	
	if( $resName=="androidpclist" or ($module=="shouyou" and $controller=="game" and $action=="onestep") ){
	     return true;
	}
	 //存入日志记录表
	 $log = new  admin_log;
	 $log ->resName  = $resName;
	 $log ->controller = $controller;
	 $log ->module = $module;
	 $log ->action = $action;
	 $log ->name = $name;
	 $log ->admin_id = $admin_id;
	 $log ->recid = $recid;
	 $log ->type = $type;
	 $log ->pdate = $pdate;
	 $log ->save();  
   }
   
	 
}
?>