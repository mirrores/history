<!-- classroom/create:body -->
<div>
    <div id="main_left">
        <p><img src="/static/images/class_title.gif" /></p>

        <div style="margin: 15px 10px">
            <h3>新建班级：</h3>
            <?php if ($success): ?>
                <p style="color:#006600">恭喜您，班级创建成功，请等待管理员审核。<a href="<?= URL::site('classroom') ?>">返回班级录</a></p>
            <?php else: ?>

                <form id="classroom_form" method="post" action="<?= URL::site('classroom/create') ?>">
                    <table>
                        <tr>
                            <td style="text-align:right;width:150px"><span style="color:#f00">*</span>&nbsp;入学及毕业年份：</td>
                            <td><input type="text" name="start_year" style="width:80px" class="input_text"> ~ <input type="text" name="finish_year" style="width:80px" class="input_text">&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">提示：毕业年份可以不填</span></td>
                        </tr>

                        <tr>
                            <td style="text-align:right"><span style="color:#f00">*</span>&nbsp;专业名称：</td>
                            <td><input type="text" name="speciality" style="width:300px" class="input_text">&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">例如：机械设计与制造</span></td>
                        </tr>

                        <tr>
                            <td style="text-align:right"><span style="color:#f00">*</span>&nbsp;所属学院(系)：</td>
                            <td><input type="text" name="institute" style="width:300px" class="input_text">&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#999">例如：工程技术学院</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <input type="button" value="确定创建"  class="button_blue" id="submit_button" onclick="create_class()"/>
                                <input type="button" onclick="window.history.back();" class="button_gray" value="取消">
                            </td>
                        </tr>
                    </table>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="clear"></div>
</div>
<script type="text/javascript">
                                function create_class() {
                                    new ajaxForm('classroom_form', {
                                        callback: function(classroom_id) {
                                            if (classroom_id != "0") {
                                                window.location.href = '/classroom_home?id=' + classroom_id;
                                            } else {
                                                window.location.href = '/classroom/create?success=1';
                                            }
                                        }
                                    }).send();
                                }
</script>