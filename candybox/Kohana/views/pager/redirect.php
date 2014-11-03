<?php
    $link_span = 4;
    $start_link = ($current_page - $link_span) > 0 ? ($current_page - $link_span) : 1;
    $last_link = ($current_page + $link_span) > $total_pages ? $total_pages : ($current_page + $link_span);
?>
<div class="comment_pager">
    <span class="total" >共&nbsp;<?=$total_items?>&nbsp;条记录&nbsp;</span>
	<?php if ($first_page !== FALSE): ?>
		<a href="<?php echo $page->url($first_page) ?>" title="第一页"><?php echo '第一页' ?></a>
	<?php else: ?>
		<?php //echo __('First') ?>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a href="<?php echo $page->url($previous_page) ?>" title="上一页"><?php echo '&lt;' ?></a>
	<?php else: ?>
		<?php //echo __('Previous') ?>
	<?php endif ?>

	<?php for ($i = $start_link; $i <= $last_link; $i++): ?>
		<?php if ($i == $current_page): ?>
			<strong><?php echo $i ?></strong>
		<?php else: ?>
			<a href="<?php echo $page->url($i) ?>"><?php echo $i ?></a>
		<?php endif ?>
	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?>
		<a href="<?php echo $page->url($next_page) ?>" title="下一页"><?php echo '&gt;' ?></a>
	<?php else: ?>
		<?php //echo __('Next') ?>
	<?php endif ?>

    <select name="redirect_page" id="redirect_page" style="color: #666" onchange="window.location='<?=$page->url()?>&page='+this.value;">
      <?php for($i=1;$i<=$total_pages;$i++):?>
      <option value="<?=$i?>" <?php if($i==$current_page):?>selected<?php endif;?>>第<?=$i?>页</option>
      <?php endfor;?>
  </select>

	<?php if ($last_page !== FALSE): ?>
		<a href="<?php echo $page->url($last_page) ?>" title="最后一页"><?php echo '最后一页 ' ?></a>
	<?php else: ?>
		<?php //echo __('Last') ?>
	<?php endif ?>
</div><!-- .pagination -->