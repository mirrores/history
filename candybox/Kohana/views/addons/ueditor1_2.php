<script type="text/javascript" src="/static/editor/ueditor_1_2/editor_config.js?v=1.1"></script>
<script type="text/javascript" src="/static/editor/ueditor_1_2/editor_all.js"></script>
<link rel="stylesheet" href="/static/editor/ueditor_1_2/themes/default/ueditor.css"/>
<script type="text/javascript">
   var ueditor = new baidu.editor.ui.Editor({
           toolbars: [[<?=$attrs['toolbars']?>]],
           enterTag:'<?=isset($attrs['enterTag'])?$attrs['enterTag']:'br';?>',
           initialStyle:false,
           zIndex :<?=isset($attrs['zIndex'])?$attrs['zIndex']:9;?>,
           autoFloatEnabled:false,
           minFrameHeight:<?=isset($attrs['minFrameHeight'])?$attrs['minFrameHeight']:300;?>,
           elementPathEnabled:<?=isset($attrs['elementPathEnabled'])?$attrs['elementPathEnabled']:'true';?>,
           autoHeightEnabled:<?=isset($attrs['autoHeightEnabled'])?$attrs['autoHeightEnabled']:'true';?>,
           focus:<?=isset($attrs['focus'])?$attrs['focus']:'false';?>,
           iframeCssUrl:'<?=isset($attrs['iframeCssUrl'])?$attrs['iframeCssUrl']:'themes/default/iframe.css?v=1.5';?>'
   });
    ueditor.render("<?=$id?>");
</script>