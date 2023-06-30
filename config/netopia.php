<?php

 return[

     /*
      * SIGNATURE
      * Netopia signature for you commercial account
      */

     'signature'=>env('NETOPIA_SIGNATURE',''),

     /*
      * URL
      * Netopia url that will be used , by default is the test oen set
      */

     'url' => env('NETOPIA_URL', 'http://sandboxsecure.mobilpay.ro'),

     /*
      * Currency
      */
     'currency'=>env('NETOPIA_CURRENCY','RON'),

     /*
      * PRIVATE KEY
      * path where the key is found
      */

     'private_key'=>env('NETOPIA_PRIVATE_KEY',''),

     /*
      * PUBLIC CERTIFICATE
      * path where public certificate is found
      */
     'public_certificate'=>env('NETOPIA_PUBLIC_CERTIFICATE',''),

     /*
      * Invoice description title
      */
     'invoice_description'=>env('NETOPIA_INVOICE_DESCRIPTION','Plata servicii')
 ];
