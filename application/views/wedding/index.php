<script type="text/javascript" src="/static/js/slider.js"></script>
<div style="margin:15px 0 0 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/xinwengongao.png" alt=""  style="width:250px"/></div>
    <div style="width: 345px;float:right;margin: 30px 5px 0 0;text-align: right;text-align: center"></div>
    <div class="clear"></div>
</div>

<div>
    <ul class="notice_ul">
        <?php foreach ($notices as $key => $n): ?>
            <li>&nbsp;&nbsp;<i class="fa fa-caret-right"></i>&nbsp;<a href="/wedding/notice?id=<?= $wedding['id'] ?>&nid=<?= $n['id'] ?>" ><?= $n['title'] ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>

<?php if ($wedding['is_upload_photography'] AND time() >= strtotime($wedding['photography_start']) AND time() <= strtotime($wedding['photography_finish'])): ?>
    <div style="margin:15px 0 0 0">
        <div style="width: 200px;float: left"><img src="/static/images/wedding/photography.png" alt=""  style="width:250px"/></div>
        <div style="width: 345px;float:right;margin: 30px 5px 0 0;text-align: right;text-align: center"></div>
        <div class="clear"></div>
    </div>
    <div>
        <a href="/wedding/uploadphoto?id=<?= $wedding['id'] ?>" ><img src="/static/images/wedding/tougao_btn.jpg" style="border-width: 0;vertical-align: middle"></a>
    </div>
<?php elseif ($wedding['photography_finish'] AND time() > strtotime($wedding['photography_finish']) AND ! $wedding['open_photography']): ?>
    <div style="margin:15px 0 0 0">
        <div style="width: 200px;float: left"><img src="/static/images/wedding/photography.png" alt=""  style="width:250px"/></div>
        <div style="width: 345px;float:right;margin: 30px 5px 0 0;text-align: right;text-align: center"></div>
        <div class="clear"></div>
    </div>
    <div>
        <img src="/static/images/wedding/photography22.jpg" style="border-width: 0;vertical-align: middle">
    </div>
<?php endif; ?>

<?php if ($wedding['open_photography']): ?>
    <div style="margin:15px 0 0 0">
        <div style="width: 200px;float: left"><img src="/static/images/wedding/photography_show.png" alt=""  style="width:250px"/></div>
        <div style="width: 345px;float:right;margin: 30px 5px 0 0;text-align: right;text-align: center"></div>
        <div class="clear"></div>
    </div>
    <div>
        <!--一等奖-->
        <div class="first_prize">
            <div class="first_tit">一等奖</div>
            <!--图片轮播-->
            <div class="scrolllist" id="s1" style="height:544px">
                <a class="abtn aleft" href="#left" title="左移"></a>
                <div class="imglist_w" style="height:544px">
                    <ul class="imglist">
                        <li style=" text-align: center;width: 820px;height: 544px">
                            <img src="/static/images/wedding/yidengjiang01.jpg" style="width:820px;height:544px">
                        </li>
                        <li style=" text-align: center">
                            <img src="/static/images/wedding/yidengjiang02.jpg" style="width:820px;height:544px">
                        </li>
                    </ul><!--imglist end-->
                </div>
                <a class="abtn aright" href="#right" title="右移"></a>
            </div><!--scrolllist end-->
        </div>

        <!--二等奖-->
        <div class="second_prize">
            <dl>
                <dt>二等奖</dt>
                <dd>
                    <ul>
                        <?php if ($second_prize): ?>
                            <?php foreach ($second_prize as $key => $p): ?>
                        <li><div class="imgBox" style="width:250px;height: 185px;overflow: hidden; text-align: center"><a href="<?=str_replace('_thumbnail','_bmiddle',$p['img_path']); ?>" title="<?= $p['title'] ?> — <?= $p['author'] ?>" class="colorboxPic" style="cursor:url(/static/big.cur),pointer"><img src="<?= $p['img_path'] ?>" height="185"  style="max-height: 185px; max-width: 250px" /></a></div><p><?= Text::limit_chars(trim($p['title']), 8) ?> — <?= $p['author'] ?></p><div class="div"></div></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </dd>
            </dl>
        </div>

        <div style="clear: both;color:#F696AB; text-align: right;font-size: 14px; margin: 20px 0;padding-right: 20px"><a href="/wedding/photography?id=<?= $wedding['id'] ?>&award=<?= urlencode('三等奖') ?>"  style="color:#BF485F;font-weight: bold;font-size: 14px">更多获奖作品展示</a></div>

    </div>

    <script type="text/javascript">
        $(function() {
            $("#s1").xslider({
                unitdisplayed: 1,
                movelength: 1,
                unitlen: 820,
                autoscroll: 3000
            });
        })
    </script>

<?php endif; ?>

<div style="margin: 10px 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/title_xinren.jpg" alt="" /></div>
    <div style="width: 300px;float:right;margin: 30px 20px 0 0;text-align: right">
        <?php if (time() >= strtotime($wedding['start']) AND time() <= strtotime($wedding['finish'])): ?>
            <a href="#"  class="btn btn-green disabled" />活动进行中</a>
        <?php elseif (time() >= strtotime($wedding['finish'])): ?>
            <a href="#"  class="btn disabled" />活动已结束</a>
        <?php elseif ($wedding['is_suspend']): ?>
            <a href="#"  class="btn disabled" />活动暂停</a>
        <?php elseif ($_UID && $user_sign): ?>
            <a href="/wedding/signform?id=<?= $wedding['id'] ?>&sign_id=<?= $user_sign['id'] ?>"  class="btn btn-orange" />修改/取消报名</a>
        <?php elseif ($wedding['is_stop_sign']): ?>
            <a href="#"  class="btn disabled" />暂停报名</a>
        <?php elseif ($wedding['sign_limit'] > 0 AND $sign_count >= $wedding['sign_limit']): ?>
            <a href="#"  class="btn disabled" />名额已满</a>
        <?php elseif (time() < strtotime($wedding['sign_start'])): ?>
            <a href="#"  class="btn disabled" />尚未开始报名</a>
        <?php elseif (time() > strtotime($wedding['sign_finish'])): ?>
            <a href="#"  class="btn disabled"  />已截止报名</a>
        <?php elseif ($_UID AND time() >= strtotime($wedding['sign_start']) AND time() < strtotime($wedding['sign_finish'])): ?>
            <a href="/wedding/signform?id=<?= $wedding['id'] ?>"  class="btn btn-green" />立即报名</a>
        <?php else: ?>
            <div style="color:#999;font-size:12px; font-weight: normal"><a href="javascript:;" onclick="loginForm('<?= isset($redirect) ? $redirect : $_URL; ?>')" id="flogin_btn" class="btn btn-green" ><i class="fa fa-sign-in"></i> 登陆后报名</a></div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>



<? if ($wedding['open_vote'] AND $_OPENVOTE == false): ?>
    <div style="color:#F696AB; text-align:left;font-size: 14px;padding-left: 20px"><i class="fa fa-heart"></i> 温馨提示：投票系统维护中，谨请关注!</div>
<?php endif; ?>

<div class="photo_list" >
    <?php if ($photos): ?>
        <?php foreach ($photos as $key => $p): ?>
            <div class="wrap">
                <img src="<?= $p['photo_path'] ?>" alt="photo" class="pp" style="border-width: 0">
                <div class="cover" >
                    <h3><?= $p['bridegroom_name'] ?>&<?= $p['bride_name'] ?>&nbsp;<?= $wedding['open_vote'] ? '第' . $p['topnum'] . '名' : null ?></h3>
                    <p style="height: 148px;" ><i class="fa fa-comments-o"></i>&nbsp;爱情宣言：<br>&nbsp;&nbsp;&nbsp;&nbsp;<?= Text::limit_chars(trim($p['love_declaration']), 100) ?></p>
                    <? if ($wedding['open_vote'] AND $_OPENVOTE): ?>
                        <p style="text-align: right;padding: 0 15px;position: relative;font-family: verdana" id="signvote_<?= $p['id'] ?>">  <i class="fa fa-thumbs-o-up " title="支持一下" ></i>&nbsp;<span class="goodnum"><?= $p['good_num'] ?></span>&nbsp;<span id="votetext<?= $p['id'] ?>"><a href="javascript:good(<?= $p['id'] ?>,'<?= $p['votekey'] ?>')"  >投一票</a></span><span style="position: absolute;right: 28px;top:-15px;font-size: 12px;display: none" class="animatevote">+1</span></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="nodata">暂时还没有任何报名信息！快成为第一个报名的吧！</div>
    <?php endif; ?>
    <div class="clear"></div>

    <? if ($wedding['open_vote']): ?>
        <div class="newtop" >
            <p style="color:#CB294B;font-weight: bold;margin: 5px 0;padding:5px 0;border-bottom:4px solid #EDC6CB "><i class="fa fa-arrow-up"></i> 投票热度排行</p>
            <div id="newtopdiv" style="height: 420px;overflow: hidden">
                <ul class="newtopul">
                    <?php foreach ($newtop as $key => $s): ?>
                        <li><span style="color:#AF1234;display: inline-block;width: 20px"><?= $key + 1 ?></span>&nbsp;&nbsp;&nbsp;<a href="/wedding/signs?sid=<?= $s['id'] ?>&id=<?= $wedding['id'] ?>" title="点击浏览" style="color:#CE4662"><?= $s['bridegroom_name'] ?>&<?= $s['bride_name'] ?></a><span class="goodnum"><?= $s['good_num'] ?>票</span></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <p style="color:#CB294B;font-weight: bold;margin: 5px 0;padding:5px 0;border-bottom:4px solid #EDC6CB "><i class="fa fa-search"></i> 查找新人</p>
            <ul>
                <li> <form action="/wedding/signs" method="get"><input type="text" name="q" style="width:80px;height:18px;font-size:12px;border:1px solid #F696AB;padding: 2px;"  placeholder="姓名"/> <input type="hidden" name="id" value="<?= $wedding['id'] ?>"/> <input type="submit" value="搜索" /></form></li>
            </ul>
        </div>
    <?php endif; ?>

</div>

<div style="color:#F696AB; text-align: right;font-size: 14px;padding-right: 20px"><i class="fa fa-heart"></i> 提示：以上新人为随机展示，<a href="/wedding/signs?id=<?= $wedding['id'] ?>"  style="color:#BF485F;font-weight: bold;font-size: 14px">点击浏览全部新人</a></div>

<?php if ($wedding['open_lottery']): ?>
    <div style="margin: 10px 0">
        <div style="width: 200px;float: left"><img src="/static/images/wedding/zhufuqiang.jpg" alt=""  style="width:250px"/></div>
        <div style="width: 345px;float:right;margin: 30px 5px 0 0;text-align: right;">
            <?php if (!$_UID): ?>
                <div style="color:#999;font-size:12px; font-weight: normal"> <a href="javascript:;" onclick="loginForm('<?= isset($redirect) ? $redirect : $_URL; ?>')" id="flogin_btn"  class="btn btn-green" ><i class="fa fa-sign-in"></i> 请登录后祝福并抽奖</a></div>
            <?php elseif ($lottery AND strtotime($lottery['start_date']) < time() AND strtotime($lottery['end_date']) > time()): ?>
                <a href="javascript:write_wish(<?= $wedding['id'] ?>)"  class="btn btn-green"  />发祝福获抽奖机会</a>
            <?php endif; ?>
        </div>
        <div class="clear"></div>
    </div>
    <div style="height:730px">
        <div class="wish-box" id="msgList" style="float:left">
            <div id="wish">
                <?php foreach ($wish as $key => $w): ?>
                    <div><?= $w['content'] ?><p><?= $w['username'] ?> <?= Date::ueTime($w['created_at']); ?></p></div>
                <?php endforeach; ?>
            </div>
        </div>
        <div style=" float: right;width:345px;">
            <div class="ly-plate">
                <div class="rotate-bg"></div>
                <div class="lottery-star"><img src="/static/images/wedding/zhizhen.png" id="lotteryBtn" style="-webkit-transform: rotate(0deg);"></div>
            </div>
            <div style=" color: #C14B64;line-height: 1.6em;font-size: 14px"><i class="fa fa-heart"></i> 规则：<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、每位注册校友在祝福墙留下祝福后，有且仅有一次抽奖机会。<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、投票结束后，中奖名单和奖品领取方式将公布在校友网集体婚礼专区。<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、上图抽奖盘中奖品顺时针依次为浙大纪念笔筒、浙大卡式U盘、集体婚礼庆典门票、浙大纪念徽章、浙大钥匙扣、浙大校景书签。 </div>
        </div>
        <div class="clear"></div>
    </div>
<?php endif; ?>


<?php if ($wedding['open_thinks']): ?>
    <div style="margin: 10px 0">
        <div style="width: 200px;"><img src="/static/images/wedding/thinks.png" alt=""  style="width:250px"/></div>
    </div>
    <div style=" margin-bottom: 15px">
        <?php if ($thinks): ?>
            <ul class="logobox1">
                <?php foreach ($thinks as $key => $t): ?>
                    <li><a href="<?= $t['website'] ?>" title="<?= $t['company_name'] ?>" target="_blank"><img src="<?= $t['logo_path'] ?>" style="border-width: 0;vertical-align: middle;height: 98px;width: 990px"></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        <?php else: ?>
            <div class="nodata" style=" text-align: left">暂无添加内容！</div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php if ($wedding['open_cooperation']): ?>
    <div style="margin: 10px 0">
        <div style="width: 200px;"><img src="/static/images/wedding/hezuodanwei.png" alt=""  style="width:250px"/></div>
    </div>
    <div>
        <?php if ($ponsors): ?>
            <ul class="logobox">
                <?php foreach ($ponsors as $key => $t): ?>
                    <li><a href="<?= $t['website'] ?>" title="<?= $t['company_name'] ?>" target="_blank"><img src="<?= str_replace('_thumbnail', '', $t['logo_path']) ?>" style="border-width: 0;vertical-align: middle"></a></li>
                <?php endforeach; ?>
            </ul>
            <div class="clear"></div>
        <?php else: ?>
            <div class="nodata" style=" text-align: left">暂无添加内容！</div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<div style="position: fixed;width:100px;height:120px;bottom: 50px;left: 40px;*bottom: 0px;*left:0px; text-align: center;color: #999">
    <a href="/wedding/past" ><img src="/static/images/wedding/glogo2.png"  style="border-width: 0"/></a>
    往届回顾
</div>

<script type="text/javascript">
    $(function() {
        $(".cover").css("opacity", .9);
        $(".wrap").hover(function() {
            $(".cover", this).stop().animate({top: "-30px"}, {queue: false, duration: 250});
        }, function() {
            $(".cover", this).stop().animate({top: "145px"}, {queue: false, duration: 250});
        });
        resetWishWall();
        $("#newtopdiv .newtopul").RollTitle({line: 10, speed: 400, timespan: 1500});
    });
    
    window.onload=function(){
        $(".colorboxPic").colorbox({rel: 'colorboxPic'});
    }

    //未发祝福直接抽奖
<?php if ($_UID && $is_wished && $user_recorded == FALSE): ?>
        lottery.bindRotate(<?= $wedding['id'] ?>);
<?php elseif ($_UID && $user_recorded): ?>
        lottery.proscribeBtn('很抱歉，您已经参加过抽奖活动，欢迎下次参加，谢谢！');
<?php elseif ($_UID && $is_wished == false): ?>
        lottery.proscribeBtn('请在发表祝福后再进行抽奖，谢谢！');
<?php elseif (!$_UID): ?>
        lottery.proscribeBtn('您还没有登录，请在登录后进行抽奖！');
<?php else: ?>
        lottery.proscribeBtn('请在发表祝福后再进行抽奖，谢谢！');
<?php endif; ?>
</script>