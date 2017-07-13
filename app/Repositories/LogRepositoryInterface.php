<?php

namespace App\Repositories;


use App\Events\LoggerInterface;
use App\Models\Log;

interface LogRepositoryInterface
{
    public function addLog($eventName, $content, $serializeData, $logLevel);
    public function addLogByLoggerEvent(LoggerInterface $event);
    public function getLogs($logLevel = Log::NEED_SHOW_LOG,$limit = 10);
}
