$('.bt_act').find('a[href="/admin/news/news/pdelete"]').bind('click',function(){
	var arrx = '';
	var i = 0 ;
	$(document).find('input[class="list_check"]').map(function(){
		if($(this).is(':checked')){
		    arrx = arrx + "list"+i+":"+$(this).val()+",";
			i++;
		}
	});
	$.get('/admin/news/news/pdelete',{'data':arrx},function(data){
        alert(data);
		window.location = "/admin/news/news/list" ;
	});
	return false ;
});