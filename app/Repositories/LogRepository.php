<?php

namespace App\Repositories;




use App\Events\LoggerInterface;
use App\Models\Log;

class LogRepository implements LogRepositoryInterface
{
    public function addLog($eventName, $content, $serializeData, $logLevel)
    {
        return Log::create([
            'event_name' => $eventName,
            'content' => $content,
            'serialize_data' => $serializeData,
            'log_level' => $logLevel
        ]);
    }

    public function addLogByLoggerEvent(LoggerInterface $event)
    {
        return $this->addLog(get_class($event), $event->log(), serialize($event), $event->logLevel());
    }
}
