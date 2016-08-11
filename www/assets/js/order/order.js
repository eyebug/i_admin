var ypAnalys = ypAnalys || {};
ypAnalys.orderList = (function($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, LIMIT = 10, modelName = "OTA后台订单", ypRecord = YP.record;

    var params = {
        'page' : 1,
        'limit' : LIMIT,
    };

    function initPage() {
        loadOrderList(params);
        $("#pageDiv").on("click", "a[op=prevPage]", function() {
            params['page'] = parseInt(params['page']) - 1;
            loadOrderList(params);
        });
        $("#pageDiv").on("click", "a[op=nextPage]", function() {
            params['page'] = parseInt(params['page']) + 1;
            loadOrderList(params);
        });
        $("#pageDiv").on("click", "a[op=jumpTo]", function() {
            params['page'] = $("#pageDiv input[op=jumpPage]").val();
            loadOrderList(params);
        });
    }

    function loadOrderList(params) {
        var xhr = ajax.ajax({
            url : ypGlobal.listUrl,
            type : "POST",
            data : params,
            cache : false,
            dataType : "json",
            timeout : 10000
        });
        xhr.done(function(data) {
            var html = '';
            if (data.data.list.length > 0) {
                html = template('template', data.data);
                var pageHtml = template('template_page', data.data.pageData);
                $("#pageDiv").html(pageHtml);
            } else {
                html = template('noData_tpl', {});
            }
            $('#templatelist').html(html);
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
        $("#searchBtn").on("click", function() {
            $(this).button('loading');
            var memberStatus = params['page'] = 1;
            params['id'] = $("#id").val();
            params['status'] = $("#status").val();
            params['mobile'] = $("#mobile").val();
            params['productType'] = $("#productType").val();
            params['orderid'] = $("#orderid").val();
            params['linkman'] = $("#linkman").val();
            loadOrderList(params);
        });
    }

    function initButton() {
        $('#templatelist').on('click', '.confirmBtn', function(event) {
            var isok = confirm('确实要确认此订单吗？');
            if (!isok) {
                return false;
            }
            var $confirmBtn = $(this);
            var id = $confirmBtn.data('id');
            var $confirmBtn = $(this);
            var id = $confirmBtn.data('id');

            var editValue = [];
            var editData = ypRecord.compareText({
                domOb : $confirmBtn
            });
            if (editData) {
                editValue.push(editData);
            }
            recordLog = ypRecord.getEditLog({
                modelName : modelName + id,
                value : editValue
            });
            var paramsData = {
                'id' : id
            };
            paramsData[YP_RECORD_VARS.recordPostVar] = recordLog;
            paramsData[YP_RECORD_VARS.recordPostId] = id;
            var xhr = ajax.ajax({
                'url' : '/orderajax/confirm/',
                'type' : "POST",
                'async' : false,
                'data' : paramsData,
                'cache' : false,
                'dataType' : "json",
                'timeout' : 10000
            });
            xhr.done(function(data) {
                $('#orderStatus' + id).html('<span style="color:red;">待付款</span>');
                $confirmBtn.remove();
            }).fail(function(data) {
                tips.show(data.msg);
            });
        });
        $('#templatelist').on('click', '.orderDetail', function(event) {
            var $detailBtn = $(this), id = $detailBtn.data('id'), $dBody = $("#detailContent"), orderid = $detailBtn.data('orderid');
            $dBody.html('');
            var xhr = ajax.ajax({
                'url' : ypGlobal.detailUrl,
                'type' : "POST",
                'async' : false,
                'data' : {
                    'id' : id,
                    'orderid' : orderid
                },
                'cache' : false,
                'dataType' : "json",
                'timeout' : 10000
            });
            xhr.done(function(data) {
                //                data.data.title = $('#' + id).find('td[param="orderTitle"]').text();
                html = template('orderDetail_tpl', data);
                $dBody.html(html);
                $("#orderDetail").modal();
            }).fail(function(data) {
                tips.show(data.msg);
            });
        });
        $('#orderDetail').on('click', 'button[op="saveForm"]', function(event) {
            var $t = $(this), id = $("#orderIdVal").val(), status = $("#curOrderStatusVal").val(), orderStatus = $('#orderStatus').val(), remark = $("#remark").val(), orderId = $("#orderId_main").val();
            if (orderStatus != status && orderStatus != '') {
                var editValue = [];
                var editData = ypRecord.compareSelect({
                    domOb : $("#orderStatus")
                });
                if (editData) {
                    editValue.push(editData);
                }
                recordLog = ypRecord.getEditLog({
                    modelName : modelName + id,
                    value : editValue
                });
                var paramsData = {
                    'id' : id,
                    'status' : orderStatus
                };
                paramsData[YP_RECORD_VARS.recordPostVar] = recordLog;
                paramsData[YP_RECORD_VARS.recordPostId] = id;
                var xhr = ajax.ajax({
                    'url' : '/orderajax/changeStatus/',
                    'type' : "POST",
                    'async' : false,
                    'data' : paramsData,
                    'cache' : false,
                    'dataType' : "json",
                    'timeout' : 10000
                });
                xhr.done(function(data) {
                    $("#orderDetail").modal('hide');
                    $("#searchBtn").trigger('click');
                }).fail(function(data) {
                    tips.show(data.msg);
                });
            } else if (orderStatus == '') {
                alert('订单状态不能为空');
            } else {
                $("#orderDetail").modal('hide');
            }

            // 添加子订单备注
            if (remark != '') {
                var editValue = [];
                var editData = ypRecord.compareText({
                    domOb : $("#remark")
                });
                if (editData) {
                    editValue.push(editData);
                }
                recordLog = ypRecord.getEditLog({
                    value : editValue
                });
                var remarkParamsData = {
                    'id' : id,
                    'orderId' : orderId,
                    'remark' : remark
                };
                remarkParamsData[YP_RECORD_VARS.recordPostVar] = recordLog;
                remarkParamsData[YP_RECORD_VARS.recordPostId] = id;
                // alert(JSON.stringify(remarkParamsData));
                var xhr = ajax.ajax({
                    'url' : '/orderajax/addRemark/',
                    'type' : "POST",
                    'async' : false,
                    'data' : remarkParamsData,
                    'cache' : false,
                    'dataType' : "json",
                    'timeout' : 10000
                });
                xhr.done(function(data) {
                    // console.log(data);return false;
                    $("#orderProductDetail").modal('hide');
                    loadOrderList(params);
                }).fail(function(data) {
                    alert(data.msg);
                });
            }

        });
    }

    function initRecordList() {
        var recordList = YP.recordList;
        $('#templatelist').on('click', '[op=orderDetail]', function() {
            var dataId = $(this).data('id');
            recordList.init({
                listUrl : '/orderajax/getRemark/',
                dataId : dataId,
                limit : 100
            });
        });
    }

    function init() {
        fixDetailHeight();
        initPage();
        initSearch();
        initButton();
        initRecordList();
    }

    return {
        init : init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function() {
    ypAnalys.orderList.init();
})
