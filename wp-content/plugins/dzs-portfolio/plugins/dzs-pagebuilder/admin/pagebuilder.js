var i =0;
var pagebuilder_lts_mousedown = false;
var pagebuilder_lts_mousedown_int = 0;
var pagebuilder_lasttarget = undefined;


var _pagebuilderWrap;
var _wrapBuild;
var pb_firsttransform_topb = true;

top.dzspb_receiver = function(arg){

    //top.dzspb_textsel = _con.find('.the-layout-body-content').eq(0).val();
    top.dzspb_target.val(arg);
    top.dzspb_target.trigger('change');
    jQuery.fn.zoomBox.close();

};


top.dzspb_receiver_type = function(arg){

    //top.dzspb_textsel = _con.find('.the-layout-body-content').eq(0).val();

    ///console.info(arg)

    top.dzspb_target_type_con.find('.field-title').eq(0).val(arg);
    jQuery.fn.zoomBox.close();

    update_layout_names();


};

(function($){
    //console.info('ceva');
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


})(jQuery);


//==global function
jQuery(document).ready(function($){
//    console.info('ceva');

    if(typeof(window.pagebuilder_settings)=='undefined'){
        return;
    }

    $('.saveconfirmer').fadeOut('fast');
//    console.log($('.wrap-build'))
    $('.wrap-build').sortable({
        placeholder: "ui-state-highlight",
        items: ' > .dzs-layout',
        handle: ".dzs-layout-head",
        stop: function (e, ui){
            var _t = $(this);
            var index = _t.parent().children().index(_t);

            _t.parent().removeClass('dragging-sortable');
            calculate_layouts();
            update_layout_names();
            save_layout();
        },
        start: function (e, ui){
            var _t = $(this);
            if(_t.parent().attr('class').indexOf('dragging-')==-1)
                _t.parent().addClass('dragging-sortable');
        }
    })

    $('.wrap-widgets .dzs-layout').draggable({
        handle: '.dzs-layout-head',
        helper:"clone",
        connectToSortable: ".wrap-build",
        start:function(e, ui){
            var _t = $(this);
            _t.removeClass('static');

        },
        stop:function(e, ui){
            var _t = $(this);
            _t.parent().parent().parent().removeClass('dragging-fullwidth');
            _t.parent().parent().parent().removeClass('dragging-one_half');
            _t.parent().parent().parent().removeClass('dragging-one_third');
            _t.parent().parent().parent().removeClass('dragging-two_third');
            _t.parent().parent().parent().removeClass('dragging-one_fourth');
            _t.parent().parent().parent().removeClass('dragging-three_fourth');
            _t.parent().parent().parent().removeClass('dragging-sortable');
            make_droppable();
            update_layout_names();
        },
        drag:function(e, ui){

            var _t = $(this);

            if (_t.attr('rel') == '1/1'){
                //if(parseInt($('.ui-draggable-dragging').css('width'))!=700)
                //$('.ui-draggable-dragging').css('width', 700)
            }
            if (_t.attr('rel') == '1/2+1/2'){
                if(_t.children('.dzs-layout-body').length<2){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
            }
            if (_t.attr('rel') == '1/3+2/3'){
                //console.log()
                if(_t.children('.dzs-layout-body').length<2){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_third');
                _t.children('.dzs-layout-body').eq(1).addClass('two_third last');
            }
            if (_t.attr('rel') == '2/3+1/3'){
                if(_t.children('.dzs-layout-body').length<2){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('two_third');
                _t.children('.dzs-layout-body').eq(1).addClass('one_third last');
            }
            if (_t.attr('rel') == '1/4+3/4'){
                if(_t.children('.dzs-layout-body').length<2){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(1).addClass('three_fourth last');
            }
            if (_t.attr('rel') == '3/4+1/4'){
                if(_t.children('.dzs-layout-body').length<2){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('three_fourth');
                _t.children('.dzs-layout-body').eq(1).addClass('one_fourth last');
            }
            if (_t.attr('rel') == '1/3+1/3+1/3'){
                if(_t.children('.dzs-layout-body').length<3){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_third');
                _t.children('.dzs-layout-body').eq(1).addClass('one_third');
                _t.children('.dzs-layout-body').eq(2).addClass('one_third last');
            }
            if (_t.attr('rel') == '1/2+1/4+1/4'){
                if(_t.children('.dzs-layout-body').length<3){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_half');
                _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(2).addClass('one_fourth last');
            }
            if (_t.attr('rel') == '1/4+1/2+1/4'){
                if(_t.children('.dzs-layout-body').length<3){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(1).addClass('one_half');
                _t.children('.dzs-layout-body').eq(2).addClass('one_fourth last');
            }
            if (_t.attr('rel') == '1/4+1/4+1/2'){
                if(_t.children('.dzs-layout-body').length<3){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(2).addClass('one_half last');
            }
            if (_t.attr('rel') == '1/4+1/4+1/4+1/4'){
                if(_t.children('.dzs-layout-body').length<4){
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                    _t.append(pagebuilder_settings.structure_layoutbody);
                }
                _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(2).addClass('one_fourth');
                _t.children('.dzs-layout-body').eq(3).addClass('one_fourth last');
            }
        }
    })
    $('.dzs-widget').draggable({
        helper:"clone"
    })
    $(document).delegate('.item-close','click', function(){
        var _t = jQuery(this);
        _t.parent().parent().remove();
        calculate_layouts();
        save_layout();
    })

    $(document).delegate('.the-layout-body-content','change', function(){
        calculate_layouts();
        save_layout();
    });


    $(document).delegate('.the-layout-body-content','focus', function(){
        var _t = $(this);

        top.dzspb_lastfocused = _t;
    });



    $('.btn-savePage').bind('click', function(){
//        console.info('ceva');
        save_layout();

        /*


         $.ajax({
         url: pagebuilder_settings.ajaxurl,
         type: 'POST',
         data: data,
         dataType: 'html',
         success: function(response) {

         if(window.console) { console.log('Got this from the server: ' + response); };
         jQuery('.saveconfirmer').html('Options saved.');
         jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
         }
         });

         */

        return false;
    });


    $(document).delegate('.ui-config','click', function(){
        var _t = jQuery(this);

        var _con = _t.parent().parent();

        top.dzspb_textsel = _con.find('.the-layout-body-content').eq(0).val();
        top.dzspb_target = _con.find('.the-layout-body-content').eq(0);

        //console.info(_t, _con, top.dzspb_textsel);

        if(_con.find('.field-title').eq(0).val() == "Gallery"){
            $.fn.zoomBox.setOptions({design_animation: 'noanim', settings_extraClasses:'no-loading', settings_disableSocial: 'on'});
            $.fn.zoomBox.open(dzspb_settings.thepath + 'tinymce/popupiframe_as.php?iframe=true', 'iframe', {width: 700, height: 900});
        }
    });

    $(document).delegate('.switcher-type','click', function(){
        var _t = jQuery(this);

        var _con = _t.parent().parent();

        //top.dzspb_textsel = _con.find('.the-layout-body-content').eq(0).val();
        //top.dzspb_target = _con.find('.the-layout-body-content').eq(0);
        top.dzspb_target_type_con = _con;
        //console.info(_con);
        $.fn.zoomBox.setOptions({design_animation: 'noanim', settings_extraClasses:'no-loading', settings_disableSocial: 'on'});
        $.fn.zoomBox.open(dzspb_settings.thepath + 'tinymce/popupiframe_types.php?iframe=true', 'iframe', {width: 700, height: 900});

    });

    var click_modifier = false;
    $('.template-item.active').bind('mousedown',function(){
        var _t = $(this);
        _t.find('input').eq(0).trigger('focus');
        return false;
        //pagebuilder_lts_mousedown_int = setTimeout()
    })
    $(window).bind('mouseup',function(){

    })
    $('.template-item').bind('mousedown',function(e){
        click_modifier = false;
        setTimeout(function(){
            e.preventDefault();
            click_modifier = true;
            return false;
        },1000)
    })
    $('.template-item').bind('mouseup',function(e){
        //console.log('hmm');
        return false;
    })
    $('.template-item').bind('click',function(e){

        if(click_modifier){
            return false;
        }
    })
    $('.template-item.active').bind('click',function(){
        return false;
    })
    $('.template-item input').bind('keyup',function(){
        var _t = $(this);
        //console.info(_t);

        _t.css('width', (_t.textWidth() + 5));
    })
    $('.template-item input').trigger('keyup');


    $('.template-item input').bind('change', change_templatename);


    $('.savetemplate').bind('click', click_savetemplate);


    $(document).delegate('.dd-selectitem-layout','click', click_selectlayout);
    $(document).delegate('.dd-selectitem-type','click', click_selecttype);


    make_droppable();
    update_layout_names();
});

function click_selectlayout(){
    var _t = jQuery(this);

    var val = _t.html();
    if(val=="1/4 * 4"){
        val = '1/4+1/4+1/4+1/4'
    }
//    console.info(val);

    _t.parent().parent().removeClass('active');// === .zoomdropdown-con
    _t.parent().parent().parent().parent().attr('rel',val);// === .dzs-layout
    _t.parent().parent().parent().parent().find('.field-rel').eq(0).val(val); // == the hidden rel field

    update_layout_names();
    save_layout();
}


function click_selecttype(){
    var _t = jQuery(this);

    var san_title = _t.html();
    san_title = san_title.replace(/ /gi, "-");

    _t.parent().parent().removeClass('active');// === .zoomdropdown-con
    _t.parent().parent().find('.the-label').eq(0).html(_t.html());
    _t.parent().parent().parent().parent().removeClass('title-Simple title-Content title-Gallery');
    _t.parent().parent().parent().parent().addClass('title-'+san_title);
    _t.parent().parent().parent().parent().find('.field-title').eq(0).val(_t.html());



    update_layout_names();
    save_layout();
}

function save_layout(){

//    console.info(window.pagebuilder_settings.mode)
    if(typeof window.pagebuilder_settings=='undefined'){
        return;
    }

    if(window.pagebuilder_settings.mode=='meta'){
        var mainarray = jQuery('.wrap-build').serializeAnything();

        //console.info(mainarray)
        var data = {
            action: 'pagebuilder_save'
            ,postdata: mainarray
            ,pageid: window.pagebuilder_settings.pageid
        };

        //console.info(pagebuilder_settings.ajaxurl, ajaxurl, data);

        jQuery.post(pagebuilder_settings.ajaxurl, data, function(response) {
            if(window.console) { console.log('Got this from the server: ' + response); };
            jQuery('.saveconfirmer').html('Options saved.');
            jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
        });
    }
    if(window.pagebuilder_settings.mode=='misc'){
        var mainarray = jQuery('.wrap-build').serializeAnything();

        //console.info(mainarray)
        var data = {
            action: 'pagebuilder_save'
            ,postdata: mainarray
            ,pageid: window.pagebuilder_settings.pageid
        };

        //console.info(pagebuilder_settings.ajaxurl, ajaxurl, data);

        jQuery.post(pagebuilder_settings.ajaxurl, data, function(response) {
            if(window.console) { console.log('Got this from the server: ' + response); };
            jQuery('.saveconfirmer').html('Options saved.');
            jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
        });
    }
    if(window.pagebuilder_settings.mode=='editor'){
        // === editor save / transport data to content
        var fout = '';
        _wrapBuild.children('.dzs-layout').each(function(){
            var _t = jQuery(this);
            if(_t.attr('rel')=='raw'){
                fout+='[pb_lay_raw]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_lay_raw]'
            }
            if(_t.attr('rel')=='1/1'){
                fout+='[pb_lay_one_full]';
                fout+='[pb_layb_one_full';
                fout+=' type="'+_t.find('.field-title').eq(0).val()+'"';
                fout+=']';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_full]';
                fout+='[/pb_lay_one_full]'
            }
            if(_t.attr('rel')=='1/2+1/2'){
                //console.log(_t); //field-title
                fout+='[pb_lay_one_half_one_half]';
                fout+='[pb_layb_one_half';
                fout+=' type="'+_t.find('.field-title').eq(0).val()+'"';
                fout+=']';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_half]';
                fout+='[pb_layb_one_half';
                fout+=' type="'+_t.find('.field-title').eq(1).val()+'"';
                fout+=']';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_half]';
                fout+='[/pb_lay_one_half_one_half]'
            }
            if(_t.attr('rel')=='2/3+1/3'){
                fout+='[pb_lay_two_third_one_third]';
                fout+='[pb_layb_two_third]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_two_third]';
                fout+='[pb_layb_one_third]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_third]';
                fout+='[/pb_lay_two_third_one_third]'
            }
            if(_t.attr('rel')=='1/3+2/3'){
                fout+='[pb_lay_two_third_one_third]';
                fout+='[pb_layb_one_third]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_third]';
                fout+='[pb_layb_two_third]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_two_third]';
                fout+='[/pb_lay_two_third_one_third]'
            }
            if(_t.attr('rel')=='1/3+1/3+1/3'){
                fout+='[pb_lay_one_third_one_third_one_third]';
                fout+='[pb_layb_one_third]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_third]';
                fout+='[pb_layb_one_third]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_third]';
                fout+='[pb_layb_one_third]';
                fout+=_t.find('.the-layout-body-content').eq(2).val();
                fout+='[/pb_layb_one_third]';
                fout+='[/pb_lay_one_third_one_third_one_third]'
            }
            if(_t.attr('rel')=='1/2+1/4+1/4'){
                fout+='[pb_lay_one_half_one_fourth_one_fourth]';
                fout+='[pb_layb_one_half]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_half]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(2).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[/pb_lay_one_half_one_fourth_one_fourth]'
            }
            if(_t.attr('rel')=='1/4+1/2+1/4'){
                fout+='[pb_lay_one_half_one_fourth_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_half]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_half]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(2).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[/pb_lay_one_half_one_fourth_one_fourth]'
            }
            if(_t.attr('rel')=='1/4+1/4+1/2'){
                fout+='[pb_lay_one_fourth_one_fourth_one_half]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_half]';
                fout+=_t.find('.the-layout-body-content').eq(2).val();
                fout+='[/pb_layb_one_half]';
                fout+='[/pb_lay_one_fourth_one_fourth_one_half]'
            }
            if(_t.attr('rel')=='1/4+1/4+1/4+1/4'){
                fout+='[pb_lay_one_fourth_one_fourth_one_fourth_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(0).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(1).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(2).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[pb_layb_one_fourth]';
                fout+=_t.find('.the-layout-body-content').eq(3).val();
                fout+='[/pb_layb_one_fourth]';
                fout+='[/pb_lay_one_fourth_one_fourth_one_fourth_one_fourth]'
            }


            var textarea = document.getElementById("content");
//            console.info(textarea);

            if(textarea!=null){
                textarea.value = fout;
                if (jQuery("#wp-content-wrap").hasClass("tmce-active")){
                    var ed = window.tinyMCE.activeEditor;
                    var sel=ed.setContent(fout, {format : 'raw'});
                    //console.log(ed);
                    //console.info(cnt);
                }else{
                    //console.log(window.tinyMCE.activeEditor);
                    //console.info(cnt);
                }
            }


        })
        //console.log(fout);
    }
}

function click_savetemplate(){

    var mainarray = jQuery('.wrap-build').serializeAnything();

    //console.info(mainarray)
    var data = {
        action: 'pagebuilder_save'
        ,postdata: mainarray
        ,sliderid: window.pagebuilder_settings.currSlider
        ,slidername: window.pagebuilder_settings.templatename
    };

    //console.info(pagebuilder_settings.ajaxurl, ajaxurl, data);

    jQuery.post(pagebuilder_settings.ajaxurl, data, function(response) {
        if(window.console) { console.log('Got this from the server: ' + response); };
        jQuery('.saveconfirmer').html('Options saved.');
        jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
    });

    return false;
}
function change_templatename(){

    var _t = jQuery(this);
    var ind = _t.parent().parent().children().index(_t.parent());



    var data = {
        action: 'pagebuilder_changetemplatename'
        ,postdata: _t.val()
        ,template_ind: ind
    };


    jQuery.post(pagebuilder_settings.ajaxurl, data, function(response) {
        if(window.console) { console.log('Got this from the server: ' + response); };
        jQuery('.saveconfirmer').html('Options saved.');
        jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
    });

    //console.info(_t, _t.parent(), ind);


}
function check_mousedownonlt(){

}
//end document ready
function make_droppable(){

    jQuery('.wrap-build .dzs-layout-body').droppable({
        accept: ".dzs-widget",
        tolerance: 'pointer',
        deactivate: function(e,ui){
            var _t = jQuery(this);
            _t.css('opacity', '1');
        },
        drop: function(e,ui){
            var _t = jQuery(this);
            var _arg = ui.draggable;
            var rel= _arg.attr('rel');

           // console.log(_t, _arg);
            if(rel=='widget-advancedscroller'){

                _t.find('.the-title').eq(0).html('Gallery');
                _t.find('.field-title').eq(0).val('Gallery');
                update_layout_names();
                save_layout();
            }


            if(rel=='widget-content'){

                _t.find('.the-title').eq(0).html('Content');
                _t.find('.field-title').eq(0).val('Content');
                update_layout_names();
                save_layout();
            }
            if(rel=='widget-simple'){

                _t.find('.the-title').eq(0).html('Simple');
                _t.find('.field-title').eq(0).val('Simple');
                update_layout_names();
                save_layout();
            }

            _t.css('opacity', '1');
        },
        over: function(e,ui){
            var _t = jQuery(this);
            _t.css('opacity', '0.5');
        },
        out: function(e,ui){
            var _t = jQuery(this);
            _t.css('opacity', '1');
        }
    })
}
function calculate_layouts(){
    var _c = jQuery('.build-wrap');
    _c.find('.clear').remove();
    var c_buf = 0;
    for(i=0;i<_c.children().length;i++){
        _c2= _c.children().eq(i);
        if(_c2.attr('rel')=='1/1' || _c2.attr('rel')=='raw'){
            c_buf+=1;
        }

        if(_c2.attr('rel')=='1/2')
            c_buf+=0.5;
        if(_c2.attr('rel')=='1/3')
            c_buf+=0.34;
        if(_c2.attr('rel')=='2/3')
            c_buf+=0.67;
        if(_c2.attr('rel')=='1/4')
            c_buf+=0.25;
        if(_c2.attr('rel')=='3/4'){
            c_buf+=0.75;
        }


        if(c_buf>=1){
            _c2.addClass('last');
            _c2.after(function() {
                return '<div class="clear"></div>';
            });

            if(c_buf>=1.2){
                _c2.before(function() {
                    return '<div class="clear"></div>';
                });

            }
            c_buf=0;
        }else{
            _c2.removeClass('last');
        }
    }
}
function update_layout_names(){

    //function which sets the layout bodies classes
    var ind =0;
    jQuery('.wrap-build .dzs-layout').each(function(){
        var _t = jQuery(this);

        _t.children('.dzs-layout-body').each(function(){

            //===layout bodies LOOP
            var _t2 = jQuery(this);

            //console.log(_t2);
            if(_t2.find('.field-title').eq(0).val()=="Gallery"){

                _t2.find('.dzs-layout-body-header').eq(0).appendOnce('<div class="ui-config"><i class="fa fa-pencil-square-o"></i> Config</div>', '.ui-config');
            }else{
                _t2.find('.dzs-layout-body-header').eq(0).find('.ui-config').remove();
            }

            //console.info(_t2.find('.field-title').eq(0));

            if(_t2.find('.field-title').eq(0).val()=="Content" || _t2.find('.field-title').eq(0).val()=="Separator"){
                _t2.find('.the-layout-body-content').val("");
                if(_t2.find('.field-title').eq(0).val()=="Content"){
                    _t2.find('.the-layout-body-content').val("//the post content you write in the editor will appear here");
                }
                _t2.find('.the-layout-body-content').attr('disabled', 'disabled');
            }else{
                _t2.find('.the-layout-body-content').removeAttr('disabled');
            }


            _t2.removeClass('title-Simple title-Content');
            _t2.addClass('title-' + _t2.find('.field-title').eq(0).val());
        })

        //console.log(_t);
        _t.children('.dzs-layout-body').removeClass('one_half one_third two_third one_fourth three_fourth last')
        while(_t.children('.dzs-layout-body').length<4){
            _t.append(window.pagebuilder_settings.structure_layoutbody);
        }
        //console.info(_t.children('.dzs-layout-body').length);

        if (_t.attr('rel') == '1/1'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_full');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == 'raw'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_full');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/2+1/2'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_half');
            _t.children('.dzs-layout-body').eq(1).addClass('one_half last');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }


        if (_t.attr('rel') == '1/3+2/3'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_third');
            _t.children('.dzs-layout-body').eq(1).addClass('two_third last');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '2/3+1/3'){
            _t.children('.dzs-layout-body').eq(0).addClass('two_third ');
            _t.children('.dzs-layout-body').eq(1).addClass('one_third last');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
            //console.log(_t.children('.dzs-layout-body'))
        }
        if (_t.attr('rel') == '1/4+3/4'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(1).addClass('three_fourth last');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '3/4+1/4'){
            _t.children('.dzs-layout-body').eq(0).addClass('three_fourth');
            _t.children('.dzs-layout-body').eq(1).addClass('one_fourth last');
            _t.children('.dzs-layout-body').last().remove();
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/3+1/3+1/3'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_third');
            _t.children('.dzs-layout-body').eq(1).addClass('one_third');
            _t.children('.dzs-layout-body').eq(2).addClass('one_third last');
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/2+1/4+1/4'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_half');
            _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(2).addClass('one_fourth last');
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/4+1/2+1/4'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(1).addClass('one_half');
            _t.children('.dzs-layout-body').eq(2).addClass('one_fourth last');
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/4+1/4+1/2'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(2).addClass('one_half last');
            _t.children('.dzs-layout-body').last().remove();
        }
        if (_t.attr('rel') == '1/4+1/4+1/4+1/4'){
            _t.children('.dzs-layout-body').eq(0).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(1).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(2).addClass('one_fourth');
            _t.children('.dzs-layout-body').eq(3).addClass('one_fourth last');
        }
        //console.log(_t, ind);

        for(i=0;i<4;i++){
            _t.find('textarea').eq(i).attr('name', 'layout['+ind+']['+i+'][content]');
            _t.find('.field-title').eq(i).attr('name', 'layout['+ind+']['+i+'][title]');
            _t.find('.switcher-type').eq(i).find('.the-label').eq(0).html(_t.find('.field-title').eq(i).val());
        }

        //console.info(_t.find('.field-rel').eq(0), _t.find('.chooser-layout .the-label').eq(0));
        _t.find('.field-rel').eq(0).attr('name', 'layout['+ind+'][settings][rel]');
        _t.find('.chooser-layout .the-label').eq(0).html(_t.find('.field-rel').eq(0).val());


        ind++;

        zoomdropdown_init('.wrap-build .zoomdropdown-con', {});
    })
}






function dzspb_builder_ready(){
    if(typeof window.pagebuilder_settings=="undefined"){
        return;
    }


    jQuery('#wp-content-editor-tools').before('<input type="hidden" class="" name="dzspb_last_editor" id="dzspb_last_editor" value="classiceditor" />');
    if(window.pagebuilder_settings.mode=='editor'){



        jQuery('#wp-content-editor-tools').before('<input onclick="return false;" type="submit" class="button button-primary" id="dzspb_switch_editor" value="Switch to Page Builder"/>');


        jQuery('#dzspb_switch_editor').bind('click', click_switch_editor);


        //we add the "dzspb-pagebuilder-con" div and append the pagebuilder from the footer to it
        jQuery('#post-body-content').append('<div id="dzspb-pagebuilder-con" style="display: none;"></div>');
        jQuery('body').append('<div id="dzspb-aux-structurer"></div>');
        jQuery('#dzspb-pagebuilder-con').append(jQuery('.aux-pb-holder').children());

        _pagebuilderWrap = jQuery('.pagebuilder-wrap').eq(0);
        _wrapBuild = _pagebuilderWrap.find('.wrap-build').eq(0);

    }
    //console.info(window.pagebuilder_settings.last_editor);
    setTimeout(function(){
        if(window.pagebuilder_settings.last_editor=='pagebuilder'){
            switch_pb();
        }
    },1000)

}

function click_switch_editor(){
    var _t = jQuery(this);



    if(_t.val()=='Switch to Page Builder'){
        switch_pb();
    }else{

        switch_ce();
    }
    return false;
}

function switch_ce(){
    //===switch classic editor
    save_layout();
    jQuery('input[name=dzspb_last_editor]').val('classiceditor');
    jQuery('#dzspb-pagebuilder-con').hide();

    jQuery('#post-status-info, #insert-media-button, #content-tmce, #content-html').show();
    jQuery('#wp-content-editor-container').show();
    jQuery('#dzspb_switch_editor').val('Switch to Page Builder');
}

function switch_pb(){
    //===switch page builder
    //console.log('ie');



    var cnt = '';



    if (jQuery("#wp-content-wrap").hasClass("tmce-active")){
        var ed = window.tinyMCE.activeEditor;
        var sel=ed.getContent({format : 'raw'});
        //console.log(ed);
        cnt = sel;
        //console.info(cnt);
    }else{
        //console.log(window.tinyMCE.activeEditor);
        var textarea = document.getElementById("content");
        cnt = textarea.value;
        //console.info(cnt);
    }

    //console.log(cnt);




//    console.info(pb_firsttransform_topb);

    if(pagebuilder_settings.last_editor != 'pagebuilder' || pagebuilder_settings.currSlider=='' || pagebuilder_settings.currSlider=='none' || pb_firsttransform_topb==false) {

    _wrapBuild.children('.dzs-layout').remove();


    var myRe = /\[pb_lay_.*?\][\s\S]*?\[\/pb_lay_.*?\]/;
    for(i=0;i<10 || myRe.test(cnt)==false ;i++){

        //console.info(i);

        var myArray = cnt.match(myRe);
        //console.log(myArray);

        if(myArray==null || myArray.length==0){
            break;;
        }

        var aux_str = (myArray[0]);
        var san_aux_str = aux_str;

        //==bogus characters
        if(san_aux_str.indexOf(']</p>') > -1){
            san_aux_str = san_aux_str.replace(']</p>', ']');
        }
        if(san_aux_str.indexOf('<p>[/pb_lay') > -1){
            san_aux_str = san_aux_str.replace('<p>[/pb_lay', '[/pb_lay');
        }

        san_aux_str = san_aux_str.replace('<br data-mce-bogus="1">', '');



        var san_aux_str_cont = san_aux_str;

        var re_findcont = /(\[pb_lay_.*?\]|\[\/pb_lay_.*?\])/g;

        san_aux_str_cont = san_aux_str.replace(re_findcont, '');

        if(san_aux_str_cont=='<p></p>'){
            continue;
        }
        if(san_aux_str_cont=='<p><br data-mce-bogus="1"></p>'){
            continue;
        }



        //console.log(san_aux_str_cont);

        //===some annoying bogus tinymce output :( we need to eliminate it!
        var regex_bogus_endp = /(\])<\/p>/g;
        var regex_bogus_startp = /<p>(\[)/g;


        //console.log(regex_bogus_endp.exec(san_aux_str_cont));

        san_aux_str_cont = san_aux_str_cont.replace(regex_bogus_endp, "$1");
        san_aux_str_cont = san_aux_str_cont.replace(regex_bogus_startp, "$1");
        san_aux_str_cont = san_aux_str_cont.replace(/<p>&nbsp;<\/p>/g, '');;
        san_aux_str_cont = san_aux_str_cont.replace(/<p><\/p>/g, '');;

        //console.log(san_aux_str_cont);

        if(san_aux_str.indexOf('[pb_lay_raw')>-1){

        }

        if(san_aux_str.indexOf('[pb_lay_raw')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="raw"]').clone());
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').val(san_aux_str_cont);
        }


        if(san_aux_str.indexOf('[pb_lay_one_full')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/1"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(arr_matches, arr_matches[0], _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            //console.log(arr_matches);
            for(k=0;k<1;k++){

                if(typeof arr_matches[k]!='undefined'){
                    if(arr_matches[k].type!=''){
                        //console.info(arr_matches[k].type);
                        _wrapBuild.children('.dzs-layout').last().find('.field-title').eq(k).val(arr_matches[k].type);

                    }
                    _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(k).val(arr_matches[k].content);
                }
            }
        }


        if(san_aux_str.indexOf('[pb_lay_one_half_one_half')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/2+1/2"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(arr_matches, arr_matches[0], _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            //console.log(arr_matches);
            for(k=0;k<2;k++){
                if(arr_matches[k].type!=''){
                    //console.info(arr_matches[k].type);
                    _wrapBuild.children('.dzs-layout').last().find('.field-title').eq(k).val(arr_matches[k].type);

                }
                _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(k).val(arr_matches[k].content);
            }

        }


        if(san_aux_str.indexOf('[pb_lay_two_third_one_third')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="2/3+1/3"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
        }

    //====pb_lay_one_third_two_third
        if(san_aux_str.indexOf('[pb_lay_one_third_two_third')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/3+2/3"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
        }




        if(san_aux_str.indexOf('[pb_lay_one_third_one_third_one_third')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/3+1/3+1/3"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(2).val(arr_matches[2].content);
        }


        if(san_aux_str.indexOf('[pb_lay_one_half_one_fourth_one_fourth')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/2+1/4+1/4"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(2).val(arr_matches[2].content);
        }


        if(san_aux_str.indexOf('[pb_lay_one_fourth_one_half_one_fourth')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/4+1/2+1/4"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(2).val(arr_matches[2].content);
        }


        if(san_aux_str.indexOf('[pb_lay_one_fourth_one_fourth_one_half')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/4+1/4+1/2"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(2).val(arr_matches[2].content);
        }

        if(san_aux_str.indexOf('[pb_lay_one_fourth_one_fourth_one_fourth_one_fourth')>-1){

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel="1/4+1/4+1/4+1/4"]').clone());
            update_layout_names();

            var arr_matches = process_layb_matches(san_aux_str_cont);
            //console.info(_wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content'));
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(0).val(arr_matches[0].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(1).val(arr_matches[1].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(2).val(arr_matches[2].content);
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').eq(3).val(arr_matches[3].content);
        }

        cnt = cnt.replace(aux_str, '');


        //console.log(san_aux_str);
    }




    jQuery('#dzspb-aux-structurer').html(cnt);

    }


    var aux_struct = jQuery('#dzspb-aux-structurer').clone();
    /*

    ==not a good idea / can break stuff

    jQuery('#dzspb-aux-structurer').html('');

    //console.log(aux_struct);


    aux_struct.children().each(function(){
        var _t = jQuery(this);



        if(typeof _t.get(0) != 'undefined'){

            var san_thtml = _t.get(0).outerHTML;

            san_thtml = san_thtml.replace('<br data-mce-bogus="1">', '');
            if(san_thtml=='<p></p>' || san_thtml==''){
                return;
            }

            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel=raw]').clone());
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').val(san_thtml);


        }
    })




    aux_struct.children().remove();
    */


    var aux_struct_html = aux_struct.html();
    var myRe_lines = /.*?[\r|\n]/g;

    /*
    for(i=0;i<10;i++){

        var aux_str = '';
        var sw=false;

        //console.info(aux_struct_html);

        //console.log(myRe_lines.test(aux_struct_html), myRe_lines.test(aux_struct_html), aux_struct_html.search(myRe_lines));
        if(myRe_lines.test(aux_struct_html)){
            var myArray = aux_struct_html.match(myRe_lines);

            aux_str = myArray[0];
        }else{

            aux_str = aux_struct_html;
            sw = true;
            //console.info('sw',sw);
        }

        //console.info(aux_str);

        if(aux_str!='' && aux_str!='<p></p>'){


            _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel=raw]').clone());
            _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').val(aux_str);

        }

        aux_struct_html = aux_struct_html.replace(aux_str, '');

        //console.info('sw',sw);
        if(sw){
            break;
        }
    }
    */

    //console.log(aux_struct_html);
    var aux_str = '';
    aux_str = aux_struct_html;
    if(aux_str!='' && aux_str!='<p></p>'){


        _wrapBuild.append(_pagebuilderWrap.find('.wrap-widgets').eq(0).find('.dzs-layout[rel=raw]').clone());
        _wrapBuild.children('.dzs-layout').last().find('.the-layout-body-content').val(aux_str);

    }

    jQuery('input[name=dzspb_last_editor]').val('pagebuilder');


    update_layout_names();


    jQuery('#wp-content-editor-container').hide();
    jQuery('#post-status-info, #insert-media-button, #content-tmce, #content-html').hide();


    jQuery('#dzspb-pagebuilder-con').show();
    jQuery('#dzspb_switch_editor').val('Switch to Classic Editor');


    pb_firsttransform_topb = false;
}


function process_layb_matches(arg){
    var re_layb_sc = /\[pb_layb_.*?\]|\[\/pb_layb_.*?\]/g;
    var re_attr_title = /type="(.*?)"/;
    var re_layb_matches = /\[pb_layb_.*?\][\s|\S]*?\[\/pb_layb_.*?\]/g;

    var arr_aux = arg.match(re_layb_matches);
    //console.log(arg, arr_aux);

    var arr_fout = [];

    if(arr_aux!=null){
    for(i=0;i<arr_aux.length;i++){
        arr_fout[i] = {'content' : '', 'type':'', second_type:''};


        if(re_attr_title.test(arr_aux[i])){
            //console.log(re_attr_title.exec(arr_aux[i]))
            var re_attr_title_arr = re_attr_title.exec(arr_aux[i]);
            arr_fout[i].type = re_attr_title_arr[1];
        }
        //console.log();
        arr_fout[i].content = arr_aux[i].replace(re_layb_sc, '');
    }
    }

    return arr_fout;
}




function dzspb_mainoptions_ready(){

    jQuery('.save-mainoptions').bind('click', dzspb_mo_saveall);
    jQuery('.saveconfirmer').fadeOut('slow');
}

function dzspb_mo_saveall(){
    jQuery('#save-ajax-loading').css('visibility', 'visible');
    var mainarray = jQuery('.mainsettings').serialize();
    var data = {
        action: 'dzspb_ajax_mo',
        postdata: mainarray
    };
    jQuery('.saveconfirmer').html('Options saved.');
    jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
    jQuery.post(ajaxurl, data, function(response) {
        if(window.console !=undefined ){
            console.log('Got this from the server: ' + response);
        }
        jQuery('#save-ajax-loading').css('visibility', 'hidden');
    });

    return false;
}


/* @projectDescription jQuery Serialize Anything - Serialize anything (and not just forms!)
 * @author Bramus! (Bram Van Damme)
 * @version 1.0
 * @website: http://www.bram.us/
 * @license : BSD
 */

(function($) {

    $.fn.serializeAnything = function() {

        var toReturn    = [];
        var els         = $(this).find(':input').get();

        $.each(els, function() {
            if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password/i.test(this.type))) {
                var val = $(this).val();
                toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
            }
        });

        return toReturn.join("&").replace(/%20/g, "+");

    }

})(jQuery);

jQuery.fn.textWidth = function(){
    var _t = jQuery(this);
    var html_org = _t.html();
    if(_t[0].nodeName=='INPUT'){
        html_org = _t.val();
    }
    var html_calcS = '<span>' + html_org + '</span>';
    jQuery('body').append(html_calcS);
    var _lastspan = jQuery('span').last();
    //console.log(_lastspan, html_calc);
    _lastspan.css({
        'font-size' : _t.css('font-size')
        ,'font-family' : _t.css('font-family')
    })
    var width =_lastspan.width() + 5;
    //_t.html(html_org);
    _lastspan.remove();
    return width;
};