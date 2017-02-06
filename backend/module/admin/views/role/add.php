		<?php 
			use yii\widgets\ActiveForm;
			use yii\Helpers\Html;
		?>
       	<div class="common_form"   >
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
				<tr>
				<td width="100"><?php echo Html::activeLabel($model,'role_name');?></td>
				<td>
					<?php echo Html::activeTextInput($model,'role_name',  array('class'=>'text')) ?>
				</td>
				</tr>
				<tr>
				<td><?php echo Html::activeLabel($model,'description');?></td>
				<td>
					<?php echo Html::activeTextInput($model,'description',  array('class'=>'text')) ?>
				</td>
				</tr>
				<tr>
				<td><?php echo Html::activeLabel($model,'disabled');?></td>
				<td>
					<?php echo Html::activeRadioList($model,'disabled',$model->getDisabledOptions(),array('template'=>'{input}{label}','separator'=>" "));?>
				</td>
				</tr>
				</tbody>
			</table>
			<div><input type="submit" class="default_btn"  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		