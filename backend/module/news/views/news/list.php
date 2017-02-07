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
		<tr>
		<th  width="10%">id</td>
		<th  width="10%">类型</td>
		<th  width="20%">标题</td>
		<th  width="10%">发布时间</td>
        <th  width="10%">编辑</td>
        <th  width="10%">是否通过</td>
		<th  width="20%">操作</td>
		</tr>';
		$controller->list_table_end = '</tbody></table></div>';
	}
	echo $controller->showList('_member_view');
?>
<?php ActiveForm::end(); ?>
