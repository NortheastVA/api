<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => false,
    'allowedOrigins' => ['*.northeastva.devel','*.northeastva.org'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['Content-Type','X-Requested-With','X-Forwarded-For'],
    'allowedMethods' => ['GET','POST','PUT','DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
];
