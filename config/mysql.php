<?php

return [
    'master' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'berton',
        'password' => '123456',
        'database' => 'userinfo',
        'charset'  => 'utf8mb4',

        // 最大连接数，每个worker最大连接数为 async_max_count/worker_num
        'max_count' => 10
    ],
    'slave' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'berton',
        'password' => '123456',
        'database' => 'userinfo',
        'charset'  => 'utf8mb4',
        'max_count' => 10
    ]
];
