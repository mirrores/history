<!-- history/index:_body -->
<style type="text/css">
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
        <form method="get" action="<?= URL::site('history/searh') ?>">
            <input type="text"  id="name" name="q" placeholder="输入专业名称或院系名称或学部名称搜索" size="50" class="input_text" />
            <input type="submit" value="搜索"  class="button_blue"/>
        </form>
    </div>
    <div>
        <div style="font-size:16px;">
            快速检索：
        </div>
        <div id="seach">

            <ul>
                <?php foreach ($history as $key => $h):
                    ?>
                    <li style="margin-left:10px;margin-top:10px;"><a href="<?= URL::site('history/searh?id=' . $h['id']) ?>"><?= $h['name'] ?></a></li>
                <?php endforeach; ?>
            </ul> 

        </div>
    </div>


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