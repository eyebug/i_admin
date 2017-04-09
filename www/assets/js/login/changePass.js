var iAdmin = iAdmin || {};
iAdmin.loginChangePass = (function($, ypRecordVar, ypGlobal) {

    var tips = YP.alert;

    function initChangePass() {
        var changePassFrom = new YP.form;
        changePassFrom.init({
            editorDom : $("#changePassForm"),
            saveButtonDom : $("#saveChangePass"),
            saveUrl : '/loginajax/changePass',
            checkParams : [ 'oldPass', 'newPass' ],
            saveBefore : function(saveParams) {
                if (saveParams.oldPass == saveParams.newPass) {
                    tips.show('新旧密码不能一样');
                    return false;
                }
                YP_RECORD_VARS.isChange = 1;
                saveParams[ypRecordVar.recordPostId] = ypGlobal.userid;
                saveParams[ypRecordVar.recordPostVar] = "修改登录密码";
                return saveParams;
            },
            saveSuccess : function(data) {
                alert('修改成功，请重新登录');
                location.href = '/Login/logout';
            },
            saveFail : function(data) {
                tips.show(data.msg);
            }
        });
    }

    function init() {
        initChangePass();
    }

    return {
        init : init
    };
})(jQuery, YP_RECORD_VARS, YP_GLOBAL_VARS);

$(function() {
    iAdmin.loginChangePass.init();
})