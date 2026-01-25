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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        // 'client_id' => "620487054042-mvv1s43g4dteo5fdqibvkduoh6iq3i4i.apps.googleusercontent.com",
        // 'client_secret' => "AIzaSyB6CUNAkJeLSU_THL5_3EkBmzHoyxaAZzw",
        'client_id' => "707683933545-930jv89ikt9hedgefqps20vdhnkthbcd.apps.googleusercontent.com",
        'client_secret' => "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",
        'redirect' => "https://bsbqa.com/google/callback",
        // 'redirect' => "http://127.0.0.1:8000/google/callback",
    ],

    'facebook' => [
        // 'client_id' => "1340933267224212",
        // 'client_secret' => "3f4192e32517a9e99cee661dd8c426bc",
        'client_id' => "1291713635463079",
        'client_secret' => "976fa6a13b5928242b54badd4e02cb30",
        'redirect' => "https://bsbqa.com/facebook/callback",
        // 'redirect' => "http://localhost:8000/facebook/callback",
    ],

];
