"use strict";jQuery(function($){$(window).on('load',function(){inView('.counternumber').on('enter',startCounter).on('exit',restartCounter);function startCounter(el){$(el).countTo({onComplete:function(value){if(this.text()!=this.attr('data-to')){this.text(this.attr('data-to'));}}});}
function restartCounter(el){$(el).countTo('restart');}});});