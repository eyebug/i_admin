var iAdmin = iAdmin || {};
iAdmin.groupUserList = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, userList = new YP.list, ypForm = new YP.form;
    var searchButton = $("#searchBtn");

    /**
     * 初始化列表
     */
    function initList() {
        $("#filter_groupid").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });

        userList.init({
            colCount: 9,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: searchButton,
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                userList.writeListData(data);
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
        ypForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            checkParams: eval(ypGlobal.checkParams),
            modelDom: detailModal,
            saveBefore: function (saveParams) {
                ypForm.updateParams({
                    saveUrl: saveParams.id > 0 ? ypGlobal.updateBaseUrl : ypGlobal.createBaseUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, saveParams.username);
                return saveParams;
            },
            saveSuccess: function (data) {
                userList.reLoadList();
            },
            saveFail: function (data) {
                tips.show(data.msg);
            }
        });
        $("#edit_groupid").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });
        // 新建产品
        $("#createData").on('click', function () {
            ypForm.writeEditor({
                editorDom: $("#listEditor")
            });
            $("#groupEdit").show();
        });
        // 编辑产品
        $("#dataList").on('click', 'button[op=editDataOne]', function () {
            var $editId = $(this).data('dataid'), $dataDom = $("#dataList").find("[dataId=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function (key, value) {
                var dataOne = $(value);
                if (dataOne.attr('type')) {
                    dataList[dataOne.attr('type')] = dataOne.data('value');
                }
            });
            ypForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            $("#groupEdit").hide();
            detailModal.modal('show');
        });
    }

    function init() {
        initList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.groupUserList.init();
})
