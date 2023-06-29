<?php

 return[

     /*
      * SIGNATURE
      * Netopia signature for you commercial account
      */

     'signature'=>env('NETOPIA_SIGNATURE',''),
     'url' => env('NETOPIA_URL', 'http://sandboxsecure.mobilpay.ro'),
     'currency'=>env('NETOPIA_CURRENCY','RON'),
     'private_key'=>env('NETOPIA_PRIVATE_KEY',''),
     'public_certificate'=>env('NETOPIA_PUBLIC_CERTIFICATE',''),
     'invoice_description'=>env('NETOPIA_INVOICE_DESCRIPTION','Plata servicii')
 ];
