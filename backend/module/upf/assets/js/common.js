 

//弹出缩略图上传页面
function showUploadBlock(result_name,mode,url,form_id,title,cname)
{
    
	    openfun(result_name,mode,url,form_id,title,cname)
	
	
}

function openpic(title,$url,$array)
{
 	var aValue = $array;
 	art.dialog.data('aValue', aValue);// 存储数据


  art.dialog.open($url,{title:title,width: '60%', height: '60%', left: '50%', top: '10%', fixed: true, resize: false, drag: false,lock:true,
  ok: function ()
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
		this.hide();
    }});
	
}


function photo_insert_editors(imgs){
	listr="";

	for(var i=0;i<imgs.length;i++)
	{
		var src = imgs[i].alt;
		src = src.split('*');
		$s = src[0];
		//$html += "<img src=\""+$s+"\">";

		listr += "<li data-imgurl=\""+$s+"\"><a href=\"###\"><img src=\""+$s+"\"></a></li>";
	}
	
    $allstr = "<div class=\"photo_editor\"> <div class=\"photo_editor_list\"><ul>"+listr+"</ul></div></div>";
	//初始化数据
 
	art.dialog({
    width: '21%', height: '100% ', left: '100%', top: '0', 
	fixed: true,
	resize: true,
	drag: true,
	lock:false,
    padding: 0,
	zIndex:999999,
    title: '上传组图',
    content: $allstr,
    okVal:'全部插入',	
	ok: function () {
	  allinsertck();
	  return false;
    }
});
	
	//显示传图侧边框
	$(".photo_editor").css("display","block");
	
	//单个插入
	$(".photo_editor_list ul li").click(function(){
		
		imgurl = $(this).attr("data-imgurl"); 
		
		insertpicck("<p style=\"text-align: center;\"><img style=\"max-width:550px;\"  src=\""+imgurl+"\" /></p>");
		
		//$(this).css("display","none");
			
	});
	
	
 
	 
	
}

function allinsertck()
{
		var count = $(".photo_editor_list ul li").length;
		var arrar = new Array();
        var html_list = "";
		for (i = 0; i < count; i++) 
		{
    	  imgurl = $(".photo_editor_list ul li:eq("+i+")").attr("data-imgurl");
		  
		  html_list = html_list+"<p style=\"text-align: center;\"><img style=\"max-width:550px;\" src=\""+imgurl+"\" /></p>"+((imgurl.indexOf("/patch/")!=-1 || imgurl.indexOf("/down/")!=-1) ? "" : "<p style=\"width:100%;height:28px;\"></p>");
        }
		
		insertpicck(html_list);
} 




function openfun(result_name,mode,url,form_id,title,cname,style)
{
 window.top.art.dialog({id:form_id}).close();
	 window.top.art.dialog.open(url,{id:form_id,title:title,width: '80%', height: '80%', left: '50%', top: '50%', fixed: true, resize: false, drag: false,lock:true,ok: function ()
	
	{	
 
	   
		
		var iframe = this.iframe.contentWindow;
		if (!iframe.document.body) {
			alert('loading...');
			return false;
		};
		
 
		//获取选中的图片对象
		var img = [],
		allElements = iframe.document.getElementsByTagName('img');
		for (var i = 0; i < allElements.length; i++) {
			if (allElements[i].className == 'selected_img') {
				img[img.length] = allElements[i];
			}
		}
		//获取选中选中对象
		var input = [],
		allElements = iframe.document.getElementsByTagName('input');
		for (var i = 0; i < allElements.length; i++) {
			if (allElements[i].className == 'selected') {
				input[input.length] = allElements[i];
			}
		}
		
	 
		//单模式
		if(mode==1 || mode==4)
		{
			var html='';
			var $s = "";
			var j=$('.pic_unit').length;
			$id = $("."+cname).attr("id");
			for(var i=0;i<img.length;i++)
			{
				var src = img[i].alt;
				src = src.split('*');
				$s = src[0];
			}
			if($s==""){
				for(var i=0;i<input.length;i++)
				{
					var src = input[i].alt;
					src = src.split('*');
					$s = src[0];
				}
			}
			
			$("#"+$id).val($s);
			
			this.hide();
			ShowImage();
			
		}else if(mode==2){
			/*
			 $html  = "";
			for(var i=0;i<img.length;i++)
			{
				var src = img[i].alt;
				src = src.split('*');
				$s = src[0];
				
				$html += "<img src=\""+$s+"\">";
			}
		  */
			if(img==""){
				 img = input;
			}
			
			 /*入图库模式*/
	    if(style>0)
		{ 
			 
		  openpic("添加到图库","/admin/pic/pic/add2",img);
		  //显示右边插图框
		  photo_insert_editors(img);
          
		  return false;
		}else{
		  //显示右边插图框
		  photo_insert_editors(img);	
			
		}
			
		//	callbacks(img);
			this.hide();
		    
			
		}else if(mode==3){
		 if(img==""){
				 img = input;
		 }
		 callbacks(img);
		 this.hide();
		} 
		else
		{
		 
			alert('未定义模式');
		}
		
		return false;
		
	},cancel: true,
	close: function () {
		this.hide();
    }});
}

//插入到编辑器
function insertpicck(content) {

	 var aTag=document.getElementsByTagName("*");
	var obj=[];

	for(var i=0;i<aTag.length;i++){
           if(aTag[i].className=="ckeditor"){
           	     obj.push(aTag[i]);
           }
	}
	var editor = CKEDITOR.instances[obj[0].id];
 
		editor.insertHtml(content);
}


//取消选择的缩略图
function cancelThumbOrignal(result_name)
{
	$('.thumb_img').attr('src','');
	$('.thumb_img').hide();
	$('.add_thumb_trigger').show();
	$('#'+result_name).val('');
	
}
//内容页裁切缩略图
function showCutFileToThumbBlock(result_name,url,form_id,title)
{
	
	var thumb_url=encodeURIComponent($('#'+result_name).val());
	if(thumb_url=='')
	{
		alert('请选择图片');	
		return;
	}
	
	url = url+"&thumb_url="+thumb_url;
	
	window.top.art.dialog({id:form_id}).close();
	window.top.art.dialog.open(url,{id:form_id,title:title,lock:true,ok: function ()
	{	
		var iframe = this.iframe.contentWindow;
		if (!iframe.document.body) {
			alert('loading...');
			return false;
		};
		//处理上传的图片
		var img  = iframe.document.getElementById('original_img_path');
		if(img.value!='')
		{
			$('.thumb_img').attr('src',img.value);
			$('.thumb_img').show();
			$('.add_thumb_trigger').hide();
			$('#'+result_name).val(img.value);
		}
		this.hide();
		return false;
		
	},cancel: true,
	close: function () {
		this.hide();
    }});
	
}
//操作提示信息
function showFlashInfo(info)
{
	document.write('<div class=\"flash-success\">');
	document.write(info);
	document.write('</div>');
	setTimeout("$('.flash-success').fadeOut()", 1500 );
}

var ShowImage = function() {
            xOffset = 10;
            yOffset = 30;
            jQuery("#imglist").find("img").hover(function(e) {
                jQuery("<img id='imgshow' src='" + this.src + "' />").appendTo("body");
                jQuery("#imgshow")
                    .css("top", (e.pageY - xOffset) + "px")
                 .css("left", (e.pageX + yOffset) + "px")
           .fadeIn("fast");
            }, function() {
                jQuery("#imgshow").remove();
            });

            jQuery("#imglist").find("img").mousemove(function(e) {
                jQuery("#imgshow")
                   .css("top", (e.pageY - xOffset) + "px")
             .css("left", (e.pageX + yOffset) + "px")
            });
        };
		
		
	jQuery(document).ready(function() {
            ShowImage();
        });	