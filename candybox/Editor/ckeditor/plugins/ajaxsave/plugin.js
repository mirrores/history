(function()
{
  var ajaxSaveCmd =
  {
    modes : { wysiwyg:1, source:1 },
    exec : function( editor )
    {
      var $form = editor.element.$.form;
      if ( $form )
      {
          try
          {
            editor.updateElement();
            $form.onsubmit();
            return false;
            
          } catch ( e ) {
            alert(e);
          }
      }
    }
  }

  var pluginName = 'ajaxsave';
  CKEDITOR.plugins.add( pluginName,
  {
     init : function( editor )
     {
        var command = editor.addCommand( pluginName, ajaxSaveCmd );
        command.modes = { wysiwyg : !!( editor.element.$.form ) };
        editor.ui.addButton( 'AjaxSave',
         {
            label : editor.lang.save,
            command : pluginName
         });
     }
   });
})();