var iAdmin = iAdmin || {};
iAdmin.hotelHotelList = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, groupList = new YP.list, userForm = new YP.form;

    /**
     * 初始化列表
     */
    function initGroupList() {
        groupList.init({
            colCount: 5,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                groupList.writeListData(data);
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
        userForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            checkParams: eval(ypGlobal.checkParams),
            modelDom: detailModal,
            saveBefore: function (saveParams) {
                userForm.updateParams({
                    saveUrl: saveParams.id > 0 ? ypGlobal.updateBaseUrl : ypGlobal.createBaseUrl
                });
                saveParams = userForm.makeRecord(saveParams, saveParams.id, saveParams.name);
                return saveParams;
            },
            saveSuccess: function (data) {
                groupList.reLoadList();
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
            userForm.writeEditor({
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
            userForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            $("#groupEdit").hide();
            detailModal.modal('show');
        });
    }

    function init() {
        initGroupList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.hotelHotelList.init();
})
