<p> <a href="<?= Db_Event::getLink($event['id'], $event['aa_id'], $event['club_id']) ?>" style="color:#c00;font-size: 14px"> <<  返回<?= $event['title'] ?></a></p>
<h2>设置活动参加方式或分类：</h2>


<table id="all_cagegorys" class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:9px " >

    <tr class="td_title" style=" background: #eee; height:25px;">
        <td width="5%" style="text-align:center">序号</td>
        <td width="30%" >分类名称</td>
        <td width="10%" style="text-align:center">组长id(可留空)</td>
        <td width="10%" style="text-align:center">组长</td>
        <td width="10%" style="text-align:center">小组人数</td>
        <td width="10%"  style="text-align:center">合并到</td>
        <td width="10%"  style="text-align:center">删除</td>
    </tr>
    <?php if (count($categorys) > 0): ?>
        <?php foreach ($categorys as $c): ?>
            <tr id="c_<?= $c['id'] ?>">
                <td style="text-align:center"><?= $c['id'] ?></td>
                <td height="25" style="padding:0px 10px" >
                    <input type="text" class="input_text" style="width: 100%" value="<?= $c['name'] ?>"  cid="<?= $c['id'] ?>" id="category_name_<?= $c['id'] ?>">
                </td>
                <td>
                    <input type="text" class="input_text" style="width: 100%" value="<?= $c['captain_id'] ?>" cid="<?= $c['id'] ?>" id="category_captain_<?= $c['id'] ?>">
                </td>
                <td style="text-align:center;"><?= $c['User']['realname'] ?></td>
                <td style="text-align:center; color: green"><?= $c['sign_num'] ? $c['sign_num'] : '0'; ?>人</td>
                <td style="text-align:center;">
                    <select class="merger_select" cid="<?= $c['id'] ?>" catname="<?= $c['name'] ?>">
                        <option value="">选择新队伍</option>
                        <?php foreach ($categorys as $cc): ?>
                            <?php if ($cc['id'] != $c['id']): ?>
                                <option value="<?= $cc['id'] ?>" ><?= $cc['name'] ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td style="text-align:center"><a href="javascript:del(<?= $c['id'] ?>)">删除</a></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td height="25" style="padding:0px 10px" colspan="4" >
                <span class="nodata">没有任何分类信息。</span>
            </td>
        </tr>
    <?php endif; ?>
</table>


<div style=" color: #666;margin:15px 15px" id="addnewsigncat">添加新分类：
    
<form action="/event/signCategorys" method="POST" id="signcategory_form">  
    <table border="0" cellspacing="3" cellpadding="0" style="margin-top:0px;width: 98%"  >
        <tr>
            <td style="width:70px;text-align: right;padding-right: 5px;">分组名称：</td>
            <td colspan="2"><input name="name" style="width:300px;color: #666" class="input_text" value="<?=@$category['name']?>"> <span style="color:#f00">*</span> 分组或小队名称</td>
        </tr>
        <tr>
            <td style="width:70px;text-align: right;padding-right: 5px;">组长ID：</td>
            <td colspan="2"><input name="captain_id" style="width:300px;color: #666" class="input_text" value="<?=@$category['captain_id']?>"> 可以留空</td>
        </tr>
        <tr>
            <td style="width:70px;text-align: right;padding-right: 5px;">分组说明：</td>
            <td colspan="2"><textarea name="remarks" style="width:100%;height:50px; color: #666" class="input_text" ><?=@$category['remarks']?></textarea></td>
        </tr>
        <tr>
            <td></td><td>
                <input type="hidden" name="event_id" value="<?=$event_id?>" />
                <input type="hidden" name="category_id" value="<?=@$category['id']?>" />
                <input type="button" value="立即创建"  class="button_blue" id="submit_button" onclick="signCategoryFormSub()"/></td>
        </tr>
    </table>
</form>
    
</div>


<script type="text/javascript">
            $(document).ready(function() {
                //修改
                var all_cagegorys = $('#all_cagegorys');
                var all_textinput = $('#all_cagegorys').find("input[type=text]");
                all_textinput.change(function() {
                    var cid=$(this).attr('cid');
                    new Request({
                        type: 'post',
                        url: '/event/signCategorys?event_id=<?=$event_id ?>',
                        data: {'category_id':$(this).attr('cid'),'name': $('#category_name_' + $(this).attr('cid')).val(),'captain_id':$('#category_captain_' + $(this).attr('cid')).val()}
                    }).send();
                });

                //合并
                var merger_selects = all_cagegorys.find("select.merger_select");
                merger_selects.change(function() {
                    if ($(this).val() != '') {
                        var select = $(this);
                        new candyConfirm({
                            title: '合并确认',
                            message: '确定要合并队伍吗？注意合并后原队伍队长将不再是队长了，原成员审核状态将保持不变！',
                            url: 'aa_admin_member',
                            callback: function() {
                                $.ajax({
                                    url: '/event/signCategorys?event_id=<?=$event_id ?>',
                                    dataType: 'html',
                                    type: 'POST',
                                    data: {'category_id': select.attr('cid'), 'merger_to_category_id': select.val()},
                                    success: function(data) {
                                        okAlert('恭喜您，分组成员合并成功！请继续操作或返回！');
                                        setTimeout(function() {
                                            window.location.reload();
                                        }, 1200);
                                    }
                                });
                            }
                        }).open();
                    }
                });
            });
</script>

<script type="text/javascript">


    //添加新报名分类
    function signCategoryFormSub() {
        new ajaxForm('signcategory_form', {textSending: '发送中', textError: '重试', textSuccess: '发送成功', callback: function(id) {
                //window.location.reload();
            }}).send();
    }

    function del(category_id) {
        new candyConfirm({
            message: '确定要删除该内容吗？注意删除分组后已经分组成员将自动设置为分组。',
            url: '/event/signCategorys?event_id=<?=$event_id ?>',
            data: {'category_id': category_id, 'del': 1},
            removeDom: 'c_' + category_id
        }).open();
    }
</script>
