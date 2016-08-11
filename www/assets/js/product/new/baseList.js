var ypAnalys = ypAnalys || {};
ypAnalys.productBaseList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, ypList = YP.list, ypForm = YP.form;
    var searchButton = $("#searchBtn");

    /**
     * 初始化列表
     */
    function initList() {
        ypList.init({
            colCount : 8,
            listUrl : ypGlobal.productListUrl,
            listDomObject : $("#productList"),
            searchButtonDomObject : searchButton,
            listTemplate : 'productList_tpl',
            listSuccess : function(data) {
                ypList.writeListData(data);
            },
            listFail : function(data) {
                tips.show('数据加载失败！');
            },
        });
    }

    /**
     * 初始化筛选
     */
    function initFilter() {
        // 初始化筛选条件切换
        var $ptSelect = $("#productType");
        $ptSelect.on('change', function() {
            var selectType = $ptSelect.val();
            $("#listFilter [op=typeFilter]").hide();
            $("#" + selectType + "_filter").show();
        });
        $ptSelect.val(39).trigger('change');
        $('#updateTimeStart, #updateTimeEnd,#createTimeStart,#createTimeEnd').datetimepicker(datatimepickerConfig);
        // 清空日期
        $("button[op=clearDate]").on('click', function() {
            var type = $(this).data("type");
            $("#" + type + "Start, #" + type + "End").val('');
        });
        // 活动来源下拉框
        $('#otaId').select2({
            placeholder : '全部',
            width : 200,
            language : 'zh-CN'
        });
        $('#edit_getMethod').select2({
            placeholder : '请选择',
            width : 300,
            language : 'zh-CN'
        });
        try {
            $('#toCity,#fromCity').select2({
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
        } catch (e) {
        }
        // 执行筛选
        searchButton.on('click', function() {
            var filterParams = {
                page : 1
            };
            $("#listFilter [op=filterCase]:visible").each(function(key, value) {
                var $filterDom = $(value), $filterId = $filterDom.attr('id'), $filterValue = $filterDom.val();
                filterParams[$filterId] = $filterValue;
            });
            ypList.updateParams(filterParams);
            ypList.reLoadList();
        });
    }

    /**
     * 初始化编辑新增
     */
    function initEditor() {
        // select2
        $('#edit_otaId').select2({
            placeholder : '请选择',
            width : 200,
            language : 'zh-CN'
        });
        try {
            $('#edit_fromCity,#edit_toCity').select2({
                width : 500,
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
                templateSelection : function(repo) {
                    $('#edit_toCity').find('option[value=' + repo.id + ']').data('countryid', repo.countryId);
                    return repo.text;
                },
                minimumInputLength : 1
            });

            $('#edit_poi').select2({
                width : 500,
                cache : true,
                language : 'zh-CN',
                ajax : {
                    url : "/product_base/searchPoi",
                    dataType : 'json',
                    delay : 250
                },
                templateResult : function(repo) {
                    return repo.showName;
                },
                templateSelection : function(repo) {
                    return repo.text;
                },
                minimumInputLength : 1
            });
        } catch (e) {
        }
        // 初始化表单保存
        var detailModal = $("#editor");
        ypForm.init({
            recordIdDomId : "productId",
            recordTitleDomId : "title",
            editorDom : $("#listEditor"),
            saveButtonDom : $("#saveProductBase"),
            checkParams : eval(ypGlobal.checkParams),
            modelDom : detailModal,
            saveBefore : function(saveParams) {
                var countryIdList = [];
                $("#edit_toCity option:selected").each(function(key, value) {
                    countryIdList.push($(value).data('countryid'));
                });
                saveParams.countryId = countryIdList;
                ypForm.updateParams({
                    saveUrl : saveParams.productId > 0 ? ypGlobal.productUpdateBaseUrl : ypGlobal.productCreateBaseUrl
                });
                saveParams = ypForm.makeRecord(saveParams, saveParams.productId, saveParams.title);
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
            $("#productTypeSelect").show();
            ypForm.writeEditor({
                editorDom : $("#listEditor")
            });
        });
        var productSubTypeSelect = $("#productSubTypeSelect");
        $("#edit_productType").on('change', function() {
            if ($(this).val() == 9) {
                productSubTypeSelect.show();
            } else {
                productSubTypeSelect.hide();
            }
        });
        // 编辑产品
        $("#productList").on('click', 'button[op=editProductBase]', function() {
            $("#productTypeSelect,#productSubTypeSelect").hide();
            var $editButton = $(this);
            detailPrams = {
                productId : $editButton.data('productid')
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
                var depCityId = $("#edit_fromCity");
                var $option = '';
                if (data.data.fromCityList) {
                    $.each(data.data.fromCityList, function(key, value) {
                        $option += '<option value=' + value.cityId + ' data-countryid=' + value.countryId + ' selected>' + value.cityName + '</option>';
                    });
                    depCityId.html($option).trigger('change');
                }
                var arrCityId = $("#edit_toCity");
                var $option = '';
                if (data.data.toCityList) {
                    $.each(data.data.toCityList, function(key, value) {
                        $option += '<option value=' + value.cityId + ' data-countryid=' + value.countryId + ' selected>' + value.cityName + '</option>';
                    });
                    arrCityId.html($option).trigger('change');
                }
                var arrPoiId = $("#edit_poi");
                var $option = '';
                if (data.data.poiList) {
                    $.each(data.data.poiList, function(key, value) {
                        $option += '<option value=' + value.poiId + ' selected>' + value.cnName + '</option>';
                    });
                    arrPoiId.html($option).trigger('change');
                }

                $editButton.button('reset');
            }).fail(function(data) {
                detailModal.modal('hide');
                tips.show(data.msg);
                $editButton.button('reset');
            });
        });
    }

    function init() {
        initFilter();
        initList();
        initEditor();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productBaseList.init();
})
