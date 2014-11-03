<!-- admin_history/professionalform:_body -->
<script type="text/javascript" src="<?= URL::site('/static/js/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= URL::site('/static/css/jquery-ui.css') ?>">
<?php
$action = 'history/professionalcreate';
if ($history_professional) {
    $action = 'history/professionalupdate';
}
?>

<form action="<?= URL::site($action) ?>" id="history_form" method="post"  >
    <table class="admin_table" border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td colspan="2" class="td_title"><?= $history_professional ? '编辑专业信息' : '添加专业信息'; ?></td>
        </tr>
        <tr>
            <td class="field">学部名称：</td>
            <td>
                <select name="depart_id" id="depart_id">
                    <option >请选择</option>
                    <?php foreach ($history_depart as $d): ?>
                        <option value="<?= $d['id'] ?>"  <?= $history_professional['depart_id'] === $d['id'] ? 'selected' : '' ?>><?= $d['name'] ?></option>
                    <?php endforeach; ?>
                </select>

            </td>
        </tr>
        <tr>
            <td class="field">院系名称：</td>
            <td>
                <select name="college_id" id="college_id">
                    <option >请选择</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="field">专业名称：</td>
            <td>
                <input type="text" name="name" value="<?= $history_professional['name'] ?>"  style="width:450px" class="input_text" />
            </td>
        </tr>
        <td style="padding:20px; text-align: center" colspan="2" >
            <input type="hidden" name="id" value="<?= $history_professional['id'] ?>" />
            <input type="hidden" id="is_draft" name="is_draft" value="0" />
            <?php if ($history_professional): ?>
                <input type="button" id="submit_button" value="保存修改" name="button" class="button_blue" onclick="post_history()" />
            <?php else: ?>
                <input type="button" id="submit_button" value="添加" name="button" class="button_blue" onclick="post_history()" />
            <?php endif; ?>


            <input type="button" value="取消" onclick="window.history.back()" class="button_gray">
            <input type="hidden" value="sys_admin" name="create_from">
        </td>
        </tr>

    </table><br>
    <?php if ($err): ?>
        <div class="notice"><?= $err; ?></div>
    <?php endif; ?>
</form>


<script type="text/javascript">
    $(document).ready(function() {
        $("#depart_id").change(function() {
            $.ajax({
                type: 'post',
                url: "<?= URL::site('/admin_history/collegeid') ?>",
                dataType: "json",
                data: {
                    depart_id: $("#depart_id").val()
                },
                success: function(data) {
                    if (data != "0") {
                        var college_id = document.getElementById('college_id');
                        //清空数组  
                        college_id.length = 0;
                        for (var i = 0; i < data.length; i++) {
                            var xValue = data[i].id;
                            var xText = data[i].name;
                            var option = new Option(xText, xValue);
                            college_id.add(option);
                        }
                    } else {
                        var college_id = document.getElementById('college_id');
                        college_id.length = 0;
                    }

                }
            });
        });
    })


</script>
<script type="text/javascript">
    function post_history() {
        var form = new ajaxForm('history_form', {
            textSending: '发送中',
            textError: '发布失败',
            loading: true,
            textSuccess: '发布成功',
            callback: function(id) {
                window.location.href = '/admin_history/professional';
            }});
        form.send();
    }

    function save_history(is_draft) {
        if (!ueditor.hasContents()) {
            ueditor.setContent('');
        }
        ueditor.sync();
        if ($defined(is_draft)) {
            history_form.setOptions({textSuccess: '在' + (new Date()).fmt("hh:mm:ss") + '保存为草稿'})
            $('is_draft').set('value', 1);
            history_form.setOptions({btnSubmit: 'save_as_draft'});
        }
        history_form.send();
    }
</script>