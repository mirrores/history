<!-- publication/index:_body -->
<div id="main_left">
    <p><img src="/static/images/publication_title.gif"></p>
    <div id="pub_list">
	<ul>
	    <?php foreach($publication AS $p):?>
	    <li>
		<a href="<?=URL::site('publication/list?pub_id='.$p['id'])?>">
		    <img src="<?=$p['cover']?>" width="120" height="162"/>
		</a>
		<br>
		<?=$p['issue']?>
	    </li>
	    <?php endforeach;?>
	</ul>
	<div class="clear"></div>
	<div><?=$pager?></div>
    </div>
</div>
<div id="sidebar_right">
<?php include 'sidebar.php';?>
</div>
<div class="clear"></div>