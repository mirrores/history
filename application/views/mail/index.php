<!-- mail/index:_body -->
<!--left -->
<div id="main_left">
    <p><img src="/static/images/mail_title.gif"></p>
    <?php if (!$mail): ?>
        <form method="post" action="<?= URL::site('mail/apply') ?>" name="mail_form" id="mail_form">

            <table width="100%" style="margin: 10px 20px" >
                <tbody>
                    <tr>
                        <td colspan="2"> <h2 id="plugin_title">申请邮箱</h2></td>
                    </tr>
                    <tr>
                        <td style="text-align:right; width: 80px; padding-top: 10px"  valign="top">登录名：</td>
                        <td ><input type="text" class="input_text" style="width:260px" name="username" AUTOCOMPLETE="OFF" maxlength="30">&nbsp;<span ><img src="/static/images/zuaamail.gif" style="vertical-align:middle"></span><br>
                            <p style="color:#999;margin-top: 2px;margin-bottom: 10px" >4~16个字符，包括字母、数字、下划线，以字母开头，字母或数字结尾</p></td>
                    </tr>

                    <tr>
                        <td style="text-align:right; width: 80px; padding-top: 10px"  valign="top" >密码：</td> 
                        <td ><input type="password" class="input_text" style="width:260px" name="password" AUTOCOMPLETE="OFF" maxlength="25">
                            <br><p style="color:#999;margin-top: 2px;margin-bottom: 10px">6~16个字符，包括字母、数字、特殊符号，区分大小写</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="text-align:right; width: 80px; padding-top: 10px"  valign="top" >确认密码：</td>
                        <td ><input type="password" class="input_text" style="width:260px" name="password2" AUTOCOMPLETE="OFF" maxlength="25"  >
                            <br><p style="color:#999;margin-top: 2px;margin-bottom: 10px">再次输入密码</p>
                        </td>
                    </tr>

                    <tr>
                        <td></td>
                        <td ><input type="button" id="submit_button" class="button_blue" value="申请"  onclick="applymail()"  > <input type="button" class="button_gray" value="取消" onclick="window.history.go(-1)"></td>
                    </tr>

                    <tr style="">
                        <td></td>
                        <td style="line-height:1.7em"><br><a href="http://mail.zuaa.zju.edu.cn" target="_blank">已经有帐号，现在就登录</a>
                        </td>
                    </tr>
                    <tr style="display:none">
                        <td></td>
                        <td style="line-height:1.7em"><br><a href="<?= URL::site('user_mail') ?>">我已经申请过了，现在想绑定邮箱</a>
                            <span style="color:#f30"><br>温馨提示：绑定邮箱后下次可直接进入邮箱。</span></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <script type="text/javascript">
            document.getElementById('mail_form').reset();
            function applymail() {
                new ajaxForm('mail_form', {
                    callback: function(data) {
                        if (data == 'temp_ok') {
                            okAlert('恭喜您，邮箱已经申请成功，请等待管理员正式开通！<br>邮箱正式开通后，将以邮件形式发送给您目前帐号！');
                            $('#submit_button').attr('disabled',true);
                        }
                    }
                }).send();
            }
        </script>

    <?php else: ?>
        <script type="text/javascript">
            window.location.href = 'http://mail.zuaa.zju.edu.cn';
        </script>
    <?php endif; ?>
</div>