
       <div class="common_form"    >
	   		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'user_name');?></td> 
					<td><?php echo CHtml::activeTextField($model,'user_name',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'user_name'); ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'user_pwd');?></td> 
					<td><?php echo CHtml::activePasswordField($model,'user_pwd',array('class'=>'text')) ?>
					<?php echo $form->error($model,'user_pwd'); ?>
					</td>
					</tr>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'confirm_pwd');?></td> 
					<td><?php echo CHtml::activePasswordField($model,'confirm_pwd',array('class'=>'text')) ?>
					<?php echo $form->error($model,'confirm_pwd'); ?>
					</td>
					</tr>
					 
					<tr>
					<td><?php echo $form->labelEx($model,'real_name');?></td>
					<td>
					<?php echo CHtml::activeTextField($model,'real_name',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'real_name'); ?>
					
					</td>
					</tr>
					<tr>
					<td><?php echo $form->labelEx($model,'role_id');?></td>
					<td>
				    <?php echo CHtml::activeDropDownList($model,'role_id',$model->getRoleOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
					<?php echo $form->error($model,'role_id'); ?>
					</td>
					</tr>
					
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php $this->endWidget(); ?>
        </div>
		