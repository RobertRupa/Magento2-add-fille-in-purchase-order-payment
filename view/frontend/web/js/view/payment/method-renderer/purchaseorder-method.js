/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* @api */
define([
    'Magento_Checkout/js/view/payment/default',
    'jquery',
    'Magento_Checkout/js/action/select-payment-method',
    'Magento_Checkout/js/checkout-data',
    'mage/validation'
], function (Component, $, selectPaymentMethodAction, checkoutData) {
    'use strict';
    
    return Component.extend({
        defaults: {
            template: 'Magento_OfflinePayments/payment/purchaseorder-form',
            purchaseOrderNumber: ''
        },
        /**
         * @return {Boolean}
         */
        selectPaymentMethod: function () {
            selectPaymentMethodAction(this.getData());
            checkoutData.setSelectedPaymentMethod(this.item.method);
            $( "div[name='PoAttachmentForm.upload']" ).insertAfter( $(".field.field-number.required").parent() );
            $( "div[name='PoAttachmentForm.upload']" ).show();
            return true;
        },
        
        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe('purchaseOrderNumber');

            return this;
        },

        /**
         * @return {Object}
         */
        getData: function () {
            return {
                method: this.item.method,
                'po_number': this.purchaseOrderNumber(),
                'additional_data': null
            };
        },

        /**
         * @return {jQuery}
         */
        validate: function () {
            var form = 'form[data-role=purchaseorder-form]';
            if($( "div[name='PoAttachmentForm.upload']" ).hasClass('_required')){
                if(!$('.file-uploader-filename').length){
                    if(!$('.file-uploader-filename').hasClass('error')){
                        $('.file-uploader-filename').addClass('error');
                    }
                    $('.file-uploader .error').show();
                    return false;
                } else {
                    if($('.file-uploader-filename').hasClass('error')){
                        $('.file-uploader-filename').removeClass('error');
                    }
                    $('.file-uploader .error').hide();
                }
            }
            return $(form).validation() && $(form).validation('isValid');
        }
    });
});
