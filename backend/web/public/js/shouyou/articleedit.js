$.getJSON("/admin/public/js/shouyou/articletypedata.js?r="+Math.random(),function(result){
	articletype = result;
	if (articletype[$('input:checked').val()]["relative"]=="0"){
		$(".gid").hide();
	}else{
		$(".gid").show();
	}
});
$("#articleEditForm_typeid").change(function(){
	if (articletype[$('input:checked').val()]["relative"]=="0"){
		$(".gid").hide();
	}else{
		$(".gid").show();
	}
});
$("#ajax_form").submit(function(){
	if (!$("#articleEditForm_title").val()){
		alert("名称标题必须填写");
		return false;
	}
	if (!$("#articleEditForm_content").val()){
		alert("必须填写内容");
		return false;
	}
});