<!-- wedding/view:_body -->

<div style="margin: 10px 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/2014/title_xinren.jpg" alt="" /></div>
    <div style="width: 300px;float:right;margin: 30px 20px 0 0;text-align: right">
        <?php if (time() >= strtotime($wedding['start']) AND time() <= strtotime($wedding['finish'])): ?>
            <a href="#"  class="btn btn-green disabled" />活动进行中</a>
        <?php elseif (time() >= strtotime($wedding['finish'])): ?>
            <a href="#"  class="btn" />活动已结束</a>
        <?php elseif ($wedding['is_suspend']): ?>
            <a href="#"  class="btn" />活动暂停</a>
        <?php elseif ($_UID && $user_sign): ?>
            <a href="/wedding/signform?id=<?= $wedding['id'] ?>&sign_id=<?= $user_sign['id'] ?>"  class="btn btn-orange" />修改/取消报名</a>
        <?php elseif ($wedding['is_stop_sign']): ?>
            <a href="#"  class="btn" />暂停报名</a>
        <?php elseif ($wedding['sign_limit'] > 0 AND $sign_count >= $wedding['sign_limit']): ?>
            <a href="#"  class="btn" />名额已满</a>
        <?php elseif (time() < strtotime($wedding['sign_start'])): ?>
            <a href="#"  class="btn" />尚未开始报名</a>
        <?php elseif (time() > strtotime($wedding['sign_finish'])): ?>
            <a href="#"  class="btn" />已截止报名</a>
        <?php elseif ($_UID AND time() >= strtotime($wedding['sign_start']) AND time() < strtotime($wedding['sign_finish'])): ?>
            <a href="/wedding/signform?id=<?= $wedding['id'] ?>"  class="btn btn-green" />立即报名</a>
        <?php else: ?>
    <div style="color:#999;font-size:12px; font-weight: normal">您还没有登录，请 <a href="javascript:;" onclick="loginForm('<?= isset($redirect) ? $redirect : $_URL; ?>')" id="flogin_btn" ><i class="fa fa-sign-in"></i> 登录</a>后报名！</div>
        <?php endif; ?>
    </div>
    <div class="clear"></div>
</div>

<div class="photo_list" >
    <?php if ($photos): ?>
        <?php foreach ($photos as $key => $p): ?>
            <div class="wrap">
                <a href="#"><img src="<?= $p['photo_path'] ?>" alt="photo" class="pp"></a>
                <div class="cover" >
                    <h3><?= $p['bridegroom_name'] ?>&<?= $p['bride_name'] ?></h3>
                    <p style="height: 148px"><i class="fa fa-comments-o"></i>&nbsp;爱情宣言：<br>&nbsp;&nbsp;&nbsp;&nbsp;<?= Text::limit_chars(trim($p['love_declaration']), 100) ?></p>
                    <p style="text-align: right;padding: 0 15px">  <i class="fa fa-thumbs-o-up " title="支持一下" onclick="okAlert('评选将在报名结束后开启，谨请关注！')" style="cursor: pointer"></i> <?= $p['good_num'] ?> </p>
                </div>
            </div>
        <?php endforeach; ?>
        <?= $pager ?>
    <?php else: ?>
        <div class="nodata">暂时还没有任何报名信息！快成为第一个报名的吧！</div>
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

