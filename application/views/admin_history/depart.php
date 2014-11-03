<!-- admin_history/depart:_body -->
<style type="text/css">
    #history_depart_form{ padding: 10px; background: #fcfcfc; border: 1px solid #eee; }
</style>
<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1">
    <tr >
        <td height="29" class="td_title" >
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
        <td width="5%" style="text-align:center">id</td>
        <td width="90%" style="text-align:center">学部名称</td>
        <td width="5%"  style="text-align:center">删除</td>
    </tr>

    <?php if (count($historys) == 0): ?>
        <tr>
            <td colspan="3" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何学部信息。</td>
        </tr>
    <?php else: ?>
        <?php foreach ($historys as $key => $h): ?>

            <tr id="history_<?= $h['id'] ?>"   class="<?php if (($key) % 2 == 0) {
            echo'even_tr';
        } ?>">
                <td style="text-align:center"><?= $h['id'] ?></td>
                <td  style="text-align: center">
                    <a href="<?= URL::site('admin_history/depart?id=' . $h['id']) ?>"><?= $h['name'] ?></a>
                </td>
                <td class="handler" style="text-align: center"><a href="javascript:del(<?= $h['id'] ?>)">删除</a>  </td>
            </tr>
    <?php endforeach; ?>
<?php endif; ?>
</table>

<table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:-1px " >
    <tr>
        <td style="height: 50px"><?= $pager ?></td>
    </tr>
</table>

<form action="<?= URL::query(); ?>" id="history_depart_form" method="post" style="margin:0; padding: 0">
    <table class="admin_table" width="100%" border="0" cellpadding="0" cellspacing="1" style="margin-top:2px ">
        <tr>
            <td colspan="2" class="td_title"><?= $history ? '修改' : '添加' ?>学部</td>
        </tr>
        <tr >
            <td class="field" style="width:150px">学部名称：</td>
            <td><input size="30" type="text" name="name" value="<?= @$history['name'] ?>" class="input_text"/></td>
        </tr>
        <tr>
            <td class="field" style="width:150px"></td>
            <td > <input type="hidden" name="id" value="<?= @$history['id'] ?>" />
                <input type="submit" value="<?= $history ? '保存修改' : '确定添加' ?>" class="button_blue" />

            </td>
        </tr>
    </table>
</form>

<script type="text/javascript">
    function del(cid) {
        var b = new Facebox({
            title: '删除确认！',
            message: '确定要删除这个学部信息吗？<br>注意删除学部信息将同时删除学部下所有院系专业信息！。',
            icon: 'question',
            ok: function() {
                new Request({
                    url: '<?= URL::site('admin_history/delDepart?cid=') ?>' + cid,
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