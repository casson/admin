	   <?php
	   		use yii\Helper\Html;
	   		use yii\widget\ActiveForm;
	   ?>
       <div class="common_form"   style="width:500px;" >
	   		<?php $form = ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'user_name');?></td> 
					<td>
						<?php echo $model->user_name;?></td>
						<?php echo Html::activeHiddenField($model,'user_name') ?>
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
					<tr>
					<td>
					 <?php echo $form->labelEx($model,'disabled');?>
					</td>
					<td>
					<?php echo CHtml::activeRadioButtonList($model,'disabled',$model->getDisabledOptions(),array('template'=>'{input}{label}','separator'=>" "));?>
								
					<?php echo $form->error($model,'disabled'); ?>
					</td>
					</tr>
				</tbody>
			</table>
			<div><input type="submit" class="hidden_submit" id='hidden_submit'  value="提交"/></div>
			<?php $this->endWidget(); ?>
        </div>
		