<?php

return [
    'user' => [
        'model' => '\Modules\Users\Entities\User',
    ],
    'broadcast' => [
        'enable' => true,
        'app_name' => 'workice',
        'pusher' => [
            'app_id' => config('broadcasting.connections.pusher.app_id'),
            'app_key' => config('broadcasting.connections.pusher.key'),
            'app_secret' => config('broadcasting.connections.pusher.secret'),
            'options' => [
                'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                'encrypted' => true,
            ],
        ],
    ],
];
