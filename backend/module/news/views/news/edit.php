		<?php
			use yii\widgets\ActiveForm;
			use yii\Helpers\Html;
            use app\widgets\Ckeditorwidget;
            use app\widgets\Uploadify;
        ?>
        <?php echo Ckeditorwidget::widget();?>
        
        <div class="common_form"    >
	   		<?php $form=ActiveForm::begin(array('id'=>'ajax_form','enableAjaxValidation'=>true, 'validateOnSubmit'=>true, 'validateOnChange'=>false)); ?>
			 <table cellpadding="0" cellpadding="0">
				<tbody>
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'title');?></td> 
					<td><?php echo Html::activeTextInput($model,'title',  array('class'=>'text','style'=>'width:400px')) ?>
					</td>
					</tr>
                    
                    <tr>
                    <td><?php echo Html::activeLabel($model, 'type'); ?></td>    
                    <td>
                        <?php echo Html::activeDropDownList($model, 'type', $model->getNewsType(), array('class'=>'text','style'=>'width:250px')); ?>
                    </td>
                    </tr>
                    
					<tr>
					<td width="80"><?php echo Html::activeLabel($model,'content');?></td> 
					<td>
                        <?php echo Html::activeTextArea($model,'content',array('class'=>'ckeditor','style'=>'width:600px;height:480px')); ?>
                        <div style="margin-top:10px;">
                            <?php echo Uploadify::widget(array("ext"=>'*.gif;*.GIF;*.jpg;*.JPG;*.png;*.PNG;*.jpeg;*.JPEG;','style'=>1,'mode'=>2,'max_num'=>100,'max_size'=>"0",'multi'=>'1','auto'=>'true','thumbImg'=>'有水印|ylyimg.png','thumb'=>'100X129,121X90','cname'=>"body"));?>
                        </div>
                    </td>
					</tr>			
				</tbody>
			</table>
			<div><input type="submit" class="default_btn" id='submit'  value="提交"/></div>
			<?php ActiveForm::end(); ?>
        </div>
		
        