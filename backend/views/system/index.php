<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo Yii::app()->name;?></title> 
<link type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/<?php echo Yii::app()->language; ?>_admin.css"  rel="stylesheet" />
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/art_dialog/artDialog.source.js?skin=wzcms"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/art_dialog/plugins/iframeTools.source.js" ></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/art_dialog/_doc/highlight/highlight.pack.js"  ></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/art_dialog/_doc/highlight/languages/javascript.js" ></script>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/admin.js"></script>
</head>
<body style="overflow:hidden;">
<div id="dvLockScreen" class="ScreenLock" style="display:none">
    <div id="dvLockScreenWin" class="inputpwd">
    <h5><b class="ico ico-info"></b><span id="lock_tips"><?php echo Yii::t('admin','lock_inits');?></span></h5>
    <div class="input">
    	<label class="lb"><?php echo Yii::t('admin','lock_password');?></label><input type="password" id="lock_password" class="input-text" size="24">
        <input type="submit" class="submit" value="&nbsp;" name="dosubmit" onclick="check_screenlock();return false;">
    </div></div>
</div>
<div style="display: block;" class="scroll"><a href="javascript:;" class="per" title="<?php echo  Yii::t('admin','using the mouse wheel scrolling sidebar');?>" onclick="menuScroll(1);"></a><a href="javascript:;" class="next" title="<?php echo  Yii::t('admin','using the mouse wheel scrolling sidebar');?>" onclick="menuScroll(2);"></a></div>

 <div class="top">
	
	<div class="admin_logo">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/images/admin_img/admin_logo.jpg">
	</div>
	<div style="float:left">
	<div  style="height:20px;line-height:20px;float:left;margin-left:700px;" >
	<?php echo Yii::t('admin','welcome').Yii::app()->session['role_name'];?> <?php echo Yii::app()->session['admin_real_name'];?> | <a href="<?php echo Yii::app()->createUrl('admin/system/changepassword');?>"  onclick="$('#crumbs').html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','change_password');?>');"target="main"><?php echo Yii::t('resource','change_password');?></a> | <a href="<?php echo Yii::app()->createUrl('admin/default/logout');?>" ><?php echo Yii::t('admin','logout');?></a>
	</div>
	<div class="top_nav"   >
			<ul class="nav" >
				<?php for($i=0;$i<count($top_menus);$i++){?>
				<li ><a href="javascript:void(0)" onclick="loadLeftMenu(<?php echo $top_menus[$i]->resource_id; ?>,'<?php echo Yii::app()->createUrl("".$top_menus[$i]->module."/".$top_menus[$i]->controller."/".$top_menus[$i]->action."");?>');" id='nav_li_<?php echo $top_menus[$i]->resource_id; ?>'  ><?php echo Yii::t('resource',$top_menus[$i]->name);?></a></li>
				<?php }?>
			</ul>
	</div>
	</div>
	<div class="top_member" style="display:none"  >
	<?php echo Yii::t('admin','welcome').Yii::app()->session['role_name'];?> <?php echo Yii::app()->session['admin_real_name'];?> | <a href="<?php echo Yii::app()->createUrl('admin/system/changepassword');?>"  onclick="$('#crumbs').html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','change_password');?>');"target="main"><?php echo Yii::t('resource','change_password');?></a>
	</div>
</div>
<div class="side_switch" id="side_switch">
</div>
<div class="side_switchl" id="side_switchl">
</div>
<div id='main_content' >
	<div class="left" style="float:left;">
		<div class="member_info" style="display:none">
				<div class="member_ico" > <a  onclick="$('#crumbs').html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','account_setting');?>');" href="<?php echo Yii::app()->createUrl('admin/system/accountsetting');?>" target="main"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/admin_img/nophoto.gif" width="43" height="43" ></a></div>	             <a class="system_a" onclick="$('#crumbs').html('<?php echo Yii::t('resource','my_panel');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','personal_info');?>&nbsp;>&nbsp;<?php echo Yii::t('resource','account_setting');?>');" href="<?php echo Yii::app()->createUrl('admin/system/accountsetting');?>" target="main"><?php  echo Yii::t('resource','account_setting');?></a><a href="<?php echo Yii::app()->createUrl('admin/default/logout');?>" class="system_logout"><?php echo Yii::t('admin','logout');?></a>
		</div>
		<div id="scroll">			
			<div id='left_main'>
			
			</div>
		</div>
	</div>
	
	<div class="right"  style="float:left">
		<div class="top_subnav" id='crumbs'></div>
		<IFRAME id="right_main" style="margin:0px;padding:0px;" marginheight="0" name="main" src="<?php echo Yii::app()->createUrl('admin/system/start/');?>" frameBorder=0 width="100%" scrolling="auto"  height="auto" allowtransparency="true"></IFRAME>
	</div>
</div>
<script language="javascript">
if(!Array.prototype.map)
Array.prototype.map = function(fn,scope) {
  var result = [],ri = 0;
  for (var i = 0,n = this.length; i < n; i++){
	if(i in this){
	  result[ri++]  = fn.call(scope ,this[i],i,this);
	}
  }
return result;
};

var getWindowSize = function(){
return ["Height","Width"].map(function(name){
  return window["inner"+name] ||
	document.compatMode === "CSS1Compat" && document.documentElement[ "client" + name ] || document.body[ "client" + name ]
});
}
window.onload = function (){
	if(!+"\v1" && !document.querySelector) { // for IE6 IE7
	  document.body.onresize = resize;
	} else { 
	  window.onresize = resize;
	}
	function resize() {
		wSize();
		return false;
	}

}

function wSize(){
	//这是一字符串	
	var str=getWindowSize();
	var strs= new Array(); //定义一数组
	strs=str.toString().split(","); //字符分割
	var heights = strs[0]-123,Body = $('body');$('#main_content').height(strs[0]);$('#right_main').height(heights);$("#scroll").height(heights-40);
	
	if(strs[1]<980){
		$('#main_content').css('width',980+'px');
		Body.attr('scroll','');
		Body.removeClass('no_scroll');
	}else{
		$('#main_content').css('width','auto');
		Body.attr('scroll','no');
		Body.addClass('no_scroll');
	}
	
	var widths = $('.top').width();
	if($('.left').css('display')=='none')
	{
		var right_body_height = $("#right_main").contents().find(".right_body").css('height');
		right_body_height = right_body_height.replace('px','');
		
		if(parseInt(right_body_height)>heights)
		{
			
			$('.right').width((widths-9)+'px');
		}
		else
		{
			$('.right').width((widths)+'px');
		}
		$('.right').css('margin-left','9px');	
	}
	else
	{
		$('.right').width((widths-205)+'px');
		$('.right').css('margin-left','0px');
		
		
	}	
}
wSize();
function windowW(){
	$(".scroll").show();
}
windowW();
//加载左侧菜单
function loadLeftMenu(resource_id,target_url)
{
	
	$.get("<?php echo Yii::app()->createUrl('admin/default/leftmenu/');?>", {parent_id:resource_id}, function(data){
	     $('#left_main').html(data);
		windowW();
 	}); 
	

	$(".selected").removeClass('selected');
	$("#nav_li_"+resource_id+"").addClass('selected');
	
	
}
loadLeftMenu(1,'<?php echo Yii::app()->createUrl('admin/system/start');?>');
//左侧二级菜单缩放
function switch_show(menu_id,ul_id)
{
	var obj = $("#"+menu_id);
	if(obj.attr('class')=='left_title_up')//收起
	{
		obj.removeClass('left_title_up');
		obj.addClass('left_title');
		$('#'+ul_id).hide();
	}
	else//打开
	{
		obj.removeClass('left_title');
		obj.addClass('left_title_up');
		$('#'+ul_id).show();
	}
	
}
//添加左侧滚动事件监听
(function(){
    var addEvent = (function(){
             if (window.addEventListener) {
                return function(el, sType, fn, capture) {
                    el.addEventListener(sType, fn, (capture));
                };
            } else if (window.attachEvent) {
                return function(el, sType, fn, capture) {
                    el.attachEvent("on" + sType, fn);
                };
            } else {
                return function(){};
            }
        })(),
    Scroll = document.getElementById('scroll');
    // IE6/IE7/IE8/Opera 10+/Safari5+
    addEvent(Scroll, 'mousewheel', function(event){
        event = window.event || event ;  
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);
 
    // Firefox 3.5+
    addEvent(Scroll, 'DOMMouseScroll',  function(event){
        event = window.event || event ;
		if(event.wheelDelta <= 0 || event.detail > 0) {
				Scroll.scrollTop = Scroll.scrollTop + 29;
			} else {
				Scroll.scrollTop = Scroll.scrollTop - 29;
		}
    }, false);
	
})();

function menuScroll(num){
	var Scroll = document.getElementById('scroll');
	if(num==1){
		Scroll.scrollTop = Scroll.scrollTop - 60;
	}else{
		Scroll.scrollTop = Scroll.scrollTop + 60;
	}
}

$(function(){
	$("#side_switch").click(function(){
		$(".left").hide();
		$(".scroll").hide();
		$('#crumbs').removeClass('top_subnav');
		$('#crumbs').addClass('top_subnav_hide');
		$('.top_member').css('text-indent','10px');
		$(this).hide();
		$("#side_switchl").show();
		$("#right_main").contents().find(".right_body").css('margin-right',14);
		
		wSize();
		
	})
})
$(function(){
	$("#side_switchl").click(function(){
		$(".left").show();
		$(".scroll").show();
		$('#crumbs').addClass('top_subnav');
		$('#crumbs').removeClass('top_subnav_hide');
		$('.top_member').css('text-indent','65px');
		$(this).hide();
		$("#side_switch").show();
		$("#right_main").contents().find(".right_body").css('margin-right',5);
		$("#right_main").contents().find(".right_body").css('margin-left',5);
		wSize();
		
	})
})
//锁屏（注销）
function lock_screen() {
	$.get("<?php echo Yii::app()->createUrl('admin/default/lockscreen/');?>");
	$('#dvLockScreen').css('display','');
}
//解除锁屏
function check_screenlock() {
	var lock_password = $('#lock_password').val();
	if(lock_password=='') {
		$('#lock_tips').html('<font color="red"><?php echo Yii::t('admin','password can not be null');?></font>');
		return false;
	}
	$.get("<?php echo Yii::app()->createUrl('admin/default/unlockscreen/');?>", { lock_password: lock_password},function(data){
	
		if(data==1) {
			$('#dvLockScreen').css('display','none');
			$('#lock_password').val('');
			$('#lock_tips').html('<?php echo Yii::t('admin','lock_tips');?>');
		} else if(data==3) {
			$('#lock_tips').html('<font color="red"><?php echo Yii::t('admin','max_wrong_time');?></font>');
		} else {
			strings = data.split('|');
			$('#lock_tips').html('<font color="red"><?php echo Yii::t('admin','wrong password,you have');?>'+strings[1]+'<?php echo Yii::t('admin','times left');?></font>');
		}
	});
}
</script>
</body>
</html>
