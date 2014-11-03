<!-- admin_history/delindex:_body -->
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
            <a  href="<?= URL::site('admin_history/deldepartindex') ?>" style="font-weight:normal">删除的学部</a>
            <a  href="<?= URL::site('admin_history/delcollegeindex') ?>"  style="font-weight:normal">删除的院系</a>

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
        <td colspan="8" class="td_title">专业管理</td>
    </tr>
    <tr>
        <td width="5%" style="text-align:center">id</td>
        <td width="15%" style="text-align:center">专业名称</td>
        <td width="15%" style="text-align:center">院系名称</td>
        <td width="15%" style="text-align:center">学部名称</td>
        <td width="10%" style="text-align:center">专业字母</td>
        <td width="10%" style="text-align:center">专业创建时间</td>
        <td width="25%"  style="text-align:center">专业变革信息</td>
        <td width="5%"  style="text-align:center">恢复</td>
    </tr>

    <?php if (count($historys) > 0): ?>
        <?php foreach ($historys as $key => $h): ?>

            <tr id="history_<?= $h['id'] ?>"   class="<?php if (($key) % 2 == 0) {
            echo'even_tr';
        } ?>">
                 <td style="text-align:center"> <?= $h['id'] ?></td>
                <td style="text-align:center"> <?= $h['name'] ?></td>
                <td style="text-align:center"><?= $h['college_id'] ?></td>
                <td style="text-align: center"><?= $h['depart_id'] ?></td>
                <td style="text-align: center"><?= $h['grapheme'] ?></td>
                <td class="timestamp" style="text-align: center"><?= $h['date'] ?></td>
                <td  style="text-align: center"><?= Text::limit_chars($h['content'], 15, '...') ?></td>
                <td class="handler" style="text-align: center"><a href="javascript:back(<?= $h['id'] ?>)">恢复</a>  </td>
            </tr>
    <?php endforeach; ?>
<?php else: ?>
        <tr>
            <td colspan="8" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何专业信息。</td>
        </tr>
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
            message: '确定要恢复除这个专业信息吗？',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/Back?cid=') ?>' + cid,
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