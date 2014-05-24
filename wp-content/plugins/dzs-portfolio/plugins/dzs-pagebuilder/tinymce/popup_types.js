//top.dzspb_textsel = '[advancedscroller][shortcode_li class="item-tobe"]test1[/shortcode_li][shortcode_li class="item-tobe"]test2[/shortcode_li][/advancedscroller]';




jQuery(document).ready(function($){
    $('.item-type').bind('click', click_itemtype);
    function click_itemtype(){
        var _t = $(this);
        if(typeof(top.dzspb_receiver_type)!='undefined'){
            top.dzspb_receiver_type(_t.find('.the-label').eq(0).html());
        }else{
            if(window.console){ console.log(_t.find('.the-label').eq(0).html())};
        }
    }
});