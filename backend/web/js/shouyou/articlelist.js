$.getJSON("/admin/public/js/shouyou/articletypedata.js?r="+Math.random(),function(result){
	for (var x in result) $("#mobile_article_typeid").append("<option value=\""+x+"\">"+result[x]["title"]+"</option>");
});