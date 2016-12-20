<?php

//增加保存后台操作日志功能
class EActiveRecord extends CActiveRecord
{
	/*
	//保存以后
	public function afterSave()
	{
		$url = Yii::app()->request->getUrl();
		$module = Yii::app()->controller->getModule()->getId();
		$model = new Log;
		$model->query_string = $url;
		$model->username = $_SESSION['admin_name'];
		$model->ip = ip();
		$model->module = $module;
		$model->time = date("Y-m-d H:i:s");
		$model->save();
	}
	//删除以后
	public function afterDelete()
	{
		$url = Yii::app()->request->getUrl();
		$module = Yii::app()->controller->getModule()->getId();
		$model = new Log;
		$model->query_string = $url;
		$model->username = $_SESSION['admin_name'];
		$model->ip = ip();
		$model->module = $module;
		$model->time = date("Y-m-d H:i:s");
		$model->save();
	}
	*/
	//对列表页索索表单进行处理
	
	public function searchFormShow()
	{
		return;
	}

}

?>