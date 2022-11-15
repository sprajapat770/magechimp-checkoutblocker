define(['jquery',
        'Magento_Checkout/js/model/quote',
        'mage/url',
        'Magento_Ui/js/model/messageList'],
    function ($,quote,urlBuilder,messageList) {
        'use strict';
        return function (target) {

            return target.extend({


                /**
                 * Place order.
                 */
                placeOrder: function (data, event) {
                    var self = this;
                    var shippingAddress = quote.shippingAddress();
                    if (shippingAddress){
                        var postCode = shippingAddress.postcode;
                        $.ajax({
                            showLoader: true,
                            url: urlBuilder.build('magechimp/ajax/zipchecker'),
                            data: {
                                'zip_code': postCode,
                                'is_checkout': true,
                            },
                            dataType: 'json',
                            type: "post",
                            cache: false,
                        }).success(function (res) {
                            if (!res.error){
                                self._super();
                            }else {
                                messageList.addErrorMessage({ message: res.message });
                            }
                        }).error(function (res){
                            if (res.error){
                                messageList.addErrorMessage({ message: res.message });
                            }
                        });
                    }else{
                        this._super();
                    }
                },
            })
        };

    });
