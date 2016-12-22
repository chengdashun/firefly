<?php

namespace App;

use Fly\Core\Config;
use Fly\Server\TcpServer;
use Fly\Pool\PoolManager;
use Fly\Redis\Pool as RedisPool;
use Fly\MySql\Pool as MySqlPool;

class Application extends TcpServer
{
    public static $instance = null;

    protected $poolManager = null;

    public function onErrorHandler($msg, $log)
    {
        print_r($msg);
        echo "\n";
        print_r($log);
        echo "\n";
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
        self::$instance =& $this;

        $this->errorHandler = [$this,'onErrorHandler'];

        parent::__construct();
    }

    public function onWorkerStart(\Swoole\Server $server, $workerId)
    {
        parent::onWorkerStart($server, $workerId);

        if ( ! $server->taskworker) {
            $this->_initPool();
        }
    }

    private function _initPool()
    {
        $this->poolManager = new PoolManager();

        $mysqlConfig = Config::load('mysql', true);
        if ($mysqlConfig) {
            foreach ($mysqlConfig as $name => $config) {
                // 每一个worker进程最大连接数
                $config['max_count'] = ceil($config['max_count']/$this->config['worker_num']);

                $this->poolManager->register(new MySqlPool($name, $config));
            }
        }
        unset($mysqlConfig);

        $redisConfig = Config::load('redis', true);
        if ($redisConfig) {
            foreach ($redisConfig as $name => $config) {
                // 每一个worker进程最大连接数
                $config['max_count'] = ceil($config['max_count']/$this->config['worker_num']);

                $this->poolManager->register(new RedisPool($name, $config));
            }
        }
        unset($redisConfig);
    }

    public function getPool($type = 'mysql', $pool = 'default')
    {
        return $this->poolManager->getPool($type, $pool);
    }
}