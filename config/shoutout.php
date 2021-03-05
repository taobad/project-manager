<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | API KEY given by Shoutout
    |
     */
    'api_key' => env('SHOUTOUT_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | SMS Source
    |--------------------------------------------------------------------------
    |
    | SMS Source given by Shoutout
    |
     */
    'sms_source' => env('SHOUTOUT_SMS_SOURCE', 'ShoutDEMO'),

    /*
    |--------------------------------------------------------------------------
    | Email Source
    |--------------------------------------------------------------------------
    |
    | Email Source given by Shoutout
    |
     */
    'email_source' => env('SHOUTOUT_EMAIL_SOURCE', 'ShoutDEMO <shoutdemo@getshoutout.com>'),

    /*
    |--------------------------------------------------------------------------
    | Log Enable
    |--------------------------------------------------------------------------
    |
    | Log enable must be true or false. true is recommended for safety reasons
    |
     */
    'log_enable' => false,

    /*
    |--------------------------------------------------------------------------
    | Log Path
    |--------------------------------------------------------------------------
    |
    | If 'log_enable' is true then log files generated in this path
    |
     */
    'log_path' => storage_path('logs/shoutout'),

    /*
    |--------------------------------------------------------------------------
    | Log File Name
    |--------------------------------------------------------------------------
    |
    | If 'log_file_name' is null then write logs as daily log files else write logs on given log file (ex: shoutout.log)
    |
     */
    'log_file_name' => null,
];
