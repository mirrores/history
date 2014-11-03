<div id="top" class="w955">
    <div style="height:72px">
	<p style="float:left;width:650px;margin: 0"><a href="/main/index3" title="回首页"><img src="/static/v3/images/logo.jpg"></a></p>
	<p style="float:right;width:240px;margin: 0;padding-top: 16px"><img src="/static/v3/images/top_search.jpg"></p>
    </div>
    <div style="height:50px">
	<div style="float:left; line-height: 50px; color: #CDDFF1; padding: 0px 20px;width:200px;">今天是 <?=date('Y')?>年<?=date('m') ?>月<?=date('d') ?>日 <?php $weekarray=array("日","一","二","三","四","五","六"); echo "星期".$weekarray[date("w")]; ?></div>
	<div style="float:right; width:515px;">
	    <form method="get" action="" style="margin-top:10px" class="top_form">
		<ul>
		    <li style="padding-top:3px"><input type="text" class="top_input" name="email" value="账号" style="color:#999"></li>
		    <li style="padding-top:3px"><input type="password" class="top_input" name="passowrd" value="..." style="color:#999"></li>
		    <li style="padding-top:0px"><input type="submit" class="top_login_button" value=""></li>
		    <li style="padding-top:0px"><input type="button" class="top_sign_button" value=""></li>
		</ul>
	    </form>
	</div>
    </div>
</div>
<div id="nav" class="w955">
    <ul>
	<li><a href="/main/index3" class="cur"><img src="/static/v3/images/nav_main.gif"></a></li>
	<li><a href="#"><img src="/static/v3/images/nav_news.gif"></a></li>
	<li><a href="#"><img src="/static/v3/images/nav_event.gif"></a></li>
	<li><a href="#"><img src="/static/v3/images/nav_aa.gif"></a></li>
	<li><a href="#"><img src="/static/v3/images/nav_bbs.gif"></a></li>
	<li class="none"></li>
	<li><a href="#"><img src="/static/v3/images/nav_juanzeng.gif"></a></li>
	<li><a href="#"><img src="/static/v3/images/nav_kanwu.gif"></a></li>
	<li><a href="#" style="border-right-width:0"><img src="/static/v3/images/nav_longka.gif"></a></li>
    </ul>
</div>