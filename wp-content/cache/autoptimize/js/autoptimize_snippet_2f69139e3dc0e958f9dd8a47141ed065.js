
/*!
 * jQuery UI Touch Punch 0.2.3
 *
 * Copyright 2011–2014, Dave Furfero
 * Dual licensed under the MIT or GPL Version 2 licenses.
 *
 * Depends:
 *  jquery.ui.widget.js
 *  jquery.ui.mouse.js
 */
(function(b){b.support.touch="ontouchend" in document;if(!b.support.touch){return}if(typeof(b.ui.mouse) == 'undefined'){return}  var d=b.ui.mouse.prototype,f=d._mouseInit,c=d._mouseDestroy,a;function e(h,i){if(h.originalEvent.touches.length>1){return}h.preventDefault();var j=h.originalEvent.changedTouches[0],g=document.createEvent("MouseEvents");g.initMouseEvent(i,true,true,window,1,j.screenX,j.screenY,j.clientX,j.clientY,false,false,false,false,0,null);h.target.dispatchEvent(g)}d._touchStart=function(h){var g=this;if(a||!g._mouseCapture(h.originalEvent.changedTouches[0])){}a=true;g._touchMoved=false;e(h,"mouseover");e(h,"mousemove");e(h,"mousedown")};d._touchMove=function(g){if(!a){return}this._touchMoved=true;e(g,"mousemove")};d._touchEnd=function(g){if(!a){return}e(g,"mouseup");e(g,"mouseout");if(!this._touchMoved){e(g,"click")}a=false};d._mouseInit=function(){var g=this;g.element.bind({touchstart:b.proxy(g,"_touchStart"),touchmove:b.proxy(g,"_touchMove"),touchend:b.proxy(g,"_touchEnd")});f.call(g)};d._mouseDestroy=function(){var g=this;g.element.unbind({touchstart:b.proxy(g,"_touchStart"),touchmove:b.proxy(g,"_touchMove"),touchend:b.proxy(g,"_touchEnd")});c.call(g)}})(jQuery);