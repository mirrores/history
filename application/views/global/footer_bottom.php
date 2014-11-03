<!-- global/footer_bottom:_footer_bottom -->
<!--footer-->
<div class="links">
    <a href="<?= URL::site('aa') ?>">关于我们</a><a href="<?= URL::site('help/file') ?>">档案查询</a><a href="http://zuaa.zju.edu.cn/mobile<?=isset($_AA)?'?aid='.$_AA['id']:null;?>">3G版</a> <a href="<?= URL::site('bbs/list?f=0&b=68') ?>">意见建议</a><a href="#">  隐私声明</a><a href="#">版权申明</a></div>
联系信箱： 地址：邮编：<br>
浙江大学校友总会版权所有 All rights reserved by Zhejiang University Alumni Association 浙ICP备10048528号 <br>
为了您的安全及获得最佳浏览体验，建议您使用IE8、Firefox4、Chrom20或更高浏览器&nbsp;&nbsp;技术支持：<a href="mailto:majun@zjuhz.com" >友笑网络</a>
<!--//footer-->
<!--返回到顶部 -->
<a id="go2top" class="go2top" href="#header" style="display: none; "><span class="go2top-inner"></span></a>
<script type="text/javascript">
    $(document).ready(function() {
        readyScript.footer = getToTop;
<?php if ($_UID): ?>readyScript.msg = function(){setTimeout(function() {check_pm_notice();}, 3000);};<?php endif;?>
<?php if ($_SESS->get('prompt')): ?>showPrompt('<?= $_SESS->get('prompt') ?>', 2000); <?= $_SESS->delete('prompt') ?><?php endif; ?>
<?php if ($_SESS->get('checkJoinEvent')): ?>setTimeout(function() { checkjoinevent(); }, 4000);<?= $_SESS->delete('checkJoinEvent') ?><?php endif; ?>
runReadyScript();
    });
</script>