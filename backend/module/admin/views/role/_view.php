<?php use app\component\ActionMenuHelper;?>
<tr>
	<td ><input type='checkbox' class='list_check' name='checkbox[<?php echo $model->role_id;?>]' value='<?php echo $model->role_id;?>'></td>
	<td><?php echo $model->role_id;?></td>
	<td><?php echo $model->role_name;?></td>
	<td >
	<?php 
		if($model->disabled==1) echo Yii::t('admin','disabled');
		if($model->disabled==0) echo Yii::t('admin','normal');
	?>
	</td>
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($model,$act_list,'role_id');?>
	</td>
</tr>
