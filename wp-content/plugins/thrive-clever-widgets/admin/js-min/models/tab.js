/*! Thrive Clever Widgets 2020-08-13
* http://www.thrivethemes.com 
* Copyright (c) 2020 * Thrive Themes */
var tcw_app=tcw_app||{};!function(){"use strict";tcw_app.Tab=Backbone.Model.extend({defaults:{identifier:"",label:"",isActive:!1,actions:[],filters:[]},initialize:function(a){this.set("options",new tcw_app.Options(a.options)),this.set("filters",new tcw_app.Filters(a.filters))},getTabIdentifierFromTabId:function(a){return a.replace("tcw_tab_","")},getTabIdFromIdentifier:function(){return"tcw_tab_"+this.get("identifier")},getTabContentIdentifier:function(){return"tcw_tab_content_"+this.get("identifier")},countCheckedOptions:function(){if("others"===this.get("identifier")){var a=0;return this.get("options").each(function(b){("direct_url"===b.get("type")||b.get("isChecked"))&&a++}),a}return this.get("options").countCheckedOptions()},uncheckAll:function(){var a=[],b=this.get("options");b.each(function(b){b.set("isChecked",!1),"direct_url"===b.get("type")&&a.push(b)}),_.forEach(a,function(a){b.remove(a)})}})}(jQuery);