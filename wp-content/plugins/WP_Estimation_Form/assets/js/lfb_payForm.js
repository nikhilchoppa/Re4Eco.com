
jQuery(window).on('load', function () {
    lfb_initPayForm();
});

function lfb_initPayForm() {
    lfb_dataPay.razorpayReady = false;
    jQuery('html,body').css({
        overflow: 'hidden'
    });
    var content = jQuery('<div id="lfb_bootstraped" class="lfb_bootstraped lfb_payForm"></div>');
    content.append('<div id="estimation_popup" data-form="' + lfb_dataPay.formID + '" class="wpe_bootstraped  wpe_fullscreen"><div id="mainPanel" style="display: block !important;"><div id="lfb_summary"></div></div></div>');
    jQuery('body').append(content);
    jQuery('#estimation_popup').append(
            '<div id="lfb_stripeModal" class="modal">'
            + '<div class="modal-dialog">'
            + '<div class="modal-content">'
            + '<div class="modal-header">'
            + '<span class="fab fa-cc-stripe"></span><span>' + lfb_dataPay.txt_stripe_title + '</span>'
            + '<a href="javascript:" class="close" data-dismiss="modal" aria-label="Close"><span class="fas fa-times"></span></a>'
            + '</div>'
            + ' <div class="modal-body p-0">'
            + '<div data-panel="form" class="p-2">'
            + '<div class="lfb_amountTextContainer" class="p-2 mb-3 "><div class="m-0 lfb_amountText text-center pb-2">' + lfb_dataPay.txt_stripe_btnPay + ' :<br/> <strong data-info="amount">$5</strong></div></div>'
            + '<form action="/charge" method="post" id="lfb_stripePaymentForm" class="pl-4 pr-4 pt-3" >'
            + '<div class="form-group"><div id="lfb_stripe_card-element" class="form-control"></div></div>'
            + '<div id="lfb_stripe_card-error"></div>'
            + '<div class="form-group"><input placeholder="' + lfb_dataPay.txt_stripe_cardOwnerLabel + '" name="ownerName" class="form-control" type="text"/></div>'
            + '</form>'
            + '<div class="text-center lfb_stripeLogoContainer"><img class="lfb_stripeLogo" src="' + lfb_dataPay.assets_url + 'img/powered_by_stripe@2x.png" alt="Powered by Stripe" /></div>'
            + '</div>'   // eof [data-panel="form"]
            + '<div data-panel="loading">'
            + '<div class=" text-center">'
            + '<span class="fas fa-hourglass-half big"></span>'
            + '</div>'   // eof +bg-success
            + '</div>'   // eof [data-panel="success"]

            + '<div data-panel="fail">'
            + '<div class="text-center">'
            + '<p><span class="fas fa-times big"></span></p>'
            + '<div>' + lfb_dataPay.txt_stripe_paymentFail + '</div>'
            + '<div data-info="error" class="text-center"></div>'
            + '</div>'   // eof +bg-danger
            + '</div>'   // eof [data-panel="danger"]
            + '</div>'   // eof +modal-body
            + '<div class="modal-footer">'
            + '<a href="javascript:" data-action="pay"  class="btn btn-primary"><span class="fas fa-check"></span>' + lfb_dataPay.txt_stripe_btnPay + '</a>'
            + '</div>' // eof+modal-footer
            + '</div>'  // eof +modal-content
            + '</div>'  // eof +modal-dialog
            + '</div>' // eof lfb_stripeModal
            );

    if (lfb_dataPay.key != "") {
        jQuery.ajax({
            url: lfb_dataPay.ajaxurl,
            type: 'post',
            data: {
                action: 'lfb_getFormToPay',
                key: lfb_dataPay.key
            },
            success: function (rep) {
                if (rep.length < 5) {
                    jQuery('#lfb_bootstraped.lfb_payForm').remove();
                    document.location.href = lfb_dataPay.homeUrl;
                } else {
                    content.find('#lfb_summary').html(rep);
                    content.find('#lfb_summary table').parent().css({
                        paddingLeft: 0,
                        paddingRight: 0
                    });
                    content.find('#lfb_summary').find('[bgcolor]').each(function () {
                        jQuery(this).css({
                            backgroundColor: jQuery(this).attr('bgcolor')
                        });
                    });
                    content.find('#lfb_summary').find('[width]').each(function () {
                        jQuery(this).css({
                            width: jQuery(this).attr('width')
                        });
                    });
                    if (content.find('#lfb_summary table').attr('border') != "0") {
                        content.find('#lfb_summary table').find('th,td').css({
                            border: '1px solid ' + content.find('#lfb_summary table').attr('bordercolor')
                        });
                    }
                    lfb_initPayment();
                }
            }
        });
    }
}

function lfb_initPayment() {

    if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_paymentMethodBtns').length > 0) {
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_paymentMethodBtns [data-payment="paypal"]').click(function () {
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_stripeForm').slideUp();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #btnOrderPaypal').trigger('click');
        });
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_paymentMethodBtns [data-payment="stripe"]').click(function () {
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_stripeForm').slideDown();
        });
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_paymentMethodBtns [data-payment="razorpay"]').click(function () {
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_stripeForm').slideUp();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #btnOrderRazorpay').trigger('click');

        });

        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_stripeForm').hide();
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_razorPayCt').hide();
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #btnOrderPaypal').hide();
    }

    if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_stripeForm').length > 0) {
        Stripe.setPublishableKey(lfb_dataPay.stripePubKey);
    }



    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #btnOrderRazorpay').click(function () {
        lfb_dataPay.useRazorpay = true;

        var singleCost = lfb_dataPay.total;
        var subCost = lfb_dataPay.totalSub;


        jQuery.ajax({
            url: lfb_dataPay.ajaxurl,
            type: 'post',
            data: {
                action: 'lfb_makeRazorPayment',
                formID: lfb_dataPay.formID,
                singleCost: singleCost,
                subCost: subCost,
                ref: lfb_dataPay.ref,
                email: lfb_dataPay.email
            },
            success: function (rep) {
                if (rep.trim().indexOf('error') == -1) {
                    var orderID = rep.trim();

                    var options = {
                        "key": lfb_dataPay.razorpay_publishKey,
                        "name": lfb_dataPay.formTitle,
                        "description": "",
                        "image": lfb_dataPay.razorpay_logoImg,
                        "handler": function (response) {
                            lfb_dataPay.razorpayReady = true;
                            lfb_validOrder(lfb_dataPay.formID);
                        },
                        "prefill": {
                            // "name": lfb_dataPay.customerName,
                            "email": lfb_dataPay.email
                        },
                        "theme": {
                            "color": lfb_dataPay.colorA
                        }
                    };
                    if (orderID.indexOf('sub_') == 0) {
                        options.subscription_id = orderID;
                    } else {
                        options.order_id = orderID;
                    }
                    var rzp1 = new Razorpay(options);
                    rzp1.open();

                } else {
                    alert(rep);
                }
            }
        });
    });


    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #lfb_btnPayStripe').click(function () {
        lfb_showWinStripePayment(lfb_dataPay);
    });

    lfb_initPaypalForm();
}

function lfb_stripeResponsePay(status, response, formID) {
    var $form = jQuery('#estimation_popup.wpe_bootstraped[data-form="' + formID + '"] #lfb_stripeForm');
    if (response.error) {
        $form.find('.payment-errors').text(response.error.message);
        $form.find('.btn').prop('disabled', false);
    } else {
        var token = response.id;
        if ($form.find('[name="stripeToken"]').length == 0) {
            $form.append(jQuery('<input type="hidden" name="stripeToken">').val(token));
            Stripe.card.createToken(jQuery('#estimation_popup.wpe_bootstraped[data-form="' + formID + '"] #lfb_stripeForm'), function (statusB, responseB) {
                lfb_stripeResponsePay(statusB, responseB, formID);
            });
        } else if ($form.find('[name="stripeTokenB"]').length == 0) {
            $form.append(jQuery('<input type="hidden" name="stripeTokenB">').val(token));
            lfb_validOrder(lfb_dataPay.formID);
        }
    }
}

function lfb_initPaypalForm() {

    if (jQuery('#wtmt_paypalForm').length > 0) {

        jQuery('#btnOrderPaypal').click(function () {
            jQuery('#wtmt_paypalForm [name="submit"]').trigger('click');
        });

        var payPrice = lfb_dataPay.total;
        payPrice = parseFloat(payPrice) * (parseFloat(lfb_dataPay.percentToPay) / 100);
        payPrice = parseFloat(payPrice).toFixed(2);
        if (lfb_dataPay.totalSub > 0) {
            if (lfb_dataPay.total > 0) {
                var payPriceSingle = parseFloat(lfb_dataPay.total) * (parseFloat(lfb_dataPay.percentToPay) / 100);
                payPriceSingle = parseFloat(payPriceSingle).toFixed(2);
                if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a1]').length == 0) {
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm').append('<input type="hidden" name="a1" value="0"/>');
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm').append('<input type="hidden" name="p1" value="1"/>');
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm').append('<input type="hidden" name="t1" value="M"/>');
                }
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a1]').val(lfb_dataPay.total);
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a3]').val(lfb_dataPay.totalSub);
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p1]').val(jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p3]').val());

                if (payPrice <= 0) {
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=cmd]').val('_xclick');
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a3]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=t3]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p3]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=bn]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=no_note]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=src]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a1]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=t1]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p1]').remove();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm').append('<input type="hidden" name="amount" value="' + lfb_dataPay.total + '"/>');
                }
            } else {
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a1]').remove();
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=t1]').remove();
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p1]').remove();
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=amount]').val(lfb_dataPay.totalSub);
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a3]').val(lfb_dataPay.totalSub);
            }
        } else {
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=cmd]').val('_xclick');
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a3]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=t3]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p3]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=bn]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=no_note]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=src]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=a1]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=t1]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=p1]').remove();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=amount]').val(payPrice);
            //  jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm').append('<input type="hidden" name="amount" value="' + lfb_dataPay.total + '"/>');

        }

        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=return]').val(lfb_dataPay.finalUrl);
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=custom]').val(lfb_dataPay.ref);
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] #wtmt_paypalForm [name=item_number]').val(lfb_dataPay.ref);
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.ref + '"] #wtmt_paypalForm [name=item_name]').val(jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.ref + '"] #wtmt_paypalForm [name=item_name]').val() + ' - ' + lfb_dataPay.ref);
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.ref + '"] #wtmt_paypalForm [type="submit"]').trigger('click');
    }
}

function lfb_validOrder(formID) {
    var stripeToken = '';
    if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] [name="stripeToken"]').length > 0) {
        stripeToken = jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] [name="stripeToken"]').val();
    }
    var stripeTokenB = '';
    if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] [name="stripeTokenB"]').length > 0) {
        stripeTokenB = jQuery('#estimation_popup.wpe_bootstraped[data-form="' + lfb_dataPay.formID + '"] [name="stripeTokenB"]').val();
    }


    jQuery.ajax({
        url: lfb_dataPay.ajaxurl,
        type: 'post',
        data: {
            action: 'lfb_validPayForm',
            formID: lfb_dataPay.formID,
            orderKey: lfb_dataPay.key,            
            stripeCustomerID: lfb_dataPay.stripeCustomerID,
            stripeToken: lfb_dataPay.stripeToken,
            stripeSrc: lfb_dataPay.stripeSrc,
            stripeToken: stripeToken,
            razorpayReady: lfb_dataPay.razorpayReady
        },
        success: function (rep) {
            jQuery('#estimation_popup #mainPanel').prepend('<h2 style="display:none;" id="lfb_payFormFinalTxt">' + lfb_dataPay.finalText + '</h2>');
            jQuery('#estimation_popup #mainPanel #lfb_summary').fadeOut();
            setTimeout(function () {
                jQuery('#estimation_popup #mainPanel #lfb_payFormFinalTxt').fadeIn();
                setTimeout(function () {
                    if (lfb_dataPay.finalUrl != "" && lfb_dataPay.finalUrl != "#" && lfb_dataPay.finalUrl != " ") {
                        document.location.href = lfb_dataPay.finalUrl;
                    }
                }, lfb_dataPay.redirectionDelay * 1000);
            }, 300);
        }
    });

}

function wpe_formatPrice(price, form) {
    if (!price) {
        price = 0;
    }
    var formID = form.formID;
    var formatedPrice = price.toString();
    if (formatedPrice.indexOf('.') > -1) {
        formatedPrice = parseFloat(price).toFixed(2).toString();
    }
   // var form = wpe_getForm(formID);
    if (form.summary_noDecimals == '1') {
        formatedPrice = Math.round(formatedPrice).toString();
    }
    var decSep = form.decimalsSeparator;
    var thousSep = form.thousandsSeparator;
    var priceNoDecimals = formatedPrice;
    var millionSep = form.millionSeparator;
    var billionSep = form.billionsSeparator;
    var decimals = "";
    if (formatedPrice.indexOf('.') > -1) {
        priceNoDecimals = formatedPrice.substr(0, formatedPrice.indexOf('.'));
        decimals = formatedPrice.substr(formatedPrice.indexOf('.') + 1, 2);
        formatedPrice = formatedPrice.replace('.', form.decimalsSeparator);
        if (decimals.toString().length == 1) {
            decimals = decimals.toString() + '0';
        }
        if (priceNoDecimals.length > 9) {
            formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 9) + billionSep + priceNoDecimals.substr(priceNoDecimals.length - 9, 3) + millionSep + priceNoDecimals.substr(priceNoDecimals.length - 6, 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length) + form.decimalsSeparator + decimals;
        } else if (priceNoDecimals.length > 6) {
            formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 6) + millionSep + priceNoDecimals.substr(priceNoDecimals.length - 6, 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length) + form.decimalsSeparator + decimals;
        } else if (priceNoDecimals.length > 3) {
            formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length) + form.decimalsSeparator + decimals;
        }
    } else {
        if (priceNoDecimals.length > 9) {
            formatedPrice = formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 9) + billionSep + priceNoDecimals.substr(priceNoDecimals.length - 9, 3) + millionSep + priceNoDecimals.substr(priceNoDecimals.length - 6, 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length);
        } else if (priceNoDecimals.length > 6) {
            formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 6) + millionSep + priceNoDecimals.substr(priceNoDecimals.length - 6, 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length);
        } else if (priceNoDecimals.length > 3) {
            formatedPrice = priceNoDecimals.substr(0, priceNoDecimals.length - 3) + thousSep + priceNoDecimals.substr(priceNoDecimals.length - 3, priceNoDecimals.length);
        }
    }
    return formatedPrice;

}
function lfb_formatPriceWithCurrency(price, form) {
    price = wpe_formatPrice(price, form);
    if (form.currencyPosition == 'left') {
        price = form.currency + price;
    } else {
        price += form.currency;
    }
    return price;
}
function lfb_showWinStripePayment(form) {
    
    var singleTotal = parseFloat(form.total);
    var subTotal = form.totalSub;

    if (form.price == 0 && form.priceSingle == 0) {
        lfb_validOrder(form.formID);
    } else {
        //
        //
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-info="amount"]').html(lfb_dataPay.totalText);
        //jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-info="amount"]').html(jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #finalPrice').html());
        
        if (form.payMode == 'percent') {
                    singleTotal = parseFloat(singleTotal) * (parseFloat(form.percentToPay) / 100);
                    var amountToShow = '<span>' + lfb_formatPriceWithCurrency(singleTotal, form) + '</span>';
                 jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-info="amount"]').html(amountToShow);

                } else if (form.payMode == 'fixed') {
                    singleTotal = parseFloat(form.fixedToPay);
                    var amountToShow = '<span>' + lfb_formatPriceWithCurrency(singleTotal, form) + '</span>';
                 jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-info="amount"]').html(amountToShow);
                }

        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="loading"]').show();
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal .modal-footer').hide();
        lfb_stripe = Stripe(form.stripePubKey);
        if (typeof (form.stripeToken) == 'undefined') {


            jQuery.ajax({
                url: form.ajaxurl,
                type: 'post',
                data: {
                    action: 'lfb_getStripePaymentIntent',
                    singleTotal: singleTotal,
                    subTotal: subTotal,
                    formID: form.formID,
                    customerInfos: form.contactInformations
                },
                success: function (rep) {
                    rep = JSON.parse(rep);
                    form.stripeToken = rep.token;
                    form.stripeCustomerID = rep.customerID;

                    var elements = lfb_stripe.elements();
                    cardElement = elements.create('card');
                    cardElement.mount('#lfb_stripe_card-element');

                    cardElement.addEventListener('change', function (event) {
                        if (event.error) {
                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripe_card-error').html(event.error.message);
                        } else {
                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripe_card-error').html('');
                        }
                    });
                    form.cardElement = cardElement;
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="form"]').show();
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal .modal-footer').slideDown();

                }
            });
        } else {
            var elements = lfb_stripe.elements();
            cardElement = elements.create('card');
            cardElement.mount('#lfb_stripe_card-element');
            cardElement.addEventListener('change', function (event) {
                if (event.error) {
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripe_card-error').html(event.error.message);
                } else {
                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripe_card-error').html('');
                }
            });
            form.cardElement = cardElement;
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="form"]').show();
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal .modal-footer').slideDown();
        }
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal a[data-action="pay"]').unbind('click');
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal a[data-action="pay"]').click(function () {
            var error = false;
            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal .has-error').removeClass('has-error');
            if (jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').val().length < 3) {
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').closest('.form-group').addClass('has-error');
                error = true;
            }
            if (!error) {
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="loading"]').show();
                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal .modal-footer').hide();

                lfb_stripe.createSource(form.cardElement).then(function (result) {
                    if (result.error) {
                        // Inform the user if there was an error                      
                        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] [data-info="error"]').html(result.error.message);
                        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="fail"]').show();
                    } else {
                        // Send the source to your server
                        // stripeSourceHandler(result.source);
                        form.stripeSrc = result.source.id;

                        if (subTotal > 0) {
                            jQuery.ajax({
                                url: form.ajaxurl,
                                type: 'post',
                                data: {
                                    action: 'lfb_processStripeSubscription',
                                    formID: form.formID,
                                    stripeSrc: form.stripeSrc,
                                    customerID: form.stripeCustomerID,
                                    singleTotal: singleTotal,
                                    subTotal: subTotal
                                },
                                success: function (rep) {
                                    rep = rep.trim();
                                    if (rep == 1) {

                                        if (singleTotal > 0) {
                                            lfb_stripe.handleCardPayment(
                                                    form.stripeToken, form.cardElement, {
                                                        payment_method_data: {
                                                            billing_details: {name: jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').val()}
                                                        }
                                                    }
                                            ).then(function (result) {
                                                if (result.error) {
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] [data-info="error"]').html(result.error);
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="fail"]').show();
                                                } else {
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                                    lfb_validOrder(form.formID);
                                                }
                                            });
                                        } else {
                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                            lfb_validOrder(form.formID);
                                        }

                                    } else if (rep.indexOf('pi_') > -1) {
                                        lfb_stripe.handleCardPayment(
                                                rep, form.cardElement, {
                                                    payment_method_data: {
                                                        billing_details: {name: jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').val()}
                                                    }
                                                }
                                        ).then(function (result) {
                                            if (result.error) {
                                                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] [data-info="error"]').html(result.error);
                                                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                                                jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="fail"]').show();
                                            } else {
                                                if (singleTotal > 0) {
                                                    lfb_stripe.handleCardPayment(
                                                            form.stripeToken, form.cardElement, {
                                                                payment_method_data: {
                                                                    billing_details: {name: jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').val()}
                                                                }
                                                            }
                                                    ).then(function (result) {
                                                        if (result.error) {
                                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] [data-info="error"]').html(result.error);
                                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="fail"]').show();
                                                        } else {
                                                            jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                                            lfb_validOrder(form.formID);
                                                        }
                                                    });
                                                } else {
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                                    lfb_validOrder(form.formID);
                                                }
                                            }

                                        });
                                    }
                                }
                            });
                        } else {
                            lfb_stripe.handleCardPayment(
                                    form.stripeToken, form.cardElement, {
                                        payment_method_data: {
                                            billing_details: {name: jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] #lfb_stripeModal [name="ownerName"]').val()}
                                        }
                                    }
                            ).then(function (result) {
                                if (result.error) {
                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"] [data-info="error"]').html(result.error);
                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel]').hide();
                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal [data-panel="fail"]').show();
                                } else {
                                    jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('hide');
                                    lfb_validOrder(form.formID);
                                }
                            });
                        }


                    }
                });


            }
        });
        jQuery('#estimation_popup.wpe_bootstraped[data-form="' + form.formID + '"]').find('#lfb_stripeModal').modal('show');
    }
}