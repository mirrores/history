<!-- history/from:_body -->
<form action="<?= URL::site('history/usercreate') ?>" id="history_form" method="post"  >
    <table class="admin_table" border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td colspan="2" class="td_title"> 添加反馈信息</td>
        </tr>
       <tr>
            <td style="text-align: center">图片</td>
            <td>
                <input type="hidden" name="imgage" id="filepath" value="<?= $historyalumnis['imgage'] ?>" />
                <iframe  id="upfileframe" name="upfileframe" scrolling="no" style="width:500px; height:30px; display:inline" frameborder="0" src="<?= URL::site('upload/frameimg?return_file_size=original') ?>"></iframe>
                <div id="uploading" style="display:none; color:#3993E0;width:600px; height:30px;"><img src="/static/images/loading4.gif"  hspace="4" align="absmiddle"  />正在上传中，请稍候...</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding:10px 20px;"  valign="top">
                <div style="height: 380px;">
                    <textarea id="content" name="content" style="width:99%;height:320px"><?= @$historyalumnis['content'] ?></textarea>
                </div>
                <p style="margin:10px 0">
                    说明：按回车(Enter)为添加段落，段落开始位置自动增加标准缩进，请勿再次添加空格，按Shift+Enter为换行。
                </p>
            </td>
        </tr>
        <tr>
            <td style="padding:20px; text-align: center" colspan="2" >

                <input type="hidden" name="id" value="<?= @$historyalumni['id'] ?>" />
                <input type="hidden" name="user_id" value="<?= @$historyalumni['user_id'] ? $historyalumni['user_id'] : $_UID ?>" />
                <input type="hidden" id="is_draft" name="is_draft" value="0" />
                <input type="hidden" name="create_date" value="<?=@$historyalumni['create_date'] ? $historyalumni['create_date'] : date('Y-m-d H:i:s') ?>" />

               
                    <input type="button" id="submit_button" value="立即反馈" name="button" class="button_blue" onclick="post_history()" />
              


                <input type="button" value="取消" onclick="window.history.back()" class="button_gray">
               
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
                window.location.href = '/history/index';
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