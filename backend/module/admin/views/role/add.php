
       <div class="common_form"   >
	   		<?php $form=$this->beginWidget('CActiveForm', array('id'=>'ajax_form','enableAjaxValidation'=>true,'clientOptions'=>array('validateOnSubmit'=>true, 'validateOnChange'=>false))); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				<tr>
				<td width="100"><?php echo $form->labelEx($model,'role_name');?></td>
				<td>
				<?php echo CHtml::activeTextField($model,'role_name',  array('class'=>'text')) ?>
				<?php echo $form->error($model,'role_name'); ?>
				
				</td>
				</tr>
				<tr>
				<td><?php echo $form->labelEx($model,'description');?></td>
				<td>
				<?php echo CHtml::activeTextField($model,'description',  array('class'=>'text')) ?>
				<?php echo $form->error($model,'description'); ?>
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
			<div><input type="submit" class="default_btn"  value="提交"/></div>
			<?php $this->endWidget(); ?>
        </div>
		