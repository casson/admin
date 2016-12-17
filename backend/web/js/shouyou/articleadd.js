$.getJSON("/admin/public/js/shouyou/articletypedata.js?r="+Math.random(),function(result){
	articletype = result;
	//for (var x in result) $("#articleAddForm_typeid").append("<option value=\""+x+"\">"+result[x]["title"]+"</option>");
});
$("#articleAddForm_typeid").change(function(){
	if (articletype[$('input:checked').val()]["relative"]=="0"){
		$(".gid").hide();
	}else{
		$(".gid").show();
	}
});
$("#ajax_form").submit(function(){
	if (!$('input:checked').val()){
		alert('必须选择类型');
		return false;
	}
	if (!$("#articleAddForm_title").val()){
		alert("名称标题必须填写");
		return false;
	}
	if (!$("#articleAddForm_content").val()){
		alert("必须填写内容");
		return false;
	}
});
$("#articleAddForm_keyword").autocomplete({
	source: "/admin/shouyou/game/autocomplete"
});