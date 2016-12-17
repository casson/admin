(function() {
    CKEDITOR.plugins.add("upload", {
        requires: ["dialog"],
        init: function(a) {
			a.addCommand("upload", new CKEDITOR.dialogCommand("upload"));
            a.ui.addButton("upload", {
                label: "upload",//调用dialog时显示的名称
                command: "upload",
                icon: this.path + "g.ico"//在toolbar中的图标

            });
            CKEDITOR.dialog.add("upload", this.path + "dialogs/upload.js")

        }

    })

})();