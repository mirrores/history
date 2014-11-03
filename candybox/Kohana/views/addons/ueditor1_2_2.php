<?php if (strpos($_SERVER["HTTP_USER_AGENT"], "MSIE 20.0")): ?>
    <div style="color:#999;padding:5px 0">您目前正在使用IE6浏览器，为获取更好的体验及功能，建议您升级至<a href="http://www.skycn.com/hao123/30276.html">IE8</a>或<a href="http://www.google.com/chrome/">chrom20</a>等最新浏览器！</div>
    <script type="text/javascript">
        $('#' + '<?= $id ?>').addClass('input_text');
        var ueditor = {};
        ueditor.hasContents = function() {
            return true
        };
        ueditor.setContent = function() {
        };
        ueditor.sync = function() {
        };
    </script>
<?php else: ?>
    <link rel="stylesheet" href="/static/editor/ueditor_1_2_2/themes/default/ueditor.css"/>
    <script type="text/javascript" src="/static/editor/ueditor_1_2_2/editor_config.js?v=1.1"></script>
    <script type="text/javascript" src="/static/editor/ueditor_1_2_2/editor_all.js?usohv=1"></script>
    <script type="text/javascript">
        readyScript.renderUeditor = function() {
            window.ueditor = new baidu.editor.ui.Editor({
                toolbars: [[<?= $attrs['toolbars'] ?>]],
                enterTag: '<?= isset($attrs['enterTag']) ? $attrs['enterTag'] : 'br'; ?>',
                initialStyle: false,
                zIndex:<?= isset($attrs['zIndex']) ? $attrs['zIndex'] : 9; ?>,
                autoFloatEnabled: false,
                minFrameHeight:<?= isset($attrs['minFrameHeight']) ? $attrs['minFrameHeight'] : 300; ?>,
                elementPathEnabled: false,
                autoHeightEnabled:<?= isset($attrs['autoHeightEnabled']) ? $attrs['autoHeightEnabled'] : 'true'; ?>,
                focus:<?= isset($attrs['focus']) ? $attrs['focus'] : 'false'; ?>,
                iframeCssUrl: '/static/editor/ueditor_1_2_2/<?= isset($attrs['iframeCssUrl']) ? $attrs['iframeCssUrl'] : 'themes/default/iframe.css?v=1.5'; ?>',
                initialStyle:<?= isset($attrs['initialStyle']) ? $attrs['initialStyle'] : 'false'; ?>
            });
            ueditor.render("<?= $id ?>");
        };
    </script>
<?php endif; ?>

