
var lfb_isDraggingComponent = false;
var lfb_elementHoverTimer = false;
var lfb_currentFormID = 0;
var lfb_currentStepID = 0;
var lfb_currentStep = false;
var lfb_editedItem = false;
var lfb_copyHelper = null;

jQuery(window).on('load',function () {
    lfb_currentFormID = jQuery('#estimation_popup').attr('data-form');
    if (typeof (window.parent.lfb_stepFrameLoaded) != 'undefined') {
        window.parent.lfb_stepFrameLoaded();
    }


});

function lfb_initVisualStep(stepID, formID) {
    lfb_currentStepID = stepID;
    jQuery(window).resize(function () {

        jQuery('#lfb_bootstraped').css({
            height: jQuery(window).height()
        });
    });
    jQuery('#lfb_bootstraped').css({
        height: jQuery(window).height()
    });
    var domStepID = stepID;
    if (domStepID == 0) {
        domStepID = 'final'
    }

    jQuery('#lfb_bootstraped').addClass('lfb_visualEditing');
    jQuery('#estimation_popup').addClass('lfb_visualEditing');
    jQuery('#estimation_popup').attr('data-animspeed', '0');
    jQuery('#estimation_popup .genSlide.lfb_activeStep').removeClass('lfb_activeStep');
    jQuery('#estimation_popup .genSlide').hide();
    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"]').show();
    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"]').addClass('lfb_activeStep');
    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"] .errorMsg').hide();
    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"] .btn-next').show();
    if (!jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"]').is('[data-start="1"]')) {
        jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"] .lfb_linkPreviousCt').show();

    }

    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"] .stepTitle').addClass('positioned');

    jQuery('#estimation_popup .genSlide[data-stepid="' + domStepID + '"] .genContent').css({opacity: 1});

    jQuery('#estimation_popup.wpe_bootstraped #mainPanel').show();
    jQuery('#estimation_popup.wpe_bootstraped #wpe_panel > .container-fluid > .row').hide();



    jQuery('#estimation_popup .lfb_item:not(.lfb_componentInitialized)').each(function () {
        jQuery(this).addClass('lfb_componentInitialized');
        lfb_initItemToolbar(jQuery(this));

        lfb_initItemContent(jQuery(this));
    });

    lfb_resizeAll();
}
function lfb_getStepByID(stepID, form) {
    var rep = false;
    for (var i = 0; i < form.steps.length; i++) {
        if (form.steps[i].id == stepID) {
            rep = form.steps[i];
            break;
        }
    }
    return rep;
}


function lfb_refreshItemDom(itemID) {
    jQuery.ajax({
        url: lfb_data.ajaxurl,
        type: 'post',
        data: {
            action: 'lfb_getItemDom',
            formID: lfb_currentFormID,
            itemID: itemID,
            stepID: jQuery('#estimation_popup .lfb_activeStep').attr('data-stepid')
        }, success: function (itemDom) {
            var $item = jQuery(itemDom);
            if (itemID > 0) {

                var exItem = jQuery('#estimation_popup .lfb_item[data-id="' + itemID + '"]');
                exItem.after($item);
                exItem.remove();
            } else {
                jQuery('#estimation_popup .lfb_activeStep > .genContent > .lfb_row').html($item);
            }
            if (itemID > 0) {
                lfb_initItemToolbar($item);
                lfb_initItemContent($item);
                    lfb_initNewItemContent($item);

                $item.find('.lfb_item').each(function () {
                    lfb_initItemToolbar(jQuery(this));
                    lfb_initItemContent(jQuery(this));
                    lfb_initNewItemContent(jQuery(this));

                });
            } else {

                jQuery('#estimation_popup .lfb_activeStep > .genContent > .lfb_row').find('.lfb_item').each(function () {
                    lfb_initItemToolbar(jQuery(this));
                    lfb_initItemContent(jQuery(this));
                    lfb_initNewItemContent(jQuery(this));

                });
            }


        }
    });
}

function lfb_initRowMenu() {
    var menu = jQuery('<div id="lfb_rowMenu" class="lfb_lPanel lfb_lPanelRight"></div>');
    menu.append('<div class="lfb_lPanelHeader"><span class="fa fa-clock-o"></span><span id="lfb_lPanelHeaderTitle">' + lfb_data.texts['Row settings'] + '</span>' +
            '<a href="javascript:" id="lfb_rowMenuCloseBtn" class="btn btn-default btn-circle btn-inverse"><span class="glyphicon glyphicon-remove"></span></a>' +
            '</div>'
            );
    menu.append(' <div class="lfb_lPanelBody"></div>');
    jQuery('#lfb_bootstraped').append(menu);

    menu.find('.lfb_lPanelBody').append('<label>' + lfb_data.texts['Columns'] + '</label>');
    menu.find('.lfb_lPanelBody').append('<table class="table table-striped"></table>');
    menu.find('.table').append('<thead></thead>');
    menu.find('.table thead').append('<tr><th>' + lfb_data.texts['Size'] + '</th><th class="text-right"><a href="javascript:" data-action="addColumn" class="btn btn-primary btn-circle" title="' + lfb_data.texts['Add a column'] + '"><span class="fas fa-plus"></span></a></th></tr>');
    menu.find('.table').append('<tbody></tbody>');

    menu.find('#lfb_rowMenuCloseBtn').on('click', function () {
        menu.removeClass('lfb_open');
    });
    menu.find('a[data-action="addColumn"]').click(function () {
        var table = jQuery(this).closest('table');

        var columnID = jQuery(this).closest('tr[data-id]').attr('data-id');

        jQuery.ajax({
            url: lfb_data.ajaxurl,
            type: 'post',
            data: {
                action: 'lfb_createRowColumn',
                rowID: lfb_editedItem.attr('data-id')
            }, success: function (columnID) {

                var column = {
                    size: 'medium',
                    id: columnID
                };

                addColumnRow(column);

            }
        });
    });

}

function addColumnRow(column) {
    var table = jQuery('#lfb_rowMenu').find('table');

    var $tr = jQuery('<tr data-id="' + column.id + '"></tr>');
    $tr.append('<td><select name="size" class="form-control form-control-sm"></select></td>');
    $tr.find('[name="size"]').append('<option value="auto">' + lfb_data.texts['Automatic'] + '</option>');
    $tr.find('[name="size"]').append('<option value="small">' + lfb_data.texts['Small'] + '</option>');
    $tr.find('[name="size"]').append('<option value="medium">' + lfb_data.texts['Medium'] + '</option>');
    $tr.find('[name="size"]').append('<option value="large">' + lfb_data.texts['Large'] + '</option>');
    $tr.find('[name="size"]').append('<option value="xl">' + lfb_data.texts['XL'] + '</option>');
    $tr.find('[name="size"]').append('<option value="fullWidth">' + lfb_data.texts['Full width'] + '</option>');
    $tr.append('<td class="text-right lfb_tdAction"></td>');
    $tr.find('.lfb_tdAction').append('<a href="javascript:" data-action="deleteColumn" class="btn btn-danger btn-circle"><span class="fas fa-trash"></span></a>');

    table.find('tbody').append($tr);
    lfb_updateRowColumns(lfb_editedItem);
    lfb_refreshItemDom(lfb_editedItem.attr('data-id'));
    $tr.find('[name="size"]').val(column.size);

    $tr.find('[name="size"]').on('change', function () {

        var size = jQuery(this).val();
        lfb_updateRowColumns(lfb_editedItem);

        jQuery.ajax({
            url: lfb_data.ajaxurl,
            type: 'post',
            data: {
                action: 'lfb_editRowColumn',
                rowID: lfb_editedItem.attr('data-id'),
                columnID: column.id,
                size: size
            }, success: function () {
                lfb_refreshItemDom(lfb_editedItem.attr('data-id'));
            }
        });

    });
    $tr.find('[data-action="deleteColumn"]').on('click', function () {
        var columnID = jQuery(this).closest('tr[data-id]').attr('data-id');
        jQuery(this).closest('tr[data-id]').remove();
        jQuery.ajax({
            url: lfb_data.ajaxurl,
            type: 'post',
            data: {
                action: 'lfb_deleteRowColumn',
                rowID: lfb_editedItem.attr('data-id'),
                columnID: column.id
            }, success: function () {
                lfb_updateRowColumns(lfb_editedItem);
                lfb_refreshItemDom(lfb_editedItem.attr('data-id'));

            }
        });
    });
}

function lfb_updateRowColumns($row) {
    var columns = new Array();
    jQuery('#lfb_rowMenu table tr[data-id]').each(function () {
        columns.push({
            id: jQuery(this).attr('data-id'),
            size: jQuery(this).find('[name="size"]').val()
        });
    });

    $row.attr('data-columns', JSON.stringify(columns));

}
function lfb_updateItemsSortOrder() {
    var itemsIDs = new Array();
    var indexes = new Array();
    var columnsIDs = new Array();
    jQuery('#estimation_popup .lfb_activeStep .lfb_item').each(function () {
        itemsIDs.push(jQuery(this).attr('data-id'));
        indexes.push(jQuery(this).index());
        var columnID = '';
        if (jQuery(this).closest('.lfb_column').length > 0) {
            columnID = jQuery(this).closest('.lfb_column').attr('data-columnid');
        }
        columnsIDs.push(columnID);
    });
    jQuery.ajax({
        url: lfb_data.ajaxurl,
        type: 'post',
        data: {
            action: 'lfb_itemsSort',
            stepID: lfb_currentStepID,
            itemsIDs: itemsIDs,
            indexes: indexes,
            columnsIDs: columnsIDs
        }
    });
}

function lfb_initComponentsMenu() {

    jQuery.ajax({
        url: lfb_data.ajaxurl,
        type: 'post',
        data: {
            action: 'lfb_getComponentMenu'
        },
        success: function (menu) {
            jQuery('#lfb_bootstraped').prepend(menu);


            jQuery('#lfb_componentsCloseBtn').on('click', function () {
                jQuery('#lfb_componentsPanel').removeClass('lfb_open');
            });

            jQuery('#estimation_popup').find('.genSlide .genContent > .lfb_row').sortable({
                connectWith: '.lfb_sortable',
                revert: 10,
                delay: 200,
                scroll: false,
                items: '.lfb_item',
                receive: function (e, ui) {       
                      jQuery('#lfb_rowMenu').removeClass('lfb_open');     
                    if (ui.sender.closest('.lfb_lPanelBodyContent').length > 0) {
                        lfb_renderComponent(ui.item, '');
                    } else {
                        ui.item.removeClass('col-md-12');                       
                            ui.item.addClass('col-md-2'); 
                        setTimeout(function () {
                            lfb_updateItemsSortOrder();
                        }, 100);
                    }
                    lfb_copyHelper = null;
                },
                start: function (e, ui) {
                    jQuery('#estimation_popup').addClass('lfb_draggingComponent');
                    ui.helper.css('background-color', jQuery('#mainPanel').css('background-color'));
                },
                over: function (event, ui) {

                },
                stop: function (event, ui) {
                    jQuery('#estimation_popup').removeClass('lfb_draggingComponent');
                        setTimeout(function () {
                            lfb_updateItemsSortOrder();
                        }, 100);


                },
                update: function (event, ui) {

                }
            }).disableSelection();

            jQuery('#lfb_componentsPanel .lfb_lPanelBodyContent').addClass('lfb_sortable').sortable({
                connectWith: '.lfb_sortable',
                revert: 10,
                delay: 200,
                scroll: false,
                appendTo: jQuery('#lfb_bootstraped'),
                items: '.lfb_item',
                forcePlaceholderSize: false,
                helper: function (e, li) {
                    lfb_copyHelper = li.clone().insertAfter(li);
                    return li.clone();
                },
                start: function (e, ui) {
                    lfb_isDraggingComponent = true;
                    ui.helper.css('background-color', jQuery('#mainPanel').css('background-color'));
                    jQuery('.lfb_tmpComponent').remove();
                    var tmpElement = jQuery('<div class="lfb_tmpComponent"></div>');
                },
                over: function (event, ui) {},
                stop: function (event, ui) {
                    lfb_copyHelper && lfb_copyHelper.remove();
                    lfb_isDraggingComponent = false;
                    jQuery('.lfb_tmpComponent').remove();       
                    if (ui.item.closest('#lfb_componentsPanel').length > 0) {
                        return false;
                    }
                },
                update: function (event, ui) {

                }
            }).disableSelection();

            jQuery('#lfb_componentsPanel').find('[data-toggle="switch"]').wrap('<div class="switch"  data-on-label="<i class=\'fui-check\'></i>" data-off-label="<i class=\'fui-cross\'></i>" />').parent().bootstrapSwitch();

            jQuery('#lfb_componentsPanel').find('[data-type="slider"]').slider({
                min: 0,
                max: 100,
                value: 50,
                step: 1,
                orientation: "horizontal",
                range: "min"
            });
            
            jQuery('#lfb_componentsPanel').find('.lfb_rate').rate({
                initial_value: 3
            }).css({
                color: '#bdc3c7'
            });


            jQuery('#lfb_componentsPanel #lfb_componentsFilters input.form-control').on('keyup change', function () {
                var start = jQuery(this).val().toLowerCase();
                jQuery('#lfb_componentsPanel .lfb_componentModel').each(function () {
                    if (jQuery(this).find('.lfb_componentTitle').text().toLowerCase().indexOf(start) > -1 || start.trim().length == 0) {
                        jQuery(this).show();
                    } else {
                        jQuery(this).hide();
                    }
                });
            });

            lfb_initRowMenu();

        }
    });

}
function lfb_editRow($item) {
    jQuery('#lfb_rowMenu').addClass('lfb_open');

    jQuery('#lfb_rowMenu table tbody').html('');
    var columns = JSON.parse($item.attr('data-columns'));
    for (var i = 0; i < columns.length; i++) {
        var column = columns[i];
        addColumnRow(column);

    }
}
function lfb_initNewItemContent($item) {

    $item.find('[data-toggle="switch"][data-checkboxstyle="switch"]').each(function () {
        if (jQuery(this).closest('.switch').length == 0) {
            jQuery(this).wrap('<div class="switch"  data-on-label="<i class=\'fui-check\'></i>" data-off-label="<i class=\'fui-cross\'></i>" />').parent().bootstrapSwitch();
        }
    });
    $item.find('.lfb_colorpicker').each(function () {
        var $this = jQuery(this);
        jQuery(this).prev('.lfb_colorPreview').click(function () {
            if (!tld_selectionMode) {
                jQuery(this).next('.lfb_colorpicker').trigger('click');
            }
        });
        jQuery(this).prev('.lfb_colorPreview').css({
            backgroundColor: form.colorA
        });
        jQuery(this).colpick({
            color: form.colorA,
            layout: 'hex',
            onSubmit: function () {
                jQuery('body > .colpick').fadeOut();
            },
            onChange: function (hsb, hex, rgb, el, bySetColor) {
                jQuery(el).val('#' + hex);
                jQuery(el).prev('.lfb_colorPreview').css({
                    backgroundColor: '#' + hex
                });
            }
        });
    });
    
     $item.find('img[data-tint="true"]').each(function () {
        jQuery(this).css('opacity', 0);
        jQuery(this).show();
        var $canvas = jQuery('<canvas class="img"></canvas>');
        $canvas.css({
            width: jQuery(this).get(0).width,
            height: jQuery(this).get(0).height
        });
        jQuery(this).hide();
        jQuery(this).after($canvas);
        var ctx = $canvas.get(0).getContext('2d');
        var img = new Image();
        img.onload = function () {
            ctx.fillStyle = form.colorA;
            ctx.fillRect(0, 0, $canvas.get(0).width, $canvas.get(0).height);
            ctx.fill();
            ctx.globalCompositeOperation = 'destination-in';
            ctx.drawImage(img, 0, 0, $canvas.get(0).width, $canvas.get(0).height);
        };
        if (jQuery(this).is('[data-lazy-src]')) {
            img.src = jQuery(this).attr('data-lazy-src');
        } else {
            img.src = jQuery(this).attr('src');
        }
    });

    $item.find('[data-type="slider"]:not(.ui-slider)').each(function () {

        var min = parseInt(jQuery(this).attr('data-min'));
        if (isNaN(min)) {
            min = 0;
        }
        var max = parseInt(jQuery(this).attr('data-max'));
        if (max == 0) {
            max = 30;
        }
        jQuery(this).slider({
            min: min,
            max: max,
            value: 0,
            step: 1,
            orientation: "horizontal",
            range: "min"
        });
    });


    $item.find('.lfb_rate').each(function () {
        if (jQuery(this).children().length == 0) {
            var max = parseInt(jQuery(this).closest('.itemBloc').attr('data-max'));
            var initialValue = parseInt(jQuery(this).closest('.itemBloc').attr('data-value'));
            if (isNaN(initialValue)) {
                initialValue = 5;
            }
            var color = '#bdc3c7';
            if (jQuery(this).closest('.itemBloc').attr('data-color') != '') {
                color = jQuery(this).closest('.itemBloc').attr('data-color');
            }
            if (color.indexOf('#') == -1) {
                color = '#' + color;
            }
            var stepSize = jQuery(this).closest('.itemBloc').attr('data-interval');
            jQuery(this).rate({
                initial_value: initialValue,
                max_value: max,
                step_size: 1
            }).css('color',color);
        }
    });


}

function lfb_initItemContent($item) {


    $item.find('.lfb_column').sortable({
        connectWith: '.lfb_sortable',
        revert: 10,
        delay: 200,
        scroll: false,
        items: '.lfb_item',
        start: function (e, ui) {
            jQuery('#estimation_popup').addClass('lfb_draggingComponent');
            ui.helper.css('background-color', jQuery('#mainPanel').css('background-color'));
        },
        over: function (event, ui) {},
        receive: function (e, ui) {
            lfb_copyHelper = null;  
            jQuery('#lfb_rowMenu').removeClass('lfb_open');
            if (ui.sender.closest('.lfb_lPanelBodyContent').length > 0) {

                lfb_renderComponent(ui.item, jQuery(this).attr('data-columnid'));
            } else {
             ui.item.removeClass('col-md-2');   
                setTimeout(function () {
                    lfb_updateItemsSortOrder();
                }, 100);
            }
        },
        stop: function (event, ui) {
             
             if(jQuery(this).is('.lfb_column')){
                 ui.item.removeClass('col-md-2');                   
             } else{
                 ui.item.removeClass('col-md-12');  
                 ui.item.addClass('col-md-2');                   
             }
            jQuery('#estimation_popup').removeClass('lfb_draggingComponent');
        },
        update: function (event, ui) {
        }
    }).disableSelection();
}
function lfb_initItemToolbar($item) {
    var tb = jQuery('<div class="lfb_elementToolbar"></div>');
    tb.append('<a href="javascript:" class="btn-primary lfb-handler"><span class="fas fa-arrows-alt" data-tooltip="true"  data-placement="bottom" title="' + lfb_data.texts['move'] + '"></span></a>');
    tb.append('<a href="javascript:" data-action="edit" class="btn-default"><span class="fas fa-pencil-alt" data-tooltip="true"  data-placement="bottom" title="' + lfb_data.texts['edit'] + '"></span></a>');
    if (/*lfb_currentStepID > 0 &&*/ !$item.is('.lfb_row')) {
        tb.append('<a href="javascript:" data-action="duplicate" class="btn-default"><span class="fas fa-copy" data-tooltip="true"  data-placement="bottom" title="' + lfb_data.texts['duplicate'] + '"></span></a>');
    }
    tb.append('<a href="javascript:" data-action="style" class="btn-default"><span class="fas fa-magic" data-tooltip="true"  data-placement="bottom" title="' + lfb_data.texts['style'] + '"></span></a>');

    tb.append('<a href="javascript:" data-action="delete" class="btn-danger"><span class="fas fa-trash" data-tooltip="true"  data-placement="bottom" title="' + lfb_data.texts['remove'] + '"></span></a>');
    tb.find('[data-action="edit"]').click(function () {
        lfb_editedItem = jQuery(this).closest('.lfb_item');
        if (jQuery(this).closest('.lfb_item').attr('data-itemtype') == 'row') {
            lfb_editRow($item);
        } else {
            window.parent.lfb_editItem(jQuery(this).closest('.lfb_item').attr('data-id'));
        }
    });
   tb.find('[data-action="style"]').click(function () {
        var domElement = '.lfb_item[data-id="'+$item.attr('data-id')+'"]';
        var targetStep = lfb_currentStepID;
        if(targetStep == 0){
            targetStep = 'final';
        }
        window.parent.lfb_openFormDesigner(targetStep,domElement);
    });
    tb.find('[data-action="duplicate"]').click(function () {
        window.parent.lfb_duplicateItem(jQuery(this).closest('.lfb_item').attr('data-id'));
    });
    tb.find('[data-action="delete"]').click(function () {
        window.parent.lfb_askDeleteItem(jQuery(this).closest('.lfb_item').attr('data-id'));
    
    });

    $item.prepend(tb);
    $item.hover(function () {
        clearTimeout(lfb_elementHoverTimer);
        var chkChildrenhover = false;
        jQuery(this).find('.lfb_item').each(function () {
            if (jQuery(this).is(':hover')) {
                chkChildrenhover = true;
            }
        });
        if ((lfb_isDraggingComponent && jQuery(this).find('.lfb-column-inner.lfb_hoverEdit').length > 0) || (!lfb_isDraggingComponent && jQuery(this).find('.lfb-column-inner:hover').length > 0)) {
            chkChildrenhover = true;
        }
        if (!chkChildrenhover) {
            jQuery('.lfb_hoverEdit').removeClass('lfb_hoverEdit');
            jQuery(this).addClass('lfb_hover');
            jQuery(this).addClass('lfb_hoverEdit');
        } else {
            jQuery(this).removeClass('lfb_hover');
            jQuery(this).removeClass('lfb_hoverEdit');
        }
        var _self = jQuery(this);
        jQuery(this).parent().closest('.lfb_item ').removeClass('lfb_hover');
    }, function () {
        var _self = jQuery(this);
        _self.removeClass('lfb_hover');
        _self.children('.lfb_hover').removeClass('lfb_hover');
        lfb_elementHoverTimer = setTimeout(function () {
            _self.removeClass('lfb_hoverEdit');
            _self.children('.lfb_hoverEdit').removeClass('lfb_hoverEdit');
        }, 500);
        if (jQuery(this).closest('.lfb_item :hover').length > 0) {
            jQuery(this).closest('.lfb_item :hover').trigger('mouseenter');
        }
    });
    $item.prepend('<div class="lfb_itemLoader"><div class="lfb_spinner" data-tldinit="true"><div class="double-bounce1" data-tldinit="true"></div><div class="double-bounce2" data-tldinit="true"></div></div></div>');
    $item.find('.lfb_itemLoader').show().fadeOut(500);

}

function lfb_onItemDeleted(itemID){
    if(jQuery('.lfb_item[data-id="'+itemID+'"]').length > 0){
        var $item = jQuery('.lfb_item[data-id="'+itemID+'"]');
        $item.remove();
         if (lfb_editedItem && lfb_editedItem.attr('data-id') == itemID) {
            jQuery('#lfb_rowMenuCloseBtn').trigger('click');
        }
    }
}

function lfb_renderComponent($component, columnID) {
    var index = $component.index();
    $component.prepend('<div class="lfb_itemLoader"><div class="lfb_spinner" data-tldinit="true"><div class="double-bounce1" data-tldinit="true"></div><div class="double-bounce2" data-tldinit="true"></div></div></div>');
    $component.find('.lfb_itemLoader').show();

    var $content = jQuery('<div class="lfb_elementContent"></div>');

    var type = $component.attr('data-component');
    var title = lfb_data.texts['Item'];
    if (jQuery('#lfb_componentsPanel .lfb_componentModel[data-component="' + type + '"] .lfb_componentTitle').length > 0) {
        title = jQuery('#lfb_componentsPanel .lfb_componentModel[data-component="' + type + '"] .lfb_componentTitle').text();
    }

    jQuery.ajax({
        url: lfb_data.ajaxurl,
        type: 'post',
        data: {
            action: 'lfb_createNewItem',
            formID: jQuery('#estimation_popup').attr('data-form'),
            stepID: jQuery('.genSlide.lfb_activeStep').attr('data-stepid'),
            title: title,
            type: type,
            columnID: columnID,
            index: index
        },
        success: function (rep) {
            rep = JSON.parse(rep);

            var itemData = rep.itemData;

            window.parent.lfb_newItemAdded(itemData);

            $item = jQuery(rep.itemDom);
            $component.after($item);
            lfb_initItemToolbar($item);
            lfb_initNewItemContent($item);
            lfb_initItemContent($item);
            $component.remove();

            lfb_updateItemsSortOrder();

        }
    });
}

function lfb_showComponentsMenu() {
    jQuery('#lfb_componentsFilters input').val('').trigger('keyup');
    jQuery('#lfb_componentsFilters input').focus();
    jQuery('#lfb_componentsPanel').addClass('lfb_open');
}