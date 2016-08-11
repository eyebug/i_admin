var ypAnalys = ypAnalys || {};
ypAnalys.productPriceList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : ypGlobal.colCount,
            listUrl : ypGlobal.priceListUrl,
            listDomObject : $("#priceList"),
            listTemplate : 'priceList_tpl',
            params : {
                childProductId : ypGlobal.childProductId,
                page : 1,
                limit : 10
            },
            listSuccess : function(data) {
                ypList.writeListData(data);
            },
            listFail : function(data) {
                tips.show('数据加载失败！');
            },
        });
    }

    /**
     * 初始化编辑新增
     */
    function initEditor() {
        var dateParams = [];
        $("#listEditor [id^='edit_']").each(function(key, value) {
            var editDom = $(value);
            if (editDom.attr('type') == 'date') {
                dateParams.push("#" + editDom.attr('id'));
            }
        });
        if (dateParams) {
            $(dateParams.join(",")).datetimepicker(datatimepickerConfig);
        }

        $("#full_stock,#full_childStock,#full_shareStock").on('click', function() {
            var forType = $(this).data('for');
            $("#" + forType).val(999);
        });

        // 初始化表单保存
        var detailModal = $("#editor");
        ypForm.init({
            editorDom : $("#listEditor"),
            saveButtonDom : $("#savePrice"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                ypForm.updateParams({
                    saveUrl : saveParams.id > 0 ? ypGlobal.productUpdateUrl : ypGlobal.productCreateUrl
                });
                recordMsg = saveParams.createType == 1 ? saveParams.time : "从" + saveParams.startTime + '到' + saveParams.endTime;
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, recordMsg, ypGlobal.productId, '子产品:' + saveParams.childProductId + "价格日历 " + (saveParams.id ? 'ID:' + saveParams.id : ''));
                return saveParams;
            },
            saveSuccess : function(data) {
                ypList.reLoadList();
            },
            saveFail : function(data) {
                alert(data.msg);
                tips.show(data.msg);
            }
        });
        // 新建产品
        var nowDate = new Date();
        var defaultDate = nowDate.getFullYear() + "-" + (nowDate.getMonth() + 1) + "-" + nowDate.getDate();
        $("#createPrice").on('click', function() {
            $("[dateType=one],#createType").show();
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : {
                    productId : ypGlobal.productId,
                    childProductId : ypGlobal.childProductId,
                    time : defaultDate,
                    startTime : defaultDate,
                    endTime : defaultDate
                }
            });
        });
        // 编辑产品
        $("#priceList").on('click', 'button[op=editPrice]', function() {
            var $editId = $(this).data('id'), $dataDom = $("[op=priceData][data-id=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function(key, value) {
                var dataOne = $(value);
                dataList[dataOne.attr('type')] = dataOne.data('value');
            });
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : dataList
            });
            $("[dateType=one],[dateType=many],#createType").hide();
            detailModal.modal('show');
        });
    }

    function initDateTypeChange() {
        var dateTypeDom = $("#edit_createType"), dateTypeOne = $("[dateType=one]"), dateTypeMany = $("[dateType=many]");
        dateTypeDom.on('change', function() {
            var dateType = dateTypeDom.val();
            if (dateType == 2) {
                dateTypeOne.hide();
                dateTypeMany.show();
            } else {
                dateTypeOne.show();
                dateTypeMany.hide();
            }
        });
        dateTypeDom.val(1).trigger('change');
    }

    function initDelete() {
        var $sabn = $("#selectAll"), $cabn = $("#cancelAll"), $list = $("#priceList");
        $sabn.on('click', function() {
            $list.find("input[op=selectData]").prop("checked", true);
        });
        $cabn.on('click', function() {
            $list.find("input[op=selectData]").prop("checked", false);
        });
        $("#deleteData").on('click', function() {
            var selectId = [];
            $list.find("input[op=selectData]:checked").each(function(key, value) {
                selectId.push($(value).data('id'));
            });
            deleteData(selectId, $(this));
        });
        $list.on('click', 'button[op=deletePrice]', function() {
            deleteData($(this).data("id"), $(this));
        });
    }

    function deleteData(deleteId, deleteButton) {
        if (!confirm('确认删除？')) {
            return false;
        }
        var params = {
            id : deleteId,
            productId : ypGlobal.productId
        };
        var deleteDate = [];
        var priceList = $("#priceList");
        $.each(typeof (deleteId) == 'number' ? [ deleteId ] : deleteId, function(key, value) {
            deleteDate.push("ID" + value + ":" + priceList.find("[op=priceData][data-id=" + value + "] [type=time]").data('value'));
        });
        recordLog = ypRecord.getDeleteLog({
            value : '子产品:' + ypGlobal.childProductId + ":价格日历" + deleteDate.join(',')
        });
        params[YP_RECORD_VARS.recordPostVar] = recordLog;
        params[YP_RECORD_VARS.recordPostId] = ypGlobal.productId;
        deleteButton.button('loading');
        var xhr = ajax.ajax({
            url : ypGlobal.productDeleteUrl,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            ypList.reLoadList();
            deleteButton.button('reset');
        }).fail(function(data) {
            tips.show(data.msg);
            deleteButton.button('reset');
        });
    }

    function init() {
        initList();
        initEditor();
        initDateTypeChange();
        initDelete();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productPriceList.init();
})
