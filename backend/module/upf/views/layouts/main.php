<?php use yii;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::$app->controller->assetsUrl; ?>/css/common.css"/>
<script type="text/javascript" src="<?php echo Yii::$app->request->baseUrl; ?>/public/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo Yii::$app->controller->assetsUrl; ?>/js/common.js?<?php echo rand(0,9999);?>"></script>
</head>
<body >
<?php echo $content; ?>
</body>
</html>