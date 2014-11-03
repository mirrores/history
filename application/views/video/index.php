<style type="text/css">
#video_list ul{ margin: 10px 20px }
#video_list li{ float: left; height: 210px; text-align: center; width: 160px;}
</style>

<div id="main_left">
    <p><img src="/static/images/xiaoyouvideo.jpg"></p>
    <div id="video_list">
        <ul>
            <?php foreach ($video AS $v): ?>
                <li style="text-align: center">
                    <a href="<?= URL::site('video/view?id=' . $v['id']) ?>" target="_blank">
                        <img src="<?= $v['video_path'] ?>/video_.jpg" width="200" height="113"/>
                    </a>
                    <br>
                    <?= $v['title'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="clear"></div>
        <div><?= $pager ?></div>
    </div>
</div>
<div id="sidebar_right">
    <?php include 'sidebar.php'; ?>
</div>
<div class="clear"></div>