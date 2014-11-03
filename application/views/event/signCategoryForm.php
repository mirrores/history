<form action="/event/signCategoryForm" id="sign_category_form" method="post" >
    <table border="0" cellspacing="3" cellpadding="0" style="margin-top:0px;width: 98%"  >
        <tr>
            <td style="width:80px;text-align: right;padding-right: 5px;">* 分组名称：</td>
            <td colspan="2"><input name="name" style="width:300px;color: #666" class="input_text" value="<?=@$category['name']?>"></td>
        </tr>
        <tr>
            <td style="width:80px;text-align: right;padding-right: 5px;">* 分组说明：</td>
            <td colspan="2" valign="top"><textarea name="remarks" style="width:100%;height:50px; color: #666" class="input_text" ><?=@$category['remarks']?></textarea></td>
        </tr>
        <tr>
            <td></td><td>
                <input type="hidden" name="event_id" value="<?=$event_id?>" />
                <input type="hidden" name="category_id" value="<?=@$category['id']?>" />
                <input type="button" value="<?=@$category?'保存修改':'立即创建'?>"  class="button_blue" id="createcatbutton" onclick="<?=@$category?'updateSignCategroy();':'crateSignCategroy();'?>"/></td>
        </tr>
        <?php if(!$category):?>
        <tr>
            <td></td><td style="color:#f60;padding-bottom: 10px;padding-top: 5px">说明：分组创建后，您将自动成为组长(队长)，请您及时审核队员申请状况！</td>
        </tr>
        <?php else:?>
        <tr>
            <td></td><td style="color:#f60;padding-bottom: 10px;padding-top: 5px">说明：如需更换队长或合并队伍请直接与管理员联系，谢谢！</td>
        </tr>
        <?php endif;?>
</form>

<div id="sign_category_formstatusTools" style="clear:both;margin:5px;padding:5px;"></div>