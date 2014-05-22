jQuery(document).ready(function ($) {
    "use strict";
    /*	Table OF Contents
	==========================
	0-prettyPhoto
	1-Navigation
	2-Calander
	3-Vegas Slider
	4-Jplayer
	5-Sliders
	6-Flicker
	7-Tweet
	8-Google Maps
	9-Gllery
	*/
	
	$('.more-events').click(
        function () {
         	$('.events_showcase').slideToggle(800);
			return false;
      });
	 $('.fancybox-media').fancybox({
    	openEffect  : 'none',
   		closeEffect : 'none',
    	helpers : {
      		media : {}
    	}
  	});
    /*============================
	1-Navigation
	============================*/
   $(document).on('click', '.yamm .dropdown-menu', function (e) {
        e.stopPropagation();
    });
	
	var $ww= $(window).width();
	$(window).on("resize", function () {
		$ww= $(window).width();
	})
	
    $('.menu-item-has-children.dropdown').click(
	  function (){
		  if($ww<=1000){
			  $(this).children('ul.dropdown-menu').slideToggle();
			  return false;
		  }
	  });

    /*============================
	3-Vegas Slider
	============================*/
	
	if($('.vegas-slides').length){
		var vegas_BG_imgs = [],
		$vegas_img = $('.vegas-slides li img'),
		vegas_slide_length= $('.vegas-slides li').length;
		
		for (var i=0; i < vegas_slide_length; i++) {
			var new_vegas_img = {};
			new_vegas_img['src'] = $vegas_img.eq(i).attr('src');
			new_vegas_img['fade'] =$vegas_img.eq(i).parent('li').attr('data-fade');
			vegas_BG_imgs.push(new_vegas_img);
			
		}
		$.vegas('slideshow', {
			backgrounds:vegas_BG_imgs,
		});
	}
	


    /*============================
	4-Jplayer
	============================*/

    $('#track_player').jPlayer({
        cssSelectorAncestor: "",
        swfPath: "assets/jPlayer/Jplayer.swf",
        supplied: "mp3",
    });

    $('.track_listen a').click(function (e) {
        e.preventDefault();
        if (!$(this).hasClass('currently_playing')) {
            $('#track_player').jPlayer('pause');
            $('.track_listen a').children('i').addClass('fa-play').removeClass('fa-pause');
            $(this).addClass('currently_playing');
            $('#track_player').jPlayer('setMedia', {
                mp3: $(this).attr('href'),
            }).jPlayer('play');
            $(this).children('i').removeClass('fa-play').addClass('fa-pause');
            console.log('test');
        } else if ($(this).hasClass('currently_playing')) {
            $(this).children('i').addClass('fa-play').removeClass('fa-pause');
            $('#track_player').jPlayer('pause');
            $('.track_listen a').removeClass('currently_playing');
        }
    });



    $("#player-instance").jPlayer({
        cssSelectorAncestor: "", // Remove the ancestor css selector clause
    });
	if($('.playlist-files').length){
		var playlist_items = [],
		$playlist_audio=$('.playlist-files li'),
		playlist_items_length= $playlist_audio.length;
		
		for (var i=0; i < playlist_items_length; i++) {
			var  new_playlist_item = {};
			new_playlist_item['title'] = $playlist_audio.eq(i).attr('data-title');
			new_playlist_item['artist'] = $playlist_audio.eq(i).attr('data-artist');
			new_playlist_item['mp3'] = $playlist_audio.eq(i).attr('data-mp3');
			playlist_items.push(new_playlist_item);
		}
	
		var werock = new jPlayerPlaylist({
			jPlayer: "#player-instance",
			cssSelectorAncestor: ""
		},playlist_items , {
			swfPath: "assets/jPlayer/Jplayer.swf",
			supplied: "mp3",
			displayTime: 'fast',
			addTime: 'fast',
		});
	
		$(".audio-track").mCustomScrollbar({
			advanced: {
				updateOnContentResize: true
			},
		});
		
		$('.audio-title').html(werock.playlist[0].title);
		$("#player-instance").bind($.jPlayer.event.play, function (event) {
			var current = werock.current,
				playlist = werock.playlist;
			jQuery.each(playlist, function (index, obj) {
				if (index == current) {
					$('.audio-title').html(obj.title);
				}
			});
		});
	}
	
    $('.jp-prev').click(function () {
        werock.previous();
        $(".audio-track").mCustomScrollbar("scrollTo", 'li.jp-playlist-current');
    });

    $('.jp-next').click(function () {
        werock.next();
        $(".audio-track").mCustomScrollbar("scrollTo", 'li.jp-playlist-current');
    });

    
    /*============================
	5-Sliders
	============================*/
	$('#flex-home').waitForImages({
		finished: function() {
			$('#flex-home').flexslider({
				animation: "slide",
				directionNav: false,
				controlNav: false,
				slideshowSpeed: 7000,
				slideshow: false,
				//smoothHeight: true,
				direction: "horizontal", //Direction of slides
				start: function(slider) {
					slider.removeClass('loading');
					$('.flex-viewport').height($('.slides li').height());			
					$('.slider-nav').show();
				}
			});
		}
	});
	$(window).on('resize', function(){
      $('.flex-viewport').height($('.slides li').height());	
	});

    var $flex_home = $('#flex-home');
    $('#home-next').click(function () {
        $flex_home.flexslider("next");
        return false;
    });
    $('#home-prev').click(function () {
        $flex_home.flexslider("prev");
        return false;
    });

    //code goes here
	$('.albums-carousel').waitForImages({
    	finished: function() {
			$('.album_preload').hide();
			$('.albums-carousel').carouFredSel({
				width: "100%",
				height: 300,
				circular: false,
				infinite: false,
				auto: false,
				scroll: {items: 1,easing: "linear"},
				prev: {button: "a.prev-album",key: "left"},
				next: {button: "a.next-album",key: "right"}
			});
		}
	});


    /*============================
	6-Flicker
	============================*/

	var $xv_flickr=$('#flicker-feed');
	if($xv_flickr.length){
		$xv_flickr.jflickrfeed({
			limit: $xv_flickr.attr('data-limit'),
			qstrings: {
				id: $xv_flickr.attr('data-flickerID'),
			},
			itemTemplate: '<li><a href="{{image_b}}" class="flickr_fancybox"  rel="flickr"><img alt="{{title}}" src="{{image_s}}" /></a></li>'
		}, function () {
			$("a.flickr_fancybox").fancybox();
		});
	}



    /*============================
	7-Tweet
	============================*/
	if($('.latest-tweet').length)
	{
		var $xv_tweet=$('.latest-tweet');
		$('.latest-tweet').tweetable({
			username: $xv_tweet.data('tweetname'),
			time: true,
			rotate: false,
			limit: 2,
			replies: false,
			position: 'append',
			loading: 'Loading Tweets...',
			failed: "Sorry, twitter is currently unavailable for this user.",
			html5: true,
			onComplete: function () {
				$("<span class='fa fa-twitter tweet-ico'></span>").insertBefore(".tweetList li p");
			}
		});
	}


    /*============================
	8-Google Maps
	============================*/

    if ($('#google-map').length) {

        var selector_map = 'google-map',
            mapAddress = $('#google-map').data('address'),
            mapType = $('#google-map').data('maptype'),
            zoomLvl = $('#google-map').data('zoomlvl'),
            map_theme_control = $('#google-map').data('theme'),
            map_theme;

        switch (map_theme_control) {
        case 'pink':
            map_theme = [{
                "stylers": [{
                    "hue": "#e62948"
                }, {
                    "visibility": "on"
                }, {
                    "invert_lightness": true
                }, {
                    "saturation": 40
                }, {
                    "lightness": 10
                }]
            }];

            break;
        case 'red':
            map_theme = [{
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffdfa6"
                }]
            }, {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#b52127"
                }]
            }, {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#c5531b"
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#74001b"
                }, {
                    "lightness": -10
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#da3c3c"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#74001b"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#da3c3c"
                }]
            }, {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#990c19"
                }]
            }, {
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#ffffff"
                }]
            }, {
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#74001b"
                }, {
                    "lightness": -8
                }]
            }, {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#6a0d10"
                }, {
                    "visibility": "on"
                }]
            }, {
                "featureType": "administrative",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffdfa6"
                }, {
                    "weight": 0.4
                }]
            }, {
                "featureType": "road.local",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "visibility": "off"
                }]
            }];

            break;
        case 'blue':
            map_theme = [{
                "stylers": [{
                    "hue": "#007fff"
                }, {
                    "saturation": 89
                }]
            }, {
                "featureType": "water",
                "stylers": [{
                    "color": "#ffffff"
                }]
            }, {
                "featureType": "administrative.country",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }];

            break;
        case 'yellow':
            map_theme = [{
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#a2daf2"
                }]
            }, {
                "featureType": "landscape.man_made",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f7f1df"
                }]
            }, {
                "featureType": "landscape.natural",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#d0e3b4"
                }]
            }, {
                "featureType": "landscape.natural.terrain",
                "elementType": "geometry",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#bde6ab"
                }]
            }, {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "poi.medical",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#fbd3da"
                }]
            }, {
                "featureType": "poi.business",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffe15f"
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#efd151"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                }]
            }, {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "black"
                }]
            }, {
                "featureType": "transit.station.airport",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#cfb2db"
                }]
            }];


            break;
        case 'green':
            map_theme = [{
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "visibility": "on"
                }, {
                    "color": "#aee2e0"
                }]
            }, {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#abce83"
                }]
            }, {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#769E72"
                }]
            }, {
                "featureType": "poi",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#7B8758"
                }]
            }, {
                "featureType": "poi",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#EBF4A4"
                }]
            }, {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "visibility": "simplified"
                }, {
                    "color": "#8dab68"
                }]
            }, {
                "featureType": "road",
                "elementType": "geometry.fill",
                "stylers": [{
                    "visibility": "simplified"
                }]
            }, {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#5B5B3F"
                }]
            }, {
                "featureType": "road",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#ABCE83"
                }]
            }, {
                "featureType": "road",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#A4C67D"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#9BBF72"
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#EBF4A4"
                }]
            }, {
                "featureType": "transit",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "visibility": "on"
                }, {
                    "color": "#87ae79"
                }]
            }, {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#7f2200"
                }, {
                    "visibility": "off"
                }]
            }, {
                "featureType": "administrative",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "color": "#ffffff"
                }, {
                    "visibility": "on"
                }, {
                    "weight": 4.1
                }]
            }, {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#495421"
                }]
            }, {
                "featureType": "administrative.neighborhood",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            }];

            break;
        default:
            map_theme = [];

        }

        contactemaps(selector_map, mapAddress, mapType, zoomLvl, map_theme);
    }


    function contactemaps(selector_map, address, type, zoom_lvl, map_theme) {
        var map = new google.maps.Map(document.getElementById(selector_map), {
            mapTypeId: google.maps.MapTypeId.type,
            scrollwheel: false,
            draggable: false,
            zoom: zoom_lvl,
            styles: map_theme,
        });
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
                'address': address
            },
            function (results, status) {
                if (status === google.maps.GeocoderStatus.OK) {
                    new google.maps.Marker({
                        position: results[0].geometry.location,
                        map: map,
                        /* icon: map_pin*/
                    });
                    map.setCenter(results[0].geometry.location);
                }
            });
    }


    /*===========================
	9-Gllery
	============================*/

	$('.photo-gallery').waitForImages({
    	finished: function() {
			var $containerfolio = $('.photo-gallery');
			if ($containerfolio.length) {
				$containerfolio.isotope({
					layoutMode: 'fitRows',
					filter: '*',
					animationOptions: {
						duration: 750,
						easing: 'linear',
						queue: false
					}
				});
			}
		
			$('.photo-filter li a').click(function () {
				$('.photo-filter li').removeClass("active");
				$(this).parent().addClass("active");
				var selector = $(this).attr('data-filter');
				$containerfolio.isotope({
					filter: selector,
					animationOptions: {
						duration: 750,
						easing: 'linear',
						queue: false
					}
				});
				return false;
			});
		}
	});
	
	/*============================
	10-Video Background
	============================*/
	
	if($(".video_BG_player").length){
		var onMobile = false;
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) { onMobile = true; }
		if( ( onMobile === false ) ) {
		
				$(".video_BG_player").mb_YTPlayer();
			
		} else {
			/* as a fallback we add a special class to the header which displays a poster image */ 
			$('#home').addClass('video-section');
			/* hide player */
			$(".player").hide();
			$("#video-volume").hide();
		}
	}


});