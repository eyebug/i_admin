var iAdmin = iAdmin || {};
iAdmin.appstartMsgList = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, startMsgList = new YP.list, startMsgForm = new YP.form;

    /**
     * 初始化列表
     */
    function initStartMsgList() {
        var filter_type = $("#filter_type"), filter_hotel = $("#filter_hotel"), filter_group = $("#filter_group");
        filter_type.on('change', function () {
            switch (filter_type.val()) {
                case 'all':
                    filter_hotel.hide();
                    filter_group.hide();
                    break;
                case '1':
                    filter_hotel.show();
                    filter_group.hide();
                    break;
                case '2':
                    filter_hotel.hide();
                    filter_group.show();
                    break;
            }
        });
        $("#filter_hotelid,#filter_groupid").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });

        startMsgList.init({
            colCount: 5,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                startMsgList.writeListData(data);
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
        var edit_type = $("#edit_type"), edit_hotel = $("#editHotel"), edit_group = $("#editGroup");
        edit_type.on('change', function () {
            switch (edit_type.val()) {
                case '1':
                    edit_hotel.show();
                    edit_group.hide();
                    break;
                case '2':
                    edit_hotel.hide();
                    edit_group.show();
                    break;
            }
        });
        $("#edit_hotelid,#edit_groupid").select2({
            width: 200,
            placeholder: '全部',
            language: 'zh-CN'
        });

        // 初始化表单保存
        var detailModal = $("#editor");
        startMsgForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            checkParams: eval(ypGlobal.checkParams),
            modelDom: detailModal,
            saveBefore: function (saveParams) {
                startMsgForm.updateParams({
                    saveUrl: saveParams.id > 0 ? ypGlobal.updateBaseUrl : ypGlobal.createBaseUrl,
                });
                saveParams.dataid = saveParams.type == 1 ? saveParams.hotelid : saveParams.groupid;
                saveParams = startMsgForm.makeRecord(saveParams, saveParams.id, saveParams.url);
                return saveParams;
            },
            saveSuccess: function (data) {
                startMsgList.reLoadList();
            },
            saveFail: function (data) {
                tips.show(data.msg);
            }
        });
        // 新建产品
        $("#createData").on('click', function () {
            startMsgForm.writeEditor({
                editorDom: $("#listEditor")
            });
            edit_type.val(1).trigger('change');
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
            dataList.type == 1 ? dataList.hotelid = dataList.dataid : dataList.groupid = dataList.dataid;
            startMsgForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            detailModal.modal('show');
        });
    }

    function init() {
        initStartMsgList();
        initEditor();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.appstartMsgList.init();
})
