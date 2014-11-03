/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
    // Define changes to default configuration here. For example:
    config.enterMode = CKEDITOR.ENTER_DIV;
    config.language = 'zh-cn';
    config.uiColor = '#eee';
    config.font_names = '楷体; 宋体; 黑体; 雅黑; Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif';
    config.smiley_images = ['1.gif','2.gif','3.gif','4.gif','5.gif','6.gif','7.gif','8.gif','9.gif','10.gif','11.gif','12.gif','13.gif','14.gif','15.gif','16.gif','17.gif','18.gif','19.gif','20.gif','21.gif','22.gif','23.gif','24.gif','25.gif','26.gif','27.gif','28.gif','29.gif','30.gif','31.gif','32.gif','33.gif','34.gif','35.gif','36.gif','37.gif','38.gif','39.gif','40.gif','41.gif','42.gif','43.gif','44.gif','45.gif','46.gif','47.gif','48.gif','49.gif','50.gif','51.gif','52.gif','53.gif','54.gif','55.gif','56.gif','57.gif','58.gif','59.gif','60.gif','61.gif','62.gif','63.gif','64.gif'];
    config.toolbar_Base = [['Bold','Italic','Underline','Outdent','Indent','-','Link','Unlink','Image','Smiley','RemoveFormat']];
    config.toolbar_Pro = [['Maximize','Font','FontSize','TextColor','BGColor','Bold','Italic','Underline','NumberedList','BulletedList','-','Link','Unlink','Image','Smiley','Flash','RemoveFormat'],['PasteText','PasteFromWord','-','Outdent','Indent','Blockquote','-','JustifyLeft','JustifyCenter'],['Source']]
};
