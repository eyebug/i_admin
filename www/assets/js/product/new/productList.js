var ypAnalys = ypAnalys || {};
ypAnalys.productList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : ypGlobal.colCount,
            listUrl : ypGlobal.productListUrl,
            listDomObject : $("#productList"),
            listTemplate : 'productList_tpl',
            params : {
                productId : ypGlobal.productId
            },
            listSuccess : function(data) {
                var $createBt = $("#createProduct");
                if (data.data.list.length == 0 || ypGlobal.createMore) {
                    $createBt.show();
                } else {
                    $createBt.hide();
                }
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
        if (ypGlobal.dateInpt) {
            $(ypGlobal.dateInpt).datetimepicker(datatimepickerConfig).on('changeDate', function(event) {
                $(event.target).trigger('blur');
            });
        }
        if (ypGlobal.select2Input) {
            $.each(ypGlobal.select2Input, function(key, width) {
                $(key).select2({
                    placeholder : '请选择',
                    width : width,
                    language : 'zh-CN'
                });
            });
        }
        // 初始化表单保存
        var detailModal = $("#editor");
        ypForm.init({
            editorDom : $("#listEditor"),
            saveButtonDom : $("#saveProductMore"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                ypForm.updateParams({
                    saveUrl : saveParams.id > 0 ? ypGlobal.productUpdateUrl : ypGlobal.productCreateUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.id, "子产品:" + saveParams.id, saveParams.productId, "子产品:" + saveParams.id);
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
        $("#createProduct").on('click', function() {
            ypForm.writeEditor({
                editorDom : $("#listEditor"),
                writeData : {
                    productId : ypGlobal.productId
                }
            });
        });
        // 编辑产品
        $("#productList").on('click', 'button[op=editProduct]', function() {
            var $editButton = $(this);
            detailPrams = {
                id : $editButton.data('id')
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
                $editButton.button('reset');
            }).fail(function(data) {
                detailModal.modal('hide');
                tips.show(data.msg);
                $editButton.button('reset');
            });
        });
    }

    function init() {
        initList();
        initEditor();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productList.init();
})
