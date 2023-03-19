"use strict"; 
jQuery(function($) { 
	$(window).on( 'load', function(){
		var isotopeGroup = $('.isotope-items').isotope({
			itemSelector: '.isotope-el',
			stagger: 30
		});

		$('.isotope-filter').on( 'click', '.btn', function() {
		  var filterValue = $(this).attr('data-filter');

		  isotopeGroup.isotope({ 
		  	itemSelector: '.isotope-el',
		  	filter: filterValue,
		  });

		});

		$('.isotope-filter').each( function( i, buttonGroup ) {
		  var $buttonGroup = $( buttonGroup );
		  $buttonGroup.on( 'click', 'button', function() {
		    $buttonGroup.find('.active').removeClass('active');
		    $( this ).addClass('active');
		  });
		});
	});
})
