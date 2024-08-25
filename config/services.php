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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'apn' => [
        'key_id' => 'RS9Q55GH9X', 
        'team_id' => '4DTG6D2N48', // Aquí coloca el ID de tu equipo
        'app_bundle_id' => 'com.example.beauteApp', // Aquí coloca tu Bundle ID
        'private_key' => base_path('AuthKey_RS9Q55GH9X.p8'), // Ruta completa al archivo .p8 que descargaste
        'production' => true, // Cambia a true cuando estés listo para producción
    ],


];
