    <div id="news">
	<?php if ($top_news): ?>
    	<h1><a href="<?= URL::site('news/view?id=' . $top_news['id']) ?>" title="<?= $top_news['title'] ?>" target="_blank"><?= Text::limit_chars($top_news['title'], 20, '..') ?></a></h1>
    	<div class="des">简述：<?= Text::limit_chars($top_news['intro'], 62, '..') ?>&nbsp;&nbsp;<a href="<?= URL::site('news/view?id=' . $top_news['id']) ?>" style="color:#666">全文</a></div>
	<?php else: ?>
    	<h3 style="margin:0px;color:#0D5194">新闻动态</h3>
	<?php endif; ?>
	<div class="con_list a14">
	    <ul>
		<?php foreach ($news_list as $n): ?>
    		<li><a href="<?= URL::site('news/view?id=' . $n['id']) ?>" title="<?= $n['title'] ?>" target="_blank"><?= Text::limit_chars($n['title'], 23, '..') ?></a><?= $n['is_pic'] ? '&nbsp;<font><img src="/static/images/imgs.gif" title="图片新闻"></font>' : ''; ?><span><?= date('n-d', strtotime($n['create_at'])); ?></span></li>
		<?php endforeach; ?>
	    </ul>
	    <p class="more" style="margin:10px 0"><a href="/news">>>更多</a></p>
	</div>
    </div>
    <!--//end news-->