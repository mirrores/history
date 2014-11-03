<?php $themeType=isset($attrs['themeType'])?$attrs['themeType']:"default"; ?>
<script charset="utf-8" src="/kindeditor/kindeditor.js"></script>
<script charset="utf-8" src="/kindeditor/lang/zh_CN.js"></script>
<link rel="stylesheet" href="/kindeditor/themes/<?=$themeType?>/<?=$themeType?>.css" />

<script>
        var editor;
        KindEditor.ready(function(K) {
                editor = K.create('#<?= $id ?>', {
                        resizeType :1,
                        width: '<?=isset($attrs['width'])?$attrs['width']:"98%"?>',
                        height: '<?=isset($attrs['height'])?$attrs['height']:"150px"?>',
                        allowPreviewEmoticons : false,
                        allowImageUpload : true,
                        items :<?=$attrs['items']?>,
                        themeType: '<?=$themeType?>',
                        cssPath:'/static/css/keditor.css',
                        newlineTag :'<?=isset($attrs['newlineTag'])?$attrs['newlineTag']:"p"?>',
                        uploadJson : '/kindeditor/upload_json.php' // 相对于当前页面的路径
                });
        });
</script>