<tr >
	<td><?php echo $data->admin_id;?></td>
	<td><?php echo $data->user_name;?></td>
	<td><?php echo $data->role->role_name;?></td>
	<td><?php echo $data->last_login_ip;?></td>
	<td><?php echo $data->last_login_time;?></td>
	<td><?php echo $data->real_name;?></td>
	<td >
	<?php 
		if($data->disabled==1) echo Yii::t('admin','disabled');
		if($data->disabled==0) echo Yii::t('admin','normal');
	?>
	</td>
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($data,$act_list,'admin_id','admin_id');?>
	</td>
</tr>
