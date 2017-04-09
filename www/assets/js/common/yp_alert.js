var YP = YP || {};
YP.alert = (function($) {
    var isAppended = false, elem = null;

    $(window).scroll(function() {
        var header = $('#header');
        var errorMsgContent = $("#errorMsgContent");
        if (errorMsgContent.length <= 0) {
            return false;
        }
        if ($(window).scrollTop() >= header.height() || $(".modal-backdrop").length) {
            errorMsgContent.addClass('top0 fix');
        } else {
            errorMsgContent.removeClass('top0 fix');
        }
    });

    function showTipDiv(type) {
        var header = $('#header');
        var div = $('<div class="alert alertStyle alert-' + type + '" role="alert" id="errorMsgContent"></div>');
        if ($(window).scrollTop() >= header.offset().top + header.height() || $(".modal-backdrop").length) {
            div.addClass('top0 fix');
        } else {
            div.removeClass('top0 fix');
        }
        if (!isAppended) {
            elem = div.insertAfter(header)
        }
        return elem;
    }

    return {
        show : function(msg, type, time) {
            if (!msg) {
                return false;
            }
            // info success warning danger
            var type = type || 'danger', time = time * 1000 || 5000;
            var tips = showTipDiv(type);
            if (type != "success") {
                msg = msg;
            }
            tips.slideDown().html(msg);
            setTimeout(function() {
                tips.slideUp();
            }, time);
        }
    }
})(jQuery);