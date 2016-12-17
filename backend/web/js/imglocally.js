$(document).ready(function(){
	$('#imglocally').click(function(){
		
		var param = script.init(/imglocally.js/g,'&').param ;
		var api = '/admin/upf/gather/catchimg';
		var aTag=document.getElementsByTagName("*");
				var obj=[];
				for(var i=0;i<aTag.length;i++){
					if(aTag[i].className=="ckeditor"){
						obj.push(aTag[i]);
					}
				}
		var imgid = param.imgid ? param.imgid : 1 ; //水印id；
		var imgstr0 = '<style>#imglist li img{display:block;width:100%;height:100%;}\n'
					+'#imglist li{width:100px;height:80px;float:left;display:block;margin-left:5px;margin-top:5px;border:1px solid #999;}\n'
					+'#status{text-align:center;border-bottom:1px solid #999;}\n'
					+'</style>';
		var editor  = CKEDITOR.instances[obj[0].id];
		var content = editor.getData();
		    imgstr  = imgstr0 + truckimg(content);
			
		var render = function(str,arrx,patten){
			console.log(arrx);
			patten = patten ? patten : /{[\S]+}/g ;
			if(!str) return str ;
			var arrc = str.match(patten); //匹配模型的数组；
			if(!arrc) return str ;
			var src;
			var srcarr = [] ;
			for(var v in arrc){
				src = arrc[v].match(/src=[\"\']([\S]+)[\'\"]/);
				if(arrx[src[1]]) {
					var strsrc = 'src="'+arrx[src[1]]+'"';
					str = str.replace(src[0],strsrc);
				}else{
					str = str.replace(arrc[v],'') ;
				}
			}
			return str ;
		};
		
		var imgarr = [];
		
		var dialog1 = art.dialog({
			title:'采集图片',
			content:"<div style='height:500px;width:240px;overflow: auto;'>"+imgstr+"</div>",
			width:'21%',
			height:"80%",
			drag:true,
			resize:true,
			fixed:true,
			lock:false,
			padding: 0,
	        zIndex:999999,
			top:0,			
			left: '100%',
			init:function(){
				    console.log('ccccc');
				},
			button:[
				{
					name:'采集',
					callback:function(){
						var OBJX = this ;
						var dom = this.content().innerHTML;
						this.content('开始采集…………');
						$.getJSON('/admin/upf/gather/catchimg',{str:dom,imgid:imgid},function(data){
							if(data.status==200){
								imgarr = data.list ;
								//静止重复采集
								//OBJX.config.button[0].disabled = true ;
								console.log(OBJX);
								console.log(OBJX._listeners.采集.elem.disabled=true);
								
								//输出采集结果；
								imgstr = imgstr0 + '<div style="height:500px;width:240px;overflow: auto;"><h3 id="status">采集成功</h3>';
								imgstr = imgstr + '<ul id="imglist" >';
								for(var v in data.img){
									imgstr += data.img[v];
								}
								imgstr += '</ul></div>';
								OBJX.content().innerHTML = imgstr;
								
								//采集结果优化；
								$('#imglist img').click(function(){
									editor.insertHtml(this.outerHTML);
								});
								
							}else if(data.status==300){
								this.content('没有收集到图片');
							}else if(data.status==400){
								this.content('没有收集到数据');
							}
						});
						return false ;
					}
				},
				{
					name:"查找",
					callback:function(){
						var headstr = imgstr0+'<div style="height:500px;width:240px;overflow: auto;"><ul id="imglist" >';
					    createdialog(this,headstr,function(){
							$('#imglist img').click(function(){
								editor.insertHtml(this.outerHTML);
							});
						});
						return false;
					},
				},
				{
					name:"替换",
					disabled:false,
					callback:function(){
						content = render(content,imgarr,/<img.*src=[\"\']([\S]+)[\"\'][^>]+>/g);
						editor.setData(content);
						return false ;	
					},
				},
			],
		});
		
	});
});


function truckimg(str){
	var imgarr = [] ;
	var imgstr = '<ul id="imglist">' ;
	if(str){
		imgarr = str.match(/<img[^>]*(src=[\S]+)[^>]+>/g);
		var dd ;
		for( var v in imgarr){
			dd = imgarr[v].match(/src=(\"|\')([^\"\']+)(\"|\')/g);
			imgarr[v] = dd ;
		}
		if(!imgarr) return "<li>没有数据</li>";
		for(var v in imgarr){
			imgstr += '<li><img '+imgarr[v]+' alt="" /></li>';
		}
	}
	imgstr +='</ul>' ;
	return imgstr ;
}

function createdialog(OBJX,style,fn){
	var apx = '/admin/upf/gather/findimg';
	var obj = OBJX ;
	var Cbox ='<style>#search_line_art_dialog{ height: 25px;line-height: 25px;margin: 0px 0px 0px 0px;padding: 0px 5px;float: left;font-size: 12px;width: 580px;}' 
	+'#contain_box{width:900px;height:40px;}'
	+'#imgul{width:900px;height:500px;overflow:auto;}'
	+'#imgul a{cursor:pointer;}'
	+'#imgul table tr td{border:1px solid #999;height:25px;padding:0;margin:0;text-align:center;line-height:25px;}'
	+'#imgul .ceil0{width:60px;}'
	+'#imgul .ceil1,.ceil2,.ceil3{width:150px;}'
	+'#search_btn{width:40px;}'
	+'</style>'
	+'<div id="contain_box" ><div id="search_line_art_dialog">日期：<select id="date_dialog"><option value="1">今天</option><option value="2">昨天</option><option value="3">前天</option></select></div>';
	
	var content = Cbox+'</div>';
	
	art.dialog({
		title:'查找图片',
		lock:true ,
		width:'80%',
		height:'80%',
		top:'10%',
		left:'10%',
		content:content,
		data:null,
		button:[
			{
				name:'插入',
				callback:function(){
					var objarr = $('#imgul').find('input:checked');
					var imglist = style + '<h3 id="status"> 引入图片成功 </h3>' ;
					for(var i=0; i<objarr.length;i++){
						imglist += '<li><img src="/admin/'+ objarr[i].value +'" /></li>'; 
					}
					imglist += '</ul></div>';
					obj.content().innerHTML = imglist ;
					fn();
					return true ;
				}
			},
			{
				name:'查找',
				callback:function(){
					var date   = $('#date_dialog ').val();
					var imgul  = '<div id="imgul" ><table><tr><td class="ceil0">选项</td><td class="ceil1" >名称</td><td class="ceil2" >类型</td><td class="ceil3">日期</td><td class="ceil3">操作</td></tr>'; 
					var artOBX = this ;
					$.getJSON('/admin/upf/gather/findimg',{date:date},function(data){
						if(data.status==300){
							imgul += '<tr>没有图片</tr>';
						}else if(data.status==200){
							for(var v in data.path){
								imgul += '<tr><td class="ceil0" ><input type="checkbox" value="'+data.path[v]+'" /></td><td class="ceil1" ><a onclick="checkimg(this)" onmouseover ="showimg(\''+data.path[v]+'\',this)" >'+data.path[v].substr(-12)+'</a></td><td>jpg</td><td>'+data.time+'</td><td>入库</td></tr>';
							}
							imgul +='</table></div>';
						}
						artOBX.content().innerHTML += imgul ;
					});
					return false ;
				}
			},
		]
	});
}

function showimg(str,obj){
	var str = str ;
	art.dialog({
		id:str,
		title:'图片',
		content:'<img src="/admin/'+str+'" />',
	});
	obj.onmouseout = function(){
		art.dialog.list[str].close();
	}
}

function checkimg(obj){
	console.log(obj);
}



