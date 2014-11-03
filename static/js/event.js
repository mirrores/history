//切换地方校友会所属
function change_aa(aid, selected_id) {
    var url = "/user/getClubSelect?aa_id=" + aid + '&selected_id=' + selected_id;
    var loading = document.getElementById("loading");
    loading.innerHTML = '<img src="/static/images/user/loading6.gif">';
    jQuery.get(url, function(data) {
        loading.innerHTML = '';
        document.getElementById("club_box").innerHTML = data;
    });
}

//参加报名
function signForm(event_id) {
    new Facebox({
        title: '填写报名信息',
        url: '/event/signForm?eid=' + event_id,
        okVal: '确定',
        ok: function() {
            //提交表单
            new ajaxForm('sign_form', {
                textSuccess: '提交成功',
                textSending: '提交中',
                callback: function(data) {
                    if (data > 1) {
                        window.location.href = '/event/view?id=' + event_id;
                    }
                    else {
                        errorAlert(data);
                    }
                }
            }).send();
            return false;
        }
    }).show();
}

//修改报名
function editSign(event_id) {
    var signForm = new Facebox({
        title: '我的报名信息',
        url: '/event/signForm?eid=' + event_id + '&sign_action=updateForm',
        okVal: '保存修改',
        ok: function() {
            //提交表单
            new ajaxForm('sign_form', {
                textSuccess: '修改成功',
                textSending: '提交中...',
                callback: function(data) {
                    if (data > 1) {
                        signForm.close();
                        window.location.reload();
                    }
                    else {
                        errorAlert(data);
                    }
                }
            }).send();
            return false;
        }
    }).show();
}

//取消报名
function cancel_sign(eid) {
    new candyConfirm({
        title: '取消确认',
        message: '您确定要取消本次活动报名吗？',
        url: '/event/cancelSign?eid=' + eid,
        callback: function() {
            window.location.reload();
        }
    }).open();
}

//快速修改
function quick_edit(cid) {
    new Facebox({
        id: 'facebox_quick_edit',
        title: '编辑活动',
        top: '50%',
        padding: '15px',
        width: '800px',
        okVal: '保存修改',
        url: '/event/quick_edit?id=' + cid + '&time=' + parseInt(10 * Math.random()),
        ok: function() {
            new ajaxForm('event_form', {
                textSending: '发送中',
                textError: '重试',
                textSuccess: '修改成功',
                callback: function() {
                    window.location.reload();
                }
            }).send();
            return false;
        }
    }).show();
}

//删除活动
function del(id) {
    new candyConfirm({
        id: 'facebox_delsss',
        message: '确定要删除该活动吗？注意删除活动将同时删除活动相关的报名、评论、相册等信息！',
        url: '/event/del?cid=' + id,
        callback: function() {
            window.location.href = '/event';
        }
    }).open();
}

//取消报名
function delsign(cid) {

    new Facebox({
        id: 'facebox_delsign',
        title: '取消活动报名',
        top: '50%',
        padding: '15px',
        width: '500px',
        okVal: '确定删除',
        url: '/event/delsign?cid=' + cid,
        ok: function() {
            new ajaxForm('del_sign_form', {
                textSending: '取消中...',
                textError: '重试',
                textSuccess: '取消成功',
                callback: function() {
                    candyDel('sign_user_' + cid);
                }
            }).send();
        }
    }).show();

    setTimeout(function() {
        $del_sign_form = $("#del_sign_form");
        $notic_remarks = $("#del_sign_form").find(".notic_remarks");
        $del_sign_form.find("input[name='notic']").live('click', function() {
            if ($(this).val() == 'none') {
                $notic_remarks.fadeOut();
            }
            else {
                $notic_remarks.fadeIn();
            }
        });
    }, 1000);
}

//发布活动
function publish_event() {
    if (!ueditor.hasContents()) {
        ueditor.setContent('');
    }
    ueditor.sync();
    var aa_id = $("#aa_id  option:selected").val();
    var club_id = $("#club_id  option:selected").val();
    new ajaxForm('event_form', {
        callback: function(id) {
            if (id > 0) {
                if (club_id > 0) {
                    window.location.href = '/club_home/eventview?id=' + club_id + '&eid=' + id;
                }
                else if (aa_id > 0) {
                    window.location.href = '/aa_home/eventview?id=' + aa_id + '&eid=' + id;
                }
                else {
                    window.location.href = '/event/view?id=' + id;
                }
            }
        }
    }).send();
}

//设为认证
function set_vcert() {
    var vcert = document.getElementById('vcert');
    var ico_vcert = document.getElementById('ico_vcert');
    if (vcert.value == 0) {
        vcert.value = 1;
        ico_vcert.src = '/static/images/ico_vcert.png';
    }
    else {
        vcert.value = 0;
        ico_vcert.src = '/static/images/ico_vcert2.png';
    }
}

//
function colorboxShow(href) {
    $.colorbox({href: href});
}

//切换报名分组
function changeSignGroup(category_id, event_id, refresh) {
    var event_signs = $('#event_signs');
    new Request({
        url: '/event/signs?event_id=' + event_id + '&category_id=' + category_id,
        type: 'post',
        beforeSend: function() {
            event_signs.html('<div style="margin:5px;padding:5px;"><img src="/static/images/loading.gif"></div>');
        },
        success: function(data) {
            event_signs.html(data);
        }
    }).send();
}

//创建毅行队伍
function crateSignCategroy() {

    new ajaxForm('sign_category_form', {
        data_type: 'json',
        submitButton: 'createcatbutton',
        callback: function(data) {
            event_category_facebox.close();
            var catselect = $('#sign_form').find('#category_id');
            catselect.append('<option value="' + data.id + '">' + data.name + '</option>');
            catselect.val(data.id);
            okAlert('队伍添加成功，请重新选择队伍！');
        }
    }).send();
}

function updateSignCategroy() {
    new ajaxForm('sign_category_form', {
        data_type: 'json',
        submitButton: 'createcatbutton',
        callback: function(data) {
            okAlert('队伍修改成功!刷新网页后将自动更新。');
            $('#manageGroup').html('');
        }
    }).send();
}

//队伍管理
function manage_team(event_id, cid) {
    var box = $('#manageGroup');
    $.ajax({
        url: '/event/manageGroup',
        dataType: 'html',
        type: 'POST',
        data: {'event_id': event_id, 'category_id': cid},
        beforeSend: function() {
            box.html('<img src="/static/images/loading.gif">');
        },
        success: function(data) {
            $('#manageGroup').html(data);
        }
    });
}

function manage_teaminfo(event_id, cid) {
    var box = $('#manageGroup');
    $.ajax({
        url: '/event/signCategoryForm',
        dataType: 'html',
        type: 'get',
        data: {'event_id': event_id, 'category_id': cid},
        beforeSend: function() {
            box.html('<img src="/static/images/loading.gif">');
        },
        success: function(data) {
            box.html(data);
        }
    });
}

//加入小队
function join_event_group(sign_id, category_id, event_id) {
    $.ajax({
        url: '/event/joineventgroup',
        dataType: 'html',
        type: 'post',
        data: {'sign_id': sign_id},
        success: function(data) {
            changeSignGroup(category_id, event_id, false);
        }
    });
}