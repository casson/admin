if (parseInt($("#normaltypeEditForm_typeid").val())){
	$(".pnum").show();
}else{
	$(".pnum").hide();
}

$("#normaltypeEditForm_typeid").change(function(){
	if (parseInt($(this).val())){
		$(".pnum").show();
	}else{
		$(".pnum").hide();
	}
});

$("#ajax_form").submit(function(){
	if (!$("#normaltypeEditForm_title").val()){
		alert("推荐的名称必须填写");
		return false;
	}
});