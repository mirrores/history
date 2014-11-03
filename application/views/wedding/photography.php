<div style="margin: 10px 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/photography_show.png" alt="" /></div>
    <div style="width: 400px;float:right;margin: 30px 20px 0 0;text-align: right">
        <form action="/wedding/photography" method="get">
            <i class="fa fa-search"></i> <input type="text" name="q" style="width:200px;height:18px; background-color: #F7E5E8;font-size:12px;border:1px solid #F696AB;padding: 2px;"  placeholder="作者或标题"/> <input type="hidden" name="id" value="<?= $wedding['id'] ?>"/> <input type="hidden" name="award" value="<?= $award_name ?>"/>  <input type="submit" value="搜索" /></li>
        </form>
    </div>
    <div class="clear"></div>
</div>

<?php if ($photos): ?>
    <div class="<?= $award_name == '三等奖' ? 'third_prize' : 'other_prize'; ?>">

        <dl>
            <dt><?= $award_name ?></dt>
            <dd>
                <ul>
                    <?php if ($photos): ?>
                        <?php foreach ($photos as $key => $p): ?>
                            <li><div class="<?= $award_name == '三等奖' ? 'imgBox' : 'imgBox2'; ?>" style="width:<?= $award_name == '三等奖' ? '250px' : '190px' ?>;height:<?= $award_name == '三等奖' ? '185px' : '150px' ?>;overflow: hidden; text-align: center"><a href="<?= str_replace('_thumbnail', '_bmiddle', $p['img_path']); ?>" title="<?= $p['title'] ?> — <?= $p['author'] ?>" class="colorboxPic" style="cursor:url(/static/big.cur),pointer"><img src="<?= $p['img_path'] ?>" height="<?= $award_name == '三等奖' ? '185' : '150'; ?>" /></a></div><p><?= Text::limit_chars(trim($p['title']), 8) ?> — <?= $p['author'] ?></p><div class="div"></div></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </dd>
        </dl>


    </div>
    <?= $pager ?>



<?php else: ?>
    <div class="third_prize">
        <dl>
            <dt><?= $award_name ?></dt>
            <dd>
                <div class="nodata">很抱歉，暂无相关作品！</div>
            </dd>
        </dl>
    </div>
<?php endif; ?>

<?php if ($award_name == '入围奖'): ?>
    <div style="color:#F696AB; text-align: right;font-size: 14px; margin: 20px 0;padding-right: 20px"><a href="/wedding?id=<?= $wedding['id'] ?>"  style="color:#BF485F;font-weight: bold;font-size: 14px">返回集体婚礼首页</a></div>
<?php else: ?>  
    <div style="color:#F696AB; text-align: right;font-size: 14px; margin: 20px 0;padding-right: 20px"><a href="/wedding/photography?id=<?= $wedding['id'] ?>&award=入围奖"  style="color:#BF485F;font-weight: bold;font-size: 14px">更多获奖作品展示</a></div>
<?php endif; ?>

<script type="text/javascript">
    window.onload=function(){
        $(".colorboxPic").colorbox({rel: 'colorboxPic'});
    }
</script>