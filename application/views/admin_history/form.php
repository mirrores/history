<!-- admin_history/form:_body -->
<script type="text/javascript" src="<?= URL::site('/static/js/jquery-ui.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= URL::site('/static/css/jquery-ui.css') ?>">
<?php
$action = 'history/create';
if ($history) {
    $action = 'history/update';
}
?>

<form action="<?= URL::site($action) ?>" id="history_form" method="post"  >
    <table class="admin_table" border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td colspan="2" class="td_title"><?= $history ? '编辑专业信息' : '添加专业信息'; ?></td>
        </tr>

        <tr>
            <td class="field">学部名称：</td>
            <td>
                <select name="depart_id" id="depart_id">
                    <option>请选择</option>
                    <?php foreach ($history_depart as $d): ?>
                        <option value="<?= $d['id'] ?>"  <?= $history['depart_id'] === $d['id'] ? 'selected' : '' ?>><?= $d['name'] ?></option>
                    <?php endforeach; ?>
                </select>

            </td>
        </tr>

        <tr>
            <td class="field">院系名称：</td>
            <td>
                <select name="college_id" id="college_id">
                    <option>请选择</option>
            </td>
        </tr>
        <tr>
            <td class="field">专业名称：</td>
            <td><input type="text" name="name" value="<?= $history['name'] ?>"  style="width:450px" class="input_text" /></td>
        </tr>
        <tr>
            <td class="field">专业创办时间：</td>
            <td><input type="text" name="date" value="<?= $history['date'] ?>"  style="width:450px" class="input_text" /></td>
        </tr>
        <tr>
            <td class="field">专业字母：</td>
            <td><input type="text" name="grapheme" value="<?= $history['grapheme'] ?>"  style="width:450px" class="input_text" /><span style="color:#999"> 用于字母搜索排序</span></td>
        </tr>
        <tr>
            <td class="field">现在所属专业名称：</td>
            <td>
                <input type="text" name="professional_id" id="professional_id" value="<?= $history['professional_id'] ?>"  style="width:450px" class="input_text" />
                <span id="professional_name"></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:10px 20px;"  valign="top">
                <div style="height: 380px;">
                    <textarea id="content" name="content" style="width:99%;height:320px"><?= @$history['content'] ?></textarea>
                </div>
                <p style="margin:10px 0">
                    说明：按回车(Enter)为添加段落，段落开始位置自动增加标准缩进，请勿再次添加空格，按Shift+Enter为换行。
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:20px; text-align: center" colspan="2" >

                <input type="hidden" name="id" value="<?= @$history['id'] ?>" />
                <input type="hidden" id="is_draft" name="is_draft" value="0" />
                <input type="hidden" name="create_date" value="<?=@$history['create_date'] ? $history['create_date'] : date('Y-m-d H:i:s') ?>" />

                <?php if ($history): ?>
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


<?=
View::ueditor('content', array(
    'toolbars' => Kohana::config('ueditor.common'),
    'minFrameHeight' => 450,
    'autoHeightEnabled' => 'false',
    'enterTag' => 'p',
    'initialStyle' => '"body{font-size:14px;} p{text-indent:28px;margin-bottom:15px}"'
));
?>


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
    $("#professional_id").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "<?= URL::site('admin_history/autocomplete') ?>",
                dataType: "json",
                data: {
                    searchDbInforItem: request.term
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#professional_name").html(ui.item.label);
        }
    });
</script>
<script>


    function post_history() {
        if (!ueditor.hasContents()) {
            ueditor.setContent('');
        }
        ueditor.sync();
        var form = new ajaxForm('history_form', {
            textSending: '发送中',
            textError: '发布失败',
            loading: true,
            textSuccess: '发布成功',
            callback: function(id) {
                window.location.href = '/admin_history/index';
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


