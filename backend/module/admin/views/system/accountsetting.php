
       <div class="common_form" >
	   		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				
				<tr>
				<td width="80"><?php echo $form->labelEx($model,'user_name');?></td> 
				<td><?php echo Yii::app()->session['admin_name'];?></td>
				</tr>
				
				<tr>
				<td width="80"><?php echo $form->labelEx($model,'last_login_time');?></td> 
				<td><?php echo Yii::app()->session['last_login_time'];?></td>
				</tr>
				
				<tr>
				<td width="80"><?php echo $form->labelEx($model,'last_login_ip');?></td> 
				<td><?php echo Yii::app()->session['last_login_ip'];?></td>
				</tr>
				
				<tr>
				<td><?php echo $form->labelEx($model,'real_name');?></td>
				<td>
				<?php echo CHtml::activeTextField($model,'real_name',  array('class'=>'text','value'=>$admin->real_name)) ?>
				<?php echo $form->error($model,'real_name'); ?>
				
				</td>
				</tr> 
	 
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php $this->endWidget(); ?>
        </div>
		