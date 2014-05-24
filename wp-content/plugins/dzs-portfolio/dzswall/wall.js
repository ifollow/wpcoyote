/*
 * Author: Digital Zoom Studio
 * Website: http://digitalzoomstudio.net/
 * This is not free software.
 * Wall v2.1
 */

var movement = 1;

var i_acc_x = 0;
var i_acc_y = 0;

var i_acc_mul = 5;
var i_max_x = 10;
var i_max_y = 10;
var use_accelerometer = false; 
var animation_time = 700;
(function($) {

	$.fn.wall = function(op) {

		var total_width = 0;
		var total_height = 0;
		var com_width = 0;
		var com_height = 0;
		var nr_lines = 1;
		var posx = 0;
		var posy = 0;
		var posxs=[];
		var posys=[];
		var cthis;
		var imgcon;
		var mousex = 0;
		var mousey = 0;
		var lastmousex = 0;
		var lastmousey = 0;
		var viewIndexX = 0;
		var viewIndexY = 0;
		var pagex = 0;
		var pagey = 0;
		var ref = this;
		var settings_error = 20;
		var rotation_max = 30;
		var rotation_div = 15;
		var rotation_busy=false;
		var movementX = false;
		var nr_children = 0;
		var find_wall_in = 0;
		var images = 0;
		var cacheobject;
		var cacheobject1;
		var auxa = 0;
		var auxb = 0;
		var aux = 0;
		var aux2 = 0;
		var aux3 = 0;
		var scale = 0;

		var html = jQuery('html');
		var defaults = {
			settings_thumbs_per_row : 5,
			settings_width : 0,
			settings_height : 0,
			settings_rotation : "off",
			thumb_width : 150,
			thumb_height : 200,
			thumb_space : 10,
			settings_padding : 20,
			settings_paddingv : 20,
			settings_paddingh : 20,
			description_height : 30,
			miscAction : 'off',
			settings_fullscreen : 'off'
		}, op = $.extend(defaults, op);

		this.each(function() {
			var categoryArray = [];
			var cpar = $(this).parent();
			var busy=false;
			var mul_cat='';
			var cacheobject
                ,_t
                ;
            var arr_cats = []
            ;
            var i
                ,j
                ,ik
            ;
			cthis = $(this);
			
			
			//cthis.wrapInner('<div class="wall-multiple-cats"></div>')

			jQuery('.preloader').fadeOut('slow');
			cthis.animate({
				'opacity' : 1
			}, 1200);

			cthis.append('<div class="wall-in"></div>')
			find_wall_in = cthis.find('.wall-in');

			op.thumb_width = parseInt(op.thumb_width, 10);
			op.thumb_height = parseInt(op.thumb_height, 10);
			op.thumb_space = parseInt(op.thumb_space, 10);
			op.settings_padding = parseInt(op.settings_padding, 10);
			op.settings_paddingh = parseInt(op.settings_paddingh, 10);
			op.settings_paddingv = parseInt(op.settings_paddingv, 10);

			for( i = 0; i < cthis.find('.wall-item').length; i++){
			    find_wall_in.append(cthis.find('.wall-item').eq(0))
			}
			
			imgcon = find_wall_in;
			images = find_wall_in.children();
            nr_children = images.length;

            //console.log(find_wall_in);
            var len = images.length;
			for( i = 0; i < len; i++) {
				cacheobject = images.eq(i);
                _t = images.eq(i);

				cacheobject.width(op.thumb_width)
				cacheobject.height(op.thumb_height)
				cacheobject.css({
					'left' : posx,
					'top' : posy
				})
				posxs.push(posx);
				posys.push(posy);

                var the_cats = _t.attr('data-category');
                if (the_cats != undefined && the_cats != '') {

                    the_cats = the_cats.split(';');
                    //console.log(the_cats);
                    for (ik = 0; ik < the_cats.length; ik++){
                        the_cat = the_cats[ik];
                        var the_cat_unsanatized = the_cats[ik];
                        if (the_cat != undefined) {
                            the_cat = the_cat.replace(' ', '-');
                            _t.addClass('cat-' + the_cat);

                        }
                        sw = false;
                        //console.log(the_cats, arr_cats, the_cat_unsanatized)
                        for (j = 0; j < arr_cats.length; j++) {
                            if (arr_cats[j] == the_cat_unsanatized) {
                                sw = true;
                            }
                        }
                        if (sw == false) {
                            arr_cats.push(the_cat_unsanatized);
                        }
                    }
                }

				if(cacheobject.attr("title") != "" && cacheobject.attr("title") != undefined) {
					cacheobject.wrap('<div class="description_con"></div>');
					//description-con
					cacheobject1 = imgcon.children().eq(i);
					cacheobject1.css({
						'left' : posx,
						'top' : posy,
						'width' : op.thumb_width,
						'height' : op.thumb_height
					})
					cacheobject.css({
						'left' : 0,
						'top' : 0
					})
					cacheobject1.append('<div class="description"><div class="description-text">' + cacheobject.attr("title") + '</div></div>');
					cacheobject1.find('.description').css('width', op.thumb_width);
					cacheobject1.find('.description').css({
						'top' : -op.description_height,
						'height' : op.description_height
					});
					cacheobject1.mouseover(function() {
						$(this).find('.description').animate({
							'top' : 0
						}, {
							queue : false,
							duration : 500
						})
					})
					cacheobject1.mouseout(function() {
						$(this).find('.description').animate({
							'top' : -op.description_height
						}, {
							duration : 300
						})
					})
				}
				posx += op.thumb_width + op.thumb_space;

				if((i + 1) % op.settings_thumbs_per_row == 0) {
					posy += op.thumb_height + op.thumb_space;
					posx = 0;
					nr_lines++;
				}
				if(!is_ie() || (is_ie() && version_ie()>8)){
					if(cacheobject.attr('data-category')==undefined){
						if(categoryArray.indexOf('default')==-1){
						categoryArray.push('default');
						}
					}else{
						if(categoryArray.indexOf(cacheobject.attr('data-category'))==-1){
						categoryArray.push(cacheobject.attr('data-category'));
						}
					}
				}
                /*
				*/
				
			}
            //console.info(cacheobject); return;



			if(posx == 0) {
				nr_lines--;
			}

			if(is_ios() == true) {
				cthis.css('overflow', 'auto');
				cthis.append('<div class="ios_notice-con" style="opacity:0;"><div class="ios_notice"><br/>USE 2 FINGERS TO SCROLL</div></div>');
				cthis.children('.ios_notice-con').animate({
					'opacity' : 0.7
				}, 2000).delay(1500).animate({
					'opacity' : 0
				}, 2000);
				setTimeout(function() {
					cthis.children('.ios_notice-con').remove();
				}, 6000);
			}
			aux3 = op.settings_thumbs_per_row;

			if(aux3 > nr_children){
				aux3 = nr_children;
			}
			com_width = aux3 * (op.thumb_width + op.thumb_space) - op.thumb_space;
            //console.log(aux3, com_width);

			com_height = nr_lines * (op.thumb_space + op.thumb_height) - op.thumb_space;
			total_width = cthis.width();
			if(is_chrome()==false && is_safari()==false && !(is_firefox() && version_firefox()>10)){
				op.settings_rotation = "off";
			}
			if(op.settings_rotation == "on") {
				imgcon.css('-webkit-transition', 'all 0.5s ease-out');
				imgcon.css('-webkit-perspective-origin', '50% 50%');
				imgcon.css('-moz-transition', 'all 0.5s ease-out');
				imgcon.css('-mozt-perspective-origin', '50% 50%');
				
				setInterval(function rotationUnbusy(){
					rotation_busy=false;
				}, 300)
			}
			if(categoryArray.length>1){
				init_multipleCategory()
			}
			
			cthis.bind('mousemove', handleMouse);
			jQuery(window).bind('resize', handleResize)

			setTimeout(test, 500)

            requestAnimFrame(handleFrame);
			
			return this;

			function handleMouse(e) {
				mousex = e.pageX - cthis.offset().left;
				mousey = e.pageY - cthis.offset().top;
			}
			
			function init_multipleCategory(){
				cpar.addClass('wall-multiple-cats');
				cpar.append('<div class="cat-selector"><div class="cat-button">all categories</div></div>');
                //console.info(categoryArray, arr_cats);
				for(i=0;i<arr_cats.length;i++){
					cpar.children('.cat-selector').append('<div class="cat-button">'+arr_cats[i]+'</div>');
				}
				cpar.children('.cat-selector').children().bind('click', catClick);
				function catClick(e){
					var $t = $(this);
					var ind = $t.parent().children().index($t);
					//console.log(ind);
					var j=0;
					
					for(i=0;i<images.length;i++){
							var _c = images.eq(i);
                            _c.animate({
									'opacity' : 1
								}, { queue:false, duration:animation_time })
						
					}
					if($t.text()=='all categories'){
						for(i=0;i<images.length;i++){
							var _c = images.eq(i);
                                _c.animate({
									'left' : posxs[j],
									'top' : posys[j]
								}, { queue:false, duration:animation_time })
								j++;
						}
					}
					var testtext = '';
					testtext = $t.text();
					if(testtext=='default') testtext = undefined;
					if($t.text()!='all categories'){
						for(i=0;i<images.length;i++){
							var _c = images.eq(i);
							if(_c.attr('data-category')!=testtext){
                                _c.animate({
									'opacity' : 0.2
								}, { queue:false, duration:animation_time })
							}else{
                                _c.animate({
									'left' : posxs[j],
									'top' : posys[j]
								}, { queue:false, duration:animation_time })
								j++;
							}
						}
						for(i=0;i<images.length;i++){
							var _c = images.eq(i);
							if(_c.attr('data-category')!=testtext){
                                _c.animate({
									'left' : posxs[j],
									'top' : posys[j]
								}, { queue:false, duration:animation_time })
								j++;
							}
						}
					}
					
				}
			}
		});
		// end each

		function handleResize() {//resize func
			if(is_ios() == true) {
				return;
			}
			total_width = cthis.width();
			total_height = cthis.height();

            //console.log(imgcon, total_width, com_width);

			imgcon.css({
				'width' : total_width,
				'height' : total_height
			})
			if(total_width < com_width) {
				movementX = true;
			} else {
				imgcon.css({
					'left' : total_width / 2 - com_width / 2
				})
				movementX = false;
			}
		}

		function handleFrame() {
			if(movement != 1)
				return;

			if(is_ios() == true && use_accelerometer == false) {
				return;
			}
			if(is_ios() != true || i_acc_x == 0) {
				viewIndexX = (mousex / total_width) * -(com_width - total_width + op.settings_paddingh * 2 + settings_error * 2) + op.settings_paddingh + settings_error;
			} else {
				viewIndexX += i_acc_x * i_acc_mul;
			}
			auxa = 0;
			auxb = 0;
            //console.log(total_width, com_width);
			
				//console.log(rotation_skip, rotation_skip_i)
            auxa = mousex - lastmousex;
            auxb = mousey - lastmousey;
            auxa*=2;
            auxb*=2;
			
			if(viewIndexX > op.settings_paddingh){
				viewIndexX = op.settings_paddingh;
            }
			if(viewIndexX < -(com_width - total_width + op.settings_paddingh))
				viewIndexX = -(com_width - total_width + op.settings_paddingh);

			if(total_width > com_width) {
				viewIndexX = total_width / 2 - com_width / 2;
				auxa = ((mousex - total_width / 2) / (total_width / 2) * rotation_max);
				
			}
			imgcon.css({
				'left' : viewIndexX
			});
			
			aux = cthis.css('left')
			aux.slice(0, aux.length - 2);
			aux = parseInt(aux);
			aux2 = (viewIndexX - aux);

			if(aux2 > -rotation_div && aux2 < rotation_div) {
				var rotateIndex = aux2 / rotation_div * rotation_max;
			}

			if(is_ios() != true || i_acc_y == 0) {
				viewIndexY = -(((mousey) / total_height * (com_height - total_height + op.settings_paddingv * 2 + settings_error * 2) - op.settings_paddingv - settings_error));
			} else {
				viewIndexY += i_acc_y * i_acc_mul;
			}

			if(viewIndexY > op.settings_paddingv)
				viewIndexY = op.settings_paddingv;

			if(viewIndexY < -(com_height - total_height + op.settings_paddingv))
				viewIndexY = -(com_height - total_height + op.settings_paddingv);

			if(total_height > com_height) {
				viewIndexY = total_height / 2 - com_height / 2;
				auxb = ((mousey - total_height / 2) / (total_height / 2) * rotation_max);
			}
			imgcon.css({
				'top' : viewIndexY
			})
			auxa /= rotation_div;
			auxb /= rotation_div;
			if(auxa > rotation_max) auxa=rotation_max;
			if(auxb > rotation_max) auxb=rotation_max;
			
			scale = Math.abs(scale);
			if(op.settings_rotation == "on") {
				if(rotation_busy==false){
				imgcon.css('-webkit-transform', 'perspective(1000px) rotateY('+auxa+'deg) rotateX('+auxb+'deg)');
				imgcon.css('-moz-transform', 'perspective(1000px) rotateY('+auxa+'deg) rotateX('+auxb+'deg)');
                imgcon.css('transform', 'perspective(1000px) rotateY('+auxa+'deg) rotateX('+auxb+'deg)');
				rotation_busy=true;
				}
			}
			lastmousex = mousex;
			lastmousey = mousey;

            requestAnimFrame(handleFrame);
		}

		function test() {
			handleResize();
		}

	}
})(jQuery);

window.ondevicemotion = function(event) {
	if(window.orientation == 90 || window.orientation == -90) {
		i_acc_x = event.accelerationIncludingGravity.y;
		i_acc_y = event.accelerationIncludingGravity.x;
	} else {
		i_acc_x = event.accelerationIncludingGravity.x;
		i_acc_y = event.accelerationIncludingGravity.y;
	}
}
function is_ios() {
	return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1)
	)
}

//if(conbusy==false){
//}

/*dev stuff

 var conbusy=false;
 setInterval(tester,5000);
 function tester(){
 conbusy=false;
 }

 */

(function($) {
	$.fn.wallmasonry = function(o) {

		var defaults = {
			innerWidth : 1980,
			columnWidth : 110,
			settings_padding : 20,
			settings_paddingh : 20,
			settings_paddingv : 20,
			calculate_portfolio_width : 'on'
		};
		var o = $.extend(defaults, o);

		this.each(function() {
			var cthis = jQuery(this);
			var cpar = cthis.parent();
			var outer;
			var inner;
			var total_width, total_height, com_width, com_height, mousex, mousey;
			var settings_error = 20;
			var categoryArray = [];
			var cpar = $(this).parent();
			var busy=false;
			var mul_cat='';
			var images;

			//sanitize the params...
			o.innerWidth = parseInt(o.innerWidth, 10);
			o.columnWidth = parseInt(o.columnWidth, 10);
			o.settings_padding = parseInt(o.settings_padding, 10);
			o.settings_paddingh = parseInt(o.settings_paddingh, 10);
			o.settings_paddingv = parseInt(o.settings_paddingv, 10);

			cthis.parent().children('.preloader').fadeOut('fast');
			if(cthis.css('opacity') == 0) {
				cthis.animate({
					'opacity' : 1
				}, 300)
			}

			if(o.calculate_portfolio_width == 'on') {
				$('.portfolio-main-img').each(function() {
					var $t = jQuery(this);
					if($t.parent().hasClass('portofolio-brick')) {
						$t.parent().css({
							'width' : $t.width() + 20
						})
					} else {
						$t.parent().parent().css({
							'width' : $t.width() + 20
						})
					}

				})
			}

			cthis.wrapInner('<div class="inner-con"></div>');
			inner = cthis.children('.inner-con');
			cthis.wrapInner('<div class="outer-con"></div>');
			outer = cthis.children('.outer-con');
			//console.log(inner);
			inner.css('width', o.innerWidth);

			inner.masonry({
				columnWidth : o.columnWidth
			});
			total_width = cthis.width();
			total_height = cthis.height();
			com_width = o.innerWidth;
			com_height = inner.height();

			if(is_ios() == true) {
				cthis.css('overflow', 'auto');
				inner.css('overflow', 'auto');
			}
			images = inner.children();
			
			for( i = 0; i < images.length; i++) {
				cacheobject = images.eq(i);
				if(cacheobject.attr('data-category')==undefined){
					if(categoryArray.indexOf('default')==-1){
					categoryArray.push('default');
					}
				}else{
					if(categoryArray.indexOf(cacheobject.attr('data-category'))==-1){
					categoryArray.push(cacheobject.attr('data-category'));
					}
				}
				cacheobject = images.eq(i);
			}


			if(categoryArray.length>1){
				init_multipleCategory()
			}


			cthis.mousemove(handleMouse)
			jQuery(window).resize(handleResize)

			setInterval(handleFrame, 30)


			
			function init_multipleCategory(){
				cpar.addClass('wall-multiple-cats');

				cpar.append('<div class="cat-selector"><div class="cat-button">all categories</div></div>');
				for(i=0;i<categoryArray.length;i++){
					cpar.children('.cat-selector').append('<div class="cat-button">'+categoryArray[i]+'</div>');
				}
				cpar.children('.cat-selector').children().bind('click', catClick);
				function catClick(e){
					var $t = $(this);
					var ind = $t.parent().children().index($t);
					//console.log(ind);
					var j=0;
					
					for(i=0;i<images.length;i++){
							var $c = images.eq(i);
								$c.animate({
									'opacity' : 1
								}, { queue:false, duration:animation_time })
						
					}
					if($t.text()=='all categories'){
						for(i=0;i<images.length;i++){
							var $c = images.eq(i);
								j++;
						}
					}
					var testtext = '';
					testtext = $t.text();
					if(testtext=='default') testtext = undefined;
					if($t.text()!='all categories'){
						for(i=0;i<images.length;i++){
							var $c = images.eq(i);
							if($c.attr('data-category')!=testtext){
								$c.animate({
									'opacity' : 0.2
								}, { queue:false, duration:animation_time })
							}else{
								j++;
							}
						}
						for(i=0;i<images.length;i++){
							var $c = images.eq(i);
							if($c.attr('data-category')!=testtext){
								j++;
							}
						}
					}
					
				}
			}


			function handleResize() {//resize func
				if(is_ios() == true) {
					return;
				}
				total_width = cthis.width();
				total_height = cthis.height();

				if(total_width < com_width) {
					movementX = true;
				} else {
					outer.css({
						'left' : total_width / 2 - com_width / 2
					})
					movementX = false;
				}
			}

			function handleFrame() {
				if(movement != 1)
					return;

				if(is_ios() == true && use_accelerometer == false) {
					return;
				}

				if(is_ios() != true || i_acc_x == 0) {
					viewIndexX = (mousex / total_width) * -(com_width - total_width + o.settings_paddingh * 2 + settings_error * 2) + o.settings_paddingh + settings_error;
				} else {
					viewIndexX += i_acc_x * i_acc_mul;
				}

				if(viewIndexX > o.settings_paddingh)
					viewIndexX = o.settings_paddingh;

				if(viewIndexX < -(com_width - total_width + o.settings_paddingh))
					viewIndexX = -(com_width - total_width + o.settings_paddingh);

				if(total_width < com_width) {
					outer.css({
						'left' : viewIndexX
					}, {
						duration : 120,
						queue : false
					})
					auxa = 0;
				} else {

					outer.css({
						'left' : o.settings_paddingh
					})
				}
				//console.log(viewIndexX);

				if(is_ios() != true || i_acc_y == 0) {
					viewIndexY = -(((mousey) / total_height * (com_height - total_height + o.settings_paddingv * 2 + settings_error * 2) - o.settings_paddingv - settings_error));
				} else {
					viewIndexY += i_acc_y * i_acc_mul;
				}

				if(viewIndexY > o.settings_paddingv)
					viewIndexY = o.settings_paddingv;

				if(viewIndexY < -(com_height - total_height + o.settings_paddingv))
					viewIndexY = -(com_height - total_height + o.settings_paddingv);

				if(total_height < com_height) {
					outer.css({
						'top' : viewIndexY
					}, {
						queue : false,
						duration : 3
					})
					if(o.settings_fullscreen == 'on'){
					jQuery('body').css('overflow', 'hidden')
					}
					auxb = 0;
				} else {
					outer.css({
						'top' : o.settings_paddingv
					})
				}
			}

			function handleMouse(e) {
				mousex = e.pageX - cthis.offset().left;
				mousey = e.pageY - cthis.offset().top;
			}
			
			
			

			return this;
		});
		//end each
	};
})(jQuery);


function is_ios() {
    return ((navigator.platform.indexOf("iPhone") != -1) || (navigator.platform.indexOf("iPod") != -1) || (navigator.platform.indexOf("iPad") != -1)
        );}; function is_android() {    return (navigator.platform.indexOf("Android") != -1);}; function is_ie(){
    if (navigator.appVersion.indexOf("MSIE") != -1){
        return true;
    };
    return false;
}; function is_firefox(){
    if (navigator.userAgent.indexOf("Firefox") != -1){
        return true;
    };
    return false;
}; function is_opera(){
    if (navigator.userAgent.indexOf("Opera") != -1){
        return true;
    };
    return false; }; function is_chrome(){    return navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
}; function is_safari(){
    return navigator.userAgent.toLowerCase().indexOf('safari') > -1;
}; function version_ie(){
    return parseFloat(navigator.appVersion.split("MSIE")[1]);
}; function version_firefox(){
    if (/Firefox[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
        var aversion=new Number(RegExp.$1);
        return(aversion);
    };
}; function version_opera(){
    if (/Opera[\/\s](\d+\.\d+)/.test(navigator.userAgent)){
        var aversion=new Number(RegExp.$1);
        return(aversion);     }; };


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