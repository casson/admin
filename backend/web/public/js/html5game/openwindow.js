$(".openwindow").click(function(){
	openWindow("/admin/shouyou/html5game/uploadify?fwj="+Math.random(),500,580)
});

function openWindow(b,a,c){var e=(window.screen.availHeight-30-c)/2;var d=(window.screen.availWidth-10-a)/2;window.open(b,"","height="+c+",,innerHeight="+c+",width="+a+",innerWidth="+a+",top="+e+",left="+d+",toolbar=no,menubar=no,scrollbars=no,resizeable=no,location=no,status=no");return false}