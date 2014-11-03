<style type="text/css">
.new_user_avatar .online_verify{border:1px dashed #A2CE4D}
</style>
<ul style="list-style: none">
<?php foreach ($signs AS $s): ?>
    <li id="sign_user_<?= $s['id'] ?>" class="new_user_avatar" >
        <?php if (!$s['is_verify']): ?>
            <span class="face_verify<?= $s['online'] ? ' online_verify' : ''; ?>"><img src="<?= Model_User::avatar(0, 48, $s['User']['sex']) ?>" title="<?=$s['group_name']?$s['group_name']:null;?>小队待审成员,<?=Date::ueTime($s['sign_at'])?>加入"></span>
            <span class="name" style="color:#999">待通过<?php if ($permission['is_edit_permission']): ?><a href="javascript:delsign(<?= $s['id'] ?>)" style="color:#999" title="取消<?= $s['User']['realname'] ?>报名信息">×</a><?php endif; ?></span>
        <?php elseif (!$s['is_anonymous']): ?>
            <span class="face<?= $s['online'] ? '_online' : ''; ?>"><a href="<?= URL::site('user_home?id=' . $s['User']['id']) ?>" title="<?=$s['group_name']?$s['group_name'].'小队成员,':null;?>报名<?= $s['num'] ?>人,<?=Date::ueTime($s['sign_at'])?>加入" target="_blank"><img src="<?= Model_User::avatar($s['User']['id'], 48, $s['User']['sex']) ?>"></a></span>
            <span class="name"><a href="<?= URL::site('user_home?id=' . $s['User']['id']) ?>" title="报名<?= $s['num'] ?>人" target="_blank"><?= $s['User']['realname'] ?></a><?php if($s['is_captain']):?><img src="/static/images/flag.png" title="<?=$s['group_name']?$s['group_name']:null;?>队长" /><?php else:?><?php if ($permission['is_edit_permission']): ?><a href="javascript:delsign(<?= $s['id'] ?>)" style="color:#999" title="取消<?= $s['User']['realname'] ?>报名信息">×</a><?php endif; ?><?php endif;?></span>
        <?php else: ?>
            <span class="face<?= $s['online'] ? '_online' : ''; ?>"><img src="<?= Model_User::avatar(0, 48, $s['User']['sex']) ?>" title="<?=$s['group_name']?$s['group_name'].'小队成员,':null;?>猜猜我是谁(报名<?= $s['num'] ?>人),<?=Date::ueTime($s['sign_at'])?>加入"></span>
            <span class="name" style="color:#999">匿名<?php if ($permission['is_edit_permission']): ?><a href="javascript:delsign(<?= $s['id'] ?>)" style="color:#999" title="取消<?= $s['User']['realname'] ?>报名信息">×</a><?php endif; ?></span>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
</ul>