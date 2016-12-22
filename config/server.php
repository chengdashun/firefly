<?php

return [
    // 服务名
    'server_name' => 'firefly',

    // 是否启用http
    'enable_http_server' => false,
    'http_server_ip' => '127.0.0.1',
    'http_server_port' => 9501,

    // 是否启用tcp
    'enable_tcp_server' => true,
    'tcp_server_ip' => '127.0.0.1',
    'tcp_server_port' => 9502,

    // 当文件有改动，自动重启
    'auto_reload' => false,

    // 服务配置
    'server_config' => [
        'dispatch_mode' => 3,
        'daemonize' => 0,
        'reactor_num' => 1,
        'worker_num' => 2,
        'task_worker_num' => 0,
    ],

    // 是否启用查询缓存
    'query_cache_enable' => true,
    'query_cache_time' => 3600,
];
