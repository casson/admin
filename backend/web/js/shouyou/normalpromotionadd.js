$.getJSON("/admin/public/js/shouyou/normaltypedata.js?r="+Math.random(),function(result){
	normaltype = result;
	for (var x in normaltype) $("#normalpromotionAddForm_typeid").append("<option value=\""+x+"\">"+normaltype[x]['title']+"</option>");
	switch (normaltype[parseInt($("#normalpromotionAddForm_typeid").val())]['pnum']){
	case "0":
		$(".smpic").hide();
		$(".bigpic").hide();
		break;
	case "1":
		$(".smpic").hide();
		$(".bigpic").show();
		break;
	case "2":
		$(".smpic").show();
		$(".bigpic").show();
	}
});

$("#normalpromotionAddForm_typeid").change(function(){
	switch (normaltype[parseInt($("#normalpromotionAddForm_typeid").val())]['pnum']){
	case "0":
		$(".smpic").hide();
		$(".bigpic").hide();
		break;
	case "1":
		$(".smpic").hide();
		$(".bigpic").show();
		break;
	case "2":
		$(".smpic").show();
		$(".bigpic").show();
	}
});

$("#ajax_form").submit(function(){
	
	switch (normaltype[parseInt($("#normalpromotionAddForm_typeid").val())]['pnum']){
	case "0":
		break;
	case "1":
		if (!$("#bigpic").val()){
			alert("图片必须填写");
			return false;
		}
		break;
	case "2":
		if (!$("#bigpic").val() || !$("#smpic").val()){
			alert("必须填写两个图片");
			return false;
		}
		break;
	}
});