/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'jquery',
    'Magento_Ui/js/form/element/file-uploader',
    'Magento_Checkout/js/model/quote',
    'Magento_Checkout/js/checkout-data',
    'mage/validation'
], function ($, Element, quote, checkout, spinner) {
    'use strict';
    
    return Element.extend({
        defaults: {
            fileInputName: '',
            template: 'Sintra_POEmailAttachment/components/file-uploader'

        },
        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe('purchaseOrderNumber');

            return this;
        },

        /**
         * Load start event handler.
         */
        onLoadingStart: function () {
            $('.file-uploader-spinner').show();
            this.isLoading = true;
        },

        /**
         * Load stop event handler.
         */
        onLoadingStop: function () {
            $('.file-uploader-spinner').hide();
            this.isLoading = false;
            if($('.file-uploader-filename').hasClass('error')){
                $('.file-uploader-filename').removeClass('error');
            }
            $('.file-uploader .error').hide();
        },
        /**
         * Adds provided file to the files list.
         *
         * @param {Object} file
         * @returns {FileUploder} Chainable.
         */
        addFile: function (file) {
            var processedFile = this.processFile(file),
                tmpFile = [],
                resultFile = {
                'file': processedFile.file,
                'name': processedFile.name,
                'size': processedFile.size,
                'status': processedFile.status ? processedFile.status : 'new'
            };

            tmpFile[0] = resultFile;

            this.isMultipleFiles ?
                this.value.push(tmpFile) :
                this.value(tmpFile);

            return this;
        },
        onBeforeFileUpload: function (e, data) {
            var file     = data.files[0],
                allowed  = this.isFileAllowed(file),
                target   = $(e.target);
            if (allowed.passed) {
                target.on('fileuploadsend', function (event, postData) {
                    postData.data.append('param_name', this.paramName);
                }.bind(data));

                target.fileupload('process', data).done(function () {
                    data.submit();
                });
            } else {
                this.notifyError(allowed.message);
            }
        }
    });
});
