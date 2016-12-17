if (parseInt($("#normaltypeAddForm_typeid").val())){
	$(".pnum").show();
}else{
	$(".pnum").hide();
}

$("#normaltypeAddForm_typeid").change(function(){
	if (parseInt($(this).val())){
		$(".pnum").show();
	}else{
		$(".pnum").hide();
	}
});

$("#ajax_form").submit(function(){
	if (!$("#normaltypeAddForm_title").val()){
		alert("推荐的名称必须填写");
		return false;
	}
});