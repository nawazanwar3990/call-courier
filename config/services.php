<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'firebase' => [
        'url' => 'https://fcm.googleapis.com/fcm/send',
        'serverKey' => 'AAAAL6XIPUU:APA91bFh6xtJ4ZUMcpYbM0Fn4Ayol2strLYluQllbh4SdcyaCdnC2qv6xOab2-twLTleUFOGp21fvbMCPUimVbbl7DEMfFfXBTsh77pnQKqzMahrOFd9rVX3rcyN12UZOyIR7JTlGEBp',
    ],
];
