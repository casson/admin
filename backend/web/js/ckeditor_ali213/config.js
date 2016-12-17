/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
		 //界面语言
	   config.language = 'zh-cn';
	   
	   // 设置宽高
	   config.width = 850;
		 config.height = 450;	 
		 
		 config.allowedContent=true;  //关闭标签过滤，
		 
		 config.toolbar = [

       ['Source','-','Save','NewPage','Preview','-','Templates'],

       ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],

       ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],

       ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],

       '/',

       ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],

        ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],

        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','PageBreak'],

        ['Link','Unlink','Anchor'],

       ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar'],

       '/',

        ['Styles','Format','Font','FontSize'],

        ['TextColor','BGColor'],
        
        ['Maximize']

    ];
		 
};
