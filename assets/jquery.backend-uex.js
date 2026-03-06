$(function(){
/**
 * 修复后的通用 Modal 处理代码
 */
$(document).on('click', '.modal-view', function(e) {
    e.preventDefault();

    var selecter = $(this).data('modal') == undefined ? '#view-modal' : '#' + $(this).data('modal');
    $(this).tooltip('hide');

    var queryString = $(this).prop('href').split('?')[1];
    var slices = $(this).prop('href').split('?')[0].split('/');
    var controller = slices[slices.length - 2];
    var action = slices[slices.length - 1];
    var ajaxRoute = controller + '/modal-' + action + '?' + queryString;

    $.get(APP.baseUrl + ajaxRoute, function(response) {
        // 1. 先检查是否是嵌套弹窗，如果是，记录当前状态
        var isNested = $('.modal:visible').length > 0;

        $(response).appendTo('body');
        $(selecter).modal('show');

        console.log([isNested, $('.modal:visible').length]);

        // 2. 绑定隐藏后的清理事件（建议用 .one 确保只执行一次，防止重复绑定）
        $(selecter).one('hidden.bs.modal', function() {
            $(this).remove(); // 移除 DOM

            // 【关键修复】
            // 延时执行检查，确保上一个 Modal 的清理逻辑已经结束
            setTimeout(function() {
                if ($('.modal:visible').length > 0) {
                    // 如果还有 Modal 1 在展示，强制补回 modal-open 类
                    $('body').addClass('modal-open');
                }
            }, 250);
        /*
        */
        });

    }).fail(ajax_fail_handler);
});
    /**
     * 全局防止重复提交表单
     *
     * 使用：在所需的表单上增加 .prevent-duplicate-submission 类名
     */
    $(document).on('beforeSubmit', 'form.prevent-duplicate-submission', function () {
        if(jQuery(this).data('submitting')) {
            return false
        }
    
        jQuery(this).data('submitting', true);
        return true;
    });

    // global modal show handler
    $(document).on('show.bs.modal', '.modal', function () {
        // opt in tooltip and popover in modal
        $('[data-toggle="tooltip"]').tooltip();
        $('a:not([data-toggle])').tooltip();
        $('[data-toggle="popover"]').popover();
    });

    /**
     * 将普通的 view action 改用在 Modal 内显示
     */
    $(document).on('click', '.x-modal-view', function(e) {
        e.preventDefault();

        // enable nested .modal-view modal
        var selecter = $(this).data('modal') == undefined ? '#view-modal' : '#' + $(this).data('modal')
        $(this).tooltip('hide');

        var queryString = $(this).prop('href').split('?')[1];
        var slices = $(this).prop('href').split('?')[0].split('/');
        var controller = slices[slices.length - 2];
        var action = slices[slices.length - 1];
        var ajaxRoute = controller + '/modal-' + action + '?' + queryString;

        $.get(APP.baseUrl + ajaxRoute, function(response) {
            // 1. 先检查是否是嵌套弹窗，如果是，记录当前状态
            var isNested = $('.modal:visible').length > 0;

            $(response).appendTo('body');
            $(selecter).modal('show')

            // 2. 绑定隐藏后的清理事件（建议用 .one 确保只执行一次，防止重复绑定）
            $(selecter).one('hidden.bs.modal', function() {
                $(this).remove(); // 移除 DOM
        
                // 【关键修复】
                // 延时执行检查，确保上一个 Modal 的清理逻辑已经结束
                setTimeout(function() {
                    if ($('.modal:visible').length > 0) {
                        // 如果还有 Modal 1 在展示，强制补回 modal-open 类
                        $('body').addClass('modal-open');
                    }
                }, 50);
            });
        }).fail(ajax_fail_handler).always(function(){
            $(document).on('hide.bs.modal', selecter, function() {
                $(selecter).remove()
            });
        })
    });
    /**
     * 通用的高级搜索
     */
    $(document).on('click', '.modal-search', function(e) {
        e.preventDefault();

        var selecter = '#search-modal'
        $(this).tooltip('hide');

        $.get($(this).prop('href'), function(response) {
            $(response).appendTo('body');
            $(selecter).modal('show')
        }).fail(ajax_fail_handler).always(function(){
            $(document).on('hide.bs.modal', selecter, function() {
                $(selecter).remove()
            });
        })
    });
})
