(function() {
    CKEDITOR.plugins.add("upload", {
        requires: ["dialog"],
        init: function(a) {
			a.addCommand("upload", new CKEDITOR.dialogCommand("upload"));
            a.ui.addButton("upload", {
                label: "upload",//����dialogʱ��ʾ������
                command: "upload",
                icon: this.path + "g.ico"//��toolbar�е�ͼ��

            });
            CKEDITOR.dialog.add("upload", this.path + "dialogs/upload.js")

        }

    })

})();