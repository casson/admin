$.get("/admin/shouyou/gametmp/companyajax/cid/"+cid,function(result){
	$("#gameEditForm_cid").val(result);
});

$(".octags").click(function(){
	$(".lotsoftags").toggle();
});