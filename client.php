<?php

use Fly\Utility\MessagePack as Pack;

include __DIR__. '/vendor/autoload.php';

$max = 0;

$stime = microtime(true);
for ($i = 0; $i < 1000; $i++) {
    $time = microtime(true);

    $client = new \Swoole\Client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);
    $client->set(array(
        'open_eof_check' => 1,
        'open_eof_split' => 1,
        'package_eof' => "\r\n\r\n",

        'package_max_length' => 1024 * 1024 * 2,
        'open_tcp_nodelay' => 1,
    ));

    if ( ! $client->connect('127.0.0.1', 9502, 3.0)) {
        $errorCode = $client->errCode;
        if ($errorCode == 0) {
            $msg = "connect fail.check host dns.";
        } else {
            $msg = socket_strerror($errorCode);
        }

        throw new \Exception($msg, $errorCode);
    }

    $client->send(Pack::encode([
        'type' => 'api',
        'data' => [
            'controller' => 'test',
            'method' => 'test',
            'param' => [join(',', [rand(1, 10), rand(1, 10), rand(1, 10)])]
        ]
    ]));
    $res = $client->recv();
    $res = Pack::decode($res);

    print_r($res);

//    $client->send(Pack::encode([
//        'type' => 'task',
//        'data' => [
//            'task' => 'test',
//            'param' => [
//                'id' => '1,2,3'
//            ]
//        ]
//    ]));
//    $res = $client->recv();
//    $res = Pack::decode($res);
//
//    print_r($res);

    $time = bcsub(microtime(true), $time, 5);
    if ($time > $max) {
        $max = $time;
    }
    echo $i . " cost:" . $time . PHP_EOL;
}

echo "max:" . $max . PHP_EOL;

$time = bcsub(microtime(true), $stime, 5);

echo "total:" . $time . PHP_EOL;
