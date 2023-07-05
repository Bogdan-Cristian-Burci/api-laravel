<?php

return [

    /*
     * USER
     * username for smartbill application account
     */

    'user'=>env('SMART_BILL_USER',''),

    /*
     * Token
     * Token used in smartbill account
     */

    'token'=>env('SMART_BILL_TOKEN',''),

    /*
     * VAT Code
     *
     * Company vat code registered in Smartbill account
     */

    'vat_code'=>env('SMART_BILL_VAT_CODE',''),

    /*
     * Series allocated from Smartbill account for the services sold through this api
     */
    'series'=>env('SMART_BILL_SERIES','Test'),

    /*
     * Due date
     * Number of days starting from the bill date to the required payed date
     */

    'due_date'=>env('SMART_BILL_DUE_DATE_DAYS',14),

    /*
     * Currency
     * Currency used on bills
     */
    'currency'=>env('SMART_BILL_CURRENCY','RON'),

    /*
     * Tax included
     * Set if the taxes are included for service price
     */

    'tax_included'=>env('SMART_BILL_TAX_INCLUDED',false),

    /*
     * Tax percentage
     * Tax percentage value applied to service prices
     */

    'tax_percentage'=>env('SMART_BILL_TAX_PERCENTAGE',19),

    /*
     * Is Service
     * Set if the sold products are services or not
     */

    'is_service'=>env('SMART_BILL_IS_SERVICE',true),

    /*
     *
     * Email
     */

    'email_to'=>env('SMART_BILL_EMAIL_TO',''),
    'email_cc'=>env('SMART_BILL_EMAIL_CC',''),

];
