$.getJSON("/admin/public/js/shouyou/normaltypedata.js?r="+Math.random(),function(result){
	normaltype = result;
	for (var x in normaltype) $("#normalpromotionEditForm_typeid").append("<option value=\""+x+"\""+(typeid==x ? "selected=\"selected\"" : "")+">"+normaltype[x]['title']+"</option>");
	switch (normaltype[parseInt($("#normalpromotionEditForm_typeid").val())]['pnum']){
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
		break;
	}
});

$("#normalpromotionEditForm_typeid").change(function(){
	switch (normaltype[parseInt($("#normalpromotionEditForm_typeid").val())]['pnum']){
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
		break;
	}
});

