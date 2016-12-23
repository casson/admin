<tr >
	<td><?php echo $model->id;?></td>
	<td><?php echo  Yii::t('resource',$model->module);?></td> 
	<td><?php echo $model->name ;?></td>
	<td><?php echo $model->recid ;?></td>
  
	<td><?php echo  Yii::t('resource',$model->resName);?></td>  
	<td><?php echo date("Y-m-d G:i:s",$model->pdate) ;?></td>	 
</tr>
 
 