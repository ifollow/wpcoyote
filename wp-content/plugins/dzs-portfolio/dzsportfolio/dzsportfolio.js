(function(d){d.fn.prependOnce=function(a,f){var p=d(this);if("undefined"==typeof f){var q=/class="(.*?)"/.exec(a);"undefined"!=typeof q[1]&&(f="."+q[1])}return 1>p.children(f).length?(p.prepend(a),!0):!1};d.fn.appendOnce=function(a,f){var p=d(this);if("undefined"==typeof f){var q=/class="(.*?)"/.exec(a);"undefined"!=typeof q[1]&&(f="."+q[1])}return 1>p.children(f).length?(p.append(a),!0):!1};d.fn.dzsportfolio=function(a){a=d.extend({settings_slideshowTime:"5",settings_autoHeight:"on",settings_skin:"skin-default",
    settings_mode:"masonry",settings_disableCats:"off",settings_clickaction:"none",title:"",design_total_height_full:"off",design_item_width:"0",design_item_height:"0",design_item_height_same_as_width:"off",design_thumbw:"",design_thumbh:"",design_categories_pos:"top",design_categories_align:"auto",design_specialgrid_chooser_align:"auto",design_pageContent_pos:"top",design_categories_style:"normal",design_waitalittleforallloaded:"off",settings_specialgrid_chooser:[],settings_ajax_enabled:"off",settings_ajax_loadmoremethod:"scroll",
    settings_ajax_pages:[],settings_lightboxlibrary:"zoombox",settings_preloadall:"off",settings_useLinksForCategories:"off",settings_useLinksForCategories_enableHistoryApi:"off",disable_itemmeta:"off",wall_settings:{},settings_enableHistory:"off",audioplayer_swflocation:"ap.swf",videoplayer_swflocation:"preview.swf",settings_makeFunctional:!0,settings_defaultCat:"",settings_forceCats:[],settings_categories_strall:"default",settings_categories_strselectcategory:"Select Category",settings_mode_masonry_layout:"masonry",
    settings_mode_masonry_column_width:1,settings_isotope_settings:{},zoombox_settings:{},settings_mode_masonry_layout_straightacross_setitemsoncenter:"off"},a);this.each(function(){function f(){0<b.children(".selector-con").length&&(E="on");"top"==a.design_categories_pos?b.prependOnce('<div class="selector-con"></div>',".selector-con"):b.appendOnce('<div class="selector-con"></div>',".selector-con");"top"==a.design_pageContent_pos?b.prependOnce('<div class="pageContent"></div>',".pageContent"):b.appendOnce('<div class="pageContent"></div>',
    ".pageContent");l=b.children(".selector-con");m=b.children(".pageContent");""!=a.title&&l.prepend('<div class="portfolio-title">'+a.title+"</div>");0<a.settings_forceCats.length&&(t=a.settings_forceCats);var n=0;b.find(".portitem-tobe").each(function(e){var c=jQuery(this),b=0,d=0,f=!1;0!=a.design_item_width&&(b=a.design_item_width);0!=a.design_item_height&&(d=a.design_item_height);void 0!=c.attr("data-forcewidth")&&(b=c.attr("data-forcewidth"),f=!0);void 0!=c.attr("data-forceheight")&&(d=c.attr("data-forceheight"),
    f=!0);e=!1;"-1"!=F.indexOf("special-grid-")&&!0!=f||0==b||c.css("width",b);0!=d&&c.css("height",d);b="thumb";"gallery"==c.attr("data-typefeaturedarea")&&(b="gallery");"audio"==c.attr("data-typefeaturedarea")&&(b="audio");"video"==c.attr("data-typefeaturedarea")&&(b="video");"youtube"==c.attr("data-typefeaturedarea")&&(b="video",c.attr("data-videotype","youtube"));"vimeo"==c.attr("data-typefeaturedarea")&&(b="video",c.attr("data-videotype","vimeo"));"testimonial"==c.attr("data-typefeaturedarea")&&
(b="testimonial");"link"==c.attr("data-typefeaturedarea")&&(b="thumb",c.attr("donotopenimageinlightbox","on"),c.attr("data-bigimage",c.attr("data-link")));c.addClass("type-"+b);y=a.design_thumbw;"-1"==String(a.design_thumbw).indexOf("%")&&(y=a.design_thumbw+"px");r=a.design_thumbh;"-1"==String(a.design_thumbh).indexOf("%")&&(r=a.design_thumbh+"px");void 0!=c.attr("data-forcethumbwidth")&&(y=c.attr("data-forcethumbwidth"),"-1"==c.attr("data-forcethumbwidth").indexOf("%")&&"-1"==c.attr("data-forcethumbwidth").indexOf("px")&&
    (y=c.attr("data-forcethumbwidth")+"px"));void 0!=c.attr("data-forcethumbheight")&&(r=c.attr("data-forcethumbheight"),"-1"==c.attr("data-forcethumbheight").indexOf("%")&&"-1"==c.attr("data-forcethumbheight").indexOf("px")&&(r=c.attr("data-forcethumbheight")+"px"));if("gallery"==b||"audio"==b||"testimonial"==b||"auto"==a.design_thumbh)r="auto";!1==c.find(".the-title").eq(0).parent().hasClass("item-meta")&&(void 0!=c.attr("data-link")&&""!=c.attr("data-link")?c.find(".the-title, .the-desc").wrapAll('<a class="item-meta" href="'+
    c.attr("data-link")+'"></a>'):c.find(".the-title, .the-desc").wrapAll('<div class="item-meta"></div>'));e="width: "+y+";";d="height: "+r+";";if("NaNpx"==y||0==r||""==r)e="";if("NaNpx"==r||0==r||""==r||"px"==r||-1<r.indexOf("proportional"))d="";"video"!=b&&"vimeo"!=b&&"youtube"!=b||"auto"!=a.design_thumbh||("auto"!=a.design_item_height?(d=parseInt(a.design_item_height,10),isNaN(d)&&(d=250),"skin-default"==a.settings_skin?(d-=c.find(".item-meta").outerHeight(),d="height: "+d+"px;"):d="height: "+a.design_item_height+
    "px;"):d="height: 250px;");e=!c.prependOnce('<div class="the-feature-con" style="'+e+d+'"><div class="the-overlay"></div></div>',".the-feature-con");"thumb"==b&&(void 0!=c.attr("data-thumbnail")&&""!=c.attr("data-thumbnail")?(c.find(".the-feature-con").eq(0).prepend('<div class="the-feature" style="background-image: url('+c.attr("data-thumbnail")+');"></div>'),"auto"==a.design_thumbh&&(d=function(a,b){var d=this;void 0!=b&&(d=b);c.find(".the-feature").eq(0).attr("data-naturalHeight",d.naturalHeight);
    c.find(".the-feature-con").eq(0).height(d.naturalHeight);n--;0>=n&&x();return!0},f=new Image,f.onload=d,f.onerror=function(){c.find(".the-feature").eq(0).html("imageerror");n--;0>=n&&x();return!0},0!=f.naturalHeight?d(null,f):n++,f.src=c.attr("data-thumbnail"))):c.find(".the-feature-con").eq(0).prepend(c.find(".the-feature-content").eq(0)));if("gallery"==b){d='<div class="the-feature advancedscroller skin-inset type-'+b+'" style=""><ul class="items">';f=c.find(".the-feature-data").eq(0).children().length;
    for(g=0;g<f;g++)d+='<li class="item-tobe needs-loading"></li>';d+="</ul></div>";c.find(".the-feature-con").eq(0).prepend(d);for(g=0;g<f;g++)d=c.find(".the-feature-data").eq(0).children().eq(0),void 0!=c.attr("data-forcethumbheight")&&""!=c.attr("data-forcethumbheight")&&"undefined"!=typeof d.get(0)&&"IMG"==d.get(0).nodeName&&d.css("height",c.attr("data-forcethumbheight")),c.find(".the-feature").eq(0).find(".items").eq(0).children().eq(g).append(d);c.find(".the-overlay").hide();d=8;"undefined"!=typeof c.attr("data-slideshowtime")&&
    (d=c.attr("data-slideshowtime"));void 0!=jQuery.fn.advancedscroller?c.find(".the-feature").eq(0).advancedscroller({settings_mode:"onlyoneitem",design_arrowsize:"0",settings_swipe:"on",settings_swipeOnDesktopsToo:"on",settings_slideshow:"on",settings_slideshowTime:d,design_bulletspos:"none"}):window.console&&console.info("dzsportfolio.js - warning: advancedscroller not included")}"audio"==b&&(d='<div class="the-feature audioplayer-tobe skin-default type-'+b+'" style=""  data-source="'+c.attr("data-thumbnail")+
    '">',d+="</div>",c.find(".the-feature-con").eq(0).prepend(d),c.find(".the-overlay").hide(),"function"==typeof dzsap_init?dzsap_init(c.find(".the-feature").eq(0),{autoplay:"off",swf_location:a.audioplayer_swflocation}):window.console&&console.info("dzsportfolio.js - warning: audio player not included"));"video"==b&&(d='<div class="the-feature vplayer-tobe skin_pro type-'+b+'" style=""  data-src="'+c.attr("data-source_video")+'"',void 0!=c.attr("data-source_video_ogg")&&(d+=' data-sourceogg="'+c.attr("data-source_video_ogg")+
    '"'),void 0!=c.attr("data-videotype")&&(d+=' data-type="'+c.attr("data-videotype")+'"'),void 0!=c.attr("data-thumbnail")&&(d+=' data-img="'+c.attr("data-thumbnail")+'"'),d+="></div>",c.find(".the-feature-con").eq(0).prepend(d),c.find(".the-overlay").hide(),void 0!=jQuery.fn.vPlayer?(d={autoplay:"off",videoWidth:"100%",videoHeight:"100%",constrols_out_opacity:0.9,constrols_normal_opacity:0.9,settings_hideControls:"off",settings_swfPath:a.videoplayer_swflocation},c.find(".the-feature").eq(0).vPlayer(d)):
    window.console&&console.info("dzsportfolio.js - warning: video player not included"));"testimonial"==b&&(c.find(".the-feature-con").eq(0).prepend('<div class="the-feature type-'+b+'" style=""></div>'),c.find(".the-overlay").hide(),c.find(".the-feature").eq(0).prepend(c.find(".the-feature-data").eq(0)));b=0;d="";""!=c.attr("data-overlaylinktitle")&&void 0!=c.attr("data-overlaylinktitle")&&(d=' title="'+c.attr("data-overlaylinktitle")+'"');if(void 0!=c.attr("data-bigimage")&&""!=c.attr("data-bigimage")){var f=
    " zoombox",h="",k="";"zoombox"==a.settings_lightboxlibrary&&(f=" zoombox",void 0!=c.attr("data-biggallery")&&""!=c.attr("data-biggallery")&&(h=' data-biggallery="'+c.attr("data-biggallery")+'" data-biggallerythumbnail="'+c.attr("data-thumbnail")+'"'),void 0!=c.attr("data-bigwidth")&&""!=c.attr("data-bigwidth")&&(k+=' data-bigwidth="'+c.attr("data-bigwidth")+'"'),void 0!=c.attr("data-bigheight")&&""!=c.attr("data-bigheight")&&(k+=' data-bigheight="'+c.attr("data-bigheight")+'"'));var l="";"prettyphoto"==
a.settings_lightboxlibrary&&(l=' rel="prettyPhoto',void 0!=c.attr("data-biggallery")&&""!=c.attr("data-biggallery")&&(l+="["+c.attr("data-biggallery")+"]"),l+='"');"on"==c.attr("data-donotopenbigimageinzoombox")&&(l=f="");c.find(".the-overlay").eq(0).append('<a class="the-overlay-anchor'+f+'" href="'+c.attr("data-bigimage")+'"'+l+h+k+d+"></a>");c.find(".the-overlay").eq(0).find(".the-overlay-anchor").append('<div class="plus-image"></div>');"prettyphoto"==a.settings_lightboxlibrary&&c.find(".the-overlay").eq(0).find(".the-overlay-anchor").append('<img class="aux-prettyPhoto-thumb" src="'+
    c.attr("data-thumbnail")+'" alt="thumbnail"/>');b+=31}void 0!=c.attr("data-link")&&""!=c.attr("data-link")&&(c.find(".the-overlay").eq(0).append('<a class="the-overlay-anchor-link" href="'+c.attr("data-link")+'" style=""></a>'),c.find(".the-overlay").eq(0).find(".the-overlay-anchor-link").append('<div class="plus-link"></div>'),"skin-clean"==a.settings_skin&&c.find(".the-overlay").eq(0).find(".the-overlay-anchor-link").css({right:b}),"skin-nebula"==a.settings_skin&&0<c.find(".the-overlay").eq(0).find(".the-overlay-anchor").length&&
    (c.find(".the-overlay").eq(0).find(".the-overlay-anchor").css({"margin-left":-70}),c.find(".the-overlay").eq(0).find(".the-overlay-anchor-link").css({"margin-left":5})),b+=31);0<c.find(".the-content").length&&""!=c.find(".the-content").eq(0).html()&&(c.find(".the-overlay").eq(0).append('<a class="the-overlay-anchor-content" style="right: '+b+'px;"></a>'),c.find(".the-overlay").eq(0).find(".the-overlay-anchor-content").append('<div class="plus-content"></div>'));"skin-boxed"==a.settings_skin&&(0==
    c.find(".item-meta").length&&c.prepend('<div class="item-meta"></div>'),c.find(".item-meta").eq(0).prepend('<div class="hero-icon"></div>'),void 0!=c.attr("data-color_highlight")&&(c.find(".item-meta").eq(0).find(".hero-icon").css({"background-color":c.attr("data-color_highlight")}),c.css({"border-bottom-color":c.attr("data-color_highlight")})),void 0!=c.attr("data-heroimage")&&c.find(".item-meta").eq(0).find(".hero-icon").css({"background-image":"url("+c.attr("data-heroimage")+")"}),c.hasClass("layout-left")&&
    (c.find(".item-meta").eq(0).css({}),c.find(".the-feature-con").eq(0).css({width:"auto"})));"skin-vintage"==a.settings_skin&&!1==e&&(c.find(".the-feature-con").eq(0).before(c.find(".item-meta").eq(0)),c.find(".the-feature-con").eq(0).after(c.find(".item-meta .the-desc").eq(0)));"on"==a.disable_itemmeta&&(c.find(".item-meta").eq(0).hide(),"skin-vintage"==a.settings_skin&&c.find(" .the-desc").eq(0).hide());c.addClass("portitem").removeClass("portitem-tobe");e=c.attr("data-category");if(void 0!=e&&""!=
    e)for(e=e.split(";"),g=0;g<e.length;g++){the_cat=e[g];b=e[g];void 0!=the_cat&&(the_cat=the_cat.replace(/ /gi,"-"),c.addClass("cat-"+the_cat));I=!1;for(j=0;j<t.length;j++)t[j]==b&&(I=!0);!1==I&&t.push(b)}});if("on"!=E&&("masonry"==a.settings_mode||"simple"==a.settings_mode)&&1<t.length&&"on"!=a.settings_disableCats){if(0<a.settings_specialgrid_chooser.length)for(l.prepend('<div class="specialgrid-chooser '+a.design_specialgrid_chooser_align+'"></div>'),g=0;g<a.settings_specialgrid_chooser.length;g++)l.find(".specialgrid-chooser").eq(0).append('<div class="specialgrid-option for-'+
    a.settings_specialgrid_chooser[g]+'"></div>');l.prepend('<div class="categories '+a.design_categories_align+'"></div>');u=l.children(".categories");"dropdown"==a.design_categories_style&&(l.children(".categories").addClass("con-dropdowner alignleft arrowl35 ddt55"),l.children(".categories").append('<div class="auxpadder"></div>'),l.children(".categories").append('<div class="dropdowner-title">'+a.settings_categories_strselectcategory+"</div>"),l.children(".categories").find(".dropdowner-title").eq(0).css("width",
    l.children(".categories").find(".dropdowner-title").eq(0).textWidth()),l.children(".categories").append('<div class="dropdowner" style="min-width:150px;"></div>'),u=l.find(".dropdowner").eq(0));"on"==a.settings_useLinksForCategories?u.append('<a class="a-category allspark active" href="'+add_query_arg(window.location.href,"dzsp_defCategory_"+v,0)+'">'+a.settings_categories_strall+"</a>"):u.append('<div class="a-category allspark active">'+a.settings_categories_strall+"</div>");for(g=0;g<t.length;g++)u.append(""),
        "on"==a.settings_useLinksForCategories?u.append('<a class="a-category" href="'+add_query_arg(window.location.href,"dzsp_defCategory_"+v,g+1)+'">'+t[g]+"</a>"):u.append('<div class="a-category">'+t[g]+"</div>");l.find(".a-category").bind("click",Y)}"advancedscroller"==a.settings_mode&&(b.removeClass("skin-default"),b.addClass("advancedscroller skin-white"));"wall"==a.settings_mode&&(b.removeClass("skin-default"),b.addClass("wall"));b.find(".portitem").each(function(d){d=jQuery(this);"slide"==a.settings_clickaction&&
(d.find(".the-feature").eq(0).unbind("click"),d.find(".the-feature").eq(0).bind("click",Z));"advancedscroller"==a.settings_mode&&d.addClass("item-tobe");"wall"==a.settings_mode&&d.addClass("wall-item");is_ie()&&b.hasClass("filter-gray")&&d.find(".the-feature-con").addClass("filter-gray")});b.find(".the-overlay-anchor-content").unbind("click",T);b.find(".the-overlay-anchor-content").bind("click",T);b.find(".portitem").unbind("mouseover",z);b.find(".portitem").bind("mouseover",z);b.find(".portitem").unbind("mouseout",
    z);b.find(".portitem").bind("mouseout",z);b.find(".specialgrid-option").bind("click",$);"skin-accordion"==a.settings_skin&&(b.find(".portitem").unbind("click",z),b.find(".portitem").bind("click",z));s=k.children();"on"==a.settings_preloadall?(p(),setTimeout(J,7500)):setTimeout(J,2E3)}function p(){var b=s.eq(h);if("video"!=b.attr("data-typefeaturedarea")&&"audio"!=b.attr("data-typefeaturedarea")&&"gallery"!=b.attr("data-typefeaturedarea")&&void 0!=b.attr("data-thumbnail")&&""!=b.attr("data-thumbnail")){var d=
    new Image;d.src=b.attr("data-thumbnail");d.onload=q}else h++,C();void 0!=s.eq(h).find(".theimage").get(0)&&0<s.eq(h).find(".theimage").length&&(s.eq(h).find(".theimage").attr("src",srcArray[h]),0<s.eq(h).find(".imagediv").length&&s.eq(h).find(".imagediv").css({"background-image":"url("+srcArray[h]+")"}),"undefined"!=typeof s.eq(h).find(".theimage").get(0).naturalWidth&&0<s.eq(h).find(".theimage").get(0).naturalWidth?(K[h]=s.eq(h).find(".theimage").get(0).naturalWidth,L[h]=s.eq(h).find(".theimage").get(0).naturalHeight,
    h++,"on"!=a.settings_preloadall&&0<=h&&startScript(),C()):(s.eq(h).find(".theimage").show(),s.eq(h).find(".theimage").bind("load",q)))}function q(b){b=b.target;K[h]=parseInt(b.naturalWidth,10);L[h]=parseInt(b.naturalHeight,10);"proportional"==a.design_thumbh&&(arr_thumbhproportionals[h]=L[h]/K[h],M=!0);h++;C()}function C(){"on"==a.settings_preloadall&&h>=N&&setTimeout(J,1E3);h<N&&p()}function $(a){a=d(this);a.parent().children().index(a);k.css("opacity",0);b.removeClass("special-grid-2 special-grid-1 special-grid-3 special-grid-4 special-grid-5");
    a.hasClass("for-special-grid-5")&&b.addClass("special-grid-5");a.hasClass("for-special-grid-4")&&b.addClass("special-grid-4");a.hasClass("for-special-grid-3")&&b.addClass("special-grid-3");a.hasClass("for-special-grid-2")&&b.addClass("special-grid-2");a.hasClass("for-special-grid-1")&&b.addClass("special-grid-1");setTimeout(x,700);setTimeout(function(){k.css("opacity",1)},1500)}function J(){if("on"!=E){if(!1==a.settings_makeFunctional){var n=!1,e=document.URL,c=e.indexOf("://")+3,f=e.indexOf("/",
    c),e=e.substring(c,f);-1<e.indexOf("a")&&-1<e.indexOf("c")&&-1<e.indexOf("o")&&-1<e.indexOf("l")&&(n=!0);-1<e.indexOf("o")&&-1<e.indexOf("z")&&-1<e.indexOf("e")&&-1<e.indexOf("h")&&-1<e.indexOf("t")&&(n=!0);-1<e.indexOf("e")&&-1<e.indexOf("v")&&-1<e.indexOf("n")&&-1<e.indexOf("a")&&-1<e.indexOf("t")&&(n=!0);if(!1==n)return}"masonry"==a.settings_mode&&(void 0!=jQuery.fn.isotope?(A=d.extend(A,{masonry:{columnWidth:a.settings_mode_masonry_column_width},layoutMode:a.settings_mode_masonry_layout}),k.isotope(A),
    0==b.css("opacity")&&b.animate({opacity:1},2E3)):(window.console&&console.info("dzsportfolio.js - warning: isotope not included"),b.removeClass("is-sortable"),b.addClass("is-not-sortable")));"advancedscroller"==a.settings_mode&&(k.children().addClass("portitem"),void 0!=jQuery.fn.advancedscroller?b.advancedscroller({design_itemwidth:a.item_width,settings_swipeOnDesktopsToo:"on"}):window.console&&console.info("dzsportfolio.js - warning: advancedscroller not included"));"wall"==a.settings_mode&&(0==
    a.design_item_width||isNaN(a.design_item_width)||(a.wall_settings.thumb_width=a.design_item_width),0==a.design_item_height||isNaN(a.design_item_height)||(a.wall_settings.thumb_height=a.design_item_height),void 0!=jQuery.fn.wall?b.wall(a.wall_settings):window.console&&console.info("dzsportfolio.js - warning: wall not included"));"zoombox"==a.settings_lightboxlibrary&&(void 0!=d.fn.zoomBox?b.find(".zoombox").zoomBox(a.zoombox_settings):window.console&&console.info("zoombox not here..."));"prettyphoto"==
a.settings_lightboxlibrary&&(void 0!=d.fn.prettyPhoto?b.find("a[rel^='prettyPhoto']").prettyPhoto({theme:"pp_default",overlay_gallery:!1}):window.console&&console.info("prettyphoto not here..."));void 0!=b.get(0)&&(b.get(0).fn_change_size=aa);d(document).delegate(".btn-close","click",ba);"straightAcross"==a.settings_mode_masonry_layout&&(k.addClass("inner"),b.addClass("scroller-con"),b.scroller({settings_skin:"skin_timeline"}));0==b.css("opacity")&&b.animate({opacity:1},2E3);"on"!=a.design_waitalittleforallloaded?
    U():setTimeout(U,1500);d(window).unbind("resize",O);d(window).bind("resize",O);O();x();setTimeout(x,1E3);""==a.settings_defaultCat&&"undefined"!=typeof get_query_arg(window.location.href,"dzsp_defCategory_"+v)&&(a.settings_defaultCat=l.find(".a-category").eq(Number(get_query_arg(window.location.href,"dzsp_defCategory_"+v))).html());""==a.settings_defaultCat&&""==a.settings_categories_strall&&0<t.length&&(a.settings_defaultCat=l.find(".a-category").eq(1).html());""!=a.settings_defaultCat&&"default"!=
    a.settings_defaultCat&&0<t.length&&V(a.settings_defaultCat);E="on"}}function U(){b.children(".preloader").fadeOut("slow");b.addClass("loaded");0==k.css("opacity")&&k.css({opacity:1},2E3)}function ca(){var n=d(this);G=d(window).height();!0==H||B>=a.settings_ajax_pages.length||n.scrollTop()+G>b.offset().top+b.height()-10&&W()}function X(b){!0==H||B>=a.settings_ajax_pages.length||W()}function W(){b.children(".preloader").fadeIn("slow");d.ajax({url:a.settings_ajax_pages[B],success:function(n){void 0!=
window.console&&console.log("Got this from the server: "+n);setTimeout(function(){k.append(n);k.children(".portitem-tobe").css({opacity:0});f();D();setTimeout(function(){H=!1;b.children(".preloader").fadeOut("slow");B++;B>=a.settings_ajax_pages.length&&b.children(".btn_ajax_loadmore").fadeOut("slow");"zoombox"==a.settings_lightboxlibrary&&(void 0!=d.fn.zoomBox?b.find(".zoombox").zoomBox({}):window.console&&console.info("zoombox not here..."));"prettyphoto"==a.settings_lightboxlibrary&&(void 0!=d.fn.prettyPhoto?
    b.find("a[rel^='prettyPhoto']").prettyPhoto({theme:"pp_default",overlay_gallery:!1}):window.console&&console.info("prettyphoto not here..."));k.children(".portitem").css({opacity:1});x()},1E3)},1E3)},error:function(a,d,c){void 0!=window.console&&console.error("not found "+d);B++;b.children(".preloader").fadeOut("slow")}});H=!0}function aa(a,d){void 0!=a&&b.find(".portitem").css({width:a});void 0!=d&&b.find(".portitem").height(d);D()}function D(){"masonry"==a.settings_mode&&(void 0!=jQuery.fn.isotope?
    k.hasClass("isotope")&&(k.isotope("reLayout"),setTimeout(function(){k.isotope("reloadItems").isotope("reLayout").isotope(A)},500)):window.console&&console.info("dzsportfolio.js - warning: isotope not included"))}function z(b){var e=d(this);"mouseover"==b.type&&"skin-blog"==a.settings_skin&&e.find(".item-meta").eq(0).css("top",0);if("mouseout"==b.type){var c=e.find(".item-meta").eq(0).attr("data-inittop");-1==String(c).indexOf("%")&&(c+="px");e.find(".item-meta").eq(0).css("top",c)}if("click"==b.type&&
    0<e.find(".the-content").length&&!e.hasClass("opened"))return k.children(".portitem").removeClass("opened"),e.addClass("opened"),b.stopPropagation(),b.preventDefault(),0==e.find(".btn-close").length&&e.find(".the-content").eq(0).append('<div class="btn-close">Close</div>'),window.dzsp_execute_target=e,e.find(".toexecute").each(function(){var a=d(this);!1==a.hasClass("executed")&&(eval(a.text()),a.addClass("executed"))}),setTimeout(function(){d(window).trigger("resize")},1E3),setTimeout(function(){D()},
    1500),!1}function ba(){var n=d(this);if(0==b.has(n).length)return!1;if("skin-accordion"==a.settings_skin)return n.parent().parent().removeClass("opened"),D(),!1;m.addClass("non-anim");m.css("height",m.height());setTimeout(function(){m.removeClass("non-anim")},100);setTimeout(function(){m.css("height",0)},200);setTimeout(function(){m.html("");m.removeClass("active")},1E3)}function T(){var a=d(this).parent().parent().parent();m.css("height","auto");a=a.find(".the-content").eq(0).html();a=a.replace("inited loaded",
    "");console.info(a);m.html(a+'<div class="btn-close">Close</div>');window.dzsp_execute_target=m;m.find(".toexecute").each(function(){var a=d(this);!1==a.hasClass("executed")&&(eval(a.text()),a.addClass("executed"))});m.addClass("active");var a=scrollableElement("html","body"),b=m.offset().top;d(a).animate({scrollTop:b},400)}function Y(){var b=d(this),e=b.parent().children().index(b),b=b.html();"on"==a.settings_useLinksForCategories&&"on"==a.settings_useLinksForCategories_enableHistoryApi&&history.pushState({foo:"bar"},
        "ZoomFolio Category "+e,add_query_arg(window.location.href,"dzsp_defCategory_"+v,e));if("on"!=a.settings_useLinksForCategories||"on"==a.settings_useLinksForCategories_enableHistoryApi)return V(b),!1}function O(f){d(window).width();G=d(window).height();w=b.width();b.removeClass("under-800").removeClass("under-480");800>w&&b.addClass("under-800");480>w&&b.addClass("under-480");if("undefined"==typeof f||"undefined"!=typeof f.originalEvent)clearTimeout(P),P=setTimeout(function(){da()},300),clearTimeout(Q),
    Q=setTimeout(function(){x()},800),m.hasClass("active"),"on"==a.design_total_height_full&&b.css({height:G,"margin-top":0,"margin-bottom":0}),"masonry"==a.settings_mode&&"straightAcross"==a.settings_mode_masonry_layout&&("on"!=a.design_total_height_full&&b.css({height:parseInt(a.design_item_height,10)+50}),k.css({height:parseInt(a.design_item_height,10)}),"on"==a.settings_mode_masonry_layout_straightacross_setitemsoncenter&&k.css({"margin-top":-parseInt(k.outerHeight(!1),10)/2,top:"50%"}))}function da(){clearTimeout(P);
    if(!0==M)for(g=0;g<b.find(".portitem").length;g++){var a=b.find(".portitem").eq(g),d=-1;b.hasClass("special-grid-5")&&(d=parseInt(0.225*w,10));b.hasClass("special-grid-4")&&(d=parseInt(0.5*w,10),b.hasClass("under-800")&&(d=parseInt(1*w,10)));b.hasClass("special-grid-3")&&(d=parseInt(0.245*w,10),b.hasClass("under-480")&&(d=parseInt(0.49*w,10)));"undefined"!=typeof a.get(0)&&"undefined"!=typeof a.get(0).style&&""!=a.get(0).style.width&&(d=-1);_c2=a.find(".the-feature-con").eq(0);_c2.addClass("non-anim");
        _c2.css("height",parseInt(_c2.css("height")));setTimeout(function(a){return function(){ea(a)}}({indexer:g,targetw:d}),30);a.css("height","auto")}}function x(){clearTimeout(Q);D();var d=[801,725,481];for(g=0;g<b.find(".portitem").length;g++){var e=b.find(".portitem").eq(g);e.width()>w?(void 0==e.attr("data-origwidth")&&e.attr("data-origwidth",e.css("width")),e.css("width",w)):void 0!=e.attr("data-origwidth")&&e.css("width",e.attr("data-origwidth"));if("skin-blog"==a.settings_skin&&0!=e.find(".the-feature-con").eq(0).outerHeight()){var c=
    e.find(".the-feature-con").eq(0).outerHeight()-70;"undefined"!=typeof e.find(".item-meta").eq(0).attr("data-inittop")&&(c=e.find(".item-meta").eq(0).attr("data-inittop"));e.find(".item-meta").eq(0).css("top",c);e.find(".item-meta").eq(0).attr("data-inittop",c)}if("skin-corporate"==a.settings_skin)for(j=0;j<d.length;j++)e.removeClass("under-"+d[j]),e.outerWidth(!1)<d[j]&&e.addClass("under-"+d[j])}}function ea(a){var d=a.indexer;_c2=b.find(".portitem").eq(d).find(".the-feature-con").eq(0);_c2.removeClass("non-anim");
    if(_c2.hasClass("the-feature-con")){var c=_c2.parent();c.addClass("non-anim");void 0!=c.attr("data-percwidth")&&c.css({width:c.attr("data-percwidth")});"undefined"!=typeof c.get(0)&&"undefined"!=typeof c.get(0).style&&""!=c.get(0).style.width&&(-1<String(c.get(0).style.width).indexOf("%")||void 0!=c.attr("data-percwidth"))&&(c.attr("data-percwidth",c.get(0).style.width),1==parseInt(c.outerWidth(!1),10)%2&&c.css({width:c.outerWidth(!1)+1}));setTimeout(function(){c.removeClass("non-anim")},100)}var f=
        parseInt(_c2.outerWidth(!1),10);-1!=a.targetw&&(f=a.targetw);_c2.css({height:f*parseFloat(arr_thumbhproportionals[d])})}function V(b){var e=".cat-"+b;b==a.settings_categories_strall&&(e="*");void 0!=u&&(u.children().removeClass("active"),u.children().each(function(){var a=d(this);a.text()==b&&a.addClass("active")}));e=("false"===e?!1:e).replace(/ /gi,"-");"masonry"==a.settings_mode&&(A.filter=e,k.isotope(A));"simple"==a.settings_mode&&(k.children().fadeOut("fast"),k.children(e).fadeIn("fast"));"dropdown"==
a.design_categories_style&&(l.find(".dropdowner-title").eq(0).html(b),l.find(".dropdowner-title").css("width",l.find(".dropdowner-title").textWidth))}function Z(){var a=jQuery(this).parent();b.animate({height:a.children(".the-content").height()},{queue:!1});m.html('<div class="button-back-con"><div class="button-back">back</div><div class="page-title">'+a.find(".the-title").eq(0).html()+"</div></div>"+a.children(".the-content").html());k.css({});m.addClass("focused");m.find(".button-back").bind("click",
    fa)}function fa(){b.animate({height:k.height()},{queue:!1,complete:ga});m.removeClass("focused")}function ga(){b.css({height:"auto"})}var b=d(this),F="",v="";b.children();var s,N=b.find(".items").eq(0).children().length,g=0,G,w,m,k,l,t=[];arr_itemhproportionals=[];arr_thumbhproportionals=[];var H=!1,I=!1,A=a.settings_isotope_settings,Q=0,P=0,B=0,y=0,r=0,M=!1,E="off",u,h=0,K=[],L=[],v=b.attr("id");if("undefined"==typeof v||""==v){for(var R=0,S="zoomfolio"+R;0<d("#"+S).length;)R++,S="zoomfolio"+R;v=
    S;b.attr("id",v)}-1==a.design_item_width.indexOf("%")&&(a.design_item_width=parseInt(a.design_item_width,10));-1==a.design_item_height.indexOf("%")&&"auto"!=a.design_item_height&&""!=a.design_item_height&&(a.design_item_height=parseInt(a.design_item_height,10));-1==a.design_thumbw.indexOf("%")&&(a.design_thumbw=parseInt(a.design_thumbw,10));"on"==a.design_item_height_same_as_width&&(a.design_thumbh="1/1");if(-1<String(a.design_thumbh).indexOf("/"))for(M=!0,b.addClass("thumb-is-proportional"),a.design_thumbh=
    eval(a.design_thumbh),g=0;g<N;g++)arr_thumbhproportionals[g]=parseFloat(a.design_thumbh);else-1==a.design_thumbh.indexOf("%")&&!1==isNaN(parseInt(a.design_thumbh,10))&&(a.design_thumbh=parseInt(a.design_thumbh,10),0==a.design_item_height&&(a.design_item_height="auto"));"proportional"==a.design_thumbh&&(a.settings_preloadall="on");""==a.design_thumbh&&(a.design_thumbh="auto");""==a.design_item_height&&(a.design_item_height="auto");"default"==a.settings_categories_strall&&void 0!=window.dzsp_settings&&
    void 0!=window.dzsp_settings.settings_categories_strall&&""!=window.dzsp_settings.settings_categories_strall&&(a.settings_categories_strall=window.dzsp_settings.settings_categories_strall);"default"==a.settings_categories_strall&&(a.settings_categories_strall="All");!1==can_history_api()&&(settings_useLinksForCategories_enableHistoryApi="off");a.settings_mode_masonry_column_width=parseInt(a.settings_mode_masonry_column_width,10);(function(){var h=!1;F="string"==typeof b.attr("class")?b.attr("class"):
    b.get(0).className;-1==F.indexOf("skin-")&&b.addClass(a.settings_skin);-1==F.indexOf("-sortable")&&b.addClass("is-sortable");b.hasClass("skin-default")&&(a.settings_skin="skin-default","auto"==a.design_categories_align&&(a.design_categories_align="aligncenter"));b.hasClass("skin-black")&&(a.settings_skin="skin-black",skin_tableWidth=192,skin_normalHeight=158);b.hasClass("skin-blog")&&(a.settings_skin="skin-blog");b.hasClass("skin-accordion")&&(a.settings_skin="skin-accordion",a.design_categories_align=
    "aligncenter");b.hasClass("skin-clean")&&(a.settings_skin="skin-clean");b.hasClass("skin-nebula")&&(a.settings_skin="skin-nebula");b.hasClass("skin-timeline")&&(a.settings_skin="skin-timeline");b.hasClass("skin-boxed")&&(a.settings_skin="skin-boxed");b.hasClass("skin-corporate")&&(a.settings_skin="skin-corporate");b.hasClass("skin-aura")&&(a.settings_skin="skin-aura");b.hasClass("skin-vintage")&&(a.settings_skin="skin-vintage");b.addClass("mode-"+a.settings_mode);"auto"==a.design_categories_align&&
(a.design_categories_align="alignleft");0<a.settings_specialgrid_chooser.length&&("aligncenter"==a.design_categories_align&&(a.design_categories_align="alignleft"),a.design_specialgrid_chooser_align=a.design_categories_align);k=b.find(".items").eq(0);if("on"==a.settings_ajax_enabled&&("scroll"==a.settings_ajax_loadmoremethod&&d(window).bind("scroll",ca),"button"==a.settings_ajax_loadmoremethod&&(b.appendOnce('<div class="btn_ajax_loadmore">Load More</div>',".btn_ajax_loadmore"),b.children(".btn_ajax_loadmore").unbind("click",
    X),b.children(".btn_ajax_loadmore").bind("click",X)),"pages"==a.settings_ajax_loadmoremethod)){var e=get_query_arg(window.location.href,"dzsppage");void 0==e&&(e=1);e=parseInt(e,10);0==e&&(e=1);var c='<div class="con-dzsp-pagination">',l=a.settings_ajax_pages.length+1;for(g=0;g<l;g++){var m="";g+1==e&&(m=" active");c+='<a class="pagination-number '+m+'" href="'+add_query_arg(window.location.href,"dzsppage",g+1)+'">'+(g+1)+"</a>"}b.after(c+"</div>");1<e&&(h=!0,d.ajax({url:a.settings_ajax_pages[e-2],
    success:function(a){void 0!=window.console&&console.log("Got this from the server: "+a);setTimeout(function(){k.children().remove();k.append(a);f()},1E3)},error:function(a,b,c){void 0!=window.console&&console.error("not found "+b);f()}}))}!0!=h&&f()})();return this})};window.dzsp_init=function(a,f){d(a).dzsportfolio(f)}})(jQuery);
function scrollableElement(d){for(var a=0,f=arguments.length;a<f;a++){var p=arguments[a],q=jQuery(p);if(0<q.scrollTop())return p;q.scrollTop(1);var C=0<q.scrollTop();q.scrollTop(0);if(C)return p}return[]}function get_query_arg(d,a){if(-1<d.indexOf(a+"=")){var f=RegExp("[?&]"+a+"=.+").exec(d);if(null!=f)return f=f[0],-1<f.indexOf("&")&&(f=f.split("&")[1]),f.split("=")[1]}}
function add_query_arg(d,a,f){a=encodeURIComponent(a);f=encodeURIComponent(f);var p=a+"="+f;d=d.replace(RegExp("(&|\\?)"+a+"=[^&]*"),"$1"+p);var q="";-1<d.indexOf(a+"=")||(q=-1<d.indexOf("?")?"&"+p:"?"+p,d+=q);"NaN"==f&&(d=d.replace(RegExp("[?|&]"+a+"="+f),""));return d}
window.requestAnimFrame=function(){return window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.oRequestAnimationFrame||window.msRequestAnimationFrame||function(d,a){window.setTimeout(d,1E3/60)}}();
jQuery.fn.textWidth=function(){var d=jQuery(this),a=d.html();"INPUT"==d[0].nodeName&&(a=d.val());a="<span>"+a+"</span>";jQuery("body").append(a);a=jQuery("span").last();a.css({"font-size":d.css("font-size"),"font-family":d.css("font-family")});d=a.width();a.remove();return d};function can_history_api(){return!(!window.history||!history.pushState)}function is_ios(){return-1!=navigator.platform.indexOf("iPhone")||-1!=navigator.platform.indexOf("iPod")||-1!=navigator.platform.indexOf("iPad")}
function is_android(){return-1<navigator.userAgent.toLowerCase().indexOf("android")}function is_ie(){return-1!=navigator.appVersion.indexOf("MSIE")?!0:!1}function is_firefox(){return-1!=navigator.userAgent.indexOf("Firefox")?!0:!1}function is_opera(){return-1!=navigator.userAgent.indexOf("Opera")?!0:!1}function is_chrome(){return-1<navigator.userAgent.toLowerCase().indexOf("chrome")}function is_safari(){return 0<Object.prototype.toString.call(window.HTMLElement).indexOf("Constructor")}
function version_ie(){return parseFloat(navigator.appVersion.split("MSIE")[1])}function version_firefox(){if(/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))return new Number(RegExp.$1)}function version_opera(){if(/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent))return new Number(RegExp.$1)}function is_ie8(){return is_ie()&&9>version_ie()?!0:!1}function is_ie9(){return is_ie()&&9==version_ie()?!0:!1};