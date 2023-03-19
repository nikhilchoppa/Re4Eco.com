"use strict";

jQuery(function($) { 
	$(window).on('load', function() {
		inView('.progress-bar')
	    .on('enter', startProgress)
	    .on('exit', restartProgress);

	    function startProgress(el) {
	    	var bar_percentage = $(el).attr('data-percentage') + '%';
	    	$(el).css('width', bar_percentage);
			}
			
	    function restartProgress(el) {
				$(el).css('width', '0');
			}
	});
})