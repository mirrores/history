<style type="text/css">
#wish { width: 100%; height:600px; margin: 5px; position: relative;margin:5px auto}
</style>

<div style="margin: 10px 0">
    <div style="width: 200px;float: left"><img src="/static/images/wedding/2014/zhufuqiang.jpg" alt=""  style="width:250px"/></div>
    <div style="width: 300px;float:right;margin: 30px 20px 0 0;text-align: right">
        <a href="javascript:write_wish(<?= $wedding['id'] ?>)"  class="btn btn-green"  />发祝福获抽奖机会</a>
    </div>
    <div class="clear"></div>
</div>

<div id="wish">
    <div>1. text</div>
    <div>2. text</div>
    <div>3. text</div>
    <div>4. text</div>
    <div>5. text</div>
    <div>6. text</div>
    <div>7. text</div>
    <div>8. text</div>
    <div>9. text</div>
    <div>10. text</div>
    <div>11. text</div>
    <div>7. text</div>
    <div>8. text</div>
    <div>9. text</div>
    <div>10. text</div>
    <div>11. text</div>
    <div>7. text</div>
    <div>8. text</div>
    <div>9. text</div>
    <div>10. text</div>
    <div>11. text</div>
    <div>7. text</div>
    <div>8. text</div>
    <div>9. text</div>
    <div>10. text</div>
    <div>11. text</div>
</div>

<script type="text/javascript">
    $('#wish').wish();
    $('.wish').draggable({containment: "#wish", scroll: false});
</script>