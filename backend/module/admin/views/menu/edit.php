
       <div class="common_form" style="width:500px;">
	   		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'name');?></td> 
					<td><?php echo CHtml::activeTextField($model,'name',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'name'); ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'parent_id');?></td> 
					<td><?php echo CHtml::activeTextField($model,'parent_id',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'parent_id'); ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo $form->labelEx($model,'module');?></td> 
					<td><?php echo CHtml::activeTextField($model,'module',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'module'); ?>
					</td>
					
					</tr>
					 
					<tr>
					<td><?php echo $form->labelEx($model,'controller');?></td>
					<td>
					<?php echo CHtml::activeTextField($model,'controller',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'controller'); ?>
					
					</td>
					</tr>
					
					<tr>
					<td><?php echo $form->labelEx($model,'action');?></td>
					<td>
					<?php echo CHtml::activeTextField($model,'action',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'action'); ?>
					
					</td>
					</tr>
					
					<tr>
					<td><?php echo $form->labelEx($model,'btn_class');?></td>
					<td>
				   <?php echo CHtml::activeDropDownList($model,'btn_class',$model->getBtnClassOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
					<?php echo $form->error($model,'btn_class'); ?>
					</td>
					</tr>
					
					<tr>
					<td><?php echo $form->labelEx($model,'title_field');?></td>
					<td>
					<?php echo CHtml::activeTextField($model,'title_field',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'title_field'); ?>
					
					</td>
					</tr>
					
					<tr>
					<td><?php echo $form->labelEx($model,'list_order');?></td>
					<td>
					<?php echo CHtml::activeTextField($model,'list_order',  array('class'=>'text')) ?>
					<?php echo $form->error($model,'list_order'); ?>
					
					</td>
					</tr>
					
					
					<tr>
					<td>
					 <?php echo $form->labelEx($model,'at_bottom');?>
					</td>
					<td>
					<?php echo CHtml::activeRadioButtonList($model,'at_bottom',$model->getBottomOptions(),array('template'=>'{input}{label}','separator'=>" "));?>
					<?php echo $form->error($model,'at_bottom'); ?>
					</td>
					</tr>
					
					<tr>
					<td>
					 <?php echo $form->labelEx($model,'menu');?>
					</td>
					<td>
					<?php echo CHtml::activeRadioButtonList($model,'menu',$model->getMenuOptions(),array('template'=>'{input}{label}','separator'=>" "));?>
					<?php echo $form->error($model,'menu'); ?>
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
		