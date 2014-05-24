window.htmleditor_sel = '';
window.mceeditor_sel = '';
top.dzsp_startinit = '';

jQuery(document).ready(function($){
    if(typeof window.dzsp_settings == 'undefined'){
        return;
    }
    $('#wp-content-media-buttons').append('<a class="shortcode_opener" id="dzsp_shortcode" style="cursor:pointer; display: inline-block; vertical-align: middle; background-size:cover; background-repeat: no-repeat; background-position: center center; width:28px; height:28px; background-image: url('+dzsp_settings.thepath+'tinymce/img/shortcodes-small-retina.png);"></a> ');
    $('#dzsp_shortcode').bind('click', function(){



        var parsel = '';
        var sel = '';
        top.dzsp_startinit = '';
        if(window.tinyMCE == undefined || window.tinyMCE.activeEditor==null || jQuery('#content_parent').css('display')=='none'){
            var textarea = document.getElementById("content");
            var start = textarea.selectionStart;
            var end = textarea.selectionEnd;
            sel = textarea.value.substring(start, end);

            //console.log(sel);

            //textarea.value = 'ceva';
            if(sel!=''){
                //parsel+='&sel=' + encodeURIComponent(sel);
                window.htmleditor_sel = sel;
            }else{
                window.htmleditor_sel = '';
            }
        }else{
            //console.log(window.tinyMCE.activeEditor);
            var ed = window.tinyMCE.activeEditor;
            sel=ed.selection.getContent();

            if(sel!=''){
                //parsel+='&sel=' + encodeURIComponent(sel);
                window.mceeditor_sel = sel;
            }else{
                window.mceeditor_sel = '';
            }
            //console.log(aux);
        }

        top.dzsp_startinit = sel;



        $.fn.zoomBox.open(dzsp_settings.thepath + 'tinymce/popupiframe.php?iframe=true', 'iframe', {bigwidth: 1200, bigheight: 700, dims_scaling: 'fill'});
  
    })
});