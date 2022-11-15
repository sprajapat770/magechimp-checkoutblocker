/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery'
], function ($) {
    'use strict';

    return function (config){
        var form = $('#zip-checker-form');
        var messageBlock = $('.zip-checker-message');
        $('#zip-checker-form button[type="submit"]').on('click',function (e){
            e.preventDefault();
            var formData = new FormData(form[0]);
            $.ajax({
                showLoader: true,
                url: form.attr('action'),
                data: formData,
                dataType: 'json',
                type: "post",
                cache: false,
                contentType: false,
                processData: false,
            }).done(function (res) {
                messageBlock.empty();
                messageBlock.html(res.message);
            }).error(function (res){
                //console.log('error',res.message)
            });
        });
    }
});
