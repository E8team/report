<?php

namespace App\Repositories;




use App\Events\LoggerInterface;
use App\Models\Log;

class LogRepository implements LogRepositoryInterface
{
    public function addLog($eventName, $content, $logLevel, $departmentId, $serializeData)
    {
        return Log::create([
            'event_name' => $eventName,
            'content' => $content,
            'serialize_data' => $serializeData,
            'log_level' => $logLevel,
            'department_id' => $departmentId
        ]);
    }

    public function addLogByLoggerEvent(LoggerInterface $event)
    {
        $log = $event->log();
        if(false !== $log)
            return $this->addLog(get_class($event), $event->log(), $event->logLevel(), $event->departmentId(), serialize($event));
        else
            return null;
    }

    public function getLogs($departmentId = null, $logLevel = Log::NEED_SHOW_LOG,$limit = 10)
    {
        $queryBuilder = Log::query();
        if(!is_null($departmentId))
            $queryBuilder->where('department_id', $departmentId);
        if(!is_null($logLevel))
            $queryBuilder->where('log_level', $logLevel);
        return $queryBuilder->recent()->orderBy('id', 'desc')->limit($limit)->get();
    }
}
