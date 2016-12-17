$("#ajax_form").submit(function(){
	if (!$("#articletypeAddForm_title").val()){
		alert("类型名必须填写");
		return false;
	}
});