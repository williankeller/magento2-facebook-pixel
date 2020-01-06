
define([
    'jquery',
    'Magestat_FacebookPixel/js/pixel-code'
], function ($) {
    'use strict';

    /**
     * Dispatch product detail event to Facebook Pixel
     *
     * @param {Object} data - product data
     *
     * @private
     */
    return function (data) {
        // Avoid errors if "fbq" don't exist.
        if (typeof fbq !== 'function') {
            return;
        }
        fbq('track', 'ViewContent', {
            content_ids: data.contents.id,
            content_name: data.contents.name,
            value: data.contents.item_price,
            currency: data.currency,
            content_type: 'product'
        });
        $('#product-addtocart-button').on('click', function () {
            fbq('track', 'AddToCart', {
                content_ids: data.contents.id,
                content_name: data.contents.name,
                value: data.contents.item_price,
                currency: data.currency,
                content_type: 'product'
            });
        });
    };
});
