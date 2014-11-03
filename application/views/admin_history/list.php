<!-- admin_history/list:_body -->
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
            <div class="title_search">
                <form name="search" action="" method="get">
                     <input type="text"  id="name" name="q" placeholder="输入专业名称或院系名称或学部名称或专业字母搜索" size="50" class="keyinput" />
                    <input type="submit" value="搜索">
                </form>
            </div>
        </td>
    </tr>
</table>


<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:0px " id="table1">
    <tr>
        <td colspan="10" class="td_title">专业管理</td>
    </tr>
    <tr>
        <td width="3%" style="text-align:center">id</td>
        <td width="15%" style="text-align:center">专业名称</td>
        <td width="15%" style="text-align:center">院系名称</td>
        <td width="15%" style="text-align:center">学部名称</td>
        <td width="5%" style="text-align:center">专业字母</td>
        <td width="8%" style="text-align:center">专业创建时间</td>
        <td width="10%" style="text-align:center">现专业名称</td>
        <td width="15%"  style="text-align:center">专业变革信息</td>
        <td width="10%"  style="text-align:center">信息添加时间</td>
        <td width="5%"  style="text-align:center">删除</td>
    </tr>

    <?php if (count($history) == 0): ?>
        <tr>
            <td colspan="10" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何专业信息。</td>
        </tr>

    <?php else: ?>
        <?php foreach ($history as $key => $h): ?>
            <tr id="history_<?= $h['id'] ?>"   class="<?php if (($key) % 2 == 0) {
            echo'even_tr';
        } ?>">
                <td style="text-align: center"><?=$h['id']?></td>
                <td style="text-align: center">
                    <a href="<?= URL::site('admin_history/form?id=' . $h['id']) ?>"><?= $h['name'] ?></a>
                </td>
                <td style="text-align:center"><?= Text::limit_chars($h['college'], 10, '...') ?></td>
                <td style="text-align:center"><a href="<?= URL::site('admin_history/collegelist?id=' . $h['depart_id']) ?>"  style=""><?= Text::limit_chars($h['depart'], 10, '...') ?></a></td>
                <td style="text-align:center"><?= $h['grapheme'] ?></td>
                <td style="text-align:center"><?= $h['date'] ?></td>
                <td style="text-align:center"><a href="<?= URL::site('admin_history/professionallist?id=' . $h['professional_id']) ?>"  style=""><?= $h['professional'] ?></a></td>
                <td style="text-align:center"><?= Text::limit_chars($h['content'], 15, '....') ?></td>
                <td style="text-align:center"><?= date('Y-n-d',strtotime($h['create_date'])) ?></td>
                <td  style="text-align: center"><a href="javascript:del(<?= $h['id'] ?>)">删除</a>  </td>
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
                    url: '<?= URL::site('admin_history/del?cid=') ?>' + cid,
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