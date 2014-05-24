var dzsap_list = [];
var dzsap_ytapiloaded = false;
var dzsap_globalidind = 20;
(function($) {
    $.fn.audioplayer = function(o) {
        var defaults = {
            design_skin: 'skin-default'
            ,autoplay: 'off'
            ,swf_location: "ap.swf"//the location of the flash backup
            ,design_thumbh: "200"//thumbnail size
            ,design_thumbw: "200"
            ,disable_volume: 'off'
            ,disable_scrub: 'off'
            ,type: 'audio'
            ,soundcloud_apikey: ''

        }
        o = $.extend(defaults, o);
        this.each(function() {
            var cthis = $(this);
            var cchildren = cthis.children()
                ,cthisId = 'ap1'
                ;
            var currNr = -1;
            var busy = true;
            var i = 0;
            var ww
                , wh
                , tw
                , th
                ,cw //controls width
                ,ch //controls height
                ,sw = 0//scrubbar width
                ,sh
                ,spos = 0 //== scrubbar prog pos
                ;
            var _audioplayerInner
                ,_apControls
                ,_conControls
                ,_conPlayPause
                ,_controlsVolume
                ,_scrubbar
                ,_theMedia
                ,_cmedia
                ,_theThumbCon
                ,_metaArtistCon
                ;
            var busy = false
                ,playing = false
                ,muted = false
                ,loaded=false
                ;
            var time_total = 0
                ,time_curr=0
                ;
            var last_vol = 1
                ,last_vol_before_mute = 1
                ;
            var inter_check
                ,inter_checkReady
                ;
            var skin_minimal_canvasplay
                ,skin_minimal_canvaspause
                ;
            var is_flashplayer = false
                ;
            var data_source
                ;
            if(String(o.design_thumbh).indexOf('%')==-1){
                o.design_thumbh = parseInt(o.design_thumbh, 10);

            }
            if(String(o.design_thumbw).indexOf('%')==-1){
                o.design_thumbw = parseInt(o.design_thumbw, 10);

            }

            init();
            function init(){
                if(cthis.attr('class').indexOf("skin-")==-1){
                    cthis.addClass(o.design_skin);
                }
                if(cthis.hasClass('skin-default')){
                    o.design_skin = 'skin-default';
                }
                if(cthis.hasClass('skin-wave')){
                    o.design_skin = 'skin-wave';
                }
                if(cthis.hasClass('skin-minimal')){
                    o.design_skin = 'skin-minimal';
                    o.disable_volume='on';
                    o.disable_scrub='on';
                }
                if(cthis.attr('data-type')=='youtube'){
                    o.type='youtube';
                }
                if(cthis.attr('data-type')=='soundcloud'){
                    o.type='soundcloud';
                }

                //====we disable the function if audioplayer inited
                if(cthis.hasClass('audioplayer')){
                    return;
                }

                if(cthis.attr('id')!=undefined){
                    cthisId = cthis.attr('id');
                }else{
                    cthisId = 'ap' + dzsap_globalidind++;
                }

                cthis.removeClass('audioplayer-tobe');
                cthis.addClass('audioplayer');



                //console.log(cthis);

                //===ios does not support volume controls so just let it die
                if(is_ios()){
                    o.disable_volume='on';
                    o.autoplay = 'off';
                }

                if(o.type=='youtube'){
                    if(dzsap_ytapiloaded==false){
                        var tag = document.createElement('script');

                        tag.src = "https://www.youtube.com/iframe_api";
                        var firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                        dzsap_ytapiloaded = true;
                    }
                }
                data_source = cthis.attr('data-source');

                setup_structure();


                //====sound cloud INTEGRATION //
                if(cthis.attr('data-source').indexOf('https://soundcloud.com/')>-1){
                    o.type='soundcloud';
                }
                if(o.type=='soundcloud'){
                    if(o.soundcloud_apikey==''){
                        alert('soundcloud api key not defined, read docs!');
                    }
                    var aux = 'http://api.' + 'soundcloud.com' + '/resolve?url='+data_source+'&format=json&consumer_key=' + o.soundcloud_apikey;
                    $.getJSON(aux, function(data) {
                        //console.log(data, data.waveform_url);
                        o.type='audio';
                        cthis.attr('data-source', data.stream_url + '?consumer_key='+ o.soundcloud_apikey);
                        setup_media();
                        init_loaded();

                        if(o.design_skin=='skin-wave' && cthis.attr('data-scrubbg')==undefined){

                            cthis.attr('data-scrubbg', data.waveform_url);
                            cthis.attr('data-scrubprog', data.waveform_url);
                            _scrubbar.find('.scrub-bg').eq(0).append('<div class="scrub-bg-div"></div>');
                            _scrubbar.find('.scrub-bg').eq(0).append('<img src="'+cthis.attr('data-scrubbg')+'" class="scrub-bg-img"/>');
                            _scrubbar.children('.scrub-prog').eq(0).append('<div class="scrub-prog-div"></div>');

                            _scrubbar.find('.scrub-bg').css({
                                'height' : '100%'
                                ,'top' : 0
                            })
                        }
                    });
                    return;
                }
                //====END sound cloud INTEGRATION//

                setup_media();


                if(o.type=='youtube'){
                    dzsap_list.push(cthis);
                    _theMedia.append('<div id="ytplayer_'+cthisId+'"></div>');
                    cthis.get(0).fn_yt_ready = check_yt_ready;
                }

                //console.log(is_flashplayer)
                if(o.type=='audio'){


                    img = document.createElement('img');
                    img.onerror = function(){

                        if(cthis.children('.meta-artist').length>0){
                            _audioplayerInner.children('.meta-artist').html('audio not found...');
                        }else{
                            _audioplayerInner.append('<div class="meta-artist">audio not found...</div>');
                            _audioplayerInner.children('.meta-artist').eq(0).wrap('<div class="meta-artist-con"></div>');
                        }
                    };
                    img.src= cthis.attr('data-source');

                    if(is_ios() || is_ie8() || is_flashplayer==true){
                        setTimeout(init_loaded, 1000);
                    }else{
                        inter_checkReady = setInterval(check_ready, 50);
                    }
                }
            }

            function formatTime(arg) {
                //formats the time
                var s = Math.round(arg);
                var m = 0;
                if (s > 0) {
                    while (s > 59) {
                        m++;
                        s -= 60;
                    }
                    return String((m < 10 ? "0" : "") + m + ":" + (s < 10 ? "0" : "") + s);
                } else {
                    return "00:00";
                }
            }
            function check_yt_ready(){
                if(loaded==true){
                    return;
                }
                //console.log('ceva');
                //var player;
                _cmedia = new YT.Player('ytplayer_'+cthisId+'', {
                    height: '200',
                    width: '200',
                    videoId: cthis.attr('data-source'),
                    playerVars: { origin: ''},
                    events: {
                        'onReady': check_yt_ready_phase_two,
                        'onStateChange': change_yt_state
                    }
                });
                //init_loaded();
            }
            function check_yt_ready_phase_two(arg){

                //console.log(arg);
                init_loaded();
            }
            function change_yt_state(arg){
                //console.log(arg);
            }
            function check_ready(){
                //console.log(_cmedia);
                //=== do a little ready checking
                //console.log(_cmedia.readyState);
                if(o.type=='youtube'){

                }else{
                    if(_cmedia.nodeName!="AUDIO"){
                        init_loaded();
                    }else{
                        if(_cmedia.readyState>=2){
                            init_loaded();
                        }
                    }
                }
            }
            function setup_structure(){
                //alert('ceva');
                cthis.append('<div class="audioplayer-inner"></div>');
                _audioplayerInner = cthis.children('.audioplayer-inner');
                _audioplayerInner.append('<div class="the-media"></div>');
                _audioplayerInner.append('<div class="ap-controls"></div>');
                _theMedia = _audioplayerInner.children('.the-media').eq(0);
                _apControls = _audioplayerInner.children('.ap-controls').eq(0);
                _apControls.append('<div class="scrubbar"><div class="scrub-bg"></div><div class="scrub-buffer"></div><div class="scrub-prog"></div><div class="scrubBox"></div><div class="scrubBox-prog"></div><div class="scrubBox-hover"></div></div><div class="con-controls"><div class="the-bg"></div><div class="con-playpause"><div class="playbtn"><div class="play-icon"></div><div class="play-icon-hover"></div></div><div class="pausebtn" style="display:none"><div class="pause-icon"><div class="pause-part-1"></div><div class="pause-part-2"></div></div><div class="pause-icon-hover"></div></div></div></div>');
                _scrubbar = _apControls.children('.scrubbar');
                _conControls = _apControls.children('.con-controls');
                _conPlayPause = _conControls.children('.con-playpause').eq(0);
                _conControls.append('<div class="controls-volume"><div class="volumeicon"></div><div class="volume_static"></div><div class="volume_active"></div><div class="volume_cut"></div></div>');

                _controlsVolume = _conControls.children('.controls-volume');

                if(cthis.children('.meta-artist').length>0){
                    _audioplayerInner.append(cthis.children('.meta-artist'));
                }
                _audioplayerInner.children('.meta-artist').eq(0).wrap('<div class="meta-artist-con"></div>');
                _metaArtistCon = _audioplayerInner.children('.meta-artist-con').eq(0);

                var str_thumbh = "";
                if(o.design_thumbh!=''){
                    str_thumbh = ' height:'+o.design_thumbh+'px;';
                }
                if(cthis.attr('data-thumb')!=undefined && cthis.attr('data-thumb')!=''){
                    _audioplayerInner.prepend('<div class="the-thumb-con"><div class="the-thumb" style="'+str_thumbh+' background-image:url('+cthis.attr('data-thumb')+')"></div></div>');
                    _theThumbCon = _audioplayerInner.children('.the-thumb-con').eq(0);
                }

                if(o.disable_volume=='on'){
                    _controlsVolume.hide();
                }
                if(o.disable_scrub=='on'){
                    _scrubbar.hide();
                }

                if(o.design_skin=='skin-wave'){
                    //console.info((o.design_thumbw + 20));
                    _metaArtistCon.css({
                        'left' :  (o.design_thumbw + 80)
                    })
                    //console.info('url('+cthis.attr('data-scrubbg')+')');
                    if(cthis.attr('data-scrubbg')!=undefined){
                        _scrubbar.children('.scrub-bg').eq(0).append('<img class="scrub-bg-img" src="'+cthis.attr('data-scrubbg')+'"/>');
                    }
                    if(cthis.attr('data-scrubprog')!=undefined){
                        _scrubbar.children('.scrub-prog').eq(0).append('<img class="scrub-prog-img" src="'+cthis.attr('data-scrubprog')+'"/>');
                    }
                    _scrubbar.find('.scrub-bg-img').eq(0).css({
                        'width' : _scrubbar.children('.scrub-bg').width()
                    });
                    _scrubbar.find('.scrub-prog-img').eq(0).css({
                        'width' : _scrubbar.children('.scrub-bg').width()
                    });

                    _audioplayerInner.children('.the-thumb-con').css({
                        'height': o.design_thumbh
                    })
                    _apControls.css({
                        'height': o.design_thumbh
                    })
                }
                if(cthis.hasClass('skin-minimal')){
                    _conPlayPause.children('.playbtn').append('<canvas width="100" height="100" class="playbtn-canvas"/>');
                    skin_minimal_canvasplay = _conPlayPause.find('.playbtn-canvas').eq(0).get(0);
                    _conPlayPause.children('.pausebtn').append('<canvas width="100" height="100" class="pausebtn-canvas"/>');
                    skin_minimal_canvaspause = _conPlayPause.find('.pausebtn-canvas').eq(0).get(0);
                }
            }
            function setup_media(){

                if(o.type=='youtube'){

                    if(is_ie()){
                        _theMedia.css({
                            'left' : '-478em'
                        })
                    }
                    return;
                }
                var aux = '';
                aux+= '<audio>';
                if(cthis.attr('data-source')!=undefined){
                    aux+='<source src="'+cthis.attr('data-source')+'" type="audio/mpeg">';
                    if(cthis.attr('data-sourceogg')!=undefined){
                        aux+='<source src="'+cthis.attr('data-sourceogg')+'" type="audio/ogg">';
                    }
                }
                aux+= '</audio>';
                if((can_playmp3()==false && cthis.attr('data-sourceogg')==undefined) || is_ie8()){
                    aux='<object type="application/x-shockwave-flash" data="ap.swf" width="100" height="50" id="flashcontent_'+cthisId+'" allowscriptaccess="always" style="visibility: visible; "><param name="movie" value="ap.swf"><param name="menu" value="false"><param name="allowScriptAccess" value="always"><param name="scale" value="noscale"><param name="allowFullScreen" value="true"><param name="wmode" value="opaque"><param name="flashvars" value="media='+cthis.attr('data-source')+'&fvid='+cthisId+'">';
                    is_flashplayer = true;
                }
                //console.log(aux, _theMedia);
                _theMedia.append(aux);
                //_theMedia.children('audio').get(0).autoplay = false;
                _cmedia = (_theMedia.children('audio').get(0));
                if(is_flashplayer==true){
                    _cmedia = (_theMedia.children('object').get(0));

                    setTimeout(function(){
                        _cmedia = (_theMedia.children('object').get(0));
                    }, 500);
                }
                if(is_ie8()){
                    setTimeout(function(){
                        _cmedia = (_theMedia.children('object').get(0));
                    }, 500)
                }
                //alert(_cmedia);
            }
            function setup_listeners(){
                _scrubbar.bind('mousemove', mouse_scrubbar);
                _scrubbar.bind('mouseleave', mouse_scrubbar);
                _scrubbar.bind('click', mouse_scrubbar);


                _controlsVolume.children('.volumeicon').bind('click', click_mute);
                _controlsVolume.children('.volume_active').bind('click', mouse_volumebar);
                _controlsVolume.children('.volume_static').bind('click', mouse_volumebar);


                _conControls.find('.con-playpause').eq(0).bind('click', click_playpause);


                //console.log('ceva');
                $(window).bind('resize', handleResize);
                handleResize();


                requestAnimFrame(check_time);


                //cthis.get(0).fn_change_color_highlight = fn_change_color_highlight;
                cthis.get(0).fn_pause_media = pause_media;
                cthis.get(0).fn_play_media = play_media;
            }
            function check_time(){
                //console.log('check');
                if(o.type=='youtube'){
                    time_total = _cmedia.getDuration();
                    time_curr = _cmedia.getCurrentTime();
                }
                if(o.type=='audio'){
                    if(is_flashplayer==true){


                        eval("if(typeof _cmedia.fn_getSoundDuration"+cthisId+" != 'undefined'){time_total = parseFloat(_cmedia.fn_getSoundDuration"+cthisId+"())};");
                        eval("if(typeof _cmedia.fn_getSoundCurrTime"+cthisId+" != 'undefined'){time_curr = parseFloat(_cmedia.fn_getSoundCurrTime"+cthisId+"())};");

                        //console.log(_cmedia.fn_getSoundCurrTime());
                    }else{
                        time_total = _cmedia.duration;
                        time_curr = _cmedia.currentTime;

                    }
                }

                //if(cthis.hasClass("skin-minimal")){ console.log(time_curr, time_total) };

                spos = (time_curr / time_total) * sw;
                if(isNaN(spos)){
                    spos = 0;
                }
                if(spos>sw){
                    spos = sw;
                }

                //console.log(_scrubbar.children('.scrub-prog'), spos, time_total,time_curr, sw);
                _scrubbar.children('.scrub-prog').css({
                    'width' : spos
                })


                if(cthis.hasClass('skin-minimal')){
                    //console.log(skin_minimal_canvasplay);
                    //alert(can_canvas());

                    if(is_ie8() || !can_canvas() || is_opera()){
                        _conPlayPause.addClass('canvas-fallback');
                    }else{
                        var ctx = skin_minimal_canvasplay.getContext('2d');
                        //console.log(ctx);

                        var ctx_w = $(skin_minimal_canvasplay).width();
                        var ctx_h = $(skin_minimal_canvasplay).height();
                        var pw = ctx_w/100;
                        var ph = ctx_h/100;
                        spos = Math.PI*2 * (time_curr / time_total);
                        if(isNaN(spos)){
                            spos = 0;
                        }
                        if(spos>Math.PI*2){
                            spos = Math.PI*2;
                        }

                        ctx.clearRect(0,0,ctx_w, ctx_h);
                        //console.log(ctx_w, ctx_h);




                        var gradient = gradient = ctx.createLinearGradient(0, 0, 0, ctx_h);
                        gradient.addColorStop("0", "#ea8c52");
                        gradient.addColorStop("1.0", "#cb7641");


                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(40*pw),0,Math.PI*2,false);
                        ctx.fillStyle = "rgba(0,0,0,0.1)";
                        ctx.fill();



                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(30*pw),0,Math.PI*2,false);
                        //ctx.moveTo(110,75);
                        ctx.fillStyle = gradient;

                        ctx.fill();

                        //console.log(spos);
                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(34*pw),0,spos,false);
                        //ctx.fillStyle = "rgba(0,0,0,0.3)";
                        ctx.lineWidth=(10*pw);
                        ctx.strokeStyle = 'rgba(0,0,0,0.3)';
                        ctx.stroke();



                        ctx.beginPath();
                        ctx.strokeStyle = "red";

                        //==draw the triangle
                        ctx.moveTo((44*pw),(40*pw));
                        ctx.lineTo((57*pw),(50*pw));
                        ctx.lineTo((44*pw),(60*pw));
                        ctx.lineTo((44*pw),(40*pw));
                        ctx.fillStyle="#ddd";
                        ctx.fill();


                        ctx = skin_minimal_canvaspause.getContext('2d');
                        //console.log(ctx);

                        ctx_w = $(skin_minimal_canvaspause).width();
                        ctx_h = $(skin_minimal_canvaspause).height();
                        pw = ctx_w/100;
                        ph = ctx_h/100;

                        ctx.clearRect(0,0,ctx_w, ctx_h);
                        //console.log(ctx_w, ctx_h);

                        //console.log((time_curr / time_total));

                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(40*pw),0,Math.PI*2,false);
                        ctx.fillStyle = "rgba(0,0,0,0.1)";
                        ctx.fill();



                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(30*pw),0,Math.PI*2,false);
                        //ctx.moveTo(110,75);
                        ctx.fillStyle = gradient;

                        ctx.fill();

                        //console.log(spos);
                        ctx.beginPath();
                        ctx.arc((50*pw),(50*ph),(34*pw),0,spos,false);
                        //ctx.fillStyle = "rgba(0,0,0,0.3)";
                        ctx.lineWidth=(10*pw);
                        ctx.strokeStyle = 'rgba(0,0,0,0.35)';
                        ctx.stroke();

                        ctx.fillStyle="#ddd";
                        ctx.fillRect((43*pw),(40*pw),(6*pw),(20*pw));
                        ctx.fillRect((53*pw),(40*pw),(6*pw),(20*pw));
                    }
                    //console.log('ceva');
                }

                //console.log(time_curr, time_total);
                if(time_total>0 && time_curr >= time_total - 0.07){
                    seek_to(0); pause_media();
                }



                if(is_flashplayer==true || o.type=='youtube'){
                    inter_check = setTimeout(check_time, 500);
                }else{
                    requestAnimFrame(check_time);
                }

            }
            function click_playpause(e){
                var _t = jQuery(this);
                //console.log(_t);


                if(o.design_skin == 'skin-minimal'){

                    var center_x = _t.offset().left + 50;
                    var center_y = _t.offset().top + 50;
                    var mouse_x = e.pageX;
                    var mouse_y = e.pageY;
                    var pzero_x = center_x + 50;
                    var pzero_y = center_y;

                    //var angle = Math.acos(mouse_x - center_x);

                    //console.log(pzero_x, pzero_y, mouse_x, mouse_y, center_x, center_y, mouse_x - center_x, angle);

                    //A = center, B = mousex, C=pointzero

                    var AB = Math.sqrt(Math.pow((mouse_x - center_x),2) + Math.pow((mouse_y - center_y),2));
                    var AC = Math.sqrt(Math.pow((pzero_x - center_x),2) + Math.pow((pzero_y - center_y),2));
                    var BC = Math.sqrt(Math.pow((pzero_x - mouse_x),2) + Math.pow((pzero_y - mouse_y),2));


                    var angle = Math.acos((AB + AC + BC)/(2*AC*AB));
                    var angle2 = Math.acos((mouse_x - center_x)/50);

                    //console.info(AB, AC, BC, angle, (mouse_x - center_x), angle2, Math.PI);

                    var perc = -(mouse_x - center_x - 50) * 0.005;//angle2 / Math.PI / 2;


                    if(mouse_y < center_y){
                        perc = 0.5 + (0.5 - perc)
                    }

                    if( !(is_flashplayer==true && is_firefox()) && AB > 20){
                        seek_to_perc(perc);
                        return;
                    }
                }



                //unghi = acos (x - centruX) = asin(centruY - y)


                if(playing==false){
                    play_media();
                }else{
                    pause_media();
                }

            }
            function init_loaded(){

                if(is_flashplayer==false){
                    totalDuration = _cmedia.duration;
                }else{

                    if(_cmedia.fn_getSoundDuration){
                        eval("totalDuration = parseFloat(_cmedia.fn_getSoundDuration"+cthisId+"())");
                    }
                }


                clearTimeout(inter_checkReady);
                setup_listeners();

                if(is_ie8()){
                    cthis.addClass('lte-ie8')
                }
                if(is_ie8()==false && o.autoplay=='on'){
                    play_media();
                };

                //===ie7 and ie8 does not have the indexOf property so let us add it
                if(is_ie8()){
                    if (!Array.prototype.indexOf)
                    {
                        Array.prototype.indexOf = function(elt)
                        {
                            var len = this.length >>> 0;

                            var from = Number(arguments[1]) || 0;
                            from = (from < 0)
                                ? Math.ceil(from)
                                : Math.floor(from);
                            if (from < 0)
                                from += len;

                            for (; from < len; from++)
                            {
                                if (from in this &&
                                    this[from] === elt)
                                    return from;
                            }
                            return -1;
                        };
                    }
                }
                if(dzsap_list.indexOf(cthis)==-1){
                    dzsap_list.push(cthis);
                }
                loaded=true;
            }
            function resize_player(){
                tw = cthis.width();
                th = cthis.height();


            }
            function handleResize() {
                ww = $(window).width();
                tw = cthis.width();
                if(o.design_skin=='skin-default'){
                    sw = tw;
                }
                if(o.design_skin=='skin-wave'){
                    sw = _scrubbar.outerWidth(false);
                }
                check_time();


                _scrubbar.find('.scrub-bg-img').eq(0).css({
                    'width' : _scrubbar.children('.scrub-bg').width()
                });
                _scrubbar.find('.scrub-prog-img').eq(0).css({
                    'width' : _scrubbar.children('.scrub-bg').width()
                });
            }
            function mouse_volumebar(e){
                var _t = jQuery(this);
                if(e.type=='mousemove'){

                }
                if(e.type=='mouseleave'){

                }
                if(e.type=='click'){

                    //console.log(_t, _t.offset().left)

                    aux = (e.pageX - (_controlsVolume.children('.volume_static').offset().left)) / (_controlsVolume.children('.volume_static').width());

                    set_volume(aux);
                    muted=false;
                }

            }
            function mouse_scrubbar(e){
                var mousex = e.pageX;
                if(e.type=='mousemove'){
                    _scrubbar.children('.scrubBox-hover').css({
                        'left' : (mousex - _scrubbar.offset().left)
                    })
                }
                if(e.type=='mouseleave'){

                }
                if(e.type=='click'){



                    var aux = ((e.pageX - (_scrubbar.offset().left)) / (sw) * time_total);
                    if(is_flashplayer==true){
                        aux = (e.pageX - (_scrubbar.offset().left)) / (sw);
                    }
                    seek_to(aux);
                }

            }
            function seek_to_perc(argperc){
                seek_to((argperc * time_total));
            }
            function seek_to(arg){
                //console.log(arg);

                if(o.type=='youtube'){
                    _cmedia.seekTo(arg);
                }
                if(o.type=='audio'){
                    if(is_flashplayer==true){

                        eval("_cmedia.fn_seek_to"+cthisId+"("+arg+")");
                        play_media();
                    }else{
                        _cmedia.currentTime = arg;
                    }
                }


            }
            function set_volume(arg){
                //=== outputs a volume from 0 to 1
                if(o.type=='youtube'){
                    _cmedia.setVolume(arg*100);
                }
                if(o.type=='audio'){
                    if(is_flashplayer==true){


                        eval("_cmedia.fn_volumeSet"+cthisId+"(arg)");
                        //play_cmedia();
                    }else{
                        _cmedia.volume = arg;
                    }
                }

                //console.log(_controlsVolume.children('.volume_active'));
                _controlsVolume.children('.volume_active').css({
                    'width':(_controlsVolume.children('.volume_static').width() * arg)
                });

                last_vol = arg;
            }
            function click_mute(){
                if(muted==false){
                    last_vol_before_mute = last_vol;
                    set_volume(0);
                    muted=true;
                }else{
                    set_volume(last_vol_before_mute);
                    muted=false;
                }
            }
            function pause_media(){

                _conPlayPause.children('.playbtn').css({
                    'display' : 'block'
                });
                _conPlayPause.children('.pausebtn').css({
                    'display' : 'none'
                });


                if(o.type=='youtube'){
                    _cmedia.pauseVideo();
                }
                if(o.type=='audio'){
                    if(is_flashplayer==true){
                        eval("_cmedia.fn_pauseMedia"+cthisId+"()");
                    }else{
                        if(_cmedia){
                            if(_cmedia.pause!=undefined){
                                _cmedia.pause();
                            }
                        }
                    }
                }

                playing=false;

            }
            function play_media(){
                //console.log()

                for(i=0;i<dzsap_list.length;i++){
                    if(!is_ie8() && dzsap_list[i].get(0)!=undefined && dzsap_list[i].get(0).fn_pause_media!=undefined){
                        dzsap_list[i].get(0).fn_pause_media();
                    }
                }

                _conPlayPause.children('.playbtn').css({
                    'display' : 'none'
                });
                _conPlayPause.children('.pausebtn').css({
                    'display' : 'block'
                });
                //===media functions

                if(o.type=='youtube'){
                    _cmedia.playVideo();
                }
                if(o.type=='audio'){
                    if(is_flashplayer==true){
                        eval("_cmedia.fn_playMedia"+cthisId+"()");
                    }else{
                        if(_cmedia){
                            if(_cmedia.play!=undefined){
                                _cmedia.play();
                            }
                        }
                    }
                }

                playing=true;
            }
            return this;
        })
    }

    window.dzsap_init = function(selector, settings) {
        $(selector).audioplayer(settings);
    };

})(jQuery);



function is_ios() {
    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1)
        );
}

function is_android() {
    //return true;
    var ua = navigator.userAgent.toLowerCase();
    return (ua.indexOf("android") > -1);
}

function is_ie() {
    if (navigator.appVersion.indexOf("MSIE") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_firefox() {
    if (navigator.userAgent.indexOf("Firefox") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_opera() {
    if (navigator.userAgent.indexOf("Opera") != -1) {
        return true;
    }
    ;
    return false;
}
;
function is_chrome() {
    return navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
}
;
function is_safari() {
    return navigator.userAgent.toLowerCase().indexOf('safari') > -1;
}
;
function version_ie() {
    return parseFloat(navigator.appVersion.split("MSIE")[1]);
}
;
function version_firefox() {
    if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var aversion = new Number(RegExp.$1);
        return(aversion);
    }
    ;
}
;
function version_opera() {
    if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)) {
        var aversion = new Number(RegExp.$1);
        return(aversion);
    }
    ;
}
;
function is_ie8() {
    if (is_ie() && version_ie() < 9) {
        return true;
    }
    return false;
}
function is_ie9() {
    if (is_ie() && version_ie() == 9) {
        return true;
    }
    return false;
}
function can_playmp3(){
    var a = document.createElement('audio');
    return !!(a.canPlayType && a.canPlayType('audio/mpeg;').replace(/no/, ''));
}
function can_canvas(){
    // check if we have canvas support
    var oCanvas = document.createElement("canvas");
    if (oCanvas.getContext("2d")) {
        return true;
    }
    return false;
}
function onYouTubeIframeAPIReady() {


    for(i=0;i<dzsap_list.length;i++){
        //console.log(dzsap_list[i].get(0).fn_yt_ready);
        if(dzsap_list[i].get(0)!=undefined && typeof dzsap_list[i].get(0).fn_yt_ready!='undefined'){
            dzsap_list[i].get(0).fn_yt_ready();
        }
    }
}

window.requestAnimFrame = (function() {
    //console.log(callback);
    return window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        window.oRequestAnimationFrame ||
        window.msRequestAnimationFrame ||
        function(/* function */callback, /* DOMElement */element) {
            window.setTimeout(callback, 1000 / 60);
        };
})();