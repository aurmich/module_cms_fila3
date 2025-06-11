<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Passport Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Passport settings. The default values are
    | set for most applications, but you can adjust them as needed.
    |
    */

    'private_key' => storage_path('oauth-private.key'),
    'public_key' => storage_path('oauth-public.key'),

    'token_lifetime' => env('PASSPORT_TOKEN_LIFETIME', 60),

    'refresh_token_lifetime' => env('PASSPORT_REFRESH_TOKEN_LIFETIME', 20160),

    'personal_access_client' => [
        'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],

    'password_client' => [
        'id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
        'secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
    ],

    'first_party_clients' => [
        [
            'id' => env('PASSPORT_FIRST_PARTY_CLIENT_ID'),
            'secret' => env('PASSPORT_FIRST_PARTY_CLIENT_SECRET'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Passport Guard
    |--------------------------------------------------------------------------
    |
    | Here you may specify which authentication guard Passport will use when
    | authenticating users. This value should correspond with one of your
    | guards that is already present in your "auth" configuration file.
    |
    */

    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Passport Database Connection
    |--------------------------------------------------------------------------
    |
    | By default, Passport's models will utilize your application's default
    | database connection. If you wish to use a different connection you
    | may specify the configured name of the database connection here.
    |
    */

    'connection' => env('PASSPORT_CONNECTION','user'),

    /*
    |--------------------------------------------------------------------------
    | Client UUIDs
    |--------------------------------------------------------------------------
    |
    | By default, Passport uses auto-incrementing primary keys when assigning
    | IDs to clients. However, if Passport is installed using the provided
    | --uuids switch, this will be set to "true" and UUIDs will be used.
    |
    */

    'client_uuids' => false,

];
