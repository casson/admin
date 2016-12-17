$.get("/admin/shouyou/gametmp/companyajax/cid/"+cid,function(result){
	$("#gametmpEditForm_cid").val(result);
});

$(".octags").click(function(){
	$(".lotsoftags").toggle();
});