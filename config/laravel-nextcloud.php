<?php

return [
    'endpoint' => env('NEXTCLOUD_API_ENDPOINT'),
    'username' => env('NEXTCLOUD_API_USERNAME'),
    'password' => env('NEXTCLOUD_API_PASSWORD'),
    'logging' => env('NEXTCLOUD_API_LOGGING', false),
    'logging-channel' => env('NEXTCLOUD_API_LOGGING_CHANNEL', 'nextcloud'),
];