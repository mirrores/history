<div id="sign_form_div" >
    <h1 style=" text-align: center; color: #EC5868" class="yahei">发布摄影作品</h1>

    <?php if ($wedding['is_upload_photography'] AND time() >= strtotime($wedding['photography_start']) AND time() <= strtotime($wedding['photography_finish'])): ?>
        <form action="/wedding/uploadphoto?id=<?= $_WID ?>" id="wedding_photography_form" method="post">
            <table style="width: 780px;margin: 10px auto">
                <tr>
                    <td colspan="4" class="td_title">
                        填写作者信息<span style="color: #999;font-weight: normal">(仅需填写一次)</span>
                    </td>
                </tr>
                <tr>
                    <td class="td_field">* 姓名</td>
                    <td><input type="text" name="author" class="text width250" maxlength="5" value="<?= $_SESS->get('uploader_author') ?>"></td>
                    <td class="td_field">* 毕业年份</td>
                    <td><input type="text" name="finish_year" class="text width250" maxlength="4" value="<?= $_SESS->get('uploader_finish_year') ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">* 学校及专业</td>
                    <td><input type="text" name="speciality" class="text width250" maxlength="20" value="<?= $_SESS->get('uploader_speciality') ?>"></td>
                    <td class="td_field">* 联系电话</td>
                    <td><input type="text" name="tel" class="text width250" maxlength="20" value="<?= $_SESS->get('uploader_tel') ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">电子邮箱</td>
                    <td><input type="text" name="email" class="text width250" maxlength="30" value="<?= $_SESS->get('uploader_email') ?>"></td>
                    <td class="td_field">* 单位或班级</td>
                    <td><input type="text" name="company" class="text width250" maxlength="20" value="<?= $_SESS->get('uploader_company') ?>"></td>
                </tr>
                <tr>
                    <td class="td_field">QQ</td>
                    <td><input type="text" name="qq" class="text width250" maxlength="15" value="<?= $_SESS->get('uploader_qq') ?>"></td>
                    <td class="td_field"></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="td_title">
                        选择并上传照片
                    </td>
                </tr>
                <tr>
                    <td colspan="1"  class="td_field">* 照片</td>
                    <td colspan="3" >
                        <div id="uploading1" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="/static/images/loading4.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
                        <input type="hidden" name="img_path" id="filepath1" value="" />
                        <input type="hidden" name="wedding_id" value="<?= $_WID ? $_WID : $_SESS->get('uploader_wedding_id') ?>" />
                        <input type="hidden" name="original_img_path" id="filepath_protected1" value="" />
                        <iframe  id="upfileframe1" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src="/upload/frameimg?xh=1&msg=建议单张原图不大于10M&resize=thumbnail_250_250,bmiddle_820_820,original_1000_1000,protected_4500_4500&return_file_size=thumbnail&prefix_path=/"></iframe>
                    </td>
                </tr>

                <tr>
                    <td class="td_field">* 标题</td>
                    <td colspan="3" style=" vertical-align: top">
                        <input type="text" name="title" id="photo_title" class="text"  maxlength="25"  value="<? // $_SESS->get('uploader_title') ?>" style="width:600px">
                    </td>
                </tr>
                <tr>
                    <td class="td_field">描述</td>
                    <td colspan="3" style=" vertical-align: top"><textarea name="intro" class="textarea" maxlength="255" id="photo_intro"><? //$_SESS->get('uploader_intro')  ?></textarea>
                        <br><div style="color: #999;margin: 5px 0"></div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style=" text-align: center"><br><br>
                        <input type="button"  class="btn btn-red" value="确定发布" id="submit_button" />
                        <a href="/wedding?id=<?= $_WID ?>"  class="btn" />取消</a>
                    </td>
                </tr>
            </table>
        </form>
    <?php else: ?>
        <div class="nodata">很抱歉，暂未开放或已经过期，谨请留意通知，谢谢！</div>
        <div style="text-align: center;padding: 10px"><a href="javascript:history.go(-1)" class="btn">返回</a></div>
    <?php endif; ?>
        
        <div style="padding: 20px;color: #666;line-height: 1.6em">
        
参赛作品要求：<br>
1、每份参赛作品须紧扣活动主题；<br>
2、以个人名义提交原创作品参赛，不得添加水印和边框；<br>
3、只限电子投稿，照片要求：JPG格式，每张最低2M、长边3000像素，每位参赛者限投5张照片。<br></div>
</div>


<div>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $btn = $('#submit_button');
        $btn.click(function() {
            new ajaxForm('wedding_photography_form', {textSending: '发送中', textError: '重试', textSuccess: '恭喜您上传成功！稍候继续上传...', callback: function(id) {
                    $('#filepath1').val('');
                    $('#filepath_protected1').val('');
                    $('#photo_title').val('');
                    $('#photo_intro').val('');
                    $btn.unbind("click");
                    setTimeout(function() {
                        window.location.href = '/wedding/uploadphoto?id=<?= $_WID ?>';
                    }, 2500);
                }}).send();
        });
    });
</script>