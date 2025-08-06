<?php

declare(strict_types=1);

return [
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI'),
    ],
    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('INSTAGRAM_REDIRECT_URI'),
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
    ],
    'netfun' => [
        'token' => env('NETFUN_TOKEN'),
    ],
    'newsapi' => [
        'app_key' => env('NEWSAPI_APP_KEY'),
    ],
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE'),
        'bot_url' => env('TELEGRAM_BOT_URL'),
        'webhook' => env('TELEGRAM_BOT_WEBHOOK'),
    ],
    'cloudfront' => [
        'region' => env('CLOUDFRONT_REGION', 'eu-west-1'),
        'base_url' => env('CLOUDFRONT_RESOURCE_KEY_BASE_URL'),
        'private_key' => env('CLOUDFRONT_PRIVATE_KEY'),
        'key_pair_id' => env('CLOUDFRONT_KEYPAIR_ID'),
    ],
];
