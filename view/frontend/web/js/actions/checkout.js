
define([
    'jquery',
    'Magestat_FacebookPixel/js/pixel-code'
], function ($) {
    'use strict';

    /**
     * Dispatch checkout detail event to Facebook Pixel
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

        fbq('track', 'InitiateCheckout', {
            content_ids: data.contentIds,
            content_type: 'product',
            contents: data.contents,
            currency: data.currency,
            num_items: data.qty,
            value: data.total
        });
    };
});
