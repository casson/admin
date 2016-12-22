<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::t('system', 'app name')."-".Yii::t('system', 'description');?></title>
<link type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/public/css/zh-CN_admin.css"  rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/public/js/jquery.js"></script>
</head>
<body class="right_body"  >
	<div class="body">
		
		<div class="title">
			<div class="title_info zs">
				<?php echo Yii::$app->session['admin_real_name'];?> 
				<?php 
				   $time =  date("G");
				   if ($time>0 and $time<12){
				   	  echo "早上好";
				   }elseif($time>12 and $time<18){
                      echo "下午好";
				   }else{
				   	  echo "晚上好";
				   }
				?>
				
				，欢迎使用后台管理系统<label>(<?php echo Yii::$app->session['admin_name'];?>)</label> ？<a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl('admin/system/accountsetting');?>"  onclick="$('#crumbs',window.parent.document).html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','account_setting');?>');">帐号设置</a>
			</div>
		</div>
		<div class="quick">
			<div class="login_info">
				您上次登录的时间是：<?php echo Yii::$app->session['last_login_time'];?> (不是您登录的？<a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl('admin/system/changepassword');?>"  onclick="$('#crumbs',window.parent.document).html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','change_password');?>');">请点这里</a>)
			</div>
			<p class="line">
			</p>
		 
		</div> 
 
	</div>
</body>
</html>
