<?php use app\component\ActionMenuHelper; ?>
<tr>
	<td><?php echo $model->resource_id;?></td>
	<?php echo '<td><a href="'.Yii::$app->urlManager->createAbsoluteUrl(Yii::$app->controller->route).'/parent_id/'.$model->resource_id.'" style="color:#000;">'.Yii::t('resource',''.$model->name.'').'</a></td>'; ?>
	<td><?php echo $model->name;?></td>
	<td><?php echo $model->parent_id;?></td>
	<td><?php echo $model->module;?></td>
	<td><?php echo $model->controller;?></td>
	<td><?php echo $model->action;?></td>
	<td>
	<?php		
		if($model->menu==0){
			echo '否';	
		}
		if($model->menu==1){
			echo '是';	
		}	
	?>	
	</td>
	<td><?php echo $model->list_order;?></td> 
	<td>
	<?php
		if($model->disabled==0){
			echo '启用';	
		}else{
			echo '<font color="red">禁用</font>';
		}		
	?>	
	</td> 
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($model,$act_list,'resource_id','resource_id');?>
	</td>
</tr>
 
 