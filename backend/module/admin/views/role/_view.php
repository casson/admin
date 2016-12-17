<tr >
	<td ><input type='checkbox'   class='list_check'  name='checkbox[<?php echo $data->role_id;?>]' value='<?php echo $data->role_id;?>'></td>
	<td><?php echo $data->role_id;?></td>
	<td><?php echo $data->role_name;?></td>
	<td >
	<?php 
		if($data->disabled==1) echo Yii::t('admin','disabled');
		if($data->disabled==0) echo Yii::t('admin','normal');
	?>
	</td>
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($data,$act_list,'role_id');?>
	</td>
</tr>
