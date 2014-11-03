<!-- wedding/notice:_notice -->
<div class="gonggao">
    <div style="width:760px; margin:0 auto;padding-top:20px;font-size: 16px" class="yahei">
    <?php if(isset($notice) AND $notice):?>
        <i class="fa fa-bullhorn"></i> <a href="/wedding/notice?id=<?=$wedding['id']?>&nid=<?=$notice['id']?>" style="color: #f00"><?=$notice['title']?></a>
    <?php else:?>
        <span class="nodata" >暂无通知及公告信息。</span>
    <?php endif;?>
    </div>
</div>