$("#gameRubaoForm_androidid").blur(function(){
	if ($("#gameRubaoForm_iosid").val()>0){
		$("#gameRubaoForm_install").val("1.iPhone、iPad游戏安装步骤如下<br />2.高速免费下载：访问 <a href=\"http://m.ali213.net/game/0-0-0-0-0-1.html\" target=\"_blank\">http://m.ali213.net/game/0-0-0-0-0-1.html</a>网站，点击『越狱版下载』或者『官方版下载』，下载包为.ipa安装文件；<br />3.应用安装：检查您的设备是否进行越狱（手机桌面有cydia图标表示已越狱），下载后双击即可安装应用；<br />4.如果没有越狱可以，进入http://m.ali213.net/jailbreak/查看越狱教程");
		return;
	}
	if ($(this).val()>0){
		$("#gameRubaoForm_install").val("1.请先访问：<a href=\"http://m.ali213.net/androidgame/0-0-0-0-1.html\" target=\"_blank\">http://m.ali213.net/androidgame/0-0-0-0-1.html</a>下载安卓游戏<br />2.首先保证你的安卓手机已经ROOT<br />3.安卓游戏，分为三大类，一类是apk的游戏，一类是主程序有apk且带有数据包的游戏，还有一类是对于钛备份的游戏<br />4.一般说来，只有apk的程序容量都小于30M（比如愤怒的小鸟，水果忍者，武士复仇等），带有数据包的游戏一般都很大，甚至超过1G（比如：都市赛车、暗影之枪、兄弟连2等），钛备份游戏你需要有钛备分的数据压缩包与主程序apk，大家安装游戏时，请看清自己下的是什么类型的游戏<br />5.APK类型的游戏一般下载好后直接复制到手机里面即可安装，容量比较大的游戏一般含有数据包需要专用工具来安装，请使用掌上游侠提供的工具进行安装即可。");
	}
});
$("#gameRubaoForm_iosid").blur(function(){
	if ($(this).val()>0){
		$("#gameRubaoForm_install").val("1.iPhone、iPad游戏安装步骤如下<br />2.高速免费下载：访问 <a href=\"http://m.ali213.net/game/0-0-0-0-0-1.html\" target=\"_blank\">http://m.ali213.net/game/0-0-0-0-0-1.html</a>网站，点击『越狱版下载』或者『官方版下载』，下载包为.ipa安装文件；<br />3.应用安装：检查您的设备是否进行越狱（手机桌面有cydia图标表示已越狱），下载后双击即可安装应用；<br />4.如果没有越狱可以，进入http://m.ali213.net/jailbreak/查看越狱教程");
		return;
	}
	if ($("#gameRubaoForm_androidid").val()>0){
		$("#gameRubaoForm_install").val("1.请先访问：<a href=\"http://m.ali213.net/androidgame/0-0-0-0-1.html\" target=\"_blank\">http://m.ali213.net/androidgame/0-0-0-0-1.html</a>下载安卓游戏<br />2.首先保证你的安卓手机已经ROOT<br />3.安卓游戏，分为三大类，一类是apk的游戏，一类是主程序有apk且带有数据包的游戏，还有一类是对于钛备份的游戏<br />4.一般说来，只有apk的程序容量都小于30M（比如愤怒的小鸟，水果忍者，武士复仇等），带有数据包的游戏一般都很大，甚至超过1G（比如：都市赛车、暗影之枪、兄弟连2等），钛备份游戏你需要有钛备分的数据压缩包与主程序apk，大家安装游戏时，请看清自己下的是什么类型的游戏<br />5.APK类型的游戏一般下载好后直接复制到手机里面即可安装，容量比较大的游戏一般含有数据包需要专用工具来安装，请使用掌上游侠提供的工具进行安装即可。");
	}
});

$("#ajax_form").submit(function(){
	var checkdata = true;
	var path = $("#gameRubaoForm_path").val();
	if (!path){
		alert("路径名为必填项");
		checkdata = false;
	}
	if (!path.match(/^[0-9a-zA-Z]+[0-9a-zA-Z-]*[0-9a-zA-Z]+$/)){
		alert("路径名不正确，只允许数字和字母组合，以及-，-不能出现在首尾");
		checkdata = false;
	}
	$.ajax({url:"/admin/shouyou/Oday/checkpath/str/"+path,async:false,dataType:"text",success:function(result){
		if (result != 0){
			alert("路径名重复");
			checkdata = false;
		}else{
			checkdata = true;
		}
	}});
	return checkdata;
});

$.getJSON("/admin/shouyou/game/odayajax/id/"+ajaxid,function(result){
	switch (parseInt(result[1]))
	{
		case 1:
			$("#gameRubaoForm_iosid").val(result[0]);
			break;
		case 3:
			$("#gameRubaoForm_androidid").val(result[0]);
			break;
		case 5:
			$("#gameRubaoForm_wp7id").val(result[0]);
			break;
	}
	var ids=[$("#gameRubaoForm_iosid").val(),$("#gameRubaoForm_androidid").val(),$("#gameRubaoForm_wp7id").val()];
	infofill(ids,result);
});

function infofill(arr1,arr2){ //arr1(0,180,256) arr2 json数据
	for (var x in arr1){
		if (arr1[x]==""){
			continue;
		}else if(parseInt(arr1[x])==parseInt(arr2[0])){
			$("#gameRubaoForm_typeid_"+(arr2[3]-1)).attr("checked",true);
			$("#gameRubaoForm_title").val(arr2[2]); //名称
			$("#gameRubaoForm_comp").val(arr2[4]); //兼容性
			$("#gameRubaoForm_language").val(arr2[5]); //语言
			$("#gameRubaoForm_size").val(arr2[6]); //大小
			$("#gameRubaoForm_price").val(arr2[7]); //价格
			$("#gameRubaoForm_good").val(arr2[8]); //好玩
			$("#gameRubaoForm_bad").val(arr2[9]); //不好玩
			$("#gameRubaoForm_download").val(arr2[10]); //下载量
			$("#gameRubaoForm_pingfen").val(arr2[11]); //评分
			return;
		}else{
			return;
		}
	}
	
}