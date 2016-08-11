var ypAnalys = ypAnalys || {};
ypAnalys.productHotelList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : ypGlobal.colCount,
            listUrl : ypGlobal.priceListUrl,
            listDomObject : $("#hotelList"),
            listTemplate : 'hotel_tpl',
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
        $('#edit_cityId').select2({
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
            saveButtonDom : $("#saveHotel"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                saveParams.cityName = $("#edit_cityId option:selected").html();
                ypForm.updateParams({
                    saveUrl : saveParams.id > 0 ? ypGlobal.productUpdateUrl : ypGlobal.productCreateUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, $("#edit_cnName").val(), ypGlobal.productId, '子产品:' + saveParams.journeyId + ":酒店信息 " + (saveParams.id ? 'ID:' + saveParams.id : ''));
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
        $("#createHotel").on('click', function() {
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : {
                    productId : ypGlobal.productId,
                    journeyId : ypGlobal.journeyId
                }
            });
        });
        // 编辑产品
        $("#hotelList").on('click', 'button[op=editHotel]', function() {
            var $editButton = $(this);
            detailPrams = {
                id : $editButton.data('id'),
                productId : ypGlobal.productId
            };
            $editButton.button('loading');
            var xhr = ajax.ajax({
                url : ypGlobal.productDetailUrl,
                type : "POST",
                data : detailPrams,
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                detailModal.modal('show');
                ypForm.writeEditor({
                    editorDom : $("#listEditor"),
                    writeData : data.data
                });
                var $option = new Option(data.data.cityName, data.data.cityId, true);
                $("#edit_cityId").append($option).trigger('change');
                $("#select2-edit_cityId-container").html(data.data.cityName);
                $editButton.button('reset');
            }).fail(function(data) {
                detailModal.modal('hide');
                tips.show(data.msg);
                $editButton.button('reset');
            });
        });
    }

    function initDelete() {
        $("#hotelList").on('click', 'button[op=deleteHotel]', function() {
            if (!confirm('确认删除？')) {
                return false;
            }
            var deleteButton = $(this);
            var params = {
                id : deleteButton.data('id'),
                productId : ypGlobal.productId
            };
            var cnName = $("#hotelList [op=hotelData][data-id=" + params.id + "] [type=cnName]").html();
            recordLog = ypRecord.getDeleteLog({
                value : '子产品:' + ypRecord.journeyId + ":酒店信息 " + cnName
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
    ypAnalys.productHotelList.init();
})
