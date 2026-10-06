<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'paysky' => [
        'mid' => env('PAYSKY_MID', '10000000001'),
        'tid' => env('PAYSKY_TID', '10000001'),
        'secret_key' => env('PAYSKY_SECRET_KEY', '31323334353637383930313233343536'),
        'mode' => env('PAYSKY_MODE', 'test'), // 'test' or 'live'
        'test_script_url' => env('PAYSKY_TEST_SCRIPT_URL', 'https://cube.paysky.io:6006/js/LightBox.js'),
        'live_script_url' => env('PAYSKY_LIVE_SCRIPT_URL', 'https://cube.paysky.io:6006/js/LightBox.js'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
        'mode' => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' or 'live'
        'currency' => env('PAYPAL_CURRENCY', 'USD'),
        'webhook_id' => env('PAYPAL_WEBHOOK_ID', ''),
        'egp_to_usd_rate' => (float) env('PAYPAL_EGP_TO_USD_RATE', 0.021), // ~48 EGP = 1 USD
    ],

];
