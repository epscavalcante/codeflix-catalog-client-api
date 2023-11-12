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

    'elasticsearch' => [
        'hosts' => explode(',', env('ELASTICSEARCH_HOSTS', 'elasticsearch:9200')),
        'username' => env('ELASTICSEARCH_USERNAME', 'elasticsearch'),
        'password' => env('ELASTICSEARCH_PASSWORD', 'defaultpassword'),
        'default_index' => env('ELASTICSEARCH_DEFAULT_INDEX', 'app')
    ],

    'logstash' => [
        'driver' => 'custom',
        'via' => LogstashLogger::class,
        'host' => env('LOGSTASH_HOST', 'logstash'),
        'port' => env('LOGSTASH_PORT', 4718)
    ],
];
