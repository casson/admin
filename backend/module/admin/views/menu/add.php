		<?php 
			use yii\widgets\ActiveForm;
			use yii\Helpers\Html;
		?>
       	<div class="common_form" style="width:500px;">
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'name');?></td> 
					<td><?php echo Html::activeTextInput($model,'name',  array('class'=>'text')) ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'parent_id');?></td> 
					<td><?php echo Html::activeTextInput($model,'parent_id',  array('class'=>'text','value'=>''.$parent_id_get.'')) ?>
					</td>
					
					</tr>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'module');?></td> 
					<td><?php echo Html::activeTextInput($model,'module',  array('class'=>'text')) ?>
					</td>
					
					</tr>
					 
					<tr>
					<td><?php echo Html::activeLabel($model,'controller');?></td>
					<td>
					<?php echo Html::activeTextInput($model,'controller',  array('class'=>'text')) ?>					
					</td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'action');?></td>
					<td>
					<?php echo Html::activeTextInput($model,'action',  array('class'=>'text')) ?>
					</td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'btn_class');?></td>
					<td>
					   <?php echo Html::activeDropDownList($model,'btn_class',$model->getBtnClassOptions(),array('empty'=>Yii::t('admin','please select'))); ?>
					</td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'title_field');?></td>
					<td>
						<?php echo Html::activeTextInput($model,'title_field',  array('class'=>'text')) ?>
					</td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'list_order');?></td>
					<td>
						<?php echo Html::activeTextInput($model,'list_order',  array('class'=>'text')) ?>
					</td>
					</tr>
					
					
					<tr>
					<td><?php echo Html::activeLabel($model,'at_bottom');?></td>
					<td><?php echo Html::activeRadioList($model,'at_bottom',$model->getBottomOptions(),array('template'=>'{input}{label}','separator'=>" "));?></td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'menu');?></td>
					<td><?php echo Html::activeRadioList($model,'menu',$model->getMenuOptions(),array('template'=>'{input}{label}','separator'=>" "));?></td>
					</tr>
					
					<tr>
					<td><?php echo Html::activeLabel($model,'disabled');?></td>
					<td><?php echo Html::activeRadioList($model,'disabled',$model->getDisabledOptions(),array('template'=>'{input}{label}','separator'=>" "));?></td>
					</tr>
					
				</tbody>
			</table>
			<div><input type="submit" class="hidden_submit" id='hidden_submit'  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		