function showFlashInfo(info,result)
{  
	document.write('<div class=\"flash-'+result+'\">');
	document.write(info);
	document.write('</div>');
	var width = $('.body').width();
	var position = $('.body').position();
	$(".flash-"+result+"").width(width+'px');
	$(".flash-"+result+"").css({left:position.left+'px'});
	setTimeout("$('.flash-"+result+"').fadeOut(clearDialog())", 2000 );
	
	
}
function clearDialog()
{
	var list = window.top.art.dialog.list;
	for (var i in list) {
		list[i].close();
	}
			
}
//弹出自适应尺寸框
function pop_original(title,url,form_id) {
		window.top.art.dialog({id:form_id}).close();
		window.top.art.dialog.open(url,{id:form_id,title:title,lock:true,ok: function ()
		{	
			var iframe = this.iframe.contentWindow;
			if (!iframe.document.body) {
				alert('iframe is being loaded');
				return false;
			};
			var form_btn= iframe.document.getElementById('hidden_submit');
			form_btn.click();
			return false;
			
    	},cancel: true,
		close: function () {
		parent.frames['main'].location = parent.frames['main'].location;//刷新页面
        this.hide();
    }});
}
//弹出全屏框
function pop_full(title,url,form_id) {
		window.top.art.dialog({id:form_id}).close();
		window.top.art.dialog.open(url,{id:form_id,title:title,width: '100%', height: '100%', left: '0%', top: '0%', fixed: true, resize: false, drag: false,lock:true,ok: function ()
		{	
			var iframe = this.iframe.contentWindow;
			if (!iframe.document.body) {
				alert('iframe is being loaded');
				return false;
			};
			var form_btn= iframe.document.getElementById('hidden_submit');
			form_btn.click();
			return false;
			
    	},cancel: true,
		close: function () {
		var iframe_name = $('#right_main',parent.document).attr('name');
	
		parent.frames[iframe_name].location = parent.frames[iframe_name].location;//刷新页面
        this.hide();
    }});
}
//弹出自适应尺寸框-无按钮
function pop_original_no_btn(title,url,form_id) {
		window.top.art.dialog({id:form_id}).close();
		window.top.art.dialog.open(url,{id:form_id,title:title,lock:true});
}
//弹出全屏框-无按钮
function pop_full_no_btn(title,url,form_id) {
		window.top.art.dialog({id:form_id}).close();
		window.top.art.dialog.open(url,{id:form_id,title:title,width: '100%', height: '100%', left: '0%', top: '0%', fixed: true, resize: false, drag: false,lock:true});
}
//操作链接绑定事件
$(document).ready(function(){
	//添加内容时弹出框
	$(".pop_original").click(function(){
		
		pop_original($(this).html(),this.href,'pop_form');
		return false;
	});
	$(".pop_full").click(function(){
		pop_full($(this).html(),this.href,'pop_form');
		return false;
	});
	$(".pop_original_no_btn").click(function(){
		pop_original_no_btn($(this).html(),this.href,'pop_form');
		return false;
	});
	$(".pop_full_no_btn").click(function(){
		pop_full_no_btn($(this).html(),this.href,'pop_form');
		return false;
	});
	//单条记录删除
	$(".action_delete").click(function(){
		return confirm("确定删除吗?");
	});
	//列表页底部按钮
	$('.btn_batch').click(function(){	
			initCheckBoxList();
			$('#list_form').attr('action',this.href);
			$('#list_form').submit();
			return false;

	});
	//列表页底部按钮
	$('.btn_delete').click(function(){
		if(confirm("确定删除吗?")){
			initCheckBoxList();
			$('#list_form').attr('action',this.href);
			$('#list_form').submit();
			return false;
		}
		else
		{
			return false;	
		}
	});
	$('.btn_sort').click(function(){	
		initCheckBoxList();
		$('#list_form').attr('action',this.href);
	    $('#list_form').submit();
		return false;
	});
	
	//列表搜索框显示OR隐藏
	if($('.list_search_form').css('display')=='none'){
		
	
		$(".search_trigger").toggle(
		  function () {		
			$.get("/admin/backend/web/ajax/searchform", {search_form_show:1}, function(data){
			    if(data==1)
			    {
			    	$('.list_search_form').show();
			    }
		 	}); 
		  },
		  function () {
				
				$.get("/admin/backend/web/ajax/searchform", {search_form_show:0}, function(data){
				    if(data==1)
				    {
				    	$('.list_search_form').hide();
				    }
			 	}); 
			  }
		); 
	}
	else
	{

		$(".search_trigger").toggle(
		  
		  function () {
				
				$.get("/admin/backend/web/ajax/searchform", {search_form_show:0}, function(data){
				    if(data==1)
				    {
				    	$('.list_search_form').hide();
				    }
			 	}); 
			  },
		  function () {		
				$.get("/admin/backend/web/ajax/searchform", {search_form_show:1}, function(data){
			    if(data==1)
			    {
			    	$('.list_search_form').show();
			    }
		 	}); 
		  }
		); 
	}
	//全选or 取消全选
	$('.list_check_btn').click(function(){
		var id_list = new Array();								
		if(this.checked==true)
		{
			
			$(".list_check").each(function(){
												this.checked=true;	
												id_list[id_list.length] = this.value;	
											}
									);
			
			id_list = id_list.join(",");
			$('#id_list').val(id_list);
		}
		else
		{
			$(".list_check").each(function(){
													this.checked=false;	
											}
										);
			$('#id_list').val('');
			
			
		}
	});
	
	parent.frames['main'].onload=function()
	{
		parent.wSize();	
		if($('.left',parent.document).css('display')=='none'){
	
			$(".right_body").css('margin-right',14);
		}
		else
		{
			$(".right_body").css('margin-right',5);
			$(".right_body").css('margin-right',5);
		}
	}

})
//编辑函数
function edit(url,class_name,title)
{
	
	if(class_name=='pop_full')
	{
		pop_full(title,url,'pop_form');
	}
	else if(class_name=='pop_original')
	{
		pop_original(title,url,'pop_form');
	}
	else if(class_name=='pop_full_no_btn')
	{
		pop_full_no_btn(title,url,'pop_form');
	}
	else if(class_name=='pop_original_no_btn')
	{
		
		pop_original_no_btn(title,url,'pop_form');
	}
	else
	{
		return true;	
	}
}
//初始化列表页选中的值

function initCheckBoxList()
{
	var id_list = new Array();	
	$(".list_check").each(function(){
		if(this.checked==true)
		{
			id_list[id_list.length] = this.value;
		}
	});	
	
	id_list = id_list.join(",");
	
	$('#id_list').val(id_list);
}