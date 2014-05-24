jQuery(document).ready(function($){
    //===global
        var i = 0;
    $(document).delegate(".input-big-image", "change", change_big_image);
    $(".input-big-image").trigger('change');
    setTimeout(reskin_select, 10);

    //console.info($('.dzsp-add-gallery-item'))


    /*
    ///======builder init CODE
    var _ahtml = $('a#content-html');
    var _atmce = $('a#content-tmce');
    $('#wp-content-editor-tools').prepend('<a onclick="switchEditors.switchto(this);" class="wp-switch-editor switch-builder" id="content-builder">Builder</a>')


    $('a#content-builder').bind('click', click_builder_initer);

     _ahtml.bind('click', click_ahtml);
     _atmce.bind('click', click_atmce);

     ///======builder init CODE END
    */



    ///======item gallery CODE
    var _gallery = jQuery('.dzsp_item_gallery_list').eq(0);

    $('.dzsp-add-gallery-item').bind('click', click_add_gallery_item);
    $(document).delegate('li .ui-delete', 'click', click_item_delete);


    _gallery.sortable({
        items: 'li',
        scrollSensitivity:50,
        forcePlaceholderSize: true,
        forceHelperSize: false,
        helper: 'clone',
        opacity: 0.7,
        placeholder: 'dzsp_item_gallery_list-placeholder',
        update: function(event, ui) {
            update_dzsp_item_gallery_metafield();
        }
    });



    function click_item_delete(){
        var _t = $(this);
        //console.info(_t);
        _t.parent().remove();
        update_dzsp_item_gallery_metafield();
    }
    function update_dzsp_item_gallery_metafield(){
        jQuery('#dzsp_image_gallery').val('');
        var aux = '';
        i=0;
        jQuery('.dzsp_item_gallery_list').children().each(function(){
            var _t = jQuery(this);
            //console.log(_t);
            if(i>0){
                aux+=',';
            }
            aux+=_t.attr('data-id');
            i++;
        });
        jQuery('#dzsp_image_gallery').val(aux);
    }

    function click_add_gallery_item(e){
        //console.log('ceva');


        item_gallery_frame = wp.media.frames.downloadable_file = wp.media({
            title: 'Add Images to Item Gallery',
            button: {
                text: 'Add to gallery'
            },
            multiple: true
        });

        item_gallery_frame.on( 'select', function() {

            var selection = item_gallery_frame.state().get('selection');
            selection = selection.toJSON();

            for(i=0;i<selection.length;i++){

                var _c = selection[i];
                //console.info(_c);
                if(_c.id==undefined){
                    continue;
                }

                _gallery.append('<li class="item-element" data-id="'+_c.id+'"><img class="the-image" src="'+_c.url+'"/><div class="ui-delete"></div></li>')

            }
            update_dzsp_item_gallery_metafield();

            /*
             selection.map( function( attachment ) {

             attachment = attachment.toJSON();
             if ( attachment.id ) {
             attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

             $product_images.append('<li class="image" data-attachment_id="' + attachment.id + '">\
             <img src="' + attachment.url + '" />\
             <ul class="actions">\
             <li><a href="#" class="delete" title="Delete image">Delete</a></li>\
             </ul>\
             </li>');
             }

             } );

             $image_gallery_ids.val( attachment_ids );
             */
        });



        // Finally, open the modal.
        item_gallery_frame.open();
        ///======item gallery CODE END



        return false;
    }

    ///======item gallery CODE END



    function click_ahtml(){
        $('#wp-content-wrap').removeClass('builder-active');

    }

    function click_atmce(){
        $('#wp-content-wrap').removeClass('builder-active');

    }
    function click_builder_initer(){
        //switchEditors.switchto(_ahtml[0]);
        $('#wp-content-wrap').removeClass('tmce-active').removeClass('html-active').addClass('builder-active');
    }

    
    function change_big_image(){
        var _t = jQuery(this);
        var _it = _t.parent();
        //console.log(_t);
        var val = _t.val();
        
        //console.log(_t, val);
        if(val!=undefined && val!=''){
            _it.find('.dzs-img-preview-con').eq(0).fadeIn('slow');
            _it.find('.dzs-img-preview').eq(0).css({
                'background-image' : 'url(' + val + ')'
            });
        }else{
            _it.find('.dzs-img-preview-con').eq(0).fadeOut('slow');
            
        }
    }


    $('.dzs-wordpress-uploader').unbind('click');
    $('.dzs-wordpress-uploader').bind('click', function(e){
        var _t = $(this);
        frame = wp.media.frames.dzsp_addimage = wp.media({
                // Set the title of the modal.
                title: "Insert Media",

                // Tell the modal to show only images.
                library: {
                },

                // Customize the submit button.
                button: {
                    // Set the text of the button.
                    text: "Insert Media",
                    // Tell the button not to close the modal, since we're
                    // going to refresh the page when the image is selected.
                    close: false
                }
            });

            // When an image is selected, run a callback.
            frame.on( 'select', function() {
                // Grab the selected attachment.
                var attachment = frame.state().get('selection').first();

                //console.log(attachment.attributes.url);
                var arg = attachment.attributes.url;
                    _t.prev().val(arg);
                    _t.prev().trigger('change');
                    frame.close();
            });

            // Finally, open the modal.
            frame.open();
            
        e.stopPropagation();
        e.preventDefault();
        return false;
    });


    extra_skin_hiddenselect();
})

function dzsp_mainoptions_ready(){

    jQuery('.save-mainoptions').bind('click', dzsp_mo_saveall);
    jQuery('.saveconfirmer').fadeOut('slow');
}

function dzsp_mo_saveall(){
    jQuery('#save-ajax-loading').css('visibility', 'visible');
    var mainarray = jQuery('.mainsettings').serialize();
    var data = {
        action: 'dzsp_ajax_mo',
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
    jQuery(document).undelegate(".select-wrapper select", "change");
    jQuery(document).delegate(".select-wrapper select", "change",  change_select);


    function change_select(){
        var selval = (jQuery(this).find(':selected').text());
        jQuery(this).parent().children('span').text(selval);
    }

};



function extra_skin_hiddenselect(){
    for(i=0;i<jQuery('.select-hidden-metastyle').length;i++){
        var _t = jQuery('.select-hidden-metastyle').eq(i);
        if(_t.hasClass('inited')){
            continue;
        }
        //console.log(_t);
        _t.addClass('inited');
        _t.children('select').eq(0).bind('change', change_selecthidden);
        change_selecthidden(null, _t.children('select').eq(0));
        _t.find('.an-option').bind('click', click_anoption);
    }
    function change_selecthidden(e, arg){
        var _c = jQuery(this);
        if(arg!=undefined){
            _c = arg;
        }
        var _con = _c.parent();
        var selind = _c.children().index(_c.children(':selected'));
        var _slidercon = _con.parent().parent();
        //console.log(selind);
        _con.find('.an-option').removeClass('active');
        _con.find('.an-option').eq(selind).addClass('active');
        //console.log(_con);
        do_changemainsliderclass(_slidercon, selind);
    }
    function click_anoption(e){
        var _c = jQuery(this);
        var ind = _c.parent().children().index(_c);
        var _con = _c.parent().parent();
        var _slidercon = _con.parent().parent();
        _c.parent().children().removeClass('active');
        _c.addClass('active');
        _con.children('select').eq(0).children().removeAttr('selected');
        _con.children('select').eq(0).children().eq(ind).attr('selected', 'selected');
        do_changemainsliderclass(_slidercon, ind);
        //console.log(_c, ind, _con, _slidercon);
    }
    function do_changemainsliderclass(arg, argval){
        //extra function - handmade
        //console.log(arg, argval, arg.find('.mainsetting').eq(0).children().eq(argval).val());

        if(arg.hasClass('dzsp-meta-bigcon')){
            arg.removeClass('mode_thumb'); arg.removeClass('mode_gallery');  arg.removeClass('mode_audio'); arg.removeClass('mode_video'); arg.removeClass('mode_youtube'); arg.removeClass('mode_vimeo'); arg.removeClass('mode_link'); arg.removeClass('mode_testimonial'); arg.removeClass('mode_link'); arg.removeClass('mode_twitter');

            arg.addClass('mode_' + arg.find('.mainsetting').eq(0).children().eq(argval).val());

        }
        if(arg.hasClass('item-settings-con')){
            arg.removeClass('type_youtube'); arg.removeClass('type_normal'); arg.removeClass('type_vimeo'); arg.removeClass('type_audio'); arg.removeClass('type_image'); arg.removeClass('type_link');

            if(argval==0){
                arg.addClass('mode_youtube')
            }
            if(argval==1){
                arg.addClass('mode_normal')
            }
            if(argval==2){
                arg.addClass('mode_vimeo')
            }
            if(argval==3){
                arg.addClass('mode_audio')
            }
            if(argval==4){
                arg.addClass('mode_image')
            }
            if(argval==5){
                arg.addClass('mode_link')
            }
        }
    }

}