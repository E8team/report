<?php

namespace App\Events;

interface LoggerInterface
{
    const NORMAL_LOG = 1;
    const NEEW_SHOW_LOG = 2;
    public function logLevel();
    public function log();
}
