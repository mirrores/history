//简单的ajax表单提交
(function($, window, undefined) {
    var ajaxForm = function(opts) {
        var def = {successLabel: '发送成功', url: '/user/check', dataType: 'html'}
        this.form = $('#' + formid) || $('form');
        this.opts = $.extend({}, def, opts);
        this.formdata = this.form.serialize();
    }
    //发送前执行
    ajaxForm.prototype.before = function() {
        this.submitButton = $form.find(':submit');
        this.submitButton.val('提交中...');
    }
    //请求成功回执函数
    ajaxForm.prototype.success = function(data) {
        $('#message').html(this.opts.successLabel);
    }
    //
    ajaxForm.prototype.send = function() {
        var _this = this;
        $.ajax({
            url: this.opts.url, //无错
            before: this.before, //引用ajaxForm.before方法
            success: this.success, //执行到这里错误，success内部this方法出错了
            type: 'post',
            data: this.formdata
        })
    }
    window.ajaxForm = ajaxForm;
})(jQuery, window)

//实例
new ajaxForm().send();