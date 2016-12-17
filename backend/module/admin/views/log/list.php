<!--搜索-->
<?php 
 $this->renderPartial('_search',array('model'=>$model)); 

 //$this->renderPartial('_search',array('model'=>$model)); 
 $this->pageTitle = '管理员列表';
 $this->pageDesc = '';
 $this->pageKeywords = '';
?>


<!--列表-->
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'list_form')); ?>
<input type="hidden" name="id_list" id="id_list" />
<?php
	//设置单页显示最大记录数
	$dataProvider->setPagination(array(
			'pageSize' => 10
	));
	$this->dataProvider = $dataProvider;
	
	$this->act_list = $act_list;

	if(count($dataProvider->data)>0){
		//底部操作菜单
		$this->bt_act_list = ActionMenuHelper::getHiddenMenu(1);
		$this->bt_act_str=ActionMenuHelper::getProcessBtActList($this->bt_act_list);
		//列表模板相关
		$this->list_table_start ='<div class="tablelist"><table cellpadding="0" cellpadding="0" class="table"><tbody>
		<tr  >
		<th  width="25">'.Yii::t('admin','id').'</td>
		<th  width="100">模块</td>
		<th  width="100">操作人</td> 
		<th  width="100">操作id</td> 
		<th  width="100">操作类型</td> 
		<th  width="200">时间</td>  
		</tr>';
		$this->list_table_end = '</tbody></table></div>';
	}
	$this->showList('_member_view');
?>
<?php $this->endWidget(); ?>
