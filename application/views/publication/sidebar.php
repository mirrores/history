    <p class="sidebar_title">刊物分类</p>
    <div class="sidebar_box" style="height:650px">
<ul class="sidebar_menus">
<?php foreach(Model_Publication::$pub_type AS $key=>$t) :?>
    <li><a href="<?=URL::site('publication?type='.$key) ?>" style="<?=$_A=='index'?'font-weight:bold':''?>"><?=$t?></a></li>
<?php endforeach; ?>
<li><a href="<?=URL::site('publication/eleReport')?>" style="<?=$_A=='eleReport'?'font-weight:bold':''?>" >浙大校友电子信息报</a></li>
<li><a href="<?=URL::site('publication/subscribe')?>" style="<?=$_A=='subscribe'?'font-weight:bold':''?>">订阅芳名录</a></li>
<li><a href="<?=URL::site('publication/callForPapers')?>" style="<?=$_A=='callForPapers'?'font-weight:bold':''?>">征订征稿</a></li>

</ul>
    </div>