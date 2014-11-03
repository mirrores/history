<!-- admin_history/collegelist:_body -->
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:0px " id="table1">
    <tr>
        <td colspan="4" class="td_title">院系管理</td>
    </tr>
    <tr>
        <td width="5%" style="text-align:center">id</td>
        <td width="45%" style="text-align:center">院系名称</td>
        <td width="45%" style="text-align:center">学部名称</td>
        <td width="5%"  style="text-align:center">删除</td>
    </tr>

    <?php if (count($college) == 0): ?>
        <tr>
            <td colspan="4" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何院系信息。</td>
        </tr>
    <?php else: ?>
        <?php foreach ($college as $key => $c): ?>

            <tr id="history_<?= $c['id'] ?>"   class="<?php if (($key) % 2 == 0) {echo'even_tr';} ?>">
                <td  style="text-align: center"><?= $c['id'] ?></td>
                <td  style="text-align: center">
                    <a href="<?= URL::site('admin_history/list?id=' . $c['id']) ?>" title="点击修改" style=""><?= $c['name'] ?></a>
                </td>
                <td  style="text-align: center"><?= $c['depart_id'] ?></td>
                <td class="handler" style="text-align: center"><a href="javascript:del(<?= $c['id'] ?>)">删除</a>  </td>
            </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>

<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:-1px " >
    <tr>
        <td style="height: 50px"><?= $pager ?></td>
    </tr>
</table>


<script type="text/javascript">
    function del(cid) {
        var b = new Facebox({
            title: '删除确认！',
            message: '确定要删除这个院系信息吗？<br>注意删除院系信息将同时删除院系下所有专业信息！。',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/delCollege?cid=') ?>' + cid,
                    type: 'post',
                    success: function() {
                        candyDel('history_' + cid);
                    }
                }).send();
                b.close();
            }
        });
        b.show();
    }
</script>