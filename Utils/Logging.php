<?php

namespace Hutech\Utils;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class Logging extends Logger
{
    public function __construct()
    {
        parent::__construct('Hutech_Log');
        $date = date('Y-m-d H:i:s');
        $output = "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n";
        $stream = new StreamHandler('Logs/' . date('Y-m-d') . '.log', Level::Debug);
        $stream->setFormatter(new LineFormatter($output, $date));
        $this->pushHandler($stream);
        $this->pushHandler(new FirePHPHandler());
    }
}