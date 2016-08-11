var ypAnalys = ypAnalys || {};
ypAnalys.productPriceCalendar = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, LIMIT = 5, modelName = "OTA产品价格日历", ypRecord = YP.record;
    var searchButton = $("#searchBtn"), $list = $("#templatelist");
    var priceCalendarListParams = {
        'page' : 1,
        'limit' : LIMIT
    };

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

    function initPriceCalendarEdit() {
        var $aoBt = $("#priceCalendar_addOne"), $amBt = $("#priceCalendar_addMore"), $bkBt = $("#priceCalendar_back"), $save = $("#savePriceCalendar");
        var $listDom = $("#priceCalendar_list"), $editOneDom = $("#priceCalendar_editOne"), $editMoreDom = $("#priceCalendar_editMore");
        var $peoId = $("#priceCalendar_editOne_id"), $peoDate = $("#priceCalendar_editOne_date"), $peoBit = $("#priceCalendar_editOne_bit");
        var $peoPrice = $("#priceCalendar_editOne_price"), $peoChildPrice = $("#priceCalendar_editOne_childPrice"), $peoSubsidy = $("#priceCalendar_editOne_subsidy");
        $aoBt.on('click', function() {
            $listDom.hide();
            $("div[op=editFiled]").removeClass('error');
            $peoId.val(0);
            $peoDate.val('').prop('disabled', false);
            $peoPrice.val(0);
            $peoChildPrice.val(0);
            $peoSubsidy.val(0);
            $peoBit.val(0);
            $editMoreDom.hide();
            $editOneDom.show();
            $save.show();
            $aoBt.hide();
            $amBt.hide();
            $bkBt.show();
        });
        $amBt.on('click', function() {
            $("#priceCalendar_editMore_date_from,#priceCalendar_editMore_date_to,#priceCalendar_editMore_price,#priceCalendar_editMore_childPrice,#priceCalendar_editMore_subsidy,#priceCalendar_editMore_bit").val('');
            $listDom.hide();
            $editMoreDom.show();
            $editOneDom.hide();
            $save.show();
            $aoBt.hide();
            $amBt.hide();
            $bkBt.show();
        });
        $bkBt.on('click', function() {
            $listDom.show();
            $editOneDom.hide();
            $editMoreDom.hide();
            $save.hide();
            $aoBt.show();
            $amBt.show();
            $bkBt.hide();
        });
        $('#priceCalendar_editOne_date,#priceCalendar_editMore_date_from,#priceCalendar_editMore_date_to').datetimepicker(datatimepickerConfig);

        $listDom.on('click', "button[op=editPriceCalendar]", function() {
            var editId = $(this).data('id');
            var xhr = ajax.ajax({
                url : ypGlobal.detailUrl,
                type : "POST",
                data : {
                    id : editId
                },
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                $aoBt.trigger('click');
                $peoId.val(data.data.id);
                $peoDate.val(data.data.date).prop('disabled', true);
                $peoPrice.val(data.data.price).data('old', data.data.price);
                $peoChildPrice.val(data.data.childPrice).data('old', data.data.childPrice);
                $peoSubsidy.val(data.data.subsidy).data('old', data.data.subsidy);
                $peoBit.val(data.data.bit).data('old', data.data.bit);
            }).fail(function(data) {
                tips.show('数据获取失败！');
            });
        });

        $pcSaveBt = $("#savePriceCalendarButton");
        var checkStatus = true;
        $pcSaveBt.on('click', function() {
            $pcSaveBt.button('loading');
            var checkParams = [];
            if ($editOneDom.is(':visible')) {
                checkParams = [ 'priceCalendar_editOne_date', 'priceCalendar_editOne_price', 'priceCalendar_editOne_bit' ];
            } else {
                checkParams = [ 'priceCalendar_editMore_date_from', 'priceCalendar_editMore_date_to', 'priceCalendar_editMore_price', 'priceCalendar_editMore_bit' ];
            }
            $.each(checkParams, function(key, value) {
                if (!checkSubmit($("#" + value))) {
                    checkStatus = false;
                    $pcSaveBt.button('reset');
                }
            });
            if (checkStatus) {
                if ($editOneDom.is(':visible')) {
                    saveOnePriceCalendar();
                } else {
                    saveMorePriceCalendar();
                }
            }
        });

        $("#bitOne").on('click', function() {
            $("#priceCalendar_editOne_bit").val("999");
        });
        $("#bitMore").on('click', function() {
            $("#priceCalendar_editMore_bit").val("999");
        });
        $peoPrice.on('change', function() {
            if (parseFloat($peoChildPrice.val()) == 0) {
                $peoChildPrice.val($peoPrice.val());
            }
        });
        var $pemPrice = $("#priceCalendar_editMore_price"), $pemChildPrice = $("#priceCalendar_editMore_childPrice");
        $pemPrice.on('change', function() {
            if ($pemChildPrice.val() == '') {
                $pemChildPrice.val($pemPrice.val());
            }
        });
    }

    function saveOnePriceCalendar() {
        var $peoId = $("#priceCalendar_editOne_id"), $peoDate = $("#priceCalendar_editOne_date"), $peoBit = $("#priceCalendar_editOne_bit");
        var $peoPrice = $("#priceCalendar_editOne_price"), $peoChildPrice = $("#priceCalendar_editOne_childPrice"), $peoSubsidy = $("#priceCalendar_editOne_subsidy");
        $bkBt = $("#priceCalendar_back"), $pcSaveBt = $("#savePriceCalendarButton");
        var params = {
            id : $peoId.val(),
            dataId : priceCalendarListParams['id'],
            date : $peoDate.val(),
            price : $peoPrice.val(),
            childPrice : $peoChildPrice.val(),
            subsidy : $peoSubsidy.val(),
            bit : $peoBit.val(),
        };

        if (params.id == 0) {
            recordLog = ypRecord.getCreateLog({
                // modelName : modelName + ypGlobal.recordName,
                value : params.date
            });
            recordDataId = params.dataId;
        } else {
            var editValue = [];
            var recordParams = [ $peoPrice, $peoChildPrice, $peoSubsidy, $peoBit ];
            $.each(recordParams, function(key, value) {
                var editData = ypRecord.compareText({
                    domOb : value
                });
                if (editData) {
                    editValue.push(editData);
                }
            });
            recordLog = ypRecord.getEditLog({
                modelName : params.date,
                value : editValue
            });
            recordDataId = params.dataId;
        }
        params[YP_RECORD_VARS.recordPostVar] = recordLog;
        params[YP_RECORD_VARS.recordPostId] = recordDataId;
        var xhr = ajax.ajax({
            url : ypGlobal.saveOneUrl,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            loadPriceCalendarList(priceCalendarListParams);
            $bkBt.trigger('click');
            $pcSaveBt.button('reset');
        }).fail(function(data) {
            $pcSaveBt.button('reset');
            tips.show('数据获取失败！');
        });
    }

    function saveMorePriceCalendar() {
        var $pemDateFrom = $("#priceCalendar_editMore_date_from"), $pemDateTo = $("#priceCalendar_editMore_date_to"), $pemBit = $("#priceCalendar_editMore_bit");
        var $pemPrice = $("#priceCalendar_editMore_price"), $pemChildPrice = $("#priceCalendar_editMore_childPrice"), $pemSubsidy = $("#priceCalendar_editMore_subsidy");
        $bkBt = $("#priceCalendar_back"), $pcSaveBt = $("#savePriceCalendarButton");
        var params = {
            dataId : priceCalendarListParams['id'],
            price : $pemPrice.val(),
            childPrice : $pemChildPrice.val(),
            subsidy : $pemSubsidy.val(),
            fromDate : $pemDateFrom.val(),
            toDate : $pemDateTo.val(),
            bit : $pemBit.val()
        };
        recordLog = ypRecord.getCreateLog({
            value : "从" + params.fromDate + '到' + params.toDate
        });
        recordDataId = params.dataId;
        params[YP_RECORD_VARS.recordPostId] = recordDataId;
        params[YP_RECORD_VARS.recordPostVar] = recordLog;
        var xhr = ajax.ajax({
            url : ypGlobal.saveMoreUrl,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            loadPriceCalendarList(priceCalendarListParams);
            $bkBt.trigger('click');
            $pcSaveBt.button('reset');
        }).fail(function(data) {
            $pcSaveBt.button('reset');
            tips.show('数据获取失败！');
        });
    }

    function initPriceCalendarList() {
        $list.on("click", 'button[op=priceCalendar]', function() {
            $("#priceCalendarList").html("");
            priceCalendarListParams['id'] = $(this).data('id');
            priceCalendarListParams['page'] = 1;
            loadPriceCalendarList(priceCalendarListParams);
            $("#priceCalendar_back").trigger('click');
        });
        var $page = $("#priceCalendarPage");
        $page.on("click", "a[op=prevPage]", function() {
            priceCalendarListParams['page'] = parseInt(priceCalendarListParams['page']) - 1;
            loadPriceCalendarList(priceCalendarListParams);
        });
        $page.on("click", "a[op=nextPage]", function() {
            priceCalendarListParams['page'] = parseInt(priceCalendarListParams['page']) + 1;
            loadPriceCalendarList(priceCalendarListParams);
        });
        $page.on("click", "a[op=jumpTo]", function() {
            priceCalendarListParams['page'] = $page.find("input[op=jumpPage]").val();
            loadPriceCalendarList(priceCalendarListParams);
        });
    }

    function loadPriceCalendarList(priceCalendarListParams) {
        var xhr = ajax.ajax({
            url : ypGlobal.listUrl,
            type : "POST",
            data : priceCalendarListParams,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            var html = '';
            if (data.data.list.length > 0) {
                html = template('priceCalendar_tpl', data.data);
                var pageHtml = template('template_page', data.data.pageData);
                $("#priceCalendarPage").html(pageHtml);
            } else {
                html = template('priceCalendarNoData_tpl', {});
            }
            $("#priceCalendarList").html(html);
        }).fail(function(data) {
            tips.show('数据加载失败！');
        });
    }

    function initPriceCalendarDelete() {
        var $listDom = $("#priceCalendar_list");
        $listDom.on('click', "button[op=deletePriceCalendar]", function() {
            if (!confirm("确认删除？")) {
                return false;
            }
            var editDom = $(this), editId = editDom.data('id');
            recordLog = ypRecord.getDeleteLog({
                // modelName : modelName + ypGlobal.recordName,
                value : editDom.data('date')
            });
            var params = {
                id : editId,
                dataId : priceCalendarListParams['id'],
            };
            recordDataId = params.dataId;
            params[YP_RECORD_VARS.recordPostVar] = recordLog;
            params[YP_RECORD_VARS.recordPostId] = recordDataId;
            var xhr = ajax.ajax({
                url : ypGlobal.deleteUrl,
                type : "POST",
                data : params,
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                loadPriceCalendarList(priceCalendarListParams);
            }).fail(function(data) {
                tips.show('数据获取失败！');
            });
        });
    }

    function init() {
        initPriceCalendarList();
        initPriceCalendarEdit();
        initPriceCalendarDelete();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productPriceCalendar.init();
})
