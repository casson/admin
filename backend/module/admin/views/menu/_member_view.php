<tr >
	<td><?php echo $data->resource_id;?></td>
	
	<?php
			echo '<td><a href="'.Yii::app()->createUrl($this->route).'/parent_id/'.$data->resource_id.'" style="color:#000;">'.Yii::t('resource',''.$data->name.'').'</a></td>';
	?>

	<td><?php echo $data->name;?></td>
	<td><?php echo $data->parent_id;?></td>
	<td><?php echo $data->module;?></td>
	<td><?php echo $data->controller;?></td>
	<td><?php echo $data->action;?></td>
	<td>
	<?php
		
		if($data->menu==0){
			echo '否';	
		}
		
		if($data->menu==1){
			echo '是';	
		}
		
	?>	
	</td>
	<td><?php echo $data->list_order;?></td> 
	<td>
	<?php
		if($data->disabled==0){
			echo '启用';	
		}else{
			echo '<font color="red">禁用</font>';
		}		
	?>	
	</td> 
	<td>
	<?php echo  ActionMenuHelper::ProcessActList($data,$act_list,'resource_id','resource_id');?>
	</td>
</tr>
 
 