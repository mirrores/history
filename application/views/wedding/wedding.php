<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title><?= isset($_title) ? $_title . '- ' : '' ?><?= @$_SETTING['site_name'] ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="keywords" content="浙江大学校友集体婚礼" />
        <script type="text/javascript" src="/static/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/static/js/jquery.form.js"></script>
        <script type="text/javascript" src="/static/artDialog4.1.5/jquery.artDialog.source.js?skin=default"></script>
        <script type="text/javascript" src="/static/js/jquery.scrollTo.js"></script>
        <script type="text/javascript" src="/static/js/global.js?v=20140107"></script>
        <script type="text/javascript" src="/static/js/wedding.js"></script>
        <!--[if lte IE 7]>
        <script type="text/javascript">
        alert("您现在使用的浏览器版本过低，可能会导致部分图片显示和信息的缺失。建议您升级至最新IE8或chrome22或其他浏览器，谢谢！")
        </script>
        <![endif]-->
        <script type="text/javascript" src="/static/js/jquery-ui-1.9.1.custom.min.js"></script>
        <script type="text/javascript" src="/static/js/wish.js" type="text/javascript"></script>
        <script src="/static/js/jQueryRotate.2.2.js"></script>
        <script src="/static/js/jquery.easing.min.js"></script>
        
        <link rel="stylesheet" href="/static/css/wedding2014.css" />
        <link rel="stylesheet" href="/static/css/font-awesome-4.0.3/css/font-awesome.min.css">
         <link rel="stylesheet" href="/static/css/btn.css" />
    </head>
    <body id="htmlbody">
        <div id="append_parent"></div>
        <div class="top1" ></div>
        <div class="top2"></div>
        <div class="top3"></div>
        <div class="top4"></div>
        <?= @$_notice ?>

        <div id="main_w1000">
            <?= @$_body ?>
        </div>

        <div id="footer">
            <a class="item" href="/" target="_blank">校友网首页</a>
            <a class="item" href="#" target="_blank">意见反馈</a>
            <a class="item" href="#" target="_blank">常见问题</a>
            <a class="item" href="#" target="_blank">侵权举报</a>
            <p>浙江大学校友总会版权所有©2013-2014</p>
        </div>
        <!--[if lte IE 7]>
        <script type="text/javascript">
        correctPNG();
        </script>
        <![endif]-->
    </body>
</html>