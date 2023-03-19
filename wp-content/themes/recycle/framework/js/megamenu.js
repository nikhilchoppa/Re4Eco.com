"use strict";

jQuery(document).ready(function($) {

  /* megamenu */
  function displayMegaMenuFeatures () {
    // depth 1
    $('.menu-item-depth-1 .menu-item-data-parent-id').each(function(){
      var menuItem = $(this).closest('.menu-item');
      var parentId = $(this).attr('value');
      var megamenuCheckbox = "#edit-menu-item-orion-megamenu-"+parentId + ':checked';
      if( $(megamenuCheckbox).length) {
        menuItem.addClass('orion-mega-column');
      } else {
        menuItem.removeClass('orion-mega-column');
      }
    })
    // depth 2
    $('.menu-item-depth-2 .menu-item-data-parent-id').each(function(){
      var menuItem = $(this).closest('.menu-item');
      var parentId = $(this).attr('value');

      if( $("#menu-item-"+parentId).hasClass('orion-mega-column')) {
        $(menuItem).addClass('orion-mega-sub-item');
      } else {
        $(menuItem).removeClass('orion-mega-sub-item');
      }
    })
    // depth 3
    $('.menu-item-depth-3 .menu-item-data-parent-id').each(function(){
      var menuItem = $(this).closest('.menu-item');
      var parentId = $(this).attr('value');
      if( $("#menu-item-"+parentId).hasClass('orion-mega-sub-item')) {
        $(menuItem).addClass('orion-mega-error');
      } else {
        $(menuItem).removeClass('orion-mega-error');
      }    
    })  
    $('.mega-menu-label').remove();
    $('.mega-menu-error-label').remove();

    if (!$('.orion-mega-column .menu-item-handle').children('.mega-menu-label').length) {
      $('.orion-mega-column .menu-item-handle').prepend('<span class="mega-menu-label">Megamenu Column</span>');
    }
    if (!$('.orion-mega-error .menu-item-handle').children('.mega-menu-error-label').length) {
      $('.orion-mega-error .menu-item-handle').prepend('<span class="mega-menu-error-label">Error: MegaMenu does not support third level menus</span>');
    }  
  }

  displayMegaMenuFeatures();
  $('.edit-menu-item-orion-megamenu').on('click', setMegamenuFunction)
  $('.menu-item-handle.ui-sortable-handle').on('mouseup', setMegamenuFunction);
  $('.ui-sortable-handle').on('mouseout', setMegamenuFunction);

  function setMegamenuFunction() {
    $('.menu-item.orion-mega-column').removeClass('orion-mega-column');
    $('.menu-item.orion-mega-sub-item').removeClass('orion-mega-sub-item');
    $('.menu-item.orion-mega-error').removeClass('orion-mega-error');
    displayMegaMenuFeatures();
  }

}) // end jQuery