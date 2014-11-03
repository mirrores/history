<div class="first_prize">
    <div class="first_tit">一等奖</div>
    <!--图片轮播-->
    <div class="scrolllist" id="s1">
        <a class="abtn aleft" href="#left" title="左移"></a>
        <div class="imglist_w">
            <ul class="imglist">
                <?php if ($first_prize): ?>
                    <?php foreach ($first_prize as $key => $p): ?>
                        <li style=" text-align: center">
                            <img height="500" src="<?= str_replace('_thumbnail', '_bmiddle', $p['img_path']) ?>" style="max-height: 500px;max-width: 820px ">
                            <p><?= Text::limit_chars(trim($p['title']), 15) ?> — <?= $p['author'] ?></p>
                            <div class="imglistbgdiv"></div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul><!--imglist end-->
        </div>
        <a class="abtn aright" href="#right" title="右移"></a>
    </div><!--scrolllist end-->
</div>