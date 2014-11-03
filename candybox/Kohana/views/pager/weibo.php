<?php
    $link_span = 5;
    $goto_page_id='page_' . rand(1,1000);
    $start_link = ($current_page - $link_span) > 0 ? ($current_page - $link_span) : 1;
    $last_link = ($current_page + $link_span) > $total_pages ? $total_pages : ($current_page + $link_span);
?>
<div class="comment_pager" style="padding-left:0px; margin-left: 0px;*margin:20px 0px 0px 0px;*padding:0px" >
   
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
  

</div><!-- .pagination -->