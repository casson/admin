function turntopage(id1,id2,link){
	
	var obj1 = document.getElementById(id1);
	var obj2 = document.getElementById(id2);
	obj2.onclick(function(){
		var page = obj1.value;
		console.log(page);
		if(page){
			alert("请输入你要跳转的页面");
		}else if (page.match('/^[0-9]*/')){
			alert("请输入数字");
		}else{
			console.log(page);
		}
			
			
	});
	
}