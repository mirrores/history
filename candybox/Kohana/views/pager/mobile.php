<?php
$link_span = 2;
$start_link = ($current_page - $link_span) > 0 ? ($current_page - $link_span) : 1;
$last_link = ($current_page + $link_span) > $total_pages ? $total_pages : ($current_page + $link_span);
?>
<div class="comment_pager">

        <?php if ($first_page !== FALSE): ?>
                <a href="<?php echo $page->url($first_page) ?>" title="第一页"><?php echo '第一页' ?></a>
        <?php else: ?>
                <?php //echo __('First') ?>
        <?php endif ?>

        <?php if ($previous_page !== FALSE): ?>
                <a href="<?php echo $page->url($previous_page) ?>" title="上一页">上一页</a>
        <?php else: ?>
                <?php //echo __('Previous') ?>
        <?php endif ?>

        <?php for ($i = $start_link; $i <= $last_link; $i++): ?>
                <?php if ($i == $current_page): ?>
                        <span style="font-weight: bold"><?php echo $i ?></span>
                <?php else: ?>
                        <a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
                <?php endif ?>
        <?php endfor ?>

        <?php if ($next_page !== FALSE): ?>
                <a href="<?php echo $page->url($next_page) ?>" title="下一页">下一页</a>
        <?php else: ?>
                <?php //echo __('Next') ?>
        <?php endif ?>
</div>