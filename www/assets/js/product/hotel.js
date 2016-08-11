var ypAnalys = ypAnalys || {};
ypAnalys.productHotel = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, LIMIT = 5, modelName = "OTA产品酒店信息", ypRecord = YP.record;
    var $list = $("#hotelList"), $ctBt = $("#createButton"), $saveBt = $("#saveForm");

    function initList() {
        var params = {
            lineid : ypGlobal.lineId
        };
        var xhr = ajax.ajax({
            url : '/Hotelajax/getHotelList',
            type : "GET",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            var html = '';
            if (data.data.length > 0) {
                html = template('hotelList_tpl', data);
            } else {
                html = template('noData_tpl', {});
            }
            $list.html(html);
        }).fail(function(data) {
            tips.show('数据加载失败！');
        });
    }

    function fixDetailHeight() {
        var detailContent = $("#detailBody");
        detailContent.height($(window).height() - 240);
        $(window).resize(function() {
            detailContent.height($(window).height() - 240)
        });
    }

    function initEditor() {
        $list.on('click', 'button[op=editFlight]', function() {
            var editId = $(this).data('id');
            var xhr = ajax.ajax({
                url : '/Hotelajax/getHotelDetail',
                type : "GET",
                data : {
                    id : editId
                },
                cache : false,
                dataType : "json",
                timeout : 10000
            });
            xhr.done(function(data) {
                writeEditData(data.data);
            }).fail(function(data) {
                tips.show('数据获取失败！');
            });
        });

        $ctBt.on('click', function() {
            writeEditData({});
        });

        var checkParams = [ 'hotelEnName', 'hotelCity', 'hotelNum', 'liveLate' ];
        var checkStatus = true;
        $saveBt.on("click", function() {
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
        var params = {
            lineid : ypGlobal.lineId
        };
        $("[id^='edit_']").each(function(key, value) {
            var param = $(value), paramKey = param.attr('id'), paramValue = param.val();
            paramKey = paramKey.split("_");
            paramKey = paramKey[1];
            params[paramKey] = paramValue;
        });
        var url = '';
        // var url = params.id > 0 ? '/Hotelajax/modifyHotel' :
        // '/Hotelajax/addHotel';
        if (params.id > 0) {
            var editValue = [];
            url = '/Hotelajax/modifyHotel';
            var noCheckParams = [ 'id', 'lineid' ];
            $.each(params, function(key, value) {
                if ($.inArray(key, noCheckParams) >= 0) {
                    return true;
                }
                var editDom = $("#edit_" + key), editType = editDom.attr('type'), editTagName = editDom.prop('tagName').toLowerCase();
                type = (editTagName == 'input') ? editType : editTagName;
                type = (type == 'select') ? 'compareSelect' : 'compareText';
                var editData = eval("ypRecord." + type + "({domOb : editDom})");

                if (editData) {
                    editValue.push(editData);
                }
            });
            recordLog = ypRecord.getEditLog({
                modelName : params.id,
                value : editValue
            });
            recordDataId = params.lineid;
        } else {
            url = '/Hotelajax/addHotel';
            recordLog = ypRecord.getCreateLog({
                value : params.hotelEnName
            });
            recordDataId = params.lineid;
        }
        params[YP_RECORD_VARS.recordPostVar] = recordLog;
        params[YP_RECORD_VARS.recordPostId] = recordDataId;
        $saveBt.button('loading');
        var xhr = ajax.ajax({
            url : url,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            initList();
            $("#closeEditor").trigger('click');
            $saveBt.button('reset');
        }).fail(function(data) {
            tips.show('数据保存失败！');
            $saveBt.button('reset');
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
        $("[id^='edit_']").each(function(key, value) {
            var param = $(value), paramKey = param.attr('id');
            paramKey = paramKey.split("_");
            paramKey = paramKey[1];
            $(value).val(detailInfo[paramKey]);
        });
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
        initList();
        initEditor();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.productHotel.init();
})
