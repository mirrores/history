<!--main -->
<script type="text/javascript">
    function setTab(name,cursel,n){
        for(i=1;i<=n;i++){
            var menu=document.getElementById(name+i);
            var con=document.getElementById("con_"+name+"_"+i);
            menu.className=i==cursel?"cur":"";
            con.style.display=i==cursel?"block":"none";
        }
    }
</script>
<script type="text/javascript" src="/static/js/title_style.js"></script>
<p><img src="/static/images/aa_title.gif"></p>
<div class="blue_tab" style="margin: 15px 20px">
    <ul>
        <li><a href="<?= URL::site('aa') ?>" id="one1"  >校友总会</a></li>
        <li><a href="<?= URL::site('aa/branch') ?>" id="one2"   class="cur">地方校友会</a></li>
        <li><a href="<?= URL::site('aa/institute') ?>" id="one3" >院系分会</a></li>
        <li><a href="<?= URL::site('aa/club') ?>" id="one4" >俱乐部</a></li>
        <li><a href="<?= URL::site('aa/association') ?>" id="one5" >学生协会</a></li>

    </ul>
</div>

<!--各地校友 -->
<?php $aa_group = Kohana::config('aa_group'); ?>
<div id="con_one_2" class="tab_content" >
    <div class="title" >国内各地校友会</div>

    <?php foreach ($aa_group[0] as $g) : ?>
        <div class="aa_district">
            <div class="name"><?= $g['name'] ?>：</div>
            <div class="city">
                <?php foreach ($all_aa as $a): ?>
                    <?php if ($g['id'] == $a['group']): ?>
                        <a href="<?= URL::site('aa_home?id=' . $a['id']) ?>"  onmouseover='wsug(event,"<?= $a['sname'] ?>校友会<br>联系人：<?= $a['contacts'] ? $a['contacts'] : '-'; ?><br>电话：<?= $a['tel'] ? $a['tel'] : '-'; ?><br>邮件：<?= $a['email'] ? $a['email'] : '-'; ?><br>地址：<?= $a['address'] ? htmlspecialchars(trim($a['address'])) : '-'; ?>")' onmouseout='wsug(event, 0)' ><?= Text::limit_chars($a['sname'], 3, '..') ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>


    <div class="title" >国外主要校友会</div>

    <?php foreach ($aa_group[1] as $g) : ?>
        <div class="aa_district">
            <div class="name"><?= $g['name'] ?>：</div>
            <div class="city">
                <?php foreach ($all_aa as $a): ?>
                    <?php if ($g['id'] == $a['group']): ?>
                        <a href="<?= URL::site('aa_home?id=' . $a['id']) ?>" onmouseover='wsug(event, "<?= $a['sname'] ?>校友会<br>联系人：<?= $a['contacts'] ? $a['contacts'] : '-'; ?><br>电话：<?= $a['tel'] ? $a['tel'] : '-'; ?><br>邮件：<?= $a['email'] ? $a['email'] : '-'; ?><br>地址：<?= $a['address'] ? htmlspecialchars(trim($a['address'])) : '-'; ?>")' onmouseout="wsug(event, 0)"><?= Text::limit_chars($a['sname'], 3, '..') ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    <?php endforeach; ?>

</div>
<!--//各地校友组织 -->
