<?php

namespace App\Repositories;




use App\Models\Log;

class LogRepository implements LogRepositoryInterface
{
    public function addLog($eventName, $content)
    {
        return Log::create([
            'event_name' => $eventName,
            'content' => $content
        ]);
    }
}
