<div class="gonggao2">
    <?php if($_A=='test' OR $_A=='signs'): ?>
        <div style="width: 900px;margin: 0 auto;padding-top: 20px"><a href="/wedding/?id=<?=$wedding['id']?>"> << 返回婚礼首页</a></div>
    <?php else: ?>
            <div style="width: 900px;margin: 0 auto;padding-top: 20px"><a href="/wedding/<?=$wedding['year']?>"> << 返回婚礼首页</a></div>
    <?php endif; ?>
</div>