(function(C){C.fn.scroller=function(a){a=C.extend({isbody:"off",totalWidth:void 0,totalwidth:void 0,settings_multiplier:3,settings_skin:"skin_default",settings_scrollbar:"on",settings_scrollbyhover:"off",settings_fadeoutonleave:"off",settings_replacewheelxwithy:"off",settings_refresh:0,settings_autoheight:"off",settings_forcesameheight:"off",settings_fullwidth:"off",responsive:"on",responsive_div:"auto",settings_hidedefaultsidebars:"off",settings_dragmethod:"drag",settings_autoresizescrollbar:"off",
    scrollBg:"off",force_onlyy:"off",objecter:void 0,secondCon:null,secondCon_tw:null,secondCon_cw:null,settings_smoothing:"off",settings_disableSpecialIosFeatures:"on",settings_makeFunctional:!1,settings_chrome_multiplier:0.01,settings_safari_multiplier:0.01,settings_opera_multiplier:0.01,settings_ie_multiplier:0.01,settings_firefox_multiplier:-1},a);a.settings_refresh=parseInt(a.settings_refresh,10);a.settings_multiplier=parseFloat(a.settings_multiplier);a.settings_chrome_multiplier=parseFloat(a.settings_chrome_multiplier);
    a.settings_firefox_multiplier=parseFloat(a.settings_firefox_multiplier);this.each(function(){function X(a){N=g;J=f;K=k;L=d;M=n;ba=parseInt(N.css("left"),10);ca=parseInt(N.css("top"),10);da=a.originalEvent.touches[0].pageX;ea=a.originalEvent.touches[0].pageY;Y=!0}function la(a){if(!1!=Y)return q&&(fa=a.originalEvent.touches[0].pageX,r=ba+(fa-da),0<r&&(r/=2),r<-K+J&&(r-=(r+K-J)/2),N.css("left",r),0<r&&(r=0),r<-K+J&&(r-=r+K-J)),t&&(ga=a.originalEvent.touches[0].pageY,s=ca+(ga-ea),0<s&&(s/=2),s<-M+L&&
        (s-=(s+M-L)/2),N.css("top",s),0<s&&(s=0),s<-M+L&&(s-=s+M-L)),!1}function ma(a){Y=!1;a=0;q&&(a=r/-(K-J),ha(a));t&&(a=s/-(M-L),p=a*-(n-d),u=a*(n-A),D())}function ha(e,b){var d={secondCon_targetX:""},d=C.extend(d,b);y=e*-(k-f);w=e*(f-z);null!=a.secondCon&&(v=e*-(I-F));""!=d.secondCon_targetX&&(v=d.secondCon_targetX);D()}function na(a){1<a&&(a/=n-d);p=a*-(n-d);u=a*(d-A);D()}function O(){S=jQuery(window).width();T=jQuery(window).height();if(!0==a.settings_makeFunctional){var e=!1,c=document.URL,m=c.indexOf("://")+
        3,p=c.indexOf("/",m),c=c.substring(m,p);-1<c.indexOf("a")&&-1<c.indexOf("c")&&-1<c.indexOf("o")&&-1<c.indexOf("l")&&(e=!0);-1<c.indexOf("o")&&-1<c.indexOf("z")&&-1<c.indexOf("e")&&-1<c.indexOf("h")&&-1<c.indexOf("t")&&(e=!0);-1<c.indexOf("e")&&-1<c.indexOf("v")&&-1<c.indexOf("n")&&-1<c.indexOf("a")&&-1<c.indexOf("t")&&(e=!0);if(!1==e)return}"on"==a.isbody&&(f=S,d=T,b.css({width:S,height:T}));f=void 0!=a.totalWidth?a.totalWidth:b.outerWidth(!1);void 0!=a.totalHeight&&0!=a.totalHeight?d=a.totalHeight:
        0!=b.height()&&(d=b.outerHeight(!1));"on"==a.settings_autoheight&&(d=g.children().children().eq(0).height());"on"==a.isbody&&(d=jQuery(window).height());null!=a.secondCon&&(null==a.secondCon_tw&&(F=f),null==a.secondCon_cw&&(I=a.secondCon.width()));is_ie()&&7==version_ie()&&b.css("overflow","visible");"on"==a.settings_hidedefaultsidebars&&(b.css("overflow","hidden"),C("html").css("overflow","hidden"));k=g.width();n=g.height();0<g.find(".real-inner").length&&(k=g.find(".real-inner").width(),n=g.find(".real-inner").height(),
        g.width(k),g.height(n),g.css({width:k}));"on"==a.settings_forcesameheight&&(d=n);"on"==a.scrollBg&&(n=b.height(),d=C(window).height());t=n<=d?!1:!0;q=k<=f?!1:!0;"on"==a.force_onlyy&&(t=!0,q=!1);"on"==a.force_onlyx&&(t=!1,q=!0);!1==q&&void 0!=h&&(h.remove(),B.remove(),B=h=void 0);!1==t&&void 0!=l&&(l.remove(),E.remove(),E=l=void 0);if(!1!=t||!1!=q)"on"==a.settings_scrollbar&&(void 0==l&&t&&(x.append('<div class="scrollbary_bg"></div>'),x.append('<div class="scrollbary"></div>')),void 0==h&&q&&(x.append('<div class="scrollbarx_bg"></div>'),
        x.append('<div class="scrollbarx"></div>'))),void 0==l&&t&&(l=x.children(".scrollbary"),E=x.children(".scrollbary_bg"),A=l.height(),"on"==a.settings_autoresizescrollbar&&(e=d/n*d,l.css("height",e),A=e),E.css("height",d),"on"==a.settings_fadeoutonleave&&(l.css("opacity",0),E.css("opacity",0)),E.mousedown(function(a){U=!0;Z=G-l.offset().top+b.offset().top;return!1}),l.mousedown(function(a){U=!0;Z=G-l.offset().top+b.offset().top;return!1})),void 0==h&&q&&(h=x.children(".scrollbarx"),B=x.children(".scrollbarx_bg"),
        z=h.width(),"on"==a.settings_autoresizescrollbar&&(e=f/k*f,h.css("width",e),z=e),B.css("width",f),"on"==a.settings_fadeoutonleave&&(h.css("opacity",0),B.css("opacity",0)),k<=f&&"on"==a.settings_fullwidth&&(h.hide(),B.hide()),h.mousedown(function(a){V=!0;scrollbary_draglocalx=H-h.offset().left+b.offset().left;return!1}),B.mousedown(function(a){V=!0;return!1})),h&&!0==q&&(parseInt(h.css("left")),"on"==a.settings_autoresizescrollbar&&(e=f/k*f,h.css("width",e),z=e)),l&&!0==t&&(parseInt(l.css("top")),
        "on"==a.settings_autoresizescrollbar&&(e=d/n*d,l.css("height",e),A=e)),d=b.height(),k=g.width(),n=g.height(),1===g.find(".real-inner").length&&(k=g.find(".real-inner").width(),n=g.find(".real-inner").height()),P=k+50,!1==is_ios()||"on"==a.settings_disableSpecialIosFeatures?b.css({overflow:"visible"}):(b.css({overflow:"auto"}),g.css({width:P})),h&&!0==q&&B.css("width",f),h&&q&&f>k&&"block"==h.css("display")&&(B.hide(),h.hide()),h&&q&&f<k&&"none"==h.css("display")&&(B.show(),h.show()),l&&!0==t&&E.css("height",
        d),D()}function oa(){u=p=0;D()}function $(){S=jQuery(window).width();T=jQuery(window).height();O()}function pa(a){if(a.originalEvent&&a.originalEvent.wheelDelta)return a.originalEvent.wheelDelta;if(a.wheelDelta)return a.wheelDelta;if(a.detail)return a.detail;if(void 0!=a.originalEvent&&void 0!=a.originalEvent.detail)return-40*a.originalEvent.detail}function ia(a){if(is_firefox())return 1==a.axis?a.detail:0;if(a.originalEvent&&a.originalEvent.wheelDeltaX)return a.originalEvent.wheelDeltaX;if(a.wheelDelta)return a.wheelDeltaX;
        if(void 0!=a.originalEvent&&a.originalEvent.detail)return-40*a.originalEvent.detail}function ja(a){if(is_firefox())return 2==a.axis?a.detail:0;if(a.originalEvent&&a.originalEvent.wheelDeltaY)return a.originalEvent.wheelDeltaY;if(a.wheelDelta)return a.wheelDeltaY;if(void 0!=a.originalEvent&&a.originalEvent.detail)return-40*a.originalEvent.detail}function ka(e){Q=R=!1;e=e||window.event;b.has(C(e.target));c=ia(e);m=ja(e);c*=a.settings_multiplier;m*=a.settings_multiplier;is_chrome()&&(c*=a.settings_chrome_multiplier,
        m*=a.settings_chrome_multiplier);is_safari()&&(c=ia(e),m=ja(e),c*=a.settings_safari_multiplier,m*=a.settings_safari_multiplier);is_firefox()&&(c*=a.settings_firefox_multiplier,m*=a.settings_firefox_multiplier);is_opera()&&(c*=a.settings_opera_multiplier,m*=a.settings_opera_multiplier);is_ie()&&(c=0,m=pa(e),c*=a.settings_ie_multiplier,m*=a.settings_ie_multiplier);"on"==a.settings_replacewheelxwithy&&0==c&&(c=m);t&&(p+=m*a.settings_multiplier,u=p/(n-d)*-(d-A));if(q&&(y+=c*a.settings_multiplier,w=y/
        (k-f)*-(f-z),null!=a.secondCon)){if(void 0==v||isNaN(v))v=0;v+=I/k*a.settings_multiplier*c}D();!1==q&&(R=!0);!1==t&&(Q=!0);if(0!=m&&!1==Q)if(!1==is_ie8())e.stopPropagation(),e.preventDefault();else return!1;if(0!=c&&!1==R)if(!1==is_ie8())e.stopPropagation(),e.preventDefault();else return!1}function D(){t&&(0<p&&(p=0),p<-(n-d)&&(p=-(n-d)),0>u&&(u=0,Q=!0),u>d-A&&(u=d-A,Q=!0),l&&("on"!=a.settings_smoothing?(b.hasClass("easing"),g.css({top:p}),l.css({top:u}),"on"==a.scrollBg&&b.css("background-position",
        "center "+p+"px")):(g.animate({top:p},{queue:!1,duration:W}),l.animate({top:u},{queue:!1,duration:W}))));h&&q&&(0<y&&(y=0),y<-(k-f)&&(y=-(k-f)),null!=a.secondCon&&(0<v&&(v=0),v<-(I-F)&&(v=-(I-F))),0>w&&(w=0,R=!0),w>f-z&&(w=f-z,R=!0),"on"!=a.settings_smoothing?(g.css({left:y}),h.css({left:w}),null!=a.secondCon&&a.secondCon.css({left:v})):(g.animate({left:y},{queue:!1,duration:W}),h.animate({left:w},{queue:!1,duration:W})))}function qa(){var a=b.width()-g.width(),c=g.position().left,h=b.height()-g.height(),
        k=g.position().top;w=c/a*(f-z);u=k/h*(d-z);D()}var f=0,d=0,k=0,n=0,S=0,T=0,g,x,c=0,m=0,u=0,w=0,l=void 0,E=void 0,h=void 0,B=void 0,b=C(this),H=0,G=0,U=!1,V=!1,A=0,z=0,Z=0,y=0,p=0,F,I,v,aa,R=!1,Q=!1,q=!0,t=!0,P=0,W=60,N,J=0,L=0,K=0,M=0,ba=0,ca=0,r=0,s=0,da,ea,fa,ga,Y=!1;if("on"==a.isbody&&(a.settings_refreshonresize="on",b.wrapInner('<div class="inner"></div>'),b.addClass("scroller-con"),is_ios()))return;g=b.find(".inner");b.addClass(a.settings_skin);is_ios()&&"off"==a.settings_disableSpecialIosFeatures?
        b.css("overflow","auto"):g.wrap('<div class="scroller"></div>');b.find(".scroller");"auto"==a.responsive_div&&(a.responsive_div=b.parent());f=void 0==a.totalWidth?b.width():a.totalWidth;d=void 0==a.totalHeight?b.height():a.totalHeight;aa=b;aa.append('<div class="scrollbar"></div>');x=aa.children(".scrollbar").eq(0);(is_ios()||is_android())&&x.addClass("easing");O();0==b.css("opacity")&&(b.animate({opacity:1},600),b.parent().children(".preloader").fadeOut("slow"));0==P&&(P=k+50);!0==is_ios()&&"off"==
        a.settings_disableSpecialIosFeatures&&(b.css({overflow:"auto"}),g.css({width:P}));void 0!=b.get(0)&&(b.get(0).reinit=$,b.get(0).scrollToTop=oa,b.get(0).updateX=ha,b.get(0).fn_scrolly_to=na);0<a.settings_refresh&&setInterval($,a.settings_refresh);"0"==b.find(".scrollbar").css("opacity")&&b.find(".scrollbar").animate({opacity:1},600);jQuery(window).bind("resize",O);O();setTimeout(O,1E3);C.fn.scroller.reinit=function(){$()};"on"==a.settings_scrollbyhover||!1!=is_ios()&&"on"!=a.settings_disableSpecialIosFeatures||
        !b[0].addEventListener||b[0].addEventListener("DOMMouseScroll",ka,!1);b[0].onmousewheel=ka;if(!1==is_ios()||"on"==a.settings_disableSpecialIosFeatures)jQuery(document).mousemove(function(c){H=c.pageX-b.offset().left;G=c.pageY-b.offset().top;"on"==a.settings_scrollbyhover&&(0>H||0>G||H>f+20||G>d+20)||(!0!=t||!0!=U&&"on"!=a.settings_scrollbyhover||(x.addClass("dragging"),"normal"==a.settings_dragmethod&&(u=G/d*(d-A),p=G/d*(d-n)),"drag"==a.settings_dragmethod&&(u=0+(G-0)-Z,p=u/-(d-A)*(n-d)),p=parseInt(p,
        10),D()),!0!=q||!0!=V&&"on"!=a.settings_scrollbyhover||(x.addClass("dragging"),"normal"==a.settings_dragmethod&&(w=H/f*(f-z),y=H/f*(f-k),null!=a.secondCon&&(v=H/F*(F-I))),"drag"==a.settings_dragmethod&&(w=0+(H-0)-0,y=w/-(f-z)*(k-f),null!=a.secondCon&&(v=w/-(F-z)*(I-F))),D()),"on"==a.settings_fadeoutonleave&&(l.animate({opacity:1},{queue:!1,duration:500}),E.animate({opacity:1},{queue:!1,duration:500})))}),g.bind("touchstart",X),g.bind("touchmove",la),g.bind("touchend",ma);!1!=is_ios()&&"on"!=a.settings_disableSpecialIosFeatures||
    jQuery(document).mouseup(function(a){V=U=!1;x.removeClass("dragging")});"on"!=a.settings_fadeoutonleave||!1!=is_ios()&&"on"!=a.settings_disableSpecialIosFeatures||b.mouseleave(function(a){l.animate({opacity:0},{queue:!1,duration:500});E.animate({opacity:0},{queue:!1,duration:500})});!0==is_ios()&&"off"==a.settings_disableSpecialIosFeatures&&setInterval(qa,70);return this})};window.dzsscr_init=function(a,X){C(a).scroller(X)}})(jQuery);
function is_ios(){return-1!=navigator.platform.indexOf("iPhone")||-1!=navigator.platform.indexOf("iPod")||-1!=navigator.platform.indexOf("iPad")}function is_android(){return-1!=navigator.platform.indexOf("Android")}function is_ie(){return-1!=navigator.appVersion.indexOf("MSIE")?!0:!1}function is_firefox(){return-1!=navigator.userAgent.indexOf("Firefox")?!0:!1}function is_opera(){return-1!=navigator.userAgent.indexOf("Opera")?!0:!1}
function is_chrome(){return-1<navigator.userAgent.toLowerCase().indexOf("chrome")}function is_safari(){return-1<navigator.userAgent.toLowerCase().indexOf("safari")}function version_ie(){return parseFloat(navigator.appVersion.split("MSIE")[1])}function version_firefox(){if(/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent))return new Number(RegExp.$1)}function version_opera(){if(/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent))return new Number(RegExp.$1)}
function is_ie8(){return is_ie()&&9>version_ie()?!0:!1}function is_ie9(){return is_ie()&&9==version_ie()?!0:!1};