<?php

namespace App\Repositories;


interface LogRepositoryInterface
{
    public function addLog($eventName, $content);
}
