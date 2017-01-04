<?php
	use app\component\ActionMenuHelper;
?>
<tr >
	<td><?php echo $model->admin_id;?></td>
	<td><?php echo $model->user_name;?></td>
	<td><?php echo $model->role->role_name;?></td>
	<td><?php echo $model->last_login_ip;?></td>
	<td><?php echo $model->last_login_time;?></td>
	<td><?php echo $model->real_name;?></td>
	<td >
	<?php 
		if($model->disabled==1) echo Yii::t('admin','disabled');
		if($model->disabled==0) echo Yii::t('admin','normal');
	?>
	</td>
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($model, $act_list, 'admin_id', 'admin_id');?>
	</td>
</tr>
