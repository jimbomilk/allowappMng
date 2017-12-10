<?php

return [
    'credentials' => [
        'key'    => env('AWS_KEY'),
        'secret' => env('AWS_SECRET'),
    ],
    'region' => 'eu-west-1',
    'version' => 'latest'
];