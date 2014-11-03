<?php if ($category AND $category['remarks']): ?>
    <div style="border-bottom:1px dashed #D6EAE5;padding-bottom: 10px;line-height: 1.6em;margin-bottom: 10px;color: #0A6A36">
        小组说明：<?= $category['remarks'] ?></div>
<?php endif ?>
<?php if (count($signs) == 0): ?>
    <span class="nodata">小队或分组暂无报名记录。</span>
<?php else: ?>
    <?= View::factory('event/inc_signs',array('signs'=>$signs,'permission'=>$permission)) ?>
    <div class="clear"></div>
<?php endif; ?>

<?php if ($permission['is_edit_permission'] OR $category['captain_id'] == $_UID): ?>
    <div style=" clear: both;text-align:right;padding:0px 20px;color: #999"><span style="vertical-align:middle"><img src="/static/images/ico_manage.gif"></span>&nbsp;管理小组：<a href="javascript:;" onclick="manage_team(<?= $category['event_id'] ?>,<?= $category['id'] ?>);">成员</a> | <a href="javascript:;" onclick="manage_teaminfo(<?= $category['event_id'] ?>,<?= $category['id'] ?>);">说明</a>  </div>
<?php endif; ?>