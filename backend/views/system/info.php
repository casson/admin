<?php use yii\helpers\Html;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title><?php  echo $title; ?></title>

</head>

<body>

<style type="text/css">

*{margin:0px;padding:0px;font-size:12px;font-family:Arial,Verdana;}

#wrapper{width:450px;height:150px;background:#fff;border:1px solid #ccc;position:absolute;top:45%;left:50%;margin-top:-100px;margin-left:-225px;padding:1px;}

p.msg-title{width:440px;height:20px;line-height:20px;text-align:left;color:#ffffff;margin:0px;padding:5px; background:#4B89C2; font-size:14px;font-weight:bold;}

p.message{width:100%;height:85px;line-height:85px;text-align:center;color:#333333;margin-top:5px;margin-bottom:5px;}

p.error{width:100%;height:85px;line-height:85px;text-align:center;color:#333333;margin-top:5px;margin-bottom:5px;font-weight:bold;}

p.notice{width:440px;height:15px;line-height:15px;text-align:center; padding:5px; background:#E4ECF7; color:#6094C4;margin:0px;}

p.notice a{color:#0099cc;text-decoration:none}

p.notice a:hover{color:#FF9900;text-decoration:underline}

</style>

<div id="wrapper">

<p class="msg-title"><?php  echo Html::encode($title); ?></p>

<present name="message">

<p class="message"><?php  echo Html::encode($message); ?></p>

</present>

<present name="closeWin">

<p class="notice"><a href="javascript:void(0)" onclick="redirect('<?php echo $target;?>')"><?php   echo "点击这里跳转下一页！" ;?></a></p>

</present>

</div>

<script type="text/javascript">
function redirect(target){
	if(target=='self'){
		location.href = '<?php echo $url;?>';
	}else if(target=='parent'){
		parent.location.href = '<?php echo $url;?>';
	}else if(target=='top'){
		top.location.href = '<?php echo $url;?>';
	}else{
		location.href = '<?php echo $url;?>';
	}
}
setTimeout('redirect("<?php echo $target;?>")',<?php echo $time;?>);
</script>

</body>

</html>