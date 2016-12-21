<!--搜索-->
<?php

 	use yii\widgets\ActiveForm;
 	use app\component\ActionMenuHelper;

 	$controller = Yii::$app->controller ; 
 	//$this->renderPartial('_search',array('model'=>$model)); 
	$controller->pageTitle 	= '管理员列表';
	$controller->pageDesc 	= '';
	$controller->pageKeywords = '';
?>


<!--列表-->
<?php $form=ActiveForm::begin(array('id'=>'list_form')); ?>
<input type="hidden" name="id_list" id="id_list" />
<?php
	//设置单页显示最大记录数
	$dataProvider->setPagination(array(
			'pageSize' => 10
	));
	$controller->dataProvider = $dataProvider;
	$controller->act_list = $act_list;

	if($dataProvider->count>0){
		//底部操作菜单
		$controller->bt_act_list = ActionMenuHelper::getHiddenMenu(1);
		$controller->bt_act_str  = ActionMenuHelper::getProcessBtActList($controller->bt_act_list);
		//列表模板相关
		$controller->list_table_start ='<div class="tablelist"><table cellpadding="0" cellpadding="0" class="table"><tbody>
		<tr  >
		<th  width="25">'.Yii::t('admin','id').'</td>
		<th  width="100">'.Yii::t('attr','user_name').'</td>
		<th  width="100">'.Yii::t('attr','role_id').'</td>
		<th  width="100">'.Yii::t('attr','last_login_ip').'</td>
		<th  width="200">'.Yii::t('attr','last_login_time').'</td> 
		<th  width="100">'.Yii::t('attr','real_name').'</td>
		<th  width="100">'.Yii::t('admin','status').'</td>
		<th>'.Yii::t('admin','manage_operation').'</td>
		</tr>';
		$controller->list_table_end = '</tbody></table></div>';
	}
	$controller->showList('_member_view');
?>
<?php ActiveForm::end(); ?>
