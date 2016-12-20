		<?php
			use yii\widgets\ActiveForm;
			use yii\helpers\Html;
		?>
       	<div class="common_form" >
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true,'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				
				<tr>
					<td width="120"><?php echo Html::activeLabel($model,'user_name');?></td> 
					<td><?php echo Yii::$app->session['admin_name'];?></td>
				</tr>
			 
				<tr>
					<td width="120"><?php echo Html::activeLabel($model,'original_pwd');?></td> 
					<td>
						<?php echo Html::activePasswordInput($model,'original_pwd',array('class'=>'text')) ?>
						<?php //echo $form->error($model,'original_pwd'); ?>
					</td>
				</tr>
				<tr>
					<td width="120"><?php echo Html::activeLabel($model,'new_pwd');?></td> 
					<td>
						<?php echo Html::activePasswordInput($model,'new_pwd',array('class'=>'text')) ?>
						<?php //echo $form->error($model,'new_pwd'); ?>
					</td>
				</tr>
				<tr>
					<td width="120"><?php echo Html::activeLabel($model,'retype_pwd');?></td> 
					<td>
					<?php echo Html::activePasswordInput($model,'retype_pwd',array('class'=>'text')) ?>
					<?php //echo $form->error($model,'retype_pwd'); ?>
					</td>
				</tr>
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		