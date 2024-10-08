<?php

return [
    'env' => env('NOMUVEL_ENV', 'dev'),
    'test_url' => env('NOMUVEL_TEST_URL','https://api-dev.nomupay.com.tr'),
    'production_url' => env('NOMUVEL_PRODUCTION_URL','https://api.nomupay.com.tr'),
    'pos_test_url' => env('NOMUVEL_POS_TEST_URL','https://test.nomupay.com.tr/SGate/Gate'),
    'pos_production_url' => env('NOMUVEL_POS_PRODUCTION_URL','https://api.nomuvel.com.tr/pos'),
    'user_code' =>  env('NOMUVEL_USER_CODE','20676'),
    'pin' => env('NOMUVEL_PIN','7D0E9E66A2624A9D9103'),
    'channel' => env('NOMUVEL_CHANNEL','KISMETIM'),
    'sub_channel' => env('NOMUVEL_SUB_CHANNEL','KISMETIM'),
];
