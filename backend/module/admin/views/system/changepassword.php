
       <div class="common_form" >
	   		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				
				<tr>
					<td width="120"><?php echo $form->labelEx($model,'user_name');?></td> 
					<td><?php echo Yii::app()->session['admin_name'];?></td>
				</tr>
			 
				<tr>
					<td width="120"><?php echo $form->labelEx($model,'original_pwd');?></td> 
					<td>
						<?php echo CHtml::activePasswordField($model,'original_pwd',array('class'=>'text')) ?>
						<?php echo $form->error($model,'original_pwd'); ?>
					</td>
				</tr>
				<tr>
					<td width="120"><?php echo $form->labelEx($model,'new_pwd');?></td> 
					<td>
						<?php echo CHtml::activePasswordField($model,'new_pwd',array('class'=>'text')) ?>
						<?php echo $form->error($model,'new_pwd'); ?>
					</td>
				</tr>
				<tr>
					<td width="120"><?php echo $form->labelEx($model,'retype_pwd');?></td> 
					<td>
					<?php echo CHtml::activePasswordField($model,'retype_pwd',array('class'=>'text')) ?>
					<?php echo $form->error($model,'retype_pwd'); ?>
					</td>
				</tr>
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php $this->endWidget(); ?>
        </div>
		