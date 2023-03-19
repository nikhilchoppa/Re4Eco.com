"use strict";
jQuery(function($) { 
  	$(window).on( 'load', function(){
	  	$('.masonry').masonry({
		  itemSelector: '.masonry-item',
		  percentPosition: true
		})

		$(window).on('resize', function() {
		    $('.masonry').masonry('bindResize');
		});		
	})
})
