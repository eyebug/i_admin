var iAdmin = iAdmin || {};
iAdmin.userUserList = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, userList = new YP.list, userForm = new YP.form;

    /**
     * 初始化列表
     */
    function initUserList() {
        $("#filter_groupid,#filter_hotelid").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });
        userList.init({
            colCount: 7,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
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
        userForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            modelDom: detailModal,
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
            userForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            $("#groupEdit").hide();
            detailModal.modal('show');
        });
    }

    function init() {
        initUserList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.userUserList.init();
})
