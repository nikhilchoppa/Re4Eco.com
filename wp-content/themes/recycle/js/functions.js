"use strict";

jQuery(function($) { 


if ($('body').hasClass('home', 'one-page')) {
	var onepageLinks = $('.site-header .nav-container a[href*="#"]:not([href="#"]):not([href*="="])');
	
	if ((onepageLinks).length > 1 ) {
        $('.nav-container a[href*="#"]:not([href="#"]):not([href*="="])').parent().removeClass("current_page_item");
	}
}

var isMobile = false;

var	screenLarge = 1200,
	screenMedium = 992,
	screenSmall = 768;


/* Check if on mobile */
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

/*-----------------------------------------------------------------------------------*/
// Passepartout	
/*-----------------------------------------------------------------------------------*/

// Create passepartout if needed
function recycle_passepartout_desktop() {
	if (!$('body').hasClass('passepartout-propagated')) {

		$('body').addClass('passepartout-propagated');

		var passepartoutHeight = $('body').data('passepartoutheight');
		var passepartoutWidth = $('body').data('passepartoutwidth');
		var passepartoutHex = $('body').data('passepartoutcolor');

		$('body').css ({ 
			'margin-left' : passepartoutWidth,
			'margin-right' : passepartoutWidth,
		});
		
		$('.site-footer').css ({
			'margin-bottom' : passepartoutHeight,
		});		

		/* create top and bottom passepartout */
		if (!$('.passepartout-top').length ) {
			$('body').prepend('<div class="passepartout passepartout-top visible-md visible-lg"></div>');
			$('body').append('<div class="passepartout passepartout-bottom visible-md visible-lg"></div>');
			$('body').append('<div class="passepartout passepartout-left visible-md visible-lg"></div>');
			$('body').append('<div class="passepartout passepartout-right visible-md visible-lg"></div>');

			$('body > .passepartout-top').css({
				'background-color' : passepartoutHex,
				'height' : passepartoutHeight
			})			
			$('body > .passepartout-bottom').css({
				'background-color' : passepartoutHex,
				'height' : passepartoutHeight
			})	
			$('body > .passepartout-left').css({
				'background-color' : passepartoutHex,
				'width' : passepartoutWidth
			})
			$('body > .passepartout-right').css({
				'background-color' : passepartoutHex,
				'width' : passepartoutWidth
			})									
		}
	}
}

function recycle_passepartout_mobile() {

	$('body').css({
		'margin-left': '0',
		'margin-right': '0',
	})

	$('body').removeClass('passepartout-propagated');
}

function  recycle_create_passepartout() {
	if ($('body').attr('data-passepartoutcolor')) {
		
		if ( $(window).width() > screenMedium ) {
			recycle_passepartout_desktop();
		} else {
			recycle_passepartout_mobile();
		}
	}
}

recycle_create_passepartout();

// passepartout resize function
if ( $('body').attr('data-passepartoutcolor') != 'undefined' ) {
	$( window ).resize(function() {
		recycle_create_passepartout();
	})		
}

/*-----------------------------------------------------------------------------------*/
// Redraw function:
/*-----------------------------------------------------------------------------------*/
$.fn.redraw = function(){
  $(this).each(function(){
    var redraw = this.offsetHeight;
  });
};
// use: $('.theElement').redraw();
/*-----------------------------------------------------------------------------------*/
// main navigation:
/*-----------------------------------------------------------------------------------*/

/*Toogle parrent (mobile navigation) */
$.fn.toggleparent = function(){
 	var element = $(this).parent('li');

 	if (element.hasClass('open')) {	
 		element.find('.togglecontainer').stop().slideUp('100');
		element.find('ul').stop().slideUp('300');
		element.removeClass('open');
		element.find('li').removeClass('open');
	}
	else {
		element.stop();
		element.parent('ul').stop().css('height', 'auto');
		element.children('ul').stop().css('height', 'auto');
		element.children('.togglecontainer').css('display', 'none');
		element.children('.togglecontainer').removeClass('hidden');

		element.children('ul, .togglecontainer').stop().slideDown('300');
		$(window).trigger('resize'); 
		element.addClass('open');
	}
}

/*prepare the main navigation*/
$('.main-nav-wrap .menu-item-has-children').each(function(){
	$('li > a',this).prepend('<span class="coll_btn desktoponly"><i class="eleganticons-arrow_right"></i></span>');
	$('> a, li > span',this).after('<span class="coll_btn notdesktop"><i class="fa fa-angle-down"></i></span>');
	$('> a, li > span',this).addClass('needs_coll_btn');
})
/* in case of mega menus delete those */
$('.orion-mega-menu span.coll_btn, .orion-megamenu .megamenu-sidebar .widget-area span.coll_btn').remove();
$('.orion-mega-menu .menu-item-has-children').each(function(){
	$('> a',this).removeClass('needs_coll_btn');
})
$('.megamenu-sidebar .needs_coll_btn').removeClass('needs_coll_btn');

/* add sub-mega-menu class to each sub-menu inside megamenu */
$('.orion-mega-menu .menu-item-has-children .sub-menu').each(function(){
	$(this).addClass('sub-mega-menu');
	$(this).removeClass('sub-menu');
})
$('.orion-mega-menu .menu-item-has-children').each(function(){
	$(this).addClass('menu-item-has-children-mega');
	$(this).removeClass('menu-item-has-children');
})
$('.nav-menu > .orion-megamenu').append('<span class="mega-indicator-wrap"></span>');
/*icon buttons action*/
$('.coll_btn').on('click', function(){
	if ($(window).width() < screenMedium ) {
		$(this).toggleparent();
	}
})

/*Toggle mobile navigation*/
$('.hamburger-box').on('click', function(){
	toggleMobileNav();
})

/* menu widget */
$('.widget_nav_menu .menu-item-has-children, .product-categories .cat-parent').each( function(){
	$('> a',this).after('<span class="coll_btn"><i class="fa fa-angle-down"></i></span>');
})

$('.megamenu-sidebar .widget-area .coll_btn').remove();
$('.widget_nav_menu .coll_btn').on('click', function(){
	$(this).toggleparent();
})
$('.widget_product_categories .coll_btn').on('click', function(){
	$(this).toggleparent();
})


/* top bar menu hover */

var menuHoverCount = 0;

$('.top-bar .widget_nav_menu li.menu-item-has-children > *').on('mouseenter', function(){
    if(!$(this).parent('.menu-item-has-children').hasClass('open')) {
    	$(this).toggleparent();
    	menuHoverCount++;    	
    }
}).mouseleave(function(){
    menuHoverCount--;
    if ($(this).hasClass('sub-menu')) {
    	menuHoverCount = 0;
    }
    if (!menuHoverCount) {
        $(this).toggleparent();
    }
});

/**
 * toggles mobile menu and renders it
 */
function toggleMobileNav() {

	var button = $('.hamburger-box'); 
	var nav_menu = $('header:not(.stickymenu) .nav-container');
	
	if ($('header .mobile-cart.open').length) {
		toggleMobileCart();
	}

	if (nav_menu.hasClass('open') ) {
		
		/* close the navigation */
		nav_menu.removeClass('open');
		button.removeClass('open');
		
		/*scroll to the top */
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, '400', 'swing', function() { 
		});

	} else {
		/* open the navigation */
		moveHeaderWidgets();
		nav_menu.addClass('open');
		button.addClass('open');
		
		/*scroll to the menu content */
		var $scrollValue = $('.hamburger-box').offset();
		var body = $("html, body");
		body.stop().animate({scrollTop:($scrollValue.top - 12)}, '700', 'swing', function() { 
		});
	}	
}

function moveHeaderWidgets() {
	if ($('.header-widgets').length &&  $('.header-widgets').children().length > 0 && !$('.site-header .mobile-widgets').length ) {
		$('.main-nav-wrap').append('<div class="mobile-widgets hidden-md hidden-lg"></div>');
		$('.header-widgets').clone().appendTo( ".main-nav-wrap .mobile-widgets" );
	}
} 

/*ensure that drop down menu does not go out of the screen (desktop)*/
function stay_on_screen() {
	$('.site-navigation .sub-menu .sub-menu').parent().hover(function() {
		if ($(this).hasClass('orion-megamenu-subitem')) {
			return;
		} else {
		    var menu = $(this).find("ul");
		    var menupos = $(menu).offset();
		    var siteWidth = $(window).width();
		    if ($('body').hasClass('boxed')) {
		    	siteWidth = $('.boxed-container').width() + $('.boxed-container').offset().left;
		    }
		    if (menupos.left + menu.width() > siteWidth) {

		        var newpos = -$(menu).width();
		        menu.css({ left: newpos });    
		    }
		}
	});
}

if ($(window).width() > (screenMedium  - 15)) {
	stay_on_screen();
}

/*-----------------------------------------------------------------------------------*/
// TOP BAR
/*-----------------------------------------------------------------------------------*/

if ($('.top-bar.collapsable').length) {
	$('.top-bar.collapsable').find('.top-bar-wrap.right').after('<div class="top-bar-toggle"> <span class="sow-icon-eleganticons" data-sow-icon="L"></span> </div>');
	$('.top-bar-toggle').on('click', function(){
		$(this).parents('.top-bar').toggleClass('on-screen');
	})
}

/*-----------------------------------------------------------------------------------*/
// Site search
/*-----------------------------------------------------------------------------------*/

$('.search-toggle .search-box, .site-search .search-toggle').on('click', function() {
    if (!$('search-opened').length) {
        $(window).scrollTop(0);
        $('.site-search-input').focus();
    }
    $('.search-box').toggleClass('open');
    $('body').toggleClass('search-opened');
});

/*-----------------------------------------------------------------------------------*/
/* Toggle megabar function */
/*-----------------------------------------------------------------------------------*/

$.fn.getSize = function() {    
    var $wrap = $("<div />").appendTo($("body"));
    $wrap.css({
        "position":   "absolute !important",
        "visibility": "hidden !important",
        "display":    "block !important",
        "max-height": "none",
    });

    var $clone = $(this).clone().appendTo($wrap);
    $(window).trigger('resize');
    var sizes = {
        "width": this.width(),
        "height": this.height()
    };

    $wrap.remove();

    return sizes;
};

$.fn.toggleWidgetContainer = function() {

	var el = $(this);
	var elWidget = $(this);
	var elBars = el.parents('.top-bar');
	var elTitle = el.find('> .widget-title');
	var elContainer = el.find('.togglecontainer');
	var elWrap = elContainer.find('div .panel-grid > div');
	
	// add distinguisable class, which we remove, when we are done
	elWidget.addClass('changeclass');

	/*  SIBLINGS  */
	// if any other widget title is active, hide it
	elBars.find('.so-widget-orion_mega_widget_topbar:not(".changeclass") > .widget-title').removeClass('active'); 

	// if any other container is active, hide it
	var siblingsContainer = $('.so-widget-orion_mega_widget_topbar:not(".changeclass")> .togglecontainer.visible', elBars);

	if (siblingsContainer.length) {
		siblingsContainer.addClass('fadeout');
		setTimeout(function() {
			siblingsContainer.removeClass('visible');
			siblingsContainer.removeClass('fadeout');
	    }, 500); 		
	}

// WIDGET
	//is it active?
	if (elTitle.hasClass('active')) {	

		/*hide it*/
		$('.closebar').addClass('evaporate');

		elTitle.removeClass('active');
	    elWrap.css("max-height", "0");

		/* timed visual effect:*/
		elContainer.addClass('remove-padding');
		setTimeout(function() {
			elContainer.removeClass('visible');
			elContainer.css("max-height", "0");
	    	elWrap.css("max-height", "0");
			$('.closebar').remove();
			elContainer.removeClass('remove-padding');

        }, 300); 

	} else {
		/*show*/
	    elTitle.addClass('active');
	    elContainer.addClass('visible'); 

	    /* this calculation works */
	    elWrap.css("max-height", "none");
       	var size = $('> div', elContainer).getSize();
		/* End calculation*/

       	siblingsContainer.find($('.closebar')).addClass('evaporate');
       
       	/* make it "visible" to calculate height */
		var height = size.height;

		/*prepare for transition*/
	    elContainer.css("max-height", "0");
	    elWrap.css("max-height", "0");

	    /*transition*/
		setTimeout(function() {
			elWrap.css("visibility", "visible");
	    	elWrap.css("max-height", height);
			elContainer.css('max-height', height);	

			/*force resize*/
			$(window).trigger('resize');				
        }, 100);   

		var closebtn ='<div class="closebar x-box xtoarrows no-opacy"><div class="relative-wrap"><span class="first triangle"></span><span class="triangle last"></span></div></div>';
		elContainer.append(closebtn);	
		setTimeout(function() {
			elContainer.children($('.closebar')).removeClass('no-opacy');
			$('.closebar.evaporate').remove();
		}, 100); 		
	}
	elWidget.removeClass('changeclass');
}

$('.orion-mega-menu.togglecontainer').parent('.menu-item').addClass('mega-menu-item');

function enableMegaMenu(el) {

	$(el).parent('.menu-item').on('mouseenter', function(){
		if($('.togglecontainer', this).hasClass('hidden') && $(window).width() > screenMedium) {
			$('.togglecontainer', this).removeClass('hidden');
			$(this).addClass('mega-active');
			$(window).trigger('resize');
		}
	})

	$(el).parent('.menu-item').on('mouseleave', function(){

		if(!$('.togglecontainer', this).hasClass('hidden') && $(window).width() > screenMedium) {
			$('.togglecontainer', this).addClass('hidden');
		}
		$(this).removeClass('mega-active');
	})	
}
enableMegaMenu('.orion-mega-menu.togglecontainer');

/*attach closebar click event to the document*/
$(document).on('click', '.closebar' , function() {
	var elwidget = $('.closebar').parents('.so-widget-orion_mega_widget_topbar');
		elwidget.toggleWidgetContainer();
		$(this).addClass('evaporate');	
});

$('.so-widget-orion_mega_widget_topbar > .widget-title').on('click', function() {
	var element = $(this);
	var elwidget = element.parents('.so-widget-orion_mega_widget_topbar');
	elwidget.toggleWidgetContainer();	
})

/*-----------------------------------------------------------------------------------*/
/* BG colors */
/*-----------------------------------------------------------------------------------*/
// If we want to display a diferent color on mobile, we can use this two classes.
//TODO: Exprimental feature, not used currently in production. 

function orionBgColors() {

	$('.section').each(function(){
	    $(this).css('background-color', $(this).attr('data-bgcolor'));
	});	

	if ($(window).width() < screenMedium) {
		$('.section[data-mobile-bgcolor]').each(function(){
			$(this).css('background-color', $(this).attr('data-mobile-bgcolor'));
		})
	}
}
orionBgColors();

/*-----------------------------------------------------------------------------------*/
/* sticky navigation */ 
/*-----------------------------------------------------------------------------------*/

// check if passpartout is set, so we can adjust the position:
if ($('body').data('passepartoutwidth')) {
	var passpartoutWidth = ($('body').data('passepartoutwidth'));
} else {
	var passpartoutWidth = '0';
}

//let's not forget about the logged in users:
if ($('body').hasClass('admin-bar')) {
	var AdminBarHeight = 32;
} else {
	var	AdminBarHeight = 0;
}
$('.stickymenu').css('top', AdminBarHeight );


function stickyAdjustWidth() {
	if ($('.stickymenu').length) {
		if($(window).width() < screenMedium ) { 
		} else {
			$('.stickymenu').css('width', '100%' );
			if ($('body').data('passepartoutwidth')) {
				var adjustWidth = '-=' + (2 * passpartoutWidth) + 'px';
				$('.stickymenu').css({
					'width' : adjustWidth 
				})		
			}			
		}
	}
}

/* if sticky menu is set, set sticky behaviour */
$( document ).on('ready', function() {
	if ($('.stickynav').length && typeof Waypoint == 'function') {
		var orionSticky = $('.stickynav');
		var stickyOffset = orionSticky.offset();
		var stickyHeight = orionSticky.height();

		// sticky menu Waypoints:
		var navWaypoint = new Waypoint({
		  	element: $('body'),
		  	handler: function(direction) {

		  		if($(window).width() < screenMedium ) { 
			    	
				    $('.stickymenu').addClass('hidesticky');
			    	$('.stickymenu').removeClass('stuck');		
			    	return; //don't run on mobile.    	
				}
			    if (direction == 'down') { 	
						$('.stickymenu').addClass('stuck');
						$('.stickymenu').removeClass('hidesticky');
						stickyAdjustWidth();
			    }
			},
		  	offset: -(stickyOffset.top  - (2*AdminBarHeight) + stickyHeight)
		})
		//remove sticky menu:
		var navWaypoint = new Waypoint({
		  	element: $('body'),
		  	handler: function(direction) {

		  		if($(window).width() < screenMedium ) { 
			    	return; //don't run on mobile.		    	
				}
			    if (direction == 'up') { 
			    	$('.stickymenu').addClass('hidesticky');
			    	$('.stickymenu').removeClass('stuck');
			    	$('.stickymenu .togglecontainer').addClass('hidden');
				}
			},
			/*sticky menu is 60px */
		  	offset: -(stickyOffset.top  - 2*AdminBarHeight - 60/2 + stickyHeight/2 )
		})
	}
})

/*-----------------------------------------------------------------------------------*/
/* END sticky navigation */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* next and previous post */ 
/*-----------------------------------------------------------------------------------*/

/**
* Set equal height of the previous and next post navigaton
*/
function setPostLinkHeight() {
	if ($('body').hasClass('single-post')) {
		var navheight = 0;
		$('.post-navigation > .wrapper a').each(function(){
			$('.post-navigation > .wrapper a').removeAttr( 'style' );
			if ($(this).height() > navheight) {
				navheight = $(this).height(); 			
			}
		});
		$('.post-navigation > .wrapper a').css('min-height', navheight + 64);
	}	
}

$(document).on('ready', setPostLinkHeight);

/*-----------------------------------------------------------------------------------*/
/* END next and previous post */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Equal height of columns in a row */ 
/*-----------------------------------------------------------------------------------*/

function equal_height() {
	$('.orion-equal-height').each(function(){
		var max_child_height = 0;
		var row = this;
		var row_height = 0;
		
		/*reset the height when screen is resized*/

		jQuery('> .panel-grid-cell .panel-widget-style, .equal-height-item', row).css("min-height", max_child_height);
	   	if (window.innerWidth >= screenMedium) { 
		    /*than we calculate the size*/
		    $(row).css({
	        	'min-height': '',
	        })
	        jQuery('> .panel-grid-cell, .equal-height-item', row).each(function() {
	        	jQuery(this).css({
	        		'min-height': ''
	        	})
	        	jQuery('> .panel-cell-style', this).css({
	        		'min-height': '',
	        	})

				if (jQuery(this).outerHeight() > max_child_height) {
				 	max_child_height = jQuery(this).outerHeight();
				}
	        })

	        jQuery('> .panel-grid-cell', row).each(function(){
	        	$(this).css({
	        	'min-height': max_child_height,
	        	'justify-content': 'center',
	        	'display': 'flex',
	        	'flex-direction': 'column'
	        	})
	        })
	        jQuery('> .panel-grid-cell > .panel-cell-style', row).each(function(){
	        	$(this).css({
	        		'min-height': max_child_height,
	        	})	        	
	        })
	        $(row).css({
	        		'min-height': max_child_height,
	        	})	 
	        // for other elements (not page builder rows)
	        jQuery('.equal-height-item', row).each(function(){
	        	jQuery(this).css("min-height", max_child_height);
	        })
    	}  else {
		    $(row).css({
	        	'min-height': '',
	        })
	        jQuery('> .panel-grid-cell', row).css({
	        		// 'display': 'block',
	        		'justify-content': '',
	        	})
	        jQuery('> .panel-grid-cell, .equal-height-item', row).each(function() {
	        	jQuery(this).css({
	        		'min-height': '',
	        	})
	        	jQuery('> .panel-cell-style', this).css({
	        		'min-height': ''
	        	})
	        })    		
    	}  	
	})
}
$(window).on('ready resize', equal_height );

/*-----------------------------------------------------------------------------------*/
/* END Equal height of columns in a row */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Full screen */ 
/*-----------------------------------------------------------------------------------*/

function setFullScreen() {

	/* modifications for first panel grid row on the page */
	var headerNotTransparentHeight = 0;
	var topBarheight = 0;
	var adminBarHeight = 0;

	if ($('.full-screen-row').parent('.panel-grid').is(':first-child')) {
		$('.full-screen-row').parent('.panel-grid').addClass('panel-grid-first-child');

		if($('.site-header:not(.header-transparent)').height) {
			headerNotTransparentHeight = $('.site-header:not(.header-transparent)').height();
		}
		if ($('.top-bar').height ){
			topBarheight = $('.top-bar').height();
		}
		if ( $('#wpadminbar').height) {
			adminBarHeight = $('#wpadminbar').height();
		}		
	}

	var fullScreenRow = $('.panel-grid:not(.panel-grid-first-child) .full-screen-row');
	var fullScreenFirstRow = $('.panel-grid.panel-grid-first-child .full-screen-row');

	
	if ($(window).width() > screenMedium ) {
		var windowHeight = $(window).height();
		var firstchildHeight = windowHeight - headerNotTransparentHeight - topBarheight - adminBarHeight;
		$(fullScreenFirstRow).stop().animate({
			'min-height': firstchildHeight,
		})
		$(fullScreenRow).stop().animate({
			'min-height': windowHeight,
		})
	} else {
		$(fullScreenRow).stop().css('min-height', '');
		$(fullScreenFirstRow).stop().css('min-height', '');
	}
}
$(window).on('ready resize', setFullScreen );

/*-----------------------------------------------------------------------------------*/
/* End Full screen */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Orion Features widget */ 
/*-----------------------------------------------------------------------------------*/

$('.widget_orion_features_w .feature-item-wrap:not(.no-toggle)').on('mouseenter', function(){

 $('.footer', this).stop().slideDown({
        duration: 100 ,
        easing: 'swing',
  }).addClass('visible');
})

$('.widget_orion_features_w .feature-item-wrap:not(.no-toggle)').on('mouseleave', function(){
if( $('body').width() > 997) {
	  $('.footer', this).stop().slideUp({
	        duration: 200 ,
	        easing: 'swing',
	  }).removeClass('visible');
  }
})

/*-----------------------------------------------------------------------------------*/
/* END Orion Features widget */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* OWL carusel 
/*-----------------------------------------------------------------------------------*/

$( document ).on('ready', function() {

	jQuery.each($('.owl-carousel'), function() {
		var owl = $(this);
		var childCount = $('.item', owl).length;
		
		var number_items = 1;
		var number_items_desktop = 4;

		var owlAutoplay = true;
		var number_items_tablet = 1;
		var dots = false;
		var margin = 0;
		var owlAutoheight = false;
		//dots
		if ( owl.attr('data-dots') == '1') {
			dots = true;
		}
		//autoplay
		if ( owl.attr('data-autoplay')) {
			var owlAutoplayAtt = (owl.attr('data-autoplay') == 'true' || owl.attr('data-autoplay') == '1');
			if (owlAutoplayAtt != true) {
				owlAutoplay = false;	
			}
		}
		//autoheight
		if ( owl.attr('data-autoheight')) {
			var owlAutoheight = (owl.attr('data-autoheight') == 'true' || owl.attr('data-autoheight') == '1');
		}		

		//margin
		if ( owl.attr('data-margin')) {
			margin = parseInt(owl.attr("data-margin"));
		}
		// number of items in a row
		if ( owl.attr('data-col')) {
			number_items_desktop = parseInt(owl.attr("data-col"));
		} 
		if (number_items_desktop > 4) {
			number_items = 4;
		} else  {
			number_items = number_items_desktop;
		}
		if (number_items > 1) {
			number_items_tablet = 2;
		}
		if (owl.attr('data-tablet')) {
			number_items_tablet = owl.attr("data-tablet");
		}

		// loop
		var owlLoop = 'true';
		if (owl.attr('data-owlloop')) {
			owlLoop = owl.attr('data-owlloop');
		}

		// navigation behaviour
		var data_slideby = 0;
		var slideByDesktop = 1;
		var slideByItems = 1;
		var slideByTablet = 1;
		var autoplayTimeout = 5000;
		if ( owl.attr('data-autoplaytimeout') ) {
			autoplayTimeout = parseInt(owl.attr("data-autoplaytimeout"));
		} 		
		if ( owl.attr('data-slideby')) {
			data_slideby = parseInt(owl.attr("data-slideby"));
		} 
		if (number_items_desktop > (childCount / 2)) {
			slideByDesktop = 1;
		} else if (data_slideby != 0 && data_slideby <= number_items_desktop) {
			slideByDesktop = data_slideby;
		} else {
			slideByDesktop = number_items_desktop;
		}
		if (number_items > (childCount / 2)) {
			slideByItems = 1;
		} else if (data_slideby != 0 && data_slideby <= number_items) {
			slideByItems = data_slideby;
		} else {
			slideByItems = number_items;
		}
		if(number_items_tablet > (childCount / 2)) {
			slideByTablet = 1;
		} else if (data_slideby != 0 && data_slideby <= number_items_tablet) {
			slideByTablet = data_slideby;
		} else {
			slideByTablet = number_items_tablet;
		}
		var owlTimeout;

		var hashListner = false;
		if (owl.attr('data-hashlisten')) {
			var hashListner = owl.attr('data-hashlisten');
		}
		var isloop = (owlLoop == 'true');
		owl.owlCarousel({ 

		    loop: isloop,
		   	URLhashListener: hashListner,
		    startPosition: 'URLHash',
		    animateOut: 'fadeOut',
		    autoplay: owlAutoplay,
		    autoplayHoverPause: true,
		    autoplaySpeed: 500,
		    autoplayTimeout: autoplayTimeout,
		    responsiveClass:true,
		    autoHeight: owlAutoheight,
		    dots: dots,
		    margin: margin,
		    responsive:{
		        0:{
		            items:1,
		            nav:false,
		            slideBy: 1,
		        },
		        600:{
		            items:number_items_tablet,
		            nav:false,
		            slideBy: slideByTablet
		        },
		        992:{
		            items: number_items,
		            nav:false,
		            slideBy: slideByItems
		        },
		        1360:{
		            items: number_items_desktop,
		            nav:false,
		            slideBy: slideByDesktop,
		        }		        
		    },
		})

		if (owl.hasClass('owl-equal-height')) {
			//set images as bg image
			owlSetBgImage(owl);
			owlUpdateSize(owl);
		}	
		if (owl.hasClass('owl-correct-height')) {
				// page builder is not fully propagated yet, so we correct the size after 1s
				owlCorrectHeight(owl);
		}				
		owl.on('changed.owl.carousel', function(event) {

    		var urlHash = window.location.hash;
    		if (urlHash != '') {
    			var dataSearchQuery = urlHash.replace("#", "");
    			var navTab = $('.carousel-navigation a[data-navid='+ dataSearchQuery +']').parent('li');
    			navTab.addClass('active');
    			navTab.siblings().removeClass('active');
    		}

		})	

		if (owlAutoplay == true) {
	        $(owl).mouseleave( function() {
	   			owlTimeout = setTimeout(function(){ owl.trigger('next.owl.carousel'); }, autoplayTimeout); 
	   		}).mouseenter(
	   		function() {
	   			clearInterval(owlTimeout);
	   		});
        }	
		// If there is navigation, use it.
	    owl.siblings().find('.owlnext').on('click', function(){
	      	owl.trigger('next.owl.carousel');
	    });
	    owl.siblings().find('.owlprev').on('click', function(){
	      	owl.trigger('prev.owl.carousel');
	    });   
	})
})

/* equal height carousel */
function owlUpdateSize($carousel) {
	var minratio = $carousel.data('minratio');
	var owlWidth = $carousel.innerWidth();
	var owlHeight = parseInt(owlWidth * minratio);
	// set size
	$carousel.height(owlHeight);
	$('.owl-item', $carousel).height(owlHeight);
}
function owlCorrectHeight($carousel) {
	setTimeout(function() {
		var slideHeight = $('> .owl-stage-outer > .owl-stage > .owl-item.active', $carousel).outerHeight();
		$('> .owl-stage-outer', $carousel).height(slideHeight);
	}, 1000);	
}

function owlSetBgImage($carousel) {
	$('.owl-item', $carousel).each(function () {
		// set image
		var $this = $(this);
		var $image = $this.find('img');
		var imageSource = $image.attr('src');
	    $this.css('backgroundImage', 'url(' + imageSource + ')');
	});
}
/*-----------------------------------------------------------------------------------*/
/* END OWL carusel
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Parallax
/*-----------------------------------------------------------------------------------*/

var updatePosition = function() {
	$('.orion-parallax').each(function(){
		var para_position = $(this).offset().top;
		var el_height = $(this).outerHeight();
		var screen_height = $(window).height();
		var para_bg_percent = ( 100 / (el_height + screen_height)) * (window.pageYOffset + screen_height - para_position);
		if ($(this).hasClass('vertical_down')) {
			$(this).css('background-position', '50% ' + para_bg_percent + '%');	
		} else if($(this).hasClass('vertical_up')) {
			$(this).css('background-position', '50% ' + (100 - para_bg_percent)	+ '%' );
		} else if($(this).hasClass('horizontal_left')) {
			$(this).css('background-position', para_bg_percent	+ '%' ) + '50% ';
		} else if($(this).hasClass('horizontal_right')) {
			$(this).css('background-position', (100 - para_bg_percent) + '%' ) + '50% ';
		}				
	})
}

updatePosition();

$(window).on('load', function(){
	if($('.orion-parallax').length > 0 ){
		var parallax_inview = new Waypoint.Inview({
			element: $('.orion-parallax')[0],
			enter: function(direction) {
				if (direction == 'down') {
					window.addEventListener('scroll', updatePosition, false);
				}
			},
			entered: function(direction) {
			},
			exit: function(direction) {
			},
			exited: function(direction) {
			}
		})
	}
})
/*-----------------------------------------------------------------------------------*/
/* END Parallax
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Comment form */ 
/*-----------------------------------------------------------------------------------*/

$( ".orioninner" ).wrapAll( "<div class='row' />");

/*-----------------------------------------------------------------------------------*/
/* END comment form */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Separators */ 
/*-----------------------------------------------------------------------------------*/

$('.orion-separator').each(function(){
	var classList = $(this).attr('class').split(/\s+/);

	var dataType = $(this).attr('data-stretch-type');
	var datatypeAttr = "";
	
	if (dataType != undefined) {
		if (dataType == 'full') {
			dataType = 'full-stretched';
		}
		datatypeAttr = 'data-stretch-type="'+ dataType + '"';
	}

	var bgColorTop = $(this).data('svgTopColor');
	var bgColorBottom = $(this).data('svgBottomColor');

	/* create svg*/
	function getSvg(svg, color) {
		var svgBgColor = '';
		if (color == 'topColor') {
			svgBgColor = bgColorTop;
		} else {
			svgBgColor = bgColorBottom;
		}
		if(svgBgColor == undefined) {

			// check the site bg color
			var siteContentBgAtt = $('body').attr("data-site-content-bg");
			if (typeof siteContentBgAtt !== typeof undefined && siteContentBgAtt !== false) {
			    svgBgColor = siteContentBgAtt;
			} else {
				svgBgColor = '#fff';
			}
		}
		var svgObj = {}
		/* Arrow */
		svgObj.svg1 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 36"> <polygon fill="' + svgBgColor + '" points="755,0 719.999,35 685,0 0,0 0,36 1440,36 1440,0 "/></svg></div>';
		/* Half circle */
		svgObj.svg2 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 36"> <path fill="' + svgBgColor + '" d="M720,0C457.834,0,211.975,12.936,0,35v1h1440v-1C1228.025,12.936,982.166,0,720,0z"/></svg></div>';
		/* Arc */
		svgObj.svg3 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 36"> <path fill="' + svgBgColor + '" d="M0,0v36h1440V0c-211.975,22.064-457.834,35-720,35S211.975,22.064,0,0z"/></svg></div>';
		/* Zigzag*/
		svgObj.svg4 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 19"> <polygon fill="' + svgBgColor + '" points="1422,18 1404,0 1386,18 1368,0 1350,18 1332,0 1314,18 1296,0 1278,18 1260,0 1242,18 1224,0 1206,18 1188,0 1170,18 1152,0 1134,18 1116,0 1098,18 1080,0 1062,18 1044,0 1026,18 1008,0 990,18 972,0 954,18 936,0 918,18 900,0 882,18 864,0 846,18 828,0 810,18 792,0 774,18 756,0 738,18 720,0 702,18 684,0 666,18 648,0 630,18 612,0 594,18 576,0 558,18 540,0 522,18 504,0 486,18 468,0 450,18 432,0 414,18 396,0 378,18 360,0 342,18 324,0 306,18 288,0 270,18 252,0 234,18 216,0 198,18 180,0 162,18 144,0 126,18 108,0 90,18 72,0 54,18 36,0 18,18 0,0 0,19 1440,19 1440,0 "/></svg></div>';
		/* Waves */
		svgObj.svg5 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 19"> <path fill="' + svgBgColor + '" d="M1404,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18c-12.729,0-23.273-18-36-18c-12.729,0-23.273,18-36,18C95.272,18,84.727,0,72,0C59.272,0,48.727,18,36,18C23.272,18,12.727,0,0,0v19c277.735,0,565.325,0,720,0c154.676,0,442.265,0,720,0V0C1427.272,0,1416.727,18,1404,18z"/></svg></div>';
		/* lift */
		svgObj.svg6 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 36"> <polygon fill="' + svgBgColor + '" points="0,36 1440,36 1440,0 0,35.234" /></svg></div>';
		/* triangle */
		svgObj.svg7 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 36"> <polygon fill="' + svgBgColor + '" points="720,34.752 0,0 0,36 710,36 730,36 1440,36 1440,0" /></svg></div>';
		/* Clouds */
		svgObj.svg8 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 60"> <path fill="' + svgBgColor + '" d="M1440,62.46C1426.956,36.684,1400.239,19,1369.375,19c-24.667,0-46.694,11.292-61.205,28.984c-4.415-2.22-9.392-3.484-14.67-3.484c-9.372,0-17.818,3.943-23.788,10.253c-11.829-10.606-27.45-17.065-44.589-17.065c-12.984,0-25.098,3.714-35.355,10.119c-9.238-14.117-25.18-23.452-43.312-23.452c-20.619,0-38.414,12.064-46.729,29.516c-6.338-2.697-13.309-4.192-20.631-4.192c-9.817,0-18.992,2.705-26.857,7.385c-18.469-8.357-38.973-13.011-60.563-13.011c-21.108,0-41.173,4.456-59.317,12.465c-12.013-15.052-30.506-24.703-51.26-24.703c-16.471,0-31.512,6.088-43.027,16.117c-2.826-0.804-5.805-1.243-8.889-1.243c-6.152,0-11.904,1.713-16.807,4.688c-9.742-12.292-24.791-20.187-41.695-20.187c-15.197,0-28.895,6.384-38.588,16.604C717.026,21.48,688.675,3.75,656.18,3.75c-31.958,0-59.906,17.152-75.153,42.75c-10.224-14.393-27.015-23.792-46.013-23.792c-4.791,0-9.441,0.602-13.883,1.727c-5.349-10.564-16.3-17.811-28.95-17.811c-17.915,0-32.438,14.523-32.438,32.438c0,0.006,0,0.012,0,0.018c-8.393-10.005-20.982-16.371-35.063-16.371c-17.053,0-31.922,9.333-39.791,23.165c-2.975-0.889-6.125-1.373-9.39-1.373c-9.903,0-18.772,4.401-24.778,11.348c-15.155-25.97-43.304-43.43-75.542-43.43c-32.362,0-60.616,17.587-75.729,43.724c-9.574-13.756-25.491-22.767-43.521-22.767c-5.303,0-10.42,0.788-15.25,2.238c-6.727-9.397-17.727-15.528-30.166-15.528c-16.579,0-30.612,10.881-35.359,25.889c-8.931-6.852-20.098-10.933-32.224-10.933C25.266,35.041,9.631,43.69,0,56.976v6.774h918.113h147.125h232.852H1440V62.46z"/></svg></div>';
		/* Crack */
		svgObj.svg9 = '<div class="svg-w"><svg xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1440 144"> <polygon fill="' + svgBgColor + '" points="872.943,141.166 568.454,28.231 402.97,106.411 140.405,0 0,132.75 0,144 1440,144 1440,99.394 1256.864,93.389 "/></svg></div>';

		if (svgObj.hasOwnProperty(svg)) {
			return svgObj[svg];	
		}		
	}
	var topSeparator = '';
	var bottomSeparator = '';

	/* which separator to show? */
	if ($(this).hasClass('top-svg-inside') || $(this).hasClass('top-svg-outside')) {
		if ($(this).hasClass('top-svg-1')) {
		   topSeparator = getSvg('svg1','topColor');
		} else if ($(this).hasClass('top-svg-2')) {
			topSeparator = getSvg('svg2','topColor');
		} else if ($(this).hasClass('top-svg-3')) {
			topSeparator = getSvg('svg3','topColor');
		} else if ($(this).hasClass('top-svg-4')) {
			topSeparator = getSvg('svg4','topColor');						
		} else if ($(this).hasClass('top-svg-5')) {
			topSeparator = getSvg('svg5','topColor');						
		} else if ($(this).hasClass('top-svg-6')) {
			topSeparator = getSvg('svg6','topColor');						
		} else if ($(this).hasClass('top-svg-7')) {
			topSeparator = getSvg('svg7','topColor');						
		} else if ($(this).hasClass('top-svg-8')) {
			topSeparator = getSvg('svg8','topColor');						
		} else if ($(this).hasClass('top-svg-9')) {
			topSeparator = getSvg('svg9','topColor');
		}	
	}
	if ($(this).hasClass('bottom-svg-inside') || $(this).hasClass('bottom-svg-outside')) {
		if ($(this).hasClass('bottom-svg-1')) {
		   bottomSeparator = getSvg('svg1','bottomColor');
		} else if ($(this).hasClass('bottom-svg-2')) {
			bottomSeparator = getSvg('svg2','bottomColor');
		} else if ($(this).hasClass('bottom-svg-3')) {
			bottomSeparator = getSvg('svg3','bottomColor');
		} else if ($(this).hasClass('bottom-svg-4')) {
			bottomSeparator = getSvg('svg4','bottomColor');						
		} else if ($(this).hasClass('bottom-svg-5')) {
			bottomSeparator = getSvg('svg5','bottomColor');						
		} else if ($(this).hasClass('bottom-svg-6')) {
			bottomSeparator = getSvg('svg6','bottomColor');						
		} else if ($(this).hasClass('bottom-svg-7')) {
			bottomSeparator = getSvg('svg7','bottomColor');						
		} else if ($(this).hasClass('bottom-svg-8')) {
			bottomSeparator = getSvg('svg8','bottomColor');						
		} else if ($(this).hasClass('bottom-svg-9')) {
			bottomSeparator = getSvg('svg9','bottomColor');						
		}
	}

	/* create svg wrapper */
	var svgTop = '';
	if (topSeparator !='') {
		// clean up class list
		var newClassList = classList.filter(function (item) {
   			return item.indexOf("bottom-") !== 0;
		});
		newClassList = newClassList.filter(function(e) { return e !== 'middle_align' });
		newClassList = newClassList.filter(function(e) { return e !== 'bottom_align' });
		newClassList = newClassList.filter(function(e) { return e !== 'orion-equal-height' });
		newClassList = newClassList.filter(function(e) { return e !== 'full-screen-row' });
		newClassList = newClassList.join(' ');
		svgTop = '<div class="' + newClassList + ' svg-wrap wrap-top"' + datatypeAttr + '>' + topSeparator + '</div>'
	}
	var svgBottom = '';
	if (bottomSeparator !='') {
		// clean up class list
		var newClassList = classList.filter(function (item) {
   			return item.indexOf("top-") !== 0;
		});
		newClassList = newClassList.filter(function(e) { return e !== 'middle_align' });
		newClassList = newClassList.filter(function(e) { return e !== 'bottom_align' });
		newClassList = newClassList.filter(function(e) { return e !== 'orion-equal-height' });		
		newClassList = newClassList.filter(function(e) { return e !== 'full-screen-row' });	
		newClassList = newClassList.join(' ');
		svgBottom = '<div class="' + newClassList + ' svg-wrap wrap-bottom"' + datatypeAttr + '>' + bottomSeparator + '</div>'
	}

	/* populate svg wrappers */
	if (svgTop != '') {
		$(this).before(svgTop);	
	}
	if (svgBottom != '') {
		$(this).after(svgBottom);	
	}	
})

/*-----------------------------------------------------------------------------------*/
/* END Separators */ 
/*-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Rounded images */ 
/*-----------------------------------------------------------------------------------*/

function roundedImages() {
	$('.orion_circle').each(function(){
		var el = $(this);
		var parentWidth = $(this).parent().width();
		parentWidth = Math.round(parentWidth);
		el.css('width', parentWidth);
		el.css('height', parentWidth);		
	});

	$('.mega-sidebar .orion_circle').css('width', '100%').css('height', 'auto');
}
$(window).on('load', roundedImages );

		
/*-----------------------------------------------------------------------------------*/
/* Resize functions*/
/*-----------------------------------------------------------------------------------*/

$(window).on('resize', function() {
	stickyAdjustWidth();
	setPostLinkHeight(); //previous, next post

	/* screen size dependant: */
	if ($(window).width() > screenMedium) {
		stay_on_screen();
	} 
	setTimeout(function() {
		roundedImages();
	}, 300); 
	$('.owl-carousel.owl-equal-height').each(function(){
		var owl = $(this);
		owlUpdateSize(owl);
	})
})

// Siteorigin fix: Resize google maps add function only if it is on the page.
if ($('.so-widget-sow-google-map').length) { 
	$(window).on('resize', function() {
		if (typeof soGoogleMapInitialize == 'function') {
			soGoogleMapInitialize();
		}
	});
}

/*-----------------------------------------------------------------------------------*/
/* End Resize function*/
/*-----------------------------------------------------------------------------------*/

$(window).on('load', function() {	
	//needed due to siteorigin full width layout bug
	$(window).trigger('resize');
})

/*-----------------------------------------------------------------------------------*/
/* Collapse tabs to accordion */ 
/*-----------------------------------------------------------------------------------*/
	$('.tabs-wrap > ul').tabCollapse();
/*-----------------------------------------------------------------------------------*/
/* END Collapse tabs to accordion */ 
/*-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* swipebox */ 
/*-----------------------------------------------------------------------------------*/

$( document ).on('ready' ,function() {
		// Add class .swipebox to all links to images
		$('a[href]').filter(function() {
		return /(\.jpg|\.jpeg|\.gif|\.png)/i.test( $(this).attr('href'));
		}).addClass("swipebox");

		// If link has no title, add img title/alt as title to links
		$('a.swipebox').filter(function(){

			// Check if image has title - else alt
			if ($(this).find('img').attr('title')){
				var title_img = $(this).find('img').attr('title');
			} else {
				var title_img = $(this).find('img').attr('alt');
			}

			if ($(this).not("[title]")){
				$(this).attr('title', title_img);
			}
		});

		var removeBarsOnMobile = true;
		if ($('body').hasClass('swipebox-mobile')) {
			removeBarsOnMobile = false;
		}
		// Add SwipeBox Script
		$( '.swipebox' ).swipebox( {
			useCSS : true,
			useSVG : true,
			initialIndexOnArray : 0,
			removeBarsOnMobile : removeBarsOnMobile,
			hideCloseButtonOnMobile : false,
			hideBarsDelay : 0,
			videoMaxWidth : 1170,
			beforeOpen: null,
			afterOpen: null,
			afterClose: null,
			nextSlide: null,
			prevSlide: null,
			loopAtEnd:false,
			queryStringData: {},
			toggleClassOnLoad: '',
			autoplayVideos: true
		} );
});

/*-----------------------------------------------------------------------------------*/
/*       	  						 image size (logos)						 		 */
/*-----------------------------------------------------------------------------------*/

$( document ).on('ready',function() {
	$('[data-imgsize]').each(function(){
		var el = $(this);
		var imgSize = el.attr('data-imgsize') + '%';
		
		var imgHoverSize = el.attr('data-imghoversize');
		if (typeof imgHoverSize !== typeof undefined && imgHoverSize !== false) {
	    	imgHoverSize = imgHoverSize + '%';
		} else {
			imgHoverSize = imgSize;
		}
		var imgHoverSize = el.attr('data-imghoversize') + '%';
		$('> img', el).css({
			"max-width": imgSize,
			"max-height": imgSize
		})
		el.on('mouseenter', function(){
			$('> img', el).css({
				"max-width": imgHoverSize,
				"max-height": imgHoverSize
			})
		})
		el.on('mouseleave', function(){
			$('> img', el).css({
				"max-width": imgSize,
				"max-height": imgSize
			})
		})	
	})
})

/*-----------------------------------------------------------------------------------*/
/* 									back to top 									 */
/*-----------------------------------------------------------------------------------*/
function backToTopBtn() {
    var button = $('.back-to-top');
    var scrollTop = $(window).scrollTop();
    if (scrollTop > 800) {
        button.removeClass('hideit');
    } else {
        button.addClass('hideit');
    }
}

$('.back-to-top').on('click', function(){
	$('html,body').animate({
        scrollTop: 0
    }, 600);
	return false;
})

$(window).on('load scroll resize' , backToTopBtn);

/*-----------------------------------------------------------------------------------*/
/* 									sticky footer 									 */
/*-----------------------------------------------------------------------------------*/

$(window).on('load', function() {
	if ($('.fixed-footer').length && $(window).width() > screenMedium ) {
		var footerSize = $('.site-footer').height();
		if (footerSize > 0) {
			$('.site-footer').addClass('fixed');
			$('body').css('margin-bottom', footerSize);
		}
	}
})

/*-----------------------------------------------------------------------------------*/
/* 									Download button									 */
/*-----------------------------------------------------------------------------------*/

$('.btn-download').on('click', function(){
	$(this).addClass('visited');
})

/*-----------------------------------------------------------------------------------*/
/* 									overlays	 									 */
/*-----------------------------------------------------------------------------------*/

$('.overlay-dark').prepend('<div class="overlay-dark-wrapper"></div>');
$('.overlay-light').prepend('<div class="overlay-light-wrapper"></div>');
$('.overlay-c1').prepend('<div class="overlay-c1-wrapper"></div>');
$('.overlay-c2').prepend('<div class="overlay-c2-wrapper"></div>');
$('.overlay-c3').prepend('<div class="overlay-c3-wrapper"></div>');
$('.overlay-c1-c2').prepend('<div class="overlay-c1-c2-wrapper"></div>');
$('.overlay-c2-c1').prepend('<div class="overlay-c2-c1-wrapper"></div>');
$('.overlay-c1-t').prepend('<div class="overlay-c1-t-wrapper"></div>');
$('.overlay-c2-t').prepend('<div class="overlay-c2-t-wrapper"></div>');
$('.overlay-c3-t').prepend('<div class="overlay-c3-t-wrapper"></div>');

/*-----------------------------------------------------------------------------------*/
/* 									shadows		 									 */
/*-----------------------------------------------------------------------------------*/
$('.shadow-2').parent().addClass('relative no-bottom-margins');
$('.shadow-2').parent().prepend('<div class="shadow-2-left-wrap"></div>');
$('.shadow-2').parent().prepend('<div class="shadow-2-right-wrap"></div>');
$('.shadow-3').parent().addClass('relative no-bottom-margins');
$('.shadow-3').parent().prepend('<div class="shadow-3-left-wrap"></div>');
$('.shadow-3').parent().prepend('<div class="shadow-3-right-wrap"></div>');

/*-----------------------------------------------------------------------------------*/
/* 								absolute widgets		 							 */
/*-----------------------------------------------------------------------------------*/

$('.orion.absolute-bottom').each(function(){
	$(this).parents('.panel-row-style').css('z-index', '2');
})

$(document).on('focus', '.wpcf7-not-valid', function(){
	$(this).siblings('.wpcf7-not-valid-tip').css('opacity', 0);
});

/*-----------------------------------------------------------------------------------*/
/*					Smooth scroll one page functionality  							 */
/*-----------------------------------------------------------------------------------*/


/* if it is a review link, first open the tab */

$('.woocommerce-review-link').on('click', function() {
	if ( $(window).width() > screenSmall ) {
		$('.nav-tabs a[area-controls="tab-reviews"]').tab('show');
	} else {
		$('.panel-group #tab-reviews-collapse').collapse('show');
	}
})

$(document).on('ready', function() {

    var scrollnow = function(e) {
        // if scrollnow()-function was triggered by an event
        if (e) {
        	if (! $(this).hasClass('owl-nav-link') && !$(this).hasClass('comment-reply-link') ) {
	            e.preventDefault();
	            var target = this.hash;
            }
        }
        // else it was called when page with a #hash was loaded
        else {
            var target = location.hash;
        }

        // same page scroll
		var offset = 0; /* Desired spacing */

		if( $('#wpadminbar').length ) {
			offset -= $('#wpadminbar').height();
		}
		if( $('.stickymenu').length ) {
			offset -= $('.stickymenu').height();
		}

		if($(target).hasClass('tab-pane') || $(target).hasClass('panel-collapse') || $(target).hasClass('panel') || $(this).hasClass('owl-nav-link') || $(this).hasClass('comment-reply-link')) {  
			// prevent actions on tabs and accordions
		} else {
			$.smoothScroll({
	            offset: offset,
	            scrollTarget: target,
	            easing: 'swing',
	            speed: 800,
        	});
		}
    };

    // if page has a #hash
    if (location.hash) {
        $('html, body').scrollTop(0).show();
        // smooth-scroll to hash
        scrollnow();
    }

    // for each <a>-element that contains a "/" and a "#"
    $('a[href*="/"][href*="#"]').each(function(){
        // if the pathname of the href references the same page
        if (this.pathname.replace(/^\//,'') == location.pathname.replace(/^\//,'') && this.hostname == location.hostname) {
            // only keep the hash, i.e. do not keep the pathname
            $(this).attr("href", this.hash);
        }
    });

    // select all href-elements that start with #
    // including the ones that were stripped by their pathname just above
    $('a[href^="#"]:not([href="#"])').on('click', scrollnow);

});
/*-----------------------------------------------------------------------------------*/
/* 									OnePage Navigation 								 */
/*-----------------------------------------------------------------------------------*/
/* Waypoints */
if ($('body').hasClass('one-page')) {
    var navLinkIDs = "";
    $('.nav-container a[href*="#"]:not([href="#"]):not([href*="="])').each(function(index) {
        if (navLinkIDs != "") {
            navLinkIDs += ", ";
        }
        var temp = $('.nav-container a[href*="#"]:not([href="#"]):not([href*="="])').eq(index).attr("href").split('#');
        navLinkIDs += '#' + temp[1];
    });
    
    if (navLinkIDs) {

    	var offset = $('.stickymenu').height() + 40;
    	if ($('.wpadminbar').length) {
			offset += ('.wpadminbar').height();
    	}
    	
        $(navLinkIDs).waypoint(function(direction) {
        	var link_id = ".nav-container .menu-item a[href*=#" + $(this.element).attr('id') + "]";
            if (direction == 'down') {
                $('.nav-container .menu-item a').parent().removeClass("one-page-current-item");
                $( link_id ).parent().addClass("one-page-current-item");

                // anchesters
                $('.one-page-current-anchester').removeClass('one-page-current-anchester');
                $( link_id ).parents('.menu-item').parents('.menu-item').addClass('one-page-current-anchester');
            }
        }, {
            offset: offset
        });

        $(navLinkIDs).waypoint(function(direction) {
        	var link_id = ".nav-container a[href*=#" + $(this.element).attr('id') + "]";
            if (direction == 'up') {
                $('.nav-container a').parent().removeClass("one-page-current-item");
                $(link_id).parent().addClass("one-page-current-item");
                
                // anchesters
                $('.one-page-current-anchester').removeClass('one-page-current-anchester');
                $( link_id ).parents('.menu-item').parents('.menu-item').addClass('one-page-current-anchester');
                                
            }
        }, {
            offset: function() {
                return -$(this.element).closest('.panel-grid').height() + offset;
                
            }
        });
    }

}

/*-----------------------------------------------------------------------------------*/
/*									Simple MegaMenu 							 	 */
/*-----------------------------------------------------------------------------------*/

/* add row class to sub-menu */
$('.orion-megamenu > .sub-menu').addClass('row');

// /* set widget text-color */
$('.orion-megamenu > .mega-light').addClass('nav-light').addClass('text-light');
$('.orion-megamenu > .mega-dark').addClass('nav-dark').addClass('text-dark');


/*-----------------------------------------------------------------------------------*/
/*    								Transparent Header 							 	 */
/*-----------------------------------------------------------------------------------*/

function headerSpaceAdjust() {
	var headerHeight = $('.header-transparent').height();
	$('.header-space').css('height', headerHeight);
}
if ($('.header-transparent').length && $('.page-heading').length) {

	$( document ).on("ready", function() {
		var headerHeight = $('.header-transparent').height();
		$('.page-heading').prepend('<div class="visible-md visible-lg header-space" style="height:' + headerHeight + 'px"></div>')
	})
	
	$( window ).resize(function() {
		headerSpaceAdjust();
	})
}


/*-----------------------------------------------------------------------------------*/
/*    								Orion Custom Menu widget					 	 */
/*-----------------------------------------------------------------------------------*/

function openMenus() {
	$('.so-widget-orion_custom_menu_w .current-menu-ancestor').addClass('open');
	$('.so-widget-orion_custom_menu_w .current-menu-ancestor > .sub-menu').css('display', 'block');

	$('.so-widget-orion_custom_menu_w .current-menu-item.menu-item-has-children').addClass('open');
	$('.so-widget-orion_custom_menu_w .current-menu-item.menu-item-has-children').children('.sub-menu').css('display', 'block');

	/* woo categories*/
	$('.widget_product_categories .current-cat.cat-parent').addClass('open');
	$('.widget_product_categories .current-cat.cat-parent > .children').css('display', 'block');
	
	$('.widget_product_categories .current-cat-parent').addClass('open');
	$('.widget_product_categories .current-cat-parent').children('.children').css('display', 'block');
	
}

$(window).on('load', openMenus );

/*-----------------------------------------------------------------------------------*/
/*    									Tablets   								 	 */
/*-----------------------------------------------------------------------------------*/

if (isMobile == true && $(window).width() > screenMedium) {
	$('.menu-item-has-children > a').on('click', function(){
		if(!$(this).hasClass('tablet-mode')){
			$(this).addClass('tablet-mode');
			return false;
		} else {
			$(this).removeClass('tablet-mode');
			window.location = this.href;
		}
	})
}

/*-----------------------------------------------------------------------------------*/
	//						JQuery UI datepicker 							 	 
/*-----------------------------------------------------------------------------------*/

if (typeof datepicker == 'function') { 
	$('input[type="date"]').datepicker( {
		dateFormat: 'yy-mm-dd',
		minDate: new Date( $( this ).attr( 'min' ) ),
		maxDate: new Date( $( this ).attr( 'max' ) )
	} ).attr('type','text');
}

/*-----------------------------------------------------------------------------------*/
/* row-divide class */ 
/*-----------------------------------------------------------------------------------*/

$(window).on('ready resize' , pushupRows);
function pushupRows(){	
    $('.row-divide').each(function(){
    	if ( $(window).width() > screenMedium ) {
	    	var rowDivideHeight = $(this).outerHeight();
	    	var setMarginTop = -rowDivideHeight/2;
	    	$(this).stop().animate({
				marginTop: setMarginTop,
			});
		} else {
    		$('.row-divide').css('marginTop', '');
    	}	
    });
    $('.push-up-row').each(function(){
    	if ( $(window).width() > screenMedium ) {
	    	var rowDivideHeight = $(this).outerHeight();
	    	var setMarginTop = -rowDivideHeight;
	    	$(this).stop().animate({
				marginTop: setMarginTop,
			});
    	} else {
    		$('.push-up-row').css('marginTop', '');
    	}
    });
}

/*-----------------------------------------------------------------------------------*/
/*    								WooCommerce   								 	 */
/*-----------------------------------------------------------------------------------*/

$('.widget_shopping_cart, .last-tab-wrap .woocart').on('mouseenter', function(){
	$(this).find('.orion-cart-wrapper').removeClass('minicart-hidden');
})

$('.widget_shopping_cart, .last-tab-wrap .woocart').on('mouseleave', function(){
	$(this).find('.orion-cart-wrapper').addClass('minicart-hidden');
})

/**
 * toggles mobile menu and renders it
 */

/*Toggle mobile cart*/
function toggleMobileCart() {

	var button = $('.to-x .woocart'); 
	moveCartContent();
	var mobile_cart = $('.mainheader .mobile-cart');

	if ($('header .nav-container.open').length) {
		toggleMobileNav();
	}

	if (mobile_cart.hasClass('open') ) {
		/* close the navigation */
		mobile_cart.removeClass('open');
		button.removeClass('open');
		
		/*scroll to the top */
		var body = $("html, body");
		body.stop().animate({scrollTop:0}, '400', 'swing', function() { 
		});

	} else {
		/* open the navigation */
		mobile_cart.addClass('open');
		button.addClass('open');
		
		/*scroll to the menu content */
		var $scrollValue = $('.hamburger-box').offset();
		var body = $("html, body");
		body.stop().animate({scrollTop:($scrollValue.top - 12)}, '700', 'swing', function() { 
		});
	}	
}

$('.burger-container .woocart').on('click',function() {
	toggleMobileCart();
})

function moveCartContent() {
	if ($('.to-x .woocart').length &&  $('.to-x .woocart .product_list_widget').children().length > 0 && !$('.site-header .mobile-cart').length) {
		$('.mainheader .nav-container').after('<div class="mobile-cart hidden-md hidden-lg"></div>');
		$('.to-x .woocart .orion-cart-wrapper').clone().appendTo( ".mainheader .mobile-cart" );
	}
} 
$(window).on('load', function(){
	$('.orion-products .woo-content').each(function(){
		if ($(this).has('.star-rating').length) {
			var woocontentWidth = $(this).width();
			var priceWidth = $('.price', this).width();
			var starWidth = $('.star-rating', this).width();
			if (woocontentWidth < (priceWidth + starWidth)) {
				$('.star-rating', this).css({
					'float': 'left',
					'margin-bottom': '8px'
				});
				$('.price', this).css('clear', 'both');
			}
		}
	})

	$('.woocommerce-product-gallery__trigger').html(''); //remove hardcoded woo icon
});

/* display add to cart on big-screen tablets */
if (isMobile == true && $(window).width() > screenMedium) {
	$('.woocommerce .add_to_cart_btn').css('transform','translateY(0)');
}

$('.widget_layered_nav > select').wrap('<div class="selectwrapper"></div>');


}) //END jQuery(function($){}) 


