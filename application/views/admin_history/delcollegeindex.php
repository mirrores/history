<!-- admin_history/delcollegeindex:_body -->
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
            <a  href="<?= URL::site('admin_history/deldepartindex') ?>"style="font-weight:normal" >删除的学部</a>
            <a  href="<?= URL::site('admin_history/delindex') ?>"  style="font-weight:normal">删除的专业</a>
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
        <td colspan="4" class="td_title">学部管理</td>
    </tr>
    <tr>
        <td width="5%" style="text-align:center">id</td>
        <td width="45%" style="text-align:center">院系名称</td>
        <td width="45%" style="text-align:center">学部名称</td>
        <td width="5%"  style="text-align:center">恢复</td>
    </tr>

    <?php if (count($colleges) == 0): ?>
        <tr>
            <td colspan="4" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何院系信息。</td>
        </tr>
    <?php else: ?>
        <?php foreach ($colleges as $key => $c): ?>

            <tr id="history_<?= $c['id'] ?>"   class="<?php if (($key) % 2 == 0) { echo'even_tr';} ?>">
                <td  style="text-align: center"><?= $c['id'] ?></td>
                <td  style="text-align: center"><?= $c['name'] ?></td>
                <td  style="text-align: center"><?= $c['depart_id'] ?></td>
                <td class="handler" style="text-align: center"><a href="javascript:back(<?= $c['id'] ?>)">恢复</a>  </td>
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
    function back(cid) {
        var b = new Facebox({
            title: '恢复确认！',
            message: '确定要恢复这个院系信息吗？<br>注意恢复院系信息将同时恢复院系下所有专业信息！。',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/BackCollege?cid=') ?>' + cid,
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