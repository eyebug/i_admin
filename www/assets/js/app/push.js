var iAdmin = iAdmin || {};
iAdmin.appPush = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, pushList = new YP.list, pushForm = new YP.form;

    /**
     * 初始化列表
     */
    function initpushList() {
        pushList.init({
            colCount: 7,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                pushList.writeListData(data);
            },
            listFail: function (data) {
                tips.show('数据加载失败！');
            }
        });
    }

    /**
     * 初始化编辑新增
     */
    function initEditor() {
        // 初始化表单保存
        var detailModal = $("#editor");
        pushForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            checkParams: eval(ypGlobal.checkParams),
            saveUrl: ypGlobal.createBaseUrl,
            modelDom: detailModal,
            saveBefore: function (saveParams) {
                saveParams = pushForm.makeRecord(saveParams, saveParams.id, saveParams.cnTitle);
                return saveParams;
            },
            saveSuccess: function (data) {
                pushList.reLoadList();
            },
            saveFail: function (data) {
                tips.show(data.msg);
            }
        });
        // 新建产品
        $("#createData").on('click', function () {
            pushForm.writeEditor({
                editorDom: $("#listEditor")
            });
        });
    }

    function init() {
        initpushList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.appPush.init();
})
