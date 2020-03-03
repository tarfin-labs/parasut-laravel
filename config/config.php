<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Client ID
    |--------------------------------------------------------------------------
    |
    | Client ID for your parasut.com account.
    |
    */

    'client_id' => env('PARASUT_CLIENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Client Secret
    |--------------------------------------------------------------------------
    |
    | Client secret for your parasut.com account.
    |
    */

    'client_secret' => env('PARASUT_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | Username for your parasut.com account.
    |
    */

    'username' => env('PARASUT_USERNAME'),

    /*
    |--------------------------------------------------------------------------
    | Password
    |--------------------------------------------------------------------------
    |
    | Password for your parasut.com account.
    |
    */

    'password' => env('PARASUT_PASSWORD'),

    /*
    |--------------------------------------------------------------------------
    | Company ID
    |--------------------------------------------------------------------------
    |
    | Company ID for your parasut.com account
    |
    */

    'company_id' => env('PARASUT_COMPANY_ID'),

    /*
    |--------------------------------------------------------------------------
    | Grant Type
    |--------------------------------------------------------------------------
    |
    | Grant type for API authentication.
    |
    | Available types: "password", "authorization_code"
    |
    | Default: "password:
    |
    */

    'grant_type' => env('PARASUT_GRANT_TYPE', 'password'),

    /*
    |--------------------------------------------------------------------------
    | Redirect URL
    |--------------------------------------------------------------------------
    |
    | Redirect URL for your parasut.com account.
    |
    | Default: "urn:ietf:wg:oauth:2.0:oob"
    |
    */

    'redirect_url' => env('PARASUT_REDIRECT_URL', 'urn:ietf:wg:oauth:2.0:oob'),

    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    | API URL for parasut.com.
    |
    | Default: "https://api.parasut.com"
    |
    */

    'api_url' => env('PARASUT_API_URL', 'https://api.parasut.com'),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | API Version for parasut.com.
    |
    | Default: "v4"
    |
    */

    'api_version' => env('PARASUT_API_VERSION', 'v4'),
];