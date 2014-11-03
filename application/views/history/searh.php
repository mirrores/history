<!-- history/searh:_body -->
<style type="text/css">
    #history_table th{ background: #f8f8f8; border-bottom: 1px solid #ccc; height: 30px;line-height: 30px}
    #history_table td{ border-bottom: 1px solid #eee; height: 30px;line-height: 30px}
    #seach ul{
        list-style:none;
    }
    #seach ul li {
        float:left;

    } 
</style>
<div id="main_left">
    <h1>历史沿革</h1>

    <div style="margin:10px">
        <form method="get" action="">
            <input type="text"  id="name" name="q" placeholder="输入专业名称或院系名称或学部名称搜索" size="50" class="input_text" />
            <input type="submit" value="搜索"  class="button_blue"/>
        </form>
    </div>
    <div style="float:left;">
        <div style="font-size:16px;">
            快速检索：
        </div>
        <div id="seach" style="margin-top:10px;">

            <ul>
                <?php foreach ($history as $key => $h):
                    ?>
                    <li style="margin-left:10px;margin-bottom:10px;"><a href="<?= URL::site('history/searh?id=' . $h['id']) ?>"><?= $h['name'] ?></a></li>
                <?php endforeach; ?>
            </ul> 

        </div>
    </div>
    <div style="float:left;font-size: 14px;">点击<font color="red">专业名称</font>可查看专业历史信息</div>
    <table border="0" width="100%" id="history_table" cellspacing="0" cellpadding="0" style="margin-top: 20px">
        <thead>
            <tr>
                <th style="text-align: center;width:18%">&nbsp;&nbsp;专业名称</th>
                <th  style="text-align: left">现所属专业名称</th>
                <th  style="text-align: left">现所属院系名称</th>
                <th  style="text-align: left">现所属学部名称</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($historys) == 0): ?>

                <tr>
                    <td colspan="4">暂无该专业信息，请点击右边的<font style="color:red">反馈</font>或者点击<a href="<?= URL::site('history/from') ?>">这里</a>，进行专业信息反馈。</td>
                </tr> 
            <?php else: ?>
                <?php foreach ($historys as $key => $h): ?>
                    <tr>
                        <td style="text-align: center;">
                            <a href="<?= URL::site('history/view?id=' . $h['professional_id']) ?>" ><?= Text::limit_chars($h['name'], 15, '...') ?></a>
                        </td>
                        <td>
                            <a href="<?= URL::site('history/view?cid=' . $h['id']) ?>" ><?= Text::limit_chars($h['professional_name'], 15, '...') ?></a></td>
                        <td><?= Text::limit_chars($h['college_id'], 15, '...') ?></td>
                        <td><?= Text::limit_chars($h['depart_id'], 15, '...') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?= $pager ?>

</div>
<div id="sidebar_right"  >
    <p class="sidebar_title" >历史沿革</p>
    <div class="sidebar_box">
        <ul>
            <li><a href="<?= URL::site('history/index') ?>">专业搜索</a></li>
            <li><a href="<?= URL::site('history/from') ?>">反馈</a></li>
        </ul>
    </div>
</div>

<div class="clear"></div>
