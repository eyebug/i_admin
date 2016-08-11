var ypAnalys = ypAnalys || {};
ypAnalys.productLine = (function($) {

    var ajax = YP.ajax, tips = YP.alert, LIMIT = 10, modelName = "OTA产品自由行路线", ypRecord = YP.record;
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
            url : '/productajax/lineList/',
            type : "POST",
            data : listParams,
            cache : false,
            dataType : "json",
            timeout : 30000
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
                url : '/productajax/changeLineStatus/',
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
                url : '/productajax/getLineDetail/',
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
                detailInfo.traveltype = $lineInfo.traveltype;
                detailInfo.titledescribe = $lineInfo.titledescribe;
                detailInfo.status = $lineInfo.status;
                detailInfo.price = $lineInfo.price;
                detailInfo.subsidy = $lineInfo.subsidy;
                detailInfo.basePrice = $lineInfo.basePrice;
                detailInfo.priceanalysis = $lineInfo.priceanalysis;
                detailInfo.recommended = $lineInfo.recommended;
                detailInfo.fromCity = $lineInfo.fromCity;
                detailInfo.toCity = $lineInfo.toCity;
                detailInfo.dayShow = $lineInfo.dayShow;
                detailInfo.days = $lineInfo.days;
                detailInfo.isdirect = $lineInfo.isdirect;
                detailInfo.hotelstar = $lineInfo.hotelstar;
                detailInfo.travelseptime = $lineInfo.travelseptime;
                detailInfo.traveldeptimeshow = $lineInfo.traveldeptimeshow;
                detailInfo.teamtrip = $lineInfo.teamtrip;
                detailInfo.duesuggests = $lineInfo.duesuggests;
                detailInfo.visainfo = $lineInfo.visainfo;
                detailInfo.schedule = $lineInfo.schedule;
                detailInfo.notes = $lineInfo.notes;
                detailInfo.costinclude = $lineInfo.costinclude;
                detailInfo.bookUrl = $lineInfo.bookUrl;
                detailInfo.fromUrl = $lineInfo.fromUrl;
                detailInfo.apiUpdate = $lineInfo.apiUpdate;
                // detailInfo.sort = $lineInfo.sort;
                detailInfo.bit = $lineInfo.bit;
                writeEditData(detailInfo);
            }).fail(function(data) {
                tips.show('数据获取失败！');
            });
        });

        $("#addStore").on('click', function() {
            writeEditData({
                id : 0,
                title : '',
                titledescribe : '',
                status : 0,
                price : 0,
                subsidy : 0,
                basePrice : 0,
                priceanalysis : 0,
                recommended : 0,
                fromCity : 0,
                toCity : 0,
                dayShow : '',
                days : 0,
                isdirect : 0,
                hotelstar : 0,
                travelseptime : '',
                travelDepTimeShow : '',
                // teamtrip : '',
                duesuggests : '',
                visainfo : '',
                schedule : '',
                notes : '',
                costinclude : '',
                bookUrl : '',
                fromUrl : '',
                apiUpdate : 0,
                // sort : 0,
                bit : 0
            });
        });

        var checkParams = [ 'title', 'titledescribe', 'fromCity', 'toCity', 'price', 'bit' ];
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
            recordDataId = params.id;
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
            recordDataId = params.id;
        }
        if (recordLog) {
            params[YP_RECORD_VARS.recordPostVar] = recordLog;
        }
        params[YP_RECORD_VARS.recordPostId] = recordDataId;
        $submitBt.button('loading');
        var xhr = ajax.ajax({
            url : '/productajax/saveLine/',
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
    ypAnalys.productLine.init();
})
