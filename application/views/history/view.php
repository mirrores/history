<!-- history/view:_body -->
<style type="text/css">
#history_table th{ background: #f8f8f8; border-bottom: 1px solid #ccc; height: 30px;line-height: 30px}
#history_table td{ border-bottom: 1px solid #eee; height: 30px;line-height: 30px}
</style>
<div id="main_left">
    <h1 style="color:#0066cc">历史沿革</h1>
    <div style="font-size: 16px; margin-left: 10px;">
         <font color="#0099ff"><?=$history['name']?></font>名称变更和重大事件如下所示：
    </div>
    <br>
       <table border="0" width="100%" id="history_table" cellspacing="0" cellpadding="0" style="margin-top: 20px">
	<thead>
	    <tr>
		<th style="text-align: center;width:18%">&nbsp;&nbsp;专业创办时间</th>
		<th  style="text-align: left">专业名称</th>
		<th  style="text-align: left">专业历史信息</th>
	    </tr>
	</thead>
	<tbody>
             <?php foreach($historys as $key=>$h):?>
                 <tr>
		<td style="text-align: center;"><?=$h['date']?></td>
		<td><?=$h['name']?></td>
		<td><?=$h['content']?></td>
	    </tr>
    <?php endforeach; ?>
	</tbody>
    </table>
</div>
 <div id="sidebar_right"  >
<p class="sidebar_title" >历史沿革</p>
<div class="sidebar_box">
    <ul>
        <li><a href="<?=URL::site('history/index')?>">专业搜索</a></li>
        <li><a href="<?=URL::site('history/from')?>">反馈</a></li>
    </ul>
</div>
 </div>

 <div class="clear"></div>
	