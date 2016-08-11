var ypAnalys = ypAnalys || {};
ypAnalys.productStore = (function($) {

    var ajax = YP.ajax, tips = YP.alert, LIMIT = 10, ypRecord = YP.record;
    var searchButton = $("#searchBtn"), $list = $("#templatelist");

    var listParams = {
        'page' : 1,
        'limit' : LIMIT,
    };

    function initPage() {
        loadList(listParams);
        $("#pageDiv").on("click", "a[op=prevPage]", function() {
            listParams['page'] = parseInt(listParams['page']) - 1;
            loadList(listParams);
        });
        $("#pageDiv").on("click", "a[op=nextPage]", function() {
            listParams['page'] = parseInt(listParams['page']) + 1;
            loadList(listParams);
        });
        $("#pageDiv").on("click", "a[op=jumpTo]", function() {
            listParams['page'] = $("#pageDiv input[op=jumpPage]").val();
            loadList(listParams);
        });
    }

    function loadList(listParams) {
        var xhr = ajax.ajax({
            url : '/productajax/storeList/',
            type : "POST",
            data : listParams,
            cache : false,
            dataType : "json",
            timeout : 20000
        });
        xhr.done(function(data) {
            var html = '';
            if (data.data.list.length > 0) {
                html = template('productLine_tpl', data.data);
                var pageHtml = template('template_page', data.data.pageData);
                $("#pageDiv").html(pageHtml);
            } else {
                html = template('noData_tpl', {});
            }
            $list.html(html);
            $("#searchBtn").button('reset');
        }).fail(function(data) {
            tips.show('数据加载失败！');
            $("#searchBtn").button('reset');
        });
    }

    function fixDetailHeight() {
        var detailContent = $("#detailBody");
        detailContent.height($(window).height() - 240);
        $(window).resize(function() {
            detailContent.height($(window).height() - 240)
        });
    }

    function initSearch() {
        // 清空日期
        $("button[op=clearDate]").on('click', function() {
            var type = $(this).data("type");
            $("#" + type + "Start, #" + type + "End").val('');
        });
        // 日历控件
        $('#updateTimeStart, #updateTimeEnd,#createTimeStart,#createTimeEnd').datetimepicker(datatimepickerConfig);

        // 活动来源下拉框
        $('#fromCity,#toCity').select2({
            placeholder : '全部',
            width : 200,
            language : 'zh-CN'
        });

        searchButton.on("click", function() {
            searchButton.button('loading');
            listParams['page'] = 1;
            listParams['id'] = $("#id").val();
            listParams['title'] = $("#title").val();
            listParams['status'] = $("#status").val();
            listParams['poiStatus'] = $("#poiStatus").val();
            listParams['updateTimeStart'] = $("#updateTimeStart").val();
            listParams['updateTimeEnd'] = $("#updateTimeEnd").val();
            listParams['createTimeStart'] = $("#createTimeStart").val();
            listParams['createTimeEnd'] = $("#createTimeEnd").val();
            listParams['fromcity'] = $("#fromCity").val();
            listParams['tocity'] = $("#toCity").val();
            loadList(listParams);
        });
    }

    function initStatusHandler() {
        var $sabn = $("#selectAll"), $cabn = $("#cancelAll"), $statusBn = $("button[op=statusChange]");
        $sabn.on('click', function() {
            $list.find("input[op=selectLine]").prop("checked", true);
        });
        $cabn.on('click', function() {
            $list.find("input[op=selectLine]").prop("checked", false);
        });
        $statusBn.on("click", function() {
            var params = {}, $clickBt = $(this);
            params.type = $clickBt.data("type"), params.value = $clickBt.data("value"), $select = $list.find("input[op=selectLine]:checked");
            if ($select.length == 0) {
                tips.show('没有选择数据！');
                return false;
            }
            var changeLineId = [];
            $select.each(function(key, value) {
                changeLineId.push($(value).data('id'));
            });
            params.id = changeLineId.join(",");

            params[YP_RECORD_VARS.recordPostId] = params.id;
            params[YP_RECORD_VARS.recordPostVar] = $clickBt.html();
            $clickBt.button('loading');

            var xhr = ajax.ajax({
                url : '/productajax/changeStoreStatus/',
                type : "POST",
                data : params,
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                loadList(listParams);
                $clickBt.button('reset');
            }).fail(function(data) {
                tips.show('修改失败！');
                $clickBt.button('reset');
            });
        });
    }

    function initEditor() {
        $('#edit_fromCity,#edit_toCity').select2({
            placeholder : '请选择',
            width : 200,
            language : 'zh-CN'
        });
        // $('#edit_poi').select2({
        // width : 200,
        // tags : true,
        // language : 'zh-CN',
        // ajax : {
        // url : "/productajax/searchPoi",
        // dataType : 'json',
        // delay : 250,
        // data : function(params) {
        // return {
        // kw : params.term, // search term
        // page : params.page
        // };
        // },
        // processResults : function(data, params) {
        // params.page = params.page || 1;
        // return {
        // results : data.items,
        // pagination : {
        // more : (params.page * 30) < data.total_count
        // }
        // };
        // }
        // },
        // templateResult : function(repo) {
        // return repo.name;
        // },
        // templateSelection : function(repo) {
        // return repo.id;
        // },
        // minimumInputLength : 1
        // });

        $list.on("click", 'button[op=editLine]', function() {
            var editId = $(this).data('id');
            var xhr = ajax.ajax({
                url : '/productajax/getStoreDetail/',
                type : "POST",
                data : {
                    id : editId
                },
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                var $lineInfo = data.data;
                var detailInfo = {};
                detailInfo.id = $lineInfo.id;
                detailInfo.title = $lineInfo.title;
                detailInfo.titleshort = $lineInfo.titleshort;
                detailInfo.status = $lineInfo.status;
                detailInfo.fromCity = $lineInfo.fromCity;
                detailInfo.toCity = $lineInfo.toCity;
                detailInfo.poi = $lineInfo.poi;
                detailInfo.poiStatus = $lineInfo.poiStatus;
                detailInfo.description = $lineInfo.description;
                detailInfo.apiUpdate = $lineInfo.apiUpdate;
                detailInfo.allowOrder = $lineInfo.allowOrder;
                detailInfo.tag = $lineInfo.tag;
                detailInfo.price = $lineInfo.price;
                detailInfo.basePrice = $lineInfo.basePrice;
                detailInfo.content = $lineInfo.content;
                detailInfo.contentPrice = $lineInfo.contentPrice;
                detailInfo.notice = $lineInfo.notice;
                detailInfo.dayShow = $lineInfo.dayShow;
                detailInfo.nonStop = $lineInfo.nonStop;
                detailInfo.hotelstars = $lineInfo.hotelstars;
                // detailInfo.rank = $lineInfo.rank;
                detailInfo.quantity = $lineInfo.quantity;
                detailInfo.urlpc = $lineInfo.urlpc;
                detailInfo.urlh5 = $lineInfo.urlh5;
                detailInfo.urlsource = $lineInfo.urlsource;
                detailInfo.dayslist = $lineInfo.dayslist;
                writeEditData(detailInfo);
            }).fail(function(data) {
                tips.show('数据获取失败！');
            });
        });

        $("#addStore").on('click', function() {
            writeEditData({
                id : 0,
                title : '',
                titleshort : '',
                status : 0,
                fromCity : 0,
                toCity : 0,
                poi : '',
                poiStatus : 0,
                description : '',
                apiUpdate : 0,
                allowOrder : 0,
                tag : 1,
                price : 0,
                basePrice : 0,
                content : '',
                contentPrice : '',
                notice : '',
                dayShow : '',
                nonStop : 0,
                hotelstars : '',
//                rank : '',
                quantity : '',
                urlpc : '',
                urlh5 : '',
                urlsource : '',
                dayslist : '',
            });
        });

        var checkParams = [ 'title', 'titleshort', 'description', 'toCity', 'price' ];
        var checkStatus = true;
        $("#saveForm").on("click", function() {
            checkStatus = true;
            $.each(checkParams, function(key, value) {
                var checkValue = $("#edit_" + value);
                if (!checkSubmit(checkValue)) {
                    checkStatus = false;
                }
            });
            if (checkStatus) {
                submitEdit();
            }
        });

        $.each(checkParams, function(key, value) {
            var checkValue = $("#edit_" + value);
            checkValue.on('blur', function() {
                checkSubmit(checkValue);
            });
        });
    }

    function submitEdit() {
        var params = {}, $submitBt = $("#saveForm");
        $("[id^='edit_']").each(function(key, value) {
            var param = $(value), paramKey = param.attr('id'), paramValue = param.val();
            paramKey = paramKey.split("_");
            paramKey = paramKey[1];
            params[paramKey] = paramValue;
        });
        if (params.id == 0) {
            recordLog = ypRecord.getCreateLog({
                value : params.title
            });
        } else {
            var editValue = [];
            $.each(params, function(key, value) {
                var editDom = $("#edit_" + key), editType = editDom.attr('type'), editTagName = editDom.prop('tagName').toLowerCase();
                type = editTagName == 'input' ? editType : editTagName;
                type = (type == 'select') ? 'compareSelect' : 'compareText';
                var editData = eval("ypRecord." + type + "({domOb : editDom})");
                if (editData) {
                    editValue.push(editData);
                }
            });
            recordLog = ypRecord.getEditLog({
                value : editValue
            });
            params[YP_RECORD_VARS.recordPostId] = params.id;
        }
        if (recordLog) {
            params[YP_RECORD_VARS.recordPostVar] = recordLog;
        }
        $submitBt.button('loading');
        var xhr = ajax.ajax({
            url : '/productajax/saveStore/',
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            loadList(listParams);
            $("#closeEditor").trigger('click');
            $submitBt.button('reset');
        }).fail(function(data) {
            tips.show('数据保存失败！');
            $submitBt.button('reset');
        });
    }

    function checkSubmit(checkValue) {
        var checkDiv = checkValue.parents("div[op=editFiled]");
        if (checkValue.val() == '' || checkValue.val() == null || checkValue.val() == 0) {
            checkDiv.addClass('error');
            return false;
        } else {
            checkDiv.removeClass('error');
            return true;
        }
    }

    function writeEditData(detailInfo) {
        $("div[op=editFiled]").removeClass('error');
        $.each(detailInfo, function(key, value) {
            if (key == 'poi') {
                if (value != '') {
                    value = value.split(",");
                    $("#edit_poi").html(template('selectedPoi_tpl', {
                        poiList : value
                    }));
                    $("#edit_poi").val(value).trigger("change");
                } else {
                    $("#edit_poi").val([]).trigger("change");
                }
            } else {
                $("#edit_" + key).val(value).data('old', value);
                if (key == 'fromCity' || key == 'toCity') {
                    $("#edit_" + key).trigger('change');
                }
            }
        });
    }

    function init() {
        fixDetailHeight();
        initPage();
        initSearch();
        initStatusHandler();
        initEditor();
    }

    return {
        init : init
    };
})(jQuery);

$(function() {
    ypAnalys.productStore.init();
})
