<?php

 return[

     /*
      * SIGNATURE
      * Netopia signature for you commercial account
      */

     'signature'=>env('NETOPIA_SIGNATURE',''),
     'url' => env('NETOPIA_URL', 'http://sandboxsecure.mobilpay.ro'),
     'currency'=>env('NETOPIA_CURRENCY','RON')
 ];
