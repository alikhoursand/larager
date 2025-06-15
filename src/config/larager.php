<?php

return [
    'middleware' => ['web'],
    'log_file' => storage_path('logs/larager.log'),


    'channels' => [

        'null' => [
            'driver' => 'monolog',
            'handler' => Monolog\Handler\NullHandler::class,
        ],
    ],

    'default' => env('LOG_CHANNEL', 'null'),

];
