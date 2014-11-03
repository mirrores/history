<form id="del_sign_form" name="del_sign_form" action="<?= URL::site('event/delsign') ?>" method="post" >
    <table width=500 border="0" cellspacing="3" cellpadding="0" style="margin-top:0px;">
        <tr>
            <td colspan="2"><label><input type="radio" name="notic" value="none" checked/>不发送任何通知</label></td>
        </tr>
        <tr>
            <td colspan="2"><label><input type="radio" name="notic" value="msg" />只发送站内信</label></td>
        </tr>
        <tr>
            <td colspan="2"><label><input type="radio" name="notic" value="msg_mail" />同时发送站内信和邮件</label></td>
        </tr>
        <tr class="notic_remarks" style="display: none">
            <td><textarea name="remarks" style="width:100%;height:80px; color: #666" class="input_text" >亲爱的<?=$sign_user['realname']?>校友，您好！很抱歉的通知您，由于您暂时还未满足《<?=$event['title']?>》活动报名条件，因此我们取消了您的报名资格，在次对您表示歉意，如有疑问，请与活动发起者联系。再次感谢您对我们活动的支持与参与，谢谢！（系统自动发送）</textarea></td>
        </tr>
    </table>
    <input type="hidden" name="sign_id" value="<?= $sign['id'] ?>">
</form>
