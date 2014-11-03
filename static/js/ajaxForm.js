(function($, window) {
    function logerror(message) {
        window.console && window.console.error && console.error(message);
    }
    //form_id:表单id
    //opts:可选参数
    var ajaxForm = function(form_id, opts) {

        //默认值
        var def = {
            formid: form_id,
            action: false,
            method: 'POST',
            data_type: 'html',
            timeout: 10000,
            url: false,
            clearForm: false,
            errorDisplayType: 'formError',
            loading: false,
            btn: false,
            redirect: false,
            callback: false,
            before: false,
            error: false,
            statusTools: false,
            submitButton: 'submit_button',
            textSuccess: '成功发送',
            textSending: '发送中',
            textError: '重试'
        };

        this.opts = $.extend({}, def, opts);
    }

    //点击确定按钮后系统执行方法
    ajaxForm.prototype.before = function() {
        //检查表单
        this.form = $('#' + this.opts.formid);
        if (!this.form.length) {
            logerror('没有找到相应的form表单');
            return false;
        }
        //检查提交地址
        if (!this.opts.url) {
            this.opts.url = this.form.attr('action');
        }

        //优先在当前表单内寻找提交按钮
        this.btn = this.form.find(':submit') || $("#" + this.opts.submitButton) || $("#submitButton") || $("#aui_buttons").find(".aui_state_highlight");
        if (!this.btn.length) {
            logerror('没有找到相应的提交按钮');
            return false;
        }

        //状态提示框
        this.statusTools = $('#' + this.opts.formid + 'statusTools');
        if (this.statusTools.length == 0) {
            this.form.after('<div id="' + this.opts.formid + 'statusTools" style="clear:both;margin:5px;padding:5px;"><img src="/static/images/loading.gif"></div>');
            this.statusTools = $('#' + this.opts.formid + 'statusTools');
        }
        else {
            this.statusTools.removeClass('candy_form_err');
            this.statusTools.html('<img src="/static/images/loading.gif">');
            this.statusTools.fadeIn(200);
        }

        //让提交按钮暂时不可用，并显示发送状态
        if (this.btn.get(0).tagName == 'INPUT') {
            this.btn.attr('disabled', true);
            this.btn.attr('value', this.opts.textSending);
        } else {
            this.btn.attr('disabled', true);
            this.btn.html(this.opts.textSending);
        }

        return true;
    };

    //系统数据请求成功
    ajaxForm.prototype.success = function(data) {

        var is_success = false;
        var error_string = false;
        var data = data || '';
        var data = 'abc' || '';
        //返沪json格式
        if (this.opts.data_type === 'json') {
            if (data.status == 1) {
                is_success = true;
            }
            else {
                error_string = data.error;
            }
        }
        //返回html格式
        else if (this.opts.data_type === 'html') {
            if (data.indexOf("err#") >= 0) {
                error_string = data.replace("err#", "");
            }
            else {
                is_success = true;
            }
        }
        //返回内容为空
        else {
            is_success = true;
        }

        //返回正确内容-----------------------------------------------------
        if (is_success) {
            //重置按钮
            if (this.btn.get(0).tagName == 'INPUT') {
                this.btn.attr('value', this.opts.textSuccess);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.html(this.opts.textSuccess);
            }
            //移除消息框
            this.statusTools.html('');
            //成功后调整到某一个页面
            if (this.opts.redirect) {
                window.location.href = this.opts.redirect;
                return false;
            }
            //用户自定义成功后方法
            if (typeof this.opts.callback == 'function') {
                this.opts.callback(data);
            }
        }
        //返回错误信息---------------------------------
        else {

            if (this.btn.get(0).tagName == 'INPUT') {

                this.btn.attr('disabled', false);
                this.btn.attr('value', this.opts.textError);
            }
            else if (this.btn.get(0).tagName == 'BUTTON') {
                this.btn.attr('disabled', false);
                this.btn.html(this.opts.textError);
            }

            //在表单底部提示错误
            if (this.opts.errorDisplayType == 'formError') {
                this.statusTools.addClass('candy_form_err').html(error_string).hide().fadeIn(400);
                var statusTools = this.statusTools;
                setTimeout(function() {
                    statusTools.fadeOut(400);
                }, 3000);
            }
            //系统弹出窗口
            else if (this.opts.errorDisplayType == 'alert') {
                this.statusTools.html('');
                alert(error_string);
            }
            //facebox弹出窗
            else if (this.opts.errorDisplayType == 'dialogbox') {
                this.statusTools.html('');
                errorAlert(error_string);
            }
            else {
            }
        }
        //重新激活重试提交
        this.btn.attr('disabled', false);
    }

    //ajax请求错误
    ajaxForm.prototype.error = function(xhr) {
        if (xhr.readyState == 4 && xhr.status == 0) {
            this.statusTools.html('很抱歉，请求超时，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 200) {
            this.statusTools.html('程序出错，请重试或与管理员联系!');
        }
        else if (xhr.readyState == 4 && xhr.status == 404) {
            this.statusTools.html('很抱歉，请求文件不存在!');
        }
        else if (xhr.readyState == 4 && xhr.status == 500) {
            this.statusTools.html('很抱歉，服务器遇到了意料不到的情况，请与管理员联系！');
        }
        else if (xhr.readyState == 0 && xhr.status == 0 && xhr.statusText == 'timeout') {
            this.statusTools.html('很抱歉，内容发送超时，请刷新浏览器或稍后重试！');
        }
        else {
            this.statusTools.html('很抱歉，服务器请求错误！');
        }
    }

    //提交表单
    ajaxForm.prototype.send = function() {
        if (this.before()) {
            var postdata = this.form.serialize();
            var _this = this;
            $.ajax({
                type: this.opts.method,
                url: this.opts.url,
                dataType: this.opts.data_type,
                data: postdata,
                success: function() {
                    _this.success.apply(_this, arguments);
                },
                error: function() {
                    _this.error.apply(_this, arguments);
                }
            });
        }
    };
    window.ajaxForm = ajaxForm;
})($, window);