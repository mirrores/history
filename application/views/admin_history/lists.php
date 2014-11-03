<!-- admin_history/lists:_body -->
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
        <td colspan="7" class="td_title">校友反馈信息管理</td>
    </tr>
    <tr>
         <td width="5%" style="text-align:center">id</td>
        <td width="30%" style="text-align:center">内容</td>
        <td width="25%" style="text-align:center">图片</td>
        <td width="13%" style="text-align:center">校友名称</td>
        <td width="15%" style="text-align:center">反馈时间</td>
        <td width="5%" style="text-align:center">是否已读</td>
        <td width="7%" style="text-align:center">是否已执行</td>
    </tr>

    <?php if (count($historyalumnis) == 0): ?>
        <tr>
            <td colspan="7" style="background-color:#fff;padding:10px; text-align: left; color: #999">没有任何专业信息。</td>
        </tr>

    <?php else: ?>
        <?php foreach ($historyalumnis as $key => $h): ?>

            <tr id="history_<?= $h['id'] ?>"   class="<?php if (($key) % 2 == 0) {
            echo'even_tr';
        } ?>">
                <td style="text-align:center"><?=$h['id']?></td>
                <td class="history_title" style="text-align:center">
                    <a href="<?= URL::site('admin_history/view?id=' . $h['id']) ?>" style=""><?= Text::limit_chars($h['content'], 15, '...') ?></a>
                </td>
                <td style="text-align:center">
                    <?php if($h['image']!=null):?>
                    <a href="<?= URL::site('admin_history/view?id=' . $h['id']) ?>" style="">  <img src="/<?=$h['image']?>" width="200px" height="49px;"></a>
                   <?php endif;?>
                </td>
                <td style="text-align:center"><?= $h['user_id'] ?></td>
                <td style="text-align:center"><?= $h['create_date'] ?></td>
                <td style="text-align:center"><input type="checkbox" value="0" onclick="setread(<?= $h['id'] ?>)" <?= $h['is_read'] ? 'checked':'' ?> /></td>
                <td style="text-align:center"><input type="checkbox" value="0" onclick="setdo(<?= $h['id'] ?>)" <?= $h['is_implement'] ? 'checked':'' ?> /></td>
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
    function setread(cid){
        new Request({
            url: '<?= URL::site('admin_history/read').URL::query() ?>',
            type: 'post',
            data: 'cid='+cid
        }).send();
    }
    function setdo(cid){
        new Request({
            url: '<?= URL::site('admin_history/do').URL::query() ?>',
            type: 'post',
            data: 'cid='+cid
        }).send();
    }
 </script>
