/**
 * @author 张福顺
 * @back 开发背景：后台大量的雷同列表，JS出现大量重复逻辑
 * @description 说明：用于雷同产品管理列表的场景，可实现列表的初始化加载、筛选等逻辑
 */
var YP = YP || {};
YP.list = function() {

    var ypList = {};
    var ajax = YP.ajax;
    ypList.listParams = {
        colCount : 9,// table中td数量
        listUrl : '',// 列表ajax请求地址
        autoLoad : true,
        initSearch : true,
        params : {// 列表ajax参数
            page : 1,
            limit : 10
        },
        ajaxMethod : 'POST',
        pageDomObject : $("#pageDiv"),// 分页html元素对象
        listDomObject : $("#listContent"),// 列表主体元素对象
        listFilterDomObject : $("#listFilter"),// 列表主体元素对象
        searchButtonDomObject : $("#searchBtn"),// 筛选搜索按钮元素对象
        listTemplate : 'list_tpl',// 列表模版名称
        pageTemplate : 'listPage_tpl',// 分页模版名称
        noDataTemplate : 'listNoData_tpl',// 没有数据展示的模版名称
        loadingTemplate : 'listLoading_tpl',// loading状态模版名称
        listSuccess : function(data) {// 成功的回调
        },
        listFail : function(data) {// 失败回调
        },
        handlerParams : function(params) {// 请求前处理参数
            return params;
        }
    }

    /**
     * 初始化
     */
    ypList.init = function(option) {
        option = $.extend(ypList.listParams, option);
        if (option.autoLoad) {
            var filterParams = {
                page : 1
            };
            ypList.listParams.listFilterDomObject.find("[op=filterCase]:visible").each(function(key, value) {
                var $filterDom = $(value), $filterId = $filterDom.attr('id'), $filterValue = $filterDom.val(), $filterKey = $filterDom.data('paramkey');
                var $filterKey = $filterKey ? $filterKey : $filterId;
                if ($filterDom.attr('type') == 'checkbox') {
                    $filterValue = $filterDom.is(':checked') ? 1 : 0;
                    filterParams[$filterKey] = $filterValue;
                } else if ($filterDom.attr('type') == 'radio') {
                    if ($filterDom.is(':checked')) {
                        filterParams[$filterKey] = $filterValue;
                    }
                } else {
                    filterParams[$filterKey] = $filterValue;
                }
            });
            ypList.updateParams(filterParams);
            loadList();
        }
        initPageChange();
        if (option.initSearch) {
            initSearch();
        }
    };

    /**
     * 把列表数据写入页面
     */
    ypList.writeListData = function(data) {
        var html = '';
        if (data.data.list.length > 0) {
            html = template(ypList.listParams.listTemplate, data.data);
            var pageHtml = template(ypList.listParams.pageTemplate, data.data.pageData);
            ypList.listParams.pageDomObject.html(pageHtml).show();
        } else {
            html = template(ypList.listParams.noDataTemplate, {
                colCount : ypList.listParams.colCount
            });
            ypList.listParams.pageDomObject.hide();
        }
        ypList.listParams.listDomObject.html(html);
    }

    /**
     * 重置搜索按钮
     */
    ypList.resetSearchButton = function() {
        ypList.listParams.searchButtonDomObject.button('reset');
    };

    /**
     * 更新参数
     */
    ypList.updateParams = function(option) {
        option = $.extend(ypList.listParams.params, option);
    };

    /**
     * 重新加载数据
     */
    ypList.reLoadList = function() {
        loadList();
    }

    function initSearch() {
        // 执行筛选
        ypList.listParams.searchButtonDomObject.on('click', function() {
            var filterParams = {
                page : 1
            };
            ypList.listParams.listFilterDomObject.find("[op=filterCase]:visible").each(function(key, value) {
                var $filterDom = $(value), $filterId = $filterDom.attr('id'), $filterValue = $filterDom.val(), $filterKey = $filterDom.data('paramkey');
                var $filterKey = $filterKey ? $filterKey : $filterId;
                if ($filterDom.attr('type') == 'checkbox') {
                    $filterValue = $filterDom.is(':checked') ? 1 : 0;
                    filterParams[$filterKey] = $filterValue;
                } else if ($filterDom.attr('type') == 'radio') {
                    if ($filterDom.is(':checked')) {
                        filterParams[$filterKey] = $filterValue;
                    }
                } else {
                    filterParams[$filterKey] = $filterValue;
                }
            });
            ypList.updateParams(filterParams);
            ypList.reLoadList();
        });
    }
    /**
     * 初始化分页信息
     */
    function initPageChange() {
        ypList.listParams.pageDomObject.on("click", "a[op=prevPage]", function() {
            ypList.listParams.params['page'] = parseInt(ypList.listParams.params['page']) - 1;
            loadList();
        });
        ypList.listParams.pageDomObject.on("click", "a[op=nextPage]", function() {
            ypList.listParams.params['page'] = parseInt(ypList.listParams.params['page']) + 1;
            loadList();
        });
        ypList.listParams.pageDomObject.on("click", "a[op=jumpTo]", function() {
            ypList.listParams.params['page'] = ypList.listParams.pageDomObject.find("input[op=jumpPage]").val();
            loadList();
        });
    }

    /**
     * 加载列表
     */
    function loadList() {
        ypList.listParams.searchButtonDomObject.button('loading');
        ypList.listParams.listDomObject.html(template(ypList.listParams.loadingTemplate, {
            colCount : ypList.listParams.colCount
        }));
        ypList.listParams.params = ypList.listParams.handlerParams(ypList.listParams.params);
        var xhr = ajax.ajax({
            url : ypList.listParams.listUrl,
            type : ypList.listParams.ajaxMethod,
            data : ypList.listParams.params,
            cache : false,
            dataType : "json",
            timeout : 100000
        });
        xhr.done(function(data) {
            ypList.listParams.listSuccess(data);
            ypList.resetSearchButton();
        }).fail(function(data) {
            ypList.listParams.listFail(data);
            html = template(ypList.listParams.noDataTemplate, {
                colCount : ypList.listParams.colCount
            });
            ypList.listParams.listDomObject.html(html);
            ypList.resetSearchButton();
        });
    }

    return ypList;
};
