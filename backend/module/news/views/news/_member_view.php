<?php use app\component\ActionMenuHelper;?>
<tr >
	<td><?php echo $model->id;?></td>
    <td><?php echo $model->type;?></td>
	<td><?php echo $model->title;?></td>
	<td><?php echo date('Y-m-d H:i:s', $model->sendtime); ?></td>
    <td><?php echo $model->admin; ?></td>
    <td><?php echo '是'; ?></td>
	<td><?php echo ActionMenuHelper::ProcessActList($model,$act_list,'id','id');?></td>
</tr>
 
 