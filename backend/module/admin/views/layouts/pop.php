<?php
	use app\component\ActionMenuHelper;
	$controller = Yii::$app->controller;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="icon" href="<?php echo Yii::$app->request->baseUrl; ?>/public/images/admin_img/favicon.ico" type="image/x-icon" />
<link type="text/css" href="<?php echo Yii::$app->request->baseUrl; ?>/public/css/<?php echo Yii::$app->language; ?>_admin.css"  rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/public/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/public/js/admin.js"></script>
</head>
<body>
<?php
	$menu_str=ActionMenuHelper::getListTopMenu($controller->son_menu);
?>
<div class="body" >
	<?php if(Yii::$app->session->hasFlash('success')): ?>
		<script type="text/javascript">
		showFlashInfo('<?php echo Yii::$app->session->getFlash('success'); ?>','success');
		</script>
	<?php endif; ?>
	<?php if(Yii::$app->session->hasFlash('failed')): ?>
		<script type="text/javascript">
		showFlashInfo('<?php echo Yii::$app->session->getFlash('failed'); ?>','failed');
		</script>
	<?php endif; ?>
	<?php echo $content; ?>
</div>
</body>
</html>