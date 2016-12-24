<?php

use yii\widgets\ActiveForm;	
use app\component\ActionMenuHelper;

$controller = Yii::$app->controller;
?>


<!--搜索-->
<?php
 $controller->renderPartial('_search',array('model'=>$model)); 
 $controller->pageTitle = '菜单列表';
 $controller->pageDesc = '';
 $controller->pageKeywords = '';
?>

<!--列表-->
<?php $form = ActiveForm::begin(array('id'=>'list_form')); ?>
<input type="hidden" name="id_list" id="id_list" />
<?php
	//设置单页显示最大记录数
	$dataProvider->setPagination(array(
			'pageSize' => 15
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
		<th  width="5%">'.Yii::t('admin','id').'</th>
		<th  width="8%">'.Yii::t('attr','name').'</th> 
		<th  width="5%">'.Yii::t('attr','name').'</th>
		<th  width="5%">'.Yii::t('attr','parent_id').'</th>
		<th  width="10%">'.Yii::t('attr','module').'</th>
		<th  width="10%">'.Yii::t('attr','controller').'</th>
		<th  width="10%">'.Yii::t('attr','action').'</th>
		<th  width="10%">'.Yii::t('attr','menu').'</th>
		<th  width="10%">'.Yii::t('attr','list_order').'</th>
		<th  width="100">'.Yii::t('attr','disabled').'</th>
		<th>'.Yii::t('admin','manage_operation').'</th>
		</tr>';
		$controller->list_table_end = '</tbody></table></div>';
	}
	echo $controller->showList('_member_view');
?>
<?php ActiveForm::end(); ?>
