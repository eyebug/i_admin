var ypAnalys = ypAnalys || {};
ypAnalys.productFlightList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : ypGlobal.colCount,
            listUrl : ypGlobal.priceListUrl,
            listDomObject : $("#flightList"),
            listTemplate : 'flight_tpl',
            params : {
                journeyId : ypGlobal.journeyId,
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
        $("#edit_arrTag").select2({
            placeholder : '请选择',
            width : 500,
            language : 'zh-CN'
        });
        $('#edit_depCityId,#edit_arrCityId').select2({
            width : 200,
            cache : true,
            language : 'zh-CN',
            ajax : {
                url : "/product_base/searchCity",
                dataType : 'json',
                delay : 250
            },
            templateResult : function(repo) {
                return repo.showName;
            },
            minimumInputLength : 1
        });
        // 初始化表单保存
        var detailModal = $("#editor");
        ypForm.init({
            editorDom : $("#listEditor"),
            saveButtonDom : $("#saveFlight"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                saveParams.depCityName = $("#edit_depCityId option:selected").html();
                saveParams.arrCityName = $("#edit_arrCityId option:selected").html();
                ypForm.updateParams({
                    saveUrl : saveParams.id > 0 ? ypGlobal.productUpdateUrl : ypGlobal.productCreateUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, saveParams.depCityName + '-' + saveParams.arrCityName, ypGlobal.productId, '子产品:' + saveParams.journeyId + ":机票信息 " + (saveParams.id ? 'ID:' + saveParams.id : ''));
                return saveParams;
            },
            saveSuccess : function(data) {
                ypList.reLoadList();
            },
            saveFail : function(data) {
                tips.show(data.msg);
            }
        });
        // 新建产品
        $("#createFilght").on('click', function() {
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : {
                    productId : ypGlobal.productId,
                    journeyId : ypGlobal.journeyId
                }
            });
        });
        // 编辑产品
        $("#flightList").on('click', 'button[op=editFlight]', function() {
            var $editId = $(this).data('id'), $dataDom = $("[op=flightData][data-id=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function(key, value) {
                var dataOne = $(value);
                dataList[dataOne.attr('type')] = dataOne.data('value');
            });
            dataList.arrTag = String(dataList.arrTag).split(",");
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : dataList
            });
            var $option = new Option(dataList.depCityName, dataList.depCityId, true);
            $("#edit_depCityId").append($option).trigger('change');
            var $option = new Option(dataList.arrCityName, dataList.arrCityId, true);
            $("#edit_arrCityId").append($option).trigger('change');
            detailModal.modal('show');
        });
    }

    function initDelete() {
        $("#flightList").on('click', 'button[op=deleteFlight]', function() {
            if (!confirm('确认删除？')) {
                return false;
            }
            var deleteButton = $(this), deleteRow = deleteButton.parents('[op=flightData]');
            var params = {
                id : deleteButton.data('id'),
                productId : ypGlobal.productId
            };
            recordLog = ypRecord.getDeleteLog({
                value : '子产品:' + params.id + "机票信息：" + deleteRow.find("[type=direction]").html() + "第" + deleteRow.find("[type=sequence]").html() + "程，ID：" + params.id
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
        });
    }

    function init() {
        initList();
        initEditor();
        initDelete();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productFlightList.init();
})
