<table id="bench_list" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tbody><tr>
            <th style="text-align:left; width: 10%">姓名</th>
            <th style="text-align:left; width: 10%"></th>
            <th style="text-align:left; width: 35%">基本信息</th>
            <th style="width: 15%">报名时间</th>
            <th style=" text-align: center;width: 5%">通过</th>
            <th style=" text-align: center;width: 5%">取消</th>
        </tr>
        <?php if(!$member):?>
        <tr>
            <td colspan="5" style="color:#999;padding: 10px 0">暂无小组成员</td>
        </tr>    
        <?php endif;?>

         <?php foreach ($member AS $key=>$s): ?>
        <tr id="duiwu_u<?=$s['user_id']?>" class="<?= (($key + 1) % 2) == 0 ? 'even_tr' : 'odd_tr'; ?>">
            <td style="padding:10px">
                <a href="/user_home?id=<?= $s['user_id'] ?>" target="_blank"><div class="user_avatar" style="width:48px"><img src="<?= Model_User::avatar($s['user_id'], 48, $s['User']['sex']) ?>" style="height: 48px;width: 48px;border-width:0"></div></a></td>
            <td>
                <a style="font-weight:bold" href="/user_home?id=<?= $s['user_id'] ?>" target="_blank"><?= $s['User']['realname'] ?></a>
                <br>
                <a href="javascript:;" onclick="sendMsg(<?= $s['user_id'] ?>)" title="发送站内信">发送站内信</a>
            </td>
            <td>
<?= isset($s['User']['Contact']['mobile'])?$s['User']['Contact']['mobile']:null;?>&nbsp;&nbsp;<?= $s['User']['start_year'] ? $s['User']['start_year'] . '级' : ''; ?><?= $s['User']['speciality'] ?>
            </td>
            <td style="text-align: center;"><?= date('Y-m-d H:i', strtotime($s['sign_at'])); ?></td>
            <td style="text-align: center;">
                <input type="checkbox" onclick="join_event_group(<?= $s['id'] ?>,<?= $s['category_id'] ?>,<?= $s['event_id'] ?>);" <?= $s['is_verify']? 'checked' : '' ?> <?= $s['is_captain'] ? 'disabled="disabled"' : ''; ?>>
            </td>
            <td style="text-align: center;">
<? if(!$s['is_captain']): ?>
                <a href="javascript:delGroupSign(<?= $s['id'] ?>,<?= $s['user_id'] ?>)" style="color:#c00" title="取消<?= $s['User']['realname'] ?>报名资格">取消</a>
<?php else:?>
                <span style="#eee">取消</span>
<?php endif;?>
            </td>
        </tr>
        <?php endforeach; ?>
        
        
     <tr>
     <td style="color:#999;padding-bottom: 10px;padding-top: 5px" colspan="6">说明：如需更换队长或合并队伍请直接发站内信至管理员，谢谢！</td>
        </tr>
    </tbody></table>


<script type="text/javascript">
//取消报名
function delGroupSign(sid,uid){
    var b = new Facebox({
        id:'deleteGroupSign',
        title: '取消确认！',
        message: '确定要取消该校友入队申请吗？（系统将自动发送站内信通知该校友）',
        icon:'question',
        ok: function(){
            new Request({
                url: '/event/deleteGroupSign',
                type: 'post',
                data:'sign_id='+sid,
                success: function(){
                    candyDel('duiwu_u'+uid);
                    candyDel('sign_user_'+sid);
                }
            }).send();
            b.close();
        }
    });
    b.show();
}
</script>