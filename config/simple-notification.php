<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel simple-notification
    |--------------------------------------------------------------------------
    |
    |
    */


    /*
     * get special values from header
     * example:
     */
    'get_special_values_from_header' => [
        'special' => 'value',
    ],


    /*
         * get global special values from request
         * example:
         */
    'get_global_special_values_from_request' => [
        'job_name' => 'job_name',
    ],


    /*
     * get special values from request
     * example:
     */
    'get_special_values_from_request' => [
        'ip' => 'ip',
    ],


    /*
     * view/template alert email
     * example:
     */
    'view-simple-email' => "SimpleNotification.simple-notification",

    /*
     * cache tag name
     * example:
     */
    'cache-tag-name' => "CACHE_GROUP_NOTIFICATION",


    /*
     * cache tag time
     * example:
     */
    'cache-tag-time' => 3600,

    /*
     * cache name
     * example:
     */
    'cache-name' => "default_name_cache",

    /*
     * mail recipient notification error
     * example:
     */
    'mail-recipient' => "yourmail@gmail.com",

    /*
     * default channel slack
     * example:
     */
    'default-channel-slack' => "",
];

