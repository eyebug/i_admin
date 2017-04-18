var iAdmin = iAdmin || {};
iAdmin.hotelHotelList = (function ($, ypGlobal) {

    var ajax = YP.ajax, tips = YP.alert, hotelList = new YP.list, hotelForm = new YP.form, ypRecord = YP.record;

    /**
     * 初始化列表
     */
    function initHotelList() {
        hotelList.init({
            colCount: 7,
            autoLoad: true,
            listUrl: ypGlobal.listUrl,
            listDomObject: $("#dataList"),
            searchButtonDomObject: $("#searchBtn"),
            listTemplate: 'dataList_tpl',
            listSuccess: function (data) {
                hotelList.writeListData(data);
            },
            listFail: function (data) {
                tips.show('数据加载失败！');
            }
        });
    }

    /**
     * 初始化编辑新增
     */
    function initEditor() {
        // 初始化表单保存
        var detailModal = $("#editor");
        hotelForm.init({
            editorDom: $("#listEditor"),
            saveButtonDom: $("#saveListData"),
            checkParams: eval(ypGlobal.checkParams),
            modelDom: detailModal,
            saveBefore: function (saveParams) {
                hotelForm.updateParams({
                    saveUrl: saveParams.id > 0 ? ypGlobal.updateBaseUrl : ypGlobal.createBaseUrl
                });
                saveParams = hotelForm.makeRecord(saveParams, saveParams.id, saveParams.name);
                return saveParams;
            },
            saveSuccess: function (data) {
                hotelList.reLoadList();
            },
            saveFail: function (data) {
                tips.show(data.msg);
            }
        });
        $("#edit_groupid").select2({
            placeholder: '全部',
            language: 'zh-CN'
        });
        // 新建产品
        $("#createData").on('click', function () {
            hotelForm.writeEditor({
                editorDom: $("#listEditor")
            });
            $("#groupEdit").show();
        });
        // 编辑产品
        $("#dataList").on('click', 'button[op=editDataOne]', function () {
            var $editId = $(this).data('dataid'), $dataDom = $("#dataList").find("[dataId=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function (key, value) {
                var dataOne = $(value);
                if (dataOne.attr('type')) {
                    dataList[dataOne.attr('type')] = dataOne.data('value');
                }
            });
            hotelForm.writeEditor({
                editorDom: $("#listEditor"),
                writeData: dataList
            });
            $("#groupEdit").hide();
            detailModal.modal('show');
        });
    }

    function initLanguageEditor() {
        var detailModal = $("#languageEditor"), langList = $("#langList"), languageDom = $("#edit_language"), saveLanguage = $("#saveLanguage");
        $("#dataList").on('click', 'button[op=editLanguage]', function () {
            var $editId = $(this).data('dataid'), $dataDom = $("#dataList").find("[dataId=" + $editId + "]");
            var langKeyListStr = $dataDom.find('td[type=langlist]').data('value');
            saveLanguage.data('dataid', $editId);
            saveLanguage.data('olddata', langKeyListStr);
            var oldData = [];
            languageDom.val('');
            languageDom.find('option').prop('disabled', false);
            langList.html('');
            if (langKeyListStr) {
                var langNameList = {};
                var langKeyList = langKeyListStr.split(',');
                $.each(langKeyList, function (key, value) {
                    var langOption = languageDom.find('option[value=' + value + ']');
                    langNameList[value] = langOption.html();
                    oldData.push(langNameList[value]);
                    langOption.prop('disabled', true);
                });
                langList.html(template('langList_tpl', {langList: langNameList}));
            }
            saveLanguage.data('olddataname', oldData.join(','));
            detailModal.modal('show');
        });
        languageDom.on('change', function () {
            var selectLang = languageDom.val(), selectLangDom = languageDom.find('option:selected');
            if (selectLang == '') {
                return false;
            }
            if (langList.find('[op=langOne]').length >= 3) {
                tips.show('最多支持3种语言');
                return false;
            }
            var langNewList = {};
            langNewList[selectLang] = selectLangDom.html();
            langList.append(template('langList_tpl', {langList: langNewList}));
            selectLangDom.prop('disabled', true);
        });

        langList.sortable().on("sortupdate", function (event, ui) {
        });
        langList.on('click', '[op=deleteLang]', function () {
            if (confirm('确认删除？')) {
                $(this).parents('[op=langOne]').remove();
            }
        });

        saveLanguage.on('click', function () {
            var saveId = saveLanguage.data('dataid');
            var selectLangList = [], selectLangeNameList = [];
            langList.find('[op=langOne]').each(function (key, value) {
                selectLangList.push($(value).data('lang'));
                selectLangeNameList.push($(value).data('langname'));
            });
            var langSaveParams = {};
            langSaveParams.id = saveId;
            langSaveParams.lang = selectLangList.join(',');
            if (langSaveParams.lang != saveLanguage.data('olddata')) {
                var editValue = [];
                editValue.push({
                    title: '物业语言',
                    from: saveLanguage.data('olddataname'),
                    to: selectLangeNameList.join(',')
                });
                recordLog = ypRecord.getEditLog({
                    value: editValue
                });
                langSaveParams[YP_RECORD_VARS.recordPostId] = saveId;
                langSaveParams[YP_RECORD_VARS.recordPostVar] = recordLog;
            }

            saveLanguage.button('loading');
            var xhr = ajax.ajax({
                url: '/hotelajax/updateHotelLangList/',
                type: 'POST',
                data: langSaveParams,
                cache: false,
                dataType: "json",
                timeout: 100000
            });
            xhr.done(function (data) {
                hotelList.reLoadList();
                detailModal.modal('hide');
                saveLanguage.button('reset');
            }).fail(function (data) {
                tips.show(data.msg);
                saveLanguage.button('reset');
            });
        });
    }

    function initMutilContent() {
        var mutilForm = new YP.form, languageNameList = eval(ypGlobal.languageList);
        var mutilCountentEditor = $("#mutilCountentEditor");
        mutilForm.init({
            editorDom: $("#mutilContentListEditor"),
            saveButtonDom: $("#saveMutilContentData"),
            checkParams: ['nameLang1'],
            modelDom: mutilCountentEditor,
            saveUrl: ypGlobal.updateBaseUrl,
            saveBefore: function (saveParams) {
                saveParams = hotelForm.makeRecord(saveParams, saveParams.id, saveParams.name);
                return saveParams;
            },
            saveSuccess: function (data) {
                hotelList.reLoadList();
            },
            saveFail: function (data) {
                tips.show(data.msg);
            }
        });

        $("#dataList").on('click', 'button[op=editMutilContent]', function () {
            var $editId = $(this).data('dataid'), $dataDom = $("#dataList").find("[dataId=" + $editId + "]");
            var dataList = {};
            $dataDom.find('td').each(function (key, value) {
                var dataOne = $(value);
                if (dataOne.attr('type')) {
                    dataList[dataOne.attr('type')] = dataOne.data('value');
                }
            });
            var languageKeyList = dataList.langlist.split(',');
            var languageList = [];
            $.each(languageKeyList, function (key, value) {
                languageList.push({key: value, name: languageNameList[value]});
            });
            $("#mutilContentListEditor").html(template('mutilContentListEditor_tpl', {
                languageList: languageList,
                dataList: dataList
            }));
            mutilCountentEditor.modal('show');
        });
    }

    function init() {
        initHotelList();
        initEditor();
        initLanguageEditor();
        initMutilContent();
    }

    return {
        init: init
    };
})(jQuery, YP_GLOBAL_VARS);

$(function () {
    iAdmin.hotelHotelList.init();
})
