		<?php
			use yii\widgets\ActiveForm;
			use yii\Helpers\Html;
		?>
    	<div class="common_form"    >
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'user_name');?></td> 
					<td><?php echo Html::activeTextInput($model,'user_name',  array('class'=>'text')) ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'user_pwd');?></td> 
					<td><?php echo Html::activePasswordInput($model,'user_pwd',array('class'=>'text')) ?>
					</td>
					</tr>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'confirm_pwd');?></td> 
					<td><?php echo Html::activePasswordInput($model,'confirm_pwd',array('class'=>'text')) ?>
					</td>
					</tr>
					 
					<tr>
					<td><?php echo Html::activeLabel($model,'real_name');?></td>
					<td>
						<?php echo Html::activeTextInput($model,'real_name',  array('class'=>'text')) ?>
					</td>
					</tr>
					<tr>
					<td><?php echo Html::activeLabel($model,'role_id');?></td>
					<td><?php echo Html::activeDropDownList($model,'role_id',$model->getRoleOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
					</td>
					</tr>
					
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		