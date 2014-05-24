//top.dzspb_textsel = '[advancedscroller][shortcode_li class="item-tobe"]test1[/shortcode_li][shortcode_li class="item-tobe"]test2[/shortcode_li][/advancedscroller]';




jQuery(document).ready(function($){



    var tinymce_settings = {
        script_url : dzspb_settings.thepath + 'tinymce/jscripts/tiny_mce/tiny_mce.js'
        ,mode : "textareas"
        ,theme : "modern"
        ,plugins : "image"
        ,relative_urls : false
        ,remove_script_host : false
        ,convert_urls : true
        ,forced_root_block : ""
        ,theme_advanced_toolbar_location : "top"
        //,theme_advanced_toolbar_align : "left"
        //,theme_advanced_statusbar_location : "bottom"
        ,toolbar: "undo redo | styleselect | bold italic | link image | removeformat code | addimagebutton"
        ,setup : function(ed) {
            // Add a custom button
            //console.info(dzspb_settings.thepath + 'tinymce/img/addimagebutton.png');
            ed.addButton('addimagebutton', {
                title : 'Add Image via WordPress Uploader',
                image : dzspb_settings.thepath + 'tinymce/img/addimagebutton.png',
                onclick : function() {

                    // Add you own code to execute something on click
                    ed.focus();
                    if ( typeof file_frame !='undefined' ) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: jQuery( this ).data( 'uploader_title' ),
                        button: {
                            text: jQuery( this ).data( 'uploader_button_text' ),
                        },
                        multiple: false  // Set to true to allow multiple files to be selected
                    });

                    // When an image is selected, run a callback.
                    file_frame.on( 'select', function() {
                        // We set multiple to false so only get one image from the uploader
                        var att = file_frame.state().get('selection').first().toJSON();

//                        console.info(this, );

                        var currEd = tinyMCE.activeEditor

//                        console.log(ed, att);
                        currEd.selection.setContent('<img src="'+att.url+'" class="fullwidth needs-loading"/>');

                        // Do something with attachment.id and/or attachment.url here
                    });

                    // Finally, open the modal
                    file_frame.open();
                }
            });
        }
    };


    var coll_buffer=0;
    var fout='';

    reskin_select();

    jQuery(".admin_items_con").sortable({ placeholder: 'ui-state-highlight', axis:'y',
            start: function(e, ui){
                $(this).find('textarea').each(function(){
                    //console.log()
                    var auxId = $(this).attr('id');
                    if(typeof(auxId)!='string'){
                        //console.log('ceva', $(this).get(0).id);
                        auxId = $(this).get(0).id;
                    }

                    //console.log(auxId);

                    //console.log($(this));
                    $(this).tinymce().remove();
                    //tinyMCE.execCommand( 'mceRemoveControl', false, auxId);
                });
            },
            stop: function(e,ui) {
                $(this).find('textarea').each(function(){
                    var auxId = $(this).attr('id');
                    if(typeof(auxId)!='string'){
                        //console.log('ceva', $(this).get(0).id);
                        auxId = $(this).get(0).id;
                    }
                    //tinyMCE.execCommand( 'mceAddControl', true, auxId );
                    $(this).tinymce(tinymce_settings);
                    jQuery(".admin_items_con").sortable("refresh");
                });
            }}
    );

    $('#add_admin_item').bind('click', click_add_admin_item);
    $('#but_preview').bind('click', prepare_preview);
    $('#insert_admin_item').bind('click', click_insert_admin_item);
    $('select[name=settings_skin]').bind('change', change_settingsSkin);

    $(document).on('click','.button-delete',click_button_delete);
    $(document).on('click','.button-edit',click_button_edit);


    /*
     if(jQuery('.justfortest').length>0){
     var _c = jQuery('.justfortest');
     //console.log(_c);
     _c.find('.dzs-tab-tobe').each(function(){
     var _cc = jQuery(this);
     //console.log(_cc);
     click_add_admin_item();
     var _ccon = jQuery('.admin_items_con').find('.item-con').last();
     setTimeout(function(){
     var aux = '';
     aux = _cc.find('.tab-menu').find('*:not(span)').eq(0).html();
     _ccon.find('.testtitle').eq(0).tinymce().setContent(aux);
     aux = _cc.find('.tab-menu').find('span').eq(0).html();
     _ccon.find('.testtooltip').eq(0).tinymce().setContent(aux);
     aux = _cc.find('.tab-content').eq(0).html();
     _ccon.find('.testcont').eq(0).tinymce().setContent(aux);
     //console.log(jQuery.fn.tinymce, _ccon.find('.testtitle').eq(0).tinymce());
     }, 800);
     if(_ccon.find('.testtitle').eq(0).tinymce()==undefined){

     }
     });
     }else{
     if(jQuery('.init-setup-transformed').html()!=''){
     jQuery('.init-setup-transformed').append('<br>(broken)');
     }
     }
     */

    if(top.dzspb_textsel!=undefined && top.dzspb_textsel!=''){
        $('.misc-init-setup').append("<h4>Initial Setup</h4>");
        $('.misc-init-setup').append('<textarea rows="5" disabled class="the-init-setup">'+top.dzspb_textsel+'</textarea>');
        init_setup(top.dzspb_textsel);
    }

    setInterval(prepare_preview, 60000);
    function click_button_delete(){
        var _t = jQuery(this);
        _t.parent().parent().remove();
    }
    function click_button_edit(){
        var _t = jQuery(this);
        if(_t.hasClass('active')){
            _t.parent().parent().children('.item-settings').hide();
            _t.removeClass('active');
        }else{
            _t.parent().parent().children('.item-settings').show();
            _t.addClass('active');

        }
    }

    function init_setup(arg){
        var jarg='';

        var regex_main = /\[advancedscroller]([\s\S]*?)\[\/advancedscroller]/g;
        var reg_arr = (RegExp(regex_main).exec(arg));

        var regex_item = /\[shortcode_dzs_li.*?]([\s\S]*?)\[\/shortcode_dzs_li\]/g;

        //var regex_item = /\](.*?)\[/g;

        //console.log(arg, reg_arr);
        var str_main = reg_arr[1];
        //console.log(str_main);

        var arr_items = [];
        //arr_items = regex_item.exec(str_main);
        //arr_items = str_main.match(regex_item);

        var a = '';

        while(a = regex_item.exec(str_main)) {
            //console.info(a);
            arr_items.push(a[1]);
            // match is now the next match, in array form.
        }
        ///console.info(arr_items);


        var i =0;
        for(i=0;i<arr_items.length;i++){
            var _t = arr_items[i];
//            console.info(_t);

            click_add_admin_item();
            change_item(i, _t);
        }
    }
    function change_item(arg, argval){
        //console.log($('.admin-item-con').eq(arg).find('.itemcontent').eq(0))
        //tinyMCE.execCommand( 'mceRemoveControl', false, $('.admin-item-con').eq(arg).find('.itemcontent').eq(0).attr('id'));
        $('.admin-item-con').eq(arg).find('.itemcontent').eq(0).val(argval);
    }

    function click_add_admin_item(){
        jQuery('.admin_items_con').append(structure_test);
        //console.log($.tinymce);
        rename_textareas();
        jQuery('.admin_items_con').children().last().find('textarea').tinymce(tinymce_settings);
        //prepare_preview();
        return false;
    }
    function rename_textareas(){
        //deprecated
        var aux = '';
        for(i=0;i<jQuery('.admin_items_con').children().length; i++){
            var _c = jQuery('.admin_items_con').children().eq(i);
            aux = 'ta0' + i;
            _c.find('textarea').eq(0).attr('id', aux);
            aux = 'ta1' + i;
            _c.find('textarea').eq(1).attr('id', aux);
            aux = 'ta2' + i;
            _c.find('textarea').eq(2).attr('id', aux);
        }

    }
    function change_settingsSkin(){
        var _t = jQuery(this);
        var _val = _t.val();
        //console.log(_t.val(), _t.parent().parent().parent());
        if(_val == 'skin-custombg'){
            _t.parent().parent().parent().addClass('type-custombg');
        }else{
            _t.parent().parent().parent().removeClass('type-custombg');

        }
    }
    function prepare_fout(){
        //console.log($('img'));
        fout='';
        fout+='[advancedscroller';
        var _c,
            _c2
            ;
        _c = $('input[name=settings_width]');
        if(_c.val()!=''){
            fout+=' settings_contentwidth=' + _c.val() + '';
        }
        _c = $('input[name=settings_height]');
        if(_c.val()!=''){
            fout+=' settings_contentheight=' + _c.val() + '';
        }

        fout+=']';


        var i=0;
        var aux='';
        for(i=0;i<$('.admin_items_con .admin-item-con').length;i++){
            _c2 = $('.admin_items_con .admin-item-con').eq(i);
            fout+='[shortcode_dzs_li class=item-tobe]';
            _c = $(_c2.find('textarea').eq(0));

            //console.log(_c.tinymce().getContent({format : 'text'}));
            if(_c.tinymce().getContent()!=''){
                aux = _c.tinymce().getContent({format : 'raw'});
                //console.log(_c, aux);
                fout+=(aux);
            }
            //fout+=tinyMCE.editors[0].getContent();
            //fout+=_c.tinymce().selection.getContent();
            fout+='[/shortcode_dzs_li]';
        }

        fout+='[/advancedscroller]';
    }
    function click_insert_admin_item(){
        prepare_fout();
        //console.log(fout);
        tinymce_add_content(fout);
        return false;
    }
    function prepare_preview(){
        //alert('ceva');
        prepare_fout();
        if(window.console){ console.log(fout); }
        var data = {
            action: 'dzspb_preparePreview',
            postdata: fout
        };
        jQuery.post(ajaxurl, data, function(response) {
            if(response.charAt(response.length-1) == '0'){
                response = response.slice(0,response.length-1);
            }
            if(window.console !=undefined ){
                console.info('Got this from the server: ' + response);
            }
            $('.preview-inner').html(response);
            //jQuery('#save-ajax-loading').css('visibility', 'hidden');
        });
    }
})
function tinymce_add_content(arg){

    if(window.console){ console.info(arg); }

    if(typeof(top.dzspb_receiver)=='function'){
        top.dzspb_receiver(arg);
    }else{
        jQuery('.output-div').text(arg).html();
        jQuery('.output-div').prepend('<h3>Output</h3>')
    }
}
function reskin_select(){
    for(i=0;i<jQuery('select').length;i++){
        var $cache = jQuery('select').eq(i);
        //console.log($cache.parent().attr('class'));

        if($cache.hasClass('styleme')==false || $cache.parent().hasClass('select_wrapper') || $cache.parent().hasClass('select-wrapper')){
            continue;
        }
        var sel = ($cache.find(':selected'));
        $cache.wrap('<div class="select-wrapper"></div>')
        $cache.parent().prepend('<span>' + sel.text() + '</span>')
    }
    jQuery('.select-wrapper select').unbind();
    jQuery(document).on('change','.select-wrapper select',change_select);

    function change_select(){
        var selval = (jQuery(this).find(':selected').text());
        jQuery(this).parent().children('span').text(selval);
    }
}
function safe_tags(str) {
    return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;') ;
}