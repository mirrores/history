<div style="margin: 10px 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/2014/title_xinren.jpg" alt="" /></div>
    <div style="width: 400px;float:right;margin: 30px 20px 0 0;text-align: right">
        <form action="/wedding/signs" method="get">
      <i class="fa fa-search"></i> <input type="text" name="q" style="width:200px;height:18px; background-color: #F7E5E8;font-size:12px;border:1px solid #F696AB;padding: 2px;"  placeholder="姓名"/> <input type="hidden" name="id" value="<?= $wedding['id']?>"/>  <input type="submit" value="搜索" /></li>
        </form>
    </div>
    <div class="clear"></div>
</div>

<div style="color:#F696AB">说明：以下展现顺序以报名先后顺序排列。<? if ($wedding['open_vote'] AND $_OPENVOTE==false): ?>投票系统维护中，谨请关注!<?php endif;?></div>
<div class="photo_list" >
    <?php if ($photos): ?>
        <?php foreach ($photos as $key => $p): ?>
            <div class="wrap">
                <a href="#"><img src="<?= $p['photo_path'] ?>" alt="photo" class="pp" style="border-width: 0"></a>
                <div class="cover" >
                    <h3><?= $p['bridegroom_name'] ?>&<?= $p['bride_name'] ?>&nbsp;<?=$wedding['open_vote']?'第'.$p['topnum'].'名':null ?></h3>
                    <p style="height: 148px;" ><i class="fa fa-comments-o"></i>&nbsp;爱情宣言：<br>&nbsp;&nbsp;&nbsp;&nbsp;<?= Text::limit_chars(trim($p['love_declaration']), 100) ?></p>
                    <? if ($wedding['open_vote'] AND $_OPENVOTE): ?>
                        <p style="text-align: right;padding: 0 15px;position: relative;font-family: verdana" id="signvote_<?= $p['id'] ?>">  <i class="fa fa-thumbs-o-up " title="支持一下" ></i>&nbsp;<span class="goodnum"><?= $p['good_num'] ?></span>&nbsp;<span id="votetext<?= $p['id'] ?>"><a href="javascript:good(<?= $p['id'] ?>,'<?= $p['votekey'] ?>')"  >投一票</a></span><span style="position: absolute;right: 28px;top:-15px;font-size: 12px;display: none" class="animatevote">+1</span></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?= $pager ?>
    <?php else: ?>
        <div class="nodata">很抱歉，没有找到符合条件的报名信息！</div>
    <?php endif; ?>
    <div class="clear"></div>
</div>


<script type="text/javascript">
    $(function() {
        $(".cover").css("opacity", .9);
        $(".wrap").hover(function() {
            $(".cover", this).stop().animate({top: "-30px"}, {queue: false, duration: 250});
        }, function() {
            $(".cover", this).stop().animate({top: "145px"}, {queue: false, duration: 250});
        });
    });
</script>
