<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php $this->display_seo(); ?>
<title><?php echo CHtml::encode($this->pageTitle);?></title>
<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/public/images/admin_img/favicon.ico" type="image/x-icon" />
<link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/<?php echo Yii::app()->language; ?>_admin.css"  rel="stylesheet" />
<?php   Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/public/js/admin.js"></script>
</head>
<body class="right_body" >
<?php
     
	$menu_str=MenuShowFun::getListTopMenu($this->son_menu);

?>
<div class="body">
	<?php if(Yii::app()->user->hasFlash('success')): ?>
		<script type="text/javascript">
		showFlashInfo('<?php echo Yii::app()->user->getFlash('success'); ?>','success');
		</script>
	<?php endif; ?>
	<?php if(Yii::app()->user->hasFlash('failed')): ?>
		<script type="text/javascript">
		showFlashInfo('<?php echo Yii::app()->user->getFlash('failed'); ?>','failed');
		</script>
	<?php endif; ?>
	<div class="action_menu">
		<ul>
		<?php
			echo $menu_str;
		?>
		</ul>
	</div>
	<?php echo $content; ?>
</div>
</body>
</html>