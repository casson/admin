KindEditor.ready(function(K){
	window.editor = K.create('.content',{
		width:'800px',
		height:'500px',
		uploadJson : '/admin/shouyou/Article/uploader',
		fileManagerJson : '/admin/shouyou/Article/filemanager',
		allowFileManager : true,
		items:['source', '|', 'undo', 'redo', '|', 'preview', 'template', 'cut', 'copy', 'paste',
		        'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
		        'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
		        'superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/',
		        'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
		        'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage',
		        'flash', 'media', 'insertfile', 'table', 'hr', 'emoticons', 'pagebreak',
		        'anchor', 'link', 'unlink']
	});
});