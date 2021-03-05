<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
     */
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'nexmo' => [
        'key' => env('NEXMO_KEY'),
        'secret' => env('NEXMO_SECRET'),
        'sms_from' => env('NEXMO_FROM', '15556666666'),
    ],
    'twilio' => [
        'username' => env('TWILIO_USERNAME'), // optional when using auth token
        'password' => env('TWILIO_PASSWORD'), // optional when using auth token
        'auth_token' => env('TWILIO_AUTH_TOKEN'), // optional when using username and password
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'from' => env('TWILIO_FROM'), // optional
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => '/callback/twitter',
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => '/callback/github',
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => '/callback/facebook',
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => '/callback/google',
    ],
    'gitlab' => [
        'client_id' => env('GITLAB_CLIENT_ID'),
        'client_secret' => env('GITLAB_CLIENT_SECRET'),
        'redirect' => '/callback/gitlab',
    ],
    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => '/callback/linkedin',
    ],
    'stripe' => [
        'model' => config('cashier.model'),
        'key' => config('cashier.key'),
        'secret' => config('cashier.secret'),
        'webhook' => [
            'secret' => config('cashier.webhook.secret'),
            'tolerance' => config('cashier.webhook.tolerance'),
        ],
    ],
    'razorpay' => [
        'keyId' => env('RAZORPAY_KEY', 'test'),
        'secretKey' => env('RAZORPAY_SECRET', 'secret'),
    ],
    '2checkout' => [
        'merchantCode' => env('2CHECKOUT_MERCHANT_CODE'),
        'secretKey' => env('2CHECKOUT_SECRET_KEY'),
        'publishableKey' => env('2CHECKOUT_PUBLISHABLE_KEY'),
        'privateKey' => env('2CHECKOUT_PRIVATE_KEY'),
    ],
    'braintree' => [
        'merchantId' => env('BRAINTREE_MERCHANT_ID', ''),
        'publicKey' => env('BRAINTREE_PUBLIC_KEY', ''),
        'privateKey' => env('BRAINTREE_PRIVATE_KEY', ''),
    ],
    'wepay' => [
        'accountId' => env('WEPAY_ACCOUNT_ID', ''),
        'clientId' => env('WEPAY_CLIENT_ID', ''),
        'secretId' => env('WEPAY_SECRET_ID', ''),
        'accessToken' => env('WEPAY_ACCESS_TOKEN', ''),
    ],
    'paytm-wallet' => [
        'env' => env('PAYTM_ENV', 'live'), // values : (local | production)
        'merchant_id' => env('PAYTM_MERCHANT_ID', ''),
        'merchant_key' => env('PAYTM_MERCHANT_KEY', ''),
        'merchant_website' => env('PAYTM_WEBSITE', ''),
        'channel' => env('PAYTM_CHANNEL', ''),
        'industry_type' => env('PAYTM_INDUSTRY_TYPE', ''),
    ],
    'square' => [
        'sandbox' => env('SQUARE_SANDBOX', false),
        'app_id' => env('SQUARE_APP_ID', ''),
        'access_token' => env('SQUARE_ACCESS_TOKEN', ''),
        'location_id' => env('SQUARE_LOCATION_ID', ''),
    ],
    'onesignal' => [
        'app_id' => env('ONESIGNAL_APP_ID'),
        'rest_api_key' => env('ONESIGNAL_REST_API_KEY'),
    ],
    'messagebird' => [
        'access_key' => env('MESSAGEBIRD_ACCESS_KEY'),
        'originator' => env('MESSAGEBIRD_ORIGINATOR'),
        'recipients' => env('MESSAGEBIRD_RECIPIENTS'),
    ],
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', ''),
    ],

];
