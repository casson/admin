$("#ajax_form").submit(function(){
	if (!$("#quicktypeAddForm_title").val()){
		alert("一键推荐名称必须填写");
		return false;
	}
});