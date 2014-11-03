<!-- admin_history/professional:_body -->
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
            <a  href="<?= URL::site('admin_history/professionalform') ?>" style="font-weight:normal">添加现有专业</a>
            <div class="title_search">
                <form name="search" action="" method="get">
                    <input name="q" type="text" style="width:200px" class="keyinput">
                    <input type="submit" value="搜索">
                </form>
            </div>
        </td>
    </tr>
</table>


<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:0px " id="table1">
    <tr>
        <td colspan="5" class="td_title">现有专业管理</td>
    </tr>
    <tr>
        <td width="5%" style="text-align:center">id</td>
        <td width="30%"style="text-align:center" >专业名称</td>
        <td width="30%" style="text-align:center">院系名称</td>
        <td width="30%" style="text-align:center">学部名称</td>
        <td width="5%"  style="text-align:center">删除</td>
    </tr>

    <?php if (count($professional) == 0): ?>
        <tr>
            <td colspan="5" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何专业信息。</td>
        </tr>

    <?php else: ?>
        <?php foreach ($professional as $key => $p): ?>

            <tr id="history_<?= $p['id'] ?>"   class="<?php if (($key) % 2 == 0) {
            echo'even_tr';
        } ?>">
                <td style="text-align:center"><?= $p['id'] ?></td>
                <td class="news_title" style="text-align:center">
                    <a href="<?= URL::site('admin_history/professionalform?id=' . $p['id'] . '&depart_id=' . $p['depart_id']) ?>" title="点击修改" style="text-align:center"><?= $p['name'] ?></a>
                </td>
                <td style="text-align:center"><?= $p['college_id'] ?></td>
                <td style="text-align: center"><?= $p['depart_id'] ?></td>
                <td class="handler" style="text-align: center"><a href="javascript:del(<?= $p['id'] ?>)">删除</a>  </td>
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
            message: '确定要删除这个专业信息吗？注意删除后将不能再恢复。',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/professionaldel?cid=') ?>' + cid,
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