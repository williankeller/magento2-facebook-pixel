/**
 * A Magento 2 module named Magestat/FacebookPixel
 * Copyright (C) 2019 Magestat
 *
 * This file included in Magestat/FacebookPixel is licensed under OSL 3.0
 *
 * http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * Please see LICENSE.txt for the full text of the OSL 3.0 license
 */

define([
    'jquery',
    'Magestat_FacebookPixel/js/pixel-code'
], function ($) {
    'use strict';

    /**
     * Dispatch checkout success event to Facebook Pixel
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

        fbq('track', 'Purchase', {
            value: data.contents.price,
            currency: data.currency,
            contents: data.contents,
            content_type: 'product'
        });
    };
});
