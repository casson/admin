$("#ajax_form").submit(function(){
	if (!$("#articletypeEditForm_title").val()){
		alert("类型名必须填写");
		return false;
	}
});