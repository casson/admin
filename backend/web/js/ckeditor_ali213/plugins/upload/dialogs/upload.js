(function() {
    CKEDITOR.dialog.add("upload", 
    function(a) {
        return {
            title: "upload",
            minWidth: "500px",
            minHeight:"500px",
            contents: [{
                id: "tab1",
                label: "",
                title: "",
                expand: true,
                width: "500px",
                height: "500px",
                padding: 0,
                elements: [{
                    type: "html",
                    style: "width:500px;height:500px",
                    html: '���ݲ���'
                }]
            }],
            onOk: function() {
			alert("d");
                //���ȷ����ť��Ĳ���
                //a.insertHtml("�༭��׷������");
            }
        }
    })
})();