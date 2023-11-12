<?php

namespace App\Services;

use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\SocketHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class LogstashLogger
{
    public function __invoke(): LoggerInterface
    {
        $appName = config('app.name');
        $host = config('services.logstash.host');
        $port = config('services.logstash.port');
        $enviroment = config('app.env');

        $handler = new SocketHandler("udp://{$host}:{$port}");
        $handler->setFormatter(new LogstashFormatter($appName));

        return new Logger("logstash.{$enviroment}", [$handler]);
    }
}
