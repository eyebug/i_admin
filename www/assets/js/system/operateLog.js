var iAdmin = iAdmin || {};
iAdmin.systemAdminOperateLog = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, operateLogList = new YP.list, operateLogForm = new YP.form;

    /**
     * 初始化列表
     */
    function initoperateLogList() {
        $("#filter_operatorid,#filter_module,#filter_group,#filter_hotel").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });
        operateLogList.init({
            colCount: 8,
            params: {
                admintype: ypGlobal.adminType
            },
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                operateLogList.writeListData(data);
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
        operateLogForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            modelDom: detailModal
        });
        $("#dataList").on('click', 'button[op=editDataOne]', function () {
            var $editId = $(this).data('dataid'), $dataDom = $("#dataList").find("[dataId=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function (key, value) {
                var dataOne = $(value);
                if (dataOne.attr('type')) {
                    dataList[dataOne.attr('type')] = dataOne.data('value');
                }
            });
            operateLogForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            detailModal.modal('show');
        });
    }

    function init() {
        initoperateLogList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.systemAdminOperateLog.init();
})
