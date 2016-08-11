var ypAnalys = ypAnalys || {};
ypAnalys.productLocalPlaceList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : ypGlobal.colCount,
            listUrl : ypGlobal.listUrl,
            listDomObject : $("#placeList"),
            listTemplate : 'place_tpl',
            params : {
                localId : ypGlobal.localId,
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
        // 初始化表单保存
        var detailModal = $("#editor");
        ypForm.init({
            editorDom : $("#listEditor"),
            saveButtonDom : $("#savePlace"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                ypForm.updateParams({
                    saveUrl : saveParams.id > 0 ? ypGlobal.updateUrl : ypGlobal.createUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, $("#edit_name").val(), ypGlobal.productId, '子产品:' + saveParams.localId + ":景点信息 " + (saveParams.id ? 'ID:' + saveParams.id : ''));
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
        $("#createPlace").on('click', function() {
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : {
                    productId : ypGlobal.productId,
                    localId : ypGlobal.localId
                }
            });
        });
        // 编辑产品
        $("#placeList").on('click', 'button[op=editPlace]', function() {
            var $editId = $(this).data('id'), $dataDom = $("[op=placeData][data-id=" + $editId + "]");
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
            detailModal.modal('show');
        });
    }

    function initDelete() {
        $("#placeList").on('click', 'button[op=deletePlace]', function() {
            if (!confirm('确认删除？')) {
                return false;
            }
            var deleteButton = $(this);
            var params = {
                id : deleteButton.data('id'),
                productId : ypGlobal.productId
            };
            var placeName = $("#placeList [op=placeData][data-id=" + params.id + "] [type=name]").html();
            recordLog = ypRecord.getDeleteLog({
                value : '子产品:' + ypGlobal.localId + +":景点信息 " + placeName
            });
            params[YP_RECORD_VARS.recordPostVar] = recordLog;
            params[YP_RECORD_VARS.recordPostId] = ypGlobal.productId;
            deleteButton.button('loading');
            var xhr = ajax.ajax({
                url : ypGlobal.deleteUrl,
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
    ypAnalys.productLocalPlaceList.init();
})
