<!-- admin_history/deldepartindex:_body -->
<style type="text/css">
    #history_depart_form{ padding: 10px; background: #fcfcfc; border: 1px solid #eee; }
</style>
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
            <a  href="<?= URL::site('admin_history/delcollegeindex') ?>" style="font-weight:normal" >删除的院系</a>
            <a  href="<?= URL::site('admin_history/delindex') ?>" style="font-weight:normal">删除的专业</a>

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
        <td colspan="3" class="td_title">学部管理</td>
    </tr>
    <tr>
        <td width="5%">id</td>
        <td width="90%" style="text-align:center">学部名称</td>
        <td width="5%"  style="text-align:center">恢复</td>
    </tr>

    <?php if (count($departs) == 0): ?>
        <tr>
            <td colspan="3" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何学部信息。</td>
        </tr>
    <?php else: ?>
        <?php foreach ($departs as $key => $d): ?>

            <tr id="history_<?= $d['id'] ?>"   class="<?php if (($key) % 2 == 0) {echo'even_tr';} ?>">
                <td  style="text-align: center"><?= $d['id'] ?></td>
                <td  style="text-align: center"><?= $d['name'] ?></td>
                <td class="handler" style="text-align: center"><a href="javascript:back(<?= $d['id'] ?>)">恢复</a>  </td>
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
            message: '确定要恢复这个学部信息吗？<br>注意恢复学部信息将同时恢复学部下所有院系专业信息！。',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/backDepart?cid=') ?>' + cid,
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