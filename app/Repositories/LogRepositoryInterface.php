<?php

namespace App\Repositories;


use App\Events\LoggerInterface;
use App\Models\Log;

interface LogRepositoryInterface
{
    public function addLog($eventName, $content, $logLevel, $departmentId, $serializeData);
    public function addLogByLoggerEvent(LoggerInterface $event);
    public function getLogs($departmentId = null, $logLevel = Log::NEED_SHOW_LOG,$limit = 10);
}
