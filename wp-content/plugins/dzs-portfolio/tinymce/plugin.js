(function(){
    tinymce.create('tinymce.plugins.TestimonialRotator', {
 
        init : function(ed, url){
            ed.addButton('TestimonialRotator', {
                title: 'Add Shortcode',
                image: window.theme_url + 'tinymce/img/shortcodes.png',
				onclick: function(){
					window.tinymce_cursor = tinyMCE.activeEditor.selection.getBookmark();
                	tb_show('Ammon Shortcodes', ammonsetings.themeurl + 'tinymce/popup.php?width=630&height=800');
            	}
            }
            )
        }
    });
    //tinymce.PluginManager.add('dzstr', tinymce.plugins.TestimonialRotator);
})();
/*
jQuery(document).ready(function($){
	$('#wp-content-media-buttons').append('<a class="thickbox shortcode_opener" style="cursor:pointer;"><img src="'+ammonsetings.themeurl+'tinymce/img/shortcodes-small.png"/></a>');
	$('.shortcode_opener').bind('click', function(){
    	tb_show('Ammon Shortcodes', ammonsetings.themeurl + 'tinymce/popup.php?width=630&height=800');
	})
})
*/
