function ajax_fail_handler (XHR, textStatus, errorThrown) {
    var err = {};
    switch (textStatus) {
    case 'timeout':
        err.header = '请求超时';
        break;
    case 'parsererror':
        err.header = '解析器发生错误';
        break;
    case 'error':
        if (XHR.status && !/^\s*$/.test(XHR.status)) {
            err.header = '错误代码： ' + XHR.status;
        } else {
            err.header = '错误';
        }
        if (XHR.responseText && !/^\s*$/.test(XHR.responseText)) {
            var response = jQuery.parseJSON(XHR.responseText);
            err.body = response.name + ': ' + response.message;
        }
        break;
    }

    if (err) {
        $('#general-modal .modal-header h2').text(err.header);
        $('#general-modal').find('.modal-body').html(err.body);
        $('#general-modal').modal();
    }
}

/**
 * PDF printer
 * from http://stackoverflow.com/a/18896318/716273
 */
function PdfUtil(url) {

    var iframe;

    var __construct = function(url) {
        iframe = getContentIframe(url);
    }

    var getContentIframe = function(url) {
        var iframe = document.createElement('iframe');
        iframe.src = url;
        return iframe;
    }

    this.display = function(parentDomElement) {
        parentDomElement.appendChild(iframe);
    }

    this.print = function() {
        try {
            iframe.contentWindow.print();
        } catch(e) {
            throw new Error("Printing failed.");
        }
    }

    __construct(url);
}

(function ( $ ) { 

/* =====================================================
 * Active Form
 *
 * ===================================================== */
    $.fn.afGetYii2 = function ( prefix ) {
        var name = full_name = tag = '';
        var elements = {};

        this.find('[name^='+ prefix +'\\[]').each(function(idx){

            tag = $(this).get(0).tagName;

            full_name = $(this).attr('name');
            name = ((tag == 'INPUT') && ($(this).attr('type') == 'checkbox')) 
                ? $(this).attr('name').split(prefix+'[')[1].slice(0,-3)
                : $(this).attr('name').split(prefix+'[')[1].slice(0,-1);
            if (!elements[name]) {
                if ((tag == 'INPUT') && ($(this).attr('type') == 'hidden'))
                {
                    var a = $(this).next().find('[type="radio"],[type="checkbox"]');
                    if (a.length > 0) {
                        elements[name] = ($(this).next().find('[type="checkbox"]').length > 0)
                        ? $(this).next().find('[name=' + prefix + '\\[' + name + '\\]\\[\\]]')
                        : $(this).next().find('[name=' + prefix + '\\[' + name + '\\]]');
                    } else
                        elements[name] = $('[name=' + prefix + '\\[' + name + '\\]]');
                } else 
                    elements[name] = $('[name=' + prefix + '\\[' + name + '\\]]');
            }

        });
        return elements;
    };

    $.fn.afGet = function ( prefix ) {
        var name = full_name = tag = '';
        var elements = {};

        this.find('[name^='+ prefix +'\\[]').each(function(idx){

            tag = $(this).get(0).tagName;

            full_name = $(this).attr('name');
            name = ((tag == 'INPUT') && ($(this).attr('type') == 'checkbox')) 
                ? $(this).attr('name').split(prefix+'[')[1].slice(0,-3)
                : $(this).attr('name').split(prefix+'[')[1].slice(0,-1);
            if (!elements[name]) {
                elements[name] = ((tag == 'INPUT') && ($(this).attr('type') == 'checkbox'))
                    ? $('[name=' + prefix + '\\[' + name + '\\]\\[\\]]')
                    : $('[name=' + prefix + '\\[' + name + '\\]]');
            }

        });
        return elements;
    };
$.AutoiFrame = function(_o){
        var _o_=new Function("return "+_o)();
            if($.support.msie){
                    $('#'+_o).ready(function(){$('#'+_o).height(_o_.document.body.scrollHeight)});
                        }else{
                                $('#'+_o).load(function(){$('#'+_o).height(_o_.document.body.scrollHeight)});
                                }
                                }


    /**
     * 'fe' means Form Element
     */
    $.fn.feSelect = function(optionId) {
        this.find("option[value="+optionId+"]").attr("selected","selected");
        return this;
    }; 
    $.fn.feType = function() {
        // 'SELECT', 'TEXTAREA'
        var obj = this;
        var tag = obj[0].tagName;
        return tag;
    }; 
    /**
     * feValue: Get/Set form elements' value.
     *  TEXT, RADIO, SELECT, TEXTAREA, HIDDEN
     * Restriction:
     *    1. Radio Button 不能单独使用，外面需有 HTML 区块包裹
     */
    $.fn.feValue = function(value) {
        var obj = this;
        if (obj[0]) {
            var tag = obj[0].tagName;
                        
            if (typeof(value) === 'undefined') {
                // GET
                if (tag == 'SELECT') {
                    var val = this.find('option:selected').val();
                } else if ((tag == 'INPUT') && (this.attr('type') == 'radio')) {
                    var val = this.parent().find(':checked').val();
                    //!var val =  $(this+':checked').val();
                    //!var val =  $(':checked',this).val();
                } else if ((tag == 'INPUT') && ($(this).attr('type') == 'checkbox')) {
                    var c = 0;
                    var v = [];
                    this.each(function(){
                        if ($(this).prop('checked')) {
                            v[c] = $(this).val();
                            c++;
                        }
                    });
                    /*!
                    this.parent().parent().find('[type=checkbox]').each(function(){
                        if ($(this).attr('checked')) {
                            v[c] = $(this).val();
                            c++;
                        }
                    });
                    */
                    var val = (v.length > 0) ? v.join(',') : '';
                } else {
                    var val = $(this).val();
                }
                return val;
            } else {
                // SET
                if (tag == 'SELECT') {
                    this.find('option[value="'+value+'"]').prop('selected',true);
                } else if ((tag == 'INPUT') && (this.attr('type') == 'radio')) {
                    // Why? @2013年9月29日
                    //!$('[value=mainland]',this).attr('checked','checked');
                    this.parents('.form-group').first().find('input[value="'+value+'"]').prop('checked', true);
                } else if ((tag == 'INPUT') && (this.attr('type') == 'checkbox')) {
                    // value is an array
                    for (var i=0; i<value.length; i++) {
                        this.parents('.form-group').first().find('[value="'+value[i]+'"]').prop('checked',true);
                    }
                } else {
                    $(this).val(value);
                }
                return this;
            }
        } else {
            return false;
        }
    }; 

    /**    
     * !DEPRECATED! Use $.fn.feValue() instead.
     */
    $.fn.feActiveValue = function() {
        // 'SELECT', 'TEXTAREA'
        var obj = this;
        var tag = obj[0].tagName;
        //var tag = $(this)[0].tagName;
        if ( ( tag == 'TEXTAREA') || ( (tag == 'INPUT') && (this.attr('type') == 'text') ) ) {
            //文本
            var val = $(this).val();
        } else if ((tag == 'INPUT') && (this.attr('type') == 'radio')) {
            // 按钮
            return $(this+':checked').val();
        } else if (tag == 'SELECT') {
            // 下拉菜单
            var val = this.find('option:selected').val();
        }
        return val;
    }; 
    $.fn.feDisable = function() {
        this.attr("disabled","disabled");
        return this;
    }; 
    $.fn.feSetName = function(val) {
        this.attr("name",val);
        return this;
    }; 
    /**
     * A shorthand for Bootstrap's Modal plugin
     *
     * Usage sample:
     *
     * $('#general-modal').quickModal({
     *     header: 'Upcoming',
     *     content: 'Create customer / address without leaving this page.'
     *      size: 'lg', 'sm', default to ''
     * });
     * 
     */
    $.fn.quickModal = function(config) {
        this.find('.modal-header > h2').html( config.header );
        this.find('.modal-body').empty().html( config.content );
        this.find('.modal-footer').empty().html( config.footer );

        /*
        if (typeof(config.size) != 'undefined' && $.inArray(config.size, ['lg', 'sm'])) {
            this.find('.modal-dialog').attr('class', 'modal-dialog modal-' + config.size);
        } else {
        }
        */
        this.find('.modal-dialog').attr('class', 'modal-dialog modal-' + config.size);
        this.modal('show');
        return this;
    }; 

    
    $.ltrim = function( str ) {
        return str.replace( /^\s+/, "" );
    }; 

    $.print_a = function( arr ) {
        // Ref. http://stackoverflow.com/questions/5289403/jquery-convert-javascript-array-to-string
        var blkstr = [];
        $.each(arr, function(idx2,val2) {                    
                 var str = idx2 + ": " + val2;
                  blkstr.push(str);
          });
          alert(blkstr.join("\n"));
        return false;
    }
    /**
     *
     * via: http://stackoverflow.com/questions/22581345/click-button-copy-to-clipboard-using-jquery
     */
    $.copyToClipboard = function( elem ) {
        // create hidden text element, if it doesn't already exist
        var targetId = "_hiddenCopyText_";
        var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
        var origSelectionStart, origSelectionEnd;
        if (isInput) {
            // can just use the original source element for the selection and copy
            target = elem;
            origSelectionStart = elem.selectionStart;
            origSelectionEnd = elem.selectionEnd;
        } else {
            // must use a temporary form element for the selection and copy
            target = document.getElementById(targetId);
            if (!target) {
                var target = document.createElement("textarea");
                target.style.position = "absolute";
                target.style.left = "-9999px";
                target.style.top = "0";
                target.id = targetId;
                document.body.appendChild(target);
            }
            target.textContent = elem.textContent;
        }
        // select the content
        var currentFocus = document.activeElement;
        target.focus();
        target.setSelectionRange(0, target.value.length);
        
        // copy the selection
        var succeed;
        try {
        	  succeed = document.execCommand("copy");
        } catch(e) {
            succeed = false;
        }
        // restore original focus
        if (currentFocus && typeof currentFocus.focus === "function") {
            currentFocus.focus();
        }
        
        if (isInput) {
            // restore prior selection
            elem.setSelectionRange(origSelectionStart, origSelectionEnd);
        } else {
            // clear temporary content
            target.textContent = "";
        }
        return succeed;
    }; 
    /**
     * Get query string pairs in an url
     *
     * Usage: console.log($.getQueries());
     *
     */
    $.getQueries = function() {
        var queries = {};
        if (document.location.search != '') {
            $.each( document.location.search.substr(1).split('&'), function(c, q){
                var pair = q.split('=');
                queries[ pair[0].toString() ] = pair[1].toString();
            });
        }
        return queries;
    };
}( jQuery ));

// enable modal overlay
$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
    }, 0);
});

/**
 * Usage:
 *
 * display_modal_error(af, response, {user: 'User'})
 */
function display_modal_error(af, response, modelMap)
{
    console.log(af);
    // remove error style in last failed submit
    af.find('.has-error').each(function(){
        $(this).removeClass('has-error');
        $(this).popover('destroy');
    })
    af.find('.help-block').each(function(){
        $(this).empty();
    })
    
    for (var model in response.error) {
        for (var attribute in response.error[model]) {
            var ae = $('[name='+modelMap[model]+'\\['+attribute+'\\]]');
            var formGroup = ae.parents('.form-group').first();
            formGroup.addClass('has-error');
            formGroup.find('.help-block').empty().text(response.error[model][attribute][0]);
        }
    }
}


/**
 * @author Alexander Manzyuk <admsev@gmail.com>
 * Copyright (c) 2012 Alexander Manzyuk - released under MIT License
 * https://github.com/admsev/jquery-play-sound
 * Usage: $.playSound('http://example.org/sound');
**/
(function($){

  $.extend({
    playSound: function(){
      return $(
        '<audio autoplay="autoplay" style="display:none;">'
          + '<source src="' + arguments[0] + '.mp3" />'
          + '<source src="' + arguments[0] + '.ogg" />'
          + '<embed src="' + arguments[0] + '.mp3" hidden="true" autostart="true" loop="false" class="playSound" />'
        + '</audio>'
      ).appendTo('body');
    }
  });

})(jQuery);
