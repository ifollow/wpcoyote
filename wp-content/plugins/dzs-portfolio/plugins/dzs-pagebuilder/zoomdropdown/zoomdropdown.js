
if (jQuery) (function ($) {

    $.fn.prependOnce = function(arg, argfind) {
        var _t = $(this[0]) // It's your element
        if(_t.children(argfind).length<1){
            _t.prepend(arg);
        }
    };
    $.fn.appendOnce = function(arg, argfind) {
        var _t = $(this[0]) // It's your element
        if(_t.children(argfind).length<1){
            _t.append(arg);
        }
    };
    $.fn.zoomdropdown = function(o) {
        var defaults = {
            design_skin : 'skin-default'
            ,settings_method: 'click'
        }

        o = $.extend(defaults, o);

        this.each( function() {

            var cthis = $(this);
            var cclass = cthis.attr('class');
            var _dd = cthis.find('.zoomdropdown').eq(0);

            if(!cthis.hasClass('treated')){
                init();
            }

            function init(){

                if(cclass.indexOf('skin-')==-1){
                    cthis.addClass(o.design_skin);
                }
                if(o.settings_method=='click'){
                    cthis.find('.the-label').eq(0).unbind('click');
                    cthis.find('.the-label').eq(0).bind('click',click_label);
                }
                cthis.addClass('treated');
            }

            function click_label(e){
                //console.log('ceva');
                if(cthis.hasClass('active')){
                    hide_dd();
                }else{
                    show_dd();
                }

            }
            function show_dd(){
                cthis.addClass('active');
            }
            function hide_dd(){
                cthis.removeClass('active');
                //console.log(cthis.hasClass('active'));
            }
            
            return this;
        });//end each
    }
    window.zoomdropdown_init = function(selector, settings) {
        $(selector).zoomdropdown(settings);
    };
})(jQuery);