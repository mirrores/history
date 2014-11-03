<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="stylesheet" href="/static/css/global.css?v=20131011" type="text/css"  />
        <link rel="stylesheet" href="/static/css/home.css" type="text/css"  />
        <script type="text/javascript" src="/static/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/static/js/jquery.form.js"></script>
        <script type="text/javascript" src="/static/artDialog4.1.5/jquery.artDialog.source.js?skin=default"></script>
        <script type="text/javascript" src="/static/js/tips.js"></script>
        <script type="text/javascript" src="/static/js/global.js?v=20140107"></script>
        <script type="text/javascript" src="/static/js/home.js?v=20130712"></script>
        <script type="text/javascript" src="/static/js/swfobject_source.js"></script>
        <?= @$_static_media ?><?= @$_custom_media ?>
     
    </head>
    <body id="htmlbody">
        <div id="append_parent"></div>
        <div class="container">
            <div id="header">
                <?= @$_header_top ?>
                <div class="clear"></div>
            </div>
            <div id="body">
                <?= @$_body ?>
                <div class="clear"></div>
            </div>
            <div id="footer">
                <?= @$_footer_bottom ?>
                <div class="clear"></div>
            </div>
            <?php if (isset($_debug)): ?>
                <div id="debug" class="candy-debug">
                    <?= $_debug ?>
                </div>
            <?php endif; ?>
        </div>
        
   </body>
</html>