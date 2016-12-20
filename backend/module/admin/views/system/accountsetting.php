		<?php
			use yii\widgets\ActiveForm;
			use yii\helpers\Html;
		?>

       	<div class="common_form" >
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				
				<tr>
					<td width="120"><?php echo Html::activeLabel($model, 'user_name');?></td> 
					<td><?php echo Html::activetextInput($model, 'user_name', ['class'=>'text', 'value'=>Yii::$app->session['admin_name']]);?></td>
				</tr>
				
				<tr>
				<td width="120"><?php echo Html::activeLabel($model, 'last_login_time');?></td> 
				<td><?php echo Html::activetextInput($model,'last_login_time', ['value'=>Yii::$app->session['last_login_time']]);?></td>
				</tr>
				
				<tr>
				<td width="120"><?php echo Html::activeLabel($model,'last_login_ip');?></td> 
				<td><?php echo Html::activetextInput($model,'last_login_ip', ['value'=>Yii::$app->session['last_login_ip']]);?></td>
				</tr>
                
				<tr>
				<td width="120"><?php echo Html::activeLabel($model,'real_name');?></td>
				<td><?php echo Html::activetextInput($model,'real_name', ['value'=>$admin->real_name]);?></td>
				</tr> 
	 
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		