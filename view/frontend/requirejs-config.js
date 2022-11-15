/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            mageChimpZipChecker:       'MageChimp_CheckoutBlocker/js/zip-code-checker'
        }
    },
    config: {
        mixins:{
            'Magento_Checkout/js/view/payment/default':{
                'MageChimp_CheckoutBlocker/js/view/payment/default-mixin':true
            }
        }
    }

};
