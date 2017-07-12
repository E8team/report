<?php

namespace App\Repositories;


use App\Events\LoggerInterface;

interface LogRepositoryInterface
{
    public function addLog($eventName, $content, $serializeData, $logLevel);
    public function addLogByLoggerEvent(LoggerInterface $event);
}
