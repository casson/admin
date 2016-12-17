$(document).ready(function(){
	$(".gamedoglist").click(function(){
		var typestr = '';
		for (var x=0;x<6;x++){
			if ($("#gamedogtype"+(x+1)).attr("checked")=="checked"){
				if (typestr==''){
					typestr = $("#gamedogtype"+(x+1)).val();
				}else{
					typestr += '-'+$("#gamedogtype"+(x+1)).val();
				}
			}
		}
		var url = $("#gamedogurl").val();
		if (!typestr || !url.match(/^http:\/\/[\w]+\.gamedog\.cn/i)){
			alert('类型和网址都是必填项切网址的格式要正确 如http://qmx5.gamedog.cn/gonglue/!');
		}else{
			window.open('/admin/shouyou/caiji/gamedoglist?page=1&type='+typestr+'&url='+url);
		}
		return false;
	});
	$(".gamedog2list").click(function(){
		var typestr = '';
		for (var x=0;x<6;x++){
			if ($("#gamedog2type"+(x+1)).attr("checked")=="checked"){
				if (typestr==''){
					typestr = $("#gamedog2type"+(x+1)).val();
				}else{
					typestr += '-'+$("#gamedog2type"+(x+1)).val();
				}
			}
		}
		var url = $("#gamedog2url").val();
		if (!typestr || !url.match(/^http:\/\/[\w]+\.gamedog\.cn/i)){
			alert('类型和网址都是必填项切网址的格式要正确 如http://qmx5.gamedog.cn/ziliao/!');
		}else{
			window.open('/admin/shouyou/caiji/gamedogziliao?type='+typestr+'&url='+url);
		}
		return false;
	});
	$(".ptbuslist").click(function(){
		var typestr = '';
		for (var x=0;x<6;x++){
			if ($("#ptbustype"+(x+1)).attr("checked")=="checked"){
				if (typestr==''){
					typestr = $("#ptbustype"+(x+1)).val();
				}else{
					typestr += '-'+$("#ptbustype"+(x+1)).val();
				}
			}
		}
		var url = $("#ptbusurl").val();
		var keyword = $.trim($("#keyword").val());
		if(keyword.length==0){
			alert("新报关键词必须填写！");
			return false;
		}
		if (!typestr || !url.match(/ptbus\.com/i)){
			alert('类型和网址都是必填项切网址的格式要正确 如http://www.ptbus.com/mlbbsyb/guide/!');
		}else{
			window.open('/admin/shouyou/caiji/ptbuslist?type='+typestr+'&url='+url+'&keyword='+encodeURI(keyword));
		}
		return false;
	});
});