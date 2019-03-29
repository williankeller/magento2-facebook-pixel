define([
    'jquery',
    'jquery/ui'
], function($) {
    'use strict';

    $('.tocart-form', '#product_addtocart_form').submit(function () {
        fbq('track', 'AddToCart');
    })
});