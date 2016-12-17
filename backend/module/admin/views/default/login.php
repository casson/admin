<?php

	use yii\widgets\ActiveForm;
	use yii\helpers\Html;
	use yii\widgets\ActiveField;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::$app->id; ?></title>
<link rel="icon" href="<?php echo Yii::$app->request->baseUrl; ?>/public/images/admin_img/favicon.ico" type="image/x-icon" />
<link type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/css/zh_cn_admin_login.css"  rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>
<script>

//验证码
function showCode()
{	
	
	$('#img_code img').attr('src','<?php echo Yii::$app->request->baseUrl; ?>/api/GetCheckCode/?background=<?php echo urlencode('#E9E9E9');?>&font_color=<?php echo urlencode('#4E9F06');?>&width=60&height=25&font_size=13&time='+Math.random());
	$('#img_code').show();
}

//$(function(){showCode();});

//回车键提交表单

$(document).ready(function()
{
	$('input').bind('keyup', function (e){ 
		var theEvent = window.event || e; 
		var code = theEvent.keyCode || theEvent.which; 
		if(code==13){$('#login-form').submit();}
	});
}
)

/*版本选择
$(function(){
var _select=$('.select');
	_select.click(function(){
		$(this).find('ul').show();
	})

	$('.select li').click(function(){
		var eid=$(this).attr('eid');
		var eid_input='<input type="hidden" value="'+eid+'" name="eid" id="eid" \/>';
		var _eidhtml=$(this).html();
		$('.eid_value').html(_eidhtml);
		if($('#eid').attr('value')){
			$('#eid').attr('value',eid);	
		}
		
	})
	$('.select ul').hover(function(){
		
	},function(){
		$(this).hide();
	})
})
*/
</script>
</head>
<body>

	<div class="login">
	<?php $form=ActiveForm::begin(array('id'=>'login-form')); ?>
		<div class="login_form">
			<!--
			<div class="login_info">
				
				<div class="login_info_title"><?php echo Yii::t('admin','please select version');?></div>
				<div class="select">
					<p class="eid_value"><?php echo Yii::t('admin','zh_cn');?></p>
					<ul>
						<li eid="en_us"><?php echo Yii::t('admin','en_us');?></li>
						<li eid="zh_cn"><?php echo Yii::t('admin','zh_cn');?></li>
					</ul>
					<input type="hidden" value="zh_cn" name="admin_lang" id="eid" />
				</div>
				
			</div>
			-->
			<div class="form_info">
				<div class="field">
					<?php echo Html::label('Username','user_name',array('style'=>'width:60px')); ?>
					<?php echo Html::activeTextInput($model,'user_name',array('class'=>'text')); ?>
				</div>
				<div class="field">
					<?php echo Html::label('Password','user_pwd',array('style'=>'width:60px')); ?>
					<?php echo Html::activeTextInput($model,'user_pwd',array('class'=>'text')); ?>
				</div>

				<!--<div class="field">
					<?php //echo $form->filed($model,'check_code'); ?>
					<?php //echo Html::activeInput('text',$model,'check_code',  array('class'=>'text','size'=>10,'id'=>'check_code')) ?>
                    <cite class="yzm" id='img_code' ><img src=""  onclick="javascript:this.src='<?php echo Yii::$app->request->baseUrl; ?>/api/GetCheckCode/?background=<?php echo urlencode('#E9E9E9');?>&font_color=<?php echo urlencode('#4E9F06');?>&width=60&height=25&font_size=13&time='+Math.random();" /></cite>
				</div>
				-->
				
				<div class="field">
					<label></label>
					<button class="button" style="margin-left:60px;_margin-left:58px;margin-top:10px;" onclick="$('#login-form').submit();"></button>
				</div>
			</div>
		</div>
	<?php ActiveForm::end(); ?>
	</div>
	
</body>
</html>
