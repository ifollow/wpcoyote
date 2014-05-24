
//top.dzsp_startinit = '[zoomfolio settings_mode="simple" skin="skin-clean" settings_specialgrid="special-grid-3" settings_lightboxlibrary="zoombox" design_item_width="280" fullscreen="off" sort_order="ASC" settings_disablecats="off" disable_itemmeta="off" settings_preloadall="off" design_categories_style="normal" design_pageContent_pos="top" settings_specialgrid_chooser_enabled="off" design_categories_pos="bottom" settings_biggalleryall="off" orderby="date" settings_ajax="on" settings_ajax_loadmoremethod="button" bgcolor="transparent" settings_mode_masonry_layout="masonry" design_total_height_full="off" settings_mode_masonry_layout_straightacross_setitemsoncenter="off"]';

if(typeof(dzsp_settings)!='undefined' && dzsp_settings.startSetup!=''){
    top.dzsp_startinit = dzsp_settings.startSetup;
}

function htmlEncode(arg){
    return $('<div/>').text(arg).html();
}

function htmlDecode(value){
    return $('<div/>').html(arg).text();
}

function get_shortcode_attr(arg, argtext){

    var regex_aattr = new RegExp(arg+'="(.*?)"');

    //console.log(regex_aattr, argtext);

    var aux = regex_aattr.exec(argtext);

    if(aux){
        var foutobj = {'full' : aux[0], 'val' : aux[1]};
        return foutobj;
    }



    return false;
}

jQuery(document).ready(function($){



    var coll_buffer=0;
    var fout='';





    // ---- some custom code for initing the generator ( previous values )
    if(typeof top.dzsp_startinit!='undefined' && top.dzsp_startinit!=''){


        var regex_initmarkup_isshortcode = /\[dzs_pricingtable.*?\][\s\S]*?\[\/dzs_pricingtable]/g;
        var regex_initmarkup_ishtml = /<div.*?dzspt-table/g;


        var arr_settings = ['settings_mode', 'skin', 'settings_posttype', 'settings_specialgrid', 'design_item_width', 'design_item_height', 'design_thumbw', 'design_thumbh','settings_orderby','sort_order', 'settings_preloadall', 'bgcolor', 'settings_disablecats', 'design_categories_style', 'disable_itemmeta', 'settings_specialgrid_chooser_enabled', 'settings_biggalleryall', 'design_categories_pos', 'design_pageContent_pos', 'posts_per_page', 'settings_ajax', 'settings_ajax_loadmoremethod', 'fullscreen', 'settings_lightboxlibrary', 'settings_extraclasses', 'settings_wpqargs', 'wall_settings_thumbs_per_row', 'wall_thumb_space', 'settings_mode_masonry_layout', 'design_total_height_full', 'settings_mode_masonry_layout_straightacross_setitemsoncenter'];

        $('.dzsp-admin').append('<div class="misc-initSetup"><h5>Start Setup</h5></h5><p>'+htmlEncode(top.dzsp_startinit)+'</p></div>');


        var res;
        var lab='';
        for(key in arr_settings){

            lab = arr_settings[key];
            res = get_shortcode_attr(lab, top.dzsp_startinit);
//            console.info(res, lab, top.dzsp_startinit);
            if(res){
                $('*[name="'+lab+'"]').val(res['val']);
                $('*[name="'+lab+'"]').trigger('change');
            }
        }







    }




    $('#example-fig1').bind('click', function(){

        var aux = '[zoomfolio settings_mode="masonry" skin="skin-default" settings_specialgrid="none" settings_lightboxlibrary="zoombox" design_item_width="280" design_item_height="280" design_thumbw="" design_thumbh="200" fullscreen="off" sort_order="ASC" settings_disablecats="off" disable_itemmeta="off" settings_preloadall="off" design_categories_style="normal" design_pageContent_pos="top" settings_specialgrid_chooser_enabled="off" design_categories_pos="top" settings_biggalleryall="off" orderby="date" settings_ajax="off" settings_ajax_loadmoremethod="button"';

        var auxcats = '';

        var auxa = String(mainsettings.sampledata_cats).split(',');

        if(auxa[0]){
            auxcats+=auxa[0];
        }
        if(auxa[1]){
            auxcats+=',';
            auxcats+=auxa[1];
        }

        aux+=' cats="'+auxcats+'"';

        aux+=' bgcolor="transparent" settings_mode_masonry_layout="masonry" design_total_height_full="off" settings_mode_masonry_layout_straightacross_setitemsoncenter="off" design_preloader_bottom="off"]';

        tinymce_add_content(aux);
    });

    $('#example-fig2').bind('click', function(){

        var aux = '[zoomfolio settings_mode="masonry" skin="skin-blog" settings_specialgrid="special-grid-2" settings_posttype="post" settings_lightboxlibrary="zoombox" design_item_width="280" design_thumbw="" fullscreen="off" sort_order="ASC" settings_disablecats="off" disable_itemmeta="off" settings_preloadall="off" design_categories_style="normal" design_pageContent_pos="top" settings_specialgrid_chooser_enabled="off" design_categories_pos="top" settings_biggalleryall="off" orderby="date" settings_ajax="off" settings_ajax_loadmoremethod="button" cats="" bgcolor="transparent" settings_mode_masonry_layout="masonry" design_total_height_full="off" settings_mode_masonry_layout_straightacross_setitemsoncenter="off" design_preloader_bottom="off"]';

        tinymce_add_content(aux);
    });


    $('#example-fig3').bind('click', function(){

        var aux = '[zoomfolio settings_mode="masonry" skin="skin-aura" settings_specialgrid="special-grid-3" settings_posttype="default" settings_lightboxlibrary="zoombox" design_item_width="280" design_thumbw="" design_thumbh="1/1" fullscreen="off" sort_order="ASC" settings_disablecats="off" disable_itemmeta="off" settings_preloadall="off" design_categories_style="normal" design_pageContent_pos="top" settings_specialgrid_chooser_enabled="off" design_categories_pos="top" settings_biggalleryall="off" orderby="title" settings_ajax="off" settings_ajax_loadmoremethod="button"';

        var auxcats = '';

        var auxa = String(mainsettings.sampledata_cats).split(',');

        if(auxa[2]){
            auxcats+=auxa[2];
        }
        aux+=' cats="'+auxcats+'"';

        aux+=' bgcolor="transparent" settings_mode_masonry_layout="masonry" design_total_height_full="off" settings_mode_masonry_layout_straightacross_setitemsoncenter="off" design_preloader_bottom="off"]';

        tinymce_add_content(aux);
    });


    $('#example-fig_exampletestimonials').bind('click', function(){

        var aux = '<style>#port0 .portitem .the-title{ display:none; }</style>[zoomfolio settings_mode="advancedscroller" skin="skin-zero" settings_specialgrid="special-grid-1" settings_posttype="default" settings_lightboxlibrary="zoombox" design_item_width="200" design_thumbw="200" fullscreen="off" sort_order="ASC" settings_disablecats="off" disable_itemmeta="off" settings_preloadall="off" design_categories_style="normal" design_pageContent_pos="top" settings_specialgrid_chooser_enabled="off" design_categories_pos="top" settings_biggalleryall="off" orderby="date" settings_ajax="off" settings_ajax_loadmoremethod="button"';

        var auxcats = '';

        var auxa = String(mainsettings.sampledata_cats).split(',');

        if(auxa[3]){
            auxcats+=auxa[3];
        }
        aux+=' cats="'+auxcats+'"';

        aux+=' bgcolor="transparent" settings_mode_masonry_layout="masonry" design_total_height_full="off" settings_mode_masonry_layout_straightacross_setitemsoncenter="off" design_preloader_bottom="off"]';

        tinymce_add_content(aux);
    });












    // ==== switcher

    $('.changer-posttype').bind('change', change_posttype);

    function change_posttype(e){
        var _t = $(this);
        var _con = _t.parent().parent().parent().parent();

        if(_con.hasClass('settings')){

            var data = {
                action: 'dzsp_get_categories',
                postdata: '1'
            };


            if(_t.val()=='post'){

                jQuery.post(ajaxurl, data, function(response) {
                    //console.log(response);
                    if(window.console !=undefined ){
                        console.log(response);
                    }
                    if(response.substr(0,6)=='error:'){
                        //console.log('ceva');
//                jQuery('.import-error').html(response.substr(7));
//                jQuery('.import-error').fadeIn('fast').delay(5000).fadeOut('slow');
                        return false;
                    }
//                    console.info(response);

                    var split_ni = response.split(';');

                    var split_i = split_ni[0].split(',');
                    var split_n = split_ni[1].split(',');

                    var aux = '';
                    var aux2 = '';
                    for(key in split_i){
                        aux+='<input type="checkbox" value="'+split_i[key]+'" name="categoryportfolio"> '+split_n[key]+'<br/>';
                        aux2+='<input type="radio" value="'+split_i[key]+'" name="defaultcategory"> '+split_n[key]+'<br/>';
                    };

                    $('.categoryportfolio-con').html(aux);
                    $('.defaultcategory-con').html(aux2);





                });
            }
            if(_t.val()=='default'){

            }



        }else{
            console.info(_con, ' does not have class settings')
        }

        return false;
    }
    // ==== switcher

    $('.switcher-simple-example > a').bind('click', click_switcher);

    function click_switcher(e){
        var _t = $(this);
        var _par = _t.parent();

        _par.children().removeClass('active');

        if(_par.children().index(_t)==0){
            $('.con-generate-custom').show();
            $('.con-generate-example').hide();
        }


        if(_par.children().index(_t)==1){
            $('.con-generate-custom').hide();
            $('.con-generate-example').show();
        }

        _t.addClass('active');

        return false;
    }



    $(document).delegate('.btn-install-demo-data','click', click_install_demo_data);
    $(document).delegate('.btn-delete-demo-data','click', click_delete_demo_data);

    if(mainsettings.sampledata_installed==true){
        var _t = $('.btn-install-demo-data').eq(0);

        _t.removeClass('btn-install-demo-data');
        _t.addClass('btn-delete-demo-data');


        _t.css({
            'opacity':1
        })

        _t.html('Remove Sample Data');

        mainsettings.sampledata_installed=true;
    }



    function click_install_demo_data(e){

        var _t = $(this);

        var data = {
            action: 'dzsp_install_demo_data',
            postdata: '1'
        };

        _t.css({
            'opacity':0.5
        })

        jQuery.post(ajaxurl, data, function(response) {
            //console.log(response);
            if(window.console !=undefined ){
                console.log(response);
            }
            if(response.substr(0,6)=='error:'){
                //console.log('ceva');
//                jQuery('.import-error').html(response.substr(7));
//                jQuery('.import-error').fadeIn('fast').delay(5000).fadeOut('slow');
                return false;
            }

            _t.removeClass('btn-install-demo-data');
            _t.addClass('btn-delete-demo-data');


            _t.css({
                'opacity':1
            })

            _t.html('Remove Sample Data');


            mainsettings.sampledata_installed=true;
            mainsettings.sampledata_cats = response;

        });


        return false;
    }

    function click_delete_demo_data(e){

        var _t = $(this);

        var data = {
            action: 'dzsp_delete_demo_data',
            postdata: '1'
        };

        _t.css({
            'opacity':0.5
        })

        jQuery.post(ajaxurl, data, function(response) {
            //console.log(response);
            if(window.console !=undefined ){
                console.log(response);
            }
            if(response.substr(0,6)=='error:'){
                //console.log('ceva');
//                jQuery('.import-error').html(response.substr(7));
//                jQuery('.import-error').fadeIn('fast').delay(5000).fadeOut('slow');
                return false;
            }


            _t.removeClass('btn-delete-demo-data');
            _t.addClass('btn-install-demo-data');



            _t.css({
                'opacity':1
            })

            _t.html('Install Sample Data');


            mainsettings.sampledata_installed=false;
            mainsettings.sampledata_cats = '';

        });


        return false;
    }



    reskin_select();
    //$(".tests_con").sortable({ placeholder: 'ui-state-highlight' });
    
      //jQuery('#add_test').bind('click', click_add_test);
      //jQuery('#but_preview').bind('click', prepare_preview);
      jQuery('.insert_tests').bind('click', click_insert_tests);
      jQuery(document).delegate('.button-edit','click', click_button_edit);

        jQuery(document).delegate('.setting-input', 'change', prepare_preview);
        jQuery(document).undelegate('.btn-refresh-preview', 'click');
        jQuery(document).delegate('.btn-refresh-preview', 'click', prepare_preview);
      setTimeout(prepare_preview, 1000);


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
      

      function prepare_fout(){
        fout='';
        fout+='[zoomfolio';
        var _c,
        _c2
        ;
        /*
        _c = $('input[name=settings_width]');
        if(_c.val()!=''){
        fout+=' width=' + _c.val() + '';
        }
        _c = $('input[name=settings_height]');
        if(_c.val()!=''){
        fout+=' height=' + _c.val() + '';
        }
        */
          _c = $('select[name=settings_mode]');
          if(_c.val()!=''){
              fout+=' settings_mode="' + _c.val() + '"';
          }
        _c = $('select[name=skin]');
        if(_c.val()!=''){
            fout+=' skin="' + _c.val() + '"';
        }
          _c = $('select[name=settings_specialgrid]');
          if(_c.val()!=''){
              fout+=' settings_specialgrid="' + _c.val() + '"';
          }
          _c = $('select[name=settings_posttype]');
          if(_c.val()!=''){
              fout+=' settings_posttype="' + _c.val() + '"';
          }
          _c = $('select[name=settings_lightboxlibrary]');
          if(_c.val()!=''){
              fout+=' settings_lightboxlibrary="' + _c.val() + '"';
          }
        _c = $('input[name=design_item_width]');
        fout+=' design_item_width="' + _c.val() + '"';
        
        _c = $('input[name=design_item_height]');
        if(_c.val()!=''){
          fout+=' design_item_height="' + _c.val() + '"';
        }
        _c = $('input[name=design_thumbw]');
        fout+=' design_thumbw="' + _c.val() + '"';

        _c = $('input[name=design_thumbh]');
        if(_c.val()!=''){
          fout+=' design_thumbh="' + _c.val() + '"';
        }
          _c = $('input[name=settings_extraclasses]');
          if(_c.val()!=''){
              fout+=' settings_extraclasses="' + _c.val() + '"';
          }

        _c = $('select[name=design_item_height_same_as_width]');
        if(_c.val()!=''){
            //fout+=' design_item_height_same_as_width="' + _c.val() + '"';
        }
        _c = $('select[name=fullscreen]');
        if(_c.val()!=''){
            fout+=' fullscreen="' + _c.val() + '"';
        }
        _c = $('select[name=sort_order]');
        if(_c.val()!=''){
            fout+=' sort_order="' + _c.val() + '"';
        }
        _c = $('select[name=settings_disablecats]');
        if(_c.val()!=''){
            fout+=' settings_disablecats="' + _c.val() + '"';
        }
          _c = $('select[name=disable_itemmeta]');
          if(_c.val()!=''){
              fout+=' disable_itemmeta="' + _c.val() + '"';
          }
          _c = $('select[name=settings_preloadall]');
          if(_c.val()!=''){
              fout+=' settings_preloadall="' + _c.val() + '"';
          }
          _c = $('select[name=design_categories_style]');
          if(_c.val()!=''){
              fout+=' design_categories_style="' + _c.val() + '"';
          }
          _c = $('select[name=design_pageContent_pos]');
          if(_c.val()!=''){
              fout+=' design_pageContent_pos="' + _c.val() + '"';
          }
          _c = $('select[name=settings_specialgrid_chooser_enabled]');
          if(_c.val()!=''){
              fout+=' settings_specialgrid_chooser_enabled="' + _c.val() + '"';
          }
        _c = $('select[name=design_categories_pos]');
        if(_c.val()!=''){
            fout+=' design_categories_pos="' + _c.val() + '"';
        }
          _c = $('select[name=settings_biggalleryall]');
          if(_c.val()!=''){
              fout+=' settings_biggalleryall="' + _c.val() + '"';
          }
          _c = $('select[name=settings_orderby]');
          if(_c.val()!=''){
              fout+=' orderby="' + _c.val() + '"';
          }

        _c = $('select[name=settings_ajax]');
        if(_c.val()!=''){
            fout+=' settings_ajax="' + _c.val() + '"';
        }
          _c = $('select[name=settings_ajax_loadmoremethod]');
          if(_c.val()!=''){
              fout+=' settings_ajax_loadmoremethod="' + _c.val() + '"';
          }
        _c = $('input[name=posts_per_page]');
        if(_c.val()!=''){
          fout+=' posts_per_page="' + _c.val() + '"';
        }
        _c = $('input[name=wall_settings_thumbs_per_row]');
        if(_c.val()!=''){
          fout+=' wall_settings_thumbs_per_row="' + _c.val() + '"';
        }
        _c = $('input[name=wall_thumb_space]');
        if(_c.val()!=''){
          fout+=' wall_thumb_space="' + _c.val() + '"';
        }
          lab = 'settings_hide_category_all';
        _c = $('select[name='+lab+']');
        if(_c.val()!=''){
          fout+=' '+lab+'="' + _c.val() + '"';
        }
          lab = 'settings_uselinksforcategories';
        _c = $('select[name='+lab+']');
        if(_c.val()!=''){
          fout+=' '+lab+'="' + _c.val() + '"';
        }
          lab = 'settings_uselinksforcategories_enablehistoryapi';
        _c = $('select[name='+lab+']');
        if(_c.val()!=''){
          fout+=' '+lab+'="' + _c.val() + '"';
        }


          _c = $('input[name=categoryportfolio]');
          var cats = '';
          for(i=0; i<_c.length;i++){
              _c2 = (_c.eq(i));
              //console.log(_c2, _c2.prop('checked'));
              if(_c2.prop('checked')){
                  if(cats=='')
                      cats+=_c2.val();
                  else
                      cats+=',' + _c2.val();
              }
          }
          if(cats!=''){
              fout+=' cats="' + cats + '"';
          }


          _c = $('input[name=defaultcategory]:checked');
          if(_c.val()!='' && _c.val()!=undefined){
              fout+=' defaultcategory="' + _c.val() + '"';
          }
          
          
          _c = $('input[name=bgcolor]');
          if(_c.val()!='' && _c.val()!=undefined){
              fout+=' bgcolor="' + _c.val() + '"';
          }

        _c = $('input[name=settings_wpqargs]');
        if(_c.val()!=''){
        fout+=' settings_wpqargs="' + _c.val() + '"';
        }


          _c = $('select[name=settings_mode_masonry_layout]');
          if(_c.val()!=''){
              fout+=' settings_mode_masonry_layout="' + _c.val() + '"';
          }
          _c = $('select[name=design_total_height_full]');
          if(_c.val()!=''){
              fout+=' design_total_height_full="' + _c.val() + '"';
          }
          _c = $('select[name=settings_mode_masonry_layout_straightacross_setitemsoncenter]');
          if(_c.val()!=''){
              fout+=' settings_mode_masonry_layout_straightacross_setitemsoncenter="' + _c.val() + '"';
          }


          _c = $('select[name=design_preloader_bottom]');
          if(_c.val()!=''){
              fout+=' design_preloader_bottom="' + _c.val() + '"';
          }




        fout+=']';
      }
      function click_insert_tests(){
      //console.log(jQuery('#mainsettings').serialize()); 
        prepare_fout();
        //console.log(fout);
          tinymce_add_content(fout);
          return false;
      }
      function prepare_preview(){
        prepare_fout();
	var data = {
		action: 'dzsp_preparePreview',
		postdata: fout
	};


          jQuery.post(ajaxurl, data, function(response) {
              if(response.charAt(response.length-1) == '0'){
                  response = response.slice(0,response.length-1);
              }
              if(window.console !=undefined ){
                  console.log('Got this from the server: ' + response);
              }
              $('.preview-inner').html(response);
              //jQuery('#save-ajax-loading').css('visibility', 'hidden');
          });

      }
})
function tinymce_add_content(arg){
	
    if(typeof(top.dzsp_receiver)=='function'){
        top.dzsp_receiver(arg);
    }else{
        jQuery('.testoutput').eq(0).html(arg);
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
//	jQuery(document).undelegate('.select-wrapper select', 'change',change_select);
    jQuery('.select-wrapper select').unbind('change',change_select);
    jQuery('.select-wrapper select').bind('change',change_select);
        
    function change_select(){
            var selval = (jQuery(this).find(':selected').text());
            jQuery(this).parent().children('span').text(selval);
    }
}
