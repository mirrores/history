<div id="sign_form_div" >
    <?php if (!$error): ?>
    <h1 style=" text-align: center; color: #EC5868" class="yahei">在线报名</h1>
        <form action="/wedding/signsub" id="wedding_sign_form" method="post">
            <table style="width: 780px;margin: 10px auto">
                <tr>
                    <td colspan="4"  class="td_title">
                        <img src="/static/wedding/sign_base_info.png" alt="" />
                    </td>
                </tr>
                <tr>
                    <td class="td_field">新郎姓名</td>
                    <td><input type="text" name="bridegroom_name" class="text width250" maxlength="4" value="<?= @$user_sign['bridegroom_name'] ?>"></td>
                    <td class="td_field">新娘姓名</td>
                    <td><input type="text" name="bride_name" class="text width250" maxlength="4" value="<?= @$user_sign['bride_name'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">工作单位</td>
                    <td><input type="text" name="bridegroom_company" class="text width250" maxlength="60" value="<?= @$user_sign['bridegroom_company'] ?>"></td>
                    <td class="td_field">工作单位</td>
                    <td><input type="text" name="bride_company" class="text width250" maxlength="60" value="<?= @$user_sign['bride_company'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">手机</td>
                    <td><input type="text" name="bridegroom_mobile" class="text width250" maxlength="11" value="<?= @$user_sign['bridegroom_mobile'] ?>"></td>
                    <td class="td_field">手机</td>
                    <td><input type="text" name="bride_mobile" class="text width250" maxlength="11" value="<?= @$user_sign['bride_mobile'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">电子邮箱</td>
                    <td><input type="text" name="bridegroom_email" class="text width250" maxlength="40" value="<?= @$user_sign['bridegroom_email'] ?>"></td>
                    <td class="td_field">电子邮箱</td>
                    <td><input type="text" name="bride_email" class="text width250" maxlength="40" value="<?= @$user_sign['bride_email'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">QQ号</td>
                    <td><input type="text" name="bridegroom_qq" class="text width250" maxlength="20" value="<?= @$user_sign['bridegroom_qq'] ?>"></td>
                    <td class="td_field">QQ号</td>
                    <td><input type="text" name="bride_qq" class="text width250" maxlength="20" value="<?= @$user_sign['bride_qq'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">通讯地址</td>
                    <td><input type="text" name="bridegroom_address" class="text width250" maxlength="150" value="<?= @$user_sign['bridegroom_address'] ?>"></td>
                    <td class="td_field">通讯地址</td>
                    <td><input type="text" name="bride_address" class="text width250" maxlength="150" value="<?= @$user_sign['bride_address'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">邮编</td>
                    <td><input type="text" name="bridegroom_zipcode" class="text width250" maxlength="7" value="<?= @$user_sign['bridegroom_zipcode'] ?>"></td>
                    <td class="td_field">邮编</td>
                    <td><input type="text" name="bride_zipcode" class="text width250" maxlength="7" value="<?= @$user_sign['bride_zipcode'] ?>"></td>
                </tr>

                <tr>
                    <td class="td_field">爱情宣言</td>
                    <td colspan="3" style=" vertical-align: top"><textarea name="love_declaration" class="textarea" maxlength="255"><?= @$user_sign['love_declaration'] ?></textarea>
                        <br><div style="color: #999;margin: 5px 0">温馨提示：用于显示在新人展示位置，精彩的爱情宣言活动中可以获得更多的人气哦～</div>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" class="td_title">
                        <img src="/static/wedding/teacher.png" alt="" />
                    </td>
                </tr>
                <tr>
                    <td class="td_field">姓名</td>
                    <td><input type="text" name="teacher_name" class="text width250" maxlength="4" value="<?= @$user_sign['teacher_name'] ?>"></td>
                    <td class="td_field">所在院系/部门</td>
                    <td><input type="text" name="teacher_department" class="text width250" maxlength="100" value="<?= @$user_sign['teacher_department'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">联系电话</td>
                    <td><input type="text" name="teacher_tel" class="text width250" maxlength="15" value="<?= @$user_sign['teacher_tel'] ?>"></td>
                    <td class="td_field">电子邮箱</td>
                    <td><input type="text" name="teacher_email" class="text width250" maxlength="40" value="<?= @$user_sign['teacher_email'] ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">理由</td>
                    <td colspan="3" style=" vertical-align: top"><textarea name="teacher_reason" class="textarea" maxlength="250"><?= @$user_sign['teacher_reason'] ?></textarea></td>
                </tr>
                <tr>
                    <td colspan="4" class="td_title">
                        <img src="/static/wedding/muxiao.png" alt="" />
                    </td>
                </tr>
                <tr>
                    <td class="td_field"></td>
                    <td colspan="3">
                        <textarea name="said_alma_mater" class="textarea"><?= @$user_sign['said_alma_mater'] ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" class="td_title">
                        <img src="/static/wedding/title_photo.png" alt="" />
                    </td>
                </tr>
                <tr>
                    <td colspan="1"  class="td_field">毕业证书</td>
                    <td colspan="3" >
                        <div id="uploading1" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="/static/images/loading4.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                        <input type="hidden" name="diploma_path" id="filepath1" value="<?= @$user_sign['diploma_path'] ?>" />
                        <iframe  id="upfileframe1" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src="/upload/frameimg?xh=1&msg=上传毕业照扫描文件，图片不大于2M&resize=original_1600_1600&return_file_size=original&prefix_path=/"></iframe>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"  class="td_field">结婚证</td>
                    <td colspan="3" >
                        <div id="uploading2" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="/static/images/loading4.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                        <input type="hidden" name="marriage_certificate_path" id="filepath2" value="<?= @$user_sign['marriage_certificate_path'] ?>" />
                        <iframe  id="upfileframe2" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src="/upload/frameimg?xh=2&msg=结婚证扫描图片且不大于2M&resize=original_1600_1600&return_file_size=original&prefix_path=/"></iframe>
                    </td>
                </tr>
                <tr>
                    <td colspan="1"  class="td_field">照片</td>
                    <td colspan="3" >
                        <div id="uploading3" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="/static/images/loading4.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                        <input type="hidden" name="photo_path" id="filepath3" value="<?= @$user_sign['photo_path'] ?>" />
                        <iframe  id="upfileframe3" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src="/upload/frameimg?xh=3&msg=婚纱或生活照，图片不大于2M&resize=thumbnail_250_250,original_1600_1600&return_file_size=thumbnail&prefix_path=/"></iframe>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style=" text-align: center"><br><br>
                        <input type="button"  class="btn btn-red" value="<?= $user_sign ? '保存修改' : '立即报名' ?>" id="submit_button" />
                        <?php if ($user_sign): ?><input type="button"  class="btn" value="取消报名" id="cancel_submit_button" /><?php endif; ?>
                        <a href="/wedding/<?= $wedding['year'] ?>"  class="btn" />取消</a>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="wedding_id" value="<?= $wedding['id'] ?>">
            <input type="hidden" name="sign_action" value="<?= $user_sign ? 'update' : 'add'; ?>" >
        </form>
    <?php else: ?>

    <div class="yahei" style="text-align: center;color: #ff0000;height: 200px;line-height: 200px;font-size: 18px"> <i class="fa fa-frown-o"></i> <?=$error?></div>
    <?php endif; ?>

</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#submit_button').click(function() {
            new ajaxForm('wedding_sign_form', {textSending: '发送中', textError: '重试', textSuccess: '<?=$user_sign?"修改成功":"报名成功"?>', callback: function(id) {
                    setTimeout(function(){
                        window.location.href = '/wedding/<?= $wedding['year'] ?>';
                    },1000);
                }}).send();
        });
        $('#cancel_submit_button').click(function() {
            new candyConfirm({
                title: '取消确认',
                message: '您确定要取消本次活动报名吗？',
                url: '/wedding/cancelSign?wid=<?= $wedding['id'] ?>',
                callback: function() {
                    setTimeout(function(){
                        window.location.href = '/wedding/<?= $wedding['year'] ?>';
                    },1000);
                }
            }).open();
        });
    });
</script>